### Credits

This repository is based on [Synoptik-Labs/magento2-price-decimal](https://github.com/Synoptik-Labs/magento2-price-decimal), with additional improvements merged from multiple community forks.

**Original work:** [lillik/magento2-price-decimal](https://github.com/lillik/magento2-price-decimal)

**Additional contributions from:**
- [i2btech](https://github.com/i2btech/magento2-price-decimal) - PHP 8.4 compatibility
- [pfortin-expertime](https://github.com/pfortin-expertime/magento2-price-decimal) - Additional fixes
- [fritzmg](https://github.com/fritzmg/magento2-price-decimal) - PHP 8.3 compatibility

### Introduction

The **«Price Decimal Precision»** Magento 2 extension allows a store administrator to setup a custom display decimal precision for the prices and other currency values (discounts, taxes, sales amounts, etc.) both for the frontend and the backend areas.
The price display settings are individual per currency and per store.
The extension supports an unlimited number of currencies.

![General Config](docs/images/general_config.png "Magento 2 Price Decimal Precision")

The **«Price Decimal Precision»** extension allows you to change or delete the decimal number (precision) in a price, that is displayed in the front office of your store. The extentension supports multi store and multi website configuration and can be useful in managing multiwebsites / multisore shops. The ** "Price Decimal Precision" ** extension is a free and fully configurable and  can be helpful for your business.

### What can the extension do for you?
###### Remove decimal precision from price
![Screenshot 1](docs/images/screenshot_1.png "Magento 2 Price Decimal Precision")
###### Price with one decimal precision
![Screenshot 2](docs/images/screenshot_2.png "Magento 2 Price Decimal Precision")

### Features
- Free and open source and fully configurable extension;
- Easy to install and unistall;
- Easy to configurate;
- Remove or change the price precision from a specific website or store;
- Supports English translation.

### Installation
The preferred way of installing synoptik-labs/magento2-price-decimal is through Composer. Simply add synoptik-labs/magento2-price-decimal as a dependency:

```bash
composer require indrisepos/magento2-price-decimal
```

### Configuration

```
Stores -> Configuration -> Catalog
```

### Contribution
Open a bug report in GitHub's [issue tracker](https://github.com/synoptik-labs/magento2-price-decimal/issues).

### License
The code is licensed under [Apache-2.0 License](https://www.apache.org/licenses/LICENSE-2.0).
