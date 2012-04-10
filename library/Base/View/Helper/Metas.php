<?php
class Base_View_Helper_Metas extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function metas($param)
	{
		/*--- Requested Module ------*/
		$module=$this->view->module;
		/*-----------------------------------*/

		/*---- Requested Action -------*/
		$actionName=$this->view->actionName;
		/*-----------------------------------*/

		/*---- Requested Controller -------*/
		$controllerName=$this->view->controllerName;
		/*-----------------------------------*/

		
                $this->view->headTitle("D-S Dale T.Smith & Sons - Meat Packaging Company");
                //$this->view->headMeta()->appendName("ROBOTS","NOINDEX, NOFOLLOW");
                //$this->view->headMeta()->appendName("description","D-S Dale T.Smith & Sons - Meat Packaging Company");
                ///$this->view->headMeta()->appendName("keywords","D-S Dale T.Smith & Sons - Meat Packaging Company");
                 $this->view->headMeta()->appendName("viewport", "width=device-width; initial-scale=1.0");
                 $this->view->headMeta()->appendName("apple-mobile-web-app-capable", "yes");
                 $this->view->headMeta()->appendHttpEquiv("X-UA-Compatible", "IE=edge,chrome=1");
                 $this->view->headMeta()->setCharset("utf-8");
                 
                 

		
	}//end of function
	
	public function setView(Zend_View_Interface $view)
	{
		$this->view = $view;
	}	
}
