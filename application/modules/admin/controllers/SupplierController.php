<?php
class Admin_SupplierController extends Base_Controller_Action
{
        public function indexAction()
        { 
            /*--search---*/

            $search = trim($this->_getParam('orgName'));
            //$status = trim($this->_getParam('status'));
            /*---sorting ----*/
            $order = trim($this->_getParam('order', ""));
            $col = trim($this->_getParam('col',""));

            if($order<>"" && $col<>"")
            {
                if($col=="city")
                    $strOrderBy="s.city {$order}";
                else if($col=="state")
                    $strOrderBy="s.state {$order}";
                else if($col=="zip")
                    $strOrderBy="s.zip {$order}";
            }
            else
            {
                $strOrderBy="s.first_name asc";
            }
            $this->view->sortOptions=array();
            /*-----sorting----------*/

            $where="s.id<>'-2147483648'";
            $this->view->linkArray=array();
            $this->view->search="";
            if($search<>"" )
            {
                $where="(org_name like '%{$search}%')and {$where} ";
                $this->view->linkArray=array('search'=>$search);
                $this->view->search=$search;
                $this->view->sortOptions['orgName']=$search;
            }
            
            $page_size= Zend_Registry::get('page_size');
            $page = $this->_getParam('page',1);
            $model=new Admin_Model_Supplier();
            $table=$model->getMapper()->getDbTable();
            $select = $table->select()->setIntegrityCheck(false)->from(array("s"=>'supplier'))
                    ->order("$strOrderBy")->where($where);
            $sql = $select->__toString(); 
            $paginator =  Base_Paginator::factory($select);

            $paginator->setItemCountPerPage($page_size);
            $paginator->setCurrentPageNumber($page);

            $this->view->totalItems= $paginator->getTotalItemCount();
            $this->view->paginator=$paginator;

        }
        
        public function createSupplierAction()
        {
            $this->view->pageHeading="Add Supplier";
            
            $request = $this->getRequest();
            $form    = new Admin_Form_Supplier();
            $elements=$form->getElements();
            $form->clearDecorators();

            foreach($elements as $element)
            {
                $element->removeDecorator('label');
                
            }  

            if ($request->isPost())
            {
                $options=$request->getPost();
                
                $form->getElement('email')->addValidators(array(
                array('Db_NoRecordExists', false, array(
                'table' => 'supplier',
                'field' => 'email',
                'messages'=>'Email already exists, Please choose another email address.'
                        ))
                ));
                
                if ($form->isValid($options))
                { 
                    $options['status']='1';
                    $options['password']=md5($options['password']);
                    

                    $model=new Admin_Model_Supplier($options);
                    $id=$model->save();
                    
                    if($options['quickSupplier'] == 1){
                        $code_values = array("codeName" => "transaction_id_".$id , "status" => '1');
                        $codeObj = new Mps_Model_Code($code_values);
                        $cid = $codeObj->save();

                    }
                    
                    if($id)  
                    {    
                        $this->_flashMessenger->addMessage(array('success'=>'Supplier added successfully!'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/supplier/create-supplier'));  
                    }
                    else
                    {
                        $this->_flashMessenger->addMessage(array('error'=>'Failed to add Supplier!'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/supplier/create-supplier'));
                    }
                    //$form->reset();
                }
                else
                {
                    $form->reset();
                    $form->populate($options);
                }
                    $this->view->pageHeading="Add Supplier";
            }
            $this->view->form =  $form;
        }
        
        
        public function editSupplierAction()
        {
            $id = $this->_getParam('id');
            $this->view->user_id = $id;
            $model1 = new Admin_Model_Supplier();
            $model = $model1->find($id);
            if(false===$model)
            {
                $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/supplier'));  
            }
            
            $options['orgName'] = $model->getOrgName();
            $options['firstName'] = $model->getFirstName();
            $options['lastName'] = $model->getLastName();
            $options['email'] = $model->getEmail();
            $options['address1'] = $model->getAddress1();
            $options['address2'] = $model->getAddress2();
            $options['phone'] = $model->getPhone();
            $options['city'] = $model->getCity();
            $options['state'] = $model->getState();
            $options['zip'] = $model->getZip();
            $options['phone'] = $model->getPhone();
            $options['fax'] = $model->getFax();
            $options['quickSupplier'] = $model->getQuickSupplier();
            $this->view->username = $model->getUsername();

            $request = $this->getRequest();
            
            $form    = new Admin_Form_Supplier();
            $elements=$form->getElements();
            $form->clearDecorators();

            foreach($elements as $element)
            {
                $element->removeDecorator('label');
            } 
            
            $form->removeElement('username');
            $form->removeElement('password');
            $form->removeElement('c_password');

            $usersNs = new Zend_Session_Namespace("members");
            if($usersNs ->userId==$id)
            {
                $form->removeElement('status');    
            }		
            $form->populate($options);

           


            $form->populate($options);

            $options=$request->getPost();
            if ($request->isPost()) 
            { 
                /*---- email validation ----*/
                if($options['email']!=$model->getEmail())
                {

                    $form->getElement('email')->addValidators(array(
                    array('Db_NoRecordExists', false, array(
                    'table' => 'supplier',
                    'field' => 'email',
                    'messages'=>'Email already exists, Please choose another email address.'
                            ))
                    ));
                }



                if ($form->isValid($options))
                {
                    $model->setOptions($options);
                    $model->save();
                      
                    // Block for editing code table in case of supplier is interncahged in its quick supplier status    
                    $model = new Mps_Model_Code();
                    $model1 = $model->fetchRow("code_name = 'transaction_id_$id'");
                    $code_values = array("codeName" => "transaction_id_".$id , "status" => '1');
                    if(!$model1){
                        if($options['quickSupplier'] == 1){
                            $codeObj = new Mps_Model_Code($code_values);
                            $cid = $codeObj->save();
                        }
                    }
                    else{
                        if($options['quickSupplier'] != 1){
                            $codeObj = new Mps_Model_Code();
                            $codeObj -> delete("code_name = 'transaction_id_$id' AND status = '1'");
                        } 
                     }
                     
                     // ends here
                   
                    $this->_flashMessenger->addMessage(array('success'=>'Supplier information has been updated successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/supplier/edit-supplier/id/'.$id));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                    $form->reset();
                    $form->populate($options);
                } 		
            }
            //$this->view->profile_image=$model->getProfileImage();
            $this->view->form =  $form;
        }//end of edit-supplier function
        
        
        
         public function changeUserStatusAction()
         {
            $id = $this->_getParam('id');
            $guid = $this->_getParam('guid');
            $usersNs = new Zend_Session_Namespace("members");
            if($usersNs->userId==$id)
            {
            $this->_flashMessenger->addMessage(array('error'=>'You cannot change your status!' ));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/supplier'));  
            exit;
            } 
            $this->view->user_id = $id;
            $model1 = new Admin_Model_Supplier();
            $model = $model1->fetchRow("id='{$id}' and row_guid='{$guid}'");
            if(false===$model )
            {
                $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/supplier'));  
            }

          
            if($model->getStatus()=="1")
                $model->setStatus ("0");
            else
                $model->setStatus ("1");

        if($model->save())
        {
                $this->_flashMessenger->addMessage(array('success'=>'Status changed for '.$model->getFirstName().' '.$model->getLastName().' [ ID : '.$model->getId().', Status : '.$model->getStatus().']'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/supplier/index'));  
        }
        else
        {
            $this->_flashMessenger->addMessage(array('error'=>'Failed to change the status for '.$model->getFirstName().' '.$model->getLastName().' [ ID : '.$model->getId().', Status : '.$model->getStatus().']'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/supplier/index'));  
        }

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
        
        $model = new Admin_Model_Supplier();
        $res=$model->changeStatus($id, $status);
        if(false===$res)
            $arrResult=array("result"=>0);
        else
            $arrResult=array("result"=>1);
        
        echo Zend_Json::encode($arrResult);
       
    }
        
 
}//end of class
