<?php

/**
 * QR Code
 *
 * Copyright 2021 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class QRCodeCode extends xPDOSimpleObject
{
    const IMAGE_API_URL = 'https://chart.googleapis.com/chart';

    /**
     * @access public.
     * @return String.
     */
    public function getImage()
    {
        $object = $this->xpdo->getObject('modResource', [
            'id' => $this->get('resource_id')
        ]);

        if ($object) {
            $context = $this->xpdo->getObject('modContext', [
                'key' => $object->get('context_key')
            ]);

            if ($context && $context->prepare()) {
                $url        = $context->getOption('site_url');
                $base       = $context->getOption('base_url', null, '/');
                $url        = rtrim(rtrim($url, $base), '/') . '/qrcode?id=' . $this->get('id');

                if ($this->get('utm_source') === 'qr') {
                    $curl = curl_init();

                    curl_setopt_array($curl, [
                        CURLOPT_URL             => rtrim(self::IMAGE_API_URL, '/') . '?' . http_build_query([
                            'chs'   => '300x300',
                            'cht'   => 'qr',
                            'chl'   => $url,
                            'choe'  => 'UTF-8'
                        ]),
                        CURLOPT_RETURNTRANSFER  => true,
                        CURLOPT_CONNECTTIMEOUT  => 10
                    ]);

                    $response       = curl_exec($curl);
                    $responseInfo   = curl_getinfo($curl);

                    if (isset($responseInfo['http_code']) && (int) $responseInfo['http_code'] === 200) {
                        return $response;
                    }
                }
            }
        }

        return null;
    }
}
