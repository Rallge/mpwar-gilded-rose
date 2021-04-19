<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    const SULFURAS = 'Sulfuras, Hand of Ragnaros';
    const BACKSTAGE = 'Backstage passes to a TAFKAL80ETC concert';
    /**
     * @var Item[]
     */
    private $items;
    const AGEDBRIE = 'Aged Brie';
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {

            if ($item->name != self::AGEDBRIE and $item->name != self::BACKSTAGE) {
                if ($item->name !=  self::SULFURAS ) {
                    $item->decreaseQuality();
                }
            } else {
                    $item->increaseQuality();
                    if ($item->name == self::BACKSTAGE) {
                        if ($item->isEarlyBird()) {
                            $item->increaseQuality();
                        }
                        if ($item->isLastDatesToSellIn()) {
                            $item->increaseQuality();
                        }
                    }
            }

            if ($item->name != self::SULFURAS) {
                $item->decreaseSellIn();
            }

            if ($item->isOverdue()) {
                if ($item->name != self::AGEDBRIE) {
                    if ($item->name != self::BACKSTAGE) {
                        if ($item->name != self::SULFURAS) {
                            $item->decreaseQuality();
                        }
                    } else {
                        $item->resetQuality();
                    }
                } else {
                    $item->increaseQuality();
                }
            }
        }
    }


}
