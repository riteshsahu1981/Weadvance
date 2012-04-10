<?php
class Base_Array{
	
    public function __construct()
    {
    
    }
	
    public function orderBy(&$data, $field, $order='asc') 
    { 
            if($order=="desc")
                    $code = "return strnatcmp(\$b['$field'], \$a['$field']);";
            else
                    $code = "return strnatcmp(\$a['$field'], \$b['$field']);";

                    usort($data, create_function('$a,$b', $code));
    } 
    
//    public function search($array, $key, $value)
//    {
//        $results = array();
//
//        if (is_array($array))
//        {
//            if (isset($array[$key]) && $array[$key] == $value)
//                $results[] = $array;
//
//            foreach ($array as $subarray)
//                $results = array_merge($results, $this->search($subarray, $key, $value));
//        }
//
//        return $results;
//    }
 
    public function search($array, $key, $value)
    {
        $results = array();

        $this->search_r($array, $key, $value, $results);

        return $results;
    }

    protected function search_r($array, $key, $value, &$results)
    {
        if (!is_array($array))
            return;
//
//        if ($array[$key] == $value)
//            $results[] = $array;
//        
        if(isset($array[$key])){
        if(stristr($array[$key], $value) !== FALSE) {
            $results[] = $array;
        }
        }
        foreach ($array as $subarray)
            $this->search_r($subarray, $key, $value, $results);
    }

}