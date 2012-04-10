<?php
class Mps_ComplianceController extends Base_Controller_Action
{
    public function indexAction()
    {
       $Pstatus="Knocked";
         if($this->_getParam('inputs')){
                $search_input = trim(implode(',',($this->_getParam('inputs'))));
            }
            else{
                $search_input = '';
          }
          
         
         $form    = new Mps_Form_Compliance();
         $elements=$form->getElements();
         $form->clearDecorators();
         foreach($elements as $element)
         {
            $element->removeDecorator('data');
            $element->removeDecorator('Label');
            $element->removeDecorator('row');
            
         } 
         
       //Used in listing
        $model2	=	new Base_Security_Privilege();
        $arrCondumnSubValue=	$model2->getCondumnValues('fdCondumnSubStatus');
        $this->view->condumnSubValue=$arrCondumnSubValue;
        //End
       
        
        
        /*---sorting ----*/
        $order = trim($this->_getParam('order', ""));
        $col = trim($this->_getParam('col',""));

        if($order<>"" && $col<>"")
        {
        if($col=="breed")
        $strOrderBy="s2.master_value {$order}";
        else if($col=="type")
             $strOrderBy="s.master_value {$order}";
        else if($col=="color")
             $strOrderBy="s3.master_value {$order}";
        else if($col=="auction_tag")
             $strOrderBy="p.auction_tag {$order}";
        else if($col=="ear_tag")
             $strOrderBy="p.ear_tag {$order}";
        else if($col=="trich")
             $strOrderBy="p.trich {$order}";
        else if($col=="trich")
             $strOrderBy="p.trich {$order}";
        else if ($col=='id')
            $strOrderBy="p.id {$order}";
        }
        else
        {
        $strOrderBy="p.id";
        }
        $this->view->sortOptions=array();
        /*-----sorting----------*/

         /*--search---*/
        $search = trim($this->_getParam('search'));
        $where="p.id<>'-2147483648' and p.process_status='$Pstatus'";
        $this->view->linkArray=array();
        if($search<>"" )
        {
            $params=$this->_getAllParams(); 
            $breed=trim($this->_getParam('breed'));
            $type=trim($this->_getParam('type'));
            $color=trim($this->_getParam('color'));
            $id=trim($this->_getParam('id'));
            $supplier=trim($this->_getParam('supplier'));
            
            
         if (!empty($breed))   
             $where.=" and breed='$breed'";
         if (!empty($type))   
             $where.=" and type='$type'";
         if (!empty($color))   
             $where.=" and color = '$color'";
         if (!empty($id))   
             $where=" and id = '$id' and p.process_status='$Pstatus'";
         if (!empty($supplier))   
             $where.=" and supplier_id = '$supplier'";
         if (!empty($search_input))   
             $where.=" and condumn_sub_status like '%$search_input%'";
         
       
         $where="{$where}";
        
         $this->view->sortOptions['inputs']=$search_input;
         $form->populate($params);
         }
        


        $page_size= Zend_Registry::get('page_size');
        $page = $this->_getParam('page',1);
        
        $model=new Mps_Model_RawProduct();
        $table=$model->getMapper()->getDbTable();
        
        $select = $table->select()->setIntegrityCheck(false)->from(array("p"=>'raw_product'),array("*"))
                ->join(array("s"=>"system_master"),"s.master_code='fdAnimalType' and s.master_id=p.type",array("type"=>"master_value"))
                ->join(array("s2"=>"system_master"),"s2.master_code='fdAnimal' and s2.master_id=p.breed",array("breed"=>"master_value"))
                ->join(array("s3"=>"system_master"),"s3.master_code='fdAnimalColor' and s3.master_id=p.color",array("color"=>"master_value"))                
        ->order("$strOrderBy")->where($where);
        
       // echo $sql = $select->__toString(); die;
        $paginator =  Base_Paginator::factory($select);

        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);

        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
        //End Listing
        $this->view->form =  $form;
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
            $options1['type'] = $options['map_id1'];
            $options1['breed'] = $options['map_id2'];
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
            $model->setType($options['map_id1']);
            $model->setBreed($options['map_id2']);
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
