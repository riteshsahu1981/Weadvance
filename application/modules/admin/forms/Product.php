<?php
class Admin_Form_Product extends Zend_Form
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
        $this->setName('product_create');
           

        
        $this->addElement('select', 'caseFormat', array(    	
        'label'=>'Case Format:',
         'required'   => true,
         'decorators' => $this->elementDecorators,
    	'MultiOptions'=>array(
        'BlackOutBug'=>"BlackOutBug",
        'JulianDateOnly'=>"JulianDateOnly",
        'Packed+Julian'=>"Packed+Julian",
        'Packed Date Only'=>"Packed Date Only",
        'pork'=>"pork",
            
                ),
        'value'=>"BlackOutBug"
  		));
       
		
        // add Label/Case
        $this->addElement('text', 'labelCase', array(
            'label'      => 'Label/Case:',
            'class' =>'required',
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Label/Case')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
         

        // Add an Product Identifier
        $this->addElement('text', 'productIdentifier', array(
            'label'      => 'Product Identifier:',
            'class' =>'required',
            
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Product Identifier')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));

        //Pack location multiple dropdown
        $model	=	new Admin_Model_Location();
        $arrGroup=	$model->getLocationArray();
        
//       $this->addElement('select', 'packLocation', array(    	
//        'label'=>'Pack Location:',
//            'class' =>'s1',
//            'multiple' =>'multiple',
//         'required'   => true,
//         'decorators' => $this->elementDecorators,
//    	'MultiOptions'=>$arrGroup,
//        'value'=>"Bone"
//  		)); 
        
        
         $this->addElement('multiselect', 'packLocation', array(    	
        'label'=>'Pack Location:',
          'class' =>'s1',
         'required'   => true,
         'decorators' => $this->elementDecorators,
    	'MultiOptions'=>$arrGroup,
        
  		)); 
	 
            // Add an Part Numebr
        $this->addElement('text', 'partNumber', array(
            'label'      => 'Part Number:',
        	'class' =>'required',
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Part number')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
	    // Add an Sell by days
        $this->addElement('text', 'sellByDays', array(
            'label'      => 'Sell By Days:',
        	'class' =>'required',
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter sell by days')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
       
        
        // Add an Price/lb ($)
        $this->addElement('text', 'priceLb', array(
            'label'      => 'Price/Lb ($):',
        	
           
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Price/lb($)')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an Pallet ID
        $this->addElement('text', 'palletId', array(
            'label'      => 'Pallet ID:',
        	
            
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Pallet ID')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an Des Line 4
        $this->addElement('text', 'desLine1', array(
            'label'      => 'Des. Line #1:',
        	
           
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Des Line 1')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an Des Line 2
        $this->addElement('text', 'desLine2', array(
            'label'      => 'Des. Line #2:',
        	
           
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Des Line 2')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an Des Line 3
        $this->addElement('text', 'desLine3', array(
            'label'      => 'Des. Line #3:',
        	
            
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Des Line 3')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        
        // Add an Des Line 4
        $this->addElement('text', 'desLine4', array(
            'label'      => 'Des. Line #4:',
        	
            
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Des Line 4')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an Lower Weight
        $this->addElement('text', 'lowerWeight', array(
            'label'      => 'Lower Weight:',
        	'class' =>'required',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Lower Weight')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an Fixed Weight
        $this->addElement('text', 'fixedWeight', array(
            'label'      => 'Fized Weight:',
        	'class' =>'required',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Fixed Weight')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an Heigh Weight
        $this->addElement('text', 'heighWeight', array(
            'label'      => 'Heigh Weight:',
        	'class' =>'required',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Heigh weight')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        // Add an Tare Weight element
        $this->addElement('text', 'tareWeight', array(
            'label'      => 'Tare Weight:',
        	'class' =>'required',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Tare Weight')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        
        // Add an Radio Required Application
        $this->addElement('radio', 'requiredApp', array(    	
        'label'=>'Required Application:',
         'required'   => true,
         'decorators' => $this->elementDecorators,
    	'MultiOptions'=>array(
        "Print all Random Weight"=>"Print all Random Weight",
        "Print Random Wts.within limits"=>"Print Random Wts.within limits"
                ),
         'value'=>'Print all Random Weight'
        
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
