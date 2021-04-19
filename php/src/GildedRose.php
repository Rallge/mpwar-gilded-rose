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
                if ($item->quality > 0) {
                    if ($item->name !=  self::SULFURAS ) {
                        $item->quality = $item->quality - 1;
                    }
                }
            } else {
                if ($item->quality < 50) {
                    $item->quality = $item->quality + 1;
                    if ($item->name == self::BACKSTAGE) {
                        if ($item->sell_in < 11) {
                            if ($item->quality < 50) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                        if ($item->sell_in < 6) {
                            if ($item->quality < 50) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                    }
                }
            }

            if ($item->name != self::SULFURAS) {
                $item->sell_in = $item->sell_in - 1;
            }

            if ($item->sell_in < 0) {
                if ($item->name != self::AGEDBRIE) {
                    if ($item->name != self::BACKSTAGE) {
                        if ($item->quality > 0) {
                            if ($item->name != self::SULFURAS) {
                                $item->quality = $item->quality - 1;
                            }
                        }
                    } else {
                        $item->quality = $item->quality - $item->quality;
                    }
                } else {
                    if ($item->quality < 50) {
                        $item->quality = $item->quality + 1;
                    }
                }
            }
        }
    }
}
