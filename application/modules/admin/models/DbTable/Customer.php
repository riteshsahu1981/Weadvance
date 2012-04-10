<?php

/**
 * User table data gateway
 *
 * @uses   Zend_Db_Table_Abstract
 * @author 	Ritesh Kumar Sahu
 * @package QuickStart
 * @subpackage Model
 */

class Admin_Model_DbTable_Customer extends Zend_Db_Table_Abstract {
	/**
     * @var string Name of the database table
     */
	protected $_name = 'customer';
	
}
