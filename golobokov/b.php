<?php
$products = new DomDocument("1.0", "utf-8");
$products->load('products.xml');

$prod_note = $products->getElementsByTagName("Товар");

$sections = new DomDocument("1.0", "utf-8");
$sections->load('sections.xml');

$result_xml = new DOMDocument("1.0", "utf-8");
$root = $result_xml->createElement('ЭлементыКаталога');
$result_xml->appendChild($root);

$node = $sections->getElementsByTagName("Разделы")->item(0);
$node = $result_xml->importNode($node, true);
$root->appendChild($node);
 foreach ($result_xml->getElementsByTagName('Раздел') as $raz ) {
     $node = $result_xml->createElement('Товары');
     $raz->appendChild($node);
 }
if($prod_note->count()!=0)
    for ($i = 0; $i<$prod_note->count(); $i++) {
        foreach ($prod_note[$i]->getElementsByTagName('ИдРаздела') as $item) {
            foreach ($result_xml->getElementsByTagName('Раздел') as $razdel)
            {
                if($razdel->getElementsByTagName('Ид')->item(0)->nodeValue == $item->nodeValue)
                {
                    $tov = $razdel->getElementsByTagName('Товары')->item(0);
                    $node = $result_xml->importNode($prod_note[$i], true);
                    $tov->appendChild($node);
                    $to_del = $tov->getElementsByTagName('Разделы')->item(0);
                    $node->removeChild($to_del);
                }

            }
        }
    }
$result_xml->save('output.xml');
?>