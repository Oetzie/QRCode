<?php

/**
 * QR Code
 *
 * Copyright 2021 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class QRCodeCodeDownloadProcessor extends modObjectProcessor
{
    /**
     * @access public.
     * @var String.
     */
    public $classKey = 'QRCodeCode';

    /**
     * @access public.
     * @var Array.
     */
    public $languageTopics = ['qrcode:default'];

    /**
     * @access public.
     * @var String.
     */
    public $objectType = 'qrcode.code';

    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('qrcode', 'QRCode', $this->modx->getOption('qrcode.core_path', null, $this->modx->getOption('core_path') . 'components/qrcode/') . 'model/qrcode/');

        return parent::initialize();
    }

    /**
     * @access public.
     * @return String.
     */
    public function process()
    {
        $object = $this->modx->getObject($this->classKey, [
            'id' => $this->getProperty('id')
        ]);

        if ($object) {
            if ($image = $object->getImage()) {
                header('Content-Disposition: attachment; filename="' . $object->get('utm_source') . '.png"');
                header('Content-Type: image/png');

                return $image;
            }
        }

        return $this->failure($this->modx->lexicon('qrcode.qrcode_failure'));
    }
}

return 'QRCodeCodeDownloadProcessor';
