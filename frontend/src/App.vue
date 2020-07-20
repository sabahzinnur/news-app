<template>
  <div id="app">
      <div class="container">
        <navbar/>
        <router-view/>
      </div>
  </div>
</template>

<script>
import Navbar from './components/Navbar'

export default {
  components: { Navbar },
  created () {
    if (this.$store.getters.isAuthenticated) {
      this.$store.dispatch('fetchUser')
    }
  }
}
</script>
