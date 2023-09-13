<?php

namespace GildedRose\Category;

class BackstagePass extends BaseCategory
{
    public function update(): void
    {
        parent::update();

        if ($this->isSellInExpired()) {
            $this->setQuality(0);
            return;
        }

        if ($this->canQualityBeIncremented()) {
            $this->incrementQuality();

            if ($this->getSellIn() < 11 && $this->canQualityBeIncremented()) {
                $this->incrementQuality();
                if ($this->getSellIn() < 6 && $this->canQualityBeIncremented()) {
                    $this->incrementQuality();
                }
            }
        }
    }
}