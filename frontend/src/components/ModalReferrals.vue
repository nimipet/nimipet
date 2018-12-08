<template>
    <div style="position:relative;">
        <div style="font-size:24px;text-align:center;margin-bottom: 60px;">
            <b>Get more food</b>
        </div>
        Refer a friend and every time your friend produces 10 pieces of food, we will give you 1 piece of food for free.
        <br>
        <br> For example, if your friend produces 70 pieces of food, she will get 70 and you will get 7 pieces of food.
        <br>
        <br> You can refer as many friends as you wish. There are no limits.
        <br>
        <br>
        Your friend needs to sign up using this unique link: <b><span id="ref-link" style="font-size:16px" @click="selectText('ref-link')">{{referral_url}}</span></b>
        <br>
        <br>
        <div style="margin-top:40px;text-align:center;"><span style="font-size:16px;font-weight:bold;">Your friend list</span>
          <br>
          <br>
          </div>
          <div v-for="referral in referrals">
            <b>{{ referral[0] }}</b>&nbsp;|&nbsp;Food received: {{ referral[1] }}
          </div>
          <!-- <nimipet-character :nimi="nimi" :unixTime="unixTime" :height="'180px'" /> -->
    </div>
</template>
<script>
import nimipetCharacter from "./NimipetCharacter.vue";

export default {
  data: function() {
    return {
      referral_id: '',
      // referral_url: 'Loading...',
      referral_url: 'Loading...',
      referrals: ''
    }
  },
  mounted: function() {
    this.axios.get('/get_referrals')
    .then((response)=> {
      this.referral_id = response.data.referral_id;
      this.referral_url = 'https://nimipet.com/reg/' + this.referral_id;
      this.referrals = response.data.referrals;
    })
    .catch(function(error) {
        console.log(error);
    })
  },
  methods: {
    selectText : function (containerid) {
      if (document.selection) {
        var range = document.body.createTextRange();
        range.moveToElementText(document.getElementById(containerid));
        range.select();
      } else if (window.getSelection) {
        var range = document.createRange();
        range.selectNode(document.getElementById(containerid));
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
      }
    }
  },
  components: {
    nimipetCharacter
  }
}
</script>