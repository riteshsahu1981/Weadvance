<?php
class Security_Form_SysConfig extends Zend_Form
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
        $this->setName('frmConfiguration');
        $model	=	new Security_Model_SysConfig();
        
        $arrLogs=$model->getConfigs();
        
     
	$this->addElement('select', 'parentConfigId',array(
            'label'      => 'Parent Config Id:',
			
        	'required'   => false,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            	'MultiOptions'=>$arrLogs
        ));
	   
	   $this->addElement('text', 'configName', array(
            'label'      => 'Config Name:',
            'autocomplete'=>"off",
            

            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Configuration Name'))),
           /* array('Db_NoRecordExists', true, array(
            'table' => 'config',
            'field' => 'config_name',
            'messages'=>'Config Name already exists'
            ))*/
            ),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
            $this->addElement('textarea', 'configDesc', array(
            
            'label'      => 'Config Desc:',
            'autocomplete'=>"off",
            'rows'=>5,
                'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please Enter Config Description.')))
            	),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
             $this->addElement('text', 'param1', array(
            'label'      => 'Param1:',
            'autocomplete'=>"off",
            
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
              $this->addElement('text', 'param2', array(
            'label'      => 'Param2:',
            'autocomplete'=>"off",
            
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
               $this->addElement('text', 'param3', array(
            'label'      => 'Param3:',
            'autocomplete'=>"off",
            
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
                $this->addElement('text', 'param4', array(
            'label'      => 'Param4:',
            'autocomplete'=>"off",
            
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
            $this->addElement('text', 'param5', array(
            'label'      => 'Param5:',
            'autocomplete'=>"off",
            
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
