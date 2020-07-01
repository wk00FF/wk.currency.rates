<?
use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
Loc::loadMessages(__FILE__);

class wk_currency_rates extends CModule{
	public function __construct(){
		if(is_file(__DIR__.'/version.php')){
			include_once(__DIR__.'/version.php');
			$this->MODULE_ID='wk.currency.rates';
			$this->MODULE_VERSION=$arModuleVersion['VERSION'];
			$this->MODULE_VERSION_DATE=$arModuleVersion['VERSION_DATE'];
			$this->MODULE_NAME=Loc::getMessage('CURRENCY_RATES_NAME');
			$this->MODULE_DESCRIPTION=Loc::getMessage('CURRENCY_RATES_DESCRIPTION');

			$this->PARTNER_NAME = "william kuchukoff";
			$this->PARTNER_URI = "mail:wk00FF@gmail.com";
		}
		else{
			CAdminMessage::showMessage(Loc::getMessage('CURRENCY_RATES_FILE_NOT_FOUND').' version.php');
		}
	}

	public function doInstall(){
		global $APPLICATION;
		if(CheckVersion(ModuleManager::getVersion('main'), '14.00.00')){
			$this->installFiles();
			$this->installDB();
			$this->installEvents();
			ModuleManager::registerModule($this->MODULE_ID);
			
			global $DB;
			$date=$DB->FormatDate(date("d.m.Y", time()+86400), CLang::GetDateFormat("SHORT", $lang), "D.M.Y").' 00:00:00';
			\CAgent::AddAgent('\wk\currency\rates\Main::ImportRatesCBR();',		// имя функции
				'wk.currency.rates',											// идентификатор модуля
				"N",																// агент не критичен к кол-ву запусков
				86400,															// интервал запуска - 1 сутки
				$date,														// дата первой проверки на запуск
				"Y",																// агент активен
				$date,															// дата первого запуска
				30);
		}
		else{
			CAdminMessage::showMessage(Loc::getMessage('CURRENCY_RATES_INSTALL_ERROR'));
			return;
		}
		$APPLICATION->includeAdminFile(Loc::getMessage('CURRENCY_RATES_INSTALL_TITLE').' «'.Loc::getMessage('CURRENCY_RATES_NAME').'»', __DIR__.'/step.php');
	}
	public function doUninstall(){
		global $APPLICATION;
		$this->uninstallFiles();
		$this->uninstallDB();
		$this->uninstallEvents();
		ModuleManager::unRegisterModule($this->MODULE_ID);
		\CAgent::RemoveModuleAgents("wk.currency.rates");
		$APPLICATION->includeAdminFile(Loc::getMessage('CURRENCY_RATES_UNINSTALL_TITLE').' «'.Loc::getMessage('CURRENCY_RATES_NAME').'»', __DIR__.'/unstep.php');
	}

	public function installFiles(){
		CopyDirFiles(__DIR__.'/assets/components', Application::getDocumentRoot().'/local/components/', true, true);
	}
	public function uninstallFiles(){
		Directory::deleteDirectory(Application::getDocumentRoot().'/local/components/wk/currency.rates/');
		Option::delete($this->MODULE_ID);
	}

	public function installDB(){
		return true;
	}
	public function uninstallDB(){
		return;
	}

	public function installEvents(){
		return true;
	}
	public function uninstallEvents(){
		return true;
	}


}