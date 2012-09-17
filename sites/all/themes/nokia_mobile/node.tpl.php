<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } if (!$status) { print ' node-unpublished'; } ?>">
	<?php print $picture ?>
	<?php if ($page == 0): ?>
	<h2><a href="<?php print $node_url; ?>" title="<?php print $title; ?>"><?php print $title; ?></a></h2>
	<?php endif; ?>
	<?php if ($submitted): ?>
    <span class="submitted"><?php print $submitted; ?></span>
	<?php endif; ?>
	<div class="content clear-block box-flat">
		<?php print $node->content['body']['#value']; ?>
	</div>
</div>