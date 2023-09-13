<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\Category\AgedBrie;
use GildedRose\Category\BackstagePass;
use GildedRose\Category\BaseCategory;
use GildedRose\Category\Conjured;
use GildedRose\Category\DefaultCategory;
use GildedRose\Category\Sulfuras;

final class GildedRose
{
    /**
     * @var BaseCategory[] $items
     */
    private array $items;

    /**
     * @param Item[] $items
     */
    public function __construct(
        array &$items
    )
    {
        $this->setItems($items);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param Item[] $items
     */
    private function setItems(array &$items): void
    {
        $this->items = &$items;
        $categories = [];

        foreach ($items as $item) {
            switch ($item->name) {
                case BaseCategory::AGED_BRIE_CATEGORY:
                    $categories[] = new AgedBrie($item->name, $item->sellIn, $item->quality);
                    break;
                case BaseCategory::BACKSTAGE_PASSES_CATEGORY:
                    $categories[] = new BackstagePass($item->name, $item->sellIn, $item->quality);
                    break;
                case BaseCategory::CONJURED_CATEGORY:
                    $categories[] = new Conjured($item->name, $item->sellIn, $item->quality);
                    break;
                case BaseCategory::SULFURAS_CATEGORY:
                    $categories[] = new Sulfuras($item->name, $item->sellIn, $item->quality);
                    break;
                default:
                    $categories[] = new DefaultCategory($item->name, $item->sellIn, $item->quality);
                    break;
            }
        }
        $this->items = $categories;
    }

    /**
     * @return void
     */
    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $item->update();
        }
    }
}
