<table style="width:560px;background:#EBEBEB;font-family:Arial,Helvetica;" cellpadding="0" cellspacing="5">
  <tr>
    <td>
	<table style="background:#EBEBEB;font-family:Arial,Helvetica;" cellpadding="0" cellspacing="0">
	  <tr>
		<td colspan="2" style="border-bottom:1px solid #000000;background:#E51836;padding-left:30px"><img src="http://localhost/pressnow/sites/all/themes/basetheme/gfx/logo.png"></td>
	  </tr>
	  <tr>
		<td colspan="2" style="font-size:10px;border-top:1px solid #606060;background-color:#ffffff;">&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="2" style="background-color:#ffffff;font-size:20px;font-weight:bold;color:#1A1A1A;padding-left:5px;padding-right:5px;"><?php print $node->title; ?></td>
	  </tr>
	  <tr>
		<td colspan="2" style="background-color:#ffffff;font-size:11px;font-weight:bold;color:#707173;padding-left:5px;padding-right:5px;padding-right:5px;"><?php print date('l j F Y',strtotime($node->field_date[0]['value'])); ?><hr style="height:1px;border:1px solid #707173;"></td>
	  </tr>

	<!-- Articles --->
	<?php
	  foreach( $node->field_content as $key => $aArticle){
		$article_node = node_load($aArticle['nid']);
		// Check if teaser and body are equal, so fixx the html 
		$body_check = strip_tags(strtolower($article_node->body));
		$body_check = str_replace('<!--break-->','',$body_check);
		$teaser_check = strip_tags(strtolower($article_node->teaser));
		$article_node->teaser = _filter_htmlcorrector($article_node->teaser);
	?>
	  <tr>
		<td style="background-color:#ffffff;font-size:14px;font-weight:bold;color:#3E3E40;padding-left:5px;padding-right:5px;padding-bottom: 15px;" valign="top"><?php print theme('imagecache', 'teaser-newsletter', $article_node->field_teaser_image[0]['filepath']); ?></td>
		<td style="background-color:#ffffff;font-size:14px;font-weight:bold;color:#3E3E40;padding-left:5px;padding-right:5px;padding-bottom: 15px;" valign="top">
			<table style="font-family:Arial,Helvetica;font-size:12px;" cellpadding="0" cellspacing="0">
			  <tr>
				<td><a href="<?php print url('node/'.$article_node->nid); ?>" style="text-decoration:none;color:#1A1A1A;font-size:16px;font-weight:bold;"><?php print $article_node->title; ?></a></td>
			  </tr>
			  <tr>
				<td style="color:#4D4D4D;"><?php print strip_tags($article_node->teaser); ?><?php if(trim($teaser_check)!=trim($body_check)){ ?> <span style="color:#1A1A1A;font-weight:bold;"><a href="<?php print url('node/'.$article_node->nid); ?>" style="text-decoration:none;color:#1A1A1A;">FULL STORY</a></span><?php } ?></td>
			  </tr>
			</table>
		</td>
	  </tr>
	<?php
	  }
	?>
	<!-- /Articles --->
	  
	<!-- Closure --->
	<?php
	if ($node->field_colofon[0]['value']):
	  // SB: Set colofon margin and padding
	  $colofon = $node->field_colofon[0]['value'];
      $colofon = str_replace('<p>','<p style="padding:0;margin:0;margin-bottom:15px;">', $colofon);
	?>
	  <tr>
		<td colspan="2" style="background-color:#ffffff;font-size:11px;color:#707173;padding-left:5px;padding-right:5px;padding-right:5px;"><hr style="height:1px;border:1px solid #707173;"><strong>Colofon</strong><br><?php print $colofon; ?></td>
	  </tr>
	<?php
	endif;
	?>
	</table>
	</td>
  </tr>
</table>