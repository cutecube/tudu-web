<?php
/**
 * 程序入口文件
 *
 * @version $Id: index.php 1547 2012-02-03 07:22:07Z web_op $
 */

ini_set('include_path', dirname(__FILE__) . '/../../../library:' . ini_get('include_path'));

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Define path to www root directory
defined('WWW_ROOT')
    || define('WWW_ROOT', realpath(APPLICATION_PATH . '/../../../'));

// Define language pack path
defined('LANG_PATH')
    || define('LANG_PATH', realpath(APPLICATION_PATH . '/../lang'));

// PROTOCOL
defined('PROTOCOL')
    || define('PROTOCOL', (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ? 'https:' : 'http:');

// HOST
defined('HOST')
    || define('HOST', $_SERVER['HTTP_HOST']);

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap(array('FrontController', 'multidb', 'memcache', 'application', 'session', 'view'))
            ->run();