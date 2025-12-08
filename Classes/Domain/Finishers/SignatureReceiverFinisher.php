<?php

namespace Passionweb\FormEmailContentblocks\Domain\Finishers;


use Passionweb\FormEmailContentblocks\Domain\Finishers\Base\ContentFinisher;

class SignatureReceiverFinisher extends ContentFinisher
{
    public function __construct()
    {
        $this->contentType = 'signatureEmailToReceiver';
    }

    protected function executeInternal(): void
    {
        $this->addFinisherVariable('html');
        $this->addFinisherVariable('plaintext');
    }
}
