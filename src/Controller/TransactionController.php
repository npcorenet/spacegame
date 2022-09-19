<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\JsonResponse;
use App\Model\Finances\BankAccount;
use App\Model\Finances\Transaction;
use App\Service\TransactionService;
use App\Table\BankAccountTable;
use App\Table\TransactionTable;
use DateTime;
use DateTimeZone;
use Exception;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;

class TransactionController extends AbstractController
{

    public function load(): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $userId;
        }

        return new JsonResponse(405);
    }

    /**
     * @throws Exception
     */
    public function transfer(): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $userId;
        }

        if (!isset($_POST['fromAccount'], $_POST['toAccount'], $_POST['contract'], $_POST['name'], $_POST['amount'])) {
            return new JsonResponse(400);
        }

        $bankAccountTable = new BankAccountTable($this->database);
        $senderAccount = $bankAccountTable->findByAddressAndUserId($_POST['fromAccount'], $userId);
        $senderMoney = $senderAccount['money'];
        $sender = new BankAccount();
        $sender->setId($senderAccount['id']);
        $sender->setName($senderAccount['name']);
        $sender->setUser($senderAccount['user']);
        $sender->setAddress($senderAccount['address']);
        $sender->setDebtAllowed($senderAccount['debtAllowed'] == 1);
        $sender->setAmount($senderAccount['money']);

        $destinationAccount = $bankAccountTable->findByAddress($_POST['toAccount']);
        $receiver = new BankAccount();
        $receiver->setId($destinationAccount['id']);
        $receiver->setName($destinationAccount['name']);
        $receiver->setUser($destinationAccount['user']);
        $receiver->setAddress($destinationAccount['address']);
        $receiver->setAmount($destinationAccount['money']);
        $receiver->setDebtAllowed($destinationAccount['debtAllowed'] == 1);

        $transaction = new Transaction();
        $transaction->setName($_POST['name']);
        $transaction->setAmount((int)$_POST['amount']);
        $transaction->setFromAccount($sender->getId());
        $transaction->setToAccount($receiver->getId());
        $transaction->setTime(new DateTime('', new DateTimeZone($_ENV['SOFTWARE_TIMEZONE'])));
        $transaction->setContract(0);

        if ($senderAccount === false || $destinationAccount === false) {
            return new JsonResponse(code: 400, message: 'sender-or-destination-missing');
        }

        $transactionTable = new TransactionTable($this->database);

        $transactionService = new TransactionService(
            $transactionTable,
            $bankAccountTable
        );

        $transactionResult = $transactionService->transferMoney(
            $transaction,
            $sender,
            $receiver
        );

        if ($transactionResult === true) {
            return new JsonResponse(200);
        }

        if ($transactionResult === false) {
            return new JsonResponse(500, [
                'newMoney' => $sender->getAmount(),
                'balance' => $senderMoney,
                'debtAllowed' => $sender->isDebtAllowed()
            ], 'transaction-not-finish-able');
        }

        return new JsonResponse(500);
    }

    public function list(RequestInterface $request, array $args = []): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $userId;
        }

        if (empty($args['token'])) {
            return new JsonResponse(400);
        }
        $token = $args['token'];

        $bankAccountTable = new BankAccountTable($this->database);
        $bankAccountData = $bankAccountTable->findByAddressAndUserId($token, $userId);

        if ($bankAccountData === false) {
            return new JsonResponse(404);
        }

        $transactionTable = new TransactionTable($this->database);
        $transactionData = $transactionTable->findAllByBankAccountId($bankAccountData['id']);

        if ($transactionData === false) {
            return new JsonResponse(404);
        }

        return new JsonResponse(200, $transactionData);
    }

}
