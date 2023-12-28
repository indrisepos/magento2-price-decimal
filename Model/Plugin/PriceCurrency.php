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
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function checkArea()
    {
        return $this->state->getAreaCode() == Area::AREA_ADMINHTML;
    }

    /**
     * @return bool
     */
    private function isCreditMemoPage()
    {
        return $this->request->getFullActionName() === 'sales_order_creditmemo_updateQty' ||
            $this->request->getFullActionName() === 'sales_order_creditmemo_save';
    }


    /**
     * {@inheritdoc}
     */
    public function beforeFormat(
        \Magento\Directory\Model\PriceCurrency $subject,
        ...$args
    ) {
        if ($this->getConfig()->isEnable()) {
            // add the optional arg
            if (!isset($args[1])) {
                $args[1] = true;
            }
            // Precision argument
            // Precision argument
            $args[3] = isset($args[3])? $args[3] : null;
            $args[4] = isset($args[4])? $args[4] : null;
            $currencyCode = $subject->getCurrency()->getCode($args[3], $args[4]);
            $args[2] = $this->getPricePrecision($currencyCode);

        }

        return $args;
    }

    /**
     * @param \Magento\Directory\Model\PriceCurrency $subject
     * @param callable $proceed
     * @param $price
     * @param array ...$args
     * @return float
     */
    public function aroundRound(
        \Magento\Directory\Model\PriceCurrency $subject,
        callable $proceed,
        $price,
        ...$args
    ) {
        if ($this->getConfig()->isEnable()) {
            $currencyCode = $subject->getCurrency()->getCode();
            if ($this->checkArea() && ($this->isCreditMemoPage())) {
                $orderId = $this->request->getParam('order_id');
                if ($orderId) {
                    $order = $this->orderFactory->create()->load($orderId);
                    if ($order->getId()) {
                        $currencyCode = $order->getBaseCurrencyCode();
                    }
                }
            }
            return round($price, $this->getPricePrecision($currencyCode));
        } else {
            return $proceed($price);
        }

    }

    /**
     * @param \Magento\Directory\Model\PriceCurrency $subject
     * @param array ...$args
     * @return array
     */
    public function beforeConvertAndFormat(
        \Magento\Directory\Model\PriceCurrency $subject,
        ...$args
    ) {
        if ($this->getConfig()->isEnable()) {
            // add the optional args
            $args[1] = isset($args[1])? $args[1] : null;
            $args[3] = isset($args[3])? $args[3] : null;
            $args[4] = isset($args[4])? $args[4] : null;
            $currencyCode = $subject->getCurrency()->getCode($args[3], $args[4]);
            $args[2] = intval($this->getPricePrecision($currencyCode));
        }

        return $args;

    }

    /**
     * @param \Magento\Directory\Model\PriceCurrency $subject
     * @param array ...$args
     * @return array
     */
    public function beforeConvertAndRound(
        \Magento\Directory\Model\PriceCurrency $subject,
        ...$args
    ) {
        if ($this->getConfig()->isEnable()) {
            //add optional args
            $args[1] = isset($args[1])? $args[1] : null;
            $args[2] = isset($args[2])? $args[2] : null;
            $currencyCode = $subject->getCurrency()->getCode($args[1], $args[2]);
            $args[3] = $this->getPricePrecision($currencyCode);
        }

        return $args;

    }
}
