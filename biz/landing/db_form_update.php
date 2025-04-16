<?php
require_once '../../common.php';


$land_memo = isset($_POST['land_memo']) ? strip_tags(clean_xss_attributes($_POST['land_memo'])) : '';

$upd_sql = "
update {$g5['crm_landing']} set
  land_memo = '{$land_memo}'
, update_date = now()
, update_user = '{$member['mb_id']}'
where land_idx  = {$land_idx}
";
isSqlError(sql_query($upd_sql), $upd_sql);

goto_url('db_list?' . $qstr);