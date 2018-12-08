<template>
  <div style="margin-top:10px;">
    <div class="form-errors" v-if="error && !success">
      <div class="error-msg" v-if="errors.email">
        Error: {{ errors.email[0] }}
      </div>
      <div class="error-msg" v-if="errors.password">
        Error: {{ errors.password[0] }}
      </div>
      <div class="error-msg" v-if="errorPassRepeat">
        Error: Passwords do not match.
      </div>
    </div>
    <form autocomplete="off" @submit.prevent="register" class="form" v-if="!success && !loading" method="post">
      <div class="form-title">
        <b>Create new account</b>
      </div>
      <div class="form-group" v-bind:class="{ 'has-error': error && errors.email }">
        <label for="email">E-mail:</label>
        <br>
        <input type="email" id="email" class="form-control" v-model="email" required>
      </div>
      <div class="form-group" v-bind:class="{ 'has-error': error && errors.password }">
        <label for="password">Password:</label>
        <br>
        <input type="password" id="password" class="form-control" v-model="password" required>
      </div>
      <div class="form-group">
        <label for="password">Repeat password:</label>
        <br>
        <input type="password" id="password-repeat" class="form-control" v-model="passwordRepeat" required>
      </div>
      <input type="hidden" v-model="referred_by">
      <br>
      <button type="submit" class="btn-1" style="margin-bottom:7px;">Sign up</button>
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
        email: '',
        referred_by: this.$store.state.referred_by,
        password: '',
        passwordRepeat: '',
        errorPassRepeat: '',
        error: false,
        errors: {},
        success: false,
        loading: false
      };
    },
    methods: {
      register(){
        if (this.password != this.passwordRepeat) {
          this.error = true;
          this.errorPassRepeat = true;
          return;
        }
        this.error = false;
        this.errorPassRepeat = false;
        this.loading = true;
        let self = this;
        grecaptcha.ready(function() {
          grecaptcha.execute('6LfbRHsUAAAAAOewdIQRIPANsHz1PkK4hNelYs-M', {action: 'register'})
          .then(function(token) {
            self.$auth.register({
              data: {
                referred_by: self.referred_by,
                email: self.email,
                password: self.password,
                captcha: token
              },
              success: function () {
                this.$store.commit('form', 'registered');
                this.loading = false;
              },
              error: function (resp) {
                self.error = true;
                self.errors = resp.response.data.errors;
                this.loading = false;
              },
              redirect: null
            });
          });
        });
      }
    }
  }
</script>

<style>
  .form-group {
    margin-top: 10px;
  }

  .form-control {
    width: 180px;
    height: 20px;
    padding-left: 2px;
  }

  .form-errors {
    margin-top: 5px;
    margin-bottom: 20px;
  }

  .error-msg {
    color: red;
    font-weight: bold;
  }
</style>