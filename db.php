<?php


$mongo = null;
$products = null;

try{
    $mongo = new MongoDB\Client("mongodb://localhost:27017");
    $products = $mongo
        ->selectDatabase("iteh2_lab2")
        ->selectCollection("products");
} catch (Exception $e){
    print_error();
    exit;
}

if($products == null){
    print_error();
    exit;
}



