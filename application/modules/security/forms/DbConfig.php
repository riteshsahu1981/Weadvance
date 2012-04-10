<?php
class Security_Form_DbConfig extends Zend_Form
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
    public function init()
    {
       $this->setName('frmDbConfig');
       
       $model=new Security_Model_SysConfig();
       $configArray=$model->getConfigs();
	   $this->addElement('select', 'configId', array(
            'label'      => 'Config Field:',
            'autocomplete'=>"off",
            'class' =>'text-input medium-input',
            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Select Config Id'))),

            	),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'MultiOptions'=> $configArray
        ));
       
		
        $this->addElement('text', 'dbServerName', array(
            'label'      => 'Server Name :',
            'autocomplete'=>"off",
            'required'   => true,

            'class' =>'text-input medium-input',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter database server name'))),
            //  array('validator' => 'StringLength', 'options' => array(6, 20))

            )
        ));
        
        

	   
	    // Add an first name element
        $this->addElement('text', 'dbServerPort', array(
            'label'      => 'Server Port:',
            'class' =>'text-input medium-input',
            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter databse server port')))),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
       
        
        // Add an last name element
        $this->addElement('text', 'dbName', array(
            'label'      => 'Database Name:',
            'class' =>'text-input medium-input',
            'required'   => true,
            'decorators' => $this->elementDecorators,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter databse name name')))),
            'filters'    => array('StringTrim'),
        ));
        
        
        $this->addElement('text', 'dbUser', array(
            'label'      => 'DB Username:',
            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter database user')))),
            'class' =>'text-input medium-input',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
         $this->addElement('text', 'dbPassword', array(
            'label'      => 'DB Password:',
            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter databse password')))),
            'class' =>'text-input medium-input',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
         $this->addElement('select', 'dbTransType', array(    	
            'label'=>'Transection Type:',
            'class' =>'text-input small-input',
            'required'   => true,
            'decorators' => $this->elementDecorators,
            'MultiOptions'=>array(
            '0'=>"select",
            '1'=>"Insert",
            '2'=>"Update",
            '3'=>"Delete",),
            'value'=>"select"
            ));
            
       
         
        $this->addElement('select', 'status', array(
            'label'      => 'Status:',
            'class' =>'text-input medium-input',
            'decorators' => $this->elementDecorators,	
            'required'   => false,
            'MultiOptions'=>array(
            '0'=>"Inactive",
            '1'=>"Active",),
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
