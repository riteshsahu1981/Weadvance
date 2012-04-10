<?php
class Security_Model_SystemMapping {
    
    protected $_id;
    protected $_mapCode;
    protected $_mapId1;
    protected $_mapId2;
    protected $_mapId3;
    protected $_status=1;
    protected $_intval1=0;
    protected $_intval2=0;
    protected $_strval1='';
    protected $_strval2='';
    protected $_blnval1=0;    
    protected $_blnval2=0;
    protected $_dblval1=0.00;
    protected $_dblval2=0.00;
    protected $_createdOn;
    protected $_createdBy;
    protected $_updatedOn;
    protected $_updatedBy;
    protected $_rowGuid;
    protected $_mapper;
    
    

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified '. $method);
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified ' . $method);
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Security_Model_SystemMappingMapper());
        }
        return $this->_mapper;
    }

   

    public function setMapCode($mapCode)
    {
        $this->_mapCode = (string) $mapCode;
        return $this;
    }

    public function getMapCode()
    {
        return $this->_mapCode;
    }
    
    public function setMapId1($mapId1)
    {
        $this->_mapId1 = (int) $mapId1;
        return $this;
    }

    public function getMapId1()
    {
        return $this->_mapId1;
    }

    public function setMapId2($mapId2)
    {
        $this->_mapId2 = (int) $mapId2;
        return $this;
    }

    public function getMapId2()
    {
        return $this->_mapId2;
    }
    
    public function setMapId3($mapId3)
    {
        $this->_mapId3 = (int) $mapId3;
        return $this;
    }

    public function getMapId3()
    {
        return $this->_mapId3;
    }
    
       

    public function getStatus()
    {
        return $this->_status;
    }
 
    public function setStatus($status)
    {
        $this->_status = (string) $status;
        return $this;
    }
    
    public function setIntval1($intval1)
    {
        $this->_intval1 = (int) $intval1;
        return $this;
    }

    public function getIntval1()
    {
        return $this->_intval1;
    } 
    
    public function setIntval2($intval2)
    {
        $this->_intval2 = (int) $intval2;
        return $this;
    }

    public function getIntval2()
    {
        return $this->_intval2;
    } 
    
    public function setStrval1($strval1)
    {
        $this->_strval1 = (string) $strval1;
        return $this;
    }

    public function getStrval1()
    {
        return $this->_strval1;
    } 
    
    public function setStrval2($strval2)
    {
        $this->_strval2 = (string) $strval2;
        return $this;
    }

    public function getStrval2()
    {
        return $this->_strval2;
    } 

        

    public function setBlnval1($blnval1)
    {
        $this->_blnval1 = (boolean) $blnval1;
        return $this;
    }

    public function getBlnval1()
    {
        return $this->_blnval1;
    }
    
    public function setBlnval2($blnval2)
    {
        $this->_blnval2 = (boolean) $blnval2;
        return $this;
    }

    public function getBlnval2()
    {
        return $this->_blnval2;
    }
    
    public function setDblval1($dblval1)
    {
        $this->_dblval1 = (double) $dblval1;
        return $this;
    }

    public function getDblval1()
    {
        return $this->_dblval1;
    }
    
    public function setDblval2($dblval2)
    {
        $this->_dblval2 = (double) $dblval2;
        return $this;
    }

    public function getDblval2()
    {
        return $this->_dblval2;
    }
    
    public function setCreatedOn($createdOn)
    {
        $this->_createdOn = (int) $createdOn;
        return $this;
    }  
    public function getCreatedOn()
    {
        return $this->_createdOn;
    }
    
    public function setCreatedBy($createdBy)
    {
        $this->_createdBy = (int) $createdBy;
        return $this;
    }  
    public function getCreatedBy()
    {
        return $this->_createdBy;
    }

    public function setUpdatedOn($updatedOn)
    {
        $this->_updatedOn = (int) $updatedOn;
        return $this;
    }
    
    public function getUpdatedOn()
    {
        return $this->_updatedOn;
    }
    
    public function setUpdatedBy($updatedBy)
    {
        $this->_updatedBy = (int) $updatedBy;
        return $this;
    }
    
    public function getUpdatedBy()
    {
        return $this->_updatedBy;
    }

    public function setRowGuid($rowGuid)
    {
        $this->_rowGuid = (string) $rowGuid;
        return $this;
    }
    
    public function getRowGuid()
    {
        return $this->_rowGuid;
    }

   
    public function updateanimal_color($map_code,$map_id3,$map_id2,$map_id1){
        $data = array(
                'map_id3'    => '',
                'updated_by' => $usersNs->userId,
                'updated_on' => time()
                );
        
         $res=$this->getMapper()->getDbTable()->update($data, array("map_code='$map_code' and map_id1= '$map_id1' and map_id2= '$map_id2' and map_id3= '$map_id3'" ));
         
         
         if(1==$res)
            return true;
        else
            return false;  
    }
    
    public function deleteanimal_type($map_code,$map_id2,$map_id1){
        $data = array(
                'map_id3'    => '',
                'updated_by' => $usersNs->userId,
                'updated_on' => time()
                );
        
         $res=$this->getMapper()->getDbTable()->update($data, array("map_code='$map_code' and map_id1= '$map_id1' and map_id2= '$map_id2' and map_id3= '$map_id3'" ));
         
         
         if(1==$res)
            return true;
        else
            return false;  
    }
    
    public function UpdateMapId3_MapId2($map_code,$parent_master_id,$child_master_id,$node_id){
       
        
       $already_exists_check = $this->fetchRow("map_code='$map_code' AND map_id1= '$parent_master_id' AND map_id2= '$child_master_id' AND map_id2 != ''" );
       //if()
       $data = array(
                'map_id3'    => $node_id,
                'updated_by' => $usersNs->userId,
                'updated_on' => time()
                );
       
      $res=$this->getMapper()->getDbTable()->update($data, array("map_code='$map_code' and map_id1= '$parent_master_id' and map_id2= '$child_master_id'" ));
      if(1==$res)
        return true;
      else
        return false;      
        
    }
  /*----Data Manupulation functions ----*/
    
    public function setModel($row)
    {
      $model = new Security_Model_SystemMapping();
      $model  ->setMapCode($row->map_code)
              ->setMapId1($row->map_id1)
              ->setMapId2($row->map_id2)
              ->setMapId3($row->map_id3)
              ->setStatus($row->status)
              ->setIntval1($row->intval1)
              ->setIntval2($row->intval2)
              ->setStrval1($row->strval1)
              ->setStrval2($row->strval2)
              ->setBlnval1($row->blnval1)
              ->setBlnval2($row->blnval2)
              ->setDblval1($row->dblval1)
              ->setDblval2($row->dblval2)
              ->setCreatedOn($row->created_on)
              ->setCreatedBy($row->created_by)
              ->setUpdatedOn($row->updated_on)
              ->setUpdatedBy($row->updated_by)
              ->setRowGuid($row->row_guid)
              
              
              ;
             return $model;
    }
    
    public function save()
    {
        $usersNs = new Zend_Session_Namespace("members");  
        
     	$data = array(
                'map_code'  		=> $this->getMapCode(),
                'map_id1' 		=> $this->getMapId1(),
                'map_id2' 		=> $this->getMapId2(),
                'map_id3' 		=> $this->getMapId3(),
        	'status'		=> $this->getStatus(),
                'intval1'               => $this->getIntval1(),
                'intval2'               => $this->getIntval2(),
                'strval1'               => $this->getStrval1(),
                'strval2'               => $this->getStrval2(),
                'blnval1'               => $this->getBlnval1(),
                'blnval2'               => $this->getBlnval2(),
                'dblval1'               => $this->getDblval1(),
                'dblval2'               => $this->getDblval2()                
                );

        if (null === $this->getCreatedOn()) 
        {
            $data['created_by']=$usersNs->userId;
            $data['row_guid']=Base_Uuid::guid();
            $data['created_on']=time();
            
            if($this->getMapper()->getDbTable()->insert($data))
            {
                return true; 
            }
        } 
        else 
        {
            $data['updated_by']=$usersNs->userId;
            $data['updated_on']=time();
            
            $res=$this->getMapper()->getDbTable()->update($data, array("map_code='{$this->getMapCode()}' and map_id1= '{$this->getMapId1()}' and map_id2= '{$this->getMapId2()}' and map_id3 IS NULL" ));
            if(1==$res)
                return true;
            else
                return false;
        }
    }

    public function find($id)
    {
        $result = $this->getMapper()->getDbTable()->find($id);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $res=$this->setModel($row);        
        return $res;
    }
	
    public function fetchAll($where = null, $order = null, $count = null, $offset = null)
    {
        $resultSet = $this->getMapper()->getDbTable()->fetchAll($where, $order , $count , $offset);
        $entries   = array();
        foreach ($resultSet as $row) 
        {
            $res=$this->setModel($row);
            $entries[] = $res;
        }
        return $entries;
    }
    
    public function fetchRow($where)
    { 
    	$row = $this->getMapper()->getDbTable()->fetchRow($where);

       	if(!empty($row))
       	{
            $res=$this->setModel($row);
            return $res;
       	}
       	else 
       	{
            return false;
       	}
    }   
    
    public function delete($where)
    {
    	return $this->getMapper()->getDbTable()->delete($where);
    }
    
    public function isExist($where)
    {
    	$res=$this->fetchRow($where);

    	if($res===false)
       	{
            return false;
       	}
       	else 
       	{
            return true;
       	}
    }
    
    public function getCount($where) 
    {
        $table= $this->getMapper()->getDbTable();
        $result = $table->fetchAll($where);
        $count = $result->count();
        return $count;
        
        //return count($this->fetchAll($select));        
    }
    
    
    
    
    public function getAnimalTypeArray($animal_id)
    {
         
        $dbTable=Zend_Registry::get('db');
        $select = $dbTable->select()
        ->from(array("a"=>'system_mapping'), array('map_id1'=>'map_id1','map_id2'=>'map_id2'))
        ->join(array("b"=>'system_master'),"a.map_id2=b.master_id and b.master_code='fdAnimalType'" ,array('breed'=>'master_value', 'master_code'))
        ->where("map_code='fdAnimalAnimalTypeAnimalColorMap' AND map_id1= '$animal_id' ")
        ->group("map_id2");
        
        $subGroups = $dbTable->fetchAll($select);
        
        
        return $subGroups;
    }
    public function getAnimalColorArray($animal_id,$breed_id)
    {
         
        $dbTable=Zend_Registry::get('db');
                
         $select = $dbTable->select()
        ->from(array("a"=>'system_mapping'), array('map_id1'=>'map_id1','map_id2'=>'map_id2','map_id3'=>'map_id3'))
        ->join(array("b"=>'system_master'),"a.map_id3=b.master_id and b.master_code='fdAnimalColor'" ,array('color'=>'master_value', 'master_code'))
        ->where("map_code='fdAnimalAnimalTypeAnimalColorMap' AND map_id1= '$animal_id' AND map_id2= '$breed_id' ")
        ->group("map_id3");
       
        
        $subGroups = $dbTable->fetchAll($select);
        
        // print_r ($subGroups);
        
        /* foreach($subGroups as $_subGroup_key => $_subGroup_value)
        {
            //print_r ($_subGroup);
            //$arr[$_subGroup->sub_group_id]=$_subGroup->subgroup_title;
            $arr[$_subGroup_key] = $_subGroup_value;
        } */
        
        return $subGroups;
    }
    
    /*----Data Manupulation functions ----*/

    
  
}
//hhh