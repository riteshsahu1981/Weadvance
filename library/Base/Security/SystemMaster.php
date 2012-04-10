<?php
class Base_Security_SystemMaster
{
    public function getMenuItems($status=1)
    {
        $model=new Security_Model_SystemMaster();
        return $model->fetchAll("status='{$status}' and master_code='fdMenu'");
    }
	
    public function getControlItemsArray($status=1)
    {
        $arr=array(""=>"--Select--");
        $controls=$this->getControlType();
        foreach($controls as $_control)
        {
            $arr[$_control['id']]=$_control['name'];
            
        }
        return $arr;
    }
	
	function getControlType($id=0)
	{
		$model=new Security_Model_Control();
		if ($id==0)
        $result=$model->fetchAll();
		else
        $result=$model->fetchAll("id='$id'");
		
		$arrParentResult=array();
        if(count($result)>0)
        {
            foreach($result as $row)
            {
				$i=count($arrParentResult);
				$arrParentResult[$i]['id']=$row->getId();
				$arrParentResult[$i]['name']=$row->getName();
				$arrParentResult[$i]['value']=$row->getValue();
				$arrParentResult[$i]['status']=$row->getStatus();
            }
        }
        
        return $arrParentResult;
		//return $result;
		
	}
      /*  
    public function getMenuItemsArray($status=1)
    {
        $arr=array("0"=>"--Select--");

        $pages=$this->getChildPages(0,0);
        foreach($pages as $_page)
        {
            $arr[$_page['menu_id']]=$_page['menu_sno'].". ".$_page['menu_title'];
            
        }
        return $arr;
    }
    
    public function delgetChildPages($parent_id)
    {
        $model=new Security_Model_SystemMaster();
        $result=$model->fetchAll("master_code='fdMenu' and intval1='$parent_id'");

        $arrParentResult=array();
        if(count($result)>0)
        {
            foreach($result as $row)
            {
                    $i=count($arrParentResult);
                    $arrParentResult[$i]['menu_id']=$row->getMasterId();
                    $arrParentResult[$i]['menu_title']=$row->getMasterValue();
                    $arrParentResult[$i]['menu_code']=$row->getMasterCode();
                    $arrParentResult[$i]['menu_is_active']=$row->getStatus();
                    $arrParentResult[$i]['menu_parent_id']=$parent_id;
                    $arrParentResult[$i]['menu_is_child']=$row->getBlnval1();
                    $arrParentResult[$i]['menu_path']=$row->getStrval1();

                    $arrChildResult=$this->getChildPages($row->getMasterId());
                    $arrParentResult[$i]['menu_childs']=array();
                    if(count($arrChildResult)>0)
                    {
                        $arrParentResult[$i]['menu_childs']=$arrChildResult;
                    }
                    
            }
        }
        
        return $arrParentResult;
    }
    public function getChildPages($parent_id, $psno)
    {
        $model=new Security_Model_SystemMaster();
        $result=$model->fetchAll("master_code='fdMenu' and intval1='$parent_id'");

        $arrParentResult=array();
        if(count($result)>0)
        {
            $sno=0;
            
            foreach($result as $row)
            {
                $sno++;
                if($psno == "0" )
                    $snod=$sno;
                 else
                    $snod=$psno.".".$sno;
                
                    $i=count($arrParentResult);
                    $arrParentResult[$i]['menu_sno']=$snod;
                    $arrParentResult[$i]['menu_id']=$row->getMasterId();
                    $arrParentResult[$i]['menu_title']=$row->getMasterValue();
                    $arrParentResult[$i]['menu_code']=$row->getMasterCode();
                    $arrParentResult[$i]['menu_is_active']=$row->getStatus();
                    $arrParentResult[$i]['menu_parent_id']=$parent_id;
                    $arrParentResult[$i]['menu_is_child']=$row->getBlnval1();
                    $arrParentResult[$i]['menu_path']=$row->getStrval1();
                    $arrParentResult[$i]['menu_row_guid']=$row->getRowGuid();
                    $arrChildResult=$this->getChildPages($row->getMasterId(), $snod);
                    //$arrParentResult[$i]['menu_childs']=array();
                    if(is_array($arrChildResult))
                       $arrParentResult = array_merge($arrParentResult,$arrChildResult);
//                    if(count($arrChildResult)>0)
//                    {
//                        $arrParentResult[$i]['menu_childs']=$arrChildResult;
//                    }
                    
            }
        }
        
        return $arrParentResult;
    }
    
    public function hasChild($arrChild)
    {
        if(count($arrChild)>0)
            return true;
        else
            return false;
    }
 
    public function getChildGrid($arrChild, $psno)
    {
        if($this->hasChild($arrChild))
        {
            $sno=0;
            
            foreach($arrChild as $_child)
            {
                $has_childs=$this->hasChild($_child['menu_childs']);
                
                $sno++;
                $snod=$psno.".".$sno;
                $str.="<tr class='child_".$_child['menu_parent_id']."' >";
                $str.="<td>  ".$snod."</td>";
                $str.="<td>".$_child['menu_id']."</td>";
                $str.="<td>".$_child['menu_title']."</td>";
                $str.="<td>".$_child['menu_path']."</td>";
                
                $str.="<td>".$_child['menu_parent_id']."</td>";
                $str.="<td>".($_child['menu_is_active']==0 ? "No" : "Yes")."</td>";
                $str.="<td>".($_child['menu_is_child']==0 ? "No" : "Yes")."</td>";
                
                if($has_childs)
                {
                    $str.=$this->getChildGrid($_child['menu_childs'], $snod);
                }
                $str.="</tr>";
            }
            
        }
        return $str;
    }
    
    
    public function changeStatus($id, $status)
    {
        $model=new Security_Model_SystemMaster();
        $row=$model->fetchRow("master_id='{$id}' and master_code='fdMenu'");
        if(false===$row)
            return false;
        
        $row->setStatus($status);
        return $row->save();
        
    }
    
    public function changeChildStatus($id, $status)
    {
        $model=new Security_Model_SystemMaster();
        $row=$model->fetchRow("master_id='{$id}' and master_code='fdMenu'");
        if(false===$row)
            return false;
        
        $row->setBlnval1($status);
        return $row->save();
    }
    
    
    
    public function getFullMenuTree()
    {

        $str='<div id="privilege_tree" class="demo">';
        $str.="<ul>";
        $str.='<li id="noderoot_0" rel="root">';
        $str.="<a href='#'>All</a>";
        $str.=$this->getMenuTree(0);
        $str.="</li>";
        $str.="</ul>";
        $str.="</div>";
        
        $str.=<<<EOT

            <script language="javascript">

            $(function () {
                    $("#privilege_tree").jstree({ 
                            "core" : { "initially_open" : [ "noderoot_0"] },
                            "plugins" : [ "themes", "html_data", "ui", "crrm", , "types" ,"hotkeys", "checkbox"],
                            "types" : {
                                "max_depth" : -2,
                                "max_children" : -2,
                                "valid_children" : [ "root" ],
                                "types" : {
                                            "root" : {
                                                    "icon" : {"image" : "/js/tree/themes/default/_drive.png" },
                                                    "valid_children" : [ "default" ],
                                                    "max_depth" : 2,
                                                    "hover_node" : false,
                                                    'rename_node' :false,
                                                    'select_node' :false
                                            },
                                            "default" : {
                                                    "icon" : {"image" : "/js/tree/themes/default/folder.png" },
                                                    "valid_children" : [ "subgroup" ],
                                                    "max_depth" : 2,
                                                    "hover_node" : false
                                            }
                                    }
                                },
                                
                            "checkbox" : {
                                real_checkboxes : true 
                                           }

                    })
                    
                   
                    ;


            });
            </script>
EOT;
        
        return $str;
    }
    
    public function getMenuTree($parent_id)
    {
        $model=new Security_Model_SystemMaster();
        $result=$model->fetchAll("master_code='fdMenu' and intval1='$parent_id'");
        
        $str="";
        if(count($result)>0)
        {
            $str.="<ul>";
            foreach($result as $row)
            {
                $str.=" <li id='{$row->getMasterId()}' >";
                $str.="     <a href='{$row->getStrval1()}'>{$row->getMasterValue()}</a>";
                //check child tree
                    $modelC=new Security_Model_SystemMaster();
                    $resultC=$model->fetchAll("master_code='fdMenu' and intval1='{$row->getMasterId()}'");        
                    if(count($resultC)>0)
                    {
                        //has childs
                        $str.=$this->getMenuTree($row->getMasterId());
                    }
                $str.=" </li>";
            }
            $str.="</ul>";
            return $str;
        }
    }
	*/
}