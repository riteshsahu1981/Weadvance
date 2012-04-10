<?php
class Admin_Form_Location extends Zend_Form
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
	
	public $elementDecoratorsRadio = array(
        'ViewHelper',
        array('Errors', array('class'=>'input-notification-ul-li error png_bg')),
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element radio')),
        array('Label', array('tag' => 'td')),
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
        $this->setName('location_create');
		
        // Add  Location title element
        $this->addElement('text', 'title', array(
            'label'      => 'Location Title:',
			'autocomplete'	=>'off',
        	'class' =>'required',
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Location Title')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
	    // Add Description element
        $this->addElement('textarea', 'description', array(
            'label'      => 'Description:',
			'rows'			=> '5',
        	'class' =>'required',
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter description')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
       
        
        // Add weight element
        $this->addElement('text', 'weight', array(
            'label'      => 'Total Weight:',
        	'class' =>'required',
			'autocomplete'	=>'off',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter weight')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add Active element
		$arrIsActive	=	array("1"=>"Yes", "0"=>"No");
		$this->addElement('radio', 'status',array(
            'label'      => 'Is Active ?',
        	'required'   => false,
        	'decorators' => $this->elementDecoratorsRadio,
                
            'separator' =>'',
            'disableLoadDefaultDecorators' => true,
        	'MultiOptions'=>$arrIsActive,
            'value'=>'1'
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
