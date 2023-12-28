<?php

declare(strict_types=1);

namespace SynoptikLabs\PriceDecimal\Model\Plugin;

use SynoptikLabs\PriceDecimal\Model\ConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\State;
use Magento\Framework\App\Area;
use Magento\Sales\Model\OrderFactory as OrderFactory;

class PriceCurrency extends PriceFormatPluginAbstract
{
    /**
     * @var State
     */
    private $state;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var OrderFactory
     */
    private $orderFactory;

    /**
     * PriceCurrency constructor.
     *
     * @param ConfigInterface $moduleConfig
     * @param OrderFactory $orderFactory
     * @param State $state
     * @param RequestInterface $request
     */
    public function __construct(
        ConfigInterface $moduleConfig,
        OrderFactory $orderFactory,
        State $state,
        RequestInterface $request
    ) {
        parent::__construct($moduleConfig);
        $this->state = $state;
        $this->request = $request;
        $this->orderFactory = $orderFactory;
    }

    /**
     *
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function checkArea()
    {
        return $this->state->getAreaCode() == Area::AREA_ADMINHTML;
    }

    /**
     *
     * @return bool
     */
    private function isCreditMemoPage()
    {
        return $this->request->getFullActionName() === 'sales_order_creditmemo_updateQty' ||
            $this->request->getFullActionName() === 'sales_order_creditmemo_save';
    }

    /**
     * @inheritdoc
     */
    public function beforeFormat(
        \Magento\Directory\Model\PriceCurrency $subject,
        $amount,
        $includeContainer = true,
        $precision = \Magento\Directory\Model\PriceCurrency::DEFAULT_PRECISION,
        $scope = null,
        $currency = null
    ) {
        if ($this->getConfig()->isEnable()) {
            $precision = $this->getPricePrecision($currency);
        }

        return [$amount, $includeContainer, $precision, $scope, $currency];
    }

    /**
     * Undocumented function
     *
     * @param \Magento\Directory\Model\PriceCurrency $subject
     * @param float   $amount
     * @param boolean $includeContainer
     * @param int     $precision
     * @param int     $scope
     * @param  string $currency
     * @return array
     */
    public function beforeConvertAndFormat(
        \Magento\Directory\Model\PriceCurrency $subject,
        $amount,
        $includeContainer = true,
        $precision = \Magento\Directory\Model\PriceCurrency::DEFAULT_PRECISION,
        $scope = null,
        $currency = null
    ) {
        if ($this->getConfig()->isEnable()) {
            $currencyCode = $subject->getCurrency()->getCode($scope, $currency);
            $precision = (int)$this->getPricePrecision($currency);
        }

        return [$amount, $includeContainer, $precision, $scope, $currency];
    }

    /**
     * Undocumented function
     *
     * @param \Magento\Directory\Model\PriceCurrency $subject
     * @param float  $amount
     * @param int    $scope
     * @param string $currency
     * @param int    $precision
     * @return array
     */
    public function beforeConvertAndRound(
        \Magento\Directory\Model\PriceCurrency $subject,
        $amount,
        $scope = null,
        $currency = null,
        $precision = \Magento\Directory\Model\PriceCurrency::DEFAULT_PRECISION
    ) {
        if ($this->getConfig()->isEnable()) {
            //add optional args
            // $args[1] = isset($args[1])? $args[1] : null;
            // $args[2] = isset($args[2])? $args[2] : null;
            // $currencyCode = $subject->getCurrency()->getCode($args[1], $args[2]);
            $precision = $this->getPricePrecision($currency);
        }

        return [$amount, $scope, $currency, $precision];
    }
}
