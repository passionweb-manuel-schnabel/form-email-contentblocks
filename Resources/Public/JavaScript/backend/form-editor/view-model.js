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

                setTimeout(function() {
                    const finisherElement = document.querySelector('div[data-finisher-identifier="'+args[2]+'"]');
                    if (finisherElement) {
                        const panelHeadingRow = finisherElement.querySelector('.panel-heading-row');

                        let removeButtonElement = finisherElement.querySelector('.formeditor-inspector-element-remove-button');

                        if (panelHeadingRow && removeButtonElement && !panelHeadingRow.querySelector('.panel-actions')) {
                            const panelActionsDiv = document.createElement('div');
                            panelActionsDiv.classList.add('panel-actions');

                            const buttonElement = removeButtonElement.tagName === 'BUTTON' ? removeButtonElement : removeButtonElement.querySelector('button');
                            if (buttonElement) {
                                buttonElement.classList.add('btn-sm');
                                const btnLabel = buttonElement.querySelector('.btn-label');
                                if (btnLabel) {
                                    btnLabel.classList.add('visually-hidden');
                                }
                                panelActionsDiv.appendChild(buttonElement);
                                panelHeadingRow.appendChild(panelActionsDiv);

                                if (removeButtonElement !== buttonElement) {
                                    removeButtonElement.remove();
                                }
                            }
                        }
                        const hintElement = finisherElement.querySelector('.inspector-editor-hint');
                        if (hintElement) {
                            hintElement.style.display = 'flex';
                        }
                    }
                }, 100);
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
