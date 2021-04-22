var QRCode = function(config) {
    config = config || {};

    QRCode.superclass.constructor.call(this, config);
};

Ext.extend(QRCode, Ext.Component, {
    page    : {},
    window  : {},
    grid    : {},
    tree    : {},
    panel   : {},
    combo   : {},
    config  : {}
});

Ext.reg('qrcode', QRCode);

QRCode = new QRCode();