<?php

function cck_field_rename_source_auto($userString) {
  $sql = " SELECT field_name FROM {content_node_field} 
           WHERE field_name LIKE lower('%%%s%%')
           ORDER BY field_name";
  $results = db_query_range($sql, $userString, 0, 25);
  
  // loop through the results and create an associative array
  $datas = array();
  while ($data = db_fetch_array($results)) {
	  $datas[$data['field_name']] = $data['field_name'];
  }
  print drupal_to_js($datas);

  // exit, to prevent your results form hitting the theme layer
  exit();
}