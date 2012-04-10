<?php
class Security_PrivilegeController extends Base_Controller_Action
{

    public function indexAction()
    { 
        $this->view->pageHeading="Group/Role Setup";
    }
    public function ajaxGetSubGroupAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $group_id=$this->_getParam('group_id');
        
        $objPrivilege = new Base_Security_Privilege();
        $subgroups=$objPrivilege->getSubGroupArray($group_id);
        echo Zend_Json::encode($subgroups);
    }
    
    public function ajaxGetRoleAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $sub_group_id=$this->_getParam('sub_group_id');
        
        $objPrivilege = new Base_Security_Privilege();
        $roles=$objPrivilege->getRoleArray($sub_group_id);
        echo Zend_Json::encode($roles);
    }
    
    public function createAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $parent_node_id=$this->_getParam('parent_node_id');
        $child_master_value=$this->_getParam('node_title');
        $arrNode=explode("_",$parent_node_id);
        $parent_master_code=$arrNode[0];
        $parent_master_id=$arrNode[1];
        $model=new Security_Model_SystemMaster();
        
        if($parent_master_code=="noderoot")
        {
            // create group
            $child_master_code="fdUserGroup";
            
            
        }else if($parent_master_code=="fdUserGroup")
        {
            //create sub group
            $child_master_code="fdUserSubGroup";
            $map_code="fdGroupSubGroupMap";
        }
        else if($parent_master_code=="fdUserSubGroup")
        {
            //create new role
            $child_master_code="fdUserRole";
            $map_code="fdSubGroupRoleMap";
        }
        $model->setMasterCode($child_master_code);
        $model->setMasterValue($child_master_value);
        $node_id=$model->save();
        if($parent_master_code!=="noderoot")
        {
            //mapping start
            $objMapping=new Security_Model_SystemMapping();
            $objMapping->setMapId1($parent_master_id);
            $objMapping->setMapId2($node_id);
            $objMapping->setMapCode($map_code);
            if(true===$objMapping->save())
            {
                $result=Zend_Json::encode(array("status"=>true, "node_id"=>$child_master_code."_".$node_id));
            }
            else
            {
                $result=Zend_Json::encode(array("status"=>false));
            }
        }
        else
        {
            if($node_id)
                $result=Zend_Json::encode(array("status"=>true, "node_id"=>$child_master_code."_".$node_id));
            else
                $result=Zend_Json::encode(array("status"=>false));
        }
        echo $result;
    }
    
    
    
    public function renameAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $node_id=$this->_getParam('node_id');
        $master_value=$this->_getParam('node_title');
        $arrNode=explode("_",$node_id);
        $master_code=$arrNode[0];
        $master_id=$arrNode[1];
        $model=new Security_Model_SystemMaster();
        $master=$model->fetchRow("master_code='{$master_code}' and master_id='{$master_id}'");
        $master->setMasterValue($master_value);
        if($master->save())
            $result=Zend_Json::encode(array("status"=>true));
        else
            $result=Zend_Json::encode(array("status"=>false));
        echo $result;        
    }
    
    
    public function removeAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $child_node_id=$this->_getParam('child_node_id');
        $arrChildNode=explode("_",$child_node_id);
        $child_master_code=$arrChildNode[0];
        $child_master_id=$arrChildNode[1];
        
        $parent_node_id=$this->_getParam('parent_node_id');
        $arrParentNode=explode("_",$parent_node_id);
        $parent_master_code=$arrParentNode[0];
        $parent_master_id=$arrParentNode[1];
        
        if($child_master_code=="fdUserRole")
        {
            //delete role
            $objMap=new Security_Model_SystemMapping();
            $objMap->delete("map_code='fdSubGroupRoleMap' and map_id1='{$parent_master_id}' and map_id2='{$child_master_id}'");

            $objMaster=new Security_Model_SystemMaster();
            $objMaster->delete("master_code='{$child_master_code}' and master_id='{$child_master_id}'");
        }
        else if($child_master_code=="fdUserSubGroup")
        {
            //fetch roles and delete them
            $objMap=new Security_Model_SystemMapping();
            $result=$objMap->fetchAll("map_code='fdSubGroupRoleMap' and map_id1='{$child_master_id}'");
            if(count($result)>0)
            {
                foreach($result as $_row )
                {
                    $objMaster=new Security_Model_SystemMaster();
                    $objMaster->delete("master_code='fdUserRole' and master_id='{$_row->getMapId2()}'");
                }
            }
            $objMap->delete("map_code='fdSubGroupRoleMap' and map_id1='{$child_master_id}'");
            
            // now delete sub group from master
            $objMaster=new Security_Model_SystemMaster();
            $objMaster->delete("master_code='{$child_master_code}' and master_id='{$child_master_id}'");
            
        }
        else if($child_master_code=="fdUserGroup")
        {
            // fetch sub groups and delete them
            $objMap=new Security_Model_SystemMapping();
            $result=$objMap->fetchAll("map_code='fdGroupSubGroupMap' and map_id1='{$child_master_id}'");
            if(count($result)>0)
            {
                foreach($result as $_row )
                {
                    //fetch roles and delete them
                    
                    $objMap1=new Security_Model_SystemMapping();
                    $result1=$objMap1->fetchAll("map_code='fdSubGroupRoleMap' and map_id1='{$_row->getMapId2()}'");
                    if(count($result1)>0)
                    {
                        foreach($result1 as $_row1 )
                        {
                            $objMaster=new Security_Model_SystemMaster();
                            $objMaster->delete("master_code='fdUserRole' and master_id='{$_row1->getMapId2()}'");
                        }
                    }
                    $objMap1->delete("map_code='fdSubGroupRoleMap' and map_id1='{$_row->getMapId2()}'");
                    
                    $objMaster=new Security_Model_SystemMaster();
                    $objMaster->delete("master_code='fdUserSubGroup' and master_id='{$_row->getMapId2()}'");
                }
            }
            
            $objMap->delete("map_code='fdGroupSubGroupMap' and map_id1='{$child_master_id}'");
             // now delete group from master
            $objMaster=new Security_Model_SystemMaster();
            $objMaster->delete("master_code='{$child_master_code}' and master_id='{$child_master_id}'");
            
        }
        echo $result=Zend_Json::encode(array("status"=>true));
        
    }
    
    
    
    public function deleteSystemMasterAction()
    {
        //Start delete system master
        $this->view->layout()->disableLayout();
        $guid   =   trim($this->_getParam('guid'));
        $masterCode =   $this->_getParam("masterCode");

        $model1 = new Security_Model_SystemMaster();
        $model = $model1->delete("row_guid='".$guid."' and master_code='$masterCode'");
        if((true==$model) || ($model>0))
        {
        $this->_flashMessenger->addMessage(array('success'=>'System Master information has been deleted successfully!'));
        }
        else
         $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
        
        $rows = $model1->fetchAll("master_code='$masterCode'");
        if (empty($rows))
        $this->_helper->_redirector->gotoUrl($this->view->seoUrl("/security/privilege/add-system-master")); 
        else
        $this->_helper->_redirector->gotoUrl($this->view->seoUrl("/security/privilege/add-system-master/masterCode/".$masterCode)); 

    }    

    public function addSystemMasterAction()
    {
            $request = $this->getRequest();
            $guid= $this->_getParam('guid');
            $form    = new Security_Form_SystemMaster();
            $masterCode=$this->_getParam('masterCode');
            
            $elements=$form->getElements();
            $form->clearDecorators();

            foreach($elements as $element)
            {
                $element->removeDecorator('label');
                //$element->removeDecorator('Errors');
            }  
            
            if (($request->isPost()) && (empty($guid)))
            { 
                $options=$request->getPost();
                if ($form->isValid($options))
                { 
                   $masterCode=$_POST['masterCode'];
                   $model=new Security_Model_SystemMaster($options);
                   $id=$model->save();
                    if($id)  
                    {    
                        $this->_flashMessenger->addMessage(array('success'=>'System master added successfully!'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/privilege/add-system-master/masterCode/'.$masterCode));  
                    }
                    else
                    {
                        $this->_flashMessenger->addMessage(array('error'=>'Failed to add System master!'));
                        //$this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/privilege/add-system-master'));
                    }
                    //$form->reset();
                    $options['masterValue']='';
                    $form->populate($options);
                }
                else
                {
                    $form->reset();
                    $form->populate($options);
                }

            }
            if (!empty($masterCode))
            $this->view->assign('read','yes');
            
           // echo "master code=".$masterCode;
            //edit master values
            if (!empty($guid))
            {
                $model1 = new Security_Model_SystemMaster();

                $model = $model1->fetchRow("row_guid='".$guid."'");
                $num=$model1->isExist("row_guid='".$guid."'");
               
                if(empty($num))
                {
                  $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
                  $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/privilege/add-system-master'));  
                }



                $options['masterCode'] = $model->getMasterCode();
                $masterCode=$model->getMasterCode();
                $options['masterValue'] = $model->getMasterValue();
               // $options['intval1'] = $model->getIntval1();
                $options['status'] = $model->getStatus();

                $this->view->assign('guid',$model->getRowGuid());
                $this->view->assign('mode','yes');
                 $this->view->assign('read','yes');


                $request = $this->getRequest();

                $form    =  new Security_Form_SystemMaster();
                $elements=$form->getElements();

                $form->clearDecorators();

                foreach($elements as $element)
                {
                    $element->removeDecorator('label');

                } 
                $form->populate($options);
                $options=$request->getPost();
                if ($request->isPost()) 
                { 
                    $modelP	= new Base_Security_Privilege();
                    if ($form->isValid($options))
                    {
                        $model->setOptions($options);
                        $model->save();

                        $this->_flashMessenger->addMessage(array('success'=>'System Master information has been updated successfully!'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl("/security/privilege/add-system-master/masterCode/".$masterCode));  
                    }
                    else
                    {
                        $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                       // $form->reset();
                        $form->populate($options);
                    } 		
                }
            }
            //End master values
            
            $this->view->form=$form;
            
            /*---sorting ----*/
            $order = trim($this->_getParam('order', ""));
            $col = trim($this->_getParam('col',""));
            $this->view->sortOptions=array();
            if($order<>"" && $col<>"")
            {

                if($col=="master_id")
                    $strOrderBy="s.master_id {$order}";
                else if($col=="master_value")
                    $strOrderBy="s.master_value {$order}";
                else if($col=="status")
                    $strOrderBy="s.status {$order}";
            }
            else
            {
                $strOrderBy="s.master_id desc";
            }
            
            /*-----sorting----------*/
            
            
            if($masterCode!="")
            {
                $this->view->sortOptions['masterCode']=$masterCode;
                $options['masterCode']=$masterCode;
                $form->populate($options);
                
                $where="s.master_code='{$masterCode}'";
                $page_size= Zend_Registry::get('page_size');
                $page = $this->_getParam('page',1);
                $model=new Security_Model_SystemMaster();
                $table=$model->getMapper()->getDbTable();
                $select = $table->select()->setIntegrityCheck(false)->from(array("s"=>'system_master'))
                        ->order($strOrderBy)->where($where);
                $sql = $select->__toString(); 
                $paginator =  Base_Paginator::factory($select);
                $paginator->setItemCountPerPage($page_size);
                $paginator->setCurrentPageNumber($page);

                $this->view->totalItems= $paginator->getTotalItemCount();
                $this->view->paginator=$paginator;
                
            }
            
            
            
    }
    
    //add master code
    public function deladdSystemMasterAction()
    {
      
        
        $guid   =   $this->_getParam('guid');
        $delete =   $this->_getParam("delete");
        $guid2 =   $this->_getParam("guid2");        
        //echo $delete.'----'.$guid2;
        
        if ((!empty($guid)) && (empty($delete)))
        {
            //start Edit system master
            $this->view->pageHeading="Edit System Master";  
            $this->view->assign('mode','edit');
            $model1 = new Security_Model_SystemMaster();
			
            $model = $model1->fetchRow("row_guid='".$guid."'");
			
            if(false===$model)
            {
                $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/privilege/add-system-master/guid/'.$guid));  
            }
            
            
            $options['masterCode'] = $model->getMasterCode();
            $options['masterValue'] = $model->getMasterValue();
           // $options['intval1'] = $model->getIntval1();
            $options['status'] = $model->getStatus();
			
            $this->view->assign('guid',$model->getRowGuid());
			
            $request = $this->getRequest();
            
            $form    =  new Security_Form_SystemMaster();
            $elements=$form->getElements();
          
            $form->clearDecorators();

            foreach($elements as $element)
            {
                $element->removeDecorator('label');
               
            } 

            $usersNs = new Zend_Session_Namespace("members");
            if($usersNs->userId==guid)
            {
               
               $form->removeElement('status');    
            }		
			
            $modelP	= new Base_Security_Privilege();
           // $form->populate($options);
            $form->populate($options);
			
            $options=$request->getPost();
            if ($request->isPost()) 
            { 
                $modelP	= new Base_Security_Privilege();
                if ($form->isValid($options))
                {
                    $model->setOptions($options);
                    $model->save();
                   
                    $this->_flashMessenger->addMessage(array('success'=>'System Master information has been updated successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl("/security/privilege/add-system-master"));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                    $form->reset();
                    $form->populate($options);
                } 		
            }

            //End Edit system master
        }
        else  if ((!empty($guid2)) && (!empty($delete)) && ($delete=='yes'))
        {
            //Start delete system master
            $this->view->pageHeading="Delete System Master";    
            $model1 = new Security_Model_SystemMaster();
            $model = $model1->delete("row_guid='".$guid2."'");
            if((true==$model) || ($model>0))
            {
             $this->_flashMessenger->addMessage(array('success'=>'System Master information has been deleted successfully!'));
             $this->_helper->_redirector->gotoUrl($this->view->seoUrl("/security/privilege/add-system-master")); 
            }
            

             
             $request = $this->getRequest();
             $form    = new Security_Form_SystemMaster();

             $elements=$form->getElements();
             $form->clearDecorators();

             foreach($elements as $element)
             {
                $element->removeDecorator('label');
                //$element->removeDecorator('Errors');
             } 
             //End delete system master
         
        }
        else
        {
            //Add system master
            
            $request = $this->getRequest();
            $form    = new Security_Form_SystemMaster();

            $elements=$form->getElements();
            $form->clearDecorators();

            foreach($elements as $element)
            {
                $element->removeDecorator('label');
                //$element->removeDecorator('Errors');
            }  
           
            $search = trim($this->_getParam('search'));
            
            if (($request->isPost()) && (empty($search)))
            { 
                $options=$request->getPost();
                if ($form->isValid($options))
                { 

                   //$options['status']='1';
                   $model=new Security_Model_SystemMaster($options);
                   $id=$model->save();
                    if($id)  
                    {    
                        $this->_flashMessenger->addMessage(array('success'=>'System master added successfully!'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/privilege/add-system-master'));  
                    }
                    else
                    {
                        $this->_flashMessenger->addMessage(array('error'=>'Failed to add System master!'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/privilege/add-system-master'));
                    }
                    $form->reset();
                }
                else
                {
                    $form->reset();
                    $form->populate($options);
                }

            }
            //End Add system master
        }
        

         //Start system master listing
        $search = trim($this->_getParam('search'));
        $this->view->assign('searchText',$search);
        //$status = trim($this->_getParam('status'));
        /*---sorting ----*/
        $order = trim($this->_getParam('order', ""));
        $col = trim($this->_getParam('col',""));

        if($order<>"" && $col<>"")
        {
            if($col=="master_code")
                $strOrderBy="s.master_code {$order}";
             else if($col=="status")
                $strOrderBy="s.status {$order}";
        }
        else
        {
            $strOrderBy="s.created_on desc";
        }
        $this->view->sortOptions=array();
        /*-----sorting----------*/

        $where="1";
        $this->view->linkArray=array();
        $this->view->search="";
        if($search<>"" )
        {
            $where="(master_code like '%{$search}%' or master_value like '%{$search}%') and {$where} ";
            //$where="(master_code like '%{$search}%') and status='1'";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
            $this->view->sortOptions['master_code']=$search;
        }



        $page_size= Zend_Registry::get('page_size');
        $page = $this->_getParam('page',1);
        $model=new Security_Model_SystemMaster();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("s"=>'system_master'))
                ->order("$strOrderBy")->where($where);
        $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);

        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);

        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
        //End For listing

        $this->view->form =  $form;
    }	
   //add master code End
    
    //edit system master
    public function editSystemMasterAction()
    {
            $this->view->pageHeading="Edit System Master";
           // $id = $this->_getParam('guid');
            $guid= $this->_getParam('guid');
            //echo $guid;
           // $this->view->user_id = $id;
            $model1 = new Security_Model_SystemMaster();
			
            $model = $model1->fetchRow("row_guid='".$guid."'");
            $num=$model1->isExist("row_guid='".$guid."'");
            if(empty($num))
            {
                $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/privilege/list-system-master'));  
            }
            
            
            $options['masterCode'] = $model->getMasterCode();
           // $options['masterValue'] = $model->getMasterValue();
           // $options['intval1'] = $model->getIntval1();
            $options['status'] = $model->getStatus();
			
            $this->view->assign('guid',$model->getRowGuid());
			
            $request = $this->getRequest();
            
            $form    =  new Security_Form_SystemMaster();
            $elements=$form->getElements();
          
            $form->clearDecorators();

            foreach($elements as $element)
            {
                $element->removeDecorator('label');
               
            } 
            //$element->removeDecorator('masterValue');
            
            $usersNs = new Zend_Session_Namespace("members");
            if($usersNs->userId==guid)
            {
               
               //$form->removeElement('status');    
            }		
            $form->removeElement('masterValue'); 	
            $modelP	= new Base_Security_Privilege();
           // $form->populate($options);
            $form->populate($options);
			
            $options=$request->getPost();
            if ($request->isPost()) 
            { 
                $modelP	= new Base_Security_Privilege();
                if ($form->isValid($options))
                {
                    $model->setOptions($options);
                    $model->save();
                   
                    $this->_flashMessenger->addMessage(array('success'=>'System Master information has been updated successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl("/security/privilege/edit-system-master/guid/".$guid));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                    $form->reset();
                    $form->populate($options);
                } 		
            }
           
            $this->view->form =  $form;
        }//end of edit-system master function    
        
    //Deleet delete-system-master-code
    public function deleteSystemMasterCodeAction()
    {
        $this->view->layout()->disableLayout();
        $masterCode =   $this->_getParam("masterCode");

        $model1 = new Security_Model_SystemMaster();
        $model = $model1->delete("master_code='$masterCode'");
        if((true==$model) || ($model>0))
        {
        $this->_flashMessenger->addMessage(array('success'=>'System Master information has been deleted successfully!'));
        }
        else
         $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));

        $this->_helper->_redirector->gotoUrl($this->view->seoUrl("/security/privilege/list-system-master")); 
        
        
    }
    //End delete-system-master-code
    //list master code
    public function listSystemMasterAction()
    { 
            /*--search---*/
            $this->view->pageHeading="List System Master";
            $search = trim($this->_getParam('master_code'));
            $this->view->assign('searchText',$search);
            //$status = trim($this->_getParam('status'));
            /*---sorting ----*/
            $order = trim($this->_getParam('order', ""));
            $col = trim($this->_getParam('col',""));

            if($order<>"" && $col<>"")
            {
                if($col=="master_code")
                    $strOrderBy="s.master_code {$order}";
                else if($col=="master_id")
                    $strOrderBy="s.master_id {$order}";
                else if($col=="master_value")
                    $strOrderBy="s.master_value {$order}";
                else if($col=="status")
                    $strOrderBy="s.status {$order}";
            }
            else
            {
                $strOrderBy="s.master_code";
            }
            $this->view->sortOptions=array();
            /*-----sorting----------*/

            $where="1";
            $groupby="s.master_code";
            $this->view->linkArray=array();
            $this->view->search="";
            if($search<>"" )
            {
                $where="(master_code like '%{$search}%')and {$where} ";
                //$where="(master_code like '%{$search}%') and status='1'";
                $this->view->linkArray=array('search'=>$search);
                $this->view->search=$search;
                $this->view->sortOptions['master_code']=$search;
            }


            $page_size= Zend_Registry::get('page_size');
            $page = $this->_getParam('page',1);
            $model=new Security_Model_SystemMaster();
            $table=$model->getMapper()->getDbTable();
            
            $select = $table->select()->setIntegrityCheck(false)->from(array("s"=>'system_master'))
                    ->order("$strOrderBy")->where($where)->group($groupby);
            $sql = $select->__toString(); 
            $paginator =  Base_Paginator::factory($select);

            $paginator->setItemCountPerPage($page_size);
            $paginator->setCurrentPageNumber($page);

            $this->view->totalItems= $paginator->getTotalItemCount();
            $this->view->paginator=$paginator;

    }
   //End list master code  
    
    //change master status ajax
    public function changeStatusAction()
    {
            $this->view->layout()->disableLayout();
            //$search = trim($this->_getParam('master_code'));
            //$this->view->assign('searchText',$search);
            $this->_helper->viewRenderer->setNoRender(true);
            $id = $this->_getParam('masterCode');
            $model1=new Security_Model_SystemMaster();
            $model = $model1->fetchAll("master_code='{$id}'");
            $status = $this->_getParam('status');
            
            if($status==0)
            $status=1;
            else
            $status=0;
            
            foreach($model as $_row)
            {
                $_row->setStatus ($status);
                $res=$_row->save();
            }
            
            if(false===$res)
                    $arrResult=array("result"=>0);
            else
                    $arrResult=array("result"=>1);

            echo Zend_Json::encode($arrResult);

    }
    //End change master status ajax 	

    //add bookmark
    public function addBookMarkAction()
    {
            $this->view->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $menu_id = $this->_getParam('id');
            $limit = Zend_Registry::get('bookMark_limit');
             
           $usersNs = new Zend_Session_Namespace("members");
           $user_id = $usersNs->userId;
            
           $security=new Base_Security_Menu();
           $bookmarkAdd=$security->isBookMarked($menu_id);
           $model=new Security_Model_SystemMapping();
            if ($bookmarkAdd==false)
            {
                $count=$model->getCount("map_code='fdUserBookmark' and map_id1='$user_id'"); 
                if ($count>=$limit)
                {
                    $arrResult=array("result"=>1); //if more than 15
                }
                else
                {
                $mapCode="fdUserBookmark";
                $model->setMapCode($mapCode);   
                $model->setMapId1($user_id);
                $model->setMapId2($menu_id);
                $model->save();
                $arrResult=array("result"=>2); //added into bookmark
                }
            }
            else if($bookmarkAdd==true)
            {
                 $arrResult=array("result"=>3); //All ready added into bookmark
            }
            else
            {
                 $arrResult=array("result"=>4); //// Problem in Parameter
            }
                
            
            echo Zend_Json::encode($arrResult);

    }
    //End bookmark	
}
