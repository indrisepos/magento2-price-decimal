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
     * @var array
     */
    public $_options;

    /**
     * Currency constructor.
     *
     * @param \Magento\Framework\App\CacheInterface            $appCache
     * @param \SynoptikLabs\PriceDecimal\Model\ConfigInterface $moduleConfig
     * @param array|string|null                                $options
     * @param string|null                                      $locale
     */
    public function __construct(
        \Magento\Framework\App\CacheInterface $appCache,
        ConfigInterface $moduleConfig,
        $options = null,
        $locale = null
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->_options = $options;
        parent::__construct($appCache, $options, $locale);
    }

    /**
     * Return currency code
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        if(is_array($this->_options))
            return $this->_options['currency'];
        else
            return "";
    }
}
