<?php
class Base_Security_Action 
{
    public function getActions($status=1)
    {
        $model=new Security_Model_SystemMaster();
        return $model->fetchAll("status='{$status}' and master_code='fdAction'");
    }
    
    public function getActionArray($status=1)
    {
        $arr=array(""=>"--Select--");
        $actions=$this->getActions($status);
        foreach($actions as $_action)
        {
            $arr[$_action->getMasterId()]=$_action->getMasterValue();
        }
        return $arr;
    }
    
    public function getFullActionTree()
    {

        $str='<div id="action_tree" class="demo">';
        $str.="<ul>";
        $str.='<li id="noderoot_0" rel="root">';
        $str.="<a href='#'>All</a>";
        $str.=$this->getActionTree(0);
        $str.="</li>";
        $str.="</ul>";
        $str.="</div>";
        
        $str.=<<<EOT

            <script language="javascript">

function customMenu(node) {
    
    var items = {   
        renameItem: { 
            label: "Rename",
            action: function (node) { this.rename(node);}
        },
        deleteItem: { 
            label: "Delete",
            action: function (node) {   if(this.is_selected(node)) { this.remove(); } else { this.remove(node); }  }
        },
        createItem: { 
            label: "Create",
            action: function (node) {this.create(node);}
        }
    };

    if ($(node).attr( 'rel' )=="root") {
        
        items.deleteItem._disabled = true;
        items.renameItem._disabled = true ;      
        items.createItem.label= "Create Action"; 

    }
    else
    {
        delete items.createItem; 
 
        
    }

    return items;
}

            $(function () {
                    $("#action_tree").jstree({ 
                            "core" : { "initially_open" : [ "noderoot_0"] },
                            "plugins" : [ "themes", "html_data", "ui", "crrm", , "types" ,"hotkeys", "checkbox", "contextmenu"],
                            'contextmenu' : { 'items' : customMenu    },
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
                                            "action" : {
                                                    "icon" : {"image" : "/js/tree/themes/default/file.png" },
                                                    "max_depth" : 2,
                                                    "hover_node" : false,
                                                    "valid_children" : "none"

                                            },
                                            "default" : {
                                                    "icon" : {"image" : "/js/tree/themes/default/file.png" },
                                                    "max_depth" : 2,
                                                    "hover_node" : false,
                                                    "valid_children" : "none"
                                            }
                                    }
                                },
                                
                            "checkbox" : {
                                real_checkboxes : true 
                                           }

                    })
                    .bind("create.jstree", function (e, data) {
              
                                $.post(
                                        "/security/action/create", 
                                        { 
                                            "parent_node_id" : data.rslt.parent.attr("id"), 
                                            "node_title" : data.rslt.name
                                        }, 
                                        function (r) {
                                                if(r.status) 
                                                    $(data.rslt.obj).attr("id", r.node_id);
                                                else 
                                                    $.jstree.rollback(data.rlbk);

                                        },"json"
                                );
                        })
                        .bind("rename.jstree", function (e, data) {

                                $.post(
                                        "/security/action/rename", 
                                        { 
                                                "node_id" : data.rslt.obj.attr("id"), 
                                                "node_title" : data.rslt.new_name
                                        }, 
                                        function (r) {
                                                if(!r.status) {
                                                        $.jstree.rollback(data.rlbk);
                                                }
                                        },"json"
                                );
                        })
                    .bind("remove.jstree", function (e, data) {

                                data.rslt.obj.each(function () {                  
                                        $.ajax({
                                                async : false,
                                                type: 'POST',
                                                url: "/security/action/remove", 
                                                data : { 
                                                        "child_node_id" : this.id,
                                                        "parent_node_id" : data.rslt.parent.attr('id')
                                                }, 
                                                success : function (r) {
                                                        if(!r.status) {
                                                                //data.inst.refresh();
                                                        }
                                                }
                                        });
                                });
                        })
                   
                    ;


            });
            </script>
EOT;
        
        return $str;
    }
    
    public function getActionTree($parent_id)
    {
        $model=new Security_Model_SystemMaster();
        $result=$model->fetchAll("master_code='fdAction' and intval1='$parent_id'");
        
        $str="";
        if(count($result)>0)
        {
            $str.="<ul>";
            foreach($result as $row)
            {
                $str.=" <li id='fdAction_{$row->getMasterId()}' rel='action' >";
                $str.="     <a href='{$row->getStrval1()}'>{$row->getMasterValue()}</a>";
                //check child tree
                    $modelC=new Security_Model_SystemMaster();
                    $resultC=$model->fetchAll("master_code='fdAction' and intval1='{$row->getMasterId()}'");        
                    if(count($resultC)>0)
                    {
                        //has childs
                        $str.=$this->getActionTree($row->getMasterId());
                    }
                $str.=" </li>";
            }
            $str.="</ul>";
            return $str;
        }
    }
}