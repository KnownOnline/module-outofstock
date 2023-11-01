<?php
namespace Known\OutOfStock\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;

class ProductSaveAfter implements ObserverInterface
{
    protected $stockRegistry;

    public function __construct(
        StockRegistryInterface $stockRegistry
    ) {
        $this->stockRegistry = $stockRegistry;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var ProductInterface $product */
        $stockItem = $observer->getData('stock_item');

        $salableQuantity = $stockItem->getSalableQty();

        // Check if the product quantity is 0
        if ($salableQuantity == 0) {
            // Set the product as out of stock
            $stockItem->setIsInStock(false);
        } else {
            $stockItem->setIsInStock(true);
        }
    }
}
