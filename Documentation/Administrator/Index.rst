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

Extension configuration (TypoScript)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

All necessary configurations are read in using the [ext\_typoscript\_setup.typoscript](./ext_typoscript_setup.typoscript) file.

.. code-block:: javascript

   plugin.tx_form.settings.yamlConfigurations {
       1673535916 = EXT:form_email_contentblocks/Configuration/Yaml/BaseSetup.yaml
   }

   module.tx_form.settings.yamlConfigurations {
       1673535916 = EXT:form_email_contentblocks/Configuration/Yaml/BaseSetup.yaml
       1673535917 = EXT:form_email_contentblocks/Configuration/Yaml/FormEditorSetup.yaml
   }
