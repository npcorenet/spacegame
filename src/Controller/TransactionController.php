<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Finances\Transaction;
use App\Service\BankAccountService;
use App\Table\BankAccountTable;
use App\Table\TransactionTable;
use DateTime;
use DateTimeZone;
use Exception;
use Laminas\Diactoros\Response;

class TransactionController extends AbstractController
{

    public function load(): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId === false) {
            $this->data = ['code' => 403, 'message' => parent::ERROR403];
            return $this->response();
        }

        $this->data = ['code' => 401, 'message' => 'invalid-method'];
        return $this->response();
    }

    /**
     * @throws Exception
     */
    public function transfer(): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId === false) {
            $this->data = ['code' => 403, 'message' => parent::ERROR403];
            return $this->response();
        }

        if (!isset($_POST['fromAccount'], $_POST['toAccount'], $_POST['contract'], $_POST['name'], $_POST['amount'])) {
            $this->data = ['code' => 400, 'message' => parent::ERROR400_DATA_MISSING];
            return $this->response();
        }

        $bankAccountTable = new BankAccountTable($this->database);
        $senderAccount = $bankAccountTable->findByAddressAndUserId($_POST['fromAccount'], $userId);
        $destinationAccount = $bankAccountTable->findByAddress($_POST['toAccount']);

        $transaction = new Transaction();
        $transaction->setName($_POST['name']);
        $transaction->setAmount((int)$_POST['amount']);
        $transaction->setFromAccount((int)$senderAccount['id']);
        $transaction->setToAccount((int)$destinationAccount['id']);
        $transaction->setTime(new DateTime('', new DateTimeZone($_ENV['SOFTWARE_TIMEZONE'])));
        $transaction->setContract(0);

        if ($senderAccount === false || $destinationAccount === false) {
            $this->data = ['code' => 400, 'message' => 'invalid-sender-or-receiver-address'];
            return $this->response();
        }

        $deptAllowed = $senderAccount['debtAllowed'] == 1;

        $bankAccountService = new BankAccountService();
        $balanceFrom = $bankAccountService->calculateNewMoney(
            $senderAccount['money'],
            -$transaction->getAmount(),
            $deptAllowed
        );
        $balanceTo = $bankAccountService->calculateNewMoney($destinationAccount['money'], +$transaction->getAmount());

        if ($balanceFrom === false) {
            $this->data = ['code' => 400, 'message' => 'dept-not-allowed'];
            return $this->response();
        }

        if (
            ($bankAccountTable->updateAccountMoneyById($transaction->getFromAccount(), $balanceFrom)) &&
            ($bankAccountTable->updateAccountMoneyById($transaction->getToAccount(), $balanceTo))
        ) {
            $transactionTable = new TransactionTable($this->database);
            if ($transactionTable->insert($transaction) !== false) {
                $this->data = ['code' => 200, 'message' => self::CODE200];
                return $this->response();
            }
        }

        $this->data = ['code' => 500, 'message' => 'unknown-error'];
        return $this->response();
    }

}
