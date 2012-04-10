<?php

class Security_Model_SysMessage {
    
    protected $_messageId;
    protected $_categoryId;
    protected $_severityId;
    protected $_typeId;
    protected $_userMessage;
    protected $_sysMessage;
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
            $this->setMapper(new Security_Model_SysMessageMapper());
        }
        return $this->_mapper;
    }
    public function setMessageId($messageId)
    {
    $this->_messageId = (int) $messageId;
        return $this;
    }
    public function getMessageId()
    {
        return $this->_messageId;
    }
    public function setCategoryId($categoryId)
    {
        $this->_categoryId= (int) $categoryId;
        return $this;
    }
    public function getCategoryId()
    {
        return $this->_categoryId;
    }
    public function getSeverityId()
    {
        return $this->_severityId;
    }
    public function setSeverityId($severityId)
    {
        $this->_severityId = (int) $severityId;
        return $this;
    }   
    public function getTypeId()
    {
        return $this->_typeId;
    }
    public function setTypeId($typeId)
    {
        $this->_typeId = (int) $typeId;
        return $this;
    }
    
    public function getUserMessage()
    {
        return $this->_userMessage;
    }
    public function setUserMessage($userMessage)
    {
        $this->_userMessage = (string) $userMessage;
        return $this;
    }
    
    public function getSysMessage()
    {
        return $this->_sysMessage;
    }
    public function setSysMessage($sysMessage)
    {
        $this->_sysMessage = (string) $sysMessage;
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
        $model = new Security_Model_SysMessage();
        $model->setMessageId($row->message_id)
            ->setCategoryId($row->category_id)
            ->setSeverityId($row->severity_id)
            ->setTypeId($row->type_id)
            ->setUserMessage($row->user_message)
            ->setSysMessage($row->sys_message)
            ->setRowGuid($row->row_guid)
            ->setCreatedBy($row->created_by)
            ->setUpdatedBy($row->updated_by)
            ->setRowVersion($row->row_version)
            ->setRowMaxId($row->row_max_id)
            ;
        return $model;
    }
    
    public function save()
    {
        $usersNs = new Zend_Session_Namespace("members");  $usersNs-userId;
         
    	$data = array(
                'category_id'   => $this->getCategoryId(),
        	'severity_id'   => $this->getSeverityId(),
                'type_id'   => $this->getTypeId(),
                'user_message'   => $this->getUserMessage(),
                 'sys_message'   => $this->getSysMessage(),
             );

        
            
        if (null === ($id = $this->getMessageId())) 
        {
            $Db=new Base_Db();
            $id=$Db->genId("sys_message", 'message_id');
            if($id!==false)
            {
                $data['message_id']=$id;
                $data['created_on']=time(); 
                $data['created_by']=$usersNs-userId;
                $data['row_guid']=Base_Uuid::guid();
                $data['row_version']=0;
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
        	return $this->getMapper()->getDbTable()->update($data, array('message_id = ?' => $id));
        }
    }


    public function find($id)
    { 
        $result = $this->getMapper()->getDbTable()->find($id);
     
        if (0 == count($result)) {
            return;
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
    
    public function getCategoryArray($status="1")
    {
        return $this->getMasterArray("fdSysMessageCategory", $status);
    }
    
    public function getSeverityArray($status="1")
    {
        return $this->getMasterArray("fdSysMessageSeverity", $status);
    }
    
    public function getTypeArray($status="1")
    {
        return $this->getMasterArray("fdSysMessageType", $status);
    }
    
    public function getMasterArray($masterCode,$status='1')
    {
        $arr=array(""=>"--Select--");
        $model=new Security_Model_SystemMaster();
        
        $res = $model->fetchAll("status='{$status}' and master_code='{$masterCode}'");
        if(count($res )>0)
        {
            foreach($res as $_row)
            {
                $arr[$_row->getMasterId()]=$_row->getMasterValue();
            }
        }
        return $arr;
    }
    
}