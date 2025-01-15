<?php
namespace skensa\Belajar\PHP\MVC;

// $appPath = dirname(__DIR__);
$appPath = str_replace("\\","/",dirname(__FILE__));
define('APP_PATH', $appPath);

$docRoot = dirname($appPath);
define('DOC_ROOT', $docRoot);

// require_once __DIR__ . '../vendor/autoload.php';
spl_autoload_register(function($className) use ($appPath)
{
    $realClass = str_replace(__NAMESPACE__, "", $className);
    $realClass = trim(str_replace("\\","/",$realClass), "/");
    $classPath = $appPath;
    $classFile ="{$classPath}/{$realClass}.php";
    include_once($classFile);
});

include_once("$appPath/Config/routes.php");

\skensa\Belajar\PHP\MVC\App\Router::run();

