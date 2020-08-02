<template>
  <div style="height: 100%; position: relative;">
    <ul class="area-list">
      <li class="area-item" v-for="(v, i) in items" :key="i" @click="onItemClick(i)" :class="{'active': i === activeIndex}">
        <span class="area-name">{{ i + 1}}. {{ v.name }}</span>
        <i class="fa fa-chevron-right item-chevron"></i>
      </li>
    </ul>
    <button class="btn btn-primary create-button" @click="$emit('create')">
      <i class="fa fa-plus mr-4"></i> Add Geofence
    </button>
  </div>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
      required: true,
    }
  },
  data: () => ({
    activeIndex: -1,
  }),
  methods: {
    onItemClick(i) {
      this.activeIndex = i
      this.$emit('item-click', i)
    }
  }
}
</script>

<style scoped>
.create-button {
  width: 100%;
  height: 48px;
  position: absolute;
  bottom: 0;
}
.area-list {
  list-style: none;
  padding-left: 0;
  margin-bottom: 48px;
  overflow: scroll;
}
.area-item {
  cursor: pointer;
  padding: 10px 20px;
  border-top: 1px solid #eeeeee;
  transition: all 0.3s ease-in;
  position: relative;
}
.area-item:last-child {
  border-bottom: 1px solid #eeeeee;
}
.area-item.active {
  background: #f5f5f5;
}
.area-item:hover {
  background: #f5f5f5;
}
.area-name {
  color: #424242;
  font-size: 1.5rem;
  font-weight: 600;
}
.item-chevron {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
}
</style>