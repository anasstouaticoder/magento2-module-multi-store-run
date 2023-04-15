<?php
/**
 * Copyright (c) 2023
 * MIT License
 * Module AnassTouatiCoder_MultiStoreRun
 * Author Anass TOUATI anass1touati@gmail.com
 */
declare(strict_types=1);

namespace AnassTouatiCoder\MultiStoreRun\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Wiki extends Field
{
    /**
     * Set template
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->getWikiContent();
    }

    /**
     * Get wiki content
     *
     * @return string
     */
    private function getWikiContent()
    {
        $filePath = __DIR__ . '/../../../../docs/WIKI.md';
        $wikiContent = '';
        if (file_exists($filePath)) {
            $wikiContent = file_get_contents($filePath);
        }

        return $wikiContent;
    }
}
