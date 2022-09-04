<?php declare(strict_types=1);

namespace App\Controller;

use App\Exception\ContractException;
use App\Http\JsonResponse;
use App\Model\ContractAccount;
use App\Service\ContractService;
use DateTime;
use App\Model\Contract;
use App\Table\ContractAccountTable;
use App\Table\ContractTable;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;

class ContractController extends AbstractController
{

    public function __construct(
        private readonly ContractService $contractService,
        Query $database)
    {
        parent::__construct($database);
    }

    public function load(RequestInterface $request): Response
    {

        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $userId;
        }

        return new JsonResponse(200,
            $this->contractService->findAllContractsAndShowAvailabilityByLevelAndUserId($this->getUserAccountData()['level'], $userId));
    }

    public function show(RequestInterface $request, array $args): Response
    {
        $accountId = $this->isAuthenticatedAndValid();
        if ($accountId instanceof Response) {
            return $accountId;
        }

        if(!isset($args['id']))
        {
            return new JsonResponse(400);
        }

        $data = $this->contractService->getContractDataForAccountByContractIdAndLevel((int)$args['id'], $this->getUserAccountData()['level'], $accountId);
        if($data !== FALSE)
        {
            unset($data['availableFrom']);
            return new JsonResponse(200, $data);
        }

        return new JsonResponse(404);
    }

    public function claim(RequestInterface $request, array $args): Response
    {
        $accountId = $this->isAuthenticatedAndValid();
        if ($accountId instanceof Response) {
            return $accountId;
        }

        if(!isset($args['id']))
        {
            return new JsonResponse(400);
        }

        try {
            $this->contractService->claim((int)$args['id'], $accountId, (int)$this->getUserAccountData()['level']);
            return new JsonResponse(200);
        } catch (ContractException $exception)
        {
            return new JsonResponse(code: $exception->getCode(), message: $exception->getMessage());
        }

    }

}
