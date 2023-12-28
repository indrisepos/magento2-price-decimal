<?php

declare(strict_types=1);

namespace SynoptikLabs\PriceDecimal\Model\Plugin;

class CurrencyModel extends PriceFormatPluginAbstract
{

    /**
     * @inheritdoc
     */
    public function beforeFormatPrecision(
        $subject,
        $price,
        $precision,
        $options = [],
        $includeContainer = true,
        $addBrackets = false
    ) {
        if ($this->getConfig()->isEnable()) {
            $precision = $this->getPricePrecision($subject->getCode());
        }

        return [$price, $precision, $options, $includeContainer, $addBrackets];
    }
}
