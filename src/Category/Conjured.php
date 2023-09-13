<?php

namespace GildedRose\Category;

class Conjured extends BaseCategory
{
    public function update(): void
    {
        parent::update();
        if ($this->canQualityBeDecremented()) {
            $this->decrementQuality();

            if ($this->canQualityBeDecremented()) {
                $this->decrementQuality();
            }

            if ($this->isSellInExpired()) {
                for ($i = 0; $i < 2; $i++) {
                    if ($this->canQualityBeDecremented()) $this->decrementQuality();
                }
            }
        }
    }
}