<?php
class Security_ActionController extends Base_Controller_Action
{

    public function createAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $parent_node_id=$this->_getParam('parent_node_id');
        $child_master_value=$this->_getParam('node_title');
        $arrNode=explode("_",$parent_node_id);
        $parent_master_code=$arrNode[0];
        $parent_master_id=$arrNode[1];
        $model=new Security_Model_SystemMaster();
        
        if($parent_master_code=="noderoot")
        {
            // create group
            $child_master_code="fdAction";
            
            
        }
        $model->setMasterCode($child_master_code);
        $model->setMasterValue($child_master_value);
        $node_id=$model->save();
   
        if($node_id)
            $result=Zend_Json::encode(array("status"=>true, "node_id"=>$child_master_code."_".$node_id));
        else
            $result=Zend_Json::encode(array("status"=>false));
        
        echo $result;
    }
    
    
    
    public function renameAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $node_id=$this->_getParam('node_id');
        $master_value=$this->_getParam('node_title');
        $arrNode=explode("_",$node_id);
        $master_code=$arrNode[0];
        $master_id=$arrNode[1];
        $model=new Security_Model_SystemMaster();
        $master=$model->fetchRow("master_code='{$master_code}' and master_id='{$master_id}'");
        $master->setMasterValue($master_value);
        if($master->save())
            $result=Zend_Json::encode(array("status"=>true));
        else
            $result=Zend_Json::encode(array("status"=>false));
        echo $result;        
    }
    
    
    public function removeAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $child_node_id=$this->_getParam('child_node_id');
        $arrChildNode=explode("_",$child_node_id);
        $child_master_code=$arrChildNode[0];
        $child_master_id=$arrChildNode[1];
        
        //$parent_node_id=$this->_getParam('parent_node_id');
        //$arrParentNode=explode("_",$parent_node_id);
        //$parent_master_code=$arrParentNode[0];
        //$parent_master_id=$arrParentNode[1];
        
        if($child_master_code=="fdAction")
        {
            $objMap=new Security_Model_SystemMapping();
            $objMap->delete("map_code='fdActionGroupMap' and  map_id1='{$child_master_id}'");
            $objMap->delete("map_code='fdActionSubGroupMap' and map_id1='{$child_master_id}'");
            $objMap->delete("map_code='fdActionRoleMap' and map_id1='{$child_master_id}'");
            $objMap->delete("map_code='fdActionUserMap' and map_id1='{$child_master_id}'");
            
            
            $objMaster=new Security_Model_SystemMaster();
            $objMaster->delete("master_code='{$child_master_code}' and master_id='{$child_master_id}'");
        }
       
        echo $result=Zend_Json::encode(array("status"=>true));
        
    }
    
    public function manageAction()
    {
        $Privilege=new Base_Security_Privilege();
        $this->view->groups=$Privilege->getGroupArray();
        $this->view->subGroups=$Privilege->getSubGroupArray("All");
        $this->view->roles=$Privilege->getRoleArray("All");
        
        $User=new Security_Model_User();
        $this->view->users=$User->getAllUsers();
        
        
        $Menu=new Base_Security_Action();
        $this->view->actionTree=$Menu->getFullActionTree();
        
    }
    
    public function savePermissionAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
       
        
        $params=$this->_getAllParams();
        $rdo=$params['rdo']; //groupId, subGroupId, roleId, userId
        $mapId2=$params[$rdo]; 
        $arrMapId1=array();
        $mapCode="";
        $arrResult=array("status"=>0);
        if($rdo=="groupId")
        {
            $mapCode="fdActionGroupMap";
        }
        else if($rdo=="subGroupId")
        {
            $mapCode="fdActionSubGroupMap";
        }
        else if($rdo=="roleId")
        {
            $mapCode="fdActionRoleMap";
        }
        else if($rdo=="userId")
        {
            $mapCode="fdActionUserMap";
        }
        
        foreach($params as $k=>$v)
        {
            if(stristr($k, "check_")!==false)
            {
                $arr=explode("_", $k);
                if($arr[1]!=="noderoot")
                $arrMapId1[]=$arr[2];

            }
        }
        
        if(count($arrMapId1)>0)
        {
            $model=new Security_Model_SystemMapping();
            $model->delete("map_code='{$mapCode}' and map_id2='{$mapId2}'");
            foreach($arrMapId1 as $mapId1)
            {
                $model->setMapCode($mapCode)
                    ->setMapId1($mapId1)
                    ->setMapId2($mapId2)
                    ->save();
                
            }
            
            $arrResult=array("status"=>1);
        }
        else
        {
            $arrResult=array("status"=>0);
        }
        echo Zend_Json::encode($arrResult);
        
        
    }
    
    
    
    public function getPermissionAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
       
        
        $params=$this->_getAllParams();
        $rdo=$params['rdo']; //groupId, subGroupId, roleId, userId
        $mapId2=$params[$rdo]; 
        $arrMapId1=array();
        $mapCode="";
        $arrResult=array("status"=>0);
        if($rdo=="groupId")
        {
            $mapCode="fdActionGroupMap";
        }
        else if($rdo=="subGroupId")
        {
            $mapCode="fdActionSubGroupMap";
        }
        else if($rdo=="roleId")
        {
            $mapCode="fdActionRoleMap";
        }
        else if($rdo=="userId")
        {
            $mapCode="fdActionUserMap";
        }
        
        $model=new Security_Model_SystemMapping();
        $res=$model->fetchAll("map_code='{$mapCode}' and map_id2='{$mapId2}'");
        if(count($res)>0)
        {
            foreach($res as $row)
            {
                $arrMapId1[]=$row->getMapId1();
            }
            $arrResult=array("status"=>1, "mapId1"=>$arrMapId1);    
        }
        
        echo Zend_Json::encode($arrResult);
        
    }
    
}
