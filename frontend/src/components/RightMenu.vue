<template>
  <div>
    <img src="/img/trophy_og.png" style="display:block;margin:auto;cursor:pointer;" @click="$store.commit('modal', 'leaderboard');" title="Leaderboard" width="40" class="">
    <br>
    <img src="/img/faq.png" title="FAQ" width="36" @click="$store.commit('modal', 'help');">
    <br>
  </div>
</template>

<script>
export default {
  data: function() {
    return {

    }
  },
  methods: {
    
  },
}
</script>