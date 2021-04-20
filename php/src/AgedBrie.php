<?php
declare(strict_types=1);


namespace GildedRose;


final class AgedBrie extends Item
{

    public function update()
    {
        $this->increaseQuality();
        if ($this->isOverdue()) {
            $this->increaseQuality();
        }
        $this->decreaseSellIn();
    }
}