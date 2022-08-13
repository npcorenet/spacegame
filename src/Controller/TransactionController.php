<?php

declare(strict_types=1);

namespace App\Controller;

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
            return $this->response();
        }

        $this->data = $this->responseHelper->createResponse(405);
        return $this->response();
    }

    /**
     * @throws Exception
     */
    public function transfer(): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $this->response();
        }

        if (!isset($_POST['fromAccount'], $_POST['toAccount'], $_POST['contract'], $_POST['name'], $_POST['amount'])) {
            $this->data = $this->responseHelper->createResponse(400);
            return $this->response();
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
            $this->data = $this->responseHelper->createResponse(400, 'sender-or-destination-missing');
            return $this->response();
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
            $this->data = $this->responseHelper->createResponse(200);
            return $this->response();
        }

        if ($transactionResult === false) {
            $this->data = [
                'code' => 500,
                'message' => 'transaction-not-finish-able',
                'data' => [
                    'newMoney' => $sender->getAmount(),
                    'balance' => $senderMoney,
                    'debtAllowed' => $sender->isDebtAllowed()
                ]
            ];
            return $this->response();
        }

        $this->data = $this->responseHelper->createResponse(500);
        return $this->response();
    }

    public function list(RequestInterface $request, array $args = []): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId === false) {
            $this->data = $this->responseHelper->createResponse(403);
            return $this->response();
        }

        if (empty($args['token'])) {
            $this->data = $this->responseHelper->createResponse(400);
            return $this->response();
        }

        $token = $args['token'];

        $bankAccountTable = new BankAccountTable($this->database);
        $bankAccountData = $bankAccountTable->findByAddressAndUserId($token, $userId);

        if ($bankAccountData === false) {
            $this->data = $this->responseHelper->createResponse(404, 'account-not-found');
            return $this->response();
        }

        $transactionTable = new TransactionTable($this->database);
        $transactionData = $transactionTable->findAllByBankAccountId($bankAccountData['id']);

        if ($transactionData === false) {
            $this->data = $this->responseHelper->createResponse(404, 'account-not-found');
            return $this->response();
        }

        $this->data = $this->responseHelper->createResponse(
            code: 200,
            data: $transactionData
        );

        return $this->response();
    }

}
