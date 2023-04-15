<?php
/**
 * Copyright (c) 2023
 * MIT License
 * Module AnassTouatiCoder_MultiStoreRun
 * Author Anass TOUATI anass1touati@gmail.com
 */
declare(strict_types=1);

namespace AnassTouatiCoder\MultiStoreRun\App;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ObjectManagerFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManager;

/**
 * Class RunCodeManager
 */
class RunStoreManager
{
    const CONFIG_DATA_TABLE = 'core_config_data';
    const CONFIG_BASE_URL_PATH = 'web/secure/base_url';
    const CONFIG_SCOPE_ID = 'scope_id';
    const CONFIG_SCOPE= 'scope';
    const VALUE_SCOPE= 'value';

    /** @var array  */
    protected $initParams = [];

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var RunStoreManager
     */
    protected static $instance = null;

    /** @var string  */
    protected $scopeType;
    /**
     * @var mixed|string
     */
    protected $baseURL;

    /**
     * RunCodeManager constructor.
     *
     * PHP_SELF & SCRIPT_NAME adjustments to remove website folder from root directory
     * MAGE_RUN_CODE adjustments
     * MAGE_RUN_TYPE adjustments
     *
     * @param ObjectManagerFactory|null $factory
     * @param array $initParams
     */
    private function __construct($factory, $initParams)
    {
        $this->initParams = $initParams;
        $this->objectManager = $factory->create($this->initParams);
        $deploymentConfig = $this->objectManager->get(\Magento\Framework\App\DeploymentConfig::class);

        $scopeId = $this->retrieveId($this->getFullURL($this->initParams));
        $runCode = '';

        if ($scopeId !== false) {
            $runCode = $this->getCodeById($scopeId > 0 ? $scopeId : 1);

            $subDirectory = $this->prepareSubDirectory($this->baseURL);
            if ($this->baseURL && $subDirectory) {
                $this->initParams['SCRIPT_NAME'] = "/{$subDirectory}/index.php";
                $this->initParams['PHP_SELF'] = "/{$subDirectory}/index.php";
            }
        } else {
            // Get admin frontName from env.php or config.php file
            $backendFrontName = $deploymentConfig->get('backend/frontName');
            // Using strpos instead of contains to stay compatible with old PHP versions
            $subdomain = parse_url($this->initParams['REQUEST_URI'], PHP_URL_PATH);
            if (strpos($subdomain, '/' . $backendFrontName)!== false ||
                strpos($this->initParams['SERVER_NAME'], 'admin')!== false) {
                $runCode = 'admin';
            }
            // if you don't want to manage default home page
            // else {

            // header('HTTP/1.0 404 Not Found');
            // exit;
            //}
        }
        $this->initParams[\Magento\Store\Model\StoreManager::PARAM_RUN_CODE] = $runCode ?: 'base';
        $this->initParams[\Magento\Store\Model\StoreManager::PARAM_RUN_TYPE] = $this->scopeType ?: 'website';

        $_SERVER = $this->initParams;
    }
    /**
     * Main entry
     *
     * @param ObjectManagerFactory|null $factory
     * @param array $initParams
     *
     * @return array
     */
    public static function getUpdatedInitParams($factory, $initParams)
    {
        if (self::$instance === null) {
            self::$instance = new self($factory, $initParams);
        }

        return self::$instance->initParams;
    }

    /**
     * Build full url from request
     *
     * @param array $initParams
     * @return string
     */
    protected function getFullURL($initParams)
    {
        $requestedDomain = $initParams['HTTP_HOST'];
        $subdomain = parse_url($initParams['REQUEST_URI'], PHP_URL_PATH);
        return $initParams['HTTP_X_FORWARDED_PROTO'] . '://' . $requestedDomain . $subdomain;
    }

    /**
     * Get website code by id
     *
     * @param int $id
     * @return string
     */
    protected function getCodeById($id)
    {
        $code = '';
        $storeManager = $this->objectManager->get(StoreManager::class);
        if ($this->scopeType === ScopeInterface::SCOPE_WEBSITE) {
            /** @var StoreManager $storeManager */
            /** @var \Magento\Store\Api\Data\WebsiteInterface[] $websites */
            $websites = $storeManager->getWebsites(true, false);
            $code = $websites[$id]->getCode();
        } elseif ($this->scopeType === ScopeInterface::SCOPE_STORE) {
            $stores = $storeManager->getStores(true, false);
            $code = $stores[$id]->getCode();
        }

        return $code;
    }

    /**
     * Retrieve Website ID from Database
     *
     * @param string $domain
     * @return int
     */
    protected function retrieveId($domain)
    {
        /** @var \Magento\Framework\App\ResourceConnection $resource */

        $resource = $this->objectManager->get(ResourceConnection::class);

        $connection = $resource->getConnection();
        $query = $connection->select()
            ->from(
                ['config' => $resource->getTableName(self::CONFIG_DATA_TABLE)],
                [self::CONFIG_SCOPE, self::CONFIG_SCOPE_ID, self::VALUE_SCOPE]
            )
            ->where('config.path = ?', self::CONFIG_BASE_URL_PATH)
            ->where(new \Zend_Db_Expr('LOCATE(value, ?) = 1'), $domain)
            ->order('LENGTH(config.value) DESC')
            ->limit(1);

        $data = $connection->fetchRow($query);
        $id = false;
        if ($data) {
            $id = $data[self::CONFIG_SCOPE_ID];
            $this->scopeType = $data[self::CONFIG_SCOPE] === ScopeInterface::SCOPE_STORES
                ? ScopeInterface::SCOPE_STORE
                : ScopeInterface::SCOPE_WEBSITE;
            $this->baseURL = $data[self::VALUE_SCOPE];
        }

        return $id;
    }

    /**
     * Prepare base URL for website
     *
     * @param string $baseURL
     * @return string
     */
    private function prepareSubDirectory($baseURL)
    {
        return (parse_url($baseURL, PHP_URL_PATH) !== null) ?
            trim(parse_url($baseURL, PHP_URL_PATH), '/') : '';
    }
}
