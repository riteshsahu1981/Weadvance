<?php
class Admin_WidgetController extends Base_Controller_Action{
    
    //start manage widgets
    public function manageAction()
    {
            $code="fdWidget";
            $usersNs = new Zend_Session_Namespace("members");
            $mapId1=$usersNs->userId;
            $where="s.master_code='$code'";
            $model=new Security_Model_SystemMaster();
            $table=$model->getMapper()->getDbTable();
            /*SELECT s.master_value,s.master_code,sm.map_id1 from system_master s,system_mapping sm where sm.map_code='fdWidget' 
             and s.master_code=sm.map_code and s.master_id=sm.map_id2*/
            $model2=new Security_Model_SystemMapping();
            $exist=$model2->isExist("map_code='$code' and map_id1='$mapId1'");
            
            if ($exist)
            {
               $select = $table->select()->setIntegrityCheck(false)->from(array("s"=>'system_master'), array("master_value"))
                ->join(array("sm"=>"system_mapping"),"sm.map_code='fdWidget' and sm.map_id1='$mapId1'  and s.master_code=sm.map_code and s.master_id=sm.map_id2", array("master_id"=>'map_id2',"intval1"=>'intval1',"intval2"=>'intval2') )
                ->order("sm.map_id3");
                
        
       // echo $sql = $select->__toString(); exit;
        
                
            }
            else
            {
                $select = $table->select()->setIntegrityCheck(false)->from(array("s"=>'system_master'))
                    ->where($where);
            }
            $sql = $select->__toString(); 
            
           $this->view->widgets=$table->fetchAll($select );

    }
    //End manage widgets   
    
    
    //Start Edit manage widgets   
    public function editWidgetAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $request = $this->getRequest();
         $usersNs = new Zend_Session_Namespace("members");
         
        $mapCode="fdWidget";
        $mapId1=$usersNs->userId;
        if ($request->isPost())
        { 
           $model1=new Security_Model_SystemMaster();
           $model = $model1->fetchAll("master_code='fdWidget'");
            
            $model2=new Security_Model_SystemMapping();
            $model2->delete("map_code='{$mapCode}' and map_id1='{$mapId1}'");
            foreach($model as $_row)
            {
                $disC="display".$_row->getMasterId();
                $ordC="order".$_row->getMasterId();
         
                $intval1=$_POST[$disC];
                $intval2=$_POST[$ordC];
                if (empty($intval2))
                $intval2=0;
                
                if (empty($intval1))
                    $intval1=0;
                else
                    $intval1=1;
                
                $mapId2=$_row->getMasterId();
                $model2->setMapCode($mapCode)
                    ->setMapId1($mapId1)
                    ->setMapId2($mapId2)
                    ->setIntval1($intval1)
                    ->setIntval2($intval2)
                    ->save();
               
            }
                
                    $this->_flashMessenger->addMessage(array('success'=>'Widgets updated successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/widget/manage'));  
        } 
    }
    //End Edit manage widgets   

}
