<?php
class Security_Form_WorkflowDetail extends Zend_Form
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
        
        $model	=	new Security_Model_WorkflowMaster();
        $arrWorkflow=	$model->getWorkflowArray();
       // print_r($arrGroup);die();
	$this->addElement('select', 'workflowId',array(
                'label'      => 'Workflow:',
		'id' => 'workflowId',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select workflow.')))
            	),
        	'decorators' => $this->elementDecorators,
                'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrWorkflow,
            
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
