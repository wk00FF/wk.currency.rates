<?
/**
 * Created by PhpStorm.
 * User: william
 * Date: 30.06.2020
 * Time: 20:14
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/**
 * @var string $componentPath
 * @var string $componentName
 * @var array  $arCurrentValues
 * */
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
if(!Loader::includeModule("iblock")){
	throw new \Exception('Не загружены модули необходимые для работы компонента');
}

$arComponentParameters=[
	"GROUPS"    =>[
		"SETTINGS"=>[
			"NAME"=>Loc::getMessage("SETTINGS_NAME"),
			"SORT"=>550,
		],
	],
	"PARAMETERS"=>[
		// Произвольный параметр типа СТРОКА
		"PARAM_1"=>[
			"PARENT"  =>"SETTINGS",
			"NAME"    =>Loc::getMessage("PARAM_1_NAME"),
			"TYPE"    =>"STRING",
			"MULTIPLE"=>"N",
			"DEFAULT" =>"",
			"COLS"    =>25
		],
		// Настройки кэширования
		'CACHE_TIME' =>['DEFAULT'=>3600],
	]
];