<?php
class Admin_BookmarkController extends Base_Controller_Action{
    
    //start manage Bookmarks
    public function indexAction()
    {
            $code="fdUserBookmark";
            $usersNs = new Zend_Session_Namespace("members");
            $mapId1=$usersNs->userId;
            
            
           $model=new Security_Model_SystemMapping();
           /*---sorting ----*/
            $order = trim($this->_getParam('order', ""));
            $col = trim($this->_getParam('col',""));

            if($order<>"" && $col<>"")
            {
                if($col=="master_value")
                    $strOrderBy="sm.master_value {$order}";
                else if($col=="map_id3")
                    $strOrderBy="s.map_id3 {$order}";
            }
            else
            {
                $strOrderBy="s.map_id3";
            }
            $this->view->sortOptions=array();
            /*-----sorting----------*/

            $where="s.map_id1='$mapId1' and s.map_code='$code'";
            $this->view->linkArray=array();
            $this->view->search="";
            
          

            $page_size= Zend_Registry::get('page_size');
            $page = $this->_getParam('page',1);
            
            $table=$model->getMapper()->getDbTable();
            
            $select = $table->select()->setIntegrityCheck(false)->from(array("sm"=>'system_master'), array("master_value"))
                ->join(array("s"=>"system_mapping"),"s.map_code='fdUserBookmark' and s.map_id1='$mapId1'  and sm.master_code='fdMenu' and sm.master_id=s.map_id2", array("map_id1"=>'map_id1',"map_id2"=>'map_id2',"map_id3"=>'map_id3') )
               ->group("s.map_id2")
                ->order($strOrderBy);
            $paginator =  Base_Paginator::factory($select);

            $paginator->setItemCountPerPage($page_size);
            $paginator->setCurrentPageNumber($page);

            $this->view->totalItems= $paginator->getTotalItemCount();
            $this->view->paginator=$paginator;

    }
    //End manage widgets   
    
    
    //Start Edit Bookmark  
    public function editBookmarkAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $request = $this->getRequest();
         $usersNs = new Zend_Session_Namespace("members");
         
        $mapCode="fdUserBookmark";
        $mapId1=$usersNs->userId;
        if ($request->isPost())
        { 
           $model1=new Security_Model_SystemMapping();
           $rows = $model1->fetchAll("map_code='$mapCode' and map_id1='$mapId1'");
           $model1->delete("map_code='$mapCode' and map_id1='$mapId1'");
           // $model2=new Security_Model_SystemMapping();
           // $model2->delete("map_code='{$mapCode}' and map_id1='{$mapId1}'");
            foreach($rows as $_row)
            {
                $mapID2=$_row->getMapId2();
                if (!empty($mapID2))
                {
                $ordC="order".$mapID2;
                $orderval=$_POST[$ordC];
                if (empty($orderval))
                $orderval=1;
                else 
                $orderval=(int)$orderval;
                
                $model1->setMapId1($mapId1);    //user id
                $model1->setMapId2($mapID2);    //master id
                $model1->setMapId3($orderval);  //order value
                $model1->setMapCode($mapCode); //map code
                
                $model1->save();
                //echo $_row->getMapId2()."----".$orderval;
                //echo "<br>";
                
                }
               
            }
            
                
                    $this->_flashMessenger->addMessage(array('success'=>'Bookmark order updated successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/bookmark/index'));  
        } 
    }
    //End Edit bookmark
    
     //Start delete bookmark
    public function deleteBookmarkAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $request = $this->getRequest();
        $usersNs = new Zend_Session_Namespace("members");
        $id = trim($this->_getParam('bookID'));
          
        $mapCode="fdUserBookmark";
        $mapId1=$usersNs->userId;
        if ($id)
        { 
           $model1=new Security_Model_SystemMapping();
           $model = $model1->delete("map_code='$mapCode' and map_id1='$mapId1' and map_id2='$id'");
           $this->_flashMessenger->addMessage(array('success'=>'Bookmark deleted successfully!'));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/bookmark/index'));  
        } 
    }
    //End delete bookmark

}
