<?php

declare(strict_types=1);

namespace SynoptikLabs\PriceDecimal\Model;

use Magento\Framework\CurrencyInterface;
use Magento\Framework\Currency as MagentoCurrency;
use SynoptikLabs\PriceDecimal\Model\ConfigInterface;

/** @method getPricePrecision */
class Currency extends MagentoCurrency implements CurrencyInterface
{

    use PricePrecisionConfigTrait;

    /**
     * @var \SynoptikLabs\PriceDecimal\Model\ConfigInterface
     */
    public $moduleConfig;

    /**
     * Currency constructor.
     *
     * @param \Magento\Framework\App\CacheInterface            $appCache
     * @param \SynoptikLabs\PriceDecimal\Model\ConfigInterface $moduleConfig
     * @param null                                             $options
     * @param null                                             $locale
     */
    public function __construct(
        \Magento\Framework\App\CacheInterface $appCache,
        ConfigInterface $moduleConfig,
        $options = null,
        $locale = null
    ) {
        $this->moduleConfig = $moduleConfig;
        parent::__construct($appCache, $options, $locale);
    }

    /**
     * Return currency code
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->_options['currency'];
    }
}
