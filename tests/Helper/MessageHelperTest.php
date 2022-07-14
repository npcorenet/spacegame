<?php

namespace Helper;

use App\Helper\MessageHelper;
use PHPUnit\Framework\TestCase;

class MessageHelperTest extends TestCase
{

    public function testCanAddMessageAndRequireArrayAndClearAfterwards()
    {
        $messageHelper = new MessageHelper();

        $expected = [];
        $expected[] = ['type' => 'danger', 'message' => 'Hello World'];

        $messageHelper->addMessage($expected[0]['type'], $expected[0]['message']);

        $this->assertIsArray($messageHelper->getMessageArray());
        $this->assertSame($expected, $messageHelper->getMessageArray());

        $messageHelper->clearMessageArray();
        $this->assertSame([], $messageHelper->getMessageArray());
    }

    public function testCanAddMultipleMessagesAndRequireArrayAndClearAfterwards()
    {
        $messageHelper = new MessageHelper();

        $expected = [];
        $expected[] = ['type' => 'danger', 'message' => 'Hello World'];
        $expected[] = ['type' => 'danger', 'message' => 'Hello World2'];
        $expected[] = ['type' => 'success', 'message' => 'Hello World5'];

        foreach ($expected as $item)
        {
            $messageHelper->addMessage($item['type'], $item['message']);
        }

        $this->assertIsArray($messageHelper->getMessageArray());
        $this->assertSame($expected, $messageHelper->getMessageArray());

        $messageHelper->clearMessageArray();
        $this->assertSame([], $messageHelper->getMessageArray());

    }

}