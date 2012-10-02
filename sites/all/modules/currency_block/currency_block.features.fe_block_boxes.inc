<?php

/**
 * Implementation of hook_default_fe_block_boxes().
 */
function currency_block_default_fe_block_boxes() {
  $export = array();

  $fe_block_boxes = new stdClass;
  $fe_block_boxes->info = 'Currency Exchange Rates';
  $fe_block_boxes->format = '2';
  $fe_block_boxes->machine_name = 'currency_exchange_rates';
  $fe_block_boxes->body = '<iframe frameborder="0" scrolling="no" height="85" width="260" allowtransparency="true" marginwidth="0" marginheight="0" src="http://fxrates.forexpros.com/index.php?pairs_ids=1647;2139;1;&header-text-color=%23FFFFFF&curr-name-color=%230059b0&inner-text-color=%23000000&green-text-color=%232A8215&green-background=%23B7F4C2&red-text-color=%23DC0001&red-background=%23FFE2E2&inner-border-color=%23CBCBCB&border-color=%23cbcbcb&bg1=%23F6F6F6&bg2=%23ffffff&bid=show&ask=show&last=hide&open=hide&high=hide&low=hide&change=hide&last_update=hide"></iframe><span style="font-size: 8px;color: #333333;text-decoration: none; width:260px; float:left;">Powered by <a href="http://www.forexpros.com/quotes" target="_blank" style="font-size: 8px;color: #06529D; font-weight: bold;">Forexpros</a> </span>';

  $export['currency_exchange_rates'] = $fe_block_boxes;

  return $export;
}
