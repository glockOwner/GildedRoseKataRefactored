<?php

namespace GildedRose\Category;

use GildedRose\Item;

class BaseCategory implements \Stringable
{
    const PRODUCT_MAX_QUALITY = 50;

    const PRODUCT_MIN_QUALITY = 0;

    const SULFURAS_CATEGORY_QUALITY = 80;

    const AGED_BRIE_CATEGORY = 'Aged Brie';

    const SULFURAS_CATEGORY = 'Sulfuras, Hand of Ragnaros';

    const BACKSTAGE_PASSES_CATEGORY = 'Backstage passes to a TAFKAL80ETC concert';

    const CONJURED_CATEGORY = 'Conjured Mana Cake';

    public function __construct(
        private string $name,
        private int $sellIn,
        private int $quality
    ) {
    }

    /**
     * @return int
     */
    public function getSellIn(): int
    {
        return $this->sellIn;
    }

    /**
     * @param int $sellIn
     */
    public function setSellIn(int $sellIn): void
    {
        $this->sellIn = $sellIn;
    }

    /**
     * @return int
     */
    public function getQuality(): int
    {
        return $this->quality;
    }

    /**
     * @param int $quality
     */
    public function setQuality(int $quality): void
    {
        $this->quality = $quality;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * обновляем качество и срок храненеия товаров
     * @return void
     */
    public function update(): void
    {
        $this->decrementSellIn();
    }

    /**
     * уменьшение срока товара
     * @return void
     */
    private function decrementSellIn(): void
    {
        $decrementedSellIn = $this->getSellIn() - 1;
        $this->setSellIn($decrementedSellIn);
    }

    /**
     * увеличение качества
     * @return void
     */
    protected function incrementQuality(): void
    {
        $incrementedQuality = $this->getQuality() + 1;
        $this->setQuality($incrementedQuality);
    }

    /**
     * уменьшение качества
     * @return void
     */
    protected function decrementQuality(): void
    {
        $decrementedQuality = $this->getQuality() - 1;
        $this->setQuality($decrementedQuality);
    }

    /**
     * проверка вышел ли срок годности товара
     * @return bool
     */
    protected function isSellInExpired(): bool
    {
        return $this->getSellIn() < 0;
    }

    /**
     * проверка, меньше ли качество макс. значения
     * @return bool
     */
    protected function isQualityLowerMax(): bool
    {
        return $this->getQuality() < self::PRODUCT_MAX_QUALITY;
    }

    /**
     * проверка, больше ли качество мин. значения
     * @return bool
     */
    protected function isQualityHigherMin(): bool
    {
        return $this->getQuality() > self::PRODUCT_MIN_QUALITY;
    }

    /**
     * проверка, может ли качество быть увеличено
     * @return bool
     */
    protected function canQualityBeIncremented(): bool
    {
        return
            $this->getQuality() >= self::PRODUCT_MIN_QUALITY
            && $this->isQualityLowerMax();
    }

    /**
     * проверка, может ли качество быть уменшьшено
     * @return bool
     */
    protected function canQualityBeDecremented(): bool
    {
        return
            $this->isQualityHigherMin()
            && $this->getQuality() <= self::PRODUCT_MAX_QUALITY;
    }

    public function __toString(): string
    {
        return (string) "{$this->name}, {$this->sellIn}, {$this->quality}";
    }
}