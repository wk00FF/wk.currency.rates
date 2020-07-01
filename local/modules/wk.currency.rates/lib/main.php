<?

/**
 * Created by PhpStorm.
 * User: william
 * Date: 01.07.2020
 * Time: 8:23
 */

namespace wk\currency\rates;

class Main{
	public static function ImportRatesCBR(){
		global $APPLICATION;
		\Bitrix\Main\Loader::includeModule('currency');
		
		$rates=self::getSiteRates();
		$strQueryText=file_get_contents("http://www.cbr.ru/scripts/XML_daily.asp");
		
		//конвертнуть XML в кодировку сайта
		$charset="windows-1251";
		if(preg_match("/<"."\?XML[^>]{1,}encoding=[\"']([^>\"']{1,})[\"'][^>]{0,}\?".">/i", $strQueryText, $matches)){
			$charset=Trim($matches[1]);
		}
		$strQueryText=$APPLICATION->ConvertCharset($strQueryText, $charset, SITE_CHARSET);
		/*	$strQueryText=preg_replace("#<!DOCTYPE[^>]+?>#i", "", $strQueryText);*/
		//	$strQueryText=preg_replace("#<"."\\?XML[^>]+?\\?".">#i", "", $strQueryText);
		
		$arData=(array) new \SimpleXMLElement($strQueryText);
		$newRates=[];
		if(is_array($arData) && count($arData['Valute'])){
			$arFilter['DATE_RATE']=$arData['@attributes']['Date'];
			foreach($arData['Valute'] as $rate){
				$rate=(array) $rate;
				if(in_array($rate['CharCode'], $rates)){
					$newRates['CURRENCY']=$rate['CharCode'];
					$newRates['RATE_CNT']=IntVal($rate['Nominal']);
					$newRates['RATE']=DoubleVal(str_replace(",", ".", $rate['Value']));
					$newRates['DATE_RATE']=$arData['@attributes']['Date'];
					
					$arFilter['CURRENCY']=$newRates['CURRENCY'];
					$by="date"; $order="desc";
					$db_rate=\CCurrencyRates::GetList($by, $order, $arFilter);
					$ar_rate=$db_rate->Fetch();
					if(!$ar_rate || $ar_rate['RATE']!=$newRates['RATE']){
						\CCurrencyRates::Add($newRates);
					}
				}
			}
		}
		return '\wk\currency\rates\Main::ImportRatesCBR();';
	}
	public static function getSiteRates(){
		global $APPLICATION;
		// получить валюты на сайте
		$by='sort'; $order='asc';
		$dbRates=\CCurrency::GetList($by, $order, 'RU');
		while($arRates=$dbRates->Fetch()){
			$rates[]=$arRates['CURRENCY'];
		}
		return $rates;
	}
}