<?php
class Security_Form_SysMessage extends Zend_Form
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
        $this->setName('frmMessage');
        
        $model	=	new Security_Model_SysMessage();
        $arrCategories=	$model->getCategoryArray();
        $this->addElement('select', 'categoryId',array(
            'label'      => 'Category Id:',
			
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select Category.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrCategories
        ));
       
        $arrSevirities=	$model->getSeverityArray();
       $this->addElement('select', 'severityId',array(
            'label'      => 'Severity Id:',
			
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select Severity.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrSevirities
        ));
       
        $arrTypes=	$model->getTypeArray();
       $this->addElement('select', 'typeId',array(
            'label'      => 'Type Id:',
			
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select type.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrTypes
        ));
	   
	   $this->addElement('text', 'userMessage', array(
            'label'      => 'User Message:',
            'autocomplete'=>"off",
            

            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter user message'))),
            ),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
           $this->addElement('text', 'sysMessage', array(
            'label'      => 'System Message:',
            'autocomplete'=>"off",
            

            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter System'))),
            ),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
          	
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
