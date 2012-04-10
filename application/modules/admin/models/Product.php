<?php
class Admin_Model_Product {
    
    protected $_id;
    protected $_caseFormat;
    protected $_labelCase;
    protected $_productIdentifier;
    protected $_packLocation;
    protected $_partNumber;
    protected $_sellByDays;
    protected $_priceLb;
    protected $_palletId;
    protected $_desLine1;
    protected $_desLine2;
    protected $_desLine3;
    protected $_desLine4;
    protected $_lowerWeight;
    protected $_fixedWeight;
    protected $_heighWeight;
    protected $_tareWeight;
    protected $_requiredApp;
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
            $this->setMapper(new Admin_Model_ProductMapper());
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

    public function setCaseFormat($caseFormat)
    {
        $this->_caseFormat = (string) $caseFormat;
        return $this;
    }

    public function getCaseFormat()
    {
     return $this->_caseFormat;
    }

    public function setLabelCase($labelCase)
    {
        $this->_labelCase = (string) $labelCase;
        return $this;
    }

    public function getLabelCase()
    {
        return $this->_labelCase;
    }
    
    public function setProductIdentifier($productIdentifier)
    {
        $this->_productIdentifier = (string) $productIdentifier;
        return $this;
    } 
    
    public function getProductIdentifier()
    {
        return $this->_productIdentifier;
    }

    public function setPackLocation($packLocation)
    {
        $this->_packLocation = (string) $packLocation;
        return $this;
    } 
    
    public function getPackLocation()
    {
          
        return $this->_packLocation;
    }

    public function setPartNumber($partNumber)
    {
        $this->_partNumber = (string) $partNumber;
        return $this;
    }
    
    public function getPartNumber()
    {
        return $this->_partNumber;
    }
    
    public function setSellByDays($sellDays)
    {
        $this->_sellByDays = (string) $sellDays;
        return $this;
    }     
    
    public function getSellByDays()
    {
        
        return $this->_sellByDays;
    }
	
    public function setPriceLb($priceLb)
    {
        $this->_priceLb = (string) $priceLb;
        return $this;
    }
    
    public function getPriceLb()
    {
        return $this->_priceLb;
    }
    
    public function setPalletId($palletId)
    {
        $this->_palletId = (string) $palletId;
        return $this;
    } 
    
    public function getPalletId()
    {
        return $this->_palletId;
    }
    
    public function setDesLine1($desLine1)
    {
        $this->_desLine1 = (string) $desLine1;
        return $this;
    }
    
    public function getDesLine1()
    {
        return $this->_desLine1;
    }
    
    public function setDesLine2($desLine2)
    {
        $this->_desLine2 = (string) $desLine2;
        return $this;
    }
    
    public function getDesLine2()
    {
        return $this->_desLine2;
    }
    
    public function setDesLine3($desLine3)
    {
        $this->_desLine3 = (string) $desLine3;
        return $this;
    }
    
    public function getDesLine3()
    {
        return $this->_desLine3;
    }
    
    public function setDesLine4($desLine4)
    {
        $this->_desLine4 = (string) $desLine4;
        return $this;
    }
    
    public function getDesLine4()
    {
        return $this->_desLine4;
    }
    
    
    public function setLowerWeight($lowerWeight)
    {
        $this->_lowerWeight = (string) $lowerWeight;
        return $this;
    }
    
    public function getLowerWeight()
    {
        return $this->_lowerWeight;
    }
    
    public function setFixedWeight($fixedWeight)
    {
        $this->_fixedWeight = (string) $fixedWeight;
        return $this;
    }
    
    public function getFixedWeight()
    {
        return $this->_fixedWeight;
    }
    
    public function setHeighWeight($heighWeight)
    {
        $this->_heighWeight = (string) $heighWeight;
        return $this;
    }
    
    public function getHeighWeight()
    {
        return $this->_heighWeight;
    }
    
    
    public function setTareWeight($tareWeight)
    {
        $this->_tareWeight = (string) $tareWeight;
        return $this;
    }
    
    public function getTareWeight()
    {
        return $this->_tareWeight;
    }
    
    public function setRequiredApp($requiredApp)
    {
        $this->_requiredApp = (string) $requiredApp;
        return $this;
    }
    
    public function getRequiredApp()
    {
        return $this->_requiredApp;
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
      $model = new Admin_Model_Product();
      $model->setId($row->id)
            ->setCaseFormat($row->case_format)
            ->setLabelCase($row->label_case)
            ->setProductIdentifier($row->product_identifier)
            ->setPackLocation($row->pack_location)
            ->setPartNumber($row->part_number)
            ->setSellByDays($row->sell_by_days)
            ->setPriceLb($row->price_lb)
            ->setPalletId($row->pallet_id)
            ->setDesLine1($row->des_line_1)
            ->setDesLine2($row->des_line_2)
            ->setDesLine3($row->des_line_3)
            ->setDesLine4($row->des_line_4)
            ->setLowerWeight($row->lower_weight)
            ->setFixedWeight($row->fixed_weight)
            ->setHeighWeight($row->heigh_weight)
            ->setTareWeight($row->tare_weight)
            ->setRequiredApp($row->required_application)
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
                'case_format'   	=> $this->getCaseFormat(),
        	'label_case'  		=> $this->getLabelCase(),
                'product_identifier'	=> $this->getProductIdentifier(),
        	'pack_location'		=> $this->getPackLocation(),
        	'part_number' 		=> $this->getPartNumber(),
                'sell_by_days' 		=> $this->getSellByDays(),
                'price_lb' 		=> $this->getPriceLb(),
                'pallet_id'             => $this->getPalletId(),
                'des_line_1'		=> $this->getDesLine1(),
                'des_line_2'            => $this->getDesLine2(),
                'des_line_3'            => $this->getDesLine3(),
     		'des_line_4'            => $this->getDesLine4(),
                'lower_weight'          => $this->getLowerWeight(),
                'fixed_weight'   	=> $this->getFixedWeight(),
                'heigh_weight'          => $this->getHeighWeight(),
                'tare_weight'           => $this->getTareWeight(),
                'required_application'  => $this->getRequiredApp(),
                'status'                => $this->getStatus()
              );

        if (null === ($id = $this->getId())) 
        {
            $Db=new Base_Db();
            $id=$Db->genId("product", 'id');
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
    	$user=new Admin_Model_Product();
    	$user=$user->fetchRow("username='{$username}'");
    	return $user;
    }
    
   
    /*------Data utility functions------*/
    public function getAllUsers($status="")
    {
        $obj=new Admin_Model_Product();
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
        $obj=new Admin_Model_Product();
        $entries=$obj->fetchAll();
        $arrUser=array();
        foreach($entries as $entry)
        { 	
            $arrUser[$entry->getId()]=$entry->getUsername();
        }
        return $arrUser;	
    }
  
}
