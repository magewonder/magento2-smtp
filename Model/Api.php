<?php

namespace MageWonder\Smtp\Model;

use MageWonder\Smtp\Model\Config\Source\Provider;

class Api
{
    protected $_api;
    protected $_apiKey;
    protected $_provider;

    public function __construct(
        \MageWonder\Smtp\Helper\Data $helper
    )
    {
        $this->_apiKey   = $helper->getApiKey();
        $this->_provider = $helper->getProvider();

        if ($this->_provider == Provider::PROVIDER_SENDGRID)
        {
            if (!empty($this->_apiKey))
            {
                $this->_api = new \SendGrid($this->_apiKey);
            }
        }
    }

    public function send($message)
    {
        if ($this->_provider == Provider::PROVIDER_SENDGRID)
        {
            return $this->_api->client->mail()->send()->post($message);
        }
    }

}

