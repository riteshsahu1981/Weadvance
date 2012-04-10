<?php
class Base_View_Helper_FlashMessages extends Zend_View_Helper_Abstract
{
	public function flashMessages()
	{
                $cdnUri =  new Base_View_Helper_CdnUri();
		$messages = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->getMessages();
		$output = '';
                $id="";
		if (!empty($messages)) {
			
			foreach ($messages as $message) {
                            
                            $id=key($message)."_box";
				$output .= '<div id="' . key($message) . '_box"  class="' . key($message) . '_box">';
                                $output .= '<img class="error" src="'.$cdnUri->cdnUri().'/images/'.key($message).'_box_img.png" alt="" />';
                                $output .=' <p>' . current($message) . '</p>';
                                $output .= '<img class="close" src="'.$cdnUri->cdnUri().'/images/'.key($message).'_box_close.png" alt="" />';
                                $output .= '</div>';
			}
			
		}
                $output.=<<<EOD
<script language="javascript">
       Flash_DelayedHide("{$id}");
</script>    
EOD;
		return $output;
	}
}
?>