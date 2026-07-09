<?php

defined('TYPO3') or die();

// EXT:form resolves its YAML configuration exclusively from the TypoScript paths
// plugin.tx_form/module.tx_form.settings.yamlConfigurations up to and including v13.
// Configuration/Form/*/config.yaml auto-discovery only exists as of v14.2.
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
    'form_email_contentblocks',
    'setup',
    '@import "EXT:form_email_contentblocks/Configuration/TypoScript/setup.typoscript"'
);
