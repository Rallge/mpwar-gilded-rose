<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GildedRose\GildedRose;
use \GildedRose\FactoryItem;

echo "OMGHAI!" . PHP_EOL;

$items = array(
    FactoryItem::CreateItem('+5 Dexterity Vest', 10, 20),
    FactoryItem::CreateItem('Aged Brie', 2, 0),
    FactoryItem::CreateItem('Elixir of the Mongoose', 5, 7),
    FactoryItem::CreateItem('Sulfuras, Hand of Ragnaros', 0, 80),
    FactoryItem::CreateItem('Sulfuras, Hand of Ragnaros', -1, 80),
    FactoryItem::CreateItem('Backstage passes to a TAFKAL80ETC concert', 15, 20),
    FactoryItem::CreateItem('Backstage passes to a TAFKAL80ETC concert', 10, 49),
    FactoryItem::CreateItem('Backstage passes to a TAFKAL80ETC concert', 5, 49),
    // this conjured item does not work properly yet
    FactoryItem::CreateItem('Conjured Mana Cake', 3, 6)
);

$app = new GildedRose($items);

$days = 2;
if (count($argv) > 1) {
    $days = (int) $argv[1];
}

for ($i = 0; $i < $days; $i++) {
    echo("-------- day $i --------" . PHP_EOL);
    echo("name, sellIn, quality" . PHP_EOL);
    foreach ($items as $item) {
        echo $item . PHP_EOL;
    }
    echo PHP_EOL;
    $app->updateQuality();
}
