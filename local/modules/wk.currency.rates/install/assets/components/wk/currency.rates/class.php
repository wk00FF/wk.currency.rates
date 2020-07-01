<?
/**
 * Created by PhpStorm.
 * User: william
 * Date: 30.06.2020
 * Time: 20:16
 */
use Bitrix\Main\Application;
use Bitrix\Main\Loader;

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

class CurrencyRates extends CBitrixComponent{
	private $_request;

	public function onPrepareComponentParams($arParams){
		return $arParams;
	}

	public function executeComponent(){
		$this->_checkModules();
		$this->_request=Application::getInstance()->getContext()->getRequest();
		
		global $DB;
		$date=$DB->FormatDate(date("d.m.Y"), CLang::GetDateFormat("SHORT", $lang), "D.M.Y");
		$this->arResult['DATE']=$date;
		$by="date"; $order="desc";
//		$db_rate=CCurrencyRates::GetList($by, $order, ['>=DATE_RATE'=>$date]);
		$db_rate=CCurrencyRates::GetList($by, $order, []);
		while($ar_rate=$db_rate->Fetch()){
			if(!$this->arResult['RATES'][$ar_rate['CURRENCY']]) $this->arResult['RATES'][$ar_rate['CURRENCY']]=$ar_rate;
		}

		$iterator=CCurrencyLang::GetList($by, $order);
		while($row=$iterator->fetch()){
			if(isset($this->arResult['RATES'][$row['CURRENCY']]) && $row['LID']=='ru') $this->arResult['RATES'][$row['CURRENCY']]['FULL_NAME']=$row['FULL_NAME'];
		}
		$this->includeComponentTemplate();
	}

	private function _checkModules(){
		if(!Loader::includeModule('iblock') || !Loader::includeModule('currency')){
			throw new \Exception(Loc::getMessage("LOAD_MODULES_ERROR"));
		}
		return true;
	}

	private function _app(){
		global $APPLICATION;
		return $APPLICATION;
	}

	private function _user(){
		global $USER;
		return $USER;
	}
}