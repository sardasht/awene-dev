<?php
// $Id: common.inc,v 1.1.2.8 2009/08/05 19:09:11 markuspetrux Exp $

/**
 * @file
 * Common functions for the Field Scheduler module.
 */

/**
 * Set the privacy option for the given field.
 */
function field_scheduler_set_content_field_date($field_name, $field_schedule_date) {
  if ($field_schedule_date !== FALSE) {
    // If scheduling is enabled, then create the variable.
    variable_set('field_scheduler_'. $field_name, $field_schedule_date);
  }
  elseif (variable_get('field_scheduler_'. $field_name, FALSE) !== FALSE) {
    // If scheduling is disabled, then remove the variable to reduce the size
    // of the {variable} table. Note this is perfectly fine because default
    // variable value is disabled.
    variable_del('field_scheduler_'. $field_name);
  }
}

/**
 * Get the privacy option for the given field.
 */
function field_scheduler_get_content_field_date($field_name) {
  return variable_get('field_scheduler_'. $field_name, FALSE);
}

/**
 * Get the list of scheduled fields for the given content type.
 */
function field_scheduler_get_content_scheduled_fields($type_name, $reset = FALSE) {
  static $scheduled_fields;
  if (!isset($scheduled_fields) || $reset) {
    $scheduled_fields = array();
  }
  if (!isset($scheduled_fields[$type_name])) {
    $scheduled_fields[$type_name] = array();
    // Scan the list of fields defined in the given content type.
    $result = db_query("SELECT nfi.field_name, nfi.label
      FROM {". content_instance_tablename() ."} nfi
        INNER JOIN {". content_field_tablename() ."} nf ON nfi.field_name = nf.field_name
      WHERE nfi.type_name = '%s' AND nf.active = 1 AND nf.locked = 0", $type_name);
    while ($instance = db_fetch_object($result)) {
      $content_field_privacy = field_scheduler_get_content_field_privacy($instance->field_name);
      if ($content_field_privacy !== FALSE) {
        $scheduled_fields[$type_name][$instance->field_name] = $content_field_privacy;
      }
    }
  }
  return $scheduled_fields[$type_name];
}

/**
 * Get the list of all fields with privacy options enabled.
 */
 /*
function field_scheduler_get_private_fields($reset = FALSE) {
  static $private_fields;
  if (!isset($private_fields) || $reset) {
    $private_fields = array();
  }
  $result = db_query("SELECT name FROM {variable} WHERE name LIKE 'cck\_private\_fields\_field\_%%'");
  while ($row = db_fetch_object($result)) {
    $field_name = preg_replace('`^field_scheduler_(.*)$`', '\1', $row->name);
    $private_fields[$field_name] = field_scheduler_get_content_field_privacy($field_name);
  }
  return $private_fields;
}

/**
 * Get the usage count for the given field.
 */
 /*
function field_scheduler_get_field_usage_count($field_name) {
  return (int)db_result(db_query("SELECT COUNT(*) FROM {field_scheduler} WHERE field_name = '%s'", $field_name));
}
*/

/**
 * Get the privacy status for the given field in the given node revision.
 */
 /*
function field_scheduler_get_field_privacy_status($vid, $field_name) {
  $field_privacy_status = db_result(db_query("SELECT privacy_status FROM {field_scheduler} WHERE vid = %d AND field_name = '%s'", $vid, $field_name));
  return is_numeric($field_privacy_status) ? (int)$field_privacy_status : (int)field_scheduler_get_content_field_privacy($field_name);
}
*/

/**
 * Get the privacy status for the given node revision.
 */
 /*
function field_scheduler_get_node_privacy_status($vid) {
  $fields = array();
  $result = db_query("SELECT field_name, privacy_status FROM {field_scheduler} WHERE vid = %d", $vid);
  while ($data = db_fetch_object($result)) {
    $fields[$data->field_name] = (int)$data->privacy_status;
  }
  return $fields;
}
*/

/**
 * Build the permission name for the given operation against a particular field.
 *
 * @param $op
 *   The operation related to the permission ('view' or 'edit').
 * @param $field_name
 *   The field name related to the permission.
 *
 * @return
 *   Boolean TRUE if the current user has the requested permission.
 *
 * @see field_scheduler_perm()
 * @see user_access()
 */
function field_scheduler_build_permission_name($op, $field_name) {
  return ($op == 'view' ? 'view private data for field' : 'edit privacy options for field') .' '. $field_name;
}

/**
 * Get the name of the module that provides private access control.
 *
 * @see field_scheduler_notify()
 */
function field_scheduler_get_private_field_access_module() {
  return variable_get('field_scheduler_view_access_module', NULL);
}

/**
 * Invoke privacy access module to check for view access to the given field
 * for the given module.
 *
 * @param $field
 *   The field which is about to be checked.
 * @param $node
 *   The node where this field is located.
 * @param $account
 *   The account to check.
 *
 * @return
 *   Boolean TRUE if the specified account is allowed to view the field.
 */
function field_scheduler_invoke_view_access($field, $node, $account) {
  // Check if privacy access module is enabled and exists.
  $module = field_scheduler_get_private_field_access_module();
  if (empty($module) || !module_exists($module)) {
    return FALSE;
  }

  // Check if privacy access hook is implemented.
  $function = $module .'_field_scheduler_view_access';
  if (!function_exists($function)) {
    return FALSE;
  }

  return (boolean)$function($field, $node, $account);
}
