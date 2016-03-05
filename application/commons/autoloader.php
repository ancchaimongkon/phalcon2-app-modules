<?php

/* =====================================================
 * โหลดอัตโนมัติ
 * ลงทะเบียนโฟล์เดอร์
 * ===================================================== */
$loader = new \Phalcon\Loader();
$loader->registerDirs(
    array(
        // เพิ่มเติม
        APPLICATION_PATH . '/' . $this->config->application->componentsDir, 
    )
)->register();
