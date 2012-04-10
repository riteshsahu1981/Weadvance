<?php
class Admin_OrganizationController extends Base_Controller_Action
{

    public function indexAction()
    { 
       
        
    }
    
    public function createOrganizationAction()
    {
        $request = $this->getRequest();
        $form    = new Admin_Form_Organization();
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
            
            /*$objPrivilege = new Base_Security_Privilege();
            $subgroups=$objPrivilege->getSubGroupArray($options['groupId']);
            $form->getElement("subGroupId")->addMultiOptions($subgroups);
            
            $objPrivilege = new Base_Security_Privilege();
            $roles=$objPrivilege->getRoleArray($options['subGroupId']);
            $form->getElement("roleId")->addMultiOptions($roles);
            */
       
            if ($form->isValid($options))
            { 
                $options['status']=1;
                
                $model=new Admin_Model_Organization($options);
                $id=$model->save();
                if($id)  
                {    
                    /*---------  Upload image START -------------------------*/
                    //$model->uploadProfilePicture($id,$options);
                    /*---------  Upload image END -------------------------*/
                    $this->_flashMessenger->addMessage(array('success'=>'Organization added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/organization/create-organization'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add Organization!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/organization/create-organization'));
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
    }//end of add-new-employee function
    
    
    public function editOrganizationAction()
    {
        
        $this->view->postUrl=$this->getRequest()->getRequestUri();
        $id = $this->_getParam('id');
        $guid = $this->_getParam('guid');
        
        $model1 = new Admin_Model_Organization();
        $model = $model1->fetchRow("id='{$id}' and row_guid='{$guid}'");
        //$model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/organization/create-organization'));  
        }
        $options['firstName'] = $model->getFirstName();
        $options['organizationName'] = $model->getorganizationName();
        $options['orgName'] = $model->getorgName();
        $options['lastName'] = $model->getLastName();
        $options['email'] = $model->getEmail();
        
        $options['phone'] = $model->getPhone();
        $options['fax'] = $model->getFax();
        $options['zip'] = $model->getZip();
        $options['city'] = $model->getCity();
        $options['state'] = $model->getState();
        $options['address1'] = $model->getAddress1();
        $options['address2'] = $model->getAddress2();
        $options['submit'] = 'Update';
        
        //$this->view->username = $model->getUsername();
		 	
        $request = $this->getRequest();
        $form    = new Admin_Form_Organization();
        $elements=$form->getElements();
        $form->clearDecorators();

        foreach($elements as $element)
        {
            $element->removeDecorator('label');
            //$element->removeDecorator('Errors');
        }  

        /*$form->removeElement('username');
        $form->removeElement('password');
        $form->removeElement('confirmPassword');*/
        
        $usersNs = new Zend_Session_Namespace("members");
        if($usersNs ->userId==$id)
        {
            //$form->removeElement('groupId');
            //$form->removeElement('subGroupId');
            //$form->removeElement('roleId');
            $form->removeElement('status');    
        }		
        
        /*$modelP	= new Base_Security_Privilege();
        $arrSubgroup = $modelP->getSubGroupArray($model->getGroupId());
        
        $form->getElement("subGroupId")->addMultiOptions( $arrSubgroup );
        $form->populate($options);
        
        $arrUserRole = $modelP->getRoleArray($model->getSubGroupId());
        $form->getElement("roleId")->addMultiOptions( $arrUserRole );
        */
        
        $form->populate($options);
        
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
             /*---- email validation ----*/
            if($options['email']!=$model->getEmail())
            {
               
                $form->getElement('email')->addValidators(array(
                array('Db_NoRecordExists', false, array(
                'table' => 'user',
                'field' => 'email',
                'messages'=>'Email already exists, Please choose another email address.'
                        ))
                ));
            }
          
            /*-------------------------*/
			
            /*$modelP	= new Base_Security_Privilege();
            $arrSubgroup = $modelP->getSubGroupArray($options['groupId']);

            $form->getElement("subGroupId")->addMultiOptions( $arrSubgroup );
            $form->populate($options);

            $arrUserRole = $modelP->getRoleArray($options['subGroupId']);
            $form->getElement("roleId")->addMultiOptions( $arrUserRole );
            */
            
            if ($form->isValid($options))
            {
                $model->setOptions($options);
                $model->save();
                /*---------  Upload image START -------------------------*/
                //$model->uploadProfilePicture($id,$options);
                /*---------  Upload image END -------------------------*/
                $this->_flashMessenger->addMessage(array('success'=>'Organization information has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl($this->view->postUrl));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
        //$this->view->profile_image=$model->getProfileImage();
        $this->view->form		=	$form;
    }//end of edit-employee function
   
    public function changeUserStatusAction()
    {
        $id = $this->_getParam('id');
        $guid = $this->_getParam('guid');
        $usersNs = new Zend_Session_Namespace("members");
        if($usersNs->userId==$id)
        {
           $this->_flashMessenger->addMessage(array('error'=>'You cannot change your status!' ));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/user'));  
           exit;
        } 
        $this->view->user_id = $id;
        $model1 = new Security_Model_User();
        $model = $model1->fetchRow("id='{$id}' and row_guid='{$guid}'");
        if(false===$model )
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/user'));  
        }
        
        
        if($model->getStatus()==1)
            $model->setStatus (0);
        else
            $model->setStatus (1);
        
       if($model->save())
       {
            $this->_flashMessenger->addMessage(array('success'=>'Status changed for '.$model->getFirstName().' '.$model->getLastName().' [ ID : '.$model->getId().', Status : '.$model->getStatus().']'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/user/index'));  
       }
       else
       {
           $this->_flashMessenger->addMessage(array('error'=>'Failed to change the status for '.$model->getFirstName().' '.$model->getLastName().' [ ID : '.$model->getId().', Status : '.$model->getStatus().']'));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/user/index'));  
       }
       
    }
    
    public function userInfoAction()
    {
        $this->view->layout()->disableLayout();
        $userId=$this->_getParam("id");
        $model=new Security_Model_User();
        $user=$model->find( $userId);
       if(false===$user)
        {
            exit("Operation failed!");
        }
        $this->view->user=$user;
    }
    
    
    public function myProfileAction()
    {
        $usersNs = new Zend_Session_Namespace("members");
        $model=new Security_Model_User();
        $user=$model->find($usersNs->userId);
        if(false===$user)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request!'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/dashboard'));  
        }
        $form    = new Application_Form_User();
        $elements=$form->getElements();
        foreach($elements as $element)
        {
           if($element->getId()!="profilePicture" && $element->getId()!="submit" )
            $form->removeElement($element->getId());
        }
        
        $this->view->form=$form;
        $request = $this->getRequest();
        if ($request->isPost()) 
        {
             $options=$request->getPost();
             if ($form->isValid($options))
             {
                $user->uploadProfilePicture($usersNs->userId,$options);
                $this->_flashMessenger->addMessage(array('success'=>'Profile picture has been uploaded successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/user/my-profile'));  
             }
             else
             {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to upload the profile picture!'));
                $form->reset();
             } 
        }
        
        $this->view->user=$user;
    }
    
    public function changePasswordAction()
    {

        $request = $this->getRequest ();
        $form = new Security_Form_User();
        $userM=new Security_Model_User();
        $arrUser=$userM->getAllUsers();
        $form->addElement('select', 'userId',array(
                                    'label'      => 'Username:',
                                    'required'   => true,
                                    'validators' => array(
                                                    array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select username.')))
                                                    ),
                                    'decorators' => array(
                                        'ViewHelper',
                                        array('Errors', array('class'=>'input-notification-ul-li error png_bg')),
                                        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
                                        array('Label', array('tag' => 'td')),
                                        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
                                    ),
                                                                    'filters'    => array('StringTrim'),
                                    'MultiOptions'=>$arrUser
                                    ));
        
        $elements=$form->getElements();
        $form->clearDecorators();
        foreach($elements as $element)
        {
            $element->removeDecorator('label');
            //$element->removeDecorator('Errors');
            if($element->getName()!="password" && $element->getName()!="confirmPassword"  && $element->getName()!="userId"  && $element->getName()!="submit" )
            $form->removeElement($element->getName());
        }
        
        
        
        
        
        if ($request->isPost ()) 
        {
                $options = $request->getPost ();
                if ($form->isValid ( $options )) 
                {
                //        $usersNs = new Zend_Session_Namespace("members");
                    $user = new Security_Model_User();
                    $model = $user->find($options['userId']);
                    $model->setPassword(md5($options ['password']));
                    $model->save();
                    $this->_flashMessenger->addMessage(array('success'=>'Password has been changed successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/user/change-password'));
                } 
                else 
                {
                    $form->reset ();
                    $form->populate ( $options );
                }
        }
        // Assign the form to the view
        $this->view->form = $form;   
    }
    
    
    public function groupsAction()
    {
        $search = trim($this->_getParam('search'));
        $where="1=1";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search!="Search...")
        {
            $where="title like '%{$search}%'";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_Group();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->order('addedon DESC')->where($where);
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage("$page_size");
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator; 
    }
  
    public function ajaxGetSubGroupAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $group_id=$this->_getParam('group_id');
        
        $objPrivilege = new Admin_Model_Organization();
        
        $subgroups=$objPrivilege->getOrgamizationArray($group_id);
        
        //print_r ($subgroups);
        
        //$objPrivilege = new Base_Security_Privilege();
        //$subgroups=$objPrivilege->getSubGroupArray($group_id);
        echo Zend_Json::encode($subgroups);
    }
        
    
    
        
}
