<?php
class Admin_Model_Supplier {
    
    protected $_id;
    protected $_username;
    protected $_password;
    protected $_orgName;
    protected $_firstName;
    protected $_lastName;
    protected $_address1;
    protected $_address2;
    protected $_city;
    protected $_state;
    protected $_zip;
    protected $_phone;
    protected $_fax;
    protected $_email;
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
            $this->setMapper(new Admin_Model_SupplierMapper());
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

    public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }

    public function getEmail()
    {
     return $this->_email;
    }

    public function setUsername($username)
    {
        $this->_username = (string) $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->_username;
    }
    
    public function getPassword()
    {
        return $this->_password;
    }

    public function setPassword($password)
    {
        $this->_password = (string) $password;
        return $this;
    }   

    public function getFirstName()
    {
          
        return $this->_firstName;
    }

    public function setFirstName($firstName)
    {
        $this->_firstName = (string) $firstName;
        return $this;
    } 

    public function getOrgName()
    {
        return $this->_orgName;
    }

    public function setOrgName($orgName)
    {
        $this->_orgName = (string) $orgName;
        return $this;
    }
    
    public function getLastName()
    {
        return $this->_lastName;
    }

    public function setLastName($lastName)
    {
        $this->_lastName = (string) $lastName;
        return $this;
    }        
	
    
    public function getAddress1()
    {
        return $this->_address1;
    }

    public function setAddress1($address1)
    {
        $this->_address1 = (string) $address1;
        return $this;
    }
    public function getAddress2()
    {
        return $this->_address2;
    }

    public function setAddress2($address2)
    {
        $this->_address2 = (string) $address2;
        return $this;
    } 
    public function getZip()
    {
        return $this->_zip;
    }

    public function setZip($zip)
    {
        $this->_zip = (string) $zip;
        return $this;
    }
    
    public function getFax()
    {
        return $this->_fax;
    }

    public function setFax($fax)
    {
        $this->_fax = (string) $fax;
        return $this;
    }
    
    public function getPhone()
    {
        return $this->_phone;
    }

    public function setPhone($phone)
    {
        $this->_phone= (string) $phone;
        return $this;
    }
    
    public function getCity()
    {
        return $this->_city;
    }

    public function setCity($city)
    {
        $this->_city= (string) $city;
        return $this;
    }
    
    public function getState()
    {
        return $this->_state;
    }

    public function setState($state)
    {
        $this->_state= (string) $state;
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
    
    
    
    public function setRowGuid($rowguid)
    {
        $this->_rowGuid = (int) $rowguid;
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
	/*----Data Manupulation functions ----*/
    
    public function setModel($row)
    {
      $model = new Admin_Model_Supplier();
      $model->setId($row->id)
            ->setUsername($row->username)
            ->setPassword($row->password)
            ->setOrgName($row->org_name)
            ->setFirstName($row->first_name)
            ->setLastName($row->last_name)
            ->setAddress1($row->address1)
            ->setAddress2($row->address2)
            ->setCity($row->city)
            ->setState($row->state)
            ->setZip($row->zip)
            ->setPhone($row->phone)
            ->setFax($row->fax)
            ->setEmail($row->email)
            ->setCreatedOn($row->created_on)
            ->setUpdatedOn($row->updated_on)
            ->setCreatedBy($row->created_by)
            ->setUpdatedBy($row->updated_by)
            ->setRowGuid($row->row_guid)
            ->setRowVersion($row->row_version)
            ->setRowMaxId($row->row_max_id)
            					;
        
             return $model;
    }
    
    public function save()
    {
         
        $usersNs = new Zend_Session_Namespace("members");  
     	$data = array(
                'username'   		=> $this->getUsername(),
        	'password'  		=> $this->getPassword(),
                'org_name'		=> $this->getOrgName(),
        	'first_name'		=> $this->getFirstName(),
        	'last_name' 		=> $this->getLastName(),
                'address1' 		=> $this->getAddress1(),
                'address2' 		=> $this->getAddress2(),
                'city'                  => $this->getCity(),
                'state'                 => $this->getState(),
                'zip'                   => $this->getZip(),
     		'phone'                 => $this->getPhone(),
                'fax'                   => $this->getFax(),
                'email'   		=> $this->getEmail()
              );

        if (null === ($id = $this->getId())) 
        {
            $Db=new Base_Db();
            $id=$Db->genId("supplier", 'id');
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

    
    public function getDataByUsername($username)
    {
    	$user=new Admin_Model_Supplier();
    	$user=$user->fetchRow("username='{$username}'");
    	return $user;
    }
    
   
    /*------Data utility functions------*/
    public function getAllUsers($status="")
    {
        $obj=new Admin_Model_Supplier();
        if($status=="")
            $entries=$obj->fetchAll();
        else
             $entries=$obj->fetchAll("status='active'");
        $arrUserLevel=array(''=>"Select");
        foreach($entries as $entry)
        { 	
            $arrUserLevel[$entry->getId()]=$entry->getFirstName()." ".$entry->getLastName() ;
        }
        return $arrUserLevel;	
    }
    
    public function getids()
    {
        $obj=new Admin_Model_Supplier();
        $entries=$obj->fetchAll();
        $arrUser=array();
        foreach($entries as $entry)
        { 	
            $arrUser[$entry->getId()]=$entry->getUsername();
        }
        return $arrUser;	
    }
  
}
