<?php declare(strict_types=1);

namespace App\Validation;

use App\Helper\MessageHelper;
use App\Model\TokenModel;
use App\Model\TokenTypeModel;
use App\Table\AccountTable;

class TokenValidation
{

    public function validate(
        TokenModel $tokenModel,
        MessageHelper $messageHelper
    ): self
    {

        if($tokenModel->getValidUntil() <= new \DateTime)
        {
            $messageHelper->addMessage('danger', 'Der Aktivierungsschlüssel ist bereits abgelaufen');
        }

        if($tokenModel->getType() !== TokenTypeModel::ActivateAccount)
        {
            $messageHelper->addMessage('danger', 'Der Aktivierungsschlüssel ist nicht für die Aktivierung von Konten');
        }

        return $this;

    }

}
