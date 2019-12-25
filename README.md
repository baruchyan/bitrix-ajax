# Bitrix Ajax Package

Пакет для работы с Ajax в Битрикс
Для работы с обменом, больше не надо подключать стандартный компонент обмена или создавать его копию.

## Установка
```sh
composer require baruchyan/bitrix-ajax
```

## Принцип работы

Для демонстрации работы библиотеки из JS обратимся к файлу ajax.php^ пример файла находится в папке examples

```js
$.post('ajax.php',
        {
            controller: ['app', 'ajax', 'catalog', 'params'],
            action: 'set_params',
            params: params,
        },
        function(data) {

            console.log(data);

            if(data.status){
                // your actions
                console.log(data.fields.count);
            }

        }, 'json');
```
В параметр controller указываем части namespace к классу ajax, который будет наслдеовать класс BaseAjax из пакета 

```php
namespace App\Ajax\Catalog;

use Baruchyan\BitrixAjax\BaseAjax;


/**
 * Class Params
 * @package App\Ajax\Catalog
 */
class Params extends BaseAjax
{

    /**
     *  Пример Action setParams
     */
    protected function setParamsAction(): void
    {

    
        $params = $this->request->get('params');
        
        $this->setField('count', 10);

        $this->setSuccessStatus();
    }

}
```

Если не выполнять никаких действий метод getResponse вернет массив 
```php
'status' => false, // статус true/ false
'message' => '', // сообщение 
'errors' => [], // массив ошибок 
'fields' => [] // массив дополнительных полей ответа
```

В классе Params устанавливаем статус в true и передаем дополнительное поле count с значением 10