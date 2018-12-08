<template>
  <div>
    <span v-if="mod != 'pub'">
      <img src="/img/icon-palette.png" title="Style" width="36" @click="styleChange">
      <br>
      <img src="/img/icon-divider.png" style="" width="28">
      <br>
      <img src="/img/icon-inventory.png" style="" title="Inventory" width="34" 
      @click="$store.commit('modal', 'inventory');" >
      <br>
      <img src="/img/icon-mp.png" style="display:block;margin:auto;margin-top:7px;cursor:pointer;" 
      @click="$store.commit('modal', 'managerMarket');" title="Marketplace" width="37">
    </span>
  </div>
</template>

<script>
export default {
  data: function() {
    return {

    }
  },
  methods: {
    styleChange: function () {
      if (this.$store.state.styleChange) {
        this.$store.commit('speech', 'general');
      }
      this.$store.commit('styleChange');
    }
  },
  props: ['mod']
}
</script>