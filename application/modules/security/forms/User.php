<?php
class Security_Form_User extends Zend_Form
{
   public $elementDecorators = array(
        'ViewHelper',
        array('Errors', array('class'=>'input-notification-ul-li error png_bg')),
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
        array('Label', array('tag' => 'td')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    );

    public $buttonDecorators = array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
        array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    );
  

    public $fileDecorators =array( 
    array('File'), 
       array('Errors', array('class'=>'input-notification-ul-li error png_bg')),
    array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
    array('Label', array('tag' => 'td')),
    array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
);

    
    
    public function init()
    {
            	
        $this->addElementPrefixPath('Base_Validate', 'Base/Validate/', 'validate');
        $this->setName('frmRegistration');
	    
	   $this->addElement('text', 'username', array(
            'label'      => 'Username:',
        	'autocomplete'=>"off",
        	
        	
                'required'   => true,
         	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter username'))),
                	array('Db_NoRecordExists', true, array(
        			'table' => 'user',
	       			'field' => 'username',
	       			'messages'=>'username already exists'
	    			))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
       
		
		
        $this->addElement('password', 'password', array(
            'label'      => 'Password:',
            'autocomplete'=>"off",
            'required'   => true,
        	
        	
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
        		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter password'))),
                array('validator' => 'StringLength', 'options' => array(6, 20))

            )
        ))
         ->getElement('password')
        ->addValidator('IdenticalField', false, array('confirmPassword', 'Confirm Password'));

            // Add an password element
        $this->addElement('password', 'confirmPassword', array(
            'label'      => 'Confirm Password:',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(6, 20))
            )
        ));

            // Add an password element
        

	   
	    // Add an first name element
        $this->addElement('text', 'firstName', array(
            'label'      => 'First Name:',
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter first name')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('text', 'lastName', array(
            'label'      => 'Last Name:',
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter last name')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
        
        
        $this->addElement('text', 'organizationName', array(
            'label'      => 'Organization Name:',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter organization name')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('text', 'address1', array(
            'label'      => 'Address1:',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter address')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        
        $this->addElement('text', 'address2', array(
            'label'      => 'Address2:',
            
        	'decorators' => $this->elementDecorators,
        
            'filters'    => array('StringTrim'),
        ));
        
        
        $this->addElement('text', 'city', array(
            'label'      => 'City:',
            
                'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter city')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('text', 'state', array(
            'label'      => 'State:',
            
                'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter state')))
            	),
            'filters'    => array('StringTrim'),
        ));
        $this->addElement('text', 'zip', array(
            'label'      => 'Zip:',
            
                'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter zip')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        
        $this->addElement('text', 'phone', array(
            'label'      => 'Phone:',
            
                'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter phone')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('text', 'fax', array(
            'label'      => 'Fax:',
            
                'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter fax')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        
        
        
        $this->addElement('text', 'email', array(
            'label'      => 'Email Address:',
        	'required'   => true,
            'validators' => array(

                    array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter email'))),
					array('EmailAddress',true, array('messages'=>array('emailAddressInvalidFormat'=>'Invalid email address format')))
              
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
        
        
         $this->addElement('text', 'dob', array(
            'label'      => 'Date of Birth:',
        	'required'   => false,
            'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter dob')))
            	),
           'readonly' =>'true',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
         
         
         $this->addElement('select', 'sex', array(    	
        'label'=>'Gender:',
         'required'   => true,
         'decorators' => $this->elementDecorators,
    	'MultiOptions'=>array(
        'male'=>"Male",
        'female'=>"Female",
		),
        'value'=>"male"
  		));
       
        $model	=	new Base_Security_Privilege();
        $arrGroup=	$model->getGroupArray();
       // print_r($arrGroup);die();
	$this->addElement('select', 'groupId',array(
            'label'      => 'Group:',
			'id' => 'groupId',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select user group.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrGroup,
            'onchange' => 'getSubGroups()'
        ));
        
        
        $arrSubgroup	=	array(""=>"Sub Group");
	$this->addElement('select', 'subGroupId',array(
            'label'      => 'Sub Group:',
			'id' => 'subGroupId',


        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select Subgroup.')))
            	),
        	'decorators' => $this->elementDecorators,
                'onchange' => 'getRoles()',
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrSubgroup
        ));
        
        
        
        $arrUserRole	=	array(""=>'Roles');
	$this->addElement('select', 'roleId',array(
            'label'      => 'User Role:',
			'id' => 'roleId',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select user Role.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrUserRole
        ));
        
        
        $user=new Security_Model_User();
        
        $arrSupervisor	=	$user->getAllUsers();
	$this->addElement('select', 'supervisorId',array(
            'label'      => 'Supervisor:',
			'id' => 'supervisorId',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select user Supervisor.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrSupervisor
        ));
       
         
//        $this->addElement('text', 'mobile', array(
//            'label'      => 'Mobile Number:',     	
//        	'decorators' => $this->elementDecorators,	
//            'required'   => false,
//            'filters'    => array('StringTrim'),
//        ));   
        
        
        
        
        
//        $this->addElement('file', 'profilePicture', array(
//            'class' =>'text-input medium-input',
//        	'label'      => 'Profile Picture:',
//            'required'   => false,
//        	'decorators' => $this->fileDecorators,
//        ));
//        $this->getElement('profilePicture')->addValidator('Size', false, 1024*1024*5); //2 MB file is allowed
//        $this->getElement('profilePicture')->getValidator('Size')->setMessages(array("fileSizeTooBig"=>"Maximum allowed file size is 5 MB.","fileSizeTooSmall"=>""));
//        $this->getElement('profilePicture')->addValidator('Extension', false, 'jpg,jpeg,png,gif');
//        $this->getElement('profilePicture')->getValidator('Extension')->setMessages(array("fileExtensionFalse"=>"Please upload jpg,jpeg,png,gif file.","fileExtensionNotFound"=>""));
//		
//		
//			
		
        
//        $this->addElement('select', 'status',array(
//            'label'      => 'Status:',
//			'id' => 'status',
//        	'required'   => true,
//        	'validators' => array(
//                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select status.')))
//            	),
//        	'decorators' => $this->elementDecorators,
//                'filters'    => array('StringTrim'),
//        	'MultiOptions'=>array("active"=>"Active","inactive"=>"Inactive")
//        ));
//        
		
      $this->addElement('submit', 'submit', array(
            'required' => false,

            'ignore'   => true,
            'label'    => 'Submit',
          'value'=>'submit',
			'decorators' => $this->buttonDecorators,
        ));
              	              
    }
    
	public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
            'Form',
        ));
    }
}
