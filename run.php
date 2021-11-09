<?php

spl_autoload_register(function (string $className) {
    require_once $className . '.php';
});

$httpReader = new HTTPReader();
$jsonData = file_get_contents($_ENV['OFFERS_ENDPOINT']);

$offerCollection = $httpReader->read($jsonData);

$subcommand = $argv[1];

switch ($subcommand) {
    case 'count_by_price_range':
        echo iterator_count(new PriceFilterIterator($offerCollection->getIterator(), $argv[2], $argv[3]));
        break;
    case 'count_by_vendor_id':
        echo iterator_count(new VendorIdFilterIterator($offerCollection->getIterator(), intval($argv[2])));
        break;
}

