<?php
class Mps_Model_RawProduct{
    
    protected $_id;
    
    protected $_sequenceNo;
    protected $_type;
    protected $_breed;
    protected $_color;
   
    protected $_supplierId;
    protected $_description;
    protected $_tagNo;
    protected $_transactionId;
    protected $_incomingDate;
    protected $_knockedDate;
    
    protected $_weighingDate;
    protected $_auctionTag;
    protected $_earTag;
   
    protected $_trich;
    protected $_backTag;
    protected $_defects;
    
    protected $_grade;
    protected $_weight;
    
    protected $_mapper;
    protected $_status;
    protected $_condumnSubStatus;
    protected $_statusOn;
    protected $_processStatus='';
    
    
    
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
            $this->setMapper(new Mps_Model_RawProductMapper());
        }
        return $this->_mapper;
    }

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setSequenceNo($sequenceNo)
    {
        $this->_sequenceNo = (string) $sequenceNo;
        return $this;
    }

    public function getSequenceNo()
    {
     return $this->_sequenceNo;
    }

        
    public function getType()
    {
        return $this->_type;
    }

    public function setType($type)
    {
        $this->_type = (string) $type;
        return $this;
    }   

    public function getBreed()
    {
          
        return $this->_breed;
    }

    public function setBreed($breed)
    {
        $this->_breed = (string) $breed;
        return $this;
    } 
    
    public function getColor()
    {
          
        return $this->_color;
    }

    public function setColor($color)
    {
        $this->_color = (string) $color;
        return $this;
    }

    public function getSupplierId()
    {
        return $this->_supplierId;
    }

    public function setSupplierId($supplierId)
    {
        $this->_supplierId = (string) $supplierId;
        return $this;
    }
    
    public function getDescription()
    {
        return $this->_description;
    }

    public function setDescription($description)
    {
        $this->_description = (string) $description;
        return $this;
    } 
    
    public function getTagNo()
    {
        return $this->_tagNo;
    }

    public function setTagNo($tagNo)
    {
        $this->_tagNo = (string) $tagNo;
        return $this;
    }
	
    
    public function getTransactionId()
    {
        return $this->_transactionId;
    }

    public function setTransactionId($transactionId)
    {
        $this->_transactionId = (string) $transactionId;
        return $this;
    }
    public function getIncomingDate()
    {
        return $this->_incomingDate;
    }

    public function setIncomingDate($incomingDate)
    {
        $this->_incomingDate = (string) $incomingDate;
        return $this;
    } 
    public function getKnockedDate()
    {
        return $this->_knockedDate;
    }

    public function setKnockedDate($knockedDate)
    {
        $this->_knockedDate = (string) $knockedDate;
        return $this;
    }
    
    public function getWeighingDate()
    {
        return $this->_weighingDate;
    }

    public function setWeighingDate($weighingDate)
    {
        $this->_weighingDate = (string) $weighingDate;
        return $this;
    }
    
    public function getAuctionTag()
    {
        return $this->_auctionTag;
    }

    public function setAuctionTag($auctionTag)
    {
        $this->_auctionTag = (string) $auctionTag;
        return $this;
    }
    
    public function getEarTag()
    {
        return $this->_earTag;
    }

    public function setEarTag($earTag)
    {
        $this->_earTag= (string) $earTag;
        return $this;
    }
    
    public function getTrich()
    {
        return $this->_trich;
    }

    public function setTrich($trich)
    {
        $this->_trich= (string) $trich;
        return $this;
    }
    
    public function getBackTag()
    {
        return $this->_backTag;
    }

    public function setBackTag($backTag)
    {
        $this->_backTag= (string) $backTag;
        return $this;
    }
    
    public function getDefects()
    {
        return $this->_defects;
    }

    public function setDefects($defects)
    {
        $this->_defects= (string) $defects;
        return $this;
    }
    
    public function getGrade()
    {
        return $this->_grade;
    }

    public function setGrade($grade)
    {
        $this->_grade= (string) $grade;
        return $this;
    }
    
    
    public function getWeight()
    {
        return $this->_weight;
    }

    public function setWeight($weight)
    {
        $this->_weight= (string) $weight;
        return $this;
    }
    
    
    public function getCondumnSubStatus()
    {
        return $this->_condumnSubStatus;
    }

    public function setCondumnSubStatus($condumnSubStatus)
    {
        $this->_condumnSubStatus= (string) $condumnSubStatus;
        return $this;
    }
    
    
    public function getStatusOn()
    {
        return $this->_statusOn;
    }

    public function setStatusOn($statusOn)
    {
        $this->_statusOn= (string) $statusOn;
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
    
    
    public function getProcessStatus()
    {
        return $this->_processStatus;
    }
 
    public function setProcessStatus($processStatus)
    {
        $this->_processStatus = (string) $processStatus;
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
      $model = new Mps_Model_RawProduct();
      $model->setId($row->id)
            
            ->setSequenceNo($row->sequence_no)
            ->setType($row->type)
            ->setBreed($row->breed)
            ->setColor($row->color)
            ->setSupplierId($row->supplier_id)
            ->setDescription($row->description)
            ->setTagNo($row->tag_no)
            ->setTransactionId($row->transaction_id)
            ->setIncomingDate($row->incoming_date)
            ->setKnockedDate($row->knocked_date)
            ->setWeighingDate($row->weighing_date)
            ->setAuctionTag($row->auction_tag)
            ->setEarTag($row->ear_tag)
            ->setTrich($row->trich)
            ->setBackTag($row->back_tag)
            ->setDefects($row->defects)
            ->setGrade($row->grade)
            ->setWeight($row->weight) 
            ->setCondumnSubStatus($row->condumn_sub_status)
            ->setStatusOn($row->status_on)
            ->setCreatedOn($row->created_on)
            ->setUpdatedOn($row->updated_on)
            ->setCreatedBy($row->created_by)
            ->setUpdatedBy($row->updated_by)
            ->setRowGuid($row->row_guid)
            ->setRowVersion($row->row_version)
            ->setRowMaxId($row->row_max_id)
            ->setStatus($row->status)
              ->setProcessStatus($row->process_status)
            					;
        
             return $model;
    }
    
    public function save()
    {
         
        
        $usersNs = new Zend_Session_Namespace("members");  
     	$data = array(
                'sequence_no'		=> $this->getSequenceNo(),
        	'type'		        => $this->getType(),
        	'breed' 		=> $this->getBreed(),
                'color' 		=> $this->getColor(),
                'supplier_id'           => $this->getSupplierId(),
                'description'           => $this->getDescription(),
                'tag_no'                => $this->getTagNo(),
                'transaction_id'        => $this->getTransactionId(),
                'incoming_date'          => $this->getIncomingDate(),
                'knocked_date' 		=> $this->getKnockedDate(),
                'weighing_date'         => $this->getWeighingDate(),
                'auction_tag'           => $this->getAuctionTag(),
                'ear_tag'               => $this->getEarTag(),
     		'trich'                 => $this->getTrich(),
                'back_tag'              => $this->getBackTag(),
                'defects'   		=> $this->getDefects(),
                'grade'   		=> $this->getGrade(),
                'weight'   		=> $this->getWeight(),
                'condumn_sub_status'    => $this->getCondumnSubStatus(),
                'status_on'             => $this->getStatusOn(),
                'status'		=> $this->getStatus(),
                'process_status'        => $this->getProcessStatus()
              );
        
        if (null === ($id = $this->getId())) 
        {
            
            
            $Db=new Base_Db();
            $id=$Db->genId("raw_product", 'id');
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
                echo 'aaahere';
        die;  
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
    	$user=new Mps_Model_RawProduct();
    	$user=$user->fetchRow("username='{$username}'");
    	return $user;
    }
    
   
    /*------Data utility functions------*/
    public function getAllUsers($status="")
    {
        $obj=new Mps_Model_RawProduct();
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
        $obj=new Mps_Model_RawProduct();
        $entries=$obj->fetchAll();
        $arrUser=array();
        foreach($entries as $entry)
        { 	
            $arrUser[$entry->getId()]=$entry->getUsername();
        }
        return $arrUser;	
    }
    
    
    
  
}
