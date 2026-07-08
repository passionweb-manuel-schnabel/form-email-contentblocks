<?php

$EM_CONF['form_email_contentblocks'] = [
    'title' => 'Form email content blocks',
    'description' => 'Allows to add a content element at the beginning (introductory text) and/or at the end (email signature) of the email templates. Also, the background color and logo of the fluid email template can be edited.',
    'category' => 'be',
    'author' => 'Manuel Schnabel',
    'author_email' => 'service@passionweb.de',
    'author_company' => 'PassionWeb Manuel Schnabel',
    'state' => 'stable',
    'version' => '4.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '14.3.0-14.3.99',
            'form' => '14.3.0-14.3.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
