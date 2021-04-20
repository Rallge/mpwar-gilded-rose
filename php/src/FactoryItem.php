<?php
declare(strict_types=1);


namespace GildedRose;


final class FactoryItem
{
    public static function CreateItem(string $itemName, int $sellIn, $quality): Item {
        switch ($itemName){
            case Item::AGEDBRIE: {
                return new AgedBrie($itemName, $sellIn, $quality);
            }
            case Item::SULFURAS: {
                return new Sulfuras($itemName, $sellIn, $quality);
            }
            case Item::BACKSTAGE: {
                return new Backstage($itemName, $sellIn, $quality);
            }
            default:
                return new Standard($itemName, $sellIn, $quality);
        }
    }
}