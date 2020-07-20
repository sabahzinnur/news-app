<template>
  <section class="hero pt-3">
    <div class="hero-body">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-5-tablet is-5-desktop is-4-widescreen">
            <form @submit.prevent="register()" class="box">
              <div class="field">
                <label for="name" class="label">Name</label>
                <div id="name" class="control has-icons-left">
                  <input type="text"
                         placeholder="e.g. bobsmith@gmail.com"
                         class="input"
                         required
                         v-model="formData.name"
                  />
                  <span class="icon is-small is-left">
                  <i class="fa fa-envelope"></i>
                </span>
                </div>
              </div>
              <div class="field">
                <label for="email" class="label">Email</label>
                <div id="email" class="control has-icons-left">
                  <input type="email"
                         placeholder="e.g. bobsmith@gmail.com"
                         class="input"
                         required
                         v-model="formData.email"
                  />
                  <span class="icon is-small is-left">
                  <i class="fa fa-envelope"></i>
                </span>
                </div>
              </div>
              <div class="field">
                <label for="password" class="label">Password</label>
                <div id="password" class="control has-icons-left">
                  <input type="password"
                         placeholder="*******"
                         class="input"
                         v-model="formData.password"
                         required>
                  <span class="icon is-small is-left">
                  <i class="fa fa-lock"></i>
                </span>
                </div>
              </div>
              <div class="field">
                <label for="confirmation" class="label">Password confirmation</label>
                <div id="confirmation" class="control has-icons-left">
                  <input type="password"
                         placeholder="*******"
                         class="input"
                         v-model="formData.c_password"
                         required>
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
                <button class="button is-success" :disabled="loading || !formData.recaptcha">
                  Register
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
  name: 'Register',
  components: {
    VueRecaptcha
  },
  data () {
    return {
      loading: false,
      formData: {
        name: '',
        email: '',
        password: '',
        c_password: '',
        recaptcha: ''
      }
    }
  },
  methods: {
    async register () {
      this.loading = true
      await this.$store.dispatch('register', this.formData)
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
      if (event) {
        this.formData.recaptcha = event
      }
    }
  }
}
</script>

<style scoped>

</style>
