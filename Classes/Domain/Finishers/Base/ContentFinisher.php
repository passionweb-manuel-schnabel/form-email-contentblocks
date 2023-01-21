<?php

namespace Passionweb\FormEmailContentblocks\Domain\Finishers\Base;


use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\RecordsContentObject;

abstract class ContentFinisher extends AbstractFinisher
{
    protected string $contentType;

    protected ContentObjectRenderer $contentObjectRenderer;

    public function __construct(
        ContentObjectRenderer $contentObjectRenderer
    )
    {
        $this->contentObjectRenderer = $contentObjectRenderer;
    }

    /**
     * @param string $key
     * @param string $emailTo
     * @param string $format
     * @return void
     */
    protected function addFinisherVariable(string $format) {

        $this->finisherContext->getFinisherVariableProvider()->add(
            $this->contentType,
            $format,
            $this->buildContent($format)
        );
    }

    /**
     * renders the content object and set absolute path for images from fileadmin
     *
     * @param string $format
     * @return string
     */
    protected function buildContent(string $format): string
    {
        if($format === 'html') {
            $recordsContentObject = new RecordsContentObject($this->contentObjectRenderer);
            $baseUri = $this->finisherContext->getFormRuntime()->getRequest()->getAttribute('normalizedParams')->getSiteUrl();
            $signatureContentHtml = $recordsContentObject->render(['tables' => 'tt_content', 'source' => $this->options['contentElementUidHtml'], 'dontCheckPid' => 1]);
            return str_replace('/fileadmin', $baseUri.'fileadmin', $signatureContentHtml);
        } else {
            return $this->parseOption('contentPlaintext');
        }
    }
}
