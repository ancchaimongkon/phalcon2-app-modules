<?php

use Phalcon\Mvc\Url as UrlManager,
    Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
    Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter,
    Phalcon\Session\Adapter\Files as SessionAdapter,
    Phalcon\Logger\Adapter\File as LogFile;

/* กำหนด Url เบื้องต้น */
$manager->set('url', function (){
    $url = new UrlManager();
    $url->setBaseUri($this->config->application->baseUri);
    return $url;
}, true);

/* เชื่อมต่อฐานข้อมูล */
$manager->set('db', function () {
    return new DbAdapter(array(
        'host'      => $this->config->database->host,
        'username'  => $this->config->database->username,
        'password'  => $this->config->database->password,
        'dbname'    => $this->config->database->dbname,
        'options'   => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->config->database->charset
        )
    ));
});

/* เปิดใช้งาน Session */
$manager->set('session', function () {
    $session = new SessionAdapter();
    $session->start();
    return $session;
});

$manager->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

// เปิดใช้งานระบบเก็บข้อมูล Log
$manager->set('logger', function (){
    $monthNow = date('Y-m-d',time());
    $pathLog = sprintf('%s/%s/%s.log', APPLICATION_PATH, $this->config->application->logsDir, $monthNow);
    $logger = new LogFile($pathLog);
    return $logger;
});

/* ==================================================
 * ลงทะเบียน Component & Librarys ที่เราสร้างขึ้นเอง
 * ================================================== */

/* ข้อมูลการตั้งค่าต่าง ๆ */
$manager->set('base', function(){
    return new CBaseSystem(); // ex. $this->base->xxxx;
});

/* ดึงข้อมูลทั่วไป */
$manager->set('main', function(){
    return new CMainSystem(); // ex. $this->main->xxxx;
});