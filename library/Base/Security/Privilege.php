<?php
class Base_Security_Privilege 
{
    public function getGroups($status=1)
    {
        $model=new Security_Model_SystemMaster();
        return $model->fetchAll("status='{$status}' and master_code='fdUserGroup'");
    }
        
    public function getSubGroups($group_id, $status=1)
    {
        $subSQL=" and a.map_id1='$group_id'";
        if($group_id=="All")
        {
                $subSQL="";    
        }
        $model=new Security_Model_SystemMapping();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("a"=>'system_mapping'), array('map_code','group_id'=>'map_id1','sub_group_id'=>'map_id2'))
                ->join(array("b"=>'system_master'),"a.map_id2=b.master_id and b.master_code='fdUserSubGroup'" ,array('subgroup_title'=>'master_value', 'master_code'))
                ->where("a.status='{$status}' and a.map_code='fdGroupSubGroupMap'  {$subSQL}");
                //echo $select->__toString(); exit;
                
        return $table->fetchAll($select);
    }
    
    public function getRoles($sub_group_id,$status=1)
    {
        $subSQL=" and a.map_id1='$sub_group_id'";
        if($sub_group_id=="All")
        {
                $subSQL="";    
        }
        
        $model=new Security_Model_SystemMapping();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("a"=>'system_mapping'), array('map_code','sub_group_id'=>'map_id1','role_id'=>'map_id2'))
                ->join(array("b"=>'system_master'),"a.map_id2=b.master_id and b.master_code='fdUserRole'" ,array('role_title'=>'master_value', 'master_code'))
                ->where("a.status='{$status}' and a.map_code='fdSubGroupRoleMap' {$subSQL}");
       
       return $table->fetchAll($select);
    }
    
    public function getGroupArray($status=1)
    {
        $arr=array(""=>"--Select--");
        $groups=$this->getGroups($status);
        foreach($groups as $_group)
        {
            $arr[$_group->getMasterId()]=$_group->getMasterValue();
        }
        return $arr;
    }
    
    public function getSubGroupArray($group_id="All", $status=1)
    {
        $arr=array(""=>"--Select--");
        $subGroups=$this->getSubGroups($group_id, $status);
        
        foreach($subGroups as $_subGroup)
        {
            $arr[$_subGroup->sub_group_id]=$_subGroup->subgroup_title;
        }
        return $arr;
    }
    
    public function getRoleArray($sub_group_id="All",$status=1)
    {
        $arr=array(""=>"--Select--");
        $roles=$this->getRoles($sub_group_id, $status);
        
        foreach($roles as $_role )
        {
            $arr[$_role->role_id]=$_role->role_title;
        }
        return $arr;
    }
    
    public function getMasterValues($code)
    {
        

        $model=new Security_Model_SystemMaster();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("s"=>'system_master'))
        ->order("master_value")->where("status='1' and master_code='$code'");
        $sql=$select->__toString($select);
       
        $rows=$model->fetchAll($select);
         $arr['']="Select";
        foreach($rows as $row)
        {
            $arr[$row->getMasterId()]=$row->getMasterValue();
        }
        return $arr;
    }
    
    public function getMasterValuesArr($code)
    {
        $model=new Security_Model_SystemMaster();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("s"=>'system_master'))
        ->order("master_value")->where("status='1' and master_code='$code'");
        $sql=$select->__toString($select);
       
        $rows=$model->fetchAll($select);
        foreach($rows as $row)
        {
            $arr[$row->getMasterId()]=$row->getMasterValue();
        }
        return $arr;
    }
    
     public function getCondumnValues($code)
     {
     return $this->getMasterValuesArr($code);
     }
    
    /* unsused
    public function getInputsValues($code)
    {
        $model=new Security_Model_SystemMaster();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("s"=>'system_master'))
        ->order("master_value")->where("status='1' and master_code='$code'");
        $sql=$select->__toString($select);
        $rows=$model->fetchAll($select);
        foreach($rows as $row)
        {
            $arr[$row->getMasterId()]=$row->getMasterValue();
        }
        return $arr;
    }
    */
	
    public function getSupplier($id=null)
    {
        if ($id)
            $where="id='$id'";
        else
            $where="id!='-2147483648'";
        
        $model=new Admin_Model_Supplier();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("s"=>'supplier'))
        ->order("first_name")->where($where);
        $sql=$select->__toString($select);
       
        $rows=$model->fetchAll($select);
        //print_r($rows);
        $arr['']="Select";
        foreach($rows as $row)
        {
            $arr[$row->getId()]=$row->getFirstName().' '.$row->getLastName();
        }
        return $arr;
    }
    	
    
}