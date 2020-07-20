<template>
  <div class="dropdown pr-2">
    <div class="dropdown-trigger">
      <button class="button" aria-haspopup="true" aria-controls="dropdown-menu3" @click.prevent="open = !open">
        <span>{{selectedCategory || 'Choose category'}}</span>
        <span class="icon is-small">
        <i class="fas fa-angle-down" aria-hidden="true"></i>
      </span>
      </button>
    </div>
    <div class="dropdown-menu" id="dropdown-menu3" role="menu" :style="open ? 'display: block' : 'none' ">
      <div class="dropdown-content">
        <div v-for="category in categories" :key="category.id">
          <a @click.prevent="selectCategory(category)" class="dropdown-item">
            {{category.name}}
          </a>
        </div>
        <hr class="dropdown-divider">
        <a @click.prevent="selectCategory({name: 'All', id: null})" class="dropdown-item">
          All
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CategorySwitcher',
  data () {
    return {
      open: false,
      selectedCategory: ''
    }
  },
  created () {
    this.$store.dispatch('fetchCategories')
  },
  computed: {
    categories () {
      return this.$store.getters.categories
    },
    filters () {
      return this.$store.getters.filters
    }
  },
  methods: {
    selectCategory (category = null) {
      this.open = false
      this.$store.commit('setFilters', Object.assign(
        this.filters, { offset: 0, category: category.id }))
      this.$store.dispatch('fetchNews')
      this.selectedCategory = category.name
    }
  }

}
</script>

<style scoped>

</style>
