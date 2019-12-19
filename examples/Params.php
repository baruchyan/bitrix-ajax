<?php

namespace App\Ajax\Catalog;

use Baruchyan\BitrixAjax\BaseAjax;
use Bitrix\Main\Type\DateTime;
use Exception;

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