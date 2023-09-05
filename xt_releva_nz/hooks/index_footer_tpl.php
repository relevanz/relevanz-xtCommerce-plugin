<?php
defined('_VALID_CALL') or die('Direct Access is not allowed.');

if(isset($xtPlugin->active_modules['xt_releva_nz']) && XT_RNZ_ACTIVATE =='true') {


    require _SRV_WEBROOT . 'plugins/xt_releva_nz/classes/class.xt_releva_nz.php';
    $rnz = new xt_releva_nz;
    global $page,$current_category_id,$current_product_id;


    if($_SESSION['customer']->customers_id != '0')
        $customer_str = '&custid='.$_SESSION['customer']->customers_id;
    else
        $customer_str = '';

    if(isset($_SESSION['xt_releva_nz_product_added'])){
        $tpl_data['script'] = '<script src = "https://pix.hyj.mobi/rt?t=d&action=w&cid='.trim(XT_RNZ_USER_ID_CAMP_ID).'&id='.$_SESSION['xt_releva_nz_product_pid'].$customer_str.'" async="async"></script>';
        unset($_SESSION['xt_releva_nz_product_added']);
        unset($_SESSION['xt_releva_nz_product_pid']);
    }

    switch ($page->page_name) {
        case 'manufacturers ':
// manufacturere ID
            $tpl_data['script'] = '<script src = "https://pix.hyj.mobi/rt?t=d&action=c&cid='.trim(XT_RNZ_USER_ID_CAMP_ID).'&id=m_'.$current_manufacturer_id.$customer_str.'" async="async" ></script>';
            break;
        case 'categorie':
// CATEGORY_ID
            $tpl_data['script'] = '<script src = "https://pix.hyj.mobi/rt?t=d&action=c&cid='.trim(XT_RNZ_USER_ID_CAMP_ID).'&id='.$current_category_id.$customer_str.'" async="async" ></script>';
            break;
        case 'product':
// PRODUCT_ID
            $tpl_data['script'] = '<script src = "https://pix.hyj.mobi/rt?t=d&action=p&cid='.trim(XT_RNZ_USER_ID_CAMP_ID).'&id='.$current_product_id.$customer_str.'" async="async" ></script>';
            break;
        case 'checkout':
            if ( $page->page_action == 'success') {
                $tpl_data['script'] = $rnz->_getConversionCode($customer_str);
            }else{
                $tpl_data['script'] = '<script src = "https://pix.hyj.mobi/rt?t=d&action=s&cid='.trim(XT_RNZ_USER_ID_CAMP_ID).$customer_str.'" async="async" ></script>';
            }
            break;

        default:
            $tpl_data['script'] = '<script src = "https://pix.hyj.mobi/rt?t=d&action=s&cid='.trim(XT_RNZ_USER_ID_CAMP_ID).$customer_str.'" async="async" ></script>';

            break;
    }


    $tpl = 'additional.html';
    $template = new Template();
    $template->getTemplatePath($tpl, 'xt_releva_nz', '', 'plugin');

    echo $template->getTemplate('xt_releva_nz_smarty',$tpl, $tpl_data);
    
}

