<?
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
if(!check_bitrix_sessid()){
	return;
}
if($errorException=$APPLICATION->getException()){
	// ошибка при установке модуля
	CAdminMessage::showMessage(Loc::getMessage('CURRENCY_RATES_INSTALL_FAILED').': '.$errorException->GetString());
}
else{
	// модуль успешно установлен
	CAdminMessage::showNote(Loc::getMessage('CURRENCY_RATES_INSTALL_SUCCESS'));
}
?>

<form action="<?=$APPLICATION->getCurPage();?>">
	<input type="hidden" name="lang" value="<?=LANGUAGE_ID;?>"/>
	<input type="submit" value="<?=Loc::getMessage('CURRENCY_RATES_RETURN_MODULES');?>">
</form>