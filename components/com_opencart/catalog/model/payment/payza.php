<?php
/**
 * @package		jCart
 * @copyright	Copyright (C) 2009 - 2012 softPHP,http://www.soft-php.com
 * @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ModelPaymentPayza extends Model {
  	public function getMethod($address, $total) {
		$this->load->language('payment/payza');
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('payza_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		
		if ($this->config->get('payza_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('payza_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}	
		
		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		'code'       => 'payza',
        		'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('payza_sort_order')
      		);
    	}
   
    	return $method_data;
  	}
}
?>