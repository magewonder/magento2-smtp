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
            $from    = new \SendGrid\Email($message['from_name'], $message['from_email']);
            $subject = $message['subject'];
            $content = new \SendGrid\Content('text/plain', isset($message['text']) ? $message['text'] : '');
            if (isset($message['html']))
            {
                $content = new \SendGrid\Content('text/html', $message['html']);
            }
            foreach ($message['to'] as $to)
            {
                $_to  = new \SendGrid\Email(null, $to['email']);
                $mail = new \SendGrid\Mail($from, $subject, $_to, $content);
                $this->_api->client->mail()->send()->post($mail);
            }
            return true;
        }
    }

}

