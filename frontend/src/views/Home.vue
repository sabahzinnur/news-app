<template>
  <div>
    <paginator />
    <div class="tile is-ancestor" style="flex-wrap: wrap">
      <div class="tile is-parent" v-for="article in news" :key="article.id">
        <article-card class="tile is-child box" :article="article"/>
      </div>
    </div>
  </div>
</template>

<script>
import articleCard from '@/components/ArticleCard'
import Paginator from '@/components/Paginator'

export default {
  name: 'Home',
  components: {
    Paginator,
    articleCard
  },
  mounted () {
    this.$store.dispatch('fetchNews')
  },
  computed: {
    news () {
      return this.$store.getters.news
    }
  }

}
</script>
