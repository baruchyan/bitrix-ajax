<?php


namespace Baruchyan\BitrixAjax;

use Bitrix\Main\Application;
use Bitrix\Main\Loader;

/**
 * Class BaseAjax
 * @package Baruchyan\BitrixAjax
 */
class BaseAjax
{
    /** @var array  */
    protected $response;

    /** @var \Bitrix\Main\Server */
    protected $server;

    /** @var  \Bitrix\Main\HttpRequest */
    protected $request;

    /** @var \CUser */
    protected $user;

    /** @var int */
    protected $userId;

    /** @var bool */
    protected $status = false;

    /** @var string */
    protected $message = '';

    /** @var array */
    protected $errors = [];

    /** @var array */
    protected $fields = [];

    /** @var string */
    protected $siteId;


    /**
     * BaseAjax constructor.
     * @param string $action
     * @param string $siteId
     */
    public function __construct(string $action, string $siteId)
    {
        $this->initProperties();
        $methodName = $this->makeMethodName($action);

        $this->siteId = $siteId;

        if(method_exists($this, $methodName)){
            $this->$methodName();

            $this->response = [
                'status' => $this->status,
                'message' => $this->message,
                'errors' => $this->errors,
                'fields' => $this->fields
            ];
        }

    }

    /**
     *
     */
    protected function initProperties(): void
    {
        $context = Application::getInstance()->getContext();
        $this->server = $context->getServer();
        $this->request = $context->getRequest();

        global $USER;
        $this->user = $USER;
        $this->userId = $USER->GetID();

    }

    /**
     * @param $modules
     */
    protected function includeModules($modules): void
    {
        if(empty($modules))
            return;

        foreach ($modules as $module){
            Loader::includeModule($module);
        }

    }

    /**
     * Преобразование имени контроллера
     * @param mixed $controller
     * @return string
     */
    static public function modifyControllerName($controller): string
    {

        $result = '';

        if(is_array($controller)){

            $parts = explode('_', array_pop($controller));

            foreach ($controller as $controllerItem){
                $result .= ucfirst($controllerItem).'\\';
            }

        }else{
            $parts = explode('_', $controller);
        }

        if(empty($parts))
            return '';

        foreach($parts as $part){
            $result .= ucfirst($part);
        }

        return $result;

    }

    /**
     * Создаем имя метода
     * @param string $action
     * @return string
     */
    protected function makeMethodName(string $action): string
    {
        $parts = explode('_', $action);

        if(empty($parts))
            return '';

        $result = '';

        foreach($parts as $part){
            $result .= ($result) ? ucfirst($part) : $part;
        }

        return $result.'Action';

    }

    /**
     * Добавление ошибки
     * @param string $error
     */
    protected function addError(string $error): void
    {
        $this->errors[] = $error;
    }

    /**
     * Проверяет пустой или нет массив ошибок
     * @return bool
     */
    protected function isEmptyErrors(): bool
    {
        return empty($this->errors);
    }


    /**
     * Установка статуса true
     * @param string $message
     */
    protected function setSuccessStatus($message = ''): void
    {
        $this->status = true;

        if(!empty($message))
            $this->message = $message;
    }

    /**
     * Установка статуса false
     */
    protected function setFailureStatus(): void
    {
        $this->status = false;
    }

    /**
     * Установка значения поля
     * @param string $field
     * @param $value
     */
    protected function setField(string $field, $value): void
    {
        $this->fields[$field] = $value;
    }

    /**
     * Установка сообщения
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}