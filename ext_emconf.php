<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Form email content blocks',
    'description' => 'Allows to add a content element at the beginning (introductory text) and/or at the end (email signature) of the email templates. Also, the background color and logo of the fluid email template can be edited.',
    'category' => 'be',
    'author' => 'Manuel Schnabel',
    'author_email' => 'service@passionweb.de',
    'author_company' => 'PassionWeb Manuel Schnabel',
    'state' => 'stable',
    'version' => '2.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '12.0.0-12.2.0',
            'form' => '12.0.0-12.2.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
