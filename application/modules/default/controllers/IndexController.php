<?php
class IndexController extends Base_Controller_Action
{
    public function indexAction()
    {
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/auth/login'));
    }
    
}//end of class
