<?php
class Base_View_Helper_CheckAcl extends Zend_View_Helper_Abstract
{
	
	public function checkAcl($uri)
	{
            
            if(preg_match("/^\/([a-z\-]+)\/([a-z\-]+)\/([a-z\-]+)$/", $uri, $matches))
            {
                $roleName=$this->view->roleName;    		
                $module=$matches[1];
                $controller=$matches[2];
                $action=$matches[3];
                
                $acl=Zend_Registry::get('acl');
                if($acl->isAllowed($roleName,$module.":".$controller,$action))
                   return true; 
                else
                    return false;
            }
            else
            {
                return false;
            }
	}
}