<template>
	<div>
    <div v-if="!$auth.check()" id="home-nim-container">
      <div style="position:absolute;top:16px;left:16px;font-size:18px;line-height:27px;margin-right:80px;text-align:left;">
        <span style="font-size:24px;font-weight:bold;">Nimipet</span>
        <br>
        {{ $t("message.home_header") }}
        <br>
        <select style="margin-top:13px;border-radius:2px;padding:3px 2px 3px 2px;border-color:#c9c9c9;" v-model="language">
          <option value="en">English</option>
          <option value="de">German</option>
          <option value="fr">French</option>
          <option value="it">Italian</option>
          <option value="jp">Japanese</option>
          <option value="kr">South Korean</option>
          <option value="nl">Dutch</option>
          <option value="ru">Russian</option>
          <option value="ptbr">Portuguese</option>
        </select>
      </div>
      <div class="right-menu">
				<right-menu/>
      </div>
      <pass-reset v-if="this.email && this.token" />
      <first v-else/>
    </div>
    <div v-if="$auth.check()">
      <manager />
    </div>
		<footer-template/>
	</div>
</template>

<script>
  import First from '../components/First.vue';
  import Manager from '../components/Manager.vue';
  import Footer from '../components/Footer.vue';
  import RightMenu from '../components/RightMenu.vue';
  import PassReset from '../components/PassReset.vue';

  export default {
    props: ['email', 'token', 'referred_by'],
		data: function() {
			return {
			}
    },
		mounted: function() {
      document.getElementById('splashScreen').style.display = 'none';
      
      if (this.$cookies.get('language') != null) {
        let lang = this.$cookies.get('language');
        this.$store.commit('language', lang);
      }
      else {
        this.$store.commit('language', 'en');
      }

      if (this.referred_by) {
        this.$store.commit('form', 'register');
        this.$store.commit('referred_by', this.referred_by);
      }

    },
    computed: {
      language: {
        get () {
          this.$i18n.locale = this.$store.state.language;
          return this.$store.state.language;
        },
        set (lang) {
          this.$store.commit('language', lang);
          this.$cookies.set("language", lang, Infinity);
        },
      },
    },
		methods: {
			showLeaderboard: function() {
        this.activeModal = 'leaderboard';
        this.modal = true;
			},
			showFaqs: function() {
        this.activeModal = 'faqs';
        this.modal = true;
			},
		},
		components: {
      footerTemplate: Footer,
      Manager,
      First,
      RightMenu,
      PassReset
		},
  }
</script>

<style>
  .grecaptcha-badge {
    display: none;
  }
</style>