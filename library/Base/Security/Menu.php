<?php
class Base_Security_Menu 
{
    public function getMenuItems($status=1)
    {
        $model=new Security_Model_SystemMaster();
        return $model->fetchAll("status='{$status}' and master_code='fdMenu'");
    }
        
    public function getMenuItemsArray($status=1)
    {
        $arr=array("0"=>"--Select--");
//        $menu_items =$this->getMenuItems($status);
//        
//        foreach($menu_items as $_menu_item)
//        {
//            $arr[$_menu_item->getMasterId()]=$_menu_item->getMasterValue();
//        }
//        return $arr;
        
        
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
//                $arrSno=explode(".", $snod);
//                if(count($arrSno)>1)
//                {
//                    foreach($arrSno as $vs)
//                    {
//                        $snod="-".$snod;
//                    }
//                }
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
                                                    "hover_node" : false,
                                                    'select_node' :false
                                            }
                                    }
                                },
                                
                            "checkbox" : {
                                real_checkboxes : true,
                                two_state :true
                                           }

                    })
                    .bind("check_node.jstree", function (e,data) 
                    { 
                        if(data.rslt.obj.attr("id")=="noderoot_0")
                        {
                            $("#privilege_tree").jstree("check_all");
                        }
                    })
                    .bind("uncheck_node.jstree", function (e,data) 
                    { 
                        if(data.rslt.obj.attr("id")=="noderoot_0")
                        {
                            $("#privilege_tree").jstree("uncheck_all");
                        }
                    })
                    

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
                    $resultC=$modelC->fetchAll("master_code='fdMenu' and intval1='{$row->getMasterId()}'");        
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
    
    
    public function getMenuArray($parent_id, $request_uri,$level)
    {
        //blnval2='1' isAction
        $level++;
        $model=new Security_Model_SystemMaster();
        if($level==1 || $level==2)
            $result=$model->fetchAll("master_code='fdMenu' and intval1='$parent_id' and 	blnval2<>'1' ");
        else
           $result=$model->fetchAll("master_code='fdMenu' and intval1='$parent_id'  ");
        
        $arr=array();
        if(count($result)>0)
        {
            foreach($result as $row)
            {
                $page['label']=$row->getMasterValue();
                $page['id']=$row->getMasterId();
                
                $arrUrl=explode("/",$row->getStrval1());
                if(count($arrUrl)==4)
                {
                    $page['type']='Base_Navigation_Page_Mvc';
                    $page['module']=$arrUrl[1];
                    $page['controller']=$arrUrl[2];
                    $page['action']=$arrUrl[3];
                    $page['resource']=$page['module'].":".$page['controller'];
                    $page['privilege']=$page['action'];
                    
                    if($row->getStatus()==0)
                        $page['visible']=false;
                    else
                        $page['visible']=true;
                    
                    //check child tree
                    $modelC=new Security_Model_SystemMaster();
                     if($level==1 || $level==2)
                        $resultC=$modelC->fetchAll("master_code='fdMenu' and intval1='{$row->getMasterId()}'  and blnval2<>'1'");
                    else
                        $resultC=$modelC->fetchAll("master_code='fdMenu' and intval1='{$row->getMasterId()}'  ");
                    if(count($resultC)>0)
                    {
                        $arrC=$this->getMenuArray($row->getMasterId(),$request_uri,$level);
                        $page["pages"]=$arrC;
                    }
                    else {
                        unset($page["pages"]);
                    }
                    
                    
                }
//                else
//                {
//                    $page['type']='Base_Navigation_Page_Uri';
//                    $page['uri']=$row->getStrval1();
//                    if($request_uri==$row->getStrval1())
//                        $page['active']=true;
//                }
               
                
                
                
                
                $arr[]=$page;
            }
            return $arr;
        }
    }
    
    public function getContainer($request_uri)
    {
        $menu=$this->getMenuArray(0,$request_uri,0);
//        echo"<pre>";
//        print_r($menu);
//        exit;
        $container = new Zend_Navigation($menu);
        return $container;
    }
    
    public function getMenuItemByUri($uri)
    {
        $model=new Security_Model_SystemMaster();
        return $model->fetchRow("master_code='fdMenu' and strval1='$uri'");

    }
    
    public function  isBookMarked($menu_id)
    {
      $usersNs  =   new Zend_Session_Namespace("members");
      $user_id  =   $usersNs->userId;
      $model=new Security_Model_SystemMapping();
      $row=$model->fetchRow("map_code='fdUserBookmark' and map_id1='$user_id' and map_id2='$menu_id'"); 
      if (false===$row)
          return false;
      else
          return true;
      
    }
    
    public function  countBookmark($menu_id)
    {
      $usersNs  =   new Zend_Session_Namespace("members");
      $user_id  =   $usersNs->userId;
      $model=new Security_Model_SystemMapping();
      $rows=$model->getCount("map_code='fdUserBookmark' and map_id1='$user_id'"); 
      return $rows;
    }    
}