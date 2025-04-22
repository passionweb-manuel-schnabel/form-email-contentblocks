<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Form email content blocks',
    'description' => 'Allows to add a content element at the beginning (introductory text) and/or at the end (email signature) of the email templates. Also, the background color and logo of the fluid email template can be edited.',
    'category' => 'be',
    'author' => 'Manuel Schnabel',
    'author_email' => 'service@passionweb.de',
    'author_company' => 'PassionWeb Manuel Schnabel',
    'state' => 'stable',
    'version' => '3.0.2',
    'constraints' => [
        'depends' => [
            'typo3' => '13.0.0-13.4.99',
            'form' => '13.0.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
