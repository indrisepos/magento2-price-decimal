<?php

declare(strict_types=1);

namespace SynoptikLabs\PriceDecimal\Model\Plugin\Local;

use SynoptikLabs\PriceDecimal\Model\Plugin\PriceFormatPluginAbstract;
use SynoptikLabs\PriceDecimal\Model\ConfigInterface;

class Format extends PriceFormatPluginAbstract
{
    /**
     * @var \Magento\Framework\App\ScopeResolverInterface
     */
    protected $scopeResolver;

    /**
     * @param \SynoptikLabs\PriceDecimal\Model\ConfigInterface $moduleConfig
     * @param \Magento\Framework\App\ScopeResolverInterface $scopeResolver
     */
    public function __construct(
        ConfigInterface $moduleConfig,
        \Magento\Framework\App\ScopeResolverInterface $scopeResolver
    ) {
        parent::__construct($moduleConfig);
        $this->scopeResolver = $scopeResolver;
    }

    /**
     * @inheritdoc
     *
     * @param object $subject
     * @param array  $result
     *
     * @return mixed
     */
    public function afterGetPriceFormat($subject, $result)
    {
        $currencyCode = null;
        if (isset($args[1])) {
            $currencyCode = $args[1];
        }
        if (!$currencyCode) {
            $currencyCode = $this->scopeResolver->getScope()->getCurrentCurrency()->getCurrencyCode();
        }

        $precision = $this->getPricePrecision($currencyCode);
        if ($this->getConfig()->isEnable()) {
            $result['precision'] = $precision;
            $result['requiredPrecision'] = $precision;
        }

        return $result;
    }
}
