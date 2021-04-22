<?php

/**
 * QR Code
 *
 * Copyright 2021 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once dirname(dirname(dirname(__DIR__))) . '/config.core.php';

require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$modx->getService('qrcode', 'QRCode', $modx->getOption('qrcode.core_path', null, $modx->getOption('core_path') . 'components/qrcode/') . 'model/qrcode/');

if ($modx->qrcode instanceof QRCode) {
    $modx->request->handleRequest([
        'processors_path'   => $modx->qrcode->config['processors_path'],
        'location'          => ''
    ]);
}
