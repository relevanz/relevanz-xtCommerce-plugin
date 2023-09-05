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
        $code .= '<script src = "https://d.hyj.mobi/conv?cid='.trim(XT_RNZ_USER_ID_CAMP_ID).$customer_str.'&orderId='.$success_order->order_data['orders_id'].'&amount='.$total_net.'&products='.implode(',',$products_list).'" ></script>';
        // produkte demarkieren nach conversion
        $code .= '<script src = "https://pix.hyj.mobi/rt?t=d&action=t&cid='.trim(XT_RNZ_USER_ID_CAMP_ID).$customer_str.'&products='.implode(',',$products_list).'" async="async" ></script>';

		return $code;
	}


}