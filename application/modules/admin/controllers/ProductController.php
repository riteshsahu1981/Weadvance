<?php
class Admin_ProductController extends Base_Controller_Action
{
        
        public function indexAction()
        { 
            /*--search---*/
            
            $search_pid = trim($this->_getParam('productIdentifier'));
            $search_pname = trim($this->_getParam('labelCase'));
            if($this->_getParam('packLocation')){
                $search_plocation = trim(implode(',',($this->_getParam('packLocation'))));
            }
            else{
                $search_plocation = '';
            }
            
            /*---sorting ----*/
            $order = trim($this->_getParam('order', ""));
            $col = trim($this->_getParam('col',""));
            $form    = new Admin_Form_Product();
            $elements=$form->getElements();
            $form->clearDecorators();
               
               
            foreach($elements as $element)
            {
                $element->removeDecorator('label');
                $element->removeDecorator('row');
                $element->removeDecorator('data');
                $element->removeDecorator('required');
                //$element->removeDecorator('Errors');
            } 
            
            //remove fields do not need to display in Edit


            $usersNs = new Zend_Session_Namespace("members");
           
                
             $form->removeElement('caseFormat');
             $form->removeElement('partNumber'); 
             $form->removeElement('sellByDays'); 
             $form->removeElement('priceLb'); 
             $form->removeElement('palletId'); 
             $form->removeElement('desLine1'); 
             $form->removeElement('desLine2');
             $form->removeElement('desLine3'); 
             $form->removeElement('desLine4'); 
             $form->removeElement('lowerWeight'); 
             $form->removeElement('fixedWeight'); 
             $form->removeElement('heighWeight'); 
             $form->removeElement('tareWeight');
             $form->removeElement('requiredApp'); 
            	
            
            
            if($order<>"" && $col<>"")
            {
                if($col=="pack_location")
                    $strOrderBy="p.pack_location {$order}";
                
            }
            else
            {
                $strOrderBy="p.product_identifier asc";
            }
            $this->view->sortOptions=array();
            /*-----sorting----------*/

            $where="p.id<>'-2147483648'";
            $this->view->linkArray=array();
            $this->view->search="";
            if(($search_pid<>"" ) || ($search_pname<>"" ) || ($search_plocation<>"" ))
            {
                $params=$this->_getAllParams();
                
                $where="(product_identifier like '%{$search_pid}%') AND (label_case like '%{$search_pname}%') AND (pack_location like '%{$search_plocation}%') AND {$where} ";
                
                $this->view->linkArray=array('productIdentifier'=>$search_pid);
                //$form->productIdentifier->setValue($search_pid);
                //$form->labelCase->setValue($search_pname);
                
                $this->view->sortOptions['productIdentifier']=$search_pid;
                $this->view->sortOptions['labelCase']=$search_pname;
                $this->view->sortOptions['packLocation']=$search_plocation;
                
                $form->populate($params);
                //print_r($params);
            }
            
            
            
            $page_size= Zend_Registry::get('page_size');
            $page = $this->_getParam('page',1);
            $model=new Admin_Model_Product();
            $table=$model->getMapper()->getDbTable();
            $select = $table->select()->setIntegrityCheck(false)->from(array("p"=>'product'))
                    ->order("$strOrderBy")->where($where);
            $sql = $select->__toString(); 
            $paginator =  Base_Paginator::factory($select);

            $paginator->setItemCountPerPage($page_size);
            $paginator->setCurrentPageNumber($page);

            $this->view->totalItems= $paginator->getTotalItemCount();
            $this->view->paginator=$paginator;
            $this->view->form=$form;
        }
        
        public function createProductAction()
        {
            $this->view->pageHeading="Add Product";
            
            $request = $this->getRequest();
            $form    = new Admin_Form_Product();
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
                    $options['packLocation'] = implode(",",$options['packLocation']);
                    $model=new Admin_Model_Product($options);
                    
                    $id=$model->save();
                    if($id)  
                    {    
                        $this->_flashMessenger->addMessage(array('success'=>'Product added successfully!'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/product/create-product'));  
                    }
                    else
                    {
                        $this->_flashMessenger->addMessage(array('error'=>'Failed to add Product!'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/product/create-product'));
                    }
                    //$form->reset();
                }
                else
                {
                    $form->reset();
                    $form->populate($options);
                }
                    $this->view->pageHeading="Add Product";
            }
            $this->view->form =  $form;
        }
        
        
        public function editProductAction()
        {
            $id = $this->_getParam('id');
            $this->view->user_id = $id;
            $model1 = new Admin_Model_Product();
            $model = $model1->find($id);
            if(false===$model)
            {
                $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/product'));  
            }
            
            $options['caseFormat'] = $model->getCaseFormat();
            $options['labelCase'] = $model->getLabelCase();
            $options['productIdentifier'] = $model->getProductIdentifier();
            $options['packLocation'] = explode(",",$model->getPackLocation());
            $options['partNumber'] = $model->getPartNumber();
            $options['sellByDays'] = $model->getSellByDays();
            $options['priceLb'] = $model->getPriceLb();
            $options['palletId'] = $model->getPalletId();
            $options['desLine1'] = $model->getDesLine1();
            $options['desLine2'] = $model->getDesLine2();
            $options['desLine3'] = $model->getDesLine3();
            $options['desLine4'] = $model->getDesLine4();
            $options['lowerWeight'] = $model->getLowerWeight();
            $options['fixedWeight'] = $model->getFixedWeight();
            $options['heighWeight'] = $model->getHeighWeight();
            $options['tareWeight'] = $model->getTareWeight();
            $options['requiredApp'] = $model->getRequiredApp();
            
           
         
            $request = $this->getRequest();
            
            $form    = new Admin_Form_Product();
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
            //$form->removeElement('username');
            //$form->removeElement('password');
            //$form->removeElement('c_password');

            $usersNs = new Zend_Session_Namespace("members");
            if($usersNs ->userId==$id)
            {
                
                //$form->removeElement('roleId');
                //$form->removeElement('status');    
            }		
            
            //$modelP	= new Base_Security_Privilege();
            //$arrSubgroup = $modelP->getSubGroupArray($model->getGroupId());

            //$form->getElement("subGroupId")->addMultiOptions( $arrSubgroup );
            $form->populate($options);
           
            
            //die;
            //$arrUserRole = $modelP->getRoleArray($model->getSubGroupId());
            //$form->getElement("roleId")->addMultiOptions( $arrUserRole );


            //$form->populate($options);

            $options=$request->getPost();
            
            if ($request->isPost()) 
            { 
                /*---- email validation ----*/
                

                /*-------------------------*/

                $modelP	= new Base_Security_Privilege();
                //$arrSubgroup = $modelP->getSubGroupArray($options['groupId']);

                //$form->getElement("subGroupId")->addMultiOptions( $arrSubgroup );
                //$form->populate($options);

               // $arrUserRole = $modelP->getRoleArray($options['subGroupId']);
                //$form->getElement("roleId")->addMultiOptions( $arrUserRole );


                if ($form->isValid($options))
                {
                    $options['packLocation'] = implode(",",$options['packLocation']);
                    $model->setOptions($options);
                    $model->save();
                    /*---------  Upload image START -------------------------*/
                    //$model->uploadProfilePicture($id,$options);
                    /*---------  Upload image END -------------------------*/
                    $this->_flashMessenger->addMessage(array('success'=>'Product information has been updated successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/product/edit-product/id/'.$id));  
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
        }//end of edit-product function
        
        
        
         public function changeUserStatusAction()
         {
            $id = $this->_getParam('id');
            $guid = $this->_getParam('guid');
            $usersNs = new Zend_Session_Namespace("members");
            if($usersNs->userId==$id)
            {
            $this->_flashMessenger->addMessage(array('error'=>'You cannot change your status!' ));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/product'));  
            exit;
            } 
            $this->view->user_id = $id;
            $model1 = new Admin_Model_Product();
            $model = $model1->fetchRow("id='{$id}' and row_guid='{$guid}'");
            if(false===$model )
            {
                $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/product'));  
            }

          
            if($model->getStatus()=="1")
                $model->setStatus ("0");
            else
                $model->setStatus ("1");

        if($model->save())
        {
                $this->_flashMessenger->addMessage(array('success'=>'Status changed for '.$model->getProductIdentifier().'  [ ID : '.$model->getId().', Status : '.$model->getStatus().']'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/product/index'));  
        }
        else
        {
            $this->_flashMessenger->addMessage(array('error'=>'Failed to change the status for '.$model->getProductIdentifier().'  [ ID : '.$model->getId().', Status : '.$model->getStatus().']'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/product/index'));  
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
        
        $model = new Admin_Model_Product();
        $res=$model->changeStatus($id, $status);
        if(false===$res)
            $arrResult=array("result"=>0);
        else
            $arrResult=array("result"=>1);
        
        echo Zend_Json::encode($arrResult);
       
    }
        
 
}//end of class
