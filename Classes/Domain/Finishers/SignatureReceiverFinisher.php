<?php

namespace Passionweb\FormEmailContentblocks\Domain\Finishers;


use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use Passionweb\FormEmailContentblocks\Domain\Finishers\Base\ContentFinisher;

class SignatureReceiverFinisher extends ContentFinisher
{
    public function __construct(
        ContentObjectRenderer $contentObjectRenderer
    )
    {
        parent::__construct($contentObjectRenderer);

        $this->contentType = 'signature';
    }

    protected function executeInternal()
    {
        $this->addFinisherVariable('html');
        $this->addFinisherVariable('plaintext');
    }

}
