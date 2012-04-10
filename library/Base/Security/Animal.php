<?php
class Base_Security_Animal 
{
    public function getAnimals($status=1)
    {
        $model=new Security_Model_SystemMaster();
        return $model->fetchAll("status='{$status}' and master_code='fdAnimal'");
    }
        
    public function getAnimalTypesOld($animal_id, $status=1)
    {
        $subSQL=" and a.map_id1='$animal_id'";
        if($animal_id=="All")
        {
                $subSQL="";    
        }
        $model=new Security_Model_SystemMapping();
        $table=$model->getMapper()->getDbTable();
        echo $select = $table->select()->setIntegrityCheck(false)->from(array("a"=>'system_mapping'), array('map_code','animal_id'=>'map_id1','animal_type_id'=>'map_id2'))
                ->join(array("b"=>'system_master'),"a.map_id2=b.master_id and b.master_code='fdAnimalType'" ,array('animal_type_title'=>'master_value', 'master_code'))
                ->where("a.status='{$status}' and a.map_code='fdAnimalAnimalTypeMap'  {$subSQL}");
                //echo $select->__toString(); exit;
                
        return $table->fetchAll($select);
    }
    
    public function getAnimalTypes($animal_id, $status=1)
    {
        $subSQL=" and a.map_id1='$animal_id'";
        if($animal_id=="All")
        {
                $subSQL="";    
        }
        $model=new Security_Model_SystemMapping();
        $table=$model->getMapper()->getDbTable();
        echo $select = $table->select()->setIntegrityCheck(false)->from(array("a"=>'system_mapping'), array('map_code','animal_id'=>'map_id1','animal_type_id'=>'map_id2'))
                ->join(array("b"=>'system_master'),"a.map_id2=b.master_id and b.master_code='fdAnimalType'" ,array('animal_type_title'=>'master_value', 'master_code'))
                ->where("a.status='{$status}' and a.map_code='fdAnimalAnimalTypeAnimalColorMap'  {$subSQL} ")
                ->group("a.map_id2");
                //echo $select->__toString(); exit;
                
        return $table->fetchAll($select);
    }
    
    public function getAnimalColorsOld($animal_type_id,$status=1)
    {
        $subSQL=" and a.map_id1='$animal_type_id'";
        if($animal_type_id=="All")
        {
                $subSQL="";    
        }
        
        $model=new Security_Model_SystemMapping();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("a"=>'system_mapping'), array('map_code','animal_type_id'=>'map_id1','animal_color_id'=>'map_id2'))
                ->join(array("b"=>'system_master'),"a.map_id2=b.master_id and b.master_code='fdAnimalColor'" ,array('animal_color_title'=>'master_value', 'master_code'))
                ->where("a.status='{$status}' and a.map_code='fdAnimalTypeAnimalColorMap' {$subSQL}");
       
       return $table->fetchAll($select);
    }
    
    public function getAnimalColors($animal_id,$animal_type_id,$status=1)
    {
        $subSQL=" and a.map_id1='$animal_id' and a.map_id2='$animal_type_id'";
        if($animal_type_id=="All")
        {
                $subSQL="";    
        }
        
        $model=new Security_Model_SystemMapping();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("a"=>'system_mapping'), array('map_code','animal_type_id'=>'map_id2','animal_color_id'=>'map_id3'))
                ->join(array("b"=>'system_master'),"a.map_id3=b.master_id and b.master_code='fdAnimalColor'" ,array('animal_color_title'=>'master_value', 'master_code'))
                ->where("a.status='{$status}' and a.map_code='fdAnimalAnimalTypeAnimalColorMap' {$subSQL}");
       
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
	
	
    
}