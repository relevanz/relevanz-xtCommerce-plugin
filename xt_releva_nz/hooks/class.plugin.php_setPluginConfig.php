<?php
defined('_VALID_CALL') or die('Direct Access is not allowed.');

$stores = $store_handler->getStores();

foreach ($stores as $sdata){
    $store_names[] = $sdata['text'];
    $query = "SELECT * FROM " . TABLE_PLUGIN_CONFIGURATION . " where plugin_id = ? and shop_id=?";
    $record = $db->Execute($query, array($plugin_id, $sdata['id']));

    while (!$record->EOF) {
        if ($record->fields['config_key'] == 'XT_RNZ_API_KEY') {

            $qry = "SELECT config_value FROM " . TABLE_PLUGIN_CONFIGURATION . " WHERE plugin_id = ? AND shop_id = ?  AND config_key = 'XT_RNZ_API_KEY'";
            $mandant_url = $db->GetOne($qry, array($plugin_id, $sdata['id']));

            $url = 'https://backend.releva.nz/v1/campaigns/get?apikey=' . trim($mandant_url);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json'
                )
            );
            $result = curl_exec($ch);

            global $logHandler;
            if (curl_errno($ch)) {
                $logHandler->_addLog('error', 'xt_releva_nz', '1', 'Curl error: ' . curl_error($ch));
            }
            $ress = json_decode($result);
            $user_id = $ress->user_id;

            $conf_value = $filter->_filter($data['conf_' . $record->fields['config_key'] . '_shop_' . $sdata['id']]);
            $db->Execute(
                "UPDATE " . TABLE_PLUGIN_CONFIGURATION . " SET config_value=? WHERE plugin_id=? and shop_id=? and config_key=?",
                array($user_id, $plugin_id, $sdata['id'], 'XT_RNZ_USER_ID_CAMP_ID')
            );

        }

        $record->MoveNext();
    }

}

 	

