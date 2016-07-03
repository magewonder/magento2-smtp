<?php
namespace MageWonder\Smtp\Controller\Adminhtml\Email;

use Magento\Framework\Object;
use Magento\Framework\Controller\ResultFactory;

class Test extends \Magento\Backend\App\Action
{
    const EMAIL_TEMPLATE_TEST_ID = 'magewonder_smtp_test_template';

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;
    /**
     * @var \MageWonder\Smtp\Helper\Data
     */
    protected $_helper;

    /**
     * Test constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \MageWonder\Smtp\Helper\Data $helper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \MageWonder\Smtp\Helper\Data $helper
    )
    {
        parent::__construct($context);
        $this->_transportBuilder = $transportBuilder;
        $this->_helper           = $helper;
    }

    public function execute()
    {
        $email = $this->getRequest()->getParam('email');
        $this->_transportBuilder->setTemplateIdentifier(self::EMAIL_TEMPLATE_TEST_ID);
        $this->_transportBuilder->setFrom($this->_helper->getTestSender());
        $this->_transportBuilder->addTo($email);
        $this->_transportBuilder->setTemplateVars([]);
        $this->_transportBuilder->setTemplateOptions([
            'area'  => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => 1
        ]);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();

        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData([
            'error' => 0
        ]);
        return $resultJson;
    }
}

