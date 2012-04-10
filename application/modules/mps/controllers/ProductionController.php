<?php
class Mps_ProductionController extends Base_Controller_Action
{
    public function indexAction()
    {
        
    }
    
    public function listBloodStationAction()
    {
        //start Listing
        $Pstatus="BloodStation";
         if($this->_getParam('inputs')){
                $search_input = trim(implode(',',($this->_getParam('inputs'))));
            }
            else{
                $search_input = '';
          }
          
         
         $form    = new Mps_Form_Production();
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
        //Search form
    
    }
    
    //Start change values of blood station   
    public function saveBloodStationValueAction()
    {
       $this->view->layout()->disableLayout();
       $this->_helper->viewRenderer->setNoRender(true);
       $id = $this->_getParam('id');
       $value = $this->_getParam('value');
       $col=$this->_getParam('col');
       
       $model = new Mps_Model_RawProduct();
       $model = $model->fetchRow("id='{$id}'");
       
       if ($col=='auction_tag')
           $model->setAuctionTag($value);
       else if ($col=='ear_tag')
           $model->setEarTag ($value);
       else if ($col=='trich')
           $model->setTrich ($value);
       else if ($col=='defects')
           $model->setDefects($value);
       else if ($col=='back_tag')
           $model->setBackTag($value);
       else if ($col=='grade')
           $model->setGrade($value);
       
       $res=$model->save();
       if(false===$res)
                $arrResult=array("result"=>0);
        else
                $arrResult=array("result"=>1);

        echo Zend_Json::encode($arrResult);
    }
    //End change values of blood station          
    
    //Start change values of Condumn values in blood station ajax  
    public function saveCondumnValueAction()
    {
       $this->view->layout()->disableLayout();
       $this->_helper->viewRenderer->setNoRender(true);
       $id = $this->_getParam('id');
       $value = $this->_getParam('value');
    
       
       $model = new Mps_Model_RawProduct();
       $model = $model->fetchRow("id='{$id}'");
       $model->setCondumnSubStatus($value);
       $res=$model->save();
       if(false===$res)
                $arrResult=array("result"=>0);
        else
                $arrResult=array("result"=>1);

        echo Zend_Json::encode($arrResult);
    }
    //End change values of Condumn values in blood station              
    
    //change process station status
    public function changeProcessStatusAction() 
    {
            $this->view->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $id = $this->_getParam('id');
            $oldstatus = $this->_getParam('oldstatus');
            if ((!empty($id)) && (!empty($oldstatus)))
            {
                $model1 = new Mps_Model_RawProduct();
                $model = $model1->fetchRow("id='$id'");
                if (($model!==false) && ($model->getProcessStatus()==$oldstatus))
                {
                    //Incoming/Knocking/Killed/Compliance/BloodStation/Weighing
                    $flag=0;
                    if ($oldstatus=='Incoming')
                        $status='Knocking';
                    else if ($oldstatus=='Knocking')
                        $status='Killed';
                    else if ($oldstatus=='Killed')
                        $status='Compliance';
                    else if ($oldstatus=='Compliance')
                        $status='BloodStation';
                    else if ($oldstatus=='BloodStation')
                        $status='Weighing';
                    else if ($oldstatus=='Weighing')
                        $status='Complete';
                    else
                    {
                        $arrResult=array("result"=>0);  
                        $flag=1;
                    }
                    
                    if ($flag==0)
                    {
                        $model->setStatus($status);
                        $res=$model->save();
                        $arrResult=array("result"=>1); 
                    }
                
                }
                else
                {
                    $arrResult=array("result"=>0);   
                   
                }
            }
            else
            {
              $arrResult=array("result"=>0);   
            }
            echo Zend_Json::encode($arrResult);
           
    }
    //End process station status
    
    //Start Listing of weighing
    public function weighingAction()
    {
         $model=new Mps_Model_RawProduct();
         $Pstatus="Weighing";
         $code="fdCondumnStatus";
         $model2	=   new Base_Security_Privilege();
         $arrValues     =   $model2->getCondumnValues($code);
         $arrSubcondumn =   $model2->getCondumnValues('fdCondumnSubStatus');
         
         $this->view->condumnValue=$arrValues;
         $this->view->condumnSubValue=$arrSubcondumn;
         
         $where="p.id<>'-2147483648' and process_status='$Pstatus'";
        //Edit cow weight values
        $request = $this->getRequest();
        $options=$request->getPost();
        
        $cowid = trim($this->_getParam('cowid'));
        $weight=trim($this->_getParam("weight"));
        $this->view->cowid=$cowid;
        if ($request->isPost())
        {
            if (isset($options['submit']))
            {
                //Update Cow weight
                $isExist=$model->isExist("id='$cowid' and process_status='$Pstatus'");
                if ($isExist)
                {
                  $model = $model->fetchRow("id='$cowid' and process_status='$Pstatus'");  
                  if ($model!==false)
                  {
                      $model->setWeight($weight);
                      $model->save();
                  }
                  $this->_flashMessenger->addMessage(array('success'=>'Cow weight has been updated successfully!'));
                  $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/production/weighing/cowid/'.$cowid));  
                }
                else
                {
                $this->_flashMessenger->addMessage(array('error'=>'Cow ID does not exist!')); 
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/production/weighing/cowid/'.$cowid));  
                }
                //End Update Cow weight
            } else  {
                //Update condumn status and weight
                $condumnStatus=trim($this->_getParam("condumnStatus")); 
                //get condumn id on the basis of condumn value
                while ($value = current($arrValues)) {
                if ($value == $condumnStatus) {
                $condumnID=key($arrValues);
                }
                next($arrValues);
                }
               
                $model = $model->fetchRow("id='$cowid' and process_status='$Pstatus'");
                  if (($model!==false) && (!empty($condumnID)))
                  {
                      $model->setWeight($weight);
                      $model->setStatusOn($condumnID);
                      $model->save();
                      $this->_flashMessenger->addMessage(array('success'=>'Condumn status has been updated successfully!'));
                      $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/production/weighing/cowid/'.$cowid));  
                      
                  }
                  else
                  {
                    $this->_flashMessenger->addMessage(array('error'=>'Invalid Condumn status')); 
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/production/weighing/'));  
                  }
                  //End Update condumn status and weight
                
                
            }
        }
        
        
        //End Edit
        
        /*---sorting ----*/
        $order = trim($this->_getParam('order', ""));
        $col = trim($this->_getParam('col',""));

        if($order<>"" && $col<>"")
        {
        if($col=="id")
        $strOrderBy="p.id {$order}";
        else if($col=="knocked_date")
             $strOrderBy="p.knocked_date {$order}";
        else if($col=="first_name")
             $strOrderBy=array("s.first_name {$order}","s.last_name $order");
        }
        else
        {
        $strOrderBy="p.knocked_date desc"; //"p.knocked_date desc"
        }
        $this->view->sortOptions=array();
        /*-----sorting----------*/
        
        
         /*--search---*/
        
        $this->view->linkArray=array();
        $page_size= Zend_Registry::get('page_size');
        $page = $this->_getParam('page',1);
        
       
        $table=$model->getMapper()->getDbTable();
        
       
        
        $select = $table->select()->setIntegrityCheck(false)->from(array("s"=>'supplier'), array("first_name","last_name"))
                ->join(array("p"=>"raw_product"),"s.id=p.supplier_id and p.process_status='$Pstatus' and s.id!='-2147483648'", array("*"))
                ->order($strOrderBy);
       // echo $sql = $select->__toString(); die;
       
        $paginator =  Base_Paginator::factory($select);

        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);

        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
        
        
    }
    //End Weighing Listing
    
    //Start Edit weight value in weighing ajax   
    public function saveWeighingValueAction()
    {
       $this->view->layout()->disableLayout();
       $this->_helper->viewRenderer->setNoRender(true);
       $id = $this->_getParam('id');
       $value = $this->_getParam('value');
      
       
       $model = new Mps_Model_RawProduct();
       $model = $model->fetchRow("id='{$id}'");
       
       $model->setWeight($value);
       $res=$model->save();
       if(false===$res)
                $arrResult=array("result"=>0);
        else
                $arrResult=array("result"=>1);

        echo Zend_Json::encode($arrResult);
    }
    //End change values of weight in Weighing        

    //Start check cow id exist or not   
    public function checkCowidAction()
    {
       $this->view->layout()->disableLayout();
       $this->_helper->viewRenderer->setNoRender(true);
       $id = $this->_getParam('id');
       $p_status=$this->_getParam('process_status');
       $model = new Mps_Model_RawProduct();
       $model = $model->isExist("id='{$id}' and process_status='$p_status'");
       
      
       if(false===$model)
                $arrResult=array("result"=>0);
        else
                $arrResult=array("result"=>1);

        echo Zend_Json::encode($arrResult);
    }
    //End check cow id exist or not      

}//end of class
