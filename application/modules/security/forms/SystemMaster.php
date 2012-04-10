<?php
class Security_Form_SystemMaster extends Zend_Form
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
        $this->setName('addSystemMaster');
		
        // Add Master Code element
        $this->addElement('text', 'masterCode', array(
            'label'      => 'Master Code:',
            'autocomplete'	=>'off',
            'class' =>'required',
            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Master Code')))
            ),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
	    // Add Master Name element
        $this->addElement('text', 'masterValue', array(
            'label'      => 'Value Text:',
            'class' =>'required',
            'autocomplete'	=>'off',
            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Master Name')))
            ),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
       
        // Add Control Type
	$control=new Base_Security_SystemMaster();
        $arrControlItems=$control->getControlItemsArray();
		
	//$arrControlItems=array('select'=>'Drop down','RadioButton'=>'Radio Button','CheckBox'=>'Check Box');
     /*   $this->addElement('select', 'intval1', array(
            'label'      => 'Control Type:',
            'class' =>'required',
            'autocomplete'	=>'off',
            'required'   => true,
            'decorators' => $this->elementDecorators,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select Control Type')))
            ),
            'filters'    => array('StringTrim'),
            'MultiOptions'=>$arrControlItems
        ));
       */ 
        
		
        // Add an Active element
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
            'FormElements',array('HtmlTag', array('tag' => 'table')),
            'Form',
        ));
    }
}
