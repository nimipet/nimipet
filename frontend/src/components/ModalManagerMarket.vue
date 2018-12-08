<template>
    <div >
      <div style="font-size:24px;text-align:center;margin-bottom: 40px;">
        <b>Marketplace</b>
      </div>
      <br>
      To participate in the marketplace as a manager you need to set the initial Nimipet price in ETH. Then anyone can invest into it.
      <br>
      <br>
      The first investor will automatically tokenize the nimipet into a NIMI token, which can be traded.
      <br>
      <br>
      After the NIMI token sale, you are still responsible for the actual nimipet, and the better it performs 
      on the leaderboard, the more valuable will be its token. Your NIMI token can be traded from person to person, and after each sell, 
      you will receive a percentage of the token price.
      <br>
      <br>
      All ETH will be received by the Ethereum wallet that we will generate for you and that belongs to you.
      <br>
      <br>
      Marketplace functionality is not yet available, but you can already set a price for your nimipet, and it will appear on 
      nimipet's public page: 
      <a :href="$store.state.nimi.nimi_slug" target="blank">https://nimipet.com/{{$store.state.nimi.nimi_slug}}</a><br>
      <br>
      Price:&nbsp;<input type="text" v-model.lazy="nimiPrice" style="width:60px;">&nbsp;ETH
      <br>
      <br>
      <br>
      You can also set a message for your nimipet speech bubble.
      <br>
      Leave it empty to not show speech bubble at all.
      <br>
      <textarea style="margin-top:8px;padding:5px;box-sizing:border-box;height:100px;width:300px;" v-model.lazy="nimiMsg" maxlength="200" height="5"></textarea>
      <!-- <br>
      <br>
      <br>
      After the first sale<br>
      You will receive: 95%<br>
      Market fee: 5%
      <br>
      <br>
      After all subsequent sales<br>
      You will receive: 15%<br>
      Investor will receive: 80%<br>
      Market fee: 5%<br>
      <br>
      <br>
      <br>
      Your Ethereum private key<br>
      <span class="a">Show</span> -->
      <!-- <br>
      <br>
      <br>
      <img src="/img/pvz.png" width="700" style="margin-bottom:-60px;"> -->
    </div>
</template>

<script>
export default {
  data: function() {
    return {
      
    }
  },
  mounted: function() {

  },
  computed: {
    nimiPrice: {
      get () {
        return this.$store.state.nimi.nimi_price;
      },
      set (val) {
        let property = 'nimi_price';
        let value = val;
        this.$store.commit('nimi', {property, value});
        
        this.axios.post('/nimi-price', {price: value}).then(result => {
          console.log(result);
        });
      },
    },
    nimiMsg: {
      get () {
        return this.$store.state.nimi.nimi_msg;
      },
      set (val) {
        let property = 'nimi_msg';
        let value = val;
        this.$store.commit('nimi', {property, value});
        
        this.axios.post('/nimi-msg', {nimi_msg: value}).then(result => {
          console.log(result);
        });
      },
    }
  },
}
</script>

<style>

</style>