<?php
class Base_View_Helper_Sort extends Zend_View_Helper_Abstract
{
	
	public function sort($colname,$options='')
        {
           
            
            $url="/".$this->view->module."/".$this->view->controllerName."/".$this->view->actionName;
            $params=$this->view->params;
               
            
            if(isset($params['col']) && $params['col']==$colname && $params['order']=="asc")
            {
                $url.="/col/".$colname."/order/desc";
            }
            else if(isset($params['col']) && $params['col']==$colname && $params['order']=="desc")
            {
                $url.="/col/".$colname."/order/asc";
            }
            else
            {
                $url.="/col/".$colname."/order/desc";
            }
            
            
            foreach($options as $k=>$v)
            {
                $url.="/".$k."/".$v;
            }
            
            $seoUrl=new Base_View_Helper_SeoUrl();
            $url=$seoUrl->seoUrl($url);
            
            $cdnUri=new Base_View_Helper_CdnUri();
            
            
            if(isset($params['col']) && $params['col']==$colname && $params['order']=="desc")
            {
                $arrowImage=$cdnUri->cdnUri()."/images/arrow.gif";
            }
            else if(isset($params['col']) && $params['col']==$colname && $params['order']=="asc")
            {
                $arrowImage=$cdnUri->cdnUri()."/images/arrow_up.gif";
            }
            else 
            {
                $arrowImage=$cdnUri->cdnUri()."/images/arrow.gif";
            }
            
            $str="<a href='{$url}'>";
            $str.="<img src='{$arrowImage}' align='right' alt='' />";
            $str.="</a>";
            return $str;
	}
}