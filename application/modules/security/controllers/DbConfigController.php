<?php
class Security_DbConfigController extends Base_Controller_Action{
    public function databaseConfigsAction(){
        $search = trim($this->_getParam('search'));
        $where="dbcnf_id<>'-2147483648'";
        $this->view->search="";
               if($search<>"")
        {
                    $where="(db_name like '%{$search}%')";
                    $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= Zend_Registry::get('page_size');
        $page =	$this->_getParam('page',1);
        $model=new Security_Model_DatabaseConfig();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from('dbconfiguration')
                 ->order('dbcnf_id ASC')->where($where);
        //$sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
       
        
    }
    public function addNewDbConfigAction(){
        
        $request = $this->getRequest();
        $form    = new Security_Form_DbConfig();
        
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
                //$options['status']='active';
                             
                $model=new Security_Model_DatabaseConfig($options);
                $id=$model->save();
                if($id)  
                {    
                    
                    $this->_flashMessenger->addMessage(array('success'=>'Db Configuration added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/db-config/add-new-db-config'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add Config!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/db-config/add-new-db-config'));
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
    public function editConfigAction(){
        $configId = $this->_getParam('id');
        $this->view->dbcnf_id = $configId;
        $model1 = new Security_Model_DatabaseConfig();
        $model = $model1->find($configId);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('admin/db-config/databaceConfigs'));  
        }
        $options['configId'] = $model->getConfigId();
        $options['dbServerName'] = $model->getDbServerName();
        $options['dbServerPort']      = $model->getDbServerPort();
        $options['dbUser'] = $model->getdbUser();
        $options['dbName'] = $model->getDbName();
        $options['dbPassword'] = $model->getDbPassword();
        $options['dbTransType'] = $model->getDbTransType();
        $options['status'] = $model->getStatus();
        
        $request = $this->getRequest();
        $form    = new Security_Form_DbConfig();
        $form->populate($options);
        $options=$request->getPost();
  
        if ($request->isPost()) 
        { 
           
            if ($form->isValid($options))
            {
               $model->setOptions($options);
                $model->save();
                $this->_flashMessenger->addMessage(array('success'=>'DB Cionfiguration has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/db-config/edit-Config/id/'.$configId));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
       
        $this->view->form		=$form;    
    }
    public function deleteConfigAction(){
         $id = $this->_getParam('id');
        
        $usersNs = new Zend_Session_Namespace("members");
        
        $this->view->dbcnf_id = $id;
        $model1 = new Security_Model_DatabaseConfig();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/data-baseConfig/database-configs'));  
        }
      
        
       if($model->delete("dbcnf_id=$id"))
       {
            $this->_flashMessenger->addMessage(array('success'=>'Data Deleted succesfully' ));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/db-config/database-configs'));  
       }
       else
       {
           $this->_flashMessenger->addMessage(array('error'=>'Failed to Delete the data '));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/db-config/database-configs'));  
       }
    }
}