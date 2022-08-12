<?php

namespace App\Helper;

class ResponseHelper
{

    public function createResponse(
        int $code,
        string $message = '',
        array $data = null
    ): array
    {

        $response['code'] = $code;
        $response['message'] = empty($message)? $this->getDefaultMessageForCode($code) : $message;
        if(!is_null($data))
        {
            $response['data'] = $data;
        }

        return $response;
    }

    private function getDefaultMessageForCode(int $code): string
    {

        return match($code) {
            200 => 'success',
            400 => 'data-missing',
            403 => 'authentication-required',
            405 => 'method-not-allowed',
            500 => 'unknown-error',
            default => 'no-message-declared'
        };

    }

}