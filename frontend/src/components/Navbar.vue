<template>
  <nav class="navbar pt-2 pb-3" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <a class="navbar-item" href="https://bulma.io">
        <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
      </a>

      <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
         data-target="navbarBasicExample">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
      <div class="navbar-start">
        <router-link class="navbar-item" :to="{name: 'Home'}">Home</router-link>
        <router-link class="navbar-item" :to="{name: 'About'}">About</router-link>

        <div v-if="$store.getters.isAuthenticated && user" class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            {{$store.getters.user.name}}
          </a>

          <div class="navbar-dropdown">
            <router-link class="navbar-item" :to="{name: 'Profile'}">Profile</router-link>
            <hr class="navbar-divider">
            <a class="navbar-item" @click.prevent="$store.dispatch('logout')">
              Logout
            </a>
          </div>
        </div>
      </div>

      <div class="navbar-end">
        <div v-if="!$store.getters.isAuthenticated" class="navbar-item">
          <div class="buttons">
            <router-link class="button is-primary" :to="{name: 'Login'}">Login</router-link>
            <router-link class="button is-primary" :to="{name: 'Register'}">Sign up</router-link>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Navbar',
  computed: {
    user () {
      return this.$store.getters.user
    }
  }
}
</script>

<style scoped>

</style>
