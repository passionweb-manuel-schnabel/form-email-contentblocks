<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Form email content blocks',
    'description' => 'Allows to add a content element at the beginning (introductory text) and/or at the end (email signature) of the email templates. Also, the background color and logo of the fluid email template can be edited.',
    'category' => 'system',
    'author' => 'Manuel Schnabel',
    'author_email' => 'service@passionweb.de',
    'author_company' => 'PassionWeb Manuel Schnabel',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'uploadfolder' => false,
    'createDirs' => '',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
            'form' => '11.5.0-11.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
