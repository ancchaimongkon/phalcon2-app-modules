<?php

/* ==================================================
 * ลงทะเบียน Modules
 * Register application modules
 * ================================================== */

$config = $this->config;   // Read the configuration
$addModule = explode(',',$config->module->moduleLists);

$modules = array();
foreach ($addModule as $recode) {
    $modules[$recode] = array(
        'className' => ucfirst($recode) . '\Module',
        'path'      => sprintf('%s/modules/%s/Module.php', APPLICATION_PATH, $recode),
    );
}
$this->registerModules($modules);