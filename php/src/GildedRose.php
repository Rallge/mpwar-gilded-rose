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
                if ($this->isGreaterMinimumQuality($item)) {
                    if ($item->name !=  self::SULFURAS ) {
                        $item->quality = $item->quality - 1;
                    }
                }
            } else {
                if ($this->isLessMaximumQuality($item)) {
                    $item->quality = $item->quality + 1;
                    if ($item->name == self::BACKSTAGE) {
                        if ($item->sell_in < 11) {
                            if ($this->isLessMaximumQuality($item)) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                        if ($item->sell_in < 6) {
                            if ($this->isLessMaximumQuality($item)) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                    }
                }
            }

            if ($item->name != self::SULFURAS) {
                $item->sell_in = $item->sell_in - 1;
            }

            if ($this->isOverdue($item)) {
                if ($item->name != self::AGEDBRIE) {
                    if ($item->name != self::BACKSTAGE) {
                        if ($this->isGreaterMinimumQuality($item)) {
                            if ($item->name != self::SULFURAS) {
                                $item->quality = $item->quality - 1;
                            }
                        }
                    } else {
                        $item->quality = $item->quality - $item->quality;
                    }
                } else {
                    if ($this->isLessMaximumQuality($item)) {
                        $item->quality = $item->quality + 1;
                    }
                }
            }
        }
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isLessMaximumQuality(Item $item): bool
    {
        return $item->quality < 50;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isGreaterMinimumQuality(Item $item): bool
    {
        return $item->quality > 0;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isOverdue(Item $item): bool
    {
        return $item->sell_in < 0;
    }
}
