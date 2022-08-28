<?php

namespace App\Service;

use App\Model\Contract;
use DateTime;
use DateTimeZone;
use Exception;

class ContractService
{

    /**
     * @throws Exception
     */
    public function checkContractAvailability(
        Contract $contract,
        DateTimeZone $timeZone,
        int $level
    ): bool
    {
        if(($contract->getAvailableFrom() >= new DateTime(timezone: $timeZone)) ||
            ($contract->getByUser() !== NULL && $level < $_ENV['GAME_EXTERNAL_CONTRACT_MINIMUM_LEVEL']))
        {
            return false;
        }

        return true;
    }



}