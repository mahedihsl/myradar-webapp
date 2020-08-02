<template>
  <div class="row" style="position: relative;">
    <div class="col-xs-12 spacing" id="builder-header">
      <h4 class="text-dark">Make New Geofence</h4>
    </div>
    <div class="col-xs-12 builder-content">
      <div class="form-group input-wrapper">
        <label for="name">Name of the Geofence</label>
        <input type="text" class="form-control" v-model="name" placeholder="Ex: Dhanmondi"/>
        <div class="error-wrapper">
          <p v-for="(e, i) in errors" :key="i" class="text-danger single-error">
            <i class="fa fa-exclamation-circle mr-4"></i> {{ e }}
          </p>
        </div>
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

    <saving-spinner v-if="loading"></saving-spinner>
  </div>
</template>

<script>
import GeofenceMap from '../../position/GeofenceMap'

import SavingSpinner from './SavingSpinner'

export default {
  components: {
    SavingSpinner
  },
  data: () => ({
    name: '',
    errors: [],
    map: null,
    loading: false,
  }),
  mounted() {
    this.map = new GeofenceMap('map-container')
    this.map.init()
  },
  methods: {
    async save() {
      if (this.validate()) {
        this.loading = true
        await this.$store.dispatch('save', {
          name: this.name,
          coordinates: this.map.coordinates()
        })
        await this.$store.dispatch('fetch')
        this.$emit('cancel')
      }
    },

    validate() {
      this.errors = []
      let validationStatus = true
      if (this.name.length < 3) {
        this.errors.push('Name must be at least 4 characters long')
        validationStatus = false
      }
      if (!this.map.isPolygonDefined()) {
        this.errors.push('Click on the map to define an area for the Geofence')
        validationStatus = false
      }
      return validationStatus
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
.error-wrapper {
  margin: 10px 0;
}
.single-error {
  margin: 0 !important;
}
</style>