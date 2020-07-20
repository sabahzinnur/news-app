<template>
  <div class="pr-2 search-panel">
    <p class="control has-icons-left pr-2">
      <input class="input is-link"
             type="text"
             @input="startSearch()"
             v-model="search"
             placeholder="Search">
      <span class="icon is-left">
        <i class="fas fa-search" aria-hidden="true"></i>
      </span>
    </p>
    <div @click="clearSearch()">
      <i class="fas fa-times" :style="!search ? {color: '#ccc', cursor: 'default'} : {color: 'black', cursor: 'pointer'}" aria-hidden="true"></i>
    </div>
    <category-switcher class="pl-6"/>
  </div>
</template>

<script>

import CategorySwitcher from '@/components/CategorySwitcher'

export default {
  name: 'SearchPanel',
  components: {
    CategorySwitcher
  },
  data () {
    return {
      search: '',
      delay: 1000, // delay to wait for user input finish
      timer: 0 // window timer
    }
  },
  computed: {
    filters () {
      return this.$store.getters.filters
    }
  },
  methods: {
    startSearch () {
      clearTimeout(this.timer)
      this.timer = window.setTimeout(() => {
        if (this.search && typeof this.search === 'string') {
          this.setFilters()
        }
      }, this.delay)
    },
    clearSearch () {
      if (this.search) {
        clearTimeout(this.timer)
        this.search = ''
        this.setFilters()
      }
    },
    setFilters () {
      this.$router.replace({ query: null })
      this.$store.commit('setFilters', Object.assign(
        this.filters,
        {
          offset: 0,
          search: this.search
        }))
      this.$store.dispatch('fetchNews')
    }
  }
}
</script>

<style scoped>
  .search-panel {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
  }
</style>
