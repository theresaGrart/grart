<?php
/**
 * @package		jCart
 * @copyright	Copyright (C) 2009 - 2012 softPHP,http://www.soft-php.com
 * @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Heading
$_['heading_title']      = 'Payza';

// Text 
$_['text_payment']       = 'Payment';
$_['text_success']       = 'Success: You have modified Payza account details!';
      
// Entry
$_['entry_merchant']     = 'Merchant ID:';
$_['entry_security']     = 'Security Code:';
$_['entry_callback']     = 'Alert URL:<br /><span class="help">This has to be set in the Payza control panel. You will also need to check the "IPN Status" to enabled.</span>';
$_['entry_total']        = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';
$_['entry_order_status'] = 'Order Status:';
$_['entry_geo_zone']     = 'Geo Zone:';
$_['entry_status']       = 'Status:';
$_['entry_sort_order']   = 'Sort Order:';

// Error
$_['error_permission']   = 'Warning: You do not have permission to modify payment Payza!';
$_['error_merchant']     = 'Merchant ID Required!';
$_['error_security']     = 'Security Code Required!';
?>