<?php

use Phalcon\Mvc\User\Component;

class CBaseSystem extends Component {
    
    /* ===========================================================
     * Web Site
     * =========================================================== */
    
    /* เวอร์ชั่นเว็บไซต์ */
    public static $version = '1.0.0';
    
    /* วันที่อัพเดทเว็บไซต์ล่าสุด */
    public static $lastUpdate = '2016-03-17 23:27:00';
    
    /* ชื่อหัวเว็บไซต์ */
    public static $pageTitle = 'Web Application | Phalcon Framework 2.0.10';
    
    /* ลิ้งค์เว็บไซต์ */
    public static $baseUrl = 'http://localhost/github/drivesoftz/phalcon2-app-modules';
    public static $urlImage = 'http://localhost/github/drivesoftz/phalcon2-app-modules/images/';
    
    /* ===========================================================
     * เปิด / ปิด ระบบ Access Control List (ACL)
     * =========================================================== */
    
    public $securityStart    = false;
    public $securityRealtime = false; // อัพเดทตลอดเวลา
    
}