<?php

declare(strict_types=1);

namespace SynoptikLabs\PriceDecimal\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config implements ConfigInterface
{

    public const XML_PATH_PRICE_PRECISION
        = 'catalog_price_decimal/general/price_precision';

    public const XML_PATH_CAN_SHOW_PRICE_DECIMAL
        = 'catalog_price_decimal/general/can_show_decimal';

    public const XML_PATH_GENERAL_ENABLE
        = 'catalog_price_decimal/general/enable';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    protected $scopeResolver;

    protected $currencyPrecisions;

    /**
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\App\ScopeResolverInterface $scopeResolver
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\ScopeResolverInterface $scopeResolver
    ) {

        $this->scopeConfig = $scopeConfig;
        $this->scopeResolver = $scopeResolver;
    }

    /**
     *
     * @return \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public function getScopeConfig()
    {
        return $this->scopeConfig;
    }

    /**
     * Return Config Value by XML Config Path
     *
     * @param string $path
     * @param string $scopeType
     *
     * @return mixed
     */
    public function getValueByPath($path, $scopeType = 'website')
    {
        return $this->getScopeConfig()->getValue($path, $scopeType);
    }

    /**
     *
     * @return mixed
     */
    public function isEnable()
    {
        return $this->getValueByPath(self::XML_PATH_GENERAL_ENABLE, 'website');
    }

    /**
     *
     * @return mixed
     */
    public function canShowPriceDecimal()
    {
        return $this->getValueByPath(self::XML_PATH_CAN_SHOW_PRICE_DECIMAL, 'website');
    }

    /**
     * Return Price precision from store config
     *
     * @return mixed
     */
    public function getPricePrecision()
    {
        if (!$this->currencyPrecisions) {
            $rawValues = $this->getValueByPath(self::XML_PATH_PRICE_PRECISION, 'website');
            $result = [];
            $rawValues = explode(',', $rawValues);
            foreach ($rawValues as $value) {
                $values = explode(':', $value);
                if (count($values) == 2) {
                    $result[trim($values[0])] = trim($values[1]);
                }
            }
            $this->currencyPrecisions = $result;
        }
        if (!$currencyCode) {
            $currencyCode = $this->scopeResolver->getScope()->getCurrentCurrency()->getCurrencyCode();
        }
        if (isset($this->currencyPrecisions[$currencyCode])) {
            return (int)$this->currencyPrecisions[$currencyCode];
        }
        return \Magento\Framework\Pricing\PriceCurrencyInterface::DEFAULT_PRECISION;
    }
}
