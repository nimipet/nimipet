<template>
	<div>
    <p><img src="/img/airdrop.png" alt="" width="600" style="margin-bottom:30px;"></p>

    <div style="font-size:24px;font-weight:bold;margin-bottom:25px;">
      Nimipet Weekly NIM Airdrop
    </div>

    <p>Total NIM airdropped: <b>{{ amount }} NIM</b>
    <br>

    Date of the airdrop: <b>{{ timestamp }}</b>
    <br>
    <br>

    <span v-html="html"></span>
    
    <div style="clear:both;margin-top:30px;margin-bottom:-20px;">
    This page updates automatically after every airdrop
    <br>
    Airdrops happen every week on Sunday 23:59 UTC 00:00
    </div>

    <footer-template/>

	</div>
</template>

<script>
  import Footer from '../components/Footer.vue';
  import RightMenu from '../components/RightMenu.vue';

  export default {
		data: function() {
			return {
        amount: 0,
        html: '',
        timestamp: ''
			}
    },
		mounted: function() {
      document.getElementById('splashScreen').style.display = 'none';

      this.axios.get('/get-airdrop').then(result => {
        this.amount = result.data.amount;
        this.html = result.data.html;
        this.timestamp = result.data.timestamp;
      });

    },
    computed: {
    
    },
		methods: {
			
		},
		components: {
      footerTemplate: Footer,
      RightMenu
		},
  }
</script>

<style>

</style>