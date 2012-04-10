<?php
class Mps_Form_Buying extends Zend_Form
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
        $this->setName('incoming_cows');
		
       
//        $this->addElementPrefixPath('Base_Decorator',
//                            'Base/Decorator/',
//                            'decorator');
        
	  
        $model	=	new Admin_Model_Supplier();
        $arrGroup =	$model->getAllSuppliers(1);
        
       // print_r($arrGroup);die();
	$this->addElement('select', 'supplierId',array(
                'label'      => 'Select Supplier:',
		'id' => 'supplierId',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select Supplier.')))
            	),
        	'decorators' => $this->elementDecorators,
                'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrGroup
            
        ));
        
        
        
        
        
        //$arrSubgroup	=	array("0"=>"Sub Group");
	$this->addElement('text', 'noCows',array(
                'label'     => 'Select Number of Cows:',
		'id'        => 'noCows',
        	'class'     =>'spinbutton_input',
        	'required'  => false,
        	'validators'=> array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select number of Cows.')))
            	),
        	'decorators'=> $this->elementDecorators,
                
                'filters'   => array('StringTrim')
        	
        ));
        
        
        
	    // Add an first name element
        $this->addElement('text', 'description', array(
            'label'      => 'Antimortum Information:',
        	'class' =>'text-input medium-input',
            'required'   => true,
        	/* 'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter first name')))
            	), */
        	'decorators' => $this->elementDecorators,
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
