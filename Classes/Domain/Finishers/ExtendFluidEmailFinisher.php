<?php

namespace Passionweb\FormEmailContentblocks\Domain\Finishers;


use TYPO3\CMS\Core\Resource\Exception\InvalidFileException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;

class ExtendFluidEmailFinisher extends AbstractFinisher
{
    protected function executeInternal()
    {
        /**
         * check if a valid hexidecimal string was entered
         */
        if(ctype_xdigit(substr($this->options['bgColor'], 1)) && (strlen($this->options['bgColor']) === 4 || strlen($this->options['bgColor']) === 7)) {
            $this->finisherContext->getFinisherVariableProvider()->add(
                $this->shortFinisherIdentifier,
                'backgroundColor',
                $this->options['bgColor']
            );
        }

        /**
         * get absolute path based on entered logo path
         */
        $absoluteLogoPath = $this->generateAbsolutePathOfFile($this->options['logo']);

        $this->finisherContext->getFinisherVariableProvider()->add(
            $this->shortFinisherIdentifier,
            'logo',
            $absoluteLogoPath
        );
    }

    /**
     * @param string $logoPath
     * @return string
     * @throws InvalidFileException
     */
    private function generateAbsolutePathOfFile(string $logoPath) {
        // entered file path is an extension path
        if(PathUtility::isExtensionPath($logoPath)) {
            return GeneralUtility::locationHeaderUrl(PathUtility::getPublicResourceWebPath($logoPath));
        }
        // entered file path is a relative fileadmin path
        else {
            // get base uri
            $baseUri = $this->finisherContext->getFormRuntime()->getRequest()->getAttribute('normalizedParams')->getSiteUrl();
            return $baseUri . "/". ltrim($logoPath, '/');
        }
    }
}
