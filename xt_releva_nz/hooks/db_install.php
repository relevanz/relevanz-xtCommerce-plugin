<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');


$rc = $db->Execute("SELECT * FROM ".TABLE_ADMIN_NAVIGATION." WHERE text = 'xt_releva_nz' ");
if ($rc->RecordCount()==0){
    $db->Execute("INSERT INTO `".TABLE_ADMIN_NAVIGATION."` ( `text`, `icon`, `url_i`, `url_d`, `sortorder`, `parent`, `type`, `navtype`, `cls`, `handler`, `iconCls`) VALUES ('xt_releva_nz', '../plugins/xt_releva_nz/images/relevanz.png', '../index.php?page=xt_releva_nz&seckey="._SYSTEM_SECURITY_KEY."', '', 10000, 'config', 'I', 'W', NULL, 'clickHandler2', NULL);");
}

$check = $db->Execute("SELECT * FROM ".TABLE_FEED." WHERE feed_title = 'releva.nz - Export' ");

if ($check->RecordCount()==0){#
    $hash = md5(time());
    $db->Execute('INSERT INTO '.TABLE_FEED.' ( `feed_key`, `feed_language_code`, `feed_store_id`, `feed_title`, `feed_type`, `feed_header`, `feed_body`, `feed_footer`, `feed_mail`, `feed_mail_flag`, `feed_mail_header`, `feed_mail_body`, `feed_ftp_flag`, `feed_ftp_server`, `feed_ftp_user`, `feed_ftp_password`, `feed_ftp_dir`, `feed_ftp_passiv`, `feed_filename`, `feed_filetype`, `feed_encoding`, `feed_save`, `feed_export_limit`, `feed_linereturn_deactivated`, `feed_p_currency_code`, `feed_p_customers_status`, `feed_p_campaign`, `feed_p_price_min`, `feed_p_price_max`, `feed_p_quantity_min`, `feed_p_quantity_max`, `feed_p_model_min`, `feed_p_model_max`, `feed_p_deactivated_status`, `feed_categories`, `feed_manufacturers`, `feed_o_customers_status`, `feed_o_orders_status`, `feed_date_range_orders`, `feed_date_from_orders`, `feed_date_to_orders`, `feed_post_flag`, `feed_post_server`, `feed_post_field`, `feed_pw_flag`, `feed_pw_user`, `feed_pw_pass`, `feed_p_slave`) VALUES
( \''.$hash.'\', \'de\', 1, \'releva.nz - Export\', 1, \'\"products_id\";\"products_name\";\"products_ean\";\"products_mode\";\"products_cat_id\";\"products_cat_name\";\"manufacturers_id\";\"manufcaturers_name\";\"products_desc_short\";\"products_desc_long\";\"products_price\";\"products_deeplink\";\"products_image_thumb\";\"products_image_info\";\"products_image_popup\";\"products_image\"\', \'\"{$data.products_id}\";\"{$data.products_name}\";\"{$data.products_ean}\";\"{$data.products_model}\";\"{$data.xt_category_id}\";\"{$data.category}\";\"m_{$data.manufacturers_id}\";\"{$data.manufacturers_name}\";\"{$data.products_short_description_clean}\";\"{$data.products_description_clean}\";\"{$data.products_price.plain}\";\"{$data.products_link}\";\"{$data.products_image_thumb}\";\"{$data.products_image_info}\";\"{$data.products_image_popup}\";\"{$data.products_image_org}\"\', \'\', \'\', 0, \'\', \'\', 0, \'\', \'\', \'\', \'\', 0, \'releva_nz\', \'.csv\', \'UTF-8\', 1, 300, 0, \'EUR\', 0, \'\', \'\', \'\', \'\', \'\', \'\', \'\', 0, \'\', \'\', 0, 0, 0, \'0000-00-00 00:00:00\', \'0000-00-00 00:00:00\', 0, \'\', \'\', 0, \'\', \'\', 0);');




$feed_id = $db->GetOne("SELECT feed_id FROM ".TABLE_FEED." WHERE `feed_key` = '".$hash."';");

    if($feed_id != '' && isset($feed_id)){
        $data = array(
            "cron_id" => "",
            "cron_note" => "releva.nz",
            "cron_value" => "1",
            "cron_type" => "d",
            "hour" => "2",
            "minute" => "30",
            "cron_action" => "file:cron.feed.php",
            "cron_parameter" => "id=".$feed_id,
            "active_status" => 1
        );
        $cron = new xt_cron();
        $cron->setPosition('admin');
        $cron->_set($data, 'add');

    }
}