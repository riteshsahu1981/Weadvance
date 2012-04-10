<?php
class Base_Acl  extends Zend_Acl{
	
    public function __construct()
    {
 	$this->setRoles();
//        $this->setResources();
//        $this->setPrivilages();
    }
	
    public function setRoles()
    {
        $this->addRole(new Zend_Acl_Role('guest'));   
        
        $this->addRole(new Zend_Acl_Role('administrator'), 'guest');
    }
    
    public function setResources()
    {   
        
        /** Default module */
        $this->add(new Zend_Acl_Resource('default'))
        ->add(new Zend_Acl_Resource('default:error','default'))
        
        ->add(new Zend_Acl_Resource('default:seo-url','default'))
        
       ->add(new Zend_Acl_Resource('default:db-config','default'))
        ->add(new Zend_Acl_Resource('default:log','default'))
        ->add(new Zend_Acl_Resource('default:index','default'))
                ->add(new Zend_Acl_Resource('default:auth','default'))
          ->add(new Zend_Acl_Resource('default:user','default'));
        
        
        
        /// demomodle module
       // $this->add(new Zend_Acl_Resource('demomodule'))
             //   ->add(new Zend_Acl_Resource('demomodule:index', 'index'));
        // admin module
        $this->add(new Zend_Acl_Resource('admin'))
                ->add(new Zend_Acl_Resource('admin:index', 'admin'))
                
                ->add(new Zend_Acl_Resource('admin:dashboard', 'admin'))
                 ->add(new Zend_Acl_Resource('admin:log', 'admin'))
                ->add(new Zend_Acl_Resource('admin:user-privilege', 'admin'))
                ->add(new Zend_Acl_Resource('admin:db-config', 'admin'))
                ->add(new Zend_Acl_Resource('admin:customer', 'admin'))
                ->add(new Zend_Acl_Resource('admin:supplier', 'admin'))
                ->add(new Zend_Acl_Resource('admin:product', 'admin'))
                 ->add(new Zend_Acl_Resource('admin:location', 'admin'))
                 ->add(new Zend_Acl_Resource('admin:organization', 'admin'))
                ->add(new Zend_Acl_Resource('admin:widget', 'admin'))
                 ->add(new Zend_Acl_Resource('admin:bookmark', 'admin'))
                
            ;
                      
        
        // security module
        
        $this->add(new Zend_Acl_Resource('security'))
                ->add(new Zend_Acl_Resource('security:user', 'security'))
                ->add(new Zend_Acl_Resource('security:privilege', 'security'))
                ->add(new Zend_Acl_Resource('security:legend', 'security'))
                ->add(new Zend_Acl_Resource('security:menu', 'security'))
                ->add(new Zend_Acl_Resource('security:animal', 'security'))
                ->add(new Zend_Acl_Resource('security:action', 'security'))
                ->add(new Zend_Acl_Resource('security:db-config', 'security'))
                ->add(new Zend_Acl_Resource('security:sys-config', 'security'))
                ->add(new Zend_Acl_Resource('security:sys-message', 'security'))
                
                
            ;
        
        
        // mps module
        
        $this->add(new Zend_Acl_Resource('mps'))
                ->add(new Zend_Acl_Resource('mps:index', 'mps'))
                ->add(new Zend_Acl_Resource('mps:app', 'mps'))
                ->add(new Zend_Acl_Resource('mps:auth', 'mps'))
                
                ->add(new Zend_Acl_Resource('mps:buying', 'mps'))
                ->add(new Zend_Acl_Resource('mps:production', 'mps'))
                ->add(new Zend_Acl_Resource('mps:inventory', 'mps'))
                ->add(new Zend_Acl_Resource('mps:office-retail', 'mps'))
                ->add(new Zend_Acl_Resource('mps:order-processing', 'mps'))
                ->add(new Zend_Acl_Resource('mps:shipping', 'mps'))
                ->add(new Zend_Acl_Resource('mps:reports', 'mps'))
                
            ;
    }

    public function setPrivilages()
    {
        /* guest */
	$this->allow('guest',array( 'default:error',"mps:auth" , 'default:index'));
        
        
        /* administrator*/
	$this->allow('administrator');
    }
}
