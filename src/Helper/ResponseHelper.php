<?php

namespace App\Helper;

class ResponseHelper
{

    public function createResponse(
        int $code,
        string $message = '',
        array $data = []
    ): array
    {

        $response['code'] = $code;
        $response['message'] = empty($message)? $this->getDefaultMessageForCode($code) : $message;
        if(!empty($data))
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
            500 => 'unknown-error',
            default => 'no-message-declared'
        };

    }

}