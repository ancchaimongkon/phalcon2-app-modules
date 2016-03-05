<?php

use Phalcon\Mvc\User\Component;

class CBaseSystem extends Component {
    
    /* ===========================================================
     * Web Site
     * =========================================================== */
    
    /* เวอร์ชั่นเว็บไซต์ */
    public $version = '1.0.0';
    
    /* วันที่อัพเดทเว็บไซต์ล่าสุด */
    public $lastUpdate = '2016-02-05 13:31:00';
    
    /* ชื่อหัวเว็บไซต์ */
    public $pageTitle = 'Web Application | Phalcon Framework 2.0.10';
    
    /* ===========================================================
     * เปิด / ปิด ระบบ Access Control List (ACL)
     * =========================================================== */
    
    public $securityStart       = true;
    public $securityRealtime    = true; // อัพเดทตลอดเวลา
    
}