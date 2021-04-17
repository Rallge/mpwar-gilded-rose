<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testFoo(): void
    {
        $items = [
            new Item('foo', 0, 0),
            new Item('Backstage passes to a TAFKAL80ETC concert', 2, 5),

        ];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $items[0]->name);
    }

    public function testQualityIsNotOverMax(): void
    {
        $agedBrie = "Aged Brie";
        $itemBackName = "Backstage passes to a TAFKAL80ETC concert";
        $itemSulfuras = "Sulfuras, Hand of Ragnaros";
        $standardItem = "standard";
        $items = [
            new Item($agedBrie, -5, 0),
            new Item($agedBrie, 2, 50),
            new Item($agedBrie, 10, 45),
            new Item($itemBackName, -5, 49),
            new Item($itemBackName, 10, 40),
            new Item($itemBackName, 1, 5),
            new Item($itemSulfuras, -5, 49),
            new Item($itemSulfuras, 10, 40),
            new Item($itemSulfuras, 1, 5),
            new Item($standardItem, -5, 49),
            new Item($standardItem, 10, 40),
            new Item($standardItem, 1, 5),

        ];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        foreach ($items as $item) {
            $this->assertLessThanOrEqual(50, $item->quality);
        }
    }


    public function testQualityIsNotOverMin(): void
    {
        $agedBrie = "Aged Brie";
        $itemBackName = "Backstage passes to a TAFKAL80ETC concert";
        $itemSulfuras = "Sulfuras, Hand of Ragnaros";
        $standardItem = "standard";
        $items = [
            new Item($agedBrie, -5, 0),
            new Item($agedBrie, 2, 50),
            new Item($agedBrie, 10, 45),
            new Item($itemBackName, -5, 49),
            new Item($itemBackName, 10, 40),
            new Item($itemBackName, 1, 5),
            new Item($itemSulfuras, -5, 49),
            new Item($itemSulfuras, 10, 40),
            new Item($itemSulfuras, 1, 5),
            new Item($standardItem, -5, 49),
            new Item($standardItem, 10, 40),
            new Item($standardItem, 1, 5),
        ];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        foreach ($items as $item) {
            $this->assertGreaterThanOrEqual(0, $item->quality);
        }
    }

    public function testIncreaseBackstageQuality(): void
    {
        $itemBackName = "Backstage passes to a TAFKAL80ETC concert";
        $backstageQualityIncreaseCases = array(
            // Case when quality should increase normally by 1
            array(
                'item' => new Item($itemBackName, 20, 5),
                'expected_incr' => 6,
            ),
            // Case when quality should increase by 2 when sell in time is 10 days or less
            array(
                'item' => new Item($itemBackName, 10, 5),
                'expected_incr' => 7,
            ),
            // Case when quality should increase by 3 when sell in time is 5 days or less
            array(
                'item' => new Item($itemBackName, 5, 5),
                'expected_incr' => 8,
            )
        );

        foreach ($backstageQualityIncreaseCases as $backstageQualityIncreaseCase) {
            $gildedRose = new GildedRose(array($backstageQualityIncreaseCase['item']));
            $gildedRose->updateQuality();
            $this->assertEquals($backstageQualityIncreaseCase['expected_incr'], $backstageQualityIncreaseCase['item']->quality);
        }
    }
    public function testDecreaseStandardItemQuality(): void
    {
        $itemStandard = "standard item";
        $itemBack = "Backstage passes to a TAFKAL80ETC concert";
        $standardDecreaseCases = array(
            array(
                'item' => new Item($itemStandard, 20, 5),
                'expected_decr' => -1,
            ),
            // Normal case when quality decrease by 1 with min quality
            array(
                'item' => new Item($itemStandard, 20, 0),
                'expected_decr' => 0,
            ),
            // Normal case when quality decrease by 1 with max quality
            array(
                'item' => new Item($itemStandard, 20, 50),
                'expected_decr' => -1,
            ),
            // When sell in value is negative and quality drops by 2
            array(
                'item' => new Item($itemStandard, -1, 5),
                'expected_decr' => -2,
            ),
            // Case when quality of Backstage passes drops down to 0
            array(
                'item' => new Item($itemBack, 0, 40),
                'expected_decr' => -40,
            ),
        );

        foreach ($standardDecreaseCases as $standardDecreaseCase) {
            $gildedRose = new GildedRose(array($standardDecreaseCase['item']));
            $quality = $standardDecreaseCase['item']->quality;
            $gildedRose->updateQuality();
            $this->assertEquals(($quality + $standardDecreaseCase['expected_decr']), $standardDecreaseCase['item']->quality);
        }
    }
    public function testSellInDecrease(): void
    {
        $agedBrie = "Aged Brie";
        $itemBackName = "Backstage passes to a TAFKAL80ETC concert";
        $itemSulfuras = "Sulfuras, Hand of Ragnaros";
        $standardItem = "standard";
        $sellIn  =  5;
        $quality = 30;

        $itemSellInDecreaseCases = array(
            array(
                'item' => new Item($standardItem, $sellIn, $quality),
                'expected_decr' => -1,
            ),
            array(
                'item' => new Item($agedBrie, $sellIn, $quality),
                'expected_decr' => -1,
            ),
            array(
                'item' => new Item($itemBackName, $sellIn, $quality),
                'expected_decr' => -1,
            ),
            array(
                'item' => new Item($itemSulfuras, $sellIn, $quality),
                'expected_decr' => 0,
            )
        );

        foreach ($itemSellInDecreaseCases as $itemDecreaseCase) {
            $gildedRose = new GildedRose(array($itemDecreaseCase['item']));
            $sellIn = $itemDecreaseCase['item']->sell_in;
            $gildedRose->updateQuality();
            $this->assertEquals($sellIn + $itemDecreaseCase['expected_decr'], $itemDecreaseCase['item']->sell_in);
        }
    }

}