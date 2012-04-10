<?php
class Admin_Form_Customer extends Zend_Form
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
        $this->setName('create_customer');
		
       
//        $this->addElementPrefixPath('Base_Decorator',
//                            'Base/Decorator/',
//                            'decorator');
        
	  
           
	   $this->addElement('text', 'orgName', array(
            'label'      => 'Organization Name:',
        	'autocomplete'=>"off",
        	'class' =>'required',
        	
                'required'   => true,
         	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Organization name'))),
                	
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
       
		
		
        
        
	    // Add an first name element
        $this->addElement('text', 'firstName', array(
            'label'      => 'First Name:',
        	'class' =>'required',
            'onkeyup' =>'copy_shipping_to_billing(this);',
            
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
            'onkeyup' =>'copy_shipping_to_billing(this);',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter surname')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an Address1 element
        $this->addElement('text', 'address', array(
            'label'      => 'Address:',
        	'class' =>'required',
            'onkeyup' =>'copy_shipping_to_billing(this);',
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
            'onkeyup' =>'copy_shipping_to_billing(this);',
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
            'onkeyup' =>'copy_shipping_to_billing(this);',
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
            'onkeyup' =>'copy_shipping_to_billing(this);',
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
            'label'      => 'Phone Number:',
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
        
        $this->addElement('checkbox', 'sameBilling', array(
            'label'      => 'Billing Address:',
            'id'         => 'sameBilling',
            'required'   => true,
            'checked'    => true,
            'onclick'    => "billing_shipping_same_fun(this);",
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
        
        
        
        
         
        
        $this->addElement('text', 'bFirstName', array(
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
        $this->addElement('text', 'bLastName', array(
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
        $this->addElement('text', 'bAddress', array(
            'label'      => 'Address:',
        	'class' =>'required',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter surname')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        
        
        // Add an City element
        $this->addElement('text', 'bCity', array(
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
        $this->addElement('text', 'bState', array(
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
        $this->addElement('text', 'bZip', array(
            'label'      => 'Zip:',
        	'class' =>'required',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter surname')))
            	),
            'filters'    => array('StringTrim'),
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
