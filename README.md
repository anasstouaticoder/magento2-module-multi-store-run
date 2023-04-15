<h1 style="text-align: center;">Magento 2 Module AnassTouatiCoder MultiStoreRun</h1>
<div style="text-align: center;">
  <p>Dynamically redirect to subdirectories or new domains for websites and storeviews</p>
  <img src="https://img.shields.io/badge/magento-2.2%20|%202.3%20|%202.4-brightgreen.svg?logo=magento&longCache=true&style=flat-square" alt="Supported Magento Versions" />
  <a href="https://packagist.org/packages/anasstouaticoder/magento2-module-multi-store-run" target="_blank"><img src="https://img.shields.io/packagist/v/anasstouaticoder/magento2-module-multi-store-run.svg?style=flat-square" alt="Latest Stable Version" /></a>
  <a href="https://packagist.org/packages/anasstouaticoder/magento2-module-multi-store-run" target="_blank"><img src="https://poser.pugx.org/anasstouaticoder/magento2-module-multi-store-run/downloads" alt="Composer Downloads" /></a>
  <a href="https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity" target="_blank"><img src="https://img.shields.io/badge/maintained%3F-yes-brightgreen.svg?style=flat-square" alt="Maintained - Yes" /></a>
  <a href="https://opensource.org/licenses/MIT" target="_blank"><img src="https://img.shields.io/badge/license-MIT-blue.svg" /></a>
</div>

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
 - Apply database updates by running `php bin/magento setup:upgrade`
 - Flush the cache by running `php bin/magento cache:flush`
 - Do not forget to flush cdn cache or varnish if exist

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require anasstouaticoder/magento2-module-multi-store-run`
 - enable the module by running `php bin/magento module:enable AnassTouatiCoder_MultiStoreRun`
 - apply database updates by running `php bin/magento setup:upgrade`
 - Flush the cache by running `php bin/magento cache:flush`
 - Do not forget to flush cdn cache or varnish if exist

## Specifications
This module make creating subdirectories or new domains for  websites and storeveiws easier, when creating new website or storeview
you do not need to create new subdirectory and new index.php file in /pub,
the module detect the target website or storeview by adding its MAGE_RUN_CODE MAGE_RUN_TYPE in server variable then you will be redirected.
