<?php
class Base_View_Helper_Puts extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function puts($string)
	{
             $translate=Zend_Registry::get('translate');
             $string=$translate->_($string);
             
		return $string;
	}
	
	public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }
	
}