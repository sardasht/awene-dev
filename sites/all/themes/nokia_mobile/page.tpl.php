<?php 
// load mobile view
$view = views_get_view('mobile');
$c = $view->execute_display('block_1');
?>
<?php print $doctype."\n"; ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>">
	<head>
    <?php //print $head; ?>
		<title><?php print $head_title; ?></title>
      <!-- nokia_mobile theme by Andrea Trasatti -->
		<?php print $styles; ?>
		<?php print $scripts; ?>
	</head>
	<body class="<?php print $bodyclasses; ?>">
	<div id="container">
		<div id="header">
			<div class="branding">
            <?php
            if ($logo && !is_null($logo)) {
							if (!$site_slogan) {
								// force some slogan so that the title attribute is not empty
								// TODO: would this be better moved into template.php?
								$site_slogan = $site_name;
							}
							if ($site_name) {
								print '<h1 id="sitename" class="top-aligned">';
							}
							$logo_url = check_url($goedlogo);
							if (!(substr($logo_url, 0, 1) == '/')) {
								$logo_url = '/'.$logo_url;
							}
							print '<a id="sitelogo" title="' . $site_slogan . '" href="' . check_url($front_page) . '" style="color: '.$header_text_color.'"><img src="'. $logo_url .'" /> ';
							print $site_name;
							print '</a>';
							if ($site_name) {
								print '</h1>';
							}
            } else if ($site_name) {
              print '<h1 id="sitename" class="top-aligned"><a title="' . $site_slogan . '" href="' . check_url($front_page) . '" style="color: '.$header_text_color.'">' . $site_name . '</a></h1>';
            }
            ?>
			</div>
		</div>
    <?php if ((isset($primary_links) && is_array($primary_links) && count($primary_links) > 0)
               || (isset($secondary_links)&& is_array($secondary_links) && count($secondary_links) > 0) ) : ?>
		<div id="primary_links">
			<?php
			if (isset($primary_links)) {
				print theme('toplinks', $primary_links, array('class' => 'links primary-links'));
			}
			if (isset($secondary_links)) {
				print theme('toplinks', $secondary_links, array('class' => 'links secondary-links'));
			}
			?>
		</div>
    <?php endif; ?>
		<?php if ($left): ?>
		<div id="sidebar-left" class="mobileregion">
			<?php if ($search_box): ?><div class="block block-theme"><?php print $search_box ?></div><?php endif; ?>
			<?php print $left ?>
		</div>
		<?php endif; ?>
		<div id="maincontent" class="mobileregion">
			<?php if ($mission) print '<div id="mission">' . $mission . '</div>'; ?>
			<?php if ($title) print '<div id="main"><h2>' . $title . '</h2></div>'; ?>
			<?php if ($tabs) print '<ul class="tabs primary">' . $tabs . '</ul>'; ?>
			<?php if ($tabs2) print '<ul class="tabs secondary">' . $tabs2 . '</ul>'; ?>
			<?php if ($show_messages && $messages) print $messages; ?>
			<?php if ($help) print $help; ?>
			<div id="content">
				<?php if (!$is_front) { ?>
				  <?php print $content; ?>
				  <div class="back"><?php print l(t('Back'), '<front>'); ?></div>
				<?php } ?>
				<div class="headlinetitle"><?php print t('Headlines'); ?></div>
				<?php print $c['content']; ?>
			</div>
		</div>
		<?php if ($right): ?>
		a
		<div id="sidebar-right" class="mobileregion">
			<?php if (!$left && $search_box): ?><div class="block block-theme"><?php print $search_box; ?></div><?php endif; ?>
			<?php print $right; ?>
		</div>
		<?php endif; ?>
		<div id="footer" class="mobileregion">
			<?php if($feed_icons) print $feed_icons; ?>
			<?php print '<p>'.$footer_message .'</p>'. $footer; ?>
		</div>
	</div>
	<?php print $closure; ?>
  </body>
</html>
