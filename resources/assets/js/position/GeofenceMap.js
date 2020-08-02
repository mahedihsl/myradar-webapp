import { Map } from './map'
import Pin from './pin'

export default class GeofenceMap extends Map {
  constructor(domId) {
    super(domId)

    this.polygon = null
    this.pins = []
  }

  updatePolygon() {
    if (!!this.polygon) {
        this.polygon.setMap(null)
    }
    const vertices = [...this.pins, this.pins[0]]
    this.polygon = new google.maps.Polygon({
        paths: vertices.map(v => v.latLng()),
        strokeColor: "#3f51b5",
        strokeOpacity: 0.8,
        strokeWeight: 1,
        fillColor: "#3f51b5",
        fillOpacity: 0.15,
    });
    this.polygon.setMap(this.map);
  }

  addPin(event) {
    const pin = new Pin(event.latLng)

    this.pins.push(pin)
    if (this.pins.length > 2) {
        this.updatePolygon()
    }
    
    return new google.maps.Marker({
        position: pin.position(),
        map: this.map,
        icon: pin.icon(),
    })
  }

  init(center = null) {
    super.init(center)

    this.map.addListener('click', this.addPin.bind(this))
  }

  isPolygonDefined() {
    return !!this.polygon
  }
}