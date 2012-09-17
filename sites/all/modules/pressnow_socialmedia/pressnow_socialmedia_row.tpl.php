<?php
// $Id$
/**
 * @file
 * pressnow_socialmedia_row.tpl.php
 */
?>
<div class="pressnow-socialmedia-row">
  <?php if ($type == 'mobypic') : ?>
    <div class="image"><?php print $image; ?></div>
  <?php endif ?>
  <?php if ($type == 'twitter'): ?>
    <div class="user"><?php print $user; ?></div>
  <?php endif; ?>
  <div class="title"><?php print $title; ?></div>
  <div class="date"><?php print $date; ?></div>
</div>