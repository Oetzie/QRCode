<?php

/**
 * QR Code
 *
 * Copyright 2021 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

require_once __DIR__ . '/qrcode.class.php';

class QRCodePlugins extends QRCode
{
    /**
     * @access public.
     */
    public function onHandleRequest()
    {
        if ($this->modx->context->get('key') !== 'mgr') {
            $uri = '';

            if (isset($_GET[$this->modx->getOption('request_param_alias', null, 'q')])) {
                $uri = $_GET[$this->modx->getOption('request_param_alias', null, 'q')];
            }

            if (isset($_GET['id']) && $uri === 'qrcode') {
                $object = $this->modx->getObject('QRCodeCode', [
                    'id' => $_GET['id']
                ]);

                if ($object) {
                    $resource = $this->modx->getObject('modResource', [
                        'id'        => $object->get('resource_id'),
                        'published' => 1,
                        'deleted'   => 0
                    ]);

                    if ($resource) {
                        $redirect = $this->modx->makeUrl($resource->get('id'), null, [
                            'utm_source'    => $object->get('utm_source'),
                            'utm_medium'    => $object->get('utm_medium'),
                            'utm_campaign'  => $object->get('utm_campaign')
                        ], 'full');

                        if ($redirect) {
                            $this->modx->sendRedirect($redirect);
                        }
                    }
                }
            }
        }
    }

    /**
     * @access public.
     * @param Array $properties.
     */
    public function onDocFormRender(array $properties = [])
    {
        if ($properties['mode'] === 'upd') {
            if ($this->modx->hasPermission('qrcode')) {
                $this->modx->regClientStartupScript($this->config['js_url'] . '/mgr/qrcode.js');

                $this->modx->regClientStartupHTMLBlock('<script type="text/javascript">
                    Ext.onReady(function() {
                        QRCode.config = ' . $this->modx->toJSON(array_merge($this->config, [
                            'branding_url'          => $this->getBrandingUrl(),
                            'branding_url_help'     => $this->getHelpUrl()
                        ])) . ';
                    });
                </script>');

                $this->modx->regClientStartupScript($this->config['js_url'] . '/mgr/widgets/qrcode.panel.js');

                if (is_array($this->config['lexicons'])) {
                    foreach ($this->config['lexicons'] as $lexicon) {
                        $this->modx->controller->addLexiconTopic($lexicon);
                    }
                } else {
                    $this->modx->controller->addLexiconTopic($this->config['lexicons']);
                }
            }
        }
    }
}
