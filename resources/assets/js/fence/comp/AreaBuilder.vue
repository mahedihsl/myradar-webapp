<template>
  <div class="row">
    <div class="col-xs-12 spacing" id="builder-header">
      <h4 class="text-dark">Make New Geofence</h4>
    </div>
    <div class="col-xs-12 builder-content">
      <div class="form-group input-wrapper">
        <label for="name">Name of the Geofence</label>
        <input type="text" class="form-control" v-model="name" placeholder="Ex: Dhanmondi"/>
      </div>
      <div id="map-container"></div>
    </div>
    <div class="col-xs-12 spacing">
      <button class="btn btn-success pull-right ml-6" @click="save">
        <i class="fa fa-check"></i>
        Save
      </button>
      <button class="btn btn-default pull-right" @click="$emit('cancel')">
        <i class="fa fa-times"></i>
        Cancel
      </button>
    </div>
  </div>
</template>

<script>
import GeofenceMap from '../../position/GeofenceMap'

export default {
  data: () => ({
    name: '',
    map: null,
  }),
  mounted() {
    this.map = new GeofenceMap('map-container')
    this.map.init()
  },
  methods: {
    save() {
      this.map.drawPolygon()
      if (this.validate()) {
        
      }
    }
  }
}
</script>

<style scoped>
.input-wrapper {
  width: 90%;
  margin: 20px auto;
}
.spacing {
  padding: 10px 30px !important;
}
.builder-content {
  border-top: 1px solid #eeeeee;
  border-bottom: 1px solid #eeeeee;
}
#map-container {
  min-height: 350px;
  background: #f5f5f5;
}
#builder-header {
  cursor: move;
}
</style>