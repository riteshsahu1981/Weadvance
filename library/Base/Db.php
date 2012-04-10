<?php
class Base_Db{
	
	public function __construct()
    {
    
    }
	
    public function getTotalRecords($table,$where=null)
    {
        $dbTable=Zend_Registry::get('db');
        $dbTable->setFetchMode(Zend_Db::FETCH_ASSOC);
        $select = $dbTable->select()->from($table,'COUNT(*) AS num')->where($where);
        $result = $dbTable->fetchRow($select);
        return 	$result['num'];
    }
    
    public function genId($table_name, $primary_key_id_name, $row_max_id_name="row_max_id", $row_version_name="row_version", $min_id_value="-2147483648")
    {
        $dbTable=Zend_Registry::get('db');
       
        $select = $dbTable->select()
                ->from($table_name, array('id'=>$primary_key_id_name, 'row_version'=>$row_version_name, 'row_max_id'=>$row_max_id_name) )
                ->where("{$primary_key_id_name}='{$min_id_value}'");
                //echo $select->__toString();
                
        $result = $dbTable->fetchRow($select);
        
        $new_row_version=$result->row_version +1;
        $new_max_id = $result->row_max_id + 1;
        
        $no_of_rows_effected=$dbTable->update($table_name, array($row_max_id_name=>$new_max_id, $row_version_name=>$new_row_version  ), "{$row_version_name}='{$result->row_version}' and {$primary_key_id_name}='{$result->id}'");
        if(1===$no_of_rows_effected)
            return $new_max_id;
        else
            return false;       
    }
    
    
//    public function genCodeId($table_name,$code_name)
//    {
//        $dbTable=Zend_Registry::get('db');
//        $select = $dbTable->select()
//                ->from($table_name, array('code_value'=>'MAX(code_value)' , 'updated_date'=>'updated_date') )
//                ->where("code_name='{$code_name}'");
//                //echo $select->__toString();
//        $result = $dbTable->fetchRow($select);
//        $new_code_value = $result->code_value + 1;
//        if($code_name == 'sequence_num'){
//            $updated_date = date("Y-m-d");
//            if($updated_date != $result->updated_date){
//                $new_code_value = 2;
//                $result->code_value = 1;
//            }
//        }
//        $no_of_rows_effected=$dbTable->update($table_name, array('code_value'=>$new_code_value,'updated_date'=>$updated_date ) , "code_name='$code_name'" );
//        if(1===$no_of_rows_effected){
//            //return $new_code_value;
//            return $result->code_value;
//        }
//        else
//            return false;       
//    }
    
    
    public function genCodeId($code_name)
    {
        $dbTable=Zend_Registry::get('db');
       
        $select = $dbTable->select()
                ->from("code_table", array('id', 'row_version', 'code_value', 'updated_on') )
                ->where("code_name='{$code_name}'");
                //echo $select->__toString();
        
                $code_name_arr = explode('_',$code_name);
        
        $result = $dbTable->fetchRow($select);
        if($code_name=="sequence_num" && $result->updated_on > 0 )
        {
            $current_time = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
            if($result->updated_on < $current_time)
            {
                $new_code_value  = 1;
            }
            else
            {
                $new_code_value  = $result->code_value + 1;
            }
        }
        else if($code_name_arr[0]=="transaction" &&(count($code_name_arr) == 3))
        {
            $new_code_value = $this->quick_supplierTId($result->updated_on,$result->code_value);
        }
        else
        {
            $new_code_value  = $result->code_value + 1;
        }
        $new_row_version = $result->row_version +1;
        $no_of_rows_effected=$dbTable->update("code_table", array('updated_on'=>time(), 'code_value'=>$new_code_value, 'row_version'=>$new_row_version  ), "row_version='{$result->row_version}' and id='{$result->id}'");
        if(1===$no_of_rows_effected)
            return $new_code_value;
        else
            return false;       
    }
    
    
    public function quick_supplierTId($updated_on,$code_value){
        $current_time = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
        if($updated_on < $current_time)
        {
            return $code_value;
        }
        else
        {
            return ($code_value + 1);
        }
     }
    /* public function genCodeId($code_name)
    {
        $dbTable=Zend_Registry::get('db');
       
        $select = $dbTable->select()
                ->from("code_table", array('id', 'row_version', 'code_value', 'updated_on') )
                ->where("code_name='{$code_name}'");
                //echo $select->__toString();
                
        $result = $dbTable->fetchRow($select);
        if($code_name=="sequence_num" && $result->updated_on > 0 )
        {
            $current_time = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
            if($result->updated_on < $current_time)
            {
                $new_code_value  = 1;
            }
            else
            {
                $new_code_value  = $result->code_value + 1;
            }
        }
        else
        {
            $new_code_value  = $result->code_value + 1;
        }
        $new_row_version = $result->row_version +1;
        $no_of_rows_effected=$dbTable->update("code_table", array('updated_on'=>time(), 'code_value'=>$new_code_value, 'row_version'=>$new_row_version  ), "row_version='{$result->row_version}' and id='{$result->id}'");
        if(1===$no_of_rows_effected)
            return $new_code_value;
        else
            return false;       
    } */
    
    
    
    public function genSystemMasterId($master_code)
    {
       $model=new Security_Model_SystemMaster();
       $table=$model->getMapper()->getDbTable();
        $select = $table->select()->from(array("a"=>'system_master'), array('max_id'=>'MAX(master_id)'))
                ->where("master_code='$master_code'");
        $row=$table->fetchRow($select );
        $max_id=$row->max_id + 1 ;
        return $max_id;
         //echo $select->__toString(); exit;
       
    }
	
	
 
}