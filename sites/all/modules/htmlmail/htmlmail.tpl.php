<?php
// $Id: htmlmail.tpl.php,v 1.1.2.2 2009/07/15 03:50:15 chrisherberte Exp $

/**
 * @file
 * Default template for HTML Mail
 *
 * HMTL Mail will first look in the directory of the current used
 * theme for a file named "htmlmail.tpl.php". If it exists, it will
 * be used as template for e-mails. If the file doesn't exists, 
 * this file will be used instead.
 *
 * DO NOT EDIT THIS FILE. If you want to customize the template, copy this
 * file to the directory of the used theme, and edit the copy.
 *
 * The following variables are available in this template:
 *
 *  - $body    : message body
 *  - $header  : template header
 *  - $footer  : template footer
 *  - $css     : template css
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php if ($css): ?>
<style type="text/css">
<?php print $css; ?>
</style>
<?php endif; ?>
</head>

<body id="htmlmail">

  <?php if ($header): ?>
  <div id="htmlmail-header">
  <?php print $header; ?>
  </div>
  <?php endif; ?>

  <div id="htmlmail-body">
  <?php print $body; ?>
  </div>

  <?php if ($footer): ?>
  <div id="htmlmail-footer">
  <?php print $footer; ?>
  </div>
  <?php endif; ?>

</body>
</html>
