<?php

use Phalcon\Mvc\Url as UrlManager;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Logger\Adapter\File as LogFile;

$config = $this->config; // ดึงข้อมูล Config จากไฟล์ /public/index.php

/* ==================================================
 * กำหนด Url เบื้องต้น
 * The URL component is used to generate all kind of urls in the application
 * ================================================== */

$manager->set('url', function () use ($config) {
    $url = new UrlManager();
    $url->setBaseUri($config->application->baseUri);
    return $url;
}, true);

/* ==================================================
 * ตั้งค่าการเชื่อมต่อฐานข้อมูล
 * Database connection is created based in the parameters defined in the configuration file
 * ================================================== */

$manager->set('db', function () use ($config) {
    return new DbAdapter(array(
        'host'      => $config->database->host,
        'username'  => $config->database->username,
        'password'  => $config->database->password,
        'dbname'    => $config->database->dbname,
        'options'   => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $config->database->charset
        )
    ));
});

/* ==================================================
 * ตั้งค่าการเปิดใช้งาน Session
 * Start the session the first time some component request the session service
 * ================================================== */

$manager->set('session', function () {
    $session = new SessionAdapter();
    $session->start();
    return $session;
});

/* ==================================================
 * กำหนดค่ามาตรฐานข้อมูลของ Phalcon Fraemwork version 2.0.2
 * ================================================== */

// ดึงข้อมูล Config จากไฟล์ public/index.php 
$manager->set('config', function () use ($config) {
    return $config;
}, true);
$manager->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

// เปิดใช้งานระบบเก็บข้อมูล Log
$manager->set('logger', function () use ($config) {
    $monthNow = date("Y-m-d",time());
    $pathLog = APPLICATION_PATH . $config->application->logsDir . '/' . $monthNow . '.log';
    $logger = new LogFile($pathLog);
    return $logger;
});

/* ==================================================
 * ลงทะเบียน Component & Librarys ที่เราสร้างขึ้นเอง
 * Register an user component
 * ================================================== */

// ดึงข้อมูลหลัก เช่น ข้อมูลการตั้งค่าต่าง ๆ 
$manager->set('base', function(){
    // ex. $this->base->xxxx;
    return new CBaseSystem();
});
// ดึงข้อมูลทั่วไป
$manager->set('main', function(){
    // ex. $this->main->xxxx;
    return new CMainSystem();
});