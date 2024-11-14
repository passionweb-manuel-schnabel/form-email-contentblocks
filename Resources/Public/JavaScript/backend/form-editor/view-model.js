/**
 * Module: @passionweb/form-email-contentblocks/backend/form-editor/view-model.js
 */

/**
 * @private
 *
 * @var object
 */
const finishersWithFieldExplanationText = [
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
        if (args[2] && args[3] && finishersWithFieldExplanationText.includes(args[2]) && args[3] === 'finishers') {
            if (getUtility(formEditorApp).isNonEmptyString(args[0]['fieldExplanationText'])) {
                getHelper(formEditorApp)
                    .getTemplatePropertyDomElement('fieldExplanationText', args[1])
                    .text(args[0]['fieldExplanationText']);

                document.querySelector('div[data-finisher-identifier="'+args[2]+'"] .t3-form-inspector-finishers-editor-header .inspector-editor-hint')
                    .style.display = 'flex';
            } else {
                getHelper(formEditorApp)
                    .getTemplatePropertyDomElement('fieldExplanationText', args[1])
                    .remove();
            }
        }
    });
}
export function bootstrap(formEditorApp) {
    subscribeEvents(formEditorApp);
}
