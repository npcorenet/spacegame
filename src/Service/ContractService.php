<?php

namespace App\Service;

use App\Exception\ContractException;
use App\Model\Contract;
use App\Model\ContractAccount;
use App\Table\ContractAccountTable;
use App\Table\ContractTable;
use DateTime;
use DateTimeZone;

class ContractService
{

    private array $claimedContractCache = [];

    public function __construct(
        private readonly ContractTable $contractTable,
        private readonly ContractAccountTable $contractAccountTable
    )
    {
    }

    /**
     * @throws ContractException
     */
    public function claim(int $contractId, int $accountId, int $level): ContractException|bool
    {
        $contract = $this->getContractById($contractId);
        if($contract === FALSE)
            throw new ContractException('contract-not-found', 404);

        if($this->isContractAvailableToUser($contract, $level, $accountId) === FALSE)
            throw new ContractException('not-acceptable', 406);

        $contractAccount = new ContractAccount();
        $contractAccount->setContract($contractId);
        $contractAccount->setUser($accountId);
        $contractAccount->setStarted(new DateTime(timezone: TIMEZONE));
        $contractAccount->setExpires((new DateTime(timezone: TIMEZONE))->modify('+'.$contract->getMaxDuration().' hours'));

        if($this->contractAccountTable->insert($contractAccount) !== FALSE)
        {
            return true;
        }

        throw new ContractException(code:500);
    }

    public function findAllContractsAndShowAvailabilityByLevelAndUserId(int $level, int $accountId): array
    {
        $availableContracts = [];

        $allContracts = $this->contractTable->findAll();
        if($_ENV['GAME_EXTERNAL_CONTRACT_MINIMUM_LEVEL'] > $level)
        {
            $allContracts = $this->contractTable->findAllDefault();
        }

        $contractEntity = new Contract();
        foreach ($allContracts as $contract)
        {
            $contractEntity->fillFromArray($contract);

            $availableContracts[$contract['id']] = $contractEntity->generateArrayFromSetVariables();
            $availableContracts[$contract['id']]['available'] = $this->isContractAvailableToUser($contractEntity, $level, $accountId);

            $contractEntity->clear();
        }

        return $availableContracts;
    }

    public function getContractDataForAccountByContractIdAndLevel(int $id, int $level, int $accountId): array|false
    {
        $contract = $this->getContractById($id);
        if($contract === FALSE)
        {
            return false;
        }

        $data = $contract->generateArrayFromSetVariables();
        $data['available'] = $this->isContractAvailableToUser($contract, $level, $accountId);

        return $data;
    }

    private function getContractById(int $id): Contract|FALSE
    {
        $data = $this->contractTable->findById($id);
        if($data === FALSE)
            return false;

        $contract = new Contract();
        $contract->fillFromArray($data);

        return $contract;
    }

    private function listClaimedContractsByAccountId(int $accountId): array
    {
        if(empty($this->claimedContractCache))
        {
            foreach ($this->contractAccountTable->findAllByUserId($accountId) as $item) {
                $this->claimedContractCache[] = $item['contract'];
            }
        }

        return $this->claimedContractCache;
    }

    private function isContractAvailableToUser(Contract $contract, int $level, int $accountId): bool
    {

        if (
            ($contract->getAvailableFrom() > new DateTime(timezone: TIMEZONE)) ||
            ($contract->getMinimumLevel() > $level) ||
            ($contract->getByUser() !== NULL && $level < $_ENV['GAME_EXTERNAL_CONTRACT_MINIMUM_LEVEL']) ||
            (in_array($contract->getId(), $this->listClaimedContractsByAccountId($accountId)))
        )
        {
            return false;
        }

        return true;
    }

}