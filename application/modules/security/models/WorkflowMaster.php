<?php
class Security_Model_WorkflowMaster {
    
    protected $_id;
    protected $_workflowName;
    protected $_createdOn;
    protected $_createdBy;
    protected $_updatedOn;
    protected $_updatedBy;
    protected $_rowGuid;
    protected $_mapper;
    protected $_rowVersion;
    protected $_rowMaxId;
    protected $_isDeleted=0;

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
            $this->setMapper(new Security_Model_WorkflowMasterMapper());
        }
        return $this->_mapper;
    }

    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setWorkflowName($workflowName)
    {
        $this->_workflowName = (string) $workflowName;
        return $this;
    }  
    public function getWorkflowName()
    {
        return $this->_workflowName;
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

    public function getRowMaxId()
    {
        return $this->_rowMaxId;
    }

    public function setRowMaxId($rowMaxId)
    {
        $this->_rowMaxId= (int) $rowMaxId;
        return $this;
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

    public function getIsDeleted()
    {
        return $this->_isDeleted;
    }

    public function setIsDeleted($isDeleted)
    {
        $this->_isDeleted= (int) $isDeleted;
        return $this;
    }
  /*----Data Manupulation functions ----*/
    
    public function setModel($row)
    {
      $model = new Security_Model_WorkflowMaster();
      $model->setId($row->id)
             ->setWorkflowName($row->workflow_name)
              ->setCreatedOn($row->created_on)
              ->setCreatedBy($row->created_by)
              ->setUpdatedOn($row->updated_on)
              ->setUpdatedBy($row->updated_by)
              ->setRowGuid($row->row_guid)
              ->setRowVersion($row->row_version)
              ->setIsDeleted($row->is_deleted)
              ;
             return $model;
    }
    
    public function save()
    {
        $usersNs = new Zend_Session_Namespace("members");  
        
     	$data = array(
            'workflow_name'       => $this->getWorkflowName(),           
            'is_deleted'       => $this->getIsDeleted(),
            );
		
        if (null === ($id = $this->getId())) 
        {
            $Db=new Base_Db();
            $id=$Db->genId("workflow_master", "id");
            if(false!==$id)
            {
                $data['id']=$id;
                $data['created_by']=$usersNs->userId;
                $data['row_guid']=Base_Uuid::guid();
                $data['created_on']=time();
                $data['row_version']=0;
                if($this->getMapper()->getDbTable()->insert($data))
                {
                   return $id; 
                }
            }
            else
            {
                return false;
            }
        } 
        else 
        {
           
            $data['updated_by']=$usersNs->userId;
            $data['updated_on']=time();
            $data['row_version']=$this->getRowVersion();
            
            $res=$this->getMapper()->getDbTable()->update($data, array("id='{$id}' and row_version = '{$this->getRowVersion()}'" ));
            
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
    
    public function getWorkflowArray()
    {
        $arr=array(""=>"--Select--");
        $res=$this->fetchAll("id<>'-2147483648' and is_deleted<>'1'");
        if(count($res)>0)
        {
            foreach($res as $_row)
            {
                $arr[$_row->getId()]=$_row->getWorkflowName();
            }
        }
        return $arr;
    }
   
    
   
    /*----Data Manupulation functions ----*/

    
  
}
