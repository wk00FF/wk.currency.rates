<?
/**
 * Created by PhpStorm.
 * User: william
 * Date: 01.07.2020
 * Time: 3:28
 */
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule('wk.currency.rates');
//\Bitrix\Main\Diag\Debug::dump($_REQUEST);
echo json_encode(\wk\currency\rates\Main::getSiteRates());
