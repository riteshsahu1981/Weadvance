<?php
class Mps_KnockingController extends Base_Controller_Action
{
    public function indexAction()
    {
       
    }
    
    public function killCowAction()
    {
        $request = $this->getRequest();
        $options=$request->getPost();

        if($options['supplier_id']){
            $Db=new Base_Db();
            $transaction_nid = $Db->genCodeId('transaction_id_'.$options[supplier_id]);
            $options1['transactionId'] = $transaction_nid;
            $options1['status'] = 1;
            $options1['breed'] = $options['map_id1'];
            $options1['type'] = $options['map_id2'];
            $options1['color'] = $options['map_id3'];
            $options1['supplierId'] = $options['supplier_id'];

            $options1['sequenceNo'] = $Db->genCodeId('sequence_num');
            $options1['tagNo'] = $Db->genCodeId('tag_num');
            $options1['processStatus'] = 'Knocked';
            $options1['knockedDate']=date("Y-m-d");
            $model=new Mps_Model_RawProduct($options1);
            $id=$model->save();
        }else{
            
            $model1 = new Mps_Model_RawProduct();
            $model = $model1->fetchRow("id='{$options['cow_id']}'");
            $model->setBreed($options['map_id1']);
            $model->setType($options['map_id2']);
            $model->setColor($options['map_id3']);
            $model->setProcessStatus('Knocked');
            $model->setKnockedDate(date("Y-m-d"));
            $id=$model->save();
       }
        if($id)  
        {   
            $this->_flashMessenger->addMessage(array('success'=>'Cow Knocked successfully!'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/knocking'));  
        }
        else
        {
            $this->_flashMessenger->addMessage(array('error'=>'Failed to KNock Cow!'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/knocking'));
        }
    }
    
    
    public function ajaxGetAnimalTypeAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $animal_id = $this->_getParam('animal_id');
        $objPrivilege = new Security_Model_SystemMapping();
        
        $subgroups = $objPrivilege->getAnimalTypeArray($animal_id);
       
        echo Zend_Json::encode($subgroups);
    }
    
    
    public function ajaxGetAnimalColorAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $breed_id = $this->_getParam('breed_id');
        $animal_id = $this->_getParam('animal_id');
        $objPrivilege = new Security_Model_SystemMapping();
        
        $subgroups = $objPrivilege->getAnimalColorArray($animal_id,$breed_id);
       
        echo Zend_Json::encode($subgroups);
    }
    
    public function ajaxGetSupplierCowAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $supplier_id = $this->_getParam('id');
        
        $rowObj = new Mps_Model_RawProduct();
        
        $subgroups = $rowObj->fetchRow("supplier_id = '$supplier_id' AND process_status = 'Incoming'");
        
        
        if(false===$subgroups)
                $arrResult=array("result"=>0);
        else
                $arrResult=array("result"=>$subgroups -> getId());

        echo Zend_Json::encode($arrResult);
        
        
        
    }
    
}//end of class
