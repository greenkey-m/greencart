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
	'<category id="2">Теплицы и каркасы</category>'.
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
        echo $item->id." - ".$item->title." - "."<br/>";

		// получаем массив длин
	    $l = explode(",", $item->fields[3]->value);

		// получаем массив с данными по ценам для калькулятора
	    $c = explode(",", $item->fields[4]->value);

	    // получаем адрес папки с изображениями
	    $f = "/images/".$item->fields[8]->value;

	    $parray = array();
	    $carray = array();
	    foreach ($c as $cit) {
		    $x = explode("x", trim($cit));
		    $parray[$x[0]] = $x;
	    }
	    if (!isset($parray[0])) {
		    $parray[0][0] = 0;
		    $parray[0][1] = 0;
		    $parray[0][2] = 0;
		    $parray[0][3] = 0;
		    $parray[0][4] = 0;
		    $parray[0][5] = 0;
	    }
	    $minln = 0;
	    foreach ($l as $lit) {
		    $lit = trim($lit);
		    if ($minln == 0) {
			    $minln = $lit;
		    } else {
			    if ($minln > $lit) $minln = $lit;
		    }

		    if (isset($parray[$lit])) {
			    $carray[$lit] = $parray[$lit];
		    } else {
			    // Откатывать назад, пока не найдется существующая запись
			    // Тогда к ней прибавить разницу в длине / 2 умноженную на цены сегмента, которые записаны в 0 индексе.
			    $x = ($lit - $prevs) / 2;
			    $carray[$lit][0] = $lit;
			    $carray[$lit][1] = $carray[$prevs][1] + $x * $parray[0][1];
			    $carray[$lit][2] = $carray[$prevs][2] + $x * $parray[0][2];
			    $carray[$lit][3] = $carray[$prevs][3] + $x * $parray[0][3];
			    $carray[$lit][4] = $carray[$prevs][4] + $x * $parray[0][4];
			    $carray[$lit][5] = $carray[$prevs][5] + $x * $parray[0][5];
			    //TODO нулевой индекс лучше наверное отдельно разместить
		    }
		    $prevs = trim($lit);
	    }

	    $icons = json_decode($item->fields[11]->rawvalue);
	    switch ($icons->icons0->ico) {
	    	case "t08": $thick = "0,8"; break;
		    case "t10": $thick = "1,0"; break;
		    case "t12": $thick = "1,2"; break;
		    case "t15": $thick = "1,5"; break;
		    default: $thick = "1,0";
	    }

		//print_r($carray);
	    //print_r($item->fields[13]->value);
        //print_r($f);
		echo "<hr/>";

        foreach ($carray as $len) {

        	if ($len[1] > 0) {
		        // Create for step 100
		        $offer = $doc->createElement('offer');
		        $offer->setAttribute("id", $item->id."x".$len[0]."x100");
		        $offer->setAttribute("available", "true");
		        $offers->appendChild($offer);

		        $element = $doc->createElement('url', 'https://triumf40.ru/production/greenhouses/'.str_replace("triumf-","",$item->alias).'?l='.$len[0].'&amp;s=100');
		        $offer->appendChild($element);

		        $element = $doc->createElement('price', $len[1]);
		        $offer->appendChild($element);

		        $element = $doc->createElement('currencyId', 'RUR');
		        $offer->appendChild($element);

		        $element = $doc->createElement('categoryId', '2');
		        $offer->appendChild($element);

		        $imgs = scandir("..".$f);
		        foreach ($imgs as $img) {
			        if (($img <> ".")&($img <> "..")&($img <> 'index.html')) {
				        $element = $doc->createElement('picture', "https://triumf40.ru".$f."/".$img);
				        $offer->appendChild($element);
			        }
		        }

		        $element = $doc->createElement('store', 'true');
		        $offer->appendChild($element);
		        $element = $doc->createElement('delivery', 'true');
		        $offer->appendChild($element);

		        $element = $doc->createElement('name', $item->title.($len[0] > 2 ? (' '.$len[0].'м (шаг 100см)'):("")));
		        $offer->appendChild($element);

		        $element = $doc->createElement('vendor', 'Триумф');
		        $offer->appendChild($element);
		        $element = $doc->createElement('vendorCode', $item->alias.($len[0] > 2 ? ('-'.$len[0].'х100'):("")));
		        $offer->appendChild($element);

		        $element = $doc->createElement('model', $item->alias.($len[0] > 2 ? ('-'.$len[0].'х100'):("")));
		        $offer->appendChild($element);

		        $element = $doc->createElement('description', $item->fields[12]->value);
		        $offer->appendChild($element);

		        $element = $doc->createElement('sales_notes', 'Оплата при доставке товара');
		        $offer->appendChild($element);

		        $element = $doc->createElement('manufacturer_warranty', 'true');
		        $offer->appendChild($element);

		        $element = $doc->createElement('param', "теплица");
		        $element->setAttribute("name", "Тип");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "поликарбонат");
		        $element->setAttribute("name", "Покрытие");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "профильная труба");
		        $element->setAttribute("name", "Тип каркаса");
		        $offer->appendChild($element);

		        if (strpos($item->title, "алюминиевая") === false) {
			        $element = $doc->createElement('param', "есть");
			        $element->setAttribute("name", "Оцинкованный каркас");
			        $offer->appendChild($element);
		        }
		        $element = $doc->createElement('param', $item->fields[13]->value);
		        $element->setAttribute("name", "Сечение каркаса");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "есть");
		        $element->setAttribute("name", "Наличие форточки");
		        $offer->appendChild($element);

		        $element = $doc->createElement('param', $len[0]);
		        $element->setAttribute("name", "Длина");
		        $element->setAttribute("unit", "метр");
		        $offer->appendChild($element);
		        //$element = $doc->createElement('param', "3");
		        //$element->setAttribute("name", "Ширина");
		        //$element->setAttribute("unit", "метр");
		        //$offer->appendChild($element);
		        //$element = $doc->createElement('param', "2,1");
		        //$element->setAttribute("name", "Высота");
		        //$element->setAttribute("unit", "метр");
		        //$offer->appendChild($element);
		        $element = $doc->createElement('param', "100");
		        $element->setAttribute("name", "Шаг между дугами");
		        $element->setAttribute("unit", "см");
		        $offer->appendChild($element);

		        $element = $doc->createElement('param', $thick);
		        $element->setAttribute("name", "Толщина стенки трубы");
		        $element->setAttribute("unit", "мм");
		        $offer->appendChild($element);

		        $element = $doc->createElement('param', "есть");
		        $element->setAttribute("name", "Наличие дверей");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "опционально");
		        $element->setAttribute("name", "Грунтозацепы");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "опционально");
		        $element->setAttribute("name", "Брус");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "опционально");
		        $element->setAttribute("name", "Внутренняя перегородка");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "опционально");
		        $element->setAttribute("name", "Боковая форточка");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "опционально");
		        $element->setAttribute("name", "Механизм открывания форточки");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "опционально");
		        $element->setAttribute("name", "Монтаж");
		        $offer->appendChild($element);

	        }

        	if ($len[2] > 0) {
		        // Create for step 65
		        $offer = $doc->createElement('offer');
		        $offer->setAttribute("id", $item->id."x".$len[0]."x65");
		        $offer->setAttribute("available", "true");
		        $offers->appendChild($offer);

		        $element = $doc->createElement('url', 'https://triumf40.ru/production/greenhouses/'.str_replace("triumf-","",$item->alias).'?l='.$len[0].'&amp;s=65');
		        $offer->appendChild($element);

		        $element = $doc->createElement('price', $len[2]);
		        $offer->appendChild($element);

		        $element = $doc->createElement('currencyId', 'RUR');
		        $offer->appendChild($element);

		        $element = $doc->createElement('categoryId', '2');
		        $offer->appendChild($element);

		        $imgs = scandir("..".$f);
		        foreach ($imgs as $img) {
			        if (($img <> ".")&($img <> "..")&($img <> 'index.html')) {
				        $element = $doc->createElement('picture', "https://triumf40.ru".$f."/".$img);
				        $offer->appendChild($element);
			        }
		        }

		        $element = $doc->createElement('store', 'true');
		        $offer->appendChild($element);
		        $element = $doc->createElement('delivery', 'true');
		        $offer->appendChild($element);

		        $element = $doc->createElement('name', $item->title.' '.$len[0].'м (шаг 65см)');
		        $offer->appendChild($element);

		        $element = $doc->createElement('vendor', 'Триумф');
		        $offer->appendChild($element);
		        $element = $doc->createElement('vendorCode', $item->alias.($len[0] > 2 ? ('-'.$len[0].'х65'):("")));
		        $offer->appendChild($element);

		        $element = $doc->createElement('model', $item->alias.'-'.$len[0].'х65');
		        $offer->appendChild($element);

		        $element = $doc->createElement('description', $item->fields[12]->value);
		        $offer->appendChild($element);

		        $element = $doc->createElement('sales_notes', 'Оплата при доставке товара');
		        $offer->appendChild($element);

		        $element = $doc->createElement('manufacturer_warranty', 'true');
		        $offer->appendChild($element);

		        $element = $doc->createElement('param', "теплица");
		        $element->setAttribute("name", "Тип");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "поликарбонат");
		        $element->setAttribute("name", "Покрытие");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "профильная труба");
		        $element->setAttribute("name", "Тип каркаса");
		        $offer->appendChild($element);
		        if (strpos($item->title, "алюминиевая") === false) {
			        $element = $doc->createElement('param', "есть");
			        $element->setAttribute("name", "Оцинкованный каркас");
			        $offer->appendChild($element);
		        }
		        $element = $doc->createElement('param', $item->fields[13]->value);
		        $element->setAttribute("name", "Сечение каркаса");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "есть");
		        $element->setAttribute("name", "Наличие форточки");
		        $offer->appendChild($element);

		        $element = $doc->createElement('param', $len[0]);
		        $element->setAttribute("name", "Длина");
		        $element->setAttribute("unit", "метр");
		        $offer->appendChild($element);
		        //$element = $doc->createElement('param', "3");
		        //$element->setAttribute("name", "Ширина");
		        //$element->setAttribute("unit", "метр");
		        //$offer->appendChild($element);
		        //$element = $doc->createElement('param', "2,1");
		        //$element->setAttribute("name", "Высота");
		        //$element->setAttribute("unit", "метр");
		        //$offer->appendChild($element);
		        $element = $doc->createElement('param', "65");
		        $element->setAttribute("name", "Шаг между дугами");
		        $element->setAttribute("unit", "см");
		        $offer->appendChild($element);

		        $element = $doc->createElement('param', $thick);
		        $element->setAttribute("name", "Толщина стенки трубы");
		        $element->setAttribute("unit", "мм");
		        $offer->appendChild($element);

		        $element = $doc->createElement('param', "есть");
		        $element->setAttribute("name", "Наличие дверей");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "опционально");
		        $element->setAttribute("name", "Грунтозацепы");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "опционально");
		        $element->setAttribute("name", "Брус");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "опционально");
		        $element->setAttribute("name", "Внутренняя перегородка");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "опционально");
		        $element->setAttribute("name", "Боковая форточка");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "опционально");
		        $element->setAttribute("name", "Механизм открывания форточки");
		        $offer->appendChild($element);
		        $element = $doc->createElement('param', "опционально");
		        $element->setAttribute("name", "Монтаж");
		        $offer->appendChild($element);
	        }

        }

    endforeach;

    $doc->save("../administrator/components/com_greencart/tmp.xml")
	//$doc->save("../triumf.xml")

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
                <param name="Внутренняя перегородка">опционально</param>
                <param name="Боковая форточка">опционально</param>
                <param name="Механизм открывания форточки">опционально</param>
                <param name="Монтаж">опционально</param>
            </offer>*/


?>

