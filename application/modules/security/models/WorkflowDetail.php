<?php
class Security_Model_WorkflowDetail {
    
    protected $_id;
    protected $_workflowId;
    protected $_groupId;
    protected $_subgroupId;
    protected $_roleId;
    protected $_processId;
    protected $_preceedingProcessId;
    protected $_startStatus;
    protected $_endStatus;
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
            $this->setMapper(new Security_Model_WorkflowDetailMapper());
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

    public function setWorkflowId($workflowId)
    {
        $this->_workflowId = (int) $workflowId;
        return $this;
    }  
    public function getWorkflowId()
    {
        return $this->_workflowId;
    }
    public function setGroupId($groupId)
    {
        $this->_groupId = (int) $groupId;
        return $this;
    }  
    public function getGroupId()
    {
        return $this->_groupId;
    }
  
    
    public function setSubgroupId($subgroupId)
    {
        $this->_subgroupId = (int) $subgroupId;
        return $this;
    }  
    public function getSubgroupId()
    {
        return $this->_subgroupId;
    }
    
    public function setRoleId($roleId)
    {
        $this->_roleId = (int) $roleId;
        return $this;
    }  
    public function getRoleId()
    {
        return $this->_roleId;
    }
    
    public function setProcessId($processId)
    {
        $this->_processId = (int) $processId;
        return $this;
    }  
    public function getProcessId()
    {
        return $this->_processId;
    }
    
    
    public function setPreceedingProcessId($preceedingProcessId)
    {
        $this->_preceedingProcessId = (int) $preceedingProcessId;
        return $this;
    }  
    public function getPreceedingProcessId()
    {
        return $this->_preceedingProcessId;
    }
    
    public function setStartStatus($startStatus)
    {
        $this->_startStatus = (int) $startStatus;
        return $this;
    }  
    public function getStartStatus()
    {
        return $this->_startStatus;
    }
    
    public function setEndStatus($endStatus)
    {
        $this->_endStatus = (int) $endStatus;
        return $this;
    }  
    public function getEndStatus()
    {
        return $this->_endStatus;
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
      $model = new Security_Model_WorkflowDetail();
      $model  ->setWorkflowId($row->workflow_id)
              ->setGroupId($row->group_id)
              ->setSubgroupId($row->subgroup_id)
              ->setRoleId($row->role_id)
              ->setProcessId($row->process_id)
              ->setPreceedingProcessId($row->preceeding_process_id)
              ->setStartStatus($row->start_status)
              ->setEndStatus($row->end_status)
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
            'workflow_id'       => $this->getWorkflowId(),           
            'group_id'       => $this->getGroupId(),
            'subgroup_id'       => $this->getSubgroupId(),
            'role_id'       => $this->getRoleId(),
            'process_id'       => $this->getProcessId(),
            'preceeding_process_id'       => $this->getPreceedingProcessId(),
            'start_status'       => $this->getStartStatus(),
            'end_status'       => $this->getEndStatus(),
            'is_deleted'       => $this->getIsDeleted(),
            );
		
        if (null === ($id = $this->getId())) 
        {
            $Db=new Base_Db();
            $id=$Db->genId("workflow_detail", "id");
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
    
    
   
    
   
    /*----Data Manupulation functions ----*/

    
  
}
