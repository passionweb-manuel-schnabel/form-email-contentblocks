<?php

defined('TYPO3') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
    'form_email_contentblocks',
    'setup',
    '@import "EXT:form_email_contentblocks/Configuration/TypoScript/setup.typoscript"'
);
