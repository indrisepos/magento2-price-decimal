<?php

declare(strict_types=1);

namespace SynoptikLabs\PriceDecimal\Test\Unit\Plugin\Model;

use SynoptikLabs\PriceDecimal\Model\ConfigInterface;
use SynoptikLabs\PriceDecimal\Model\Plugin\PriceCurrency;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class PriceCurrencyTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var function
     */
    private $closureMock;

    /**
     * @var null|object|MockObject
     */
    private $priceCurrencyMock;

    protected function setUp()
    {
        $this->closureMock = function (...$args) {
            return number_format($args[0], $args[2]);
        };

        $this->priceCurrencyMock = $this->getMockBuilder('Magento\Directory\Model\PriceCurrency')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     *
     */
    public function testAroundFormat()
    {

        $price = 22.54;
        $args = [
            $price,
            true,
            2
        ];

        $pricePrecision = 2;

        $configMock = $this->getMockBuilder(
            ConfigInterface::class
        )->disableOriginalConstructor()
            ->setMethods(['isEnable', 'getScopeConfig', 'canShowPriceDecimal', 'getPricePrecision'])
            ->getMock();

        $configMock->expects($this->any())->method('isEnable')->willReturn(1);
        $configMock->expects($this->any())->method('canShowPriceDecimal')->willReturn(1);
        $configMock->expects($this->any())->method('getPricePrecision')->willReturn($pricePrecision);

        $objectManager = new ObjectManager($this);
        $model = $objectManager->getObject(
            PriceCurrency::class,
            [
                'moduleConfig' => $configMock
            ]
        );

        $result = $model->aroundFormat(
            $this->priceCurrencyMock,
            $this->closureMock,
            ...$args
        );

        $this->assertEquals(number_format($args[0], $args[2]), $result);
    }
}
