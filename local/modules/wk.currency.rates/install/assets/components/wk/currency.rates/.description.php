<?
/**
 * Created by PhpStorm.
 * User: william
 * Date: 30.06.2020
 * Time: 20:14
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Localization\Loc;

$arComponentDescription=[
	"NAME"       =>Loc::getMessage("COMPONENT_NAME"),
	"DESCRIPTION"=>Loc::getMessage("COMPONENT_DESCRIPTION"),
	"COMPLEX"    =>"N",
	"PATH"       =>[
		"ID"  =>'local',
		"NAME"=>Loc::getMessage("BRANCH_NAME"),
	],
];
?>