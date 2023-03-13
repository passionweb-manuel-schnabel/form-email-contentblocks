<?php

namespace Passionweb\FormEmailContentblocks\Domain\Finishers\Base;


use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;
use TYPO3\CMS\Frontend\ContentObject\RecordsContentObject;

abstract class ContentFinisher extends AbstractFinisher
{
    protected string $contentType;

    public function __construct() {}

    /**
     * adds variable to finisherVariableProvider with generated content
     */
    protected function addFinisherVariable(string $format):void {

        $this->finisherContext->getFinisherVariableProvider()->add(
            $this->contentType,
            $format,
            $this->buildContent($format)
        );
    }

    /**
     * renders the content object and set absolute path for images from fileadmin
     */
    protected function buildContent(string $format): string
    {
        if($format === 'html') {
            $recordsContentObject = GeneralUtility::makeInstance(RecordsContentObject::class);
            $recordsContentObject->setContentObjectRenderer($GLOBALS['TSFE']->cObj);
            $recordsContentObject->setRequest($this->finisherContext->getRequest());
            // get base uri
            $baseUri = $this->finisherContext->getFormRuntime()->getRequest()->getAttribute('normalizedParams')->getSiteUrl();
            $htmlContent = $recordsContentObject->render(['tables' => 'tt_content', 'source' => $this->options['contentElementUidHtml'], 'dontCheckPid' => 1]);
            // convert available relative fileadmin paths to absolute paths
            $htmlContent = str_replace('/fileadmin', $baseUri.'fileadmin', $htmlContent);

            return $this->replaceFormVariablesWithUserInputs($htmlContent);
        } else {
            return $this->replaceFormVariablesWithUserInputs($this->parseOption('contentPlaintext'));
        }
    }

    protected function replaceFormVariablesWithUserInputs(string $content):string {
        $formValues = $this->finisherContext->getFormRuntime()->getFormState()->getFormValues();
        foreach($formValues as $key => $value) {
            if (gettype($value) === "string") {
                $content = str_replace("{".$key."}", $value, $content);
            }
        }
        return $content;
    }
}
