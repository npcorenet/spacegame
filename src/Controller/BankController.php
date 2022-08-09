<?php

namespace App\Controller;

use Laminas\Diactoros\Response;

class BankController extends AbstractController
{

    public function load(): Response
    {

        if (!$this->isAuthenticatedAndValid()) {
            $this->data = ['code' => 403, 'message' => parent::ERROR403];
            return $this->response();
        }

        $this->data = ['code' => 200, 'message' => 'success'];
        return $this->response();
    }

}