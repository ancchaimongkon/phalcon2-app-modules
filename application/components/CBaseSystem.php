<?php

use Phalcon\Mvc\User\Component;

class CBaseSystem extends Component {
    
    /* ===========================================================
     * Web Site
     * =========================================================== */
    
    /* เวอร์ชั่นเว็บไซต์ */
    public $version = '0.0.4';
    
    /* วันที่อัพเดทเว็บไซต์ล่าสุด */
    public $lastUpdate = '2015-08-07 09:58:25';
    
    /* ชื่อหัวเว็บไซต์ */
    public $pageTitle = 'Web Application | Phalcon Framework 2';
    
    
    /* ===========================================================
     * เปิด / ปิด ระบบ Access Control List (ACL)
     * =========================================================== */
    
    public $securityStart       = true;
    public $securityRealtime    = true; // อัพเดทตลอดเวลา
    
    
}