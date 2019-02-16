<?php

$products = simplexml_load_file('products.xml');
$sections = simplexml_load_file('sections.xml');

$id_array = array();
// for each product get section list
foreach ($products as $key => $product) {
    
    // for each section in product save product_info
    foreach ($product->Разделы->ИдРаздела as $key => $section) {
        // create if it's not
        if(!isset($id_array[(string)$section]))
            $id_array[(string)$section] = array();

        // save product info to the array
        $id_array[(string)$section][] = array(
            'Ид' =>     (string)$product->Ид,
            'Артикул' =>    (string)$product->Артикул,
            'Наименование' =>   (string)$product->Наименование
        );
    }

}

// add product_info to the sections
foreach ($sections as $key => $value) {
    $val_id = (string)$value->Ид;
    // if we have products for this section
    if (isset($id_array[$val_id])) {
        $section_products = $value->addChild("Товары");
        
        foreach ($id_array[$val_id] as $key => $product_info) {
            $new_product = $section_products->addChild("Товар"); 
            $new_product->addChild("Ид", $product_info['Ид']);
            $new_product->addChild("Наименование", $product_info['Наименование']);
            $new_product->addChild("Артикул", $product_info['Артикул']);
        }
    }
}

// save it
$sections->saveXML('output.xml');
