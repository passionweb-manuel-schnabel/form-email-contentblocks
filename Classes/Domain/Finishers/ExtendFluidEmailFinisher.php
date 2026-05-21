<?php

declare(strict_types=1);

namespace Passionweb\FormEmailContentblocks\Domain\Finishers;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\LinkHandling\LinkService;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
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
            $webPath = PathUtility::getPublicResourceWebPath($logoPath);
            return $webPath === '' ? '' : $this->getSiteOrigin($request) . '/' . ltrim($webPath, '/');
        }

        if (PathUtility::hasProtocolAndScheme($logoPath)) {
            return $logoPath;
        }

        $falPublicUrl = $this->resolveFalPublicUrl($logoPath);
        if ($falPublicUrl !== null) {
            if (PathUtility::hasProtocolAndScheme($falPublicUrl)) {
                return $falPublicUrl;
            }
            $logoPath = $falPublicUrl;
        }

        return rtrim($this->getSiteBaseUrl($request), '/') . '/' . ltrim($logoPath, '/');
    }

    /**
     * Canonical scheme + host (+ port) for document-root-relative paths, taken from the
     * site configuration. Falls back to the request host only when no site is available.
     */
    private function getSiteOrigin(ServerRequestInterface $request): string
    {
        $site = $request->getAttribute('site');
        if ($site instanceof Site && $site->getBase()->getHost() !== '') {
            $base = $site->getBase();
            $origin = $base->getScheme() . '://' . $base->getHost();
            if ($base->getPort() !== null) {
                $origin .= ':' . $base->getPort();
            }
            return $origin;
        }

        $normalizedParams = $request->getAttribute('normalizedParams');
        return $normalizedParams instanceof NormalizedParams ? rtrim($normalizedParams->getRequestHost(), '/') : '';
    }

    /**
     * Canonical site base URL (scheme + host + path) for site-relative resources, taken from
     * the site configuration. Falls back to the request-derived site URL when unavailable.
     */
    private function getSiteBaseUrl(ServerRequestInterface $request): string
    {
        $site = $request->getAttribute('site');
        if ($site instanceof Site && $site->getBase()->getHost() !== '') {
            return (string)$site->getBase();
        }

        $normalizedParams = $request->getAttribute('normalizedParams');
        return $normalizedParams instanceof NormalizedParams ? $normalizedParams->getSiteUrl() : '';
    }

    private function resolveFalPublicUrl(string $logoPath): ?string
    {
        try {
            if (str_starts_with($logoPath, 't3://')) {
                $resolved = GeneralUtility::makeInstance(LinkService::class)->resolve($logoPath);
                $file = $resolved['file'] ?? null;
                return $file instanceof FileInterface ? $file->getPublicUrl() : null;
            }

            if (str_starts_with($logoPath, 'file:')
                || MathUtility::canBeInterpretedAsInteger($logoPath)
                || preg_match('/^\d+:/', $logoPath) === 1
            ) {
                $file = GeneralUtility::makeInstance(ResourceFactory::class)->retrieveFileOrFolderObject($logoPath);
                return $file instanceof FileInterface ? $file->getPublicUrl() : null;
            }
        } catch (\Throwable) {
            return null;
        }

        return null;
    }
}
