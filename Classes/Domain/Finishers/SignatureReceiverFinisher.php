<?php

namespace Passionweb\FormEmailContentblocks\Domain\Finishers;


use Passionweb\FormEmailContentblocks\Domain\Finishers\Base\ContentFinisher;

class SignatureReceiverFinisher extends ContentFinisher
{
    public function __construct()
    {
        parent::__construct();
        $this->contentType = 'signature';
    }

    protected function executeInternal()
    {
        $this->addFinisherVariable('html');
        $this->addFinisherVariable('plaintext');
    }
}
