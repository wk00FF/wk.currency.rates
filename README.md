# wk.currency.rates

Это модуль для автоматического получения курсов валют из cbr.ru
Будут обновляться валюты, прописанные в системе. Содержит так же компонент, который выводит виджет с текущими курсами.

### установка
Распаковать в корень и установить из админки. 
При установке модуля появится агент, настроеный на срабатываение раз в сутки. 

### использование
Обновление курсов можно так же запустить в init.php (например), вот таким образом
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

### экшены
Директория /api сожержит экшены. Они заработают, когда в системе будут иметься курсы валют.

- возвращает символьные коды всех существующих валют
  *пример запроса:* **GET {host}/api/currency-codes** 
  
- возвращает массив объектов всех курсов валют и позволяет применить фильтрацию по значению (больше,    меньше, больше или равно, меньше или равно) и сортировку по значению
  *пример запроса:* **GET {host}/api/currency**
  *пример запроса с фильтрацией и сортировкой:* **GET {host}/api/currency?filters[value][gte]=50&filters[value][lt]=100&order[field]=value&order[direction]=asc**
  ___Работает так:___
  ***filters[value][gte]=50*** - это больше 50
  ***filters[value][lt]=100*** - это меньше 100
  аналогично
  ***filters[value][gte_]=50*** - это больше или равно 50
  ***filters[value][lt_]=100*** - это меньше или равно 100
- возвращает одну запись курса валют по символьному коду
  *пример запроса:* **GET {host}/api/currency/USD**
  Чтобы работал этот экшн, надо добавить в urlrewrite.php правило
```php
  65 => [
	  'CONDITION' => '#^/api/currency/(\D{3})#',
	  'RULE' => 'CURRENCY=$1',
	  'ID' => '',
	  'PATH' => '/api/currency/index.php',
	  'SORT' => 100,
  ],
```
Ответы с экшенов отдаются в json.
