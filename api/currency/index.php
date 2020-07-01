<?
/**
 * Created by PhpStorm.
 * User: william
 * Date: 01.07.2020
 * Time: 3:28
 */
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
//\Bitrix\Main\Diag\Debug::dump($_REQUEST);
if($_REQUEST['CURRENCY']){
	$filter=['CURRENCY'=>strtoupper(str_ireplace('/', '', $_REQUEST['CURRENCY']))];
	$by="date"; $order="desc";
	$db_rate=CCurrencyRates::GetList($by, $order, $filter);
	if($ar_rate=$db_rate->Fetch()){
		echo json_encode($ar_rate);
	}
	exit();
}
$filter=[];
$by="date"; $order="asc";
if($_REQUEST['order']){
	if($_REQUEST['order']['field']=='value'){
		$by='rate';
	}
	$order=$_REQUEST['order']['direction'];
}
global $DB;
$filter['DATE_RATE']=$DB->FormatDate(date("d.m.Y"), CLang::GetDateFormat("SHORT", $lang), "D.M.Y");
$db_rate=CCurrencyRates::GetList($by, $order, $filter);
while($ar_rate=$db_rate->Fetch()){
	if($_REQUEST['filters']['value']['gte_']){ // больше или равно
		if(DoubleVal($ar_rate['RATE']) < DoubleVal(str_replace(",", ".", $_REQUEST['filters']['value']['gte']))){
			continue;
		}
	}
	if($_REQUEST['filters']['value']['lt_']){ // меньше или равно
		if(DoubleVal($ar_rate['RATE']) > DoubleVal(str_replace(",", ".", $_REQUEST['filters']['value']['lt']))){
			continue;
		}
	}
	if($_REQUEST['filters']['value']['gte']){ // больше
		if(DoubleVal($ar_rate['RATE']) <= DoubleVal(str_replace(",", ".", $_REQUEST['filters']['value']['gte']))){
			continue;
		}
	}
	if($_REQUEST['filters']['value']['lt']){ // меньше
		if(DoubleVal($ar_rate['RATE']) >= DoubleVal(str_replace(",", ".", $_REQUEST['filters']['value']['lt']))){
			continue;
		}
	}
	$arResult[]=$ar_rate;
}
//\Bitrix\Main\Diag\Debug::dump($by);
//\Bitrix\Main\Diag\Debug::dump($order);
//\Bitrix\Main\Diag\Debug::dump($filter);
//\Bitrix\Main\Diag\Debug::dump($arResult);
echo json_encode($arResult);