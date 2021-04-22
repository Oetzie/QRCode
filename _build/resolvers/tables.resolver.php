<?php

/**
 * QR Code
 *
 * Copyright 2021 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modx->addPackage('qrcode', $modx->getOption('qrcode.core_path', null, $modx->getOption('core_path') . 'components/qrcode/') . 'model/');

            $manager = $modx->getManager();

            $manager->createObjectContainer('QRCodeCode');

            break;
    }
}

return true;
