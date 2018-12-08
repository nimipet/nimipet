<template>

  <div>
		
    <div>

		<div class="row">

			<div class="left-menu">
				<miner v-if="this.$store.state.nimi.nimi_mood == 'peyote'" v-bind:class="'peyote-trip'" />
        <miner v-else />

				<food v-if="this.$store.state.nimi.nimi_mood == 'peyote'" v-bind:class="'peyote-trip'" />
        <food v-else />
			</div>

			<div class="col-md-8 col-sm-12 game-container">
        <speech-bubble v-if="this.$store.state.nimi.nimi_mood != 'unborn' && this.$store.state.nimi.nimi_mood != 'dead' && this.$store.state.nimi.nimi_mood == 'peyote'" v-bind:class="'peyote-trip'" />
        <speech-bubble v-else-if="this.$store.state.nimi.nimi_mood != 'unborn' && this.$store.state.nimi.nimi_mood != 'dead'" />

				<nimipet :nimi="this.$store.state.nimi" v-if="this.$store.state.nimi.nimi_mood == 'peyote'" v-bind:class="'peyote-trip'" />
        <nimipet :nimi="this.$store.state.nimi" v-else />

        <div class="lds-spinner" style="margin-top:60px;margin-bottom:10px;" v-if="!this.$store.state.loaded && this.$store.state.nimi.nimi_mood != 'unborn'"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>

        <info-boxes v-if="this.$store.state.nimi.nimi_mood == 'peyote' && this.$store.state.loaded" v-bind:class="'peyote-trip'" />
				<info-boxes v-else-if="this.$store.state.loaded && this.$store.state.nimi.nimi_mood != 'unborn'"/>

        <bottom v-if="this.$store.state.nimi.nimi_mood == 'peyote' && this.$store.state.loaded" v-bind:class="'peyote-trip'" />
				<bottom v-else-if="this.$store.state.loaded && this.$store.state.nimi.nimi_mood != 'unborn'" />
			</div>

			<div class="col-md-2 right-menu">
				<right-menu v-if="this.$store.state.nimi.nimi_mood == 'peyote'" v-bind:class="'peyote-trip'" />
        <right-menu v-else />

				<manager-right v-if="this.$store.state.nimi.nimi_mood == 'peyote'" v-bind:class="'peyote-trip'" />
        <manager-right v-else />
			</div>

		</div>

    </div>

  </div>

</template>

<script>
  import infoBoxes from './InfoBoxes.vue';
  import miner from './LeftMiner.vue';
  import food from './LeftFood.vue';
  import nimipet from './Nimipet.vue';
  import bottom from './Bottom.vue';
  import managerRight from './ManagerRight.vue';
  import rightMenu from './RightMenu.vue';
  import speechBubble from './SpeechBubble.vue'

  export default {
      data: function() {
          return {
            speechBubble
          }
      },		
      methods: {

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
    },
    beforeCreate: function() {
      this.axios.get('/get-nimipet').then(result => {
        // make user id global
        window.user_id = result.data[0].user_id;

        // 1. unborn nimi
        if (result.data == 'first-login') {
          let property = 'nimi_mood';
          let value = 'unborn';
          this.$store.commit('nimi', {property, value});
        }

        // 2. dead nimi
        else if (result.data[0].nimi_state == 'dead') {
          let property = 'nimi_mood';
          let value = 'dead';
          this.$store.commit('nimi', {property, value});
        }

        // 3. nimi with magic
        else if (result.data[0].nimi_meta != null) {
            let metaData = JSON.parse(result.data[0].nimi_meta);
            result.data[0].nimi_mood = metaData[0];
            // @todo: do a check, if cause met, and if yes, call backend to update meta
        }

        // 4. style
        if (typeof(result.data[0].nimi_style) != 'undefined') {
          result.data[0].nimi_style = JSON.parse(result.data[0].nimi_style.replace(/\\/g, ''));
        }

        // 4. update nimi object state
        for (const key of Object.keys(result.data[0])) {
          let property = key;
          let value = result.data[0][key];
          this.$store.commit('nimi', {property, value});
          this.$store.commit('loaded', true);
        }
      })
      // .catch(error => {
      //   // auto logout if error
      //   if (error.message == "Request failed with status code 500") {
      //     this.$auth.logout();
      //   }
      // });

      // get and update items
      this.axios.get('/get-items').then(result => {
        for (const key of Object.keys(result.data)) {
          let type = result.data[key].type;
          let item = result.data[key].item;
          let available = result.data[key].available;
          this.$store.commit('items', { type, item, available } );
        }
      });

    },
    mounted: function() {
      window.scrollTo(0, 0);
    },
    created () {
      this.$store.watch(
        (state)=>{
          return this.$store.state.nimi.nimi_lastfed;
        },
        (newValue, oldValue)=>{
          if (newValue != null) {
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
            
            // this.timer();
          }
        },
      )
    },
    components: {
      miner,
      food,
      nimipet,
      infoBoxes,
      bottom,
      managerRight,
      rightMenu,
      speechBubble
    }
  }
</script>

<style>
  .container {
      margin: 0 auto;
  }

  .row {
      margin-right: 0 !important;
      margin-left: 0 !important;
  }

  .left-menu {
      top: 25px;
      position: absolute;
      left: 25px;
  }
    
  .mobile-footer {
    display: none;
  }

  .desktop-footer { 
    display: block;
  }

  @media screen and (max-width: 500px) {
      .left-menu {
        left: 15px;
        top: 20px;
      }
      body {
        padding-left: 12px;
        padding-right: 12px;
      }
      .mobile-footer {
        display: block;
        line-height: 27px;
      }
      .desktop-footer { 
        display: none;
      }
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