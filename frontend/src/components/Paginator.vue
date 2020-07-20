<template>
  <nav class="pagination pt-3" role="navigation" aria-label="pagination">
    <search-panel/>
    <pagination v-if="pages"
      :itemsTotal="filters.total"
      :itemsPerPage="filters.limit"
      :currentPage="currentPage"
      :buttonsMax="5"
      :url="this.$route.name"
    />
  </nav>
</template>

<script>
import Pagination from 'vue-bulma-paginate'
import SearchPanel from '@/components/SearchPanel'

export default {
  name: 'Paginator',
  components: {
    SearchPanel,
    Pagination
  },
  created () {
    const page = +this.$route.query.page || 1
    this.getPage(page)
  },
  computed: {
    filters () {
      return this.$store.getters.filters
    },
    pages () {
      return Math.ceil(this.filters.total / this.filters.limit) - 1
    },
    currentPage () {
      return +this.$route.query.page || 1
    }
  },
  methods: {
    setOffset (value) {
      this.$store.commit('setFilters', Object.assign({}, this.filters, { offset: value }))
      this.$store.dispatch('fetchNews')
    },
    getOffset (pageNumber) {
      return pageNumber * this.filters.limit
    },
    getPage (pageNumber) {
      this.setOffset(this.getOffset(pageNumber))
    }
  },
  watch: {
    currentPage (newValue) {
      this.getPage(newValue)
    }
  }

}
</script>

<style scoped>

</style>
