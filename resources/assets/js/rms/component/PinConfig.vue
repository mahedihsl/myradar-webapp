<template>
  <div class="row" style="margin: 10px 0;">
    <div class="col-xs-2">
      <select class="form-control">
        <option value="dm1">DM1</option>
        <option value="dm2">DM2</option>
        <option value="dm3">DM3</option>
        <option value="dm4">DM4</option>
        <option value="dm5">DM5</option>
        <option value="dm6">DM6</option>
        <option value="dm7">DM7</option>
        <option value="dm8">DM8</option>
        <option value="am1">AM1</option>
        <option value="am2">AM2</option>
        <option value="am3">AM3</option>
        <option value="am4">AM4</option>
        <option value="am5">AM5</option>
        <option value="am6">AM6</option>
      </select>
    </div>
    <div class="col-xs-3">
      <select class="form-control">
        <option value="main_phase">MAIN PHASE</option>
        <option value="dg_status">DG STATUS</option>
        <option value="dg_fuel">DG FUEL</option>
        <option value="temperature">TEMPERATURE</option>
        <option value="door_status">DOOR STATUS</option>
        <option value="battery_cell">BATTERY CELL</option>
        <option value="battery_terminal">BATTERY TERMINAL</option>
        <option value="battery_offset">BATTERY OFFSET</option>
        <option value="smoke_detector">SMOKE DETECTOR</option>
      </select>
    </div>
    <div class="col-xs-1">
      <input type="text" class="form-control" placeholder="Factor" />
    </div>
    <div class="col-xs-1">
      <input type="text" class="form-control" placeholder="Offset" />
    </div>
    <div class="col-xs-3">
      <input type="text" class="form-control" placeholder="Optional Name" />
    </div>
    <div class="col-xs-2">
      <button class="btn btn-danger btn-sm">
        <span><i class="fa fa-times"></i></span>
      </button>
    </div>
  </div>
</template>

<script>
  export default {
    
  }
</script>

<style lang="scss" scoped>

</style>