<?php

namespace Passionweb\FormEmailContentblocks\Domain\Finishers;


use Passionweb\FormEmailContentblocks\Domain\Finishers\Base\ContentFinisher;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class IntroductorySenderFinisher extends ContentFinisher
{
    public function __construct(
        ContentObjectRenderer $contentObjectRenderer
    )
    {
        parent::__construct($contentObjectRenderer);

        $this->contentType = 'introductory';
    }

    protected function executeInternal()
    {
        $this->addFinisherVariable('html');
        $this->addFinisherVariable('plaintext');
    }

}
