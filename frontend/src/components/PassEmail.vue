<template>
  <div>
    <div class="form-errors" v-if="error && !success">
      <div class="error-msg">
        Error: The given data was invalid.
      </div>
    </div>
    <div class="form-errors" v-if="captchaError && !success">
      <div class="error-msg">
        Error: Are you a robot?
      </div>
    </div>
    <form autocomplete="off" @submit.prevent="resetPass" class="form" v-if="!success && !loading" method="post">
      <div class="form-title">
        <b>Reset your password</b>
      </div>
      <div class="form-group" v-bind:class="{ 'has-error': error && errors.email }">
        <label for="email">E-mail:</label>
        <br>
        <input type="email" id="emailToken" class="form-control" v-model="emailToken" required>
      </div>
      <br>
      <button type="submit" class="btn-1" style="margin-bottom:7px;">Submit</button>
    </form>
    <div class="form" v-if="success && !loading">
      Please check your email to confirm password reset.
    </div>
    <div class="form" v-if="loading">
      <div class="lds-spinner" style="margin-top:20px;margin-bottom:10px;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        name: '',
        emailToken: '',
        token: '',
        password: '',
        password_confirmation: '',
        error: false,
        errors: {},
        success: false,
        loading: false,
        captchaError: false
      };
    },
    methods: {
      resetPass(){
        let self = this;
        this.loading = true;
        grecaptcha.ready(function() {
          grecaptcha.execute('6LfbRHsUAAAAAOewdIQRIPANsHz1PkK4hNelYs-M', {action: 'reset'})
          .then(function(token) {
            self.axios.post('/password/email', { email: self.emailToken, captcha: token } )
            .then(result => {
              if (result.data == 'success') {
                self.success = true;
                self.loading = false;
              }
              else if (result.data == 'error-captcha') {
                self.captchaError = true;
                self.loading = false;
              }
            })
            .catch(error => {
              self.error = true;
              self.loading = false;
            });
          });
        });
      },
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