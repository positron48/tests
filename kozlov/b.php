<?php

$sectionsXml = simplexml_load_file($argv[1]);
$productsXml = simplexml_load_file($argv[2]);

$catalog = new DomDocument('1.0');
$catalog->encoding = "UTF-8";
$catalog->formatOutput = true;

$elementsOutput = $catalog->appendChild($catalog->createElement('ЭлементыКаталога'));
$sectionsOutput = $elementsOutput->appendChild($catalog->createElement('Разделы'));

//Генерация разделов
foreach ($sectionsXml as $sectionXml) {
    $sectionId = $sectionXml->Ид;

    $sectionOutput = $sectionsOutput->appendChild($catalog->createElement('Раздел'));

    $sectionIdOutput = $sectionOutput->appendChild($catalog->createElement('Ид'));
    $sectionIdOutput->appendChild($catalog->createTextNode($sectionId));

    $sectionNameOutput = $sectionOutput->appendChild($catalog->createElement('Наименование'));
    $sectionNameOutput->appendChild($catalog->createTextNode($sectionXml->Наименование));

    $sectionProductsOutput = $sectionOutput->appendChild($catalog->createElement('Товары'));

    //склейка с товарами
    foreach ($productsXml as $productXml) {
        foreach ($productXml->Разделы as $productSectionXml) {
            if ($sectionId == (string) $productSectionXml->ИдРаздела[0]) {
                $sectionSingleProductOutput = $sectionProductsOutput->appendChild($catalog->createElement('Товар'));

                $sectionSingleProductIdOutput = $sectionSingleProductOutput->appendChild($catalog->createElement('Ид'));
                $sectionSingleProductIdOutput->appendChild($catalog->createTextNode($productXml->Ид));

                $sectionSingleProductNameOutput = $sectionSingleProductOutput->appendChild($catalog->createElement('Наименование'));
                $sectionSingleProductNameOutput->appendChild($catalog->createTextNode($productXml->Наименование));

                $sectionSingleProductArticleOutput = $sectionSingleProductOutput->appendChild($catalog->createElement('Артикул'));
                $sectionSingleProductArticleOutput->appendChild($catalog->createTextNode($productXml->Артикул));

            }
        }
    }
}

$catalog->save($argv[3]);