<?php
class Security_Form_Menu extends Zend_Form
{
   public $elementDecorators = array(
        'ViewHelper',
        array('Errors', array('class'=>'input-notification-ul-li error png_bg')),
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
        array('Label', array('tag' => 'td')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    );
    public $elementDecoratorsRadio = array(
        'ViewHelper',
        array('Errors', array('class'=>'input-notification-ul-li error png_bg')),
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element radio')),
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
        
        $this->setName('frmMenu');
           
	 
        $this->addElement('text', 'title', array(
            'label'      => 'Title:',
        	
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter menu title')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
       
        
        //$validator = new Zend_Validate_Regex(array('pattern' => '/^\/[a-z\-]+\/[a-z\-]+\/[a-z\-]+$/'));
        
        $this->addElement('text', 'path', array(
            'label'      => 'Path:',
        	
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter path.'))),
                        array('Regex', true, array("pattern"=>'/^\/[a-z\-]+\/[a-z\-]+\/[a-z\-]+$/',
                            'messages'=>array('regexNotMatch'=>"Please enter path in '/module/controller/action' pattern.")))
            	),
            'filters'    => array('StringTrim'),
        ))
        //->getElement("path")->addValidator($validator)
        
        ;
        
        
        $this->addElement('text', 'toolTip', array(
            'label'      => 'Tooltip:',
            'required'   => false,
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        $this->addElement('text', 'menuIcon', array(
            'label'      => 'Menu Icon:',
            'readonly'  =>   'true',
            'required'   => false,
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));        
        
        $menu=new Base_Security_Menu();
        $arrMenuItems=$menu->getMenuItemsArray();
	$this->addElement('select', 'parentMenuId',array(
            'label'      => 'Parent Menu:',
            'required'   => false,
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'MultiOptions'=>$arrMenuItems
        ));
	
        
        $arrIsActive	=	array("1"=>"Yes", "0"=>"No");
	$this->addElement('radio', 'isActive',array(
                'label'      => 'Is Active ?',
		
        	'required'   => false,
        	'decorators' => $this->elementDecoratorsRadio,
                
                'separator' =>'',
                'disableLoadDefaultDecorators' => true,
        	'MultiOptions'=>$arrIsActive,
                'value'=>'1'
        ));
        
        $arrIsChild	=	array("1"=>"Yes", "0"=>"No");
	$this->addElement('radio', 'isChild',array(
                'label'      => 'Is Child ?',
		
        	
        	'required'   => false,
        	'decorators' => $this->elementDecoratorsRadio,
                
                'separator' =>'',
                'disableLoadDefaultDecorators' => true,
        	'MultiOptions'=>$arrIsChild,
                'value'=>'0'
        ));
        
        $arrIsAction	=	array("1"=>"Yes", "0"=>"No");
	$this->addElement('radio', 'isAction',array(
                'label'      => 'Is Action ?',
		
        	
        	'required'   => false,
        	'decorators' => $this->elementDecoratorsRadio,
                
                'separator' =>'',
                'disableLoadDefaultDecorators' => true,
        	'MultiOptions'=>$arrIsAction,
                'value'=>'0'
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
