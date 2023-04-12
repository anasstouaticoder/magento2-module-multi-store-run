<?php
/**
 * Copyright (c) 2023
 * MIT License
 * Module AnassTouatiCoder_MultiStoreRun
 * Author Anass TOUATI anass1touati@gmail.com
 */
declare(strict_types=1);

namespace AnassTouatiCoder\MultiStoreRun\Setup\Patch\Data;

use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;

class PatchIndexFile implements DataPatchInterface, PatchVersionInterface
{
    /** @var File  */
    private $file;

    /**
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $this->modifyBootstrap();
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public static function getVersion()
    {
        return '1.0.0';
    }

    private function modifyBootstrap()
    {
        $bootstrapPath = BP . '/pub/index.php';
        $originalContent = $this->file->read($bootstrapPath);
        $newContent = str_replace(
            'use Magento\Framework\App\Bootstrap;',
            'use AnassTouatiCoder\MultiStoreRun\App\Bootstrap;',
            $originalContent
        );
        $this->file->write($bootstrapPath, $newContent);
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }
}
