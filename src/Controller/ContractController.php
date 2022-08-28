<?php declare(strict_types=1);

namespace App\Controller;

use App\Model\ContractAccount;
use App\Service\ContractService;
use DateTime;
use App\Model\Contract;
use App\Table\ContractAccountTable;
use App\Table\ContractTable;
use Exception;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;

class ContractController extends AbstractController
{

    public function load(RequestInterface $request): Response
    {

        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $this->response();
        }

        $contractTable = new ContractTable($this->database);
        $contractAccountTable = new ContractAccountTable($this->database);
        $contracts = $contractTable->findAll();
        if($_ENV['GAME_EXTERNAL_CONTRACT_MINIMUM_LEVEL'] > $this->getUserAccountData()['level'])
        {
            $contracts = $contractTable->findAllDefault();
        }
        $accountContracts = $contractAccountTable->findAllByUserId($userId);
        $contractsClaimed = [];
        foreach ($accountContracts as $contract)
        {
            $contractsClaimed[$contract['contract']] = $contract['contract'];
        }

        $data = [];
        foreach ($contracts as $contract)
        {
            $contract['available'] = false;
            if(
                ($contract['minimumLevel'] <= $this->getUserAccountData()['level']) &&
                !(in_array($contract['id'], $contractsClaimed)))
            {
                $contract['available'] = true;
            }

            $data[] = $contract;
        }

        $this->data = $this->responseHelper->createResponse(code: 200, data: $data);

        return $this->response();
    }

    /**
     * @throws Exception
     */
    public function show(RequestInterface $request, array $args): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $this->response();
        }

        if(!isset($args['id']))
        {
            $this->data = $this->responseHelper->createResponse(400);
            return $this->response();
        }

        $contractId = (int)$args['id'];
        $contractService = new ContractService();
        $contractTable = new ContractTable($this->database);
        $contractData = $contractTable->findById($contractId);

        if($contractData === FALSE)
        {
            $this->data = $this->responseHelper->createResponse(404);
            return $this->response();
        }

        $contract = new Contract();
        $contract->setId($contractData['id']);
        $contract->setName($contractData['name']);
        $contract->setDescription($contractData['description']);
        $contract->setAvailableFrom(new DateTime($contractData['availableFrom'], $this->timeZone));
        $contract->setAvailableUntil($contractData['availableUntil'] !== NULL ? new DateTime($contractData['availableUntil'], $this->timeZone) : null);
        $contract->setMaxDuration($contractData['maxDuration']);
        $contract->setMinimumLevel($contractData['minimumLevel']);
        $contract->setPrePayment($contractData['prePayment']);
        $contract->setReward((int)$contractData['reward']);
        $contract->setByUser($contractData['byUser']);
        $contract->setUserLimit($contractData['userLimit']);

        if($contract->getAvailableFrom() > new DateTime())
        {
            $this->data = $this->responseHelper->createResponse(404);
            return $this->response();
        }

        $contractAccountTable = new ContractAccountTable($this->database);
        $contractAccountData = $contractAccountTable->findByContractAndUserId($contractData['id'], $userId);

        $data = $contract->generateArrayFromSetVariables();
        $data['users'] = $contract->getUserLimit() > 0 ? count($contractAccountTable->findAllByContractId($contract->getId())) : 0;

        $data['claimable'] = false;
        if(($contractAccountData !== FALSE) && $data['users'] < $contract->getUserLimit())
        {
            $data['claimable'] = true;
        }
        unset($data['availableFrom']);

        $this->data = $this->responseHelper->createResponse(code: 200, data: $data);
        return $this->response();
    }

    public function claim(RequestInterface $request, array $args): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $this->response();
        }

        if(!isset($args['id']))
        {
            $this->data = $this->responseHelper->createResponse(400);
            return $this->response();
        }
        $contractId = (int)$args['id'];

        $contractTable = new ContractTable($this->database);
        $contractData = $contractTable->findById($contractId);

        $contract = (new Contract())->fillFromArray($contractData);

        $contractService = new ContractService();
        if(
            ($contractData === FALSE) ||
            (!$contractService->checkContractAvailability($contract, $this->timeZone, $this->getUserAccountData()['level']))
        )
        {
            $this->data[] = $this->responseHelper->createResponse(404);
            $this->response();
        }

        $contractAccount = new ContractAccount();
        $contractAccount->setUser($userId);
        $contractAccount->setContract($contractId);
        $contractAccount->setExpires((new DateTime(timezone: $this->timeZone))->modify('+'.$contract->getMaxDuration().' hours'));

        $contractAccountTable = new ContractAccountTable($this->database);
        if($contractAccountTable->findByContractAndUserId($contractAccount->getContract(), $contractAccount->getUser()))
        {
            $this->data = $this->responseHelper->createResponse(410);
            return $this->response();
        }

        $contractAccountTable->insert($contractAccount);

        $this->data = $this->responseHelper->createResponse(code:200);
        return $this->response();
    }

}
