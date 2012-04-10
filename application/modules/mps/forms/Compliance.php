<?php
class Mps_Form_Compliance extends Zend_Form
{
   public $elementDecorators = array('ViewHelper',
        array('Errors', array('class'=>'input-notification-ul-li error png_bg')),
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
        array('Label', array('tag' => 'td')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    );

    public $buttonDecorators = array('ViewHelper',
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
        $this->setName('frmC');
     
	  
           
        $model	=	new Base_Security_Privilege();
        
        $this->addElement('text', 'cowid', array(
            'label'      => 'Cow ID:',
            'class' =>'text-input medium-input',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        $arrSuplier  =   $model->getSupplier();
        $this->addElement('select', 'supplier',array(
            'label'      => 'Select Supplier:',
            'id' => 'type',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'MultiOptions'=>$arrSuplier
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
