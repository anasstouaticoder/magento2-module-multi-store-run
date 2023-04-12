<?php
/**
 * Copyright (c) 2018
 * MIT License
 * Module AnassTouatiCoder_MultiStoreRun
 * Author Anass TOUATI anass1touati@gmail.com
 */
declare(strict_types=1);

namespace AnassTouatiCoder\MultiStoreRun\App;

use Magento\Framework\App\Bootstrap as MagentoBootstrap;
use Magento\Framework\App\ObjectManagerFactory;

class Bootstrap extends MagentoBootstrap
{
    /**
     * @inheritdoc
     */
    public static function create($rootDir, array $initParams, ObjectManagerFactory $factory = null)
    {
        self::populateAutoloader($rootDir, $initParams);
        if ($factory === null) {
            $factory = self::createObjectManagerFactory($rootDir, $initParams);
            $objectManager = $factory->create($initParams);
            $deploymentConfig =$objectManager->get(\Magento\Framework\App\DeploymentConfig::class);
            RunStoreManager::getInstance($factory, $deploymentConfig, $initParams);
        }
        return new self($factory, $rootDir, $initParams);
    }
}
