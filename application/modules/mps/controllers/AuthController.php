<?php
class Mps_AuthController extends Base_Controller_Action
{
        
        public function preDispatch()
        { 
            parent::preDispatch();
            
            if (Zend_Auth::getInstance()->hasIdentity()) 
            { 
                if ('logout' != $this->getRequest()->getActionName()) 
                {       
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/app/dashboard'));
                   
                }
            } 
            else 
            { 
                if ('logout' == $this->getRequest()->getActionName()) 
                {
                    //$this->_flashMessenger->addMessage(array('success'=>'You have successfully logged out!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/auth/login'));    
                }
            }
        }
        
	public function indexAction()
	{
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/auth/login'));
	}
        
        public function loginAction()
	{ 
            
            $this->view->pageHeading='Sign in to your Account';
            $request = $this->getRequest();
            
            $this->view->form=$form=new Application_Form_Login();
            $elements=$form->getElements();
            $form->clearDecorators();

            foreach($elements as $element)
            {
                $element->removeDecorator('label');
                $element->removeDecorator('Errors');
            }   
            if ($request->isPost())
            {
                if($form->isValid($request->getPost()))
                {
                   
                    $params=$request->getParams();
                    $Auth = new Base_Auth_Auth();
                    $Auth ->doLogout();
                    $loginStatusEmail=true;
                    $loginStatusUsername=true;

                    $loginStatusEmail=$Auth->doLogin($params, 'email');
                    if($loginStatusEmail==false)
                        $loginStatusUsername=$Auth->doLogin($params, 'username');



                    if ($loginStatusEmail==false && $loginStatusUsername==false) 
                    {
                        $this->_flashMessenger->addMessage(array('error'=>'Invalid credentials! Please try again.'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/auth/login'));
                    }
                    else
                    {				
                       $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/app/dashboard'));
                    }
                }
                else
                {
                    $this->view->email_msg=array_pop($form->getMessages('email'));
                    $this->view->password_msg=array_pop($form->getMessages('password'));
                    $this->_flashMessenger->addMessage(array('error'=>'Invalid credentials! Please try again.'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/auth/login'));
                }
            }
            
            
	}
        
    public function logoutAction()
    {
    	$Auth=new Base_Auth_Auth();
        $Auth->doLogout();
        //$Auth->forgotMe('rememberMe');
        $this->_flashMessenger->addMessage(array('success'=>'You have successfully logged out.'));
        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/auth/login'));
      
    }
    
    public function forgotPasswordAction()
    {
        $this->view->pageHeading="Forgot your Password?";
            $request = $this->getRequest();
            
            $this->view->form=$form=new Application_Form_Login();
            $elements=$form->getElements();
            $form->clearDecorators();

            foreach($elements as $element)
            {
                $element->removeDecorator('label');
                $element->removeDecorator('Errors');
            }   
            $form->removeElement('password');
            if ($request->isPost())
            {
                $this->view->pageHeading="Sent Password";
                 $this->view->msg="Your Password has been reset and sent to your email address.";
//                if($form->isValid($request->getPost()))
//                {
//                    $params=$request->getParams();
//                    $user=new Application_Model_User();
//                    $user=$user->fetchRow("email='{$params['email']}'");
//                    if($user)
//                    {
//                        $auth=new Base_Auth_Auth();
//                        $auth->recoverPassword($user);
//                        $this->_flashMessenger->addMessage(array('success'=>'Your password has been reset. Please check your email.'));
//                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/index/login'));
//                    }
//                    else
//                    {
//                        $this->_flashMessenger->addMessage(array('error'=>"Invalid email address!"));
//                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/index/forgot-password'));
//                    }
//                    
//                }
//                else
//                {
//                    $this->view->email_msg=array_pop($form->getMessages('email'));
//                }
            }
    }
    
    

}//end of class
