<?php declare(strict_types=1);

namespace App\Helper;

class MessageHelper
{

    private array $messages = [];

    public function addMessage(string $type, string $message): self
    {
        $this->messages[] = ['type' => $type, 'message' => $message];
        return $this;
    }

    public function countMessageByType(string $type): int
    {
        $count = 0;
        foreach ($this->messages as $message)
        {
            if($message['type'] === $type)
            {
                $count++;
            }
        }
        return $count;
    }

    public function getMessageArray(): array
    {
        return $this->messages;
    }

}
