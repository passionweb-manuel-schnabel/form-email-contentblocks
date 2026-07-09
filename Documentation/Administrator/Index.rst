.. include:: ../Includes.txt


Administration Manual
=====================

Target group: **Administrators**

Requirements
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This extension provides additional finishers for the TYPO3 system extension "Form" (`EXT:form <https://docs.typo3.org/c/typo3/cms-form/11.5/en-us/Index.html>`_). In order for this extension to work as desired, the extension must be installed and configured correctly.

Installation
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Add via composer.json:

.. code-block:: javascript

  composer require "passionweb/form-email-contentblocks"

- Install the extension via composer

- Flush TYPO3 and PHP Cache

Form configuration (automatic)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

As of TYPO3 v14 the form YAML configuration is registered automatically through the form
framework's auto-discovery (``Configuration/Form/FormEmailContentblocks/config.yaml``), for
both the frontend and the backend form editor. No TypoScript setup is required.

The previous TypoScript registration via ``plugin.tx_form``/``module.tx_form.settings.yamlConfigurations``
was deprecated in TYPO3 v14.2 (`#109412 <https://docs.typo3.org/permalink/changelog:deprecation-109412-1732785703>`_)
and removed here in favour of auto-discovery.

Site-wide defaults (site set)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The extension ships a site set ``passionweb/form-email-contentblocks`` that exposes site-wide
fallback defaults for the ``ExtendFluidEmailFinisher``:

- ``formEmailContentblocks.bgColor`` – fallback background color (hex, e.g. ``#ffffff``)
- ``formEmailContentblocks.logo`` – fallback logo (``EXT:`` path, URL, FAL reference or root-relative path)
- ``formEmailContentblocks.showCopyright`` – default for the copyright note

Include the set via :guilabel:`Site Management > Sites > (your site) > Sets` and add
"Form email content blocks", or add ``passionweb/form-email-contentblocks`` to the site's
``dependencies``. Per-form finisher options always take precedence; the site settings only
apply when a form leaves the respective option empty. The site set is optional.
