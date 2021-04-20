<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GildedRose\GildedRose;
use \GildedRose\FactoryItem;
use GildedRose\Item;

echo "OMGHAI!" . PHP_EOL;

$items = array(
    FactoryItem::CreateItem('+5 Dexterity Vest', 10, 20),
    FactoryItem::CreateItem(Item::AGEDBRIE, 2, 0),
    FactoryItem::CreateItem('Elixir of the Mongoose', 5, 7),
    FactoryItem::CreateItem(Item::SULFURAS, 0, 80),
    FactoryItem::CreateItem(Item::SULFURAS, -1, 80),
    FactoryItem::CreateItem(Item::BACKSTAGE, 15, 20),
    FactoryItem::CreateItem(Item::BACKSTAGE, 10, 49),
    FactoryItem::CreateItem(Item::BACKSTAGE, 5, 49),
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
