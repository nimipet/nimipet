<template>
  <div>
    <div>	
        <div style="width:100%;text-align: center;margin-top:40px;">
            <div class="btn-2" @click="$store.commit('modal', 'referrals');">
                Get more food
            </div>
            <br>
            <div class="btn-3" @click="$store.commit('modal', 'pubLink');">
                Get more NIM
            </div>
        </div>
        <div style="margin:0 auto;text-align:center;margin-top:50px;">
            <a @click="$store.commit('modal', 'withdrawal');" class="blacklink" style="cursor:pointer;">Put to sleep</a>
            <br>
            <br>
            <span @click="logout" class="a">Log out</span>
        </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {

    }
  },
  methods: {
    logout: function () {
      // @todo: reset state
      this.$auth.logout();
    }
  },
}
</script>