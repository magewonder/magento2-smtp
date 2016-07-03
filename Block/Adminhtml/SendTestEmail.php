<?php
namespace MageWonder\Smtp\Block\Adminhtml;

class SendTestEmail extends \Magento\Config\Block\System\Config\Form\Field
{
    protected $_template = 'sendemail.phtml';

    /**
     * @codeCoverageIgnore
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $originalData = $element->getOriginalData();

        $label = $originalData['button_label'];

        $this->addData([
            'button_label' => __($label),
            'button_url'   => $this->getUrl('magewondersmtp/email/test'),
            'html_id'      => $element->getHtmlId(),
        ]);
        return $this->_toHtml();
    }
}
