<?php

namespace MageWonder\Smtp\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ACTIVE   = 'magewondersmtp/general/active';
    const XML_PATH_PROVIDER = 'magewondersmtp/general/provider';
    const XML_PATH_APIKEY   = 'magewondersmtp/general/apikey';
    const SENDER_IDENTITY   = 'checkout/payment_failed/identity';

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;


    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    )
    {
        $this->_logger = $context->getLogger();
        parent::__construct($context);
    }

    public function getApiKey($store = null)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_APIKEY, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
    }

    public function getProvider($store = null)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_PROVIDER, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
    }

    public function isActive($store = null)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ACTIVE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * @codeCoverageIgnore
     */
    public function log($msg)
    {
        $this->_logger->info($msg);
    }

    public function getTestSender()
    {
        return $this->scopeConfig->getValue(
            self::SENDER_IDENTITY,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
