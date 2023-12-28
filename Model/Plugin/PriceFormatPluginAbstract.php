<?php

declare(strict_types=1);

namespace SynoptikLabs\PriceDecimal\Model\Plugin;

use SynoptikLabs\PriceDecimal\Model\ConfigInterface;
use SynoptikLabs\PriceDecimal\Model\PricePrecisionConfigTrait;

abstract class PriceFormatPluginAbstract
{

    use PricePrecisionConfigTrait;

    /** @var ConfigInterface  */
    protected $moduleConfig;

    /**
     * @param \SynoptikLabs\PriceDecimal\Model\ConfigInterface $moduleConfig
     */
    public function __construct(
        ConfigInterface $moduleConfig
    ) {
        $this->moduleConfig  = $moduleConfig;
    }
}
