<script type="text/javascript">

$(document).ready(function(){
	// Local copy of jQuery selectors, for performance.
	var jpPlayTime = $(".jquery_jplayer_soundbite_<?php print $delta;?> #jplayer_play_time_<?php print $delta;?>");
	var jpTotalTime = $(".jquery_jplayer_soundbite_<?php print $delta;?> #jplayer_total_time_<?php print $delta;?>");

	$("#jquery_jplayer_soundbite_<?php print $delta;?>").jPlayer({
		ready: function () {
			this.element.jPlayer("setFile", "<?php print $audiopath; ?>");
      console.log(this);
		},
    customCssIds: true,
		volume: 80,
		oggSupport: false,
	  swfPath: "/sites/all/libraries/jPlayer"
	})
  .jPlayer("cssId", "play", "jplayer_play_<?php print $delta;?>")
  .jPlayer("cssId", "pause", "jplayer_pause_<?php print $delta;?>")
  .jPlayer("cssId", "stop", "jplayer_stop_<?php print $delta;?>")
  .jPlayer("cssId", "loadBar", "jplayer_load_bar_<?php print $delta;?>")
  .jPlayer("cssId", "playBar", "jplayer_play_bar_<?php print $delta;?>")
  .jPlayer("cssId", "volumeMin", "jplayer_volume_min_<?php print $delta;?>")
  .jPlayer("cssId", "volumeMax", "jplayer_volume_max_<?php print $delta;?>")
  .jPlayer("cssId", "volumeBar", "jplayer_volume_bar_<?php print $delta;?>")
  .jPlayer("cssId", "volumeBarValue", "jplayer_volume_bar_value_<?php print $delta;?>")
 	.jPlayer("onProgressChange", function(loadPercent, playedPercentRelative, playedPercentAbsolute, playedTime, totalTime) {
		jpPlayTime.text($.jPlayer.convertTime(playedTime));
		jpTotalTime.text($.jPlayer.convertTime(totalTime));
	})
	.jPlayer("onSoundComplete", function() {
		this.element.jPlayer("play");
	});
});

</script>

<div id="jquery_jplayer_soundbite_<?php print $delta;?>"></div>

<div class="jp-playlist-player jquery_jplayer_soundbite">
  <div class="jp-interface">
    <ul class="jp-controls">
      <li id="jplayer_play_<?php print $delta;?>" class="jp-play"></li>
      <li id="jplayer_pause_<?php print $delta;?>" class="jp-pause"></li>
    </ul>
    <div class="jp-progress">
    	<div class="jp-progress-inner">
        <div id="jplayer_load_bar_<?php print $delta;?>" class="jp-load-bar">
          <div id="jplayer_play_bar_<?php print $delta;?>" class="jp-play-bar"></div>
        </div>
      </div>
    </div>
    <div id="jplayer_volume_bar_<?php print $delta;?>" class="jp-volume-bar">
      <div id="jplayer_volume_bar_value_<?php print $delta;?>" class="jp-volume-bar-value"></div>
    </div>
    <div id="jplayer_play_time_<?php print $delta;?>" class="jp-play-time"></div>
    <div id="jplayer_total_time_<?php print $delta;?>" class="jp-total-time"></div>
    
    <?php if ($audiodescription) :?>
    <div class="jp-description"><?php print $audiodescription; ?></div>
    <?php endif; ?>
  </div>
</div>