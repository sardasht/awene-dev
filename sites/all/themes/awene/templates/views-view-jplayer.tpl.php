<?php
// $Id: views-view-unformatted.tpl.php,v 1.6 2008/10/01 20:52:11 merlinofchaos Exp $
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<?php
$playlist = implode(',', $rows);
drupal_add_js('var myPlayList = ['.$playlist.']', 'inline');

drupal_add_js('sites/all/libraries/jPlayer/jquery.jplayer.min.js');
drupal_add_js(drupal_get_path('module', 'jplayer_view').'/js/jplayer.playlist.js');

drupal_add_css('sites/all/libraries/jPlayer/jplayer.blue.monday.css');

$jPlayerSettings = array();
$jPlayerSettings['jPlayer']['autoPlay'] = $options['autoplay'];
$jPlayerSettings['jPlayer']['playListNext'] = $options['playnext'];
drupal_add_js($jPlayerSettings, 'setting');
?>

<?php
if(module_exists('hi_lo_switch')) {
  print theme('hi_lo_switch');
}
?>

<div id="jquery_jplayer"></div>

<div class="jp-playlist-player">
  <div class="jp-interface">
    <ul class="jp-controls">
      <li id="jplayer_play" class="jp-play">play</li>
      <li id="jplayer_pause" class="jp-pause">pause</li>
    </ul>
    <div class="jp-progress">
    	<div class="jp-progress-inner">
        <div id="jplayer_load_bar" class="jp-load-bar">
          <div id="jplayer_play_bar" class="jp-play-bar"></div>
        </div>
      </div>
    </div>
    <div id="jplayer_volume_bar" class="jp-volume-bar">
      <div id="jplayer_volume_bar_value" class="jp-volume-bar-value"></div>
    </div>
    <div id="jplayer_play_time" class="jp-play-time"></div>
    <div id="jplayer_total_time" class="jp-total-time"></div>
  </div>
  <div id="jplayer_playlist" class="jp-playlist">
    <ul>
      <!-- The function displayPlayList() uses this unordered list -->
    </ul>
  </div>
</div>