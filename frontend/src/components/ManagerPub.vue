<template>

  <div>
		
    <div>

		<div class="row">

			<div class="left-menu">
        <miner />

        <div id="nimipet-food">
          <div class="food-piece " v-for="(index, item) in this.$store.state.items.food" v-if="index > 0" :key="item" @click="animalsFeed">

            <div style="margin-bottom:-6px">
              <img :src="`/img/food-${item}.png`" v-bind:title="item.charAt(0).toUpperCase() + item.slice(1)" v-bind:class="'food-icon-pub food-icon '+item">
            </div>

          </div>
        </div>
			</div>

			<div class="game-container">

        <span v-if="!error">
          <speech-bubble v-if="this.$store.state.nimi.nimi_mood != 'unborn' && this.$store.state.nimi.nimi_mood != 'dead'" mod="pub"/>

          <div class="scaled">

            <nimipet :nimi="this.$store.state.nimi" mod="pub" />

            <div class="lds-spinner" style="margin-top:60px;margin-bottom:10px;" v-if="!loaded"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            
            <div v-if="loaded">
              <div class="infobox-pub">
                <div class="infobox-pub-text">
                <div style="margin-bottom:12px;font-weight:bold;">Nimipet details</div>
                Position: <span class="mono">{{ $store.state.nimi.nimi_position }}</span><br>
                Points: <span class="mono">{{ Math.floor($store.state.nimi.nimi_points) }}</span><br>
                NIM: <span class="mono">{{ Math.floor($store.state.nimi.nimi_value) }}</span><br>
                Age: <span class="mono">{{age}} d.</span><br> 
                <span v-if="$store.state.timePassed != 'Hibernated'">
                  Last fed: <span class="mono">{{$store.state.timePassed}}</span> ago
                </span>
                <span v-else>
                  Last fed: {{$store.state.timePassed}}
                </span>
                </div>
              </div>
              <br>
              <br>
              <br>
              <br>
              <b>Become a Nimipet investor</b>
              <br>
              <br>
              <span style="line-height:18px;">
                Buy the NIMI token now and sell it later
                <!-- Buy and sell the NIMI token (Ethereum ERC-721) which is associated with this unique nimipet -->
                <!-- Invest into this nimipet by buying a NIMI token (Ethereum ERC721),
                associated with this unique nimipet. -->
              </span>
              <br>
              <br>
              Token price: <span style="font-size:17px;font-weight:bold;">
              <span v-if="price != null">
                {{ price }} ETH
                <br>
                <button class="btn-1" style="margin-top:15px;margin-bottom:10px;" v-on:click="alertSoon">Buy NIMI</button>
              </span>
              <span v-else>
                Not for sale
                <br>
                <button class="btn-1-disabled" style="margin-top:15px;margin-bottom:10px;" disabled>Buy NIMI</button>
              </span></span>
              
              <br>
              <span class="a" v-on:click="alertSoon">More details</span>
              <br>
              <br>
              <br>
              <br>
              <br>
              <b>Become a Nimipet manager</b>
              <br>
              <br>
              Grow your own nimipet and receive crypto rewards
              <br>
              <router-link :to="referral_url">
                <button class="btn-1" style="margin-top:15px;margin-bottom:10px;" @click="signUp">Sign up</button>
              </router-link>
              <br>
              <router-link to="/">
                <span class="a" @click="logIn">Log in</span>
              </router-link>
            </div>

          </div>

          <div class="scaled-bottom">&nbsp;</div>

        </span>

        <span v-else>
          <div style="margin:0 auto;text-align:center;margin-top:100px;">
            <div style="width:250px;margin:0 auto;">
              <img src="/img/404.gif" width="250">
            </div>
            <div style="font-size:32px;margin-top:10px;margin-bottom:150px;">404: Page not found</div>
          </div>
        </span>

			</div>

			<div class="col-md-2 right-menu">
        <right-menu />
      
        <manager-right :mod="'pub'"/>
			</div>

		</div>

    </div>
    
    <footer-template/>

  </div>

</template>

<script>
  import miner from './LeftMiner.vue';
  import food from './LeftFood.vue';
  import nimipet from './Nimipet.vue';
  import managerRight from './ManagerRight.vue';
  import rightMenu from './RightMenu.vue';
  import Footer from '../components/Footer.vue';
  import speechBubble from './SpeechBubble.vue';

  export default {
    props: ['slug'],
    data: function() {
        return {
          loaded : false,
          age : 0,
          price: '',
          referral_url: '',
          error: false
        }
    },		
    methods: {
      alertSoon: function () {
        alert('Soon...');
      },
      
      logIn: function () {
        this.$store.commit('form', 'login');
      },
      
      signUp: function () {
        this.$store.commit('form', 'register');
      },

      showFaq: function() {
        this.$store.commit('modal', 'help');
        this.modal = true;
      },

      showLeaderboard: function() {
        this.activeModal = 'leaderboard';
        this.modal = true
      },

      timer: function() {
        if (this.$store.state.nimi.nimi_lastfed != null) {
          let timePassed = Date.parse(this.$store.state.nimi.current_time) - Date.parse(this.$store.state.nimi.nimi_lastfed);

          let s = Math.floor((timePassed / 1000) % 60);
          let m = Math.floor((timePassed / 1000 / 60) % 60);
          let h = Math.floor((timePassed / (1000 * 60 * 60)) % 24);

          let timeFormatted = ('0' + (h)).slice(-2) + ":" + ('0' + m).slice(-2) + ":" + ('0' + s).slice(-2);
          this.$store.commit('timePassed', timeFormatted);
          
          if (typeof window.myTimer !== 'undefined') {
            clearInterval(window.myTimer);
          }
          
          window.myTimer = setInterval(timerOn, 1000);
          const self = this;

          function timerOn() {
            timePassed += 1000;

            var s = Math.floor( (timePassed /1000) % 60 );
            var m = Math.floor( (timePassed /1000/60) % 60 );
            var h = Math.floor( (timePassed /(1000*60*60)) % 24 );
        
            let timeFormatted = ('0' + (h)).slice(-2) + ":" + ('0' + m).slice(-2) + ":" + ('0' + s).slice(-2);
            self.$store.commit('timePassed', timeFormatted);
          };
        }
      },

      animalsFeed: function () {
        alert("Please do not feed the pet.");
      }

    },
    mounted: function() {
      document.getElementById('splashScreen').style.display = 'none';
      window.scrollTo(0, 0);

      this.axios.post('/get-nimi-pub', { nimi_slug: this.slug }).then(result => {
        
        if (result.data == 'first-login') {
          this.error = true;
          return;
        }

        // 1. unborn nimi

        // 2. dead nimi
        if (result.data.nimipet[0].nimi_state == 'dead') {
          let property = 'nimi_mood';
          let value = 'dead';
          this.$store.commit('nimi', {property, value});
        }

        // 3. nimi with magic
        else if (result.data.nimipet[0].nimi_meta != null) {
          let metaData = JSON.parse(result.data.nimipet[0].nimi_meta);
          result.data.nimipet[0].nimi_mood = metaData[0];
          // @todo: do a check, if cause met, and if yes, call backend to update meta
        }

        // 4. style
        if (typeof(result.data.nimipet[0].nimi_style) != 'undefined') {
          result.data.nimipet[0].nimi_style = JSON.parse(result.data.nimipet[0].nimi_style.replace(/\\/g, ''));
        }

        // 5. update nimi object state
        for (const key of Object.keys(result.data.nimipet[0])) {
          let property = key;
          let value = result.data.nimipet[0][key];
          this.$store.commit('nimi', {property, value});
          this.loaded = true;
        }

        // PUB. update nimi id
        window.nimi_id = result.data.nimipet[0].id;

        // Items
        let self = this;
        // console.log(result.data.items);
        result.data.items.forEach(function(itemObj) {
          let type = itemObj.type;
          if (type != "magic") {
            let item = itemObj.item;
            let available = itemObj.available;
            self.$store.commit('items', { type, item, available } );
          }
        });

      });

      this.axios.post('/referral-id', {nimi_slug: this.slug})
      .then((response)=> {
        // console.log(response.data);
        let referral_id = response.data;
        this.referral_url = '/reg/' + referral_id;
      })
      .catch(function(error) {
          console.log(error);
      })

    },
    created () {
      this.$store.watch(
        (state)=>{
          return this.$store.state.nimi.nimi_lastfed;
        },
        (newValue, oldValue)=>{
          if (this.$store.state.nimi.nimi_meta != null) {
            let metaData = JSON.parse(this.$store.state.nimi.nimi_meta);
            if (metaData[0] != 'hibernation') {
              this.timer();
            }
            else {
              this.$store.commit('timePassed', 'Hibernated')
            }
          }
          else {
            this.timer();
          }
          this.price = this.$store.state.nimi.nimi_price;

          this.age = Date.parse(this.$store.state.nimi.current_time) - Date.parse(this.$store.state.nimi.nimi_born);
          this.age = Math.floor(this.age / 86400000);

        },
      )
    },
    components: {
      miner,
      food,
      nimipet,
      managerRight,
      rightMenu,
      footerTemplate: Footer,
      speechBubble
    }
  }
</script>

<style>
  @media only screen and (min-width: 600px) {
    .scaled {
      transform: scale(1.15);
      transform-origin: top;
      padding-top: 10px;
    }
    .scaled-bottom {
      height:150px;
    }
  }


  .mono {
    font-family: monospace;
  }

  .food-icon-pub {
    cursor:default!important;
  }

  .infobox-pub {
    height: 156px;
    width: 200px;
    line-height: 18px;
    padding-top: 20px;
    text-align: center;
    background-color: #efefef;
    border: 1px solid #929292;
    border-radius: 5px;
    display: inline-Block;
    margin: 10px;
    margin-top: 5px;
  }

  .infobox-pub-text {
    height:50px;
    width: 100%;
    text-align: center;
    margin-bottom:10px;
    line-height: 21px;
  }

  .container {
      margin: 0 auto;
  }

  .row {
      margin-right: 0 !important;
      margin-left: 0 !important;
  }

  .mining-details {
      display: block;
      position: relative;
      text-align: left;
  }

  .right-menu img:nth-child(n+1) {
      display: block;
      margin: auto;
      margin-top: 7px;
      cursor: pointer;
  }

/* loading spinner */

  .lds-spinner {
    color: official;
    display: inline-block;
    position: relative;
    width: 64px;
    height: 64px;
  }
  .lds-spinner div {
    transform-origin: 32px 32px;
    animation: lds-spinner 1.2s linear infinite;
  }
  .lds-spinner div:after {
    content: " ";
    display: block;
    position: absolute;
    top: 3px;
    left: 29px;
    width: 5px;
    height: 14px;
    border-radius: 20%;
    background: rgb(175, 175, 175);
  }
  .lds-spinner div:nth-child(1) {
    transform: rotate(0deg);
    animation-delay: -1.1s;
  }
  .lds-spinner div:nth-child(2) {
    transform: rotate(30deg);
    animation-delay: -1s;
  }
  .lds-spinner div:nth-child(3) {
    transform: rotate(60deg);
    animation-delay: -0.9s;
  }
  .lds-spinner div:nth-child(4) {
    transform: rotate(90deg);
    animation-delay: -0.8s;
  }
  .lds-spinner div:nth-child(5) {
    transform: rotate(120deg);
    animation-delay: -0.7s;
  }
  .lds-spinner div:nth-child(6) {
    transform: rotate(150deg);
    animation-delay: -0.6s;
  }
  .lds-spinner div:nth-child(7) {
    transform: rotate(180deg);
    animation-delay: -0.5s;
  }
  .lds-spinner div:nth-child(8) {
    transform: rotate(210deg);
    animation-delay: -0.4s;
  }
  .lds-spinner div:nth-child(9) {
    transform: rotate(240deg);
    animation-delay: -0.3s;
  }
  .lds-spinner div:nth-child(10) {
    transform: rotate(270deg);
    animation-delay: -0.2s;
  }
  .lds-spinner div:nth-child(11) {
    transform: rotate(300deg);
    animation-delay: -0.1s;
  }
  .lds-spinner div:nth-child(12) {
    transform: rotate(330deg);
    animation-delay: 0s;
  }
  @keyframes lds-spinner {
    0% {
      opacity: 1;
    }
    100% {
      opacity: 0;
    }
  }


  /* peyote CSS trip */

  .peyote-trip {
     -webkit-animation-name: spin;
    -webkit-animation-duration: 3000ms;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-timing-function: linear;
    -moz-animation-name: spin;
    -moz-animation-duration: 3000ms;
    -moz-animation-iteration-count: infinite;
    -moz-animation-timing-function: linear;
    -ms-animation-name: spin;
    -ms-animation-duration: 3000ms;
    -ms-animation-iteration-count: infinite;
    -ms-animation-timing-function: linear;
    animation-name: spin;
    animation-duration: 3000ms;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
  }

  @-moz-keyframes spin {
    from { -moz-transform: rotate(0deg); }
    to { -moz-transform: rotate(360deg); }
  }
  @-webkit-keyframes spin {
    from { -webkit-transform: rotate(0deg); }
    to { -webkit-transform: rotate(360deg); }
  }
  @keyframes spin {
    from {transform:rotate(0deg);}
    to {transform:rotate(360deg);}
  }
</style>