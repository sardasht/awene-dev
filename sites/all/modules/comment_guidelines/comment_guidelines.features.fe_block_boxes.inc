<?php

/**
 * Implementation of hook_default_fe_block_boxes().
 */
function comment_guidelines_default_fe_block_boxes() {
  $export = array();

  $fe_block_boxes = new stdClass;
  $fe_block_boxes->info = 'Comment Guide for Reader';
  $fe_block_boxes->format = '1';
  $fe_block_boxes->machine_name = 'comment_guidelines';
  $fe_block_boxes->body = '<ol><li>please be care write comment</li><li>thaks for your comment</li></ol>';

  $export['comment_guidelines'] = $fe_block_boxes;

  return $export;
}
