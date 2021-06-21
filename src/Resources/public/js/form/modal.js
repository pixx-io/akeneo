'use strict';

define(
    [
    'jquery',
    'underscore',
    'backbone',
    'pim/form',
    'pixxio/modal/overlay/template'
    ], function (
        $,
        _,
        Backbone,
        BaseForm,
        template
    ) {
        return BaseForm.extend(
            {
                config: {},
                template: _.template(template),
                validationErrors: [],
                modal: null,
                def: null,

                initialize(meta) {
                    this.config = meta.config;

                    BaseForm.prototype.initialize.apply(this, arguments);
                },
                configure(meta) {
                    if(meta && meta.config) {
                        this.config = meta.config;
                    }
                },
                render() {
                    this.$el.html(
                        this.template(
                            {
                                innerDescription: '',
                                fields: null,
                                hint: null,
                            }
                        )
                    );

                    this.renderExtensions();
                    return this;
                },
                getNewModal() {
                    return new Backbone.BootstrapModal(
                        {
                            title: '',
                            subtitle: '',
                            content: '',
                            okText: '',
                            okCloses: true,
                        }
                    );
                },
                cleanModal(modal) {
                    // TODO Find why this is used. Probably behats.
                    modal.$('.modal-body').addClass('creation');
                    modal.$('.AknButtonList').remove();
                    modal.$('.AknFullPage-illustration').remove();
                },
                addModalEvent(modal, deferred) {
                    modal.on(
                        'cancel', () => {
                        deferred.reject();
                        modal.remove();
                        }
                    );
                },
                open() {
                    const deferred = $.Deferred();

                    const modal = this.getNewModal();
                    modal.open();

                    this.setElement(modal.$('.modal-body')).render();
                    this.cleanModal(modal);
                    this.addModalEvent(modal, deferred);

                    this.modal = modal;
                    this.def = deferred;
                    return deferred;
                },
                close() {
                    if (null !== this.modal) {
                        this.modal.close();
                    }
                    this.def.resolve();
                },
            }
        );
    }
);
