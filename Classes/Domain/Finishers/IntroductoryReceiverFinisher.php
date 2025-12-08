<?php

namespace Passionweb\FormEmailContentblocks\Domain\Finishers;


use Passionweb\FormEmailContentblocks\Domain\Finishers\Base\ContentFinisher;

class IntroductoryReceiverFinisher extends ContentFinisher
{
    public function __construct()
    {
        $this->contentType = 'introductoryEmailToReceiver';
    }

    protected function executeInternal(): void
    {
        $this->addFinisherVariable('html');
        $this->addFinisherVariable('plaintext');
    }
}
