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
                if ($this->isGreaterThanMinimumQuality($item)) {
                    if ($item->name !=  self::SULFURAS ) {
                        $item->decreaseQuality();
                    }
                }
            } else {
                if ($this->isLowerThanMaximumQuality($item)) {
                    $item->increaseQuality();
                    if ($item->name == self::BACKSTAGE) {
                        if ($item->isEarlyBird()) {
                            if ($this->isLowerThanMaximumQuality($item)) {
                                $item->increaseQuality();
                            }
                        }
                        if ($item->isLastDatesToSellIn()) {
                            if ($this->isLowerThanMaximumQuality($item)) {
                                $item->increaseQuality();
                            }
                        }
                    }
                }
            }

            if ($item->name != self::SULFURAS) {
                $item->decreaseSellIn();
            }

            if ($item->isOverdue()) {
                if ($item->name != self::AGEDBRIE) {
                    if ($item->name != self::BACKSTAGE) {
                        if ($this->isGreaterThanMinimumQuality($item)) {
                            if ($item->name != self::SULFURAS) {
                                $item->decreaseQuality();
                            }
                        }
                    } else {
                        $item->resetQuality();
                    }
                } else {
                    if ($this->isLowerThanMaximumQuality($item)) {
                        $item->increaseQuality();
                    }
                }
            }
        }
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isLowerThanMaximumQuality(Item $item): bool
    {
        return $item->quality < 50;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isGreaterThanMinimumQuality(Item $item): bool
    {
        return $item->quality > 0;
    }
    

}
