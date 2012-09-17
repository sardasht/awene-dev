<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
$node = node_load($row->nid);
?>
<div class="row-node-type-<?php print $node->type;?> <?php print $node->type;?>">
<?php foreach ($fields as $id => $field): ?>
  <?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
  <?php endif; ?>

  <<?php print $field->inline_html;?> class="views-field-<?php print $field->class; ?>">
    <?php if ($field->label): ?>
      <label class="views-label-<?php print $field->class; ?>">
        <?php print $field->label; ?>:
      </label>
    <?php endif; ?>
      <?php
      // $field->element_type is either SPAN or DIV depending upon whether or not
      // the field is a 'block' element type or 'inline' element type.
      ?>
      <<?php print $field->element_type; ?> class="field-content"><?php print $field->content; ?></<?php print $field->element_type; ?>>
  </<?php print $field->inline_html;?>>
<?php endforeach; ?>

<?php
if($node->field_related[0]['nid'] != NULL):
?>
  <div class="view-related">
<?php
for ($i = 0; $i < 2; $i++):
  if($node->field_related[$i]):
  $rel_node = node_load($node->field_related[$i]);
  // Trim teaser bij 180 chars at word boundary
  $teaser = strip_tags($rel_node->teaser);
  $teaser = str_replace('&nbsp;',' ',html_entity_decode($teaser));
  $teaser = drupal_substr($teaser, 0, 180);
  if (preg_match("/(.*)\b.+/us", $teaser, $matches)) {
	$teaser = $matches[1];
  $teaser = htmlentities($teaser);
  }
?>
	<div class="rij">
		<?php if(!empty($rel_node->field_teaser_image[0])): ?>
    <div class="views-field-field-teaser-image-fid">
      <?php print theme('imagecache','t075x050',$rel_node->field_teaser_image[0]['filepath']); ?>
    </div>
    <?php endif; ?>
    <div class="views-field-title">
      <span class="field-content"><?php print l($rel_node->title,'node/'.$rel_node->nid); ?></span>
    </div>
	</div>
	<div class="rij">
    <div class="views-field-nothing">
      <span class="field-content"><span class="field-city"><?php print $rel_node->field_city[0]['value']; ?></span> (<span class="date-display-single"><?php print date('j M',strtotime($rel_node->field_date[0]['value'])); ?></span>.) - <?php print $teaser; ?>... <span class="readmore"><?php print l(t('full story'),'node/'.$rel_node->nid); ?></span></span>
    </div>
	</div>
<?php
  endif;
endfor;
?>
  </div>
<?php
endif;
?>
</div>