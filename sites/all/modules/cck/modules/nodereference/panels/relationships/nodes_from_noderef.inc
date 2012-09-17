<?php
// $Id: node_from_noderef.inc,v 1.1.2.3 2009/07/20 17:34:17 markuspetrux Exp $

/**
 * @file
 * Implements the node reference relationship for Panels.
 */

/**
 * Implementation of hook_ctools_relationships().
 */
function nodereference_nodes_from_noderef_ctools_relationships() {
  return array(
    'title' => t('All nodes from reference'),
    'keyword' => 'nodereferences',
    'description' => t('Adds a node from a node reference in a node context; if multiple nodes are referenced, the node IDs will be concatenated.'),
    'required context' => new ctools_context_required(t('Node'), 'node'),
    'context' => 'nodereference_nodes_from_noderef_context',
    'settings form' => 'nodereference_nodes_from_noderef_settings_form',
    'settings form validate' => 'nodereference_nodes_from_noderef_settings_form_validate',
    'defaults' => array('concatenator' => ','),
  );
}

/**
 * Return a new ctools context based on an existing context.
 */
function nodereference_nodes_from_noderef_context($context, $conf) {
  $field = content_fields($conf['field_name']);

  // If unset it wants a generic, unfilled context, which is just NULL.
  if (empty($context->data)) {
    return ctools_context_create_empty('string', NULL);
  }
  else if (isset($context->data->{$conf['field_name']}[0]['nid'])) {
    $nids = array();
    foreach ($context->data->{$conf['field_name']} as $referenced_node) {
      $nid = $referenced_node['nid'];
      $nids[] = $nid;
    }
    
    if (!empty($nids)) {
      $nids = implode($conf['concatenator'], $nids);
      return ctools_context_create('string', $nids);
    }
  }

  return ctools_context_create_empty('string', NULL);

}

/**
 * Settings form for the ctools relationship.
 */
function nodereference_nodes_from_noderef_settings_form($conf) {
  $options = array();
  foreach (content_fields() as $field) {
    if ($field['type'] == 'nodereference') {
      $options[$field['field_name']] = t($field['widget']['label']);
    }
  }
  $form['field_name'] = array(
    '#title' => t('Node reference field'),
    '#type' => 'select',
    '#options' => $options,
    '#default_value' => isset($conf['field_name']) ? $conf['field_name'] : '',
    '#prefix' => '<div class="clear-block">',
    '#suffix' => '</div>',
  );

  $form['concatenator'] = array(
    '#title' => t('Concatenator'),
    '#type' => 'select',
    '#options' => array(',' => ', (AND)', '+' => '+ (OR)'),
    '#default_value' => $conf['concatenator'],
    '#prefix' => '<div class="clear-block">',
    '#suffix' => '</div>',
    '#description' => t("When the value from this context is passed on to a view as argument, the node IDs can be concatenated in the form of 1+2+3 (for OR) or 1,2,3 (for AND)."),
  );

  return $form;
}
