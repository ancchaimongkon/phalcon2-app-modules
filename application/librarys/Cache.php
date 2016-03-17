<?php

/* 
 * Cache Library v1.0.0
 * Updated : 2016-03-17 21:48
 * -------------------------------------------------------------
 * Eakkabin Jaikeawma <eakkabin@drivesoft.co>
 * Website : https://drivesoft.co/
 * -------------------------------------------------------------
 */

namespace Multiple\Librarys;

use Phalcon\Cache\Frontend\Output as CacheOutput;
use Phalcon\Cache\Backend\File as CacheFile;
use Multiple\Components\CComponent;

class Cache extends CComponent {
    
    /* ===========================================================
     * Cache 
     * =========================================================== */
    
    public $cacheTime = 2; // ระยะเวลาการใช้งานไฟล์ Cache (วัน)
    public $cacheDir = '/application/runtime/caches/HTML/'; // ไดเรคทอรี่เก็บไฟล์ Cache
    public $cacheFileName = 'cache'; // ชื่อไฟล์ Cache
    public $cacheFileType = '.cache'; // นามสกุลไฟล์ Cache
    
    public function cacheHTML($html = null, $realtime = false, $lifetime = null, $filename = '', $cacheDir = null){
        
        // จัดเก็บไดเรคทอรี่เก็บไฟล์ Cache
        $_cacheDir = !empty($cacheDir) ? ROOT_PATH . $cacheDir : ROOT_PATH . $this->cacheDir;
        
        // กรณีไม่พบไดเรคทอรี่ ให้ดำเนินการสร้างไดเรคทอรี่ใหม่ (อัตโนมัติ)
        if (!is_dir($_cacheDir)) { mkdir($_cacheDir, 0777); }
        
        // กำหนดระยะเวลาการใช้งานไฟล์ Cache (หมดอายุ)
        $setCache = new CacheOutput(array(
            'lifetime' => (86400 * !empty($lifetime) ? $lifetime : $this->cacheTime) // 86400 = 24 ชั่วโมง / 1 วัน
        ));
        
        // กำหนดไดเรคทอรี่เก็บไฟล์ Cache
        $cache = new CacheFile($setCache, array( 'cacheDir' => $_cacheDir ));
        
        // กำหนดชื่อไฟล์ Cache
        $content = $cache->start(!empty($filename) ? $filename . $this->cacheFileType : $this->cacheFileName . $this->cacheFileType);
        
        // ตรวจสอบการทำงานแบบ Realtime
        if (empty($realtime)) {
            
            // ปิดการทำงานแบบ Realtime
           
            // ตรวจสอบข้อมูลคำสั่ง HTML
            if ($content === null) {
            
                // ไม่พบข้อมูลคำสั่ง HTML
                echo $html;
                $cache->save(); // จัดเก็บไฟล์ Cache

            } else {
                
                // พบข้อมูลคำสั่ง HTML
                echo $content;
                
            }
            
        } else {
            
            // เปิดการทำงานแบบ Realtime
            
            echo $html;
            
        }
        
    }
    
}