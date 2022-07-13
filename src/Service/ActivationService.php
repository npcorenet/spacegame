<?php declare(strict_types=1);

namespace App\Service;

use App\Helper\MessageHelper;
use App\Model\TokenModel;
use App\Model\TokenTypeModel;
use App\Table\AccountTable;
use App\Table\TokenTable;
use App\Validation\TokenValidation;

class ActivationService
{

    public function __construct(
        protected ActivateAccountService $activateAccountService,
        protected TokenModel $tokenModel,
        protected TokenTable $tokenTable,
        protected TokenValidation $tokenValidation,
        protected AccountTable $accountTable,
        protected MessageHelper $messageHelper
    )
    {
    }

    public function activate(): bool
    {

        $tokenData = $this->tokenTable->findByTokenAndType($this->tokenModel->getToken(), TokenTypeModel::ActivateAccount);
        if($tokenData === FALSE) {
            header("Location: login/");
            return false;
        }

        $this->tokenModel->setUser($tokenData['user']);
        $this->tokenModel->setId($tokenData['id']);
        $this->tokenModel->setType($tokenData['type']);
        $this->tokenModel->setValidUntil($this->activateAccountService->stringToDateTime($tokenData['validUntil']));

        if($this->validate() === FALSE)
            return false;

        if(
            ($this->accountTable->setActivated(1, $this->tokenModel->getUser())) &&
            ($this->tokenTable->setIsUsed(1, $this->tokenModel->getToken()))
        )
        {
            $this->messageHelper->addMessage('success', 'Das Konto wurde erfolgreich aktiviert');
            return true;
        }

        $this->messageHelper->addMessage('danger', 'Das Konto konnte nicht aktiviert werden');

        return false;
    }

    private function validate(): bool
    {
        return ($this->tokenValidation->validate($this->tokenModel, $this->messageHelper)) &&
            ($this->messageHelper->countMessageByType('danger') === 0);
    }

}
