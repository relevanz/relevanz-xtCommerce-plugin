<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

$db->Execute("DELETE FROM ".TABLE_ADMIN_NAVIGATION." WHERE `text` = 'xt_releva_nz' ");
