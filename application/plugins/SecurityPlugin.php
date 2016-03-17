<?php

namespace Multiple\Plugins;

use Phalcon\Acl,
    Phalcon\Acl\Role,
    Phalcon\Acl\Resource,
    Phalcon\Events\Event,
    Phalcon\Mvc\User\Plugin,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Acl\Adapter\Memory as AclList,
    CBaseSystem as BaseComponent;    
// use Phalcon\Acl\Resource as AclResource;

/* =======================================================
 * ระบบกำหนดสิทธิ์การเข้าถึงข้อมูล
 * ======================================================= */

class SecurityPlugin extends Plugin {
        
    private $_status;
    private $_enable = true;
    private $_module;

    private $acl;
    private $_roles;

    /* ====================== บทบาทหน้าที่ ======================
     * - ระดับ Admin ผู้ดูแลระบบ
     * - ระดับ Member สมาชิก
     * - ระดับ Guest ผู้ใช้ทั่วไป
     * ======================================================= */

    private $roles = array(
        'admin'  => 'Admin',  // ผู้ดูแลระบบ
        'member' => 'Member', // สมาชิก
        'guest'  => 'Guest',  // ผู้ใช้ทั่วไป
    );

    private $arrAcl = array(
        
        'frontend' => array(
            'Admin' => array(),
            'Member' => array(),
            'Guest' => array(
//                'main' => array('index'),
            ),
        ),
        
        /**
         * 'moduleName' => array(
         *   'roleName' => array(
         *     'controllerName' => array('actionName','actionName'),
         *     'controllerName' => array('actionName','actionName'),
         *   ),
         * ),
         **/
        
    );
    
    /* เปิด / ปิด ระบบกำหนดสิทธิ์การเข้าถึง */
    public function __construct() {
        $baseSystem = new BaseComponent();
        $this->_status = $baseSystem->securityStart;
    }
    
    /* เปิด / ปิด ระบบอัพเดทตลอดเวลา */
    public function setModule($module = 'frontend') {
        if(!empty($module)){
            $this->_module = $module;
        }
    }

    /* New access control list */
    public function getAcl(){
        
        if (!isset($this->persistent->acl) || !empty($this->_enable)) {
            
            $this->acl = new AclList();
            $this->acl->setDefaultAction(Acl::DENY);
             
            // ดึงข้อมูล "บทบาทหน้าที่" 
            foreach ($this->roles as $roleKey => $roleName) {
                // ext. $roles['admin'] = new Role('Admin');
                $roles[$roleKey] = new Role($roleName);
            }
            $this->_roles = $roles;
            
            // ลงทะเบียน "บทบาทหน้าที่"
            foreach ($roles as $role) {
                $this->acl->addRole($role);
            }
            
            // ผู้ดูแลระบบ
            $this->setRoleAdmins();
            
            // สมาชิก
            $this->setRoleMembers();
            
            // ทั่วไป
            $this->setRoleGuest();
            
            $this->persistent->acl = $this->acl;
            
        }
        
        return $this->persistent->acl;
        
    }
    
    private function setRoleAdmins(){
        
        // ผู้ดูแลระบบ
        if(!empty($this->arrAcl[$this->_module]['Admin'])){
            
            $adminResources = $this->arrAcl[$this->_module]['Admin'];
            foreach ($adminResources as $resource => $actions) {
                $this->acl->addResource(new Resource($resource), $actions);
            }
            
            // Setting Role Admin
            foreach ($adminResources as $resource => $actions) {
                foreach ($actions as $action){
                    $this->acl->allow('Admin', $resource, $action);
                }
            }
            
        }
        
    }
    
    private function setRoleMembers(){
        
        // สมาชิก
        if(!empty($this->arrAcl[$this->_module]['Member'])){
            
            $memberResources = $this->arrAcl[$this->_module]['Member'];
            foreach ($memberResources as $resource => $actions) {
                $this->acl->addResource(new Resource($resource), $actions);
            }
            
            // Setting Role Member
            foreach ($memberResources as $resource => $actions) {
                foreach ($actions as $action){
                    $this->acl->allow('Member', $resource, $action);
                }
            }
            
        }
        
    }
    
    private function setRoleGuest(){
        
        // ทั่วไป
        if(!empty($this->arrAcl[$this->_module]['Guest'])){
            
            $guestResources = $this->arrAcl[$this->_module]['Guest'];
            foreach ($guestResources as $resource => $actions) {
                $this->acl->addResource(new Resource($resource), $actions);
            }
            
            // Setting Role Public
            foreach ($this->_roles as $role) {
                foreach ($guestResources as $resource => $actions) {
                    foreach ($actions as $action){
                        $this->acl->allow($role->getName(), $resource, $action);
                    }
                }
            }
            
        }
        
    }
    
    public function beforeDispatch(Event $event, Dispatcher $dispatcher){
        
        if($this->_status){
            
            $auth = $this->session->get('auth');
            
            if (!$auth) {
                $role = 'Guest'; /* บทบาทเริ่มต้น */
            } else {
                $role = $auth['role'];
            }
            
            $controller = $dispatcher->getControllerName();
            $action     = $dispatcher->getActionName();
            $acl        = $this->getAcl();
            $allowed    = $acl->isAllowed($role, $controller, $action);
            
            if ($allowed != Acl::ALLOW) {
               
                /*
                // Getting a response instance
                $response = new \Phalcon\Http\Response();
                $response->redirect('/user/login', true);
                $response->send();
                */
                
                echo 'Role : ' . $role;
                echo '<br />';
                echo 'Controller : ' . ucfirst($controller) . 'Controller';
                echo '<br />';
                echo 'Action : ' . $action . 'Action()'; 
                echo '<br />';
                exit();
                
                return false;
                
            }
            
        } else {
            return true;
        }
        
    }
    
}