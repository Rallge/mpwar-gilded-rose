<?php
declare(strict_types=1);


namespace GildedRose;


final class Standard extends Item
{

    public function update()
    {
        $this->decreaseSellIn();
        $this->decreaseQuality();
        if ($this->isOverdue()) {
            $this->decreaseQuality();
        }
    }
}