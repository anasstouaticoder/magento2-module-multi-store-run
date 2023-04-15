# Mage2 Module AnassTouatiCoder MultiStoreRun

    ``anasstouaticoder/magento2-module-multi-store-run``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Specifications](#markdown-header-specifications)

## Main Functionalities

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/AnassTouatiCoder`
 - Enable the module by running `php bin/magento module:enable AnassTouatiCoder_MultiStoreRun`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require anasstouaticoder/magento2-module-multi-store-run`
 - enable the module by running `php bin/magento module:enable AnassTouatiCoder_MultiStoreRun`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

## Specifications
This module make creating subdirectory websites and storeveiws easier, when creating new website or storeview
you do not need to create new subdirectory and new index.php file in /pub,
the module detect the target website or storeview by adding its MAGE_RUN_CODE MAGE_RUN_TYPE in server variable then you will be redirected.
