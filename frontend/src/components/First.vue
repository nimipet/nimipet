<template>
  <div>
    <div style="width:250px;margin:0 auto;margin-bottom:5px;">
      <img src="../assets/home_nimipet.png" width="200">
    </div>
    <div id="typed" style="color:#626262;font-size:28px;width:300px;margin:0 auto;display:inline;"></div>
    <div style="font-size:22px;margin-top:40px;margin-bottom:0px;">
      {{ $t("message.create_account")}}
    </div>
    <br>
    <div v-if="$store.state.form == 'registered'" class="registered">Registration complete<br>Please log in</div>
    <register v-if="$store.state.form == 'register'"></register>
    <login v-if="$store.state.form == 'login' || $store.state.form == 'registered'"></login>
    <pass-email v-if="$store.state.form == 'reset'"></pass-email>
    <br>
    <div v-if="$store.state.form == ''">
      <button class="btn" @click="$store.commit('form', 'register')">
        Sign up
      </button>
      <div style="height:15px;"></div>
      <span class="a" @click="$store.commit('form', 'login')">Log in</span>
    </div>
    <span class="a" 
    v-if="$store.state.form == 'login' || $store.state.form == 'registered'" @click="$store.commit('form', 'register')">Sign up</span>
    <span class="a" 
    v-if="$store.state.form == 'register' || $store.state.form == 'reset'" @click="$store.commit('form', 'login')">Log in</span>
    <br>
  </div>
</template>

<script>
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import PassEmail from '../components/PassEmail.vue';

export default {
  data: function() {
    return {
    }
  },
  mounted: function() {
    // window.captcha = document.createElement('script');
    // captcha.setAttribute('src', 'https://www.google.com/recaptcha/api.js?render=6LfbRHsUAAAAAOewdIQRIPANsHz1PkK4hNelYs-M');
    // document.head.appendChild(captcha);

    // typed.js
    let typed = new this.Typed('#typed', {
      strings: ["Orlando", "Alice", "Morty", "Han Solo", "Buckaroo", "Starcrasher", "Shack", "No. 1", "Desmond", "Snake", "Mussburger", "Pandemonium", "Broomhilda", "Kowalczyk", "Cosmo Brown", "Snootles", "Lancaster", "Majestyk", "Dembo", "Maggot", "John Matrix"],
      typeSpeed: 60,
      loop: true
    });
  },
  components: {
    Register,
    Login,
    PassEmail
  }
}
</script>

<style>
  .form {
    width: 250px;
    background-color: #eeeeee;
    border: 1px solid rgb(172, 172, 172);
    border-radius: 5px;
    margin: 0 auto;
    padding: 20px;
    padding-right:10px;
    padding-left: 10px;
  }

  .form-title {
    margin-top:4px;
    margin-bottom:20px;
  }

  .registered {
    font-weight: bold;
    margin-bottom: 13px;
    font-size: 16px;
    line-height: 22px;
    color: #00be20;
  }
</style>