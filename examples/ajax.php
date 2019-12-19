<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

$controllerName = $request->get('controller');
$action = $request->get('action');
$siteId = 's1';

$controllerName = Baruchyan\BitrixAjax\BaseAjax::modifyControllerName($controllerName);

if(class_exists($controllerName)){

    $controller = new $controllerName($action, $siteId);
    $response = $controller->getResponse();

}else{
    $response = [];
}

echo json_encode($response);

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
