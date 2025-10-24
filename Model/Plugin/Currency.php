<?php

declare(strict_types=1);

namespace SynoptikLabs\PriceDecimal\Model\Plugin;

class Currency extends PriceFormatPluginAbstract
{

    /**
     * @inheritdoc
     *
     * @param \Magento\Framework\CurrencyInterface $subject
     * @param array                                ...$arguments
     *
     * @return array
     */
    public function beforeToCurrency(
        \SynoptikLabs\PriceDecimal\Model\Currency $subject,
        ...$arguments
    ) {
        if ($this->getConfig()->isEnable()) {
	    $arguments[1]['precision'] = (int) $subject->getPricePrecision($subject->getCurrencyCode());
        }
        return $arguments;
    }
}
