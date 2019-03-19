<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Greenkey 
/-------------------------------------------------------------------------------------------------------/

	@version		0.0.2
	@build			12th марта, 2019
	@created		12th марта, 2019
	@package		Greencart
	@subpackage		default_yandex_xml_yml.php
	@author			Matvey <https://greenkey.ru>	
	@copyright		Copyright (C) 2019. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$doc = new DOMDocument();
$doc->loadXML('<?xml version="1.0" encoding="UTF-8"?><yml_catalog date="2019-03-01 17:00"><shop>'.
	'<name>Triumf</name>'.
	'<company>Triumf</company>'.
	'<url>https://triumf40.ru/</url>'.
	'<currencies>'.
	'<currency id="RUR" rate="1"/>'.
	'</currencies>'.
	'<categories>'.
	'<category id="2">Теплицы из поликарбоната</category>'.
	'<category id="11">Навесы</category>'.
	'<category id="12">Для дачи</category>'.
	'</categories>'.
	'<delivery-options>'.
	'<option cost="1000" days="3" />'.
	'</delivery-options>'.
	'<offers></offers>'.
	'</shop></yml_catalog>');

    $offers = $doc->getElementsByTagName('offers')[0];

    foreach ($this->items as $i => $item) :
        echo $item->id." - ".$item->title." - ".$item->tag_id."<br/>";
        //print_r($item);


	    $offer = $doc->createElement('offer');

	    $offer->setAttribute("id", $item->id);
	    $offer->setAttribute("available", "true");

	    $offers->appendChild($offer);

	    $element = $doc->createElement('url', 'https://triumf40.ru/production/greenhouses/'.$item->alias.'?l=4&amp;s=100');
	    $offer->appendChild($element);


    endforeach;

    $doc->save("../administrator/components/com_greencart/tmp.xml")

/*<offer id="66x4x100" available="true">
                <url>https://triumf40.ru/production/greenhouses/triumf-sphere?l=4&amp;s=100</url>
                <price>20300</price>
                <currencyId>RUR</currencyId>
                <categoryId>2</categoryId>
                <picture>https://triumf40.ru/images/sphera/42520761.jpg</picture>
                <picture>https://triumf40.ru/images/sphera/opensky.jpg</picture>
                <store>true</store>
                <delivery>true</delivery>
                <name>Теплица оцинкованная Триумф Сфера 4м (шаг 100см)</name>
                <vendor>Триумф</vendor>
                <model>triumf-sphera-4х100</model>
                <description>Теплица из оцинкованной трубы с покрытием из поликарбоната с раздвигающейся крышей</description>
                <sales_notes>Оплата при доставке товара</sales_notes>
                <manufacturer_warranty>true</manufacturer_warranty>
                <param name="Длина" unit="метр">4</param>
                <param name="Ширина" unit="метр">3</param>
                <param name="Высота" unit="метр">2,1</param>
                <param name="Шаг между дугами" unit="см">100</param>
                <param name="Материал">Оцинкованная стальная труба</param>
                <param name="Размер трубы" unit="миллиметр">20х20</param>
                <param name="Толщина стенки трубы" unit="миллиметр">1</param>
                <param name="Покрытие">Поликарбонат  4мм с защитой UV</param>
                <param name="Двери">есть</param>
                <param name="Форточки">есть</param>
                <param name="Грунтозацепы">опционально</param>
                <param name="Брус">опционально</param>
                <param name="Грунтозацепы">опционально</param>
                <param name="Внутренняя перегородка">опционально</param>
                <param name="Боковая форточка">опционально</param>
                <param name="Механизм открывания форточки">опционально</param>
                <param name="Монтаж">опционально</param>
            </offer>*/


?>

