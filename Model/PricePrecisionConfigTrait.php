<?php

declare(strict_types=1);

namespace SynoptikLabs\PriceDecimal\Model;

trait PricePrecisionConfigTrait
{


    /**
     * @return \SynoptikLabs\PriceDecimal\Model\ConfigInterface
     */
    public function getConfig()
    {
        return $this->moduleConfig;
    }

    /**
     * @return int|mixed
     */
    public function getPricePrecision($currencyCode = 'USD')
    {
        if ($this->getConfig()->canShowPriceDecimal()) {
            return $this->getConfig()->getPricePrecision($currencyCode);
        }

        return 0;
    }
}
