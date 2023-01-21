/**
 * Module: TYPO3/CMS/FormEmailContentblocks/Backend/FormEditor/ViewModel
 */
define(['jquery',
    'TYPO3/CMS/Form/Backend/FormEditor/Helper'
], function($, Helper) {
    'use strict';

    return (function($, Helper) {

        /**
         * @private
         *
         * @var object
         */
        var _finishersWithFieldExplanationText = [
            'ExtendFluidMail',
            'IntroductoryReceiver',
            'IntroductorySender',
            'SignatureReceiver',
            'SignatureSender',
        ];

        /**
         * @private
         *
         * @var object
         */
        var _formEditorApp = null;

        /**
         * @private
         *
         * @return object
         */
        function getFormEditorApp() {
            return _formEditorApp;
        }

        /**
         * @private
         *
         * @return object
         */
        function getPublisherSubscriber() {
            return getFormEditorApp().getPublisherSubscriber();
        }

        /**
         * @private
         *
         * @return object
         */
        function getUtility() {
            return getFormEditorApp().getUtility();
        }

        /**
         * @private
         *
         * @param object
         * @return object
         */
        function getHelper() {
            return Helper;
        }

        /**
         * @private
         *
         * @return object
         */
        function getCurrentlySelectedFormElement() {
            return getFormEditorApp().getCurrentlySelectedFormElement();
        }

        /**
         * @private
         *
         * @param mixed test
         * @param string message
         * @param int messageCode
         * @return void
         */
        function assert(test, message, messageCode) {
            return getFormEditorApp().assert(test, message, messageCode);
        }

        /**
         * @private
         *
         * @return void
         * @throws 1491643380
         */
        function _helperSetup() {
            assert('function' === $.type(Helper.bootstrap),
                'The view model helper does not implement the method "bootstrap"',
                1491643380
            );
            Helper.bootstrap(getFormEditorApp());
        }

        /**
         * @private
         *
         * @return void
         */
        function _subscribeEvents() {
            /**
             * @private
             *
             * @param string
             * @param array
             *              args[0] = editorConfiguration
             *              args[1] = editorHtml
             *              args[2] = collectionElementIdentifier
             *              args[3] = collectionName
             * @return void
             */
            getPublisherSubscriber().subscribe('view/inspector/editor/insert/perform', function (topics, args) {
                if (args[2] && args[3] && _finishersWithFieldExplanationText.includes(args[2]) && args[3] === 'finishers') {
                    if (getUtility().isNonEmptyString(args[0]['fieldExplanationText'])) {
                        getHelper()
                            .getTemplatePropertyDomElement('fieldExplanationText', args[1])
                            .text(args[0]['fieldExplanationText']);

                        document.querySelector('div[data-finisher-identifier="'+args[2]+'"] .t3-form-inspector-finishers-editor-header .inspector-editor-hint')
                            .style.display = 'inline-block';
                    } else {
                        getHelper()
                            .getTemplatePropertyDomElement('fieldExplanationText', args[1])
                            .remove();
                    }
                }
            });
        }

        /**
         * @public
         *
         * @param object formEditorApp
         * @return void
         */
        function bootstrap(formEditorApp) {
            _formEditorApp = formEditorApp;
            _helperSetup();
            _subscribeEvents();
        }

        /**
         * Publish the public methods.
         * Implements the "Revealing Module Pattern".
         */
        return {
            bootstrap: bootstrap
        };
    })($, Helper);
});
