<?php

class Security_Model_SysConfig {
    
    protected $_configId;
    protected $_parentConfigId;
    protected $_configName;
    protected $_configDesc;
    protected $_param1;
    protected $_param2;
    protected $_param3;
    protected $_param4;
    protected $_param5;
    protected $_createdOn;
    protected $_updatedOn;
    protected $_mapper;
    protected $_createdBy;
    protected $_updatedBy;
    protected $_rowGuid;
    protected $_rowVersion;
    protected $_rowMaxId;
    
    
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
            throw new Exception('Invalid property specified');
        }
        $this->$method($value);
    }
    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
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
            $this->setMapper(new Security_Model_SysConfigMapper());
        }
        return $this->_mapper;
    }
    public function setConfigId($configId)
    {
    $this->_configId = (int) $configId;
        return $this;
    }
    public function getConfigId()
    {
        return $this->_configId;
    }
    public function setParentConfigId($parentConfigId)
    {
        $this->_parentConfigId= (int) $parentConfigId;
        return $this;
    }
    public function getParentConfigId()
    {
        return $this->_parentConfigId;
    }
    public function getConfigName()
    {
        return $this->_configName;
    }
    public function setConfigName($configName)
    {
        $this->_configName = (string) $configName;
        return $this;
    }   
    public function getConfigDesc()
    {
        return $this->_configDesc;
    }
    public function setConfigDesc($configDesc)
    {
        $this->_configDesc = (string) $configDesc;
        return $this;
    }
    
    public function getParam1()
    {
        return $this->_param1;
    }
    public function setParam1($param1)
    {
        $this->_param1 = (string) $param1;
        return $this;
    }
    
    public function getParam2()
    {
        return $this->_param2;
    }
    public function setParam2($param2)
    {
        $this->_param2 = (string) $param2;
        return $this;
    }
   
     public function getParam3()
    {
        return $this->_param3;
    }
    public function setParam3($param3)
    {
        $this->_param3 = (string) $param3;
        return $this;
    }
   
     public function getParam4()
    {
        return $this->_param4;
    }
    public function setParam4($param4)
    {
        $this->_param4 = (string) $param4;
        return $this;
    }
   
    public function getParam5()
    {
        return $this->_param5;
    }
    public function setParam5($param5)
    {
        $this->_param5 = (string) $param5;
        return $this;
    }
    
    public function getCreatedOn()
    {
        return $this->_createdOn;
    }
    public function setCreatedOn($createdOn)
    {
        $this->_createdOn = (int) $createdOn;
        return $this;
    }
    public function getUpdatedOn()
    {
        return $this->_updatedOn;
    }
    public function setUpdatedOn($updatedOn)
    {
        $this->_updatedOn= (int) $updatedOn;
        return $this;
    }
    public function getCreatedBy()
    {
        return $this->_createdBy;
    }

    public function setCreatedBy($createdby)
    {
        $this->_createdBy = (int) $createdby;
        return $this;
    }  
    
    public function getupdatedBy()
    {
        return $this->_updatedBy;
    }

    public function setUpdatedBy($updatedby)
    {
        $this->_updatedBy = (int) $updatedby;
        return $this;
    }
    public function setRowGuid($rowguid)
    {
        $this->_rowGuid = (int) $rowguid;
        return $this;
    }

    public function getRowGuid()
    {
        return $this->_rowGuid;
    }
    public function getRowVersion()
    {
        return $this->_rowVersion;
    }

    public function setRowVersion($rowVersion)
    {
        $this->_rowVersion= (int) $rowVersion;
        return $this;
    }
    
    public function getRowMaxId()
    {
        return $this->_rowMaxId;
    }

    public function setRowMaxId($rowMaxId)
    {
        $this->_rowMaxId= (int) $rowMaxId;
        return $this;
    }
    
	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
 		$model = new Security_Model_SysConfig();
                $model->setConfigId($row->config_id)
                  ->setParentConfigId($row->parent_config_id)
                  ->setConfigName($row->config_name)
                  ->setConfigDesc($row->config_desc)
                  ->setParam1($row->param1)
                  ->setParam2($row->param2)
                  ->setParam3($row->param3)
                  ->setParam4($row->param4)
                  ->setParam5($row->param5)
                  ->setRowGuid($row->row_guid)
                  ->setCreatedBy($row->created_by)
                  ->setUpdatedBy($row->updated_by)
                ->setRowVersion($row->row_version)
                ->setRowMaxId($row->row_max_id)
                  ;
    	//print_r($model);
             return $model;
    }
    
    public function save()
    {
        $usersNs = new Zend_Session_Namespace("members");  $usersNs-userId;
         
    	$data = array(
                'parent_config_id'   => $this->getParentConfigId(),
        	'config_name'   => $this->getConfigName(),
        	'config_desc'   => $this->getConfigDesc(),
                'param1'   => $this->getParam1(),
                'param2'   => $this->getParam2(),
                'param3'   => $this->getParam3(),
                'param4'   => $this->getParam4(),
                'param5'   => $this->getParam5(),
             );

        if (null === ($id = $this->getConfigId())) {
            
            $Db=new Base_Db();
            $id=$Db->genId("sys_config", 'config_id');
            if($id!==false)
            {
                $data['config_id']=$id;
                $data['created_on']=time();
                $data['created_by']=$usersNs-userId;
                $data['row_guid']=Base_Uuid::guid();
                $data['row_version']=0;
                if($this->getParentConfigId()==0)
                {
                    $data['parent_config_id']=$id;
                }
                
                if($this->getMapper()->getDbTable()->insert($data))
                {
                    return $id; 
                }
                
            }
            
        } 
        else 
        {
                   
            $data['updated_by']=$usersNs-userId;
            $data['updated_on']=time();
            $data['row_version']=$this->getRowVersion() + 1;
            return $this->getMapper()->getDbTable()->update($data, array('config_id = ?' => $id));
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
    /*----Data Manupulation functions ----*/    

    /*------Data utility functions------*/
    public function getConfigs(){
          $obj=new Security_Model_SysConfig();
         $entries=$obj->fetchAll("config_id<>'-2147483648'");
         $arr=array("0"=>"--Select--");
        
         foreach($entries as $entry)
         { 	
         	$arr[$entry->getConfigId()]=ucfirst($entry->getConfigName());
         }
         
         return $arr;
    }
    
    
    
    
    public function deleteConfig($parent_id)
    {
        $model=new Security_Model_SysConfig();
        $result=$model->fetchAll("parent_config_id='$parent_id'");
        $model->delete("config_id='{$parent_id}'");
        
        if(count($result)>0)
        {
            foreach($result as $row)
            {
                //check child tree
                $modelC=new Security_Model_SysConfig();
                $resultC=$modelC->fetchAll("parent_config_id='{$row->getConfigId()}'");        
                $modelC->delete("config_id='{$row->getConfigId()}'");
                if(count($resultC)>0)
                {
                    $this->deleteConfig($row->getConfigId());
                }
            }
        
        }
        
        return true;
    }
    /*------Data utility functions------*/
    
}

?>