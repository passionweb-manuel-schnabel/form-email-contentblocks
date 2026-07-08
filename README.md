# TYPO3 Extension `Form email contentblocks`

Allows to add a content element at the beginning (introductory text) and/or at the end (signature) of the email templates. Also, the background color and logo of the fluid email template can be edited.

## Features

- Add a content element at the beginning of the email to receiver template
- Add a content element at the beginning of the email to sender template

![Introductory text finisher for sender/receiver](./Documentation/Introduction/example-introductory-text.png)

- Add a content element at the end of the email to receiver template
- Add a content element at the end of the email to sender template

![Signature text finisher for sender/receiver](./Documentation/Introduction/example-signature-text.png)

- Edit the background color and logo of the fluid email template for sender and receiver

![ExtendFluidEmail finisher](./Documentation/Introduction/example-extend-fluid-email.png)

## Installation

Add via composer:

    composer require "passionweb/form-email-contentblocks"

* Install the extension via composer
* Flush TYPO3 and PHP Cache

## What does this extension do?

This extension provides additional finishers for the TYPO3 system extension "Form" ([EXT:form](https://docs.typo3.org/c/typo3/cms-form/11.5/en-us/Index.html "EXT:form")). In order for this extension to work as desired, the extension must be installed and configured correctly.

Since version 1.1.0 it is possible to [use form variables in the content elements](#add-form-variables-to-content-elements).

Following finishers are available:

 - `IntroductoryReceiverFinisher` (Adds a content element at the beginning of the email to receiver template)

 - `IntroductorySenderFinisher` (Adds a content element at the beginning of the email to sender template)

 - `SignatureReceiverFinisher` (Adds a content element at the end of the email to receiver template)

 - `SignatureSenderFinisher` (Adds a content element at the end of the email to sender template)

 - `ExtendFluidEmailFinisher` (Edit the background color and logo of the fluid email template for sender and receiver. The logo accepts an extension path (`EXT:...`), a public URL, a FAL reference (`t3://file?uid=…`, `file:…` or `storage:uid`) or a document-root-relative path. Background color, logo and copyright can also be pre-set site-wide via the site set, see [Configuration](#configuration).)

All previous finishers must be placed in front of the associated email finishers (`EmailToSender` or `EmailToReceiver`). Otherwise the corresponding content blocks are ignored. The same applies to the ExtendFluidEmailFinisher variables.

For each finisher, the corresponding notes are also displayed in the header of the respective finisher.

## Configuration

### Form configuration (automatic)

As of TYPO3 v14, the form YAML configuration is registered automatically through the
form framework's auto-discovery (`Configuration/Form/FormEmailContentblocks/config.yaml`),
for both the frontend and the backend form editor. **No TypoScript setup is required.**

> The previous TypoScript registration via
> `plugin.tx_form`/`module.tx_form.settings.yamlConfigurations` was deprecated in TYPO3
> v14.2 ([#109412](https://docs.typo3.org/permalink/changelog:deprecation-109412-1732785703))
> and removed here in favour of auto-discovery.

### Site-wide defaults (site set)

The extension ships a site set **`passionweb/form-email-contentblocks`** that exposes
site-wide fallback defaults for the `ExtendFluidEmailFinisher`:

| Setting | Type | Description |
| --- | --- | --- |
| `formEmailContentblocks.bgColor` | string | Fallback background color (hex, e.g. `#ffffff`) |
| `formEmailContentblocks.logo` | string | Fallback logo (`EXT:` path, URL, FAL reference or root-relative path) |
| `formEmailContentblocks.showCopyright` | bool | Default for the copyright note |

Include the set in your site: **Site Management → Sites → your site → Sets → add
"Form email content blocks"** (or add `passionweb/form-email-contentblocks` to the
site's `dependencies` in `config/sites/<identifier>/config.yaml`). Per-form finisher
options always take precedence; the site settings only apply when a form leaves the
respective option empty. The site set is optional — the finishers work without it.

## How editors can/should use the extension

1) Create new or edit an existing form
2) Add the finisher(s) you want to use (and place them in the right order)

![Signature finisher for sender/receiver](./Documentation/Editor/overview-added-finishers.png)

3) Save the form

## Add form variables to content elements

Since version 1.1.0 it is possible to use form variables in the content elements or the text fields for the plaintext. You can use it in the same way as in the finisher configurations.

![Form variables in content element](./Documentation/Editor/form-variables-in-content-element.png)

## Troubleshooting and logging

If something does not work as expected take a look at the log file first.
Every problem is logged to the TYPO3 log (normally found in `var/log/typo3_*.log`).

If something still doesn't work as desired after checking the logs, feel free to contact me.

## Important notes

This extension does not override any of the default EXT:form finisher classes, as it uses the `FinisherVariableProvider` object to share variables between finishers.

But the default email templates are overwritten. If you use several extensions that overwrite the default email templates of EXT:form, conflicts can arise.

## Achieving more together or Feedback, Feedback, Feedback

I'm grateful for any feedback! Be it suggestions for improvement, extension requests or just a (constructive) feedback on how good or crappy the extension is.

Feel free to send me your feedback to [service@passionweb.de](mailto:service@passionweb.de "Send Feedback") or [contact me on Slack](https://typo3.slack.com/team/U02FG49J4TG "Contact me on Slack")
