<?php
class Admin_CustomerController extends Base_Controller_Action
{
        
        public function indexAction()
        { 
            /*--search---*/

            $search_name = trim($this->_getParam('search_name'));
            $search_city = trim($this->_getParam('search_city'));
            $search_phone = trim($this->_getParam('search_phone'));
            $search_email = trim($this->_getParam('search_email'));
            //$status = trim($this->_getParam('status'));
            /*---sorting ----*/
            $order = trim($this->_getParam('order', ""));
            $col = trim($this->_getParam('col',""));

            if($order<>"" && $col<>"")
            {
                if($col=="phone")
                    $strOrderBy="c.phone {$order}";
                else if($col=="fax")
                    $strOrderBy="c.fax {$order}";
                else if($col=="email")
                    $strOrderBy="c.email {$order}";
            }
            else
            {
                $strOrderBy="c.first_name asc";
            }
            $this->view->sortOptions=array();
            /*-----sorting----------*/

            $where="c.id<>'-2147483648'";
            $this->view->linkArray=array();
            $this->view->search="";
            if(($search_name<>"" ) || ($search_city<>"" ) || ($search_phone<>"" ) || ($search_email<>"" ))
            {
                $where="((first_name like '%{$search_name}%') OR (bfirst_name like '%{$search_name}%') OR (last_name like '%{$search_name}%') OR (blast_name like '%{$search_name}%')) AND ((city like '%{$search_city}%') OR (bcity like '%{$search_city}%')) AND (phone like '%{$search_phone}%') AND (email like '%{$search_email}%') and {$where} ";
                $this->view->linkArray=array('search_name'=>$search_name);
                $this->view->search_name=$search_name;
                $this->view->search_city=$search_city;
                $this->view->search_phone=$search_phone;
                $this->view->search_email=$search_email;
                $this->view->sortOptions['search_name']=$search_name;
                $this->view->sortOptions['search_city']=$search_city;
                $this->view->sortOptions['search_phone']=$search_phone;
                $this->view->sortOptions['search_email']=$search_email;
            }
            
            $page_size= Zend_Registry::get('page_size');
            $page = $this->_getParam('page',1);
            $model=new Admin_Model_Customer();
            $table=$model->getMapper()->getDbTable();
            $select = $table->select()->setIntegrityCheck(false)->from(array("c"=>'customer'))
                    ->order("$strOrderBy")->where($where);
            $sql = $select->__toString(); 
            $paginator =  Base_Paginator::factory($select);

            $paginator->setItemCountPerPage($page_size);
            $paginator->setCurrentPageNumber($page);

            $this->view->totalItems= $paginator->getTotalItemCount();
            $this->view->paginator=$paginator;

        }
        
        public function createCustomerAction()
        {
            $this->view->pageHeading="Add Customer";
            
            $request = $this->getRequest();
            $form    = new Admin_Form_Customer();
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
                $form->getElement('email');
                $form->getElement('email')->addValidators(array(
                array('Db_NoRecordExists', false, array(
                'table' => 'customer',
                'field' => 'email',
                'messages'=>'Email already exists, Please choose another email address.'
                        ))
                ));
                //print_r ($options);
                //die;
                
                if ($form->isValid($options))
                { 
                    $options['status']='1';
                    //$options['password']=md5($options['password']);

                    $model=new Admin_Model_Customer($options);
                    $id=$model->save();
                    if($id)  
                    {    
                        $this->_flashMessenger->addMessage(array('success'=>'Customer added successfully!'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/customer/create-customer'));  
                    }
                    else
                    {
                        $this->_flashMessenger->addMessage(array('error'=>'Failed to add Custoemr!'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/customer/create-customer'));
                    }
                    //$form->reset();
                }
                else
                {
                    $form->reset();
                    $form->populate($options);
                }
                    $this->view->pageHeading="Add Customer";
            }
            $this->view->form =  $form;
        }
        
        
        public function editCustomerAction()
        {
            $id = $this->_getParam('id');
            $this->view->user_id = $id;
            $model1 = new Admin_Model_Customer();
            $model = $model1->find($id);
            if(false===$model)
            {
                $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/customer'));  
            }
            
            $options['orgName'] = $model->getOrgName();
            $options['firstName'] = $model->getFirstName();
            $options['lastName'] = $model->getLastName();
            $options['address'] = $model->getAddress();
            $options['city'] = $model->getCity();
            $options['state'] = $model->getState();
            $options['zip'] = $model->getZip();
            $options['bFirstName'] = $model->getBFirstName();
            $options['bLastName'] = $model->getBLastName();
            $options['bAddress'] = $model->getBAddress();
            $options['bCity'] = $model->getBCity();
            $options['bState'] = $model->getBState();
            $options['bZip'] = $model->getBZip();
            $options['email'] = $model->getEmail();
            $options['phone'] = $model->getPhone();
            $options['fax'] = $model->getFax();
            //$this->view->username = $model->getUsername();

            $request = $this->getRequest();
            
            $form    = new Admin_Form_Customer();
            $elements=$form->getElements();
            //echo $request->isPost();
            $form->clearDecorators();

            foreach($elements as $element)
            {
                $element->removeDecorator('label');
                //$element->removeDecorator('Errors');
            } 
            
            //remove fields do not need to display in Edit
            //$form->removeElement('employeeCode');
            //$form->getElement('employeeCode')->setAttrib("readonly", "true");
            /*$form->removeElement('username');
            $form->removeElement('password');
            $form->removeElement('c_password');*/

            $usersNs = new Zend_Session_Namespace("members");
            if($usersNs ->userId==$id)
            {
                //$form->removeElement('groupId');
                //$form->removeElement('subGroupId');
                //$form->removeElement('roleId');
                $form->removeElement('status');    
            }		

            $modelP	= new Base_Security_Privilege();
            //$arrSubgroup = $modelP->getSubGroupArray($model->getGroupId());

            //$form->getElement("subGroupId")->addMultiOptions( $arrSubgroup );
            $form->populate($options);

            //$arrUserRole = $modelP->getRoleArray($model->getSubGroupId());
            //$form->getElement("roleId")->addMultiOptions( $arrUserRole );


            $form->populate($options);

            $options=$request->getPost();
            if ($request->isPost()) 
            { 
                /*---- email validation ----*/
                if($options['email']!=$model->getEmail())
                {

                    $form->getElement('email')->addValidators(array(
                    array('Db_NoRecordExists', false, array(
                    'table' => 'customer',
                    'field' => 'email',
                    'messages'=>'Email already exists, Please choose another email address.'
                            ))
                    ));
                }

                /*-------------------------*/

                $modelP	= new Base_Security_Privilege();
                //$arrSubgroup = $modelP->getSubGroupArray($options['groupId']);

                //$form->getElement("subGroupId")->addMultiOptions( $arrSubgroup );
                //$form->populate($options);

               // $arrUserRole = $modelP->getRoleArray($options['subGroupId']);
                //$form->getElement("roleId")->addMultiOptions( $arrUserRole );


                if ($form->isValid($options))
                {
                    $model->setOptions($options);
                    $model->save();
                    /*---------  Upload image START -------------------------*/
                    //$model->uploadProfilePicture($id,$options);
                    /*---------  Upload image END -------------------------*/
                    $this->_flashMessenger->addMessage(array('success'=>'Customer information has been updated successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/customer/edit-customer/id/'.$id));  
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
        }//end of edit-customer function
        
        
        
         public function changeUserStatusAction()
         {
            $id = $this->_getParam('id');
            $guid = $this->_getParam('guid');
            $usersNs = new Zend_Session_Namespace("members");
            if($usersNs->userId==$id)
            {
            $this->_flashMessenger->addMessage(array('error'=>'You cannot change your status!' ));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/customer'));  
            exit;
            } 
            $this->view->user_id = $id;
            $model1 = new Admin_Model_Customer();
            $model = $model1->fetchRow("id='{$id}' and row_guid='{$guid}'");
            if(false===$model )
            {
                $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/customer'));  
            }

          
            if($model->getStatus()=="1")
                $model->setStatus ("0");
            else
                $model->setStatus ("1");

        if($model->save())
        {
                $this->_flashMessenger->addMessage(array('success'=>'Status changed for '.$model->getFirstName().' '.$model->getLastName().' [ ID : '.$model->getId().', Status : '.$model->getStatus().']'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/customer/index'));  
        }
        else
        {
            $this->_flashMessenger->addMessage(array('error'=>'Failed to change the status for '.$model->getFirstName().' '.$model->getLastName().' [ ID : '.$model->getId().', Status : '.$model->getStatus().']'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/customer/index'));  
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
        
        $model = new Admin_Model_Customer   ();
        $res=$model->changeStatus($id, $status);
        if(false===$res)
            $arrResult=array("result"=>0);
        else
            $arrResult=array("result"=>1);
        
        echo Zend_Json::encode($arrResult);
       
    }
        
 
}//end of class
