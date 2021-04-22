<?php
/**
 * QR Code
 *
 * Copyright 2021 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

if (in_array($modx->event->name, ['OnHandleRequest', 'OnDocFormRender'], true)) {
    $instance = $modx->getService('qrcodeplugins', 'QRCodePlugins', $modx->getOption('qrcode.core_path', null, $modx->getOption('core_path') . 'components/qrcode/') . 'model/qrcode/');

    if ($instance instanceof QRCodePlugins) {
        $method = lcfirst($modx->event->name);

        if (method_exists($instance, $method)) {
            $instance->$method($scriptProperties);
        }
    }
}