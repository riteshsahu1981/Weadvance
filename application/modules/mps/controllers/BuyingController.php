<?php
class Mps_BuyingController extends Base_Controller_Action
{
    public function indexAction()
    {
        $request = $this->getRequest();
        $form    = new Mps_Form_Buying();
        $elements=$form->getElements();
        foreach($elements as $element)
        {
            $element->removeDecorator('label');
        }  
        $form->clearDecorators();
        if ($request->isPost())
        {
            $options=$request->getPost();
            
            if ($form->isValid($options))
            { 
                $options['status']=1;
                
                $model=new Mps_Model_RawProduct($options);
                $id=$model->save();
                if($id)  
                {   
                    $this->_flashMessenger->addMessage(array('success'=>'Organization added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/organization/create-organization'));  
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
    }
    
    
    public function ajaxGetSaveRawProductAction()
    {
        $this->view->layout()->disableLayout();
        //$this->_helper->viewRenderer->setNoRender(true);
        $num_cows=$this->_getParam('num_cows');
        $arrIds=array();
        for($i=0;$i<$num_cows;$i++)
        {
            $Db=new Base_Db();
            $arrIds[]=$Db->genId("raw_product", 'id');
        }
        
        if(count($arrIds)==0)
        {
            $this->_helper->viewRenderer->setNoRender(true);
            echo "0";
        }
        else
            $this->view->arrIds=$arrIds;
    }
    
    public function ajaxSaveRawProductAction()
    {
        $request = $this->getRequest();
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $Db=new Base_Db();
        $transaction_nid = $Db->genCodeId('transaction_id');
        
        $options = $request->getPost();
        $options['transactionId'] = $transaction_nid;
        $options['status'] = 1;
        $tag_edited_arr = explode(',',$options['tag_edited_str']); 
        $i = 0;
        
        while($options['num_cows']){
            if(isset($tag_edited_arr[$i])){
                $options['tagNo'] =  $tag_edited_arr[$i];
            }else{
                $options['tagNo'] = '';
            }
            $options['sequenceNo'] = $Db->genCodeId('sequence_num');
            $options['processStatus'] = 'Incoming';
            $options['incomingDate']=date("Y-m-d");
            $model=new Mps_Model_RawProduct($options);
            $id=$model->save();
            $options['num_cows']--;
            $i++;
        }
        
        echo Zend_Json::encode($id);
    }
    
    public function ajaxGetSavePrintRawProductAction()
    {
        $request = $this->getRequest();
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
         
        $Db=new Base_Db();
        $transaction_nid = $Db->genCodeId('transaction_id');
            
        $options = $request->getPost();
        
        $options['transactionId'] = $transaction_nid;
        $options['status'] = 1;
        
        $i = 0;
        while($options['num_cows']){
            $options['sequenceNo'] = $Db->genCodeId('sequence_num');
            $options['tagNo'] = $Db->genCodeId('tag_num');
            $options['processStatus'] = 'Incoming';
            $options['incomingDate']=date("Y-m-d");
            $model=new Mps_Model_RawProduct($options);
            $id=$model->save();
            $options['num_cows']--;
            $i++;
        }
        
        echo Zend_Json::encode($id);
    }
    
}//end of class
