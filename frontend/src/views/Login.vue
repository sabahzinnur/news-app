<template>
  <section class="hero pt-3">
    <div class="hero-body">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-6-tablet is-5-desktop is-4-widescreen">
            <form class="box" @submit.prevent="logIn()">
              <div class="field">
                <label for="email" class="label">Email</label>
                <div id="email" class="control has-icons-left">
                  <input type="email"
                         v-model="formData.email"
                         placeholder="e.g. bobsmith@gmail.com"
                         class="input" required/>
                  <span class="icon is-small is-left">
                  <i class="fa fa-envelope"></i>
                </span>
                </div>
              </div>
              <div class="field">
                <label for="password" class="label">Password</label>
                <div id="password" class="control has-icons-left">
                  <input type="password" v-model="formData.password" placeholder="*******" class="input" required>
                  <span class="icon is-small is-left">
                  <i class="fa fa-lock"></i>
                </span>
                </div>
              </div>
              <div class="field">
                <vue-recaptcha
                  ref="recaptcha"
                  :sitekey="$config.recaptchaKey"
                  :loadRecaptchaScript="true"
                  @verify="validateRecaptcha($event)"
                  @error="resetRecaptcha(false)"
                  @expired="resetRecaptcha()"
                />
              </div>
              <div class="field">
                <label for="remember" class="checkbox">
                  <input id="remember" type="checkbox">
                  Remember me
                </label>
              </div>
              <div class="field">
                <button class="button is-success" :disabled="loading || !formData.recaptcha">
                  Login
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import VueRecaptcha from 'vue-recaptcha'

export default {
  name: 'Login',
  components: {
    VueRecaptcha
  },
  data () {
    return {
      loading: false,
      formData: {
        email: '',
        password: '',
        recaptcha: ''
      }
    }
  },
  methods: {
    async logIn () {
      this.loading = true
      await this.$store.dispatch('login', this.formData)
      this.loading = false
      if (this.$store.getters.isAuthenticated) {
        await this.$router.push(
          this.$route.query.redirectFrom || { path: '/' }
        )
      } else if (!this.success) {
        this.resetRecaptcha()
      }
    },
    resetRecaptcha (rerender = true) {
      if (rerender) {
        this.$refs.recaptcha.reset() // Direct call reset method
      }
    },
    validateRecaptcha (event) {
      this.formData.recaptcha = event
    }
  }
}
</script>

<style scoped>

</style>
