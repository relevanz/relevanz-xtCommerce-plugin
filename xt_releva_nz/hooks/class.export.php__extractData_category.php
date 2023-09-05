<?php
defined('_VALID_CALL') or die('Direct Access is not allowed.');

if(isset($xtPlugin->active_modules['xt_releva_nz']) && XT_RNZ_ACTIVATE =='true') {


    if ($rs->RecordCount() == 1) {
        $data_array['xt_category_id'] = $rs->fields['categories_id'];
    }

}

