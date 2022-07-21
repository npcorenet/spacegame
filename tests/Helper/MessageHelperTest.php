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

    public function testCanCountSpecificMessageType()
    {
        $messageHelper = new MessageHelper();

        $expected[] = ['type' => 'danger', 'message' => 'Hello World1'];
        $expected[] = ['type' => 'success', 'message' => 'Hello World2'];
        $expected[] = ['type' => 'danger', 'message' => 'Hello World3'];
        $expected[] = ['type' => 'danger', 'message' => 'Hello World4'];
        $expected[] = ['type' => 'success', 'message' => 'Hello World5'];
        $expected[] = ['type' => 'warning', 'message' => 'Hello World6'];

        foreach ($expected as $item)
        {
            $messageHelper->addMessage($item['type'], $item['message']);
        }

        $this->assertSame(3, $messageHelper->countMessageByType('danger'));
        $this->assertSame(2, $messageHelper->countMessageByType('success'));
        $this->assertSame(1, $messageHelper->countMessageByType('warning'));

    }

}