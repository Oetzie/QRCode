Ext.extend(QRCode, Ext.Component, {
    setButton: function() {
        var toolbar = Ext.getCmp('modx-action-buttons');

        if (toolbar) {
            toolbar.insertButton(0, [{
                text    : '<i class="icon icon-qrcode"></i> ' + _('qrcode'),
                handler : QRCode.createQRCode
            }]);

            toolbar.doLayout();
        }
    },
    createQRCode: function(btn, e) {
        if (QRCode.window.createQRCodeWindow) {
            QRCode.window.createQRCodeWindow.destroy();
        }

        QRCode.window.createQRCodeWindow = MODx.load({
            xtype       : 'qrcode-window-create',
            record      : {
                resource_id : MODx.request.id,
                utm_source  : 'qr'
            },
            closeAction : 'close',
            listeners   : {
                'success'   : {
                    fn          : function (data) {
                        MODx.msg.status({
                            title   : _('success'),
                            message : data.a.result.message
                        });

                        window.location = QRCode.config.connector_url + '?action=mgr/qrcodes/download&id=' + data.a.result.object.id + '&HTTP_MODAUTH=' + MODx.siteId;
                    },
                    scope      : this
                }
            }
        });

        QRCode.window.createQRCodeWindow.setValues({
            resource_id : MODx.request.id,
            utm_source  : 'qr'
        });
        QRCode.window.createQRCodeWindow.show(e.target);
    },
});

QRCode.window.CreateQRCode = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        autoHeight  : true,
        title       : _('qrcode'),
        url         : QRCode.config.connector_url,
        baseParams  : {
            action      : 'mgr/qrcodes/create'
        },
        fields      : [{
            xtype       : 'hidden',
            name        : 'resource_id'
        }, {
            xtype       : 'hidden',
            name        : 'utm_source'
        }, {
            xtype       : 'textfield',
            fieldLabel  : _('qrcode.label_utm_medium'),
            description : MODx.expandHelp ? '' : _('qrcode.label_utm_medium_desc'),
            name        : 'utm_medium',
            anchor      : '100%'
        }, {
            xtype       : MODx.expandHelp ? 'label' : 'hidden',
            html        : _('qrcode.label_utm_medium_desc'),
            cls         : 'desc-under'
        }, {
            xtype       : 'textfield',
            fieldLabel  : _('qrcode.label_utm_campaign'),
            description : MODx.expandHelp ? '' : _('qrcode.label_utm_campaign_desc'),
            name        : 'utm_campaign',
            anchor      : '100%'
        }, {
            xtype       : MODx.expandHelp ? 'label' : 'hidden',
            html        : _('qrcode.label_utm_campaign_desc'),
            cls         : 'desc-under'
        }]
    });

    QRCode.window.CreateQRCode.superclass.constructor.call(this, config);
};

Ext.extend(QRCode.window.CreateQRCode, MODx.Window);

Ext.reg('qrcode-window-create', QRCode.window.CreateQRCode);

Ext.onReady(function() {
    QRCode.setButton();
});