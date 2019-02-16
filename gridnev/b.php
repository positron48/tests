<?php

$products = simplexml_load_file($argv[2]);
$sections = simplexml_load_file($argv[1]);

$razdely_id = array();
$razdely_names = array();

$prod_id = array();
$prod_art = array();
$prod_names = array();

foreach ($sections->Раздел as $razdely) {
    array_push($razdely_id, $razdely->Ид);
    array_push($razdely_names, $razdely->Наименование);
}

foreach($products->Товар as $prod_goods) {
    array_push($prod_id, $prod_goods->Ид);
    array_push($prod_art, $prod_goods->Артикул);
    array_push($prod_names, $prod_goods->Наименованние);
}
 
$fp = fopen($argv[3], 'a');
fwrite($fp, '<?xml version="1.0" encoding="UTF-8"?>'); 
fwrite($fp, '<Элементы Каталога>');
fwrite($fp, '<Разделы>');
for ($i=0; $i<sizeof($razdely_id); $i++) {
    fwrite($fp, '<Раздел>');
    fwrite($fp, '<Ид>' . $razdely_id[$i][0] . '</Ид>');
    fwrite($fp, '<Наименование>' . $razdely_names[$i][0] . '</Наименование>');
}
fwrite($fp, '<Товары>');
for ($i=0; $i<sizeof($prod_id); $i++) {
    fwrite($fp, '<Товар>');
    fwrite($fp, '<Ид>' . $prod_id[$i][0] . '</Ид>');
    fwrite($fp, '<Наименование>' . $prod_names[$i][0] . '</Наименование>');
    fwrite($fp, '<Артикул>' . $prod_art[$i][0] . '</Артикул>');
}

fwrite($fp, '</Товары>');
fwrite($fp, '</Раздел>');
fwrite($fp, '</Разделы>');
fwrite($fp, '</Элементы Каталога>');
fclose($fp);  

