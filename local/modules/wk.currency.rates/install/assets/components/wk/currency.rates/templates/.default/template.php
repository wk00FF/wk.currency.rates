<?

/**
 * Created by PhpStorm.
 * User: william
 * Date: 30.06.2020
 * Time: 20:44
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

//\Bitrix\Main\Diag\Debug::dump($arParams);
//\Bitrix\Main\Diag\Debug::dump($arResult);

?>

<div class="ratesForm">
	Курс валют
	<div class="select">
		<select class="select-css" id="selectrate">
			<?foreach($arResult['RATES'] as $currency=>$rate){?>
				<option value="<?=$currency?>" data-rate-cnt="<?=$rate['RATE_CNT']?>" data-full-name="<?=$rate['FULL_NAME']?>" data-rate="<?=$rate['RATE']?>">
					<?=($rate['FULL_NAME'].' ('.$currency.')');?>
				</option>
			<?}?>
		</select>
	</div>
	<div id="currentrate"></div>
</div>

