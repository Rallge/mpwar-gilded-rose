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
                        $item->quality = $this->decreaseQuality($item);
                    }
                }
            } else {
                if ($this->isLowerThanMaximumQuality($item)) {
                    $item->increaseQuality();
                    if ($item->name == self::BACKSTAGE) {
                        if ($this->isEarlyBird($item)) {
                            if ($this->isLowerThanMaximumQuality($item)) {
                                $item->increaseQuality();
                            }
                        }
                        if ($this->isLastDatesToSellIn($item)) {
                            if ($this->isLowerThanMaximumQuality($item)) {
                                $item->increaseQuality();
                            }
                        }
                    }
                }
            }

            if ($item->name != self::SULFURAS) {
                $item->sell_in = $this->decreaseSellIn($item);
            }

            if ($this->isOverdue($item)) {
                if ($item->name != self::AGEDBRIE) {
                    if ($item->name != self::BACKSTAGE) {
                        if ($this->isGreaterThanMinimumQuality($item)) {
                            if ($item->name != self::SULFURAS) {
                                $item->quality = $this->decreaseQuality($item);;
                            }
                        }
                    } else {
                        $item->quality = $this->resetQuality($item);
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

    /**
     * @param Item $item
     * @return bool
     */
    public function isOverdue(Item $item): bool
    {
        return $item->sell_in < 0;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isLastDatesToSellIn(Item $item): bool
    {
        return $item->sell_in < 6;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isEarlyBird(Item $item): bool
    {
        return $item->sell_in < 11;
    }

    /**
     * @param Item $item
     * @return int
     */
    public function decreaseQuality(Item $item): int
    {
        return $item->quality - 1;
    }

    /**
     * @param Item $item
     * @return int
     */
    public function resetQuality(Item $item): int
    {
        return $item->quality - $item->quality;
    }

    /**
     * @param Item $item
     * @return int
     */
    public function decreaseSellIn(Item $item): int
    {
        return $item->sell_in - 1;
    }
}
