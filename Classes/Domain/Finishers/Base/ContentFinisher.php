<?php

namespace Passionweb\FormEmailContentblocks\Domain\Finishers\Base;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

abstract class ContentFinisher extends AbstractFinisher
{
    protected string $contentType;

    protected function addFinisherVariable(string $format):void {

        $this->finisherContext->getFinisherVariableProvider()->add(
            $this->contentType,
            $format,
            $this->buildContent($format)
        );
    }

    protected function buildContent(string $format): string
    {
        if($format === 'html') {
            $request = $this->finisherContext->getRequest();
            $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
            $cObj->setRequest($request);
            $cObj->start([], 'tt_content');
            $conf = [
                'table' => 'tt_content',
                'select.' => [
                    'uidInList' => $this->options['contentElementUidHtml'],
                    'pidInList' => 0
                ]
            ];
            $htmlContent = $cObj->cObjGetSingle('CONTENT', $conf);
            $baseUri = $request->getAttribute('normalizedParams')->getSiteUrl();
            $htmlContent = str_replace('/fileadmin', $baseUri.'fileadmin', $htmlContent);
            return $this->replaceFormVariablesWithUserInputs($htmlContent);
        } else {
            return $this->replaceFormVariablesWithUserInputs($this->parseOption('contentPlaintext'));
        }
    }

    protected function replaceFormVariablesWithUserInputs(string $content): string {
        $formValues = $this->finisherContext->getFormRuntime()->getFormState()->getFormValues();
        foreach($formValues as $key => $value) {
            if (gettype($value) === "string") {
                $content = str_replace("{".$key."}", $value, $content);
            }
        }
        return $content;
    }
}
