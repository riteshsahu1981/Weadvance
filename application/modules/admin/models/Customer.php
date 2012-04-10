<?php
class Admin_Model_Customer {
    
    protected $_id;
    
    protected $_orgName;
    protected $_firstName;
    protected $_lastName;
    protected $_address;
   
    protected $_city;
    protected $_state;
    protected $_zip;
    protected $_phone;
    protected $_fax;
    protected $_email;
    
    protected $_bFirstName;
    protected $_bLastName;
    protected $_bAddress;
   
    protected $_bCity;
    protected $_bState;
    protected $_bZip;
    
    protected $_mapper;
    protected $_status;
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
            $this->setMapper(new Admin_Model_CustomerMapper());
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
    
    public function getBFirstName()
    {
          
        return $this->_bFirstName;
    }

    public function setBFirstName($bFirstName)
    {
        $this->_bFirstName = (string) $bFirstName;
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
    
    public function getBLastName()
    {
        return $this->_bLastName;
    }

    public function setBLastName($bLastName)
    {
        $this->_bLastName = (string) $bLastName;
        return $this;
    }
	
    
    public function getAddress()
    {
        return $this->_address;
    }

    public function setAddress($address)
    {
        $this->_address = (string) $address;
        return $this;
    }
    public function getBAddress()
    {
        return $this->_bAddress;
    }

    public function setBAddress($bAddress)
    {
        $this->_bAddress = (string) $bAddress;
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
    
    public function getBZip()
    {
        return $this->_bZip;
    }

    public function setBZip($bZip)
    {
        $this->_bZip = (string) $bZip;
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
    
    public function getBCity()
    {
        return $this->_bCity;
    }

    public function setBCity($bCity)
    {
        $this->_bCity= (string) $bCity;
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
    
    public function getBState()
    {
        return $this->_bState;
    }

    public function setBState($bState)
    {
        $this->_bState= (string) $bState;
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
    
    public function changeStatus($id, $status)
    {
        //$model=new Security_Model_SystemMaster();
        $row=$this->fetchRow("id='{$id}'");
        if(false===$row)
            return false;
        
        $row->setStatus($status);
        return $row->save();
        
    }
    
    
    
    
	/*----Data Manupulation functions ----*/
    
    public function setModel($row)
    {
      $model = new Admin_Model_Customer();
      $model->setId($row->id)
            
            ->setOrgName($row->org_name)
            ->setFirstName($row->first_name)
            ->setLastName($row->last_name)
            ->setAddress($row->address)
            ->setCity($row->city)
            ->setState($row->state)
            ->setZip($row->zip)
            ->setBFirstName($row->bfirst_name)
            ->setBLastName($row->blast_name)
            ->setBAddress($row->baddress)
            ->setBCity($row->bcity)
            ->setBState($row->bstate)
            ->setBZip($row->bzip)
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
            ->setStatus($row->status)
            					;
        
             return $model;
    }
    
    public function save()
    {
         
        $usersNs = new Zend_Session_Namespace("members");  
     	$data = array(
                'org_name'		=> $this->getOrgName(),
        	'first_name'		=> $this->getFirstName(),
        	'last_name' 		=> $this->getLastName(),
                'address' 		=> $this->getAddress(),
                'city'                  => $this->getCity(),
                'state'                 => $this->getState(),
                'zip'                   => $this->getZip(),
                'bfirst_name'		=> $this->getBFirstName(),
        	'blast_name' 		=> $this->getBLastName(),
                'baddress' 		=> $this->getBAddress(),
                'bcity'                  => $this->getBCity(),
                'bstate'                 => $this->getBState(),
                'bzip'                   => $this->getBZip(),
     		'phone'                 => $this->getPhone(),
                'fax'                   => $this->getFax(),
                'email'   		=> $this->getEmail(),
                'status'		=> $this->getStatus()
              );

        if (null === ($id = $this->getId())) 
        {
            $Db=new Base_Db();
            $id=$Db->genId("customer", 'id');
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
    	$user=new Admin_Model_Customer();
    	$user=$user->fetchRow("username='{$username}'");
    	return $user;
    }
    
   
    /*------Data utility functions------*/
    public function getAllUsers($status="")
    {
        $obj=new Admin_Model_Customer();
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
        $obj=new Admin_Model_Customer();
        $entries=$obj->fetchAll();
        $arrUser=array();
        foreach($entries as $entry)
        { 	
            $arrUser[$entry->getId()]=$entry->getUsername();
        }
        return $arrUser;	
    }
  
}
