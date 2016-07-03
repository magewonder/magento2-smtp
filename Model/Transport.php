<?php

namespace MageWonder\Smtp\Model;

class Transport implements \Magento\Framework\Mail\TransportInterface
{
    /**
     * @var \MageWonder\Smtp\Model\Message
     */
    protected $_message;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    /**
     * @var \MageWonder\Smtp\Helper\Data
     */
    protected $_helper;

    /**
     * @var Api\Mandrill
     */
    protected $_api;

    /**
     * @param \Magento\Framework\Mail\MessageInterface $message
     * @param \Psr\Log\LoggerInterface $logger
     * @param \MageWonder\Smtp\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\Mail\MessageInterface $message,
        \Psr\Log\LoggerInterface $logger,
        \MageWonder\Smtp\Helper\Data $helper,
        \MageWonder\Smtp\Model\Api $api
    )
    {
        $this->_message = $message;
        $this->_logger  = $logger;
        $this->_helper  = $helper;
        $this->_api     = $api;
    }

    public function sendMessage()
    {
        $message = [
            'subject'    => $this->_message->getSubject(),
            'from_name'  => $this->_message->getFromName(),
            'from_email' => $this->_message->getFrom(),
        ];

        foreach($this->_message->getTo() as $to)
        {
            $message['to'][] = [
                'email' => $to
            ];
        }

        foreach($this->_message->getBcc() as $bcc)
        {
            $message['to'][] = [
                'email' => $bcc,
                'type'  => 'bcc'
            ];
        }

        if($att = $this->_message->getAttachments())
        {
            $message['attachments'] = $att;
        }

        if($headers = $this->_message->getHeaders())
        {
            $message['headers'] = $headers;
        }

        switch($this->_message->getType())
        {
            case \Magento\Framework\Mail\MessageInterface::TYPE_HTML:
                $message['html'] = $this->_message->getBody();
                break;
            case \Magento\Framework\Mail\MessageInterface::TYPE_TEXT:
                $message['text'] = $this->_message->getBody();
                break;
        }

        $this->_api->send($message);
        return true;
    }
}
