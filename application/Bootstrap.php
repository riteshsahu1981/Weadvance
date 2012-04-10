<?php
//ritesh
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
   


    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');
    }
 

    protected function _initRegistry()
    {
        
        $this->bootstrap('db');
        $db = $this->getResource('db');
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        Zend_Registry::set('db', $db);


        $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', APPLICATION_ENV);
        Zend_Registry::set('siteurl', $config->gd->siteurl);
        Zend_Registry::set('domain', $config->gd->domain);
        Zend_Registry::set('cdn_uri', $config->gd->cdn_uri);
        
        
        
        
        $select=$db->select()->from('sys_config')
                ->where("config_id='15'");
        $res=$db->fetchRow($select);
        $page_size=25;
        if($res)
        {
            $page_size=$res->param1;
        }
        
        Zend_Registry::set('page_size', $page_size);
        
        $select=$db->select()->from('sys_config')
                ->where("config_id='16'");
        $res=$db->fetchRow($select);
        $page_size=15;
        if($res)
        {
            $page_size=$res->param1;
        }
        Zend_Registry::set('bookMark_limit', $page_size);
        
        
                $locale = new Zend_Locale('en'); 
                
                $translate = new Zend_Translate(
                    array(
                            'adapter' => 'csv',
                            'content' => APPLICATION_PATH.'/languages/en_US/en_US.csv',
                            'locale'  => 'en',
                            'delimiter' => ','
                         )
                );
                
                Zend_Registry::set('translate', $translate);
                
                //$translate->setLocale( $locale->getLanguage() );
                
    }
    
   

	
    protected function _initViewHelpers()
    {
        
        $this->bootstrap('layout');
        $layout=$this->getResource('layout');
        $view=$layout->getView();
        $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        $view->addHelperPath('Base/View/Helper/', 'Base_View_Helper');



        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        ZendX_JQuery::enableView($view);
   		
    }
    protected function _initACL()
    {
        $acl=new Base_Acl();
        Zend_Registry::set('acl', $acl);
    }
    
    protected function _initViewVars()
    {
        $this->bootstrap('layout');
        $layout=$this->getResource("layout");
        $view=$layout->getView();
        $view->roleName='guest';
        $usersNs = new Zend_Session_Namespace("members");
        if($usersNs->userType<>'')
        {
            $view->roleName=$usersNs->userType;
            $view->userFullName=$usersNs->userFullName;
            $view->userId=$usersNs->userId;
            $view->userEmail=$usersNs->userEmail;
            $view->userFirstName=$usersNs->userFirstName;
            $view->userUsername=$usersNs->userUsername;
            $view->userGroupId=$usersNs->userGroupId;
            $view->userSubGroupId=$usersNs->userSubGroupId;
            $view->userRoleId=$usersNs->userRoleId;
        }
    }
    
    protected function _initNavigation()
    {
//        $this->bootstrap('layout');
//        $layout=$this->getResource("layout");
//        $view=$layout->getView();
//       
//
//        $navigation= new Zend_Navigation(); 
//        $front = $this->getResource('frontcontroller');
//        $modules = $front->getControllerDirectory();
//        $arrModules=array();
//          foreach (array_keys($modules) as $module) 
//          {
//               $navPath  = $front->getModuleDirectory($module). DIRECTORY_SEPARATOR . 'configs'. DIRECTORY_SEPARATOR .'navigation'. DIRECTORY_SEPARATOR .'navigation.xml';
//                if(is_file($navPath)){
//                    $weight=new Zend_Config_Xml($navPath,'weight');  
//                    $arrModules[$weight->weight]=$module;
//                }
//                
//                
//          }
//          ksort($arrModules);
//          if(count($arrModules)>0){
//            foreach ($arrModules as $module) 
//            {
//                $navPath  = $front->getModuleDirectory($module). DIRECTORY_SEPARATOR . 'configs/navigation/navigation.xml';
//                $pages=new Zend_Config_Xml($navPath,'nav');  
//                $navigation->addPages($pages);
//            }
//          }
//          
//        $acl= Zend_Registry::get('acl');
//        $view->navigation($navigation)->setAcl($acl)->setRole($view->roleName);       
        
        
//        $page = Zend_Navigation_Page::factory(array(
//    'type'    => 'Base_Navigation_Page_Uri',
//));
        
    }

    protected function _initDbSchema()
    {
         
        $front = $this->getResource('frontcontroller');
        $modules = $front->getControllerDirectory();
        $arrModules=array();
         foreach (array_keys($modules) as $module) 
         {
            $path  = $front->getModuleDirectory($module). DIRECTORY_SEPARATOR . 'configs'. DIRECTORY_SEPARATOR .'module.ini';
            
            if(is_file($path))
            {
                $config = new Zend_Config_Ini($path, APPLICATION_ENV);
                if($config->install_db_schema == 1)
                {
                    $dir  = $front->getModuleDirectory($module). DIRECTORY_SEPARATOR . 'data'. DIRECTORY_SEPARATOR ;
                        if (is_dir($dir)) 
                        {
                                if ($dh = opendir($dir)) 
                                {
                                    $db = $this->getResource('db');
                                    while (($file = readdir($dh)) !== false) {
                                    if(filetype($dir . $file)=="file")
                                    {
                                        try{
                                        $schema=file_get_contents($dir . $file);
                                        
                                        $db->query($schema);
                                        }
                                        catch(Zend_Db_Exception $e)
                                        {
                                            $msg= "Schema Filename : $dir$file <br>\n";
                                            $msg.= "Error Message".$e->getMessage();
                                            
                                            throw new Zend_Db_Exception($msg);
                                        }
                                    }

                                }
                                closedir($dh);
                            }
                    }
                }
                
            }
          }
          
          
    }
    
    
    protected function _initPlugin()
    {
            $front = Zend_Controller_Front::getInstance();
            $front->registerPlugin(new Base_Plugin_Action());


    }
    
    protected function _initJquery()
    {
        $this->bootstrap('layout');
        $layout=$this->getResource("layout");
        $view=$layout->getView();
        $view->jQuery()->enable();
        $view->jQuery()->uiEnable();
         $view->jQuery()->setLocalPath($view->baseUrl()."/js/jqueryui/jquery-1.7.1.min.js")
                                ->setUiLocalPath($view->baseUrl()."/js/jqueryui/jquery-ui-1.8.17.custom.min.js")
                                
                                ->addStylesheet($view->baseUrl()."/js/jqueryui/themes/ui-darkness/jquery-ui-1.8.18.custom.css")
                                ->addStylesheet($view->baseUrl()."/js/jqueryui/themes/ui-darkness/jquery.ui.tabs.css")
                                ->addStylesheet($view->baseUrl()."/js/jqueryui/themes/ui-darkness/jquery.ui.datepicker.css")
                                ->addStylesheet($view->baseUrl()."/js/jqueryui/themes/ui-darkness/jquery.ui.dialog.css")
                  
                 
            ;
    }
    protected function _initJavascript()
    {
        $this->bootstrap('layout');
        $layout=$this->getResource("layout");
       
        $view=$layout->getView();
        $view->headScript()->appendFile('/js/html5.js');   
        $view->headScript()->appendFile('/js/jquery.placeholder.js');
        $view->headScript()->appendFile('/js/cufon-yui.js');
        $view->headScript()->appendFile('/js/Arial_400.font.js');
        $view->headScript()->appendFile('/js/Arial_fontface.js');
        $view->headScript()->appendFile('/js/ddaccordion.js');
        $view->headScript()->appendFile('/js/menu_acc.js');
        $view->headScript()->appendFile('/js/jquery.mousewheel.js');
        $view->headScript()->appendFile('/js/jquery.jscrollpane.js');
        $view->headScript()->appendFile('/js/smartspinner.js');   
        
       $view->headScript()->appendFile('/js/jquery.keyboard.js')   ; 
       $view->headScript()->appendFile('/js/simpla.js')   ; 
       $view->headScript()->appendFile('/js/jquery.validate.js')   ; 
       
       $view->headScript()->appendFile('/js/smartspinner.js');
       //-------------- tree js
        $view->headScript()->appendFile("/js/tree/_lib/jquery.cookie.js");
        $view->headScript()->appendFile("/js/tree/_lib/jquery.hotkeys.js");
        $view->headScript()->appendFile("/js/tree/jquery.jstree.js");
        $view->headLink()->appendStylesheet('/js/tree/themes/default/style.css'); 
        //-------------- tree js
         $view->headScript()->appendFile("/js/fg.js");
        $view->headLink()->appendStylesheet('/style/fg.css');

                 
                 
          //----jquery jplot----//
            $view->headScript()->appendFile("/js/jqplot/jquery.jqplot.min.js");
            $view->headScript()->appendFile("/js/jqplot/plugins/jqplot.highlighter.min.js");
            $view->headScript()->appendFile("/js/jqplot/plugins/jqplot.cursor.min.js");
            $view->headScript()->appendFile("/js/jqplot/plugins/jqplot.dateAxisRenderer.min.js");
            $view->headScript()->appendFile("/js/jqplot/plugins/jqplot.dateAxisRenderer.min.js");

            $view->headLink()->appendStylesheet('/js/jqplot/jquery.jqplot.min.css');
                 
                 
        //---dropdown----
            $view->headScript()->appendFile("/js/ui.dropdownchecklist-1.4-min.js");
            $view->headLink()->appendStylesheet('/js/ui.dropdownchecklist.standalone.css');
            $view->headLink()->appendStylesheet('/js/ui.dropdownchecklist.themeroller.css');
                 
                 
    }
    
    protected function _initStylesheet()
    {
        $this->bootstrap('layout');
        $layout=$this->getResource("layout");
        $view=$layout->getView();
        
        $view->headLink()->appendStylesheet('/style/style.css')
                
                //it should be conditional
                ->appendStylesheet('/js/jquery.jscrollpane.css')
              ->appendStylesheet('/style/style_temp.css')
                ->appendStylesheet('/style/acc_menu.css')
                
                
                ->headLink(array('rel' => 'shortcut icon','href' => '/images/favicon.ico'),'PREPEND')
                ->headLink(array('rel' => 'apple-touch-icon','href' => '/images/favicon.png'),'PREPEND'); 
        
    }
    
    protected function _initMonitor()
    {
        
        /*
         CREATE TABLE IF NOT EXISTS `logentries` (
            `entryID` int(11) NOT NULL AUTO_INCREMENT,
            `logType` varchar(50) NOT NULL DEFAULT 'default',
            `projectName` varchar(20) NOT NULL DEFAULT 'not available',
            `environment` varchar(15) NOT NULL DEFAULT 'not available',
            `priority` int(11) NOT NULL,
            `errorNumber` int(11) DEFAULT NULL,
            `message` text NOT NULL,
            `file` varchar(255) DEFAULT NULL,
            `line` int(11) DEFAULT NULL,
            `context` longtext,
            `stacktrace` longtext,
            `timestamp` varchar(30) NOT NULL,
            `priorityName` varchar(15) NOT NULL,
            PRIMARY KEY (`entryID`)
            ) 
         */

        $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', APPLICATION_ENV);
        
        $monitorDb = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params);
        $monitor = new Base_Monitorix_Monitor(new Zend_Log_Writer_Db($monitorDb, 'logentries'), "yourProjectName");
        
        
        
        
        /*mail writer*/
//        $mail = new Base_Mail();
//        $mail->setFrom('riteshsahu1981@gmail.com')
//                ->addTo('ritesh.sahu@compunnel.com');
// 
//        $writer = new Zend_Log_Writer_Mail($mail);
//        
//        $monitor->addWriter($writer);
        /*mail writer*/
               
        //if you want to monitor php errors
        $monitor->registerErrorHandler();

        //if you want to log exceptions
        $monitor->logExceptions();

        //if you want to monitor javascript errors
        //$monitor->logJavascriptErrors();
        $dbAdapter=$this->getResource('db');
        //if you want to log slow database queries
        $monitor->logSlowQueries(array($dbAdapter));
        $monitor->registerShutdown();
        
    
    }
}