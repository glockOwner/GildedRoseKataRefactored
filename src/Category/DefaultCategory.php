<?php

namespace GildedRose\Category;

class DefaultCategory extends BaseCategory
{
    public function update(): void
    {
        parent::update();
        # уменьшаем качество
        if ($this->canQualityBeDecremented()) {
            $this->decrementQuality();

            if ($this->isSellInExpired() && $this->canQualityBeDecremented()) {
                $this->decrementQuality();
            }
        }
    }
}