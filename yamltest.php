<?php
//ddev exec php yamltest.php 2>&1 | tail -10; rm yamltest.php

require __DIR__ . '/.build/vendor/autoload.php';
try {
    $y = \Symfony\Component\Yaml\Yaml::parseFile(__DIR__ . '/Extensions/form-email-contentblocks/Configuration/Yaml/Finishers/ExtendFluidEmail.yaml');
    var_export($y['TYPO3']['CMS']['Form']['prototypes']['standard']['finishersDefinition']['ExtendFluidEmail']['formEditor']['predefinedDefaults']);
} catch (\Throwable $e) {
    echo 'ERROR: ' . $e->getMessage();
}
