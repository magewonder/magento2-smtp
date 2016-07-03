<?php

namespace MageWonder\Smtp\Model\Config\Source;

class Provider implements \Magento\Framework\Option\ArrayInterface
{
    const PROVIDER_SENDGRID = 'sendgrid';

    protected $_options = null;

    public function toOptionArray()
    {
        return [
            [
                'label' => 'Sendgird',
                'value' => self::PROVIDER_SENDGRID
            ],
        ];
    }

}

