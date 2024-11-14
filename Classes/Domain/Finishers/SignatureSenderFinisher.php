<?php

namespace Passionweb\FormEmailContentblocks\Domain\Finishers;


use Passionweb\FormEmailContentblocks\Domain\Finishers\Base\ContentFinisher;

class SignatureSenderFinisher extends ContentFinisher
{
    public function __construct()
    {
        $this->contentType = 'signature';
    }

    protected function executeInternal(): void
    {
        $this->addFinisherVariable('html');
        $this->addFinisherVariable('plaintext');
    }
}
