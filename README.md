# wk.currency.rates

Модуль нужно положить в /local и установить из админки. Директория /api сожержит экшены. Они заработают, когда в системе будут иметься курсы валют.
При установке модуля появится агент, настроеный на срабатываение раз в сутки. Обновление курсов можно так же запустить в init.php (например), вот таким образом

```php
\Bitrix\Main\Loader::includeModule('wk.currency.rates');
\wk\currency\rates\Main::ImportRatesCBR();
```

Компонент запускается вот так
```php
<?$APPLICATION->IncludeComponent(
	"wk:currency.rates",
	"",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"PARAM_NAME" => ""
	)
);?>
```
или с визуального редактора тоже можно.

### Немного насчет экшенов
Ответы отдаются в json. С первым все понятно, со вторым: там было такое 
*фильтр по значению (больше, меньше, больше или равно, меньше или равно)*

То есть, я понял так: 
***filters[value][gte]=50*** - это больше 50
***filters[value][lt]=100*** - это меньше 100

аналогично работает еще 
***filters[value][gte_]=50*** - это больше или равно 50
***filters[value][lt_]=100*** - это меньше или равно 100

По третьему экшену, чтобы работал, надо добавить в urlrewrite.php правило
```php
  65 => [
	  'CONDITION' => '#^/api/currency/(\D{3})#',
	  'RULE' => 'CURRENCY=$1',
	  'ID' => '',
	  'PATH' => '/api/currency/index.php',
	  'SORT' => 100,
  ],
```