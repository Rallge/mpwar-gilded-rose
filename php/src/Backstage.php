<?php
declare(strict_types=1);


namespace GildedRose;


final class Backstage extends Item
{

    public function update()
    {
        $this->increaseQuality();
        if ($this->isEarlyBird()) {
            $this->increaseQuality();
        }
        if ($this->isLastDatesToSellIn()) {
            $this->increaseQuality();
        }
        $this->decreaseSellIn();
        if ($this->isOverdue()) {
            $this->resetQuality();
        }
    }
}