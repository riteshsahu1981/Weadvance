<?php
class Admin_Form_Supplier extends Zend_Form
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
        $this->setName('supplier_create');
		
       
//        $this->addElementPrefixPath('Base_Decorator',
//                            'Base/Decorator/',
//                            'decorator');
        
	  
           
	   $this->addElement('text', 'username', array(
            'label'      => 'Username:',
        	'autocomplete'=>"off",
        	'class' =>'required',
        	
                'required'   => true,
         	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter username'))),
                	array('Db_NoRecordExists', true, array(
        			'table' => 'supplier',
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
        	
        	'class' =>'required',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
        		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter password'))),
                array('validator' => 'StringLength', 'options' => array(6, 20))

            )
        ))
         ->getElement('password')
        ->addValidator('IdenticalField', false, array('c_password', 'Confirm Password'));

            // Add an password element
        $this->addElement('password', 'c_password', array(
            'label'      => 'Confirm Password:',
            'required'   => true,
        	
        	'class' =>'required',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(6, 20))
            )
        ));

            // Add an password element
        

	 
            // Add an Organization name element
        $this->addElement('text', 'orgName', array(
            'label'      => 'Organization Name:',
        	'class' =>'required',
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Organization name')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
	    // Add an first name element
        $this->addElement('text', 'firstName', array(
            'label'      => 'First Name:',
        	'class' =>'required',
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter first name')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
       
        
        // Add an last name element
        $this->addElement('text', 'lastName', array(
            'label'      => 'Last Name:',
        	'class' =>'required',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter surname')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an Address1 element
        $this->addElement('text', 'address1', array(
            'label'      => 'Address1:',
        	'class' =>'required',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter surname')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an Address2 element
        $this->addElement('text', 'address2', array(
            'label'      => 'Address2:',
        	'class' =>'required',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter surname')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an City element
        $this->addElement('text', 'city', array(
            'label'      => 'City:',
        	'class' =>'required',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter surname')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an State element
        $this->addElement('text', 'state', array(
            'label'      => 'State:',
        	'class' =>'required',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter surname')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        
        // Add an Zip element
        $this->addElement('text', 'zip', array(
            'label'      => 'Zip:',
        	'class' =>'required',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter surname')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an Phone element
        $this->addElement('text', 'phone', array(
            'label'      => 'Phone:',
        	'class' =>'required number',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter surname')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an Fax element
        $this->addElement('text', 'fax', array(
            'label'      => 'Fax:',
        	'class' =>'required number',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter surname')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        
        $this->addElement('text', 'email', array(
            'label'      => 'Email:',
        	'required'   => true,
            'validators' => array(
                    array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter email'))),
					array('EmailAddress',true, array('messages'=>array('emailAddressInvalidFormat'=>'Invalid email address format')))
              
            	),
        	'class' =>'required email',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
        
        $model	=	new Admin_Model_Supplier();
        //$model	=	new Base_Security_Privilege();
        //$arrGroup=	$model->getGroupArray();
        $quicksupplier =	$model->getquickSupplier();
        
        if($quicksupplier)
            $checked = true;
        else
            $checked = false;
        
        $this->addElement('checkbox', 'quickSupplier', array(
            'label'      => 'Quick Supplier:',
            'id'         => 'quickSupplier',
            'checked'    => $checked,
            'required'   => true,
            
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
        
        	
      $this->addElement('submit', 'submit', array(
            'required' => false,
      		'class' =>'button',
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
