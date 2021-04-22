<?php

/**
 * QR Code
 *
 * Copyright 2021 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class QRCodeCodeCreateProcessor extends modObjectProcessor
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
            'resource_id'   => $this->getProperty('resource_id'),
            'utm_source'    => $this->getProperty('utm_source'),
            'utm_medium'    => $this->getProperty('utm_medium'),
            'utm_campaign'  => $this->getProperty('utm_campaign')
        ]);

        if (!$object) {
            $object = $this->modx->newObject($this->classKey);
        }

        if ($object) {
            $object->fromArray([
                'resource_id'   => $this->getProperty('resource_id'),
                'utm_source'    => $this->getProperty('utm_source'),
                'utm_medium'    => $this->getProperty('utm_medium'),
                'utm_campaign'  => $this->getProperty('utm_campaign')
            ]);

            if ($object->save()) {
                return $this->success($this->modx->lexicon('qrcode.qrcode_success'), $object);
            }
        }

        return $this->failure($this->modx->lexicon('qrcode.qrcode_failure'));
    }
}

return 'QRCodeCodeCreateProcessor';
