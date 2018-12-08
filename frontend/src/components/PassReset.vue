<template>
  <div>
    <div style="height:50px;"></div>
    <div style="height:50px;margin-bottom:30px;" v-if="!success">
      <h3 style="margin-bottom:8px">Choose a new password</h3>
      Minimum length: 10 symbols
    </div>
    <div style="height:50px;margin-bottom:10px;" v-if="success">
      <h3 style="margin-bottom:8px">Success!</h3>
    </div>
    <div class="form-errors" v-if="error && !success">
      <div class="error-msg">
        {{ errorMessage }}
      </div>
    </div>
    <form autocomplete="off" @submit.prevent="resetPass" class="form" v-if="!success" method="post">
      <div class="form-group">
        <label for="password">Password:</label>
        <br>
        <input type="password" id="password" class="form-control" v-model="password" required>
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirm password:</label>
        <br>
        <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation" required>
      </div>
      <br>
      <button type="submit" class="btn-1" style="margin-bottom:7px;">Submit</button>
    </form>
    <div v-else class="form">
      Your password has been reset. Please log in now.
    </div>
    <br>
    <router-link to="/" class="a">Log in</router-link>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        name: '',
        emailReset: this.$parent.email,
        token: this.$parent.token,
        password: '',
        password_confirmation: '',
        error: false,
        errors: {},
        success: false,
        errorMessage: 'Error: The given data was invalid.'
      };
    },
    mounted () {
      this.$store.commit('form', 'login');
    },
    methods: {
      resetPass(){
        var app = this
        this.axios.post('/password/reset', { email: app.emailReset, token: app.token, password: app.password, password_confirmation: app.password_confirmation } )
        .then(result => {
          if (result.data.message == "This password reset token is invalid.") {
            this.error = true;
            this.errorMessage = "Error: This password reset token is invalid.";
          }
          if (result.data.message == "Passwords must be at least six characters and match the confirmation.") {
            this.error = true;
            this.errorMessage = "Error: The given data was invalid.";
          }
          if (result.data.message == 'Your password has been reset!') {
            this.success = true;
          }
        })
        .catch(error => {
          this.errorMessage = 'Error: The given data was invalid.';
          this.error = true;
        });
      },
      login () {
        this.$parent.token = false;
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