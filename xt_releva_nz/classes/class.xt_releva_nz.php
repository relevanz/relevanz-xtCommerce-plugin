<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

class xt_releva_nz {
    

	function _getConversionCode($customer_str) {
		global $success_order;

        if (!is_object($success_order)) return false;
        
        $total_net=0;
        $success_order->order_data['orders_id'];
		foreach ($success_order->order_products as $key => $arr) {                                                                  
		    $total_net+=$arr['products_final_price']['plain_otax'];                                                                 
		    $products_list[] =$arr['orders_products_id'];
        }

        /*
         * $total_net= Produktprices without shipping or any fee!
         * Percentage discounts will be applied, "fixed amount" discounts not
         * */
        $code = '';
        $code .= 'https://d.hyj.mobi/conv?cid='.trim(XT_RNZ_USER_ID_CAMP_ID).$customer_str.'&orderId='.$success_order->order_data['orders_id'].'&amount='.$total_net.'&products='.implode(',',$products_list);
        // produkte demarkieren nach conversion
        // code is added to url which destroys conversion tracking, instead only use conversion call as it already demarks customer
        //$code .= 'https://pix.hyj.mobi/rt?t=d&action=t&cid='.trim(XT_RNZ_USER_ID_CAMP_ID).$customer_str.'&products='.implode(',',$products_list);

		return $code;
	}

    function getPhpVersion() {
        return [
            'version' => phpversion(),
            'sapi-name' => php_sapi_name(),
            'memory-limit' => ini_get('memory_limit'),
            'max-execution-time' => ini_get('max_execution_time'),
        ];
    }

    function getServerEnvironment() {
        return [
            'server-software' => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : null,
            'php' => $this->getPhpVersion()
        ];
    }
}