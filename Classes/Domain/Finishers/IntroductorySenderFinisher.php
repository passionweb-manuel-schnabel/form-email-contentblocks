<?php

namespace Passionweb\FormEmailContentblocks\Domain\Finishers;


use Passionweb\FormEmailContentblocks\Domain\Finishers\Base\ContentFinisher;

class IntroductorySenderFinisher extends ContentFinisher
{
    public function __construct()
    {
        $this->contentType = 'introductoryEmailToSender';
    }

    protected function executeInternal(): void
    {
        $this->addFinisherVariable('html');
        $this->addFinisherVariable('plaintext');
    }
}
