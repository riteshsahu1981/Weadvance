<?php
/**
 * Base_Controller_Action
 * 
 * @author : ritesh
 * @version  
 */
  
class Base_Controller_Action extends Zend_Controller_Action {	
	
	public function init()
        {
         
            $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $this->initView();
        }
	
        public function routeStartup()
        {
            parent::routeStartup();
          
        }
	public function postDispatch()
        {
           
            parent::postDispatch();
           // if(APPLICATION_ENV=="development")
             //   $this->view->headTitle(" Layout --> ".$this->view->layout()->getLayout()." <-- Layout ");
	}

        public function preDispatch()
        {
            parent::preDispatch();
            $request=$this->getRequest();
            $this->view->module=$request->getModuleName();
            $this->view->actionName=$request->getActionName();
            $this->view->controllerName=$request->getControllerName();
            $this->view->params=$params=$request->getParams();
            $this->view->metas($params);
            
            
            $this->initACL();
            $this->nav();
            $this->checkACL();
            $this->setAppLayout();
            
            
            
            /*--get current menu id */
            $uri="/".$request->getModuleName()."/".$request->getControllerName()."/".$request->getActionName();
            $security=new Base_Security_Menu();
            $menu=$security->getMenuItemByUri($uri);
            $this->view->menuId=null;
            if(false!==$menu)
            {
                $this->view->menuId=$menu->getMasterId();
            }
            /*------------------------*/
            
        }
        
        public function nav()
        {
            $roleName=$this->view->roleName;    		
            $acl=Zend_Registry::get('acl');
            $request=$this->getRequest();
            $menu=new Base_Security_Menu();
            $navigation=$menu->getContainer( $request->getRequestUri());
            $this->view->navigation($navigation)->setAcl($acl)->setRole($roleName);
        }
        
        public function initACL()
        {
            $model=new Security_Model_SystemMaster();
            $result=$model->fetchAll("master_code='fdMenu' and status='1'");
            $acl=new Base_Acl();
            foreach($result as $row)
            {
                $arrUrl=explode("/",$row->getStrval1());
                $module=$arrUrl[1];
                $controller=$arrUrl[2];
                $action=$arrUrl[3];
                
                if(!$acl->has("$module:$controller"))
                    $acl->add(new Zend_Acl_Resource("$module:$controller"));
                //$acl->deny('administrator', "$module:$controller", $action);
            }
            
            $acl->add(new Zend_Acl_Resource('default:error'))
                  ->add(new Zend_Acl_Resource('mps:auth'))
                  ->add(new Zend_Acl_Resource('default:index'))
                    ;
            
            $acl->allow('guest',array( 'default:error',"mps:auth" , 'default:index'));
           $acl->allow('administrator',array("mps:app" )); // prototype
            
            
            $model=new Security_Model_SystemMapping();
            
            $userGroupId=$this->view->userGroupId;    		
            $userSubGroupId=$this->view->userSubGroupId;    		
            $userRoleId=$this->view->userRoleId;
            $userId=$this->view->userId;
            
            $arrG=array();
            $res=$model->fetchAll("map_code='fdMenuGroupMap' and map_id2='{$userGroupId}'");
            if(count($res)>0)
            {
                foreach($res as $_row)
                {
                    $arrG[]=$_row->getMapId1();
                }
            }
            
            $res=$model->fetchAll("map_code='fdMenuSubGroupMap' and map_id2='{$userSubGroupId}'");
            if(count($res)>0)
            {
                foreach($res as $_row)
                {
                    $arrG[]=$_row->getMapId1();
                }
            }
            
            $res=$model->fetchAll("map_code='fdMenuRoleMap' and map_id2='{$userRoleId}'");
            if(count($res)>0)
            {
                foreach($res as $_row)
                {
                    $arrG[]=$_row->getMapId1();
                }
            }
            
            $res=$model->fetchAll("map_code='fdMenuUserMap' and map_id2='{$userId}'");
            if(count($res)>0)
            {
                foreach($res as $_row)
                {
                    $arrG[]=$_row->getMapId1();
                }
            }
            
            $arrG=array_unique($arrG);
            $strid=implode("','", $arrG);
            $model=new Security_Model_SystemMaster();
            $result=$model->fetchAll("master_code='fdMenu' and master_id in ('{$strid}')");
            if(count($result)>0)
            {
                
                foreach($result as $row)
                {
                    $arrUrl=explode("/",$row->getStrval1());
                    $module=$arrUrl[1];
                    $controller=$arrUrl[2];
                    $action=$arrUrl[3];
//                    echo "<pre>";
//                    print_r($arrUrl);
//                    echo "</pre>";
                    $acl->allow('administrator', "$module:$controller", $action);    
                }
            }
            $acl->allow('administrator', 'security:menu', array('get-permission','save-permission'));
            
            Zend_Registry::set('acl', $acl);
        }
        public function checkACL()
        {
            
            $request=$this->getRequest();
            $module=$request->getModuleName();
            $action=$request->getActionName();
            $controller=$request->getControllerName();
            
            $roleName=$this->view->roleName;    		
            $acl=Zend_Registry::get('acl');
           //echo $module.":".$controller.":".$action;exit;
            if(!$acl->isAllowed($roleName,$module.":".$controller,$action))
            {
                if($roleName=='guest')
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Unauthorized access or your session has been expired!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/auth/login'));
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Unauthorized access!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/app/dashboard'));
                }
            }
        }
        
        public function setAppLayout()
        {
            $request=$this->getRequest();
            $module=$request->getModuleName();
            $action=$request->getActionName();
            $controller=$request->getControllerName();
            
            $layout="main-layout";
            if(($module=="default" || $module=="mps"  )&& ($controller=="index" || $controller=="auth" ) && ( $action=="login" || $action=="index" || $action=="forgot-password" ))
                $layout="login-layout";
            $this->_helper->layout->setLayout($layout);
        }
} 
