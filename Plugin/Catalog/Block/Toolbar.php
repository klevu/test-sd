<?php
namespace Klevu\Somethingdigital\Plugin\Catalog\Block;

class Toolbar
{

    /**
     * Plugin
     *
     * @param \Magento\Catalog\Block\Product\ProductList\Toolbar $subject
     * @param \Closure $proceed
     * @param \Magento\Framework\Data\Collection $collection
     * @return \Magento\Catalog\Block\Product\ProductList\Toolbar
     */
    public function aroundSetCollection(
        \Magento\Catalog\Block\Product\ProductList\Toolbar $subject,
        \Closure $proceed,
        $collection
    ) {
        $currentOrder = $subject->getCurrentOrder();
        $direction = $subject->getCurrentDirection();
        $result = $proceed($collection);
        \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class)->error('before plugin order: '.$currentOrder);
        if ($currentOrder) {
            if ($currentOrder == 'personalized') {
                $subject->getCollection()->getSelect()->order('search_result.score '. $direction);
                \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class)->error('after set order plugin order: '.$currentOrder);
            }
        }

        return $result;
    }

}