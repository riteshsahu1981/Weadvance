<?php
class Admin_LocationController extends Base_Controller_Action
{
        
        public function indexAction()
        { 
            /*--search---*/
            $this->view->pageHeading="List Location";
            $search = trim($this->_getParam('title'));
			$this->view->assign('searchText',$search);
            //$status = trim($this->_getParam('status'));
            /*---sorting ----*/
            $order = trim($this->_getParam('order', ""));
            $col = trim($this->_getParam('col',""));

            if($order<>"" && $col<>"")
            {
                if($col=="title")
                    $strOrderBy="l.title {$order}";
               // else if($col=="weight")
               //     $strOrderBy="l.weight {$order}";
            }
            else
            {
                $strOrderBy="l.id desc";
            }
            $this->view->sortOptions=array();
            /*-----sorting----------*/

            $where="l.id<>'-2147483648'";
            $this->view->linkArray=array();
            $this->view->search="";
            if($search<>"" )
            {
                $where="(title like '%{$search}%')and {$where} ";
                $this->view->linkArray=array('search'=>$search);
                $this->view->search=$search;
                $this->view->sortOptions['title']=$search;
            }
            
            
            
            $page_size= Zend_Registry::get('page_size');
            $page = $this->_getParam('page',1);
            $model=new Admin_Model_Location();
            $table=$model->getMapper()->getDbTable();
            $select = $table->select()->setIntegrityCheck(false)->from(array("l"=>'location'))
                    ->order("$strOrderBy")->where($where);
            $sql = $select->__toString(); 
            $paginator =  Base_Paginator::factory($select);

            $paginator->setItemCountPerPage($page_size);
            $paginator->setCurrentPageNumber($page);

            $this->view->totalItems= $paginator->getTotalItemCount();
            $this->view->paginator=$paginator;

        }
        
        public function createLocationAction()
        {
            $this->view->pageHeading="Add Location";
            $request = $this->getRequest();
            $form    = new Admin_Form_Location();
            $elements=$form->getElements();
            $form->clearDecorators();

            foreach($elements as $element)
            {
                $element->removeDecorator('label');
                //$element->removeDecorator('Errors');
            }  

            if ($request->isPost())
            {
                $options=$request->getPost();
                
                
               
                if ($form->isValid($options))
                { 
				
                    $options['status']='1';
                    //$options['password']=md5($options['password']);
					
                   $model=new Admin_Model_Location($options);
                   $id=$model->save();
				   //$id=10;
                    if($id)  
                    {    
                        $this->_flashMessenger->addMessage(array('success'=>'Location added successfully!'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/location/create-location'));  
                    }
                    else
                    {
                        $this->_flashMessenger->addMessage(array('error'=>'Failed to add location!'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/location/create-location'));
                    }
                    $form->reset();
                }
                else
                {
                    $form->reset();
                    $form->populate($options);
                }
                    $this->view->pageHeading="Add Location";
            }
            $this->view->form =  $form;
        }
        
        
        public function editLocationAction()
        {
            $this->view->pageHeading="Edit Location";
            $id = $this->_getParam('id');
            $guid= $this->_getParam('guid');
			
            $this->view->user_id = $id;
            $model1 = new Admin_Model_Location();
			
            $model = $model1->fetchRow("id='".$id."' and row_guid='".$guid."'");
			
            if(false===$model)
            {
                $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/location'));  
            }
            
            
            $options['title'] = $model->getTitle();
            $options['description'] = $model->getDescription();
            $options['weight'] = $model->getWeight();
            $options['status'] = $model->getStatus();
			
            $this->view->assign('guid',$model->getRowGuid());
			
            $request = $this->getRequest();
            
            $form    = new Admin_Form_Location();
            $elements=$form->getElements();
          
            $form->clearDecorators();

            foreach($elements as $element)
            {
                $element->removeDecorator('label');
               
            } 
            
/*           
            $form->removeElement('title');
            $form->removeElement('description');
            $form->removeElement('weight');
            $this->assign-$model->getstatus();
*/
            $usersNs = new Zend_Session_Namespace("members");
            if($usersNs->userId==$id)
            {
               
               // $form->removeElement('status');    
            }		
			//$form->removeElement('status');  
			
            $modelP	= new Base_Security_Privilege();
            $form->populate($options);
            $form->populate($options);
			
            $options=$request->getPost();
            if ($request->isPost()) 
            { 
                $modelP	= new Base_Security_Privilege();
                if ($form->isValid($options))
                {
                    $model->setOptions($options);
                    $model->save();
                   
                    $this->_flashMessenger->addMessage(array('success'=>'Location information has been updated successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/location/edit-location/id/'.$id."/guid/".$guid));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                    $form->reset();
                    $form->populate($options);
                } 		
            }
           
            $this->view->form =  $form;
        }//end of edit-location function
        
        
        //change location status
         public function changeLocationStatusAction()
         {
            $id = $this->_getParam('id');
            $guid = $this->_getParam('guid');
            $usersNs = new Zend_Session_Namespace("members");
            if($usersNs->userId==$id)
            {
            $this->_flashMessenger->addMessage(array('error'=>'You cannot change status!' ));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/location'));  
            exit;
            } 
            $this->view->location_id = $id;
            $model1 = new Admin_Model_Location();
            $model = $model1->fetchRow("id='{$id}' and row_guid='{$guid}'");
            if(false===$model )
            {
                $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/location'));  
            }

            if($model->getStatus()=="1")
            $model->setStatus ("0");
            else
            $model->setStatus ("1");

        if($model->save())
        {
                $this->_flashMessenger->addMessage(array('success'=>'Status changed for '.$model->getTitle()));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/location/index'));  
        }
        else
        {
            $this->_flashMessenger->addMessage(array('error'=>'Failed to change the status for '.$model->getTitle()));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/location/index'));  
        }

        }
		//end change location status
		
		//change location status ajax
		public function changeStatusAction()
		{
			$this->view->layout()->disableLayout();
                        $search = trim($this->_getParam('title'));
			$this->view->assign('searchText',$search);
			$this->_helper->viewRenderer->setNoRender(true);
			$id = $this->_getParam('id');
			$model1 = new Admin_Model_Location();
                        $model = $model1->fetchRow("id='{$id}'");
			$status = $this->_getParam('status');
			if($status==0)
				$status=1;
			else
				$status=0;
			 $model->setStatus ($status);
			//$model = new Base_Security_Menu();
			//$res=$model->changeStatus($id, $status);
			$res=$model->save();
			if(false===$res)
				$arrResult=array("result"=>0);
			else
				$arrResult=array("result"=>1);
			
			echo Zend_Json::encode($arrResult);
		   
		}
		//End change location status ajax 	
 
                
        public function locationMappingAction()
        {

        }
}//end of class
