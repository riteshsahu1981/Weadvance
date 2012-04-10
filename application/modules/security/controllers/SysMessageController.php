<?php
class Security_SysMessageController extends Base_Controller_Action
{  
    public function messagesAction()
    { 
        /*--search---*/
        $categoryName = trim($this->_getParam('categoryName'));
        $severityName= trim($this->_getParam('severityName'));
        $typeName= trim($this->_getParam('typeName'));
        
        
        /*---sorting ----*/
        $order = trim($this->_getParam('order', ""));
        $col = trim($this->_getParam('col',""));
                
        if($order<>"" && $col<>"")
        {
            if($col=="category")
                $strOrderBy="c.master_value {$order}";
            else if($col=="severity")
                $strOrderBy="s.master_value {$order}";
            else if($col=="type")
                $strOrderBy="t.master_value {$order}";
        }
        else
        {
            $strOrderBy="m.message_id desc";
        }
        $this->view->sortOptions=array();
        /*-----sorting----------*/
        
       $where="m.message_id<>'-2147483648'";
        $this->view->linkArray=array();
        $this->view->categoryName="";
        if($categoryName<>"")
        {
            $where.=" and c.master_value like '%{$categoryName}%' ";
            $this->view->linkArray['categoryName']=$categoryName;
            $this->view->categoryName=$categoryName;
            $this->view->sortOptions['categoryName']=$categoryName;
        }
        
        $this->view->severityName="";
        if($severityName<>"")
        {
            $where.=" and s.master_value like '%{$severityName}%' ";
            $this->view->linkArray['severityName']=$severityName;
            $this->view->severityName=$severityName;
            $this->view->sortOptions['severityName']=$severityName;
        }
        
        $this->view->typeName="";
        if($typeName<>"")
        {
            $where.=" and t.master_value like '%{$typeName}%' ";
            $this->view->linkArray['typeName']=$typeName;
            $this->view->typeName=$typeName;
            $this->view->sortOptions['typeName']=$typeName;
        }
        
        $this->view->page_size=$page_size= Zend_Registry::get('page_size');
        $page =	$this->_getParam('page',1);
        $model=new Security_Model_SysMessage();
        $table=$model->getMapper()->getDbTable();
        
         $select = $table->select()->setIntegrityCheck(false)->from(array("m"=>'sys_message'))
                 ->join(array("c"=>"system_master"),"m.category_id=c.master_id and c.master_code='fdSysMessageCategory'", array("category_name"=>'master_value') )
                 ->join(array("s"=>"system_master"),"m.severity_id=s.master_id and s.master_code='fdSysMessageSeverity'", array("severity_name"=>'master_value') )
                 ->join(array("t"=>"system_master"),"m.type_id=t.master_id and t.master_code='fdSysMessageType'", array("type_name"=>'master_value') )
                    ->order($strOrderBy)->where($where);
        
        //echo $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
       
    }
        
    public function addMessageAction()  {   //create new message
    
        $this->view->postUrl=$this->getRequest()->getRequestUri();
        $request = $this->getRequest();
        $form    = new Security_Form_SysMessage();
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
                             
                $model=new Security_Model_SysMessage($options);
                $id=$model->save();
                if($id)  
                {    
                    
                    $this->_flashMessenger->addMessage(array('success'=>'Message added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl($this->view->postUrl));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add Message!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl($this->view->postUrl));
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
    }// End create new message
    
    
       public function editMessageAction(){  //Edit Message
           
        $this->view->postUrl=$this->getRequest()->getRequestUri();
        $messageId = $this->_getParam('id');
        $guid= $this->_getParam('guid');
        
        $model1 = new Security_Model_SysMessage();
        $model = $model1->fetchRow("message_id='{$messageId}' and row_guid='$guid'");
        
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/sys-message/messages'));  
        }
        $options['categoryId'] = $model->getCategoryId();
        $options['severityId'] = $model->getSeverityId();
        $options['typeId'] = $model->getTypeId();
        $options['userMessage'] = $model->getUserMessage();
        $options['sysMessage'] = $model->getSysMessage();
        
        $request = $this->getRequest();
        
        $form    = new Security_Form_SysMessage();
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
            if($options['user_message']==$model->getUserMessage())
            {
               $form->getElement('userMessage')->removeValidator("Db_NoRecordExists");
            }
            if ($form->isValid($options))
            {
               $model->setOptions($options);
                $model->save();
                $this->_flashMessenger->addMessage(array('success'=>'Message has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl($this->view->postUrl));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
       
        $this->view->form		=$form;  
         
     }// end  Edit message
       //delete message function start
     public function deleteMessageAction()
    {
        $id = $this->_getParam('id');
        $guid = $this->_getParam('guid');

        $model1 = new Security_Model_SysMessage();
        $model = $model1->fetchRow("message_id='{$id}' and row_guid='$guid'");
   
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/sys-message/messages'));  
        }
      
        
       if($model->delete("message_id=$id"))
       {
            $this->_flashMessenger->addMessage(array('success'=>'Data Deleted succesfully' ));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/sys-message/messages'));  
       }
       else
       {
           $this->_flashMessenger->addMessage(array('error'=>'Failed to Delete the data '));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/sys-message/messages'));  
       }
       
    }

}