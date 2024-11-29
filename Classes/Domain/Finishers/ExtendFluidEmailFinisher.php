<?php

namespace Passionweb\FormEmailContentblocks\Domain\Finishers;


use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Resource\Exception\InvalidFileException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;

class ExtendFluidEmailFinisher extends AbstractFinisher
{
    protected function executeInternal()
    {
        $bgColor = $this->options['bgColor'] ?? '';
        if(ctype_xdigit(substr($bgColor, 1)) && (strlen($bgColor) === 4 || strlen($bgColor) === 7)) {
            $this->finisherContext->getFinisherVariableProvider()->add(
                $this->shortFinisherIdentifier,
                'backgroundColor',
                $this->options['bgColor']
            );
        }
        $logoPath = $this->options['logo'] ?? '';
        $absoluteLogoPath = $this->generateAbsolutePathOfFile($logoPath);
        if(!empty($absoluteLogoPath)) {
            $this->finisherContext->getFinisherVariableProvider()->add(
                $this->shortFinisherIdentifier,
                'logo',
                $absoluteLogoPath
            );
        }
    }

    /**
     * @param string $logoPath
     * @return string
     */
    private function generateAbsolutePathOfFile(string $logoPath) {
        try {
            if(PathUtility::isExtensionPath($logoPath)) {
                return GeneralUtility::locationHeaderUrl(PathUtility::getPublicResourceWebPath($logoPath));
            } else {
                $baseUri = $this->finisherContext->getFormRuntime()->getRequest()->getAttribute('normalizedParams')->getSiteUrl();
                return $baseUri . "/". ltrim($logoPath, '/');
            }
        } catch (InvalidFileException $e) {
            $logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
            $logger->error($e->getMessage());
            return '';
        }
    }
}
