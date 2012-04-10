<?php
class Security_WorkflowController extends Base_Controller_Action
{  
    public function indexAction()
    {
        
    }
    public function workflowListAction()
    {
        /*--search---*/
        
    
        $search = trim($this->_getParam('search'));
        
        
        /*---sorting ----*/
        $order = trim($this->_getParam('order', ""));
        $col = trim($this->_getParam('col',""));
                
        if($order<>"" && $col<>"")
        {
            $strOrderBy="w.{$col} {$order}";
        }
        else
        {
            $strOrderBy="w.workflow_name asc";
        }
        $this->view->sortOptions=array();
        /*-----sorting----------*/
        
        $where="w.id<>'-2147483648' and w.is_deleted<>1";
        $this->view->linkArray=array();
        $this->view->search="";
        if($search<>"" )
        {
            $where="w.workflow_name like '%{$search}%' and {$where} ";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
            $this->view->sortOptions['search']=$search;
        }
        
        $model=new Security_Model_User();
        $table=$model->getMapper()->getDbTable();
        
        $select = $table->select()->setIntegrityCheck(false)->from(array("w"=>'workflow_master'), array("id", "workflow_name", "row_guid", "is_deleted"))
                ->order($strOrderBy)->where($where);
        //echo $sql = $select->__toString(); exit;
        
        $page_size= Zend_Registry::get('page_size');
        $page =	$this->_getParam('page',1);
        $paginator =  Base_Paginator::factory($select);
       
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
    }
    public function addWorkflowAction()
    {
        $request = $this->getRequest();
        $form    = new Security_Form_Workflow();
        $elements=$form->getElements();
        $form->clearDecorators();

        foreach($elements as $element)
        {
            $element->removeDecorator('label');
            //$element->removeDecorator('Errors');
        }  

        
        if ($request->isPost())
        {
            
            $form->getElement('workflowName')->addValidators(array(
            array('Db_NoRecordExists', false, array(
            'table' => 'workflow_master',
            'field' => 'workflow_name',
            'messages'=>'Workflow already exists, Please choose another name.'
                    ))
            ));
            
            $options=$request->getPost();
                  
            if ($form->isValid($options))
            { 
                $model=new Security_Model_WorkflowMaster($options);
                $id=$model->save();
                if($id)  
                {    
                    /*---------  Upload image START -------------------------*/
                    //$model->uploadProfilePicture($id,$options);
                    /*---------  Upload image END -------------------------*/
                    $this->_flashMessenger->addMessage(array('success'=>'Workflow added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/workflow/add-workflow'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add workflow!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/workflow/add-workflow'));
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
    public function editWorkflowAction()
    {
        $this->view->postUrl=$this->getRequest()->getRequestUri();
        $id = $this->_getParam('id');
        $guid = $this->_getParam('guid');
        
        $model1 = new Security_Model_WorkflowMaster();
        $model = $model1->fetchRow("id='{$id}' and row_guid='{$guid}'");
        //$model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/workflow/workflow-list'));  
        }
        $options['workflowName'] = $model->getWorkflowName();
        $request = $this->getRequest();
        $form    = new Security_Form_Workflow();
        $elements=$form->getElements();
        $form->clearDecorators();

        foreach($elements as $element)
        {
            $element->removeDecorator('label');
            //$element->removeDecorator('Errors');
        }  
        
        $form->populate($options);
        
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
             /*---- email validation ----*/
            if($options['workflowName']!=$model->getWorkflowName())
            {
               
                $form->getElement('workflowName')->addValidators(array(
                array('Db_NoRecordExists', false, array(
                'table' => 'workflow_master',
                'field' => 'workflow_name',
                'messages'=>'Workflow already exists, Please choose another name.'
                        ))
                ));
            }
          
            /*-------------------------*/
            if ($form->isValid($options))
            {
                $model->setOptions($options);
                $model->save();
                $this->_flashMessenger->addMessage(array('success'=>'Workflow name has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl($this->view->postUrl));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }

        $this->view->form		=	$form;
    }
    
    public function deleteWorkflowAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $id = $this->_getParam('id');
        $guid = $this->_getParam('guid');
        $model1 = new Security_Model_WorkflowMaster();
        $model = $model1->fetchRow("id='{$id}' and row_guid='{$guid}'");
        if(false===$model )
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/workflow/workflow-list'));  
        }
        
        $model->setIsDeleted(1);
        if($model->save())
        {
            $this->_flashMessenger->addMessage(array('success'=>'Workflow deleted successfully'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/workflow/workflow-list'));  
        }
        
    }
    
    
    
    
    
    
    
    
    
    public function listWorkflowDetailAction()
    {
        
    }
    
    
    public function addWorkflowDetailAction()
    {
        $request = $this->getRequest();
        $form    = new Security_Form_WorkflowDetail();
        $elements=$form->getElements();
        $form->clearDecorators();

        foreach($elements as $element)
        {
            $element->removeDecorator('label');
            //$element->removeDecorator('Errors');
        }  

        
        if ($request->isPost())
        {
            
            $form->getElement('workflowName')->addValidators(array(
            array('Db_NoRecordExists', false, array(
            'table' => 'workflow_master',
            'field' => 'workflow_name',
            'messages'=>'Workflow already exists, Please choose another name.'
                    ))
            ));
            
            $options=$request->getPost();
                  
            if ($form->isValid($options))
            { 
                $model=new Security_Model_WorkflowMaster($options);
                $id=$model->save();
                if($id)  
                {    
                    /*---------  Upload image START -------------------------*/
                    //$model->uploadProfilePicture($id,$options);
                    /*---------  Upload image END -------------------------*/
                    $this->_flashMessenger->addMessage(array('success'=>'Workflow added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/workflow/add-workflow'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add workflow!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/workflow/add-workflow'));
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
}