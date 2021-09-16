'use strict';

define(
    [
        'jquery',
        'pim/media-field',
        'underscore',
        'routing',
        'pim/attribute-manager',
        'pixxio/template/product/field/pixxio-image',
        'pim/dialog',
        'oro/mediator',
        'pixxio/modal/overlay',
        'pim/media-url-generator',
        'oro/translator',
        'pixxio/jsdk',
        'jquery.slimbox',
    ], function (
        $,
        Field,
        _,
        Routing,
        AttributeManager,
        fieldTemplate,
        Dialog,
        mediator,
        FormModal,
        MediaUrlGenerator,
        __
        ) {
        return Field.extend(
            {
                fieldTemplate: _.template(fieldTemplate),
                events: {
                    'click .edit .field-input:first input[type="text"]': 'openModal',
                    'click  .clear-field': 'clearField',
                    'click  .open-media': 'previewImage',
                    'click  .open-tab': 'newTab'
                },
                renderInput: function (context) {
                    return this.fieldTemplate(context);
                },
                getConfigQueryParameters: function () {
                    return {
                        method: 'GET',
                        headers: [
                            ['X-Requested-With', 'XMLHttpRequest'],
                        ],
                    };
                },
                getModalConfig: function () {
                    return {
                        className: 'modal modal--fullPage',
                        content: '',
                        lables: {title: '', subsTitle: ''},
                    };
                },
                openModal: function () {
                    const modalParameters = this.getModalConfig();

                    fetch(Routing.generate('pixxio_pixxio_connector_config'), this.getConfigQueryParameters()).then(
                        function (config) {
                            config.json().then(
                                function (apiConfig) {
                                    if (apiConfig.key !== '' && apiConfig.url !== '') {
                                        const formModal = new FormModal('pixxio-modal-template', this.updateModel.bind(this), modalParameters);

                                        formModal.open();

                                        const p = new PIXXIO(
                                            {
                                                element: document.getElementById('pixxio-integration'),
                                                appKey: apiConfig.key,
                                                appUrl: apiConfig.url,
                                                v1: apiConfig.version
                                            }
                                        );

                                        p.getMedia({max: 1}).then(
                                            function (formFiles) {
                                                if (formFiles) {
                                                    this.updateModel(formFiles);
                                                }
                                            }.bind(this)
                                        )
                                        .catch(/** capture cancel **/)
                                        .finally(
                                            function () {
                                                formModal.close();
                                            }.bind(formModal)
                                        );
                                    } else {
                                        Dialog.alert(__('pixxio_pixxio.message.config'))
                                    }
                                }.bind(this)
                            )
                        }.bind(this)
                    );
                },
                setUploadContextValue: function (value) {
                    var productValue = AttributeManager.getValue(
                        this.model.get('values'),
                        this.attribute,
                        this.context.locale,
                        this.context.scope
                    );

                    if (productValue) {
                        productValue.data = value;
                        mediator.trigger('pim_enrich:form:entity:update_state');
                    }
                },
                updateModel: function (formFiles) {
                    const fileData = formFiles[0] ? formFiles[0] : false;
                    if (fileData) {
                        this.setUploadContextValue(fileData.url+'|'+fileData.thumbnail);
                    }
                    this.render();
                },
                clearField: function () {
                    this.setCurrentValue(null);

                    this.render();
                },
                previewImage: function () {
                    let mediaUrl = MediaUrlGenerator.getMediaShowUrl(this.getCurrentValue().data, 'preview');
                    if (mediaUrl) {
                        $.slimbox(mediaUrl, '', {overlayOpacity: 0.3});
                    }
                },
                newTab: function() {
                    window.open(MediaUrlGenerator.getMediaShowUrl(this.getCurrentValue().data, 'preview'), '_blank');
                }
            }
        );
    }
);
