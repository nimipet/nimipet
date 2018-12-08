<template>
  <div style="margin-top:10px;">
    <div class="form-errors" v-if="error">
      <div>
        <div class="error-msg" style="margin-bottom:14px;">
          Error: Unable to sign in with those credentials.
        </div>
        <span style="rgb(121, 114, 210);">
          If this is your first log in to the new version, <br>please 
          <span class="a" style="rgb(121, 114, 210);" @click="$store.commit('form', 'reset')">reset your password</span>
        </span>
      </div>
    </div>
    <form autocomplete="off" @submit.prevent="login" method="post" class="form" v-if="!loading">
      <div class="form-title">
        <b>Log in to your account</b>
      </div>
      <div class="form-group">
        <label for="email">E-mail:</label>
        <br>
        <input type="email" id="email-login" class="form-control" v-model="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <br>
        <input type="password" id="password-login" class="form-control" v-model="password" required>
      </div>
      <br>
      <button type="submit" class="btn-1">Log in</button>
      <div style="margin-top:15px;margin-bottom:0px;">
        <span class="a" @click="$store.commit('form', 'reset')">Forgot password?</span>
      </div>
    </form>
    <div class="form" v-if="loading">
      <div class="lds-spinner" style="margin-top:20px;margin-bottom:10px;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        email: null,
        password: null,
        error: false,
        loading: false
      }
    },
    methods: {
      login(){
        this.$store.commit("reset");
        
        this.loading = true;
        var app = this;
        grecaptcha.ready(function() {
          grecaptcha.execute('6LfbRHsUAAAAAOewdIQRIPANsHz1PkK4hNelYs-M', {action: 'login'})
          .then(function(token) {
            app.$auth.login({
              params: {
                email: app.email,
                password: app.password,
                captcha: token
              }, 
              success: function () {},
              error: function (resp) {
                this.error = true;
                this.loading = false;
              },
              rememberMe: true,
              fetchUser: true,
            });
          });
        });
      },
    }
  }   
</script>