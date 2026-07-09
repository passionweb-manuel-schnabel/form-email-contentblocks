/**
 * Module: @passionweb/form-email-contentblocks/backend/form-editor/view-model.js
 */

/**
 * @private
 *
 * @var object
 */
const finishersWithDescription = [
    'ExtendFluidEmail',
    'IntroductoryReceiver',
    'IntroductorySender',
    'SignatureReceiver',
    'SignatureSender',
];

/**
 * @private
 *
 * @return object
 */
function getPublisherSubscriber(formEditorApp) {
    return formEditorApp.getPublisherSubscriber();
}

function getUtility(formEditorApp) {
    return formEditorApp.getUtility();
}
function getHelper(formEditorApp) {
    return formEditorApp.viewModel.getHelper();
}

/**
 * @private
 *
 * @return void
 */
function subscribeEvents(formEditorApp) {
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
    getPublisherSubscriber(formEditorApp).subscribe('view/inspector/editor/insert/perform', function (topics, args) {
        if (args[2] && args[3] && finishersWithDescription.includes(args[2]) && args[3] === 'finishers') {
            // Since TYPO3 v14 the former "fieldExplanationText" editor property was renamed
            // to "description" (fieldExplanationText is deprecated and auto-migrated). The core
            // header editor (Inspector-CollectionElementHeaderEditor) does not render the
            // description itself, so we still populate it from our custom partial here.
            if (getUtility(formEditorApp).isNonEmptyString(args[0]['description'])) {
                const descriptionElement = getHelper(formEditorApp)
                    .getTemplatePropertyElement('description', args[1]);
                if (descriptionElement) {
                    descriptionElement.textContent = args[0]['description'];
                }

                // The hint lives inside the rendered header editor (args[1]) and is hidden
                // by default in the CollectionElementHeaderEditor partial. Reveal it here.
                // Note: since TYPO3 v14 the collection element is no longer marked with a
                // "data-finisher-identifier" attribute, so we must not rely on a global
                // document lookup. Moving the remove button/building the collapse toggle is
                // now handled by the core header editor, so no extra DOM surgery is needed.
                const hintElement = args[1].querySelector('.inspector-editor-hint');
                if (hintElement) {
                    hintElement.style.display = 'flex';
                }
            }
        }
    });
}
export function bootstrap(formEditorApp) {
    subscribeEvents(formEditorApp);
}
