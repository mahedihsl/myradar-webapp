<template>
  <div class="col-xs-12">
    <button class="btn btn-default" @click="close">
      <i class="fa fa-times"></i> Close
    </button>
    <br/><br/><br/>
    <ul class="list-group">
      <li class="list-group-item" :class="{'list-group-item-success': item.status, 'list-group-item-danger': !item.status}" v-for="item in list" :key="item.id">
        <span class="badge">{{item.date}}</span>
        Account was {{item.status ? 'Enabled' : 'Disabled'}}
      </li>
    </ul>
  </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import CustomerApi from '../../../../api/CustomerApi';

export default {
  props: ['customer'],
  data: () => ({
    list: [],
    loading: false,
  }),
  mounted() {
    CustomerApi.getToggleHistory(this.customer.id)
                .then(this.onHistoryFound.bind(this));
  },
  methods: {
    onHistoryFound(list) {
      this.list = list;
    },

    close() {
      EventBus.$emit('toggle-history-closed', null);
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
