<?php
class Mps_IndexController extends Base_Controller_Action
{
    public function indexAction()
    {
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/app/dashboard'));
    }
    
}//end of class
