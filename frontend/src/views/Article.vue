<template>
  <div>
    <div class="card" v-if="article">
      <div class="card-image">
        <figure class="image is-4by3">
          <img :src="article.urlToImage" :alt="article.description">
        </figure>
      </div>
      <div class="card-content">
        <div class="media">
          <div class="media-content">
            <p class="title is-4">{{article.title}}</p>
          </div>
        </div>

        <div class="content">
          {{article.content}}
          <br>
          <small class="date">{{article.created_at | date('date')}}</small>
        </div>
      </div>
    </div>
    <p v-else>No content</p>
  </div>
</template>

<script>
export default {
  name: 'Article',
  data () {
    return {
      article: null
    }
  },
  async mounted () {
    this.article = this.$route.params.article
    if (!this.article && this.$route.query.id) {
      this.article = await this.$store.dispatch('fetchArticle', this.$route.query.id)
    }
  }
}
</script>

<style scoped>

</style>
