<?php
class Mps_AppController extends Base_Controller_Action
{
    public function indexAction()
    {
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/mps/app/dashboard'));
    }
    public function testAction()
    {
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout->setLayout("test");
            $this->view->pageHeading="Test";
    }
    public function dashboardAction()
    {
        //Start Dashboard bookmark listing
        $code1="fdUserBookmark";
        $usersNs = new Zend_Session_Namespace("members");
        $mapId1=$usersNs->userId;
        $model=new Security_Model_SystemMapping();
        $strOrderBy="s.map_id3";
        $this->view->sortOptions=array();
        $this->view->linkArray=array();
        $table=$model->getMapper()->getDbTable();

        $select = $table->select()->setIntegrityCheck(false)->from(array("sm"=>'system_master'), array("master_value","strval1","strval3"))
        ->join(array("s"=>"system_mapping"),"s.map_code='$code1' and s.map_id1='$mapId1'  and sm.master_code='fdMenu' and sm.strval1!='' and sm.master_id=s.map_id2", array("map_id1"=>'map_id1',"map_id2"=>'map_id2',"map_id3"=>'map_id3') )
        ->group("s.map_id2")
        ->order($strOrderBy);
        $this->view->bookmarks=$table->fetchAll($select );
        //End Dashboard bookmark listing
           
        //start dashboard Widgets
        $code2="fdWidget";
        $model=new Security_Model_SystemMaster();
        $table2=$model->getMapper()->getDbTable();
        $select = $table2->select()->setIntegrityCheck(false)->from(array("s"=>'system_master'), array("master_value"))
        ->join(array("sm"=>"system_mapping"),"sm.map_code='$code2' and sm.map_id1='$mapId1'  and s.master_code=sm.map_code and s.master_id=sm.map_id2 and sm.intval1=1", array("master_id"=>'map_id2',"intval1"=>'intval1',"intval2"=>'intval2') )
        ->order("sm.map_id3");
        $this->view->widgets=$table2->fetchAll($select );
        //End widgets listing
            
           $this->view->pageHeading="Dashboard";
    }

    public function createSupplierAction()
    {
        $this->view->pageHeading="Add Supplier";
    }
    
    public function supplierListAction()
    {
        $this->view->pageHeading="Supplier List";
    }
    
    public function createCustomerAction()
    {
        $this->view->pageHeading="Add Customer";
    }
    public function customerListAction()
    {
        $this->view->pageHeading="Customer List";
    }
    
    public function disclaimerAction()
    {
        $this->view->pageHeading="Disclaimer";
    }
    public function termsAndConditionsAction()
    {
        $this->view->pageHeading="Terms and Conditions";
    }
    
    public function knockingBoxAction()
    {
        $this->view->pageHeading="Knocking Box";
        $this->view->isFullScreen=true;
        $this->view->fullScreenLink="/mps/app/popup-knocking";
    }
    
    public function popupKnockingAction()
    {
        $this->_helper->layout->setLayout("full-screen");
    }
    public function manageUserAction()
    {
        $this->view->pageHeading="Staff List";
    }
    
    public function incomingCowsAction()
    {

        $arrUrl=explode("/","/mps/app/incoming-cows");
       // var_dump($arrUrl);
        $this->view->pageHeading="Incoming Cows";
    }
    
    public function createUserAction()
    {
        $this->view->pageHeading="Add Staff";
    }
    public function changePasswordAction()
    {
        $this->view->pageHeading="Change Password";
    }
    public function menuCreateAction()
    {
        $this->view->pageHeading="Add Menu";
    }
    public function menuListAction()
    {
        $this->view->pageHeading="Menu List";
    }
    
    public function createProductAction()
    {
        $this->view->pageHeading="Add Product";
    }
    public function productListAction()
    {
        $this->view->pageHeading="Product List";
    }
    
    public function createLotPriceAction()
    {
        $this->view->pageHeading="Create Lot Price";
    }
    public function lotPriceListAction()
    {
        $this->view->pageHeading="Manage Lot Price";
    }
    public function manageActionsAction()
    {
        $this->view->pageHeading="Manage Actions";
    }
    public function permissionSetupAction()
    {
        $this->view->pageHeading="Menu Permission Setup";
    }
    public function actionPermissionSetupAction()
    {
        $this->view->pageHeading="Action Permission Setup";
    }
    public function createInventoryLocationAction()
    {
        $this->view->pageHeading="Add Location";
    }
    public function inventoryLocationListAction()
    {
        $this->view->pageHeading="Location List";
    }
    
    public function manageCowProfileAction()
    {
        $this->view->pageHeading="Manage Cow Profile";
    }
    public function complianceAction()
    {
        $this->view->pageHeading="Compliance";
    }
    public function weighingAction()
    {
        $this->view->pageHeading="Weighing";
        $this->view->isFullScreen=true;
        $this->view->fullScreenLink="/mps/app/popup-weighing";
    }
    
    public function popupWeighingAction()
    {
        $this->_helper->layout->setLayout("full-screen");
    }
    public function pricingAction()
    {
        $this->view->pageHeading="Pricing";
    }
    public function billingAction()
    {
        $this->view->pageHeading="Billing";
    }
    public function stockInputUpdateAction()
    {
        $this->view->pageHeading="Stock Intput/Update";
    }
    public function orderCaptureAction()
    {
        $this->view->pageHeading="Order Capture";
    }
    public function pickOrderAction()
    {
        $this->view->pageHeading="Pick Order";
    }
    public function orderPriortizationAction()
    {
        $this->view->pageHeading="Order Priortization";
    }
    public function productTypeBasedWorkOrderAction()
    {
        $this->view->pageHeading="Product type based work order creation";
    }
    public function meatPackagingFulfilmentAction()
    {
        $this->view->pageHeading="Meat Packaging & Fulfilment";
    }
    public function shippingAction()
    {
        $this->view->pageHeading="Shipping";
    }
    
    public function retailAction()
    {
        $this->view->pageHeading="Retail";
    }
    
    public function reportsAction()
    {
        $this->view->pageHeading="Reports";
    }
    
    public function boneAction()
    {
        $this->view->pageHeading="Bone";
    }
    public function tripeAction()
    {
        $this->view->pageHeading="Tripe";
    }
    public function comboAction()
    {
        $this->view->pageHeading="Combo";
    }
    public function retailInventoryAction()
    {
        $this->view->pageHeading="Retail Production ";
    }
    public function orderStatusAction()
    {
        $this->view->pageHeading="Order Status";
    }
    
    public function manageOrganizationAction()
    {
        $this->view->pageHeading="Manage Organization";
    }
    public function invoicingAction()
    {
        $this->view->pageHeading="Invoicing";
    }
    public function printTagsAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        echo '<img src="'.$this->view->cdnUri().'/media/print_image/AntemortumCard.JPG" alt="">';
    }
    
    public function bloodStationAction()
    {
        $this->view->pageHeading="Blood station";
    }
    public function officeRetailAction()
    {
        $this->view->pageHeading="Office Retail";
    }
    public function orderListAction()
    {
        $this->view->pageHeading="Order List";
    }
    public function scanProductionAction()
    {
        $this->view->pageHeading="Scan Production";
    }
    public function monthEndAction()
    {
        $this->view->pageHeading="Month End";
    }
    public function scanInventoryAction()
    {
        $this->view->pageHeading="Scan Inventory";
    }
    public function productionReportsAction()
    {
        $this->view->pageHeading="Production Reports";
    }
    public function shippingStatusAction()
    {
        $this->view->pageHeading="Shipping Status";
    }
    
    
    public function popupOfficeRetailAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        echo '<img src="'.$this->view->cdnUri().'/media/print_image/AntemortumCard.JPG" alt="">';
    }
    
    public function cowStatusAction()
    {
        $this->view->pageHeading="Cow Status";
    }
}//end of class
