<?php
class Security_MenuController extends Base_Controller_Action
{

    public function indexAction()
    { 
        $menu_title = trim($this->_getParam('menu_title'));
        $this->view->linkArray=array();
        
        $menu=new Base_Security_Menu();
        $pages=$menu->getChildPages(0,0);
        $this->view->sortOptions=array();
        
        $this->view->menu_title="";
        if($menu_title<>"")
        {
            $this->view->linkArray['menu_title']=$menu_title;
            $this->view->menu_title=$menu_title;
            $arrObj=new Base_Array();
            $pages=$arrObj->search($pages, 'menu_title', $menu_title);
            $this->view->sortOptions['menu_title']=$menu_title;
            
        }
        
        
         /*---sorting ----*/
        $order = trim($this->_getParam('order', ""));
        $col = trim($this->_getParam('col',""));
        
        if($order<>"" && $col<>"")
        {
            $arrObj=new Base_Array();
            $arrObj->orderBy($pages, $col, $order);
        }
        /*----------------*/
        
        $page_size= Zend_Registry::get('page_size');
        $this->view->page = $page =	$this->_getParam('page',1);
        $paginator =  Base_Paginator::factory($pages);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator=$paginator;
    }
    
    public function getIconsList()
    {
        /* List of icons*/
        $iconFilePath="media/menu-icons";
        $dir = new DirectoryIterator($iconFilePath);
        $arr=array();
        
        foreach($dir as $fileInfo) {
            if($fileInfo->isDot()) {
            // do nothing
            } else {
            $arr[]=$fileInfo->__toString();
            }
        }
        $this->view->icons=$arr; 
        /*End list of icons*/

    }
    
    public function addMenuItemAction()
    {
	$request = $this->getRequest();
        $form    = new Security_Form_Menu();
        $elements=$form->getElements();
        $form->clearDecorators();
        foreach($elements as $element)
        {
            $element->removeDecorator('label');
            //$element->removeDecorator('Errors');
        }
        //echo $this->getFrontController()->getBaseUrl();
        $this->getIconsList();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
            if ($form->isValid($options))
            { 
                
                $model=new Security_Model_SystemMaster();
                $model->setMasterCode("fdMenu");
                $model->setMasterValue($options['title']);
                $model->setStatus($options['isActive']);
                $model->setStrval1($options['path']);
                $model->setStrval2($options['toolTip']);
                $model->setIntval1($options['parentMenuId']);
                $model->setBlnval1($options['isChild']);
                $model->setBlnval2($options['isAction']);
                $model->setStrval3($options['menuIcon']);
                
                $id=$model->save();
                if($id)  
                {
                    $this->_flashMessenger->addMessage(array('success'=>'Menu item added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/menu/add-menu-item'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add menu item!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/menu/add-menu-item'));
                }
               $form->reset();
            }
            else
            {
                $form->reset();
                $form->populate($options);
           }
        }
        $this->view->form =  $form;
    }
    
    
    public function editMenuItemAction()
    {
        $id = $this->_getParam('id');
        $guid = $this->_getParam('guid');
        $model1 = new Security_Model_SystemMaster();
        $model1->setMasterCode("fdMenu");
        $model = $model1->fetchRow("master_code ='".$model1->getMasterCode()."' AND master_id='".$id."'");
      
        if(false===$model || $model->getRowGuid()!=$guid)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/menu/index'));  
        }
          $this->getIconsList();
          
        $options['title'] = $model->getMasterValue();
        $options['path'] = $model->getStrval1();
        $options['toolTip'] = $model->getStrval2();
        $options['parentMenuId'] = $model->getIntval1();
        $options['isActive'] = $model->getStatus();
        $options['isChild'] = $model->getBlnval1();
        $options['isAction'] = $model->getBlnval2();
        $options['menuIcon'] = $model->getStrval3();
       
        
        
        $form    = new Security_Form_Menu();
        $elements=$form->getElements();
        $form->clearDecorators();
        foreach($elements as $element)
        {
            $element->removeDecorator('label');
            //$element->removeDecorator('Errors');
        } 
        
        $form->populate($options);
        
        $request = $this->getRequest();
        $options=$request->getPost();
       // echo "str val3=".$options['menuIcon']; die;
        if ($request->isPost()) 
        {
            if ($form->isValid($options))
            {
                $model->setMasterValue($options['title']);
                $model->setStatus($options['isActive']);
                $model->setStrval1($options['path']);
                $model->setStrval2($options['toolTip']);
                $model->setIntval1($options['parentMenuId']);
                $model->setBlnval1($options['isChild']);
                $model->setBlnval2($options['isAction']);
                $model->setStrval3($options['menuIcon']);
                
                $model->save();
                $this->_flashMessenger->addMessage(array('success'=>'Menu information has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl("/security/menu/edit-menu-item/id/{$id}/guid/{$guid}"));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
        
        $this->view->form = $form;
    }//end of edit-employee function
    
    public function deleteMenuItemAction()
    {
        $id = $this->_getParam('id');
        $menu=new Base_Security_Menu();
        $pages=$menu->getChildPages($id,0);
        $arrChild[] = $id;
        for($i=0 ; $i < count($pages) ; $i++){
            $arrChild[] = $pages[$i]['menu_id'];
        }
        
       $strMenuIds = implode(',',$arrChild);
       $model1 = new Security_Model_SystemMaster();
       $model1->setMasterCode("fdMenu");
       $model1->delete("master_id IN ($strMenuIds) AND master_code ='".$model1->getMasterCode()."'");
       $this->_flashMessenger->addMessage(array('success'=>'Menu item deleted successfully!'));
       $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/menu/'));
    }
    
    
   
   
   
  
    public function changeStatusAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $id = $this->_getParam('id');
        $status = $this->_getParam('status');
        if($status==0)
            $status=1;
        else
            $status=0;
        
        $model = new Base_Security_Menu();
        $res=$model->changeStatus($id, $status);
        if(false===$res)
            $arrResult=array("result"=>0);
        else
            $arrResult=array("result"=>1);
        
        echo Zend_Json::encode($arrResult);
       
    }
        
    public function changeChildStatusAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $id = $this->_getParam('id');
        $status = $this->_getParam('status');
        
        if($status==0)
            $status=1;
        else
            $status=0;
        
        $model = new Base_Security_Menu();
        $res=$model->changeChildStatus($id, $status);
        
        
        if(false===$res)
            $arrResult=array("result"=>0);
        else
            $arrResult=array("result"=>1);
        
        echo Zend_Json::encode($arrResult);
    }
        
    
    public function permissionSetupAction()
    {
        $Privilege=new Base_Security_Privilege();
        $this->view->groups=$Privilege->getGroupArray();
        $this->view->subGroups=$Privilege->getSubGroupArray("All");
        $this->view->roles=$Privilege->getRoleArray("All");
        
        $User=new Security_Model_User();
        $this->view->users=$User->getAllUsers();
        
        
        $Menu=new Base_Security_Menu();
        $this->view->menuTree=$Menu->getFullMenuTree();
        
    }
    
    public function savePermissionAction()
    {

        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
       
        
        $params=$this->_getAllParams();
        $rdo=$params['rdo']; //groupId, subGroupId, roleId, userId
        $mapId2=$params[$rdo]; 
        $arrMapId1=array();
        $mapCode="";
        $arrResult=array("status"=>0);
        if($rdo=="groupId")
        {
            $mapCode="fdMenuGroupMap";
        }
        else if($rdo=="subGroupId")
        {
            $mapCode="fdMenuSubGroupMap";
        }
        else if($rdo=="roleId")
        {
            $mapCode="fdMenuRoleMap";
        }
        else if($rdo=="userId")
        {
            $mapCode="fdMenuUserMap";
        }
        
        foreach($params as $k=>$v)
        {
            if(stristr($k, "check_")!==false)
            {
                $arr=explode("_", $k);
                if($arr[1]!=="noderoot")
                $arrMapId1[]=$arr[1];

            }
        }
        
        if(count($arrMapId1)>0)
        {
            $model=new Security_Model_SystemMapping();
            $model->delete("map_code='{$mapCode}' and map_id2='{$mapId2}'");
            foreach($arrMapId1 as $mapId1)
            {
                $model->setMapCode($mapCode)
                    ->setMapId1($mapId1)
                    ->setMapId2($mapId2)
                    ->save();
                
            }
            
            $arrResult=array("status"=>1);
        }
        else
        {
            $arrResult=array("status"=>0);
        }
        
        echo Zend_Json::encode($arrResult);
        
        
    }
    
    
    
    public function getPermissionAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
       
        
        $params=$this->_getAllParams();
        $rdo=$params['rdo']; //groupId, subGroupId, roleId, userId
        $mapId2=$params[$rdo]; 
        $arrMapId1=array();
        $mapCode="";
        $arrResult=array("status"=>0);
        if($rdo=="groupId")
        {
            $mapCode="fdMenuGroupMap";
        }
        else if($rdo=="subGroupId")
        {
            $mapCode="fdMenuSubGroupMap";
        }
        else if($rdo=="roleId")
        {
            $mapCode="fdMenuRoleMap";
        }
        else if($rdo=="userId")
        {
            $mapCode="fdMenuUserMap";
        }
        
        $model=new Security_Model_SystemMapping();
        $res=$model->fetchAll("map_code='{$mapCode}' and map_id2='{$mapId2}'");
        if(count($res)>0)
        {
            foreach($res as $row)
            {
                $arrMapId1[]=$row->getMapId1();
            }
            $arrResult=array("status"=>1, "mapId1"=>$arrMapId1);    
        }
        
        echo Zend_Json::encode($arrResult);
        
    }
    
}
