<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Finances\BankAccount;
use App\Model\Finances\Transaction;
use App\Table\BankAccountTable;
use App\Table\TransactionTable;

class TransactionService
{

    public function __construct(
        private readonly TransactionTable $transactionTable,
        private readonly BankAccountTable $bankAccountTable)
    {
    }

    public function transferMoney(
        Transaction $transaction,
        BankAccount $sender,
        BankAccount $receiver
    ): bool
    {
        if($transaction->getAmount() < 0)
        {
            $transaction->setAmount(abs($transaction->getAmount()));
        }

        $newAmountSender = $this->calculateNewMoney($sender, -$transaction->getAmount());
        if($newAmountSender === FALSE)
        {
            return false;
        }

        $receiver->setAmount($this->calculateNewMoney($receiver, +$transaction->getAmount()));

        if (
            ($this->bankAccountTable->updateAccountMoneyById($transaction->getFromAccount(), $newAmountSender)) &&
            ($this->bankAccountTable->updateAccountMoneyById($transaction->getToAccount(), $receiver->getAmount()))
        ) {
            if ($this->transactionTable->insert($transaction) !== false) {
                return true;
            }
        }

        return false;
    }

    private function calculateNewMoney(BankAccount $bankAccount, int $change): int|bool
    {
        $new = $bankAccount->getAmount() + $change;
        if ((!$bankAccount->isDebtAllowed()) && $new < 0) {
            return false;
        }

        return $new;
    }

}
