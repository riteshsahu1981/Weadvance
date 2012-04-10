<?php
class Admin_Model_Location {
    
    protected $_id;
    protected $_title;
    protected $_description;
    protected $_weight;
    protected $_status;
	protected $_mapper;
    protected $_createdOn;
    protected $_updatedOn;
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
            throw new Exception('Invalid property specified' . $method);
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
			//echo $method."->";
            if (in_array($method, $methods)) {
                $this->$method($value);
				//echo $value;
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
            $this->setMapper(new Admin_Model_LocationMapper());
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

    public function getTitle()
    {
        return $this->_title;
    }
	
	public function setTitle($title)
    {
        $this->_title=(string)$title;
		return $this;
    }    
	
    public function getDescription()
    {
        return $this->_description;
    }

    public function setDescription($description)
    {
       $this->_description=(string)$description;
	   return $this;
    }

    public function getWeight()
    {
        return $this->_weight;
    }

	public function setWeight($weight)
    {
        $this->_weight=(string)$weight;
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
    
     public function getCreatedBy()
    {
        return $this->_createdBy;
    }

    public function setCreatedBy($createdby)
    {
        $this->_createdBy = (int) $createdby;
        return $this;
    }  
    
    public function getUpdatedBy()
    {
        return $this->_updatedBy;
    }

    public function setUpdatedBy($updatedby)
    {
        $this->_updatedBy = (int) $updatedby;
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
    
    public function getStatus()
    {
        return $this->_status;
    }
 
    public function setStatus($status)
    {
        $this->_status = (string) $status;
        return $this;
    }
    
    public function setRowGuid($rowguid)
    {
        $this->_rowGuid =$rowguid;
        return $this;
    }

    public function getRowGuid()
    {
        return $this->_rowGuid;
    }
       
    public function getLocations($status=1)
    {
        //$model=new Admin_Model_Location();
        
        return $this->fetchAll("status='{$status}'");
    }
    
    public function getLocationArray($status=1)
    {
        //$arr=array(""=>"--Select--");
        $groups=$this->getLocations($status);
        foreach($groups as $_group)
        {
            $arr[$_group->getId()]=$_group->getTitle();
        }
        return $arr;
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
	/*----Data Manupulation functions ----*/
    
    public function setModel($row)
    {
      $model = new Admin_Model_Location();
      $model->setId($row->id)
            ->setTitle($row->title)
            ->setDescription($row->description)
            ->setWeight($row->weight)
            ->setCreatedOn($row->created_on)
            ->setUpdatedOn($row->updated_on)
            ->setCreatedBy($row->created_by)
            ->setUpdatedBy($row->updated_by)
            ->setRowGuid($row->row_guid)
            ->setRowVersion($row->row_version)
            ->setRowMaxId($row->row_max_id)
            ->setStatus($row->status)
            					;
								
        
             return $model;
    }
    
    public function save()
    {
         
        $usersNs = new Zend_Session_Namespace("members");  
     	$data = array(
            'title'   			=> $this->getTitle(),
        	'description'  		=> $this->getDescription(),
            'weight'			=> $this->getWeight(),
            'status'			=> $this->getStatus()
              );
		$id = $this->getId();
		//echo "id==".$id;
		
        if ($id===null) 
        {
            $Db=new Base_Db();
            $id=$Db->genId("location", 'id');
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
            $data['row_version']=$this->getRowVersion() + 1;
            $res=$this->getMapper()->getDbTable()->update($data, array("id = '$id' and row_version = '{$this->getRowVersion()}'" ));
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

    
   
    
   
    /*------Data utility functions------*/
    
    
    public function getids()
    {
        $obj=new Admin_Model_Location();
        $entries=$obj->fetchAll();
        $arrUser=array();
        foreach($entries as $entry)
        { 	
            $arrUser[$entry->getId()]=$entry->getUsername();
        }
        return $arrUser;	
    }
  
}
