<?php

declare(strict_types=1);

namespace SynoptikLabs\PriceDecimal\Model;

use SynoptikLabs\PriceDecimal\Model\ConfigInterface;

trait PricePrecisionConfigTrait
{


    /**
     *
     * @return \SynoptikLabs\PriceDecimal\Model\ConfigInterface
     */
    public function getConfig()
    {
        return $this->moduleConfig;
    }

    /**
     *
     * @param string $currencyCode
     * @return int|mixed
     */
    public function getPricePrecision($currencyCode = 'USD')
    {
        if ($this->getConfig()->canShowPriceDecimal()) {
	    return (int)$this->getConfig()->getPricePrecision();
        }

        return 0;
    }
}
