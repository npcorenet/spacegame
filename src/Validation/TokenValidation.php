<?php declare(strict_types=1);

namespace App\Validation;

use App\Helper\MessageHelper;
use App\Model\TokenModel;
use App\Table\AccountTable;

class TokenValidation
{

    public function validate(
        TokenModel $tokenModel,
        MessageHelper $messageHelper
    ): self
    {

        $messages = [];

        if($tokenModel->getValidUntil() <= new \DateTime)
        {
            $messageHelper->addMessage('danger', 'Der Aktivierungsschlüssel ist bereits abgelaufen');
        }

        return $this;

    }

}
