if(typeof(GOverlay) == 'function') {
  function infoWindow(marker,html,width) {
    this.html_ = html;
    this.width_ = (width ? width + 'px' : 'auto');
    this.marker_ = marker;
  }
  infoWindow.prototype = new GOverlay();
  infoWindow.prototype.initialize = function(map) {
    var div = document.createElement("div");
    div.style.display = 'none';
    map.getPane(G_MAP_FLOAT_PANE).appendChild(div);
    this.map_ = map;
    this.container_ = div;
  }
  infoWindow.prototype.remove = function() {
    this.container_.parentNode.removeChild(this.container_);
  }
  infoWindow.prototype.copy = function() {
    return new infoWindow(this.html_);
  }
  infoWindow.prototype.redraw = function(force) {
    if (!force) return;
    
    var pixelLocation = this.map_.fromLatLngToDivPixel(this.marker_.getPoint());
    
    this.container_.innerHTML = this.html_;
    this.container_.style.position = 'absolute';
    this.container_.style.left = (pixelLocation.x - 127) + "px";
    this.container_.style.top = (pixelLocation.y + 10) + "px";
    this.container_.style.width = '255px';
    this.container_.style.bgColor  = 'transparent';
    this.container_.style.display = 'block';
    this.container_.style.zIndex = '1000';
  }
  GMarker.prototype.infoWindowInstance = null;
  GMarker.prototype.openinfoWindow = function(content) {
    //don't show the tool tip if there is acustom info window
    if(this.infoWindowInstance == null) {
      this.infoWindowInstance = new infoWindow(this,content)
      pixelLocation = map.fromLatLngToDivPixel(this.getPoint());
      allowedBounds = map.getBounds();
      map.addOverlay(this.infoWindowInstance);
      
    }
  }
  GMarker.prototype.closeinfoWindow = function() {
    if(this.infoWindowInstance != null) {
      map.removeOverlay(this.infoWindowInstance);
      this.infoWindowInstance = null;
    }
  }
}