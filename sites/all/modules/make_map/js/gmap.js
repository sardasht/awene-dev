// Make map globally available for custom tooltips
var map;
// Global setting for fullscreen map
var fullscreen; var nid; var nr = 0; var initMarker; var initMarkerShown = false; var openMarker = false;

$(document).ready(function(){
  if(typeof(GBrowserIsCompatible) == 'function' && GBrowserIsCompatible()) {
		$(".google_map").each(function(){
      var divId = $(this).attr("id");
			nid = $('body').attr('rel');
      
      // Get XML path
      var XMLPath = '/map_xml';
      
      // Modify HTML
      document.getElementById(divId).innerHTML = '<div id="'+divId+'_map" style="width: 100%; height: 100%;">De kaart kon niet geladen worden...</div>';
      
      map = new GMap2(document.getElementById(divId+"_map"));
			map.setMapType(G_SATELLITE_MAP);
      map.setCenter(new GLatLng(37.71859032558813, 47.63671875), 3);
      map.addControl(new GSmallZoomControl3D());
			map.enableScrollWheelZoom();
    
      var baseIcon = new GIcon(G_DEFAULT_ICON);
      baseIcon.iconSize = new GSize(32, 22);
			baseIcon.imageMap = [0,0 , 32,0, 32,22 , 0,22];
			baseIcon.shadow = '';
      baseIcon.iconAnchor = new GPoint(16, 11);
      baseIcon.infoWindowAnchor  = new GPoint(16, 11);
			baseIcon.image = Drupal.settings.make_map.folder + '/img/marker.png';
      
      GDownloadUrl(XMLPath, function(data, responseCode) {
        var xml = GXml.parse(data);
        
        $(xml.documentElement).children("marker").each(function(){
          var point = new GLatLng(parseFloat($(this).children("latitude").text()), parseFloat($(this).children("longitude").text())); 
          addPOI({point: point, options: {
            	icon: baseIcon
						},
            url: $(this).children("url").text(),
						nid: $(this).children("nid").text(),
						label: $(this).children("label").text(),
						latlng: point});
        });
      });
    });
  }
});

function addPOI(poi) {
  var marker = new GMarker(poi.point, poi.options);
	if(nr == 0) {
		marker.openinfoWindow(poi.label);
		openMarker = marker;
		GEvent.addListener(marker, 'click', function() {poiMouseClick(poi.url);});
	  GEvent.addListener(marker, 'mouseover', function() {poiMouseOverWindow(marker, poi.label)});
		GEvent.addListener(marker, 'mouseout', function() {poiMouseOutWindow(marker);});
	} else {
		GEvent.addListener(marker, 'click', function() {poiMouseClick(poi.url);});
	  GEvent.addListener(marker, 'mouseover', function() {poiMouseOverWindow(marker, poi.label)});
	  GEvent.addListener(marker, 'mouseout', function() {poiMouseOutWindow(marker);});
	}
  nr++;
  // Add marker to map
  map.addOverlay(marker);
}

function poiMouseClick(url) {
  window.location = url;
}

function poiMouseOverWindow(marker, content, init) {
	if (openMarker) {
    openMarker.closeinfoWindow();
  }
	marker.openinfoWindow(content);
	openMarker = marker;
}

function poiMouseOutWindow(marker) {
	marker.closeinfoWindow();
}