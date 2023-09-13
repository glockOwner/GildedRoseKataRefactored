<?php

namespace GildedRose\Category;

class AgedBrie extends BaseCategory
{
    public function update(): void
    {
        parent::update();
        if ($this->canQualityBeIncremented()) {
            $this->incrementQuality();

            if ($this->isSellInExpired() && $this->canQualityBeIncremented()) {
                $this->incrementQuality();
            }
        }
    }
}