<?php

namespace Passionweb\FormEmailContentblocks\Domain\Finishers;


use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Resource\Exception\InvalidFileException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;

class ExtendFluidEmailFinisher extends AbstractFinisher
{
    protected function executeInternal(): void
    {
        if(ctype_xdigit(substr($this->options['bgColor'], 1)) && (strlen($this->options['bgColor']) === 4 || strlen($this->options['bgColor']) === 7)) {
            $this->finisherContext->getFinisherVariableProvider()->add(
                $this->shortFinisherIdentifier,
                'backgroundColor',
                $this->options['bgColor']
            );
        }

        $absoluteLogoPath = $this->generateAbsolutePathOfFile($this->options['logo']);
        $this->finisherContext->getFinisherVariableProvider()->add(
            $this->shortFinisherIdentifier,
            'logo',
            $absoluteLogoPath
        );

        $this->finisherContext->getFinisherVariableProvider()->add(
            $this->shortFinisherIdentifier,
            'showCopyright',
            $this->options['showCopyright'] ?? false
        );
    }

    private function generateAbsolutePathOfFile(string $logoPath): string
    {
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
