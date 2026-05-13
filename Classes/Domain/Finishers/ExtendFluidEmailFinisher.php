<?php

declare(strict_types=1);

namespace Passionweb\FormEmailContentblocks\Domain\Finishers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;

class ExtendFluidEmailFinisher extends AbstractFinisher
{
    protected function executeInternal(): void
    {
        $bgColor = $this->options['bgColor'] ?? '';
        if (ctype_xdigit(substr($bgColor, 1)) && (strlen($bgColor) === 4 || strlen($bgColor) === 7)) {
            $this->finisherContext->getFinisherVariableProvider()->add(
                $this->shortFinisherIdentifier,
                'backgroundColor',
                $this->options['bgColor']
            );
        }
        $logoPath = $this->options['logo'] ?? '';
        $absoluteLogoPath = $this->generateAbsolutePathOfFile($logoPath);
        if (!empty($absoluteLogoPath)) {
            $this->finisherContext->getFinisherVariableProvider()->add(
                $this->shortFinisherIdentifier,
                'logo',
                $absoluteLogoPath
            );
        }
        $this->finisherContext->getFinisherVariableProvider()->add(
            $this->shortFinisherIdentifier,
            'showCopyright',
            $this->options['showCopyright'] ?? false
        );
    }

    private function generateAbsolutePathOfFile(string $logoPath): string
    {
        if ($logoPath === '') {
            return '';
        }

        $request = $this->finisherContext->getRequest();

        if (PathUtility::isExtensionPath($logoPath)) {
            return GeneralUtility::locationHeaderUrl(PathUtility::getAbsoluteWebPath($logoPath), $request);
        }

        $baseUri = $request->getAttribute('normalizedParams')->getSiteUrl();
        return rtrim($baseUri, '/') . '/' . ltrim($logoPath, '/');
    }
}
