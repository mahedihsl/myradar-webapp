export default class Pin {
  constructor(latlng) {
    this.latlng = latlng
    this.iconUrl = 'http://myradar.com.bd/images/ic-pin@2x.png'
  }

  position() {
    return this.latlng
  }

  latLng() {
    return { lat: this.latlng.lat(), lng: this.latlng.lng() }
  }

  lngLat() {
    return [this.latlng.lng(), this.latlng.lat()]
  }

  icon() {
    return {
      url: this.iconUrl,
      // size: new google.maps.Size(64, 64),
      // scale: 0.5,
      scaledSize: new google.maps.Size(32, 32)
      // origin: new google.maps.Point(0, 0),
      // anchor: new google.maps.Point(0, 32),
    }
  }
}