<?php
// $Id:$

/**
 * @file
 * Administrative interface for the Field Scheduler module.
 */

/**
 * Alter the CCK Field settings form.
 */
function _field_scheduler_content_field_edit_form_alter(&$form) {
  $field_name = $form['#field']['field_name'];
  $field_schedule_date = field_scheduler_get_content_field_date($field_name);

  $content_type = content_types($form['type_name']['#value']);
  $type_date_fields = array('none' => t('None (disabled)'));
  foreach ($content_type['fields'] as $field) {
    if ($field['type'] == 'datetime' || $field['type'] == 'date' || $field['type'] == 'timestamp') {
      $type_date_fields[$field['field_name']] = $field['widget']['label'];
    }
  }

  $form['field']['field_scheduler'] = array(
    '#type' => 'fieldset',
    '#title' => t('Field Scheduler options'),
    '#weight' => 50,
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#description' => t('Only display this field after a chosen date and time.'),
  );
  $form['field']['field_scheduler']['field_schedule_date'] = array(
    '#type' => 'select',
    '#title' => t('Date field to use'),
    '#options' => $type_date_fields,
    '#default_value' => (isset($field_schedule_date) ? $field_schedule_date : ''),
    '#description' => t('Note: if this field occurs in more than one content type, the date field chosen here must also be added to those content types.'),
  );

  $form['#submit'][] = '_field_scheduler_content_field_edit_form_submit';
}

/**
 * Submit function for Field Scheduler extra config.
 */
function _field_scheduler_content_field_edit_form_submit($form, &$form_state) {
  // Set the scheduling option for the given field.
  $field_schedule_date = ($form_state['values']['field_schedule_date'] != 'none' ? $form_state['values']['field_schedule_date'] : FALSE);
  field_scheduler_set_content_field_date($form_state['values']['field_name'], $field_schedule_date);
}

/**
 * Modules notify CCK Private Fields module when enabled, disabled, etc.
 *
 * @param $op
 *   The module operation: install, uninstall, enable, disable.
 * @param $module
 *   The name of the affected module.
 *
 * @see field_scheduler_get_private_field_access_module()
 */
function _field_scheduler_notify($op, $module) {
  switch ($op) {
    case 'enable':
      if (!module_exists($module)) {
        return FALSE;
      }

      // Save the name of the module that provides view access control
      // for Private status.
      variable_set('field_scheduler_view_access_module', $module);
      return TRUE;

    case 'disable':
      variable_del('field_scheduler_view_access_module');

      // This will force Drupal core invoke hook_requirements('install')
      // whenever the module is enabled again.
      drupal_set_installed_schema_version($module, SCHEMA_UNINSTALLED);
      return TRUE;

    case 'install':
    case 'uninstall':
      // Nothing really special to do here.
      return TRUE;
  }
  return FALSE;
}

/**
 * Modules that provide field access control for Private status should
 * invoke this function from its own hook_requirements('install')
 * implementation.
 */
function _field_scheduler_check_install_requirements($module) {
  $requirements = array();
  $t = get_t();

  $field_access_module = field_scheduler_get_private_field_access_module();
  if (!empty($field_access_module) && $field_access_module != $module) {
    $requirements[$module] = array(
      'title' => $t('CCK Private Fields'),
      'severity' => REQUIREMENT_ERROR,
      'description' => $t('%cck-private-fields is not compatible with more than one field access control provider. Please, uninstall %field-access-module if you want to enable %module.', array(
        '%cck-private-fields' => $t('CCK Private Fields'),
        '%field-access-module' => $field_access_module,
        '%module' => $module,
      )),
    );
  }
  return $requirements;
}
