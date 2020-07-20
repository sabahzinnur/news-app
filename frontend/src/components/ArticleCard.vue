<template>
  <div class="card article-card" @click="openArticle(article)" v-if="categories.length && article">
    <div class="card-image">
      <figure class="image is-4by3">
        <img :src="article.urlToImage" alt="Placeholder image">
      </figure>
    </div>
    <div class="card-content">
      <div class="media">

        <div class="media-content">
          <span class="tag is-info is-light">{{getCategoryName(article.category_id)}}</span>
          <p class="title is-4">{{article.title}}</p>
        </div>
      </div>

      <div class="content">
        {{article.description}}
        <br>
      </div>

      <small class="date">{{article.created_at | date('date')}}</small>
    </div>
  </div>
</template>

<script>
export default {
  name: 'articleCard',
  props: {
    article: {
      required: true,
      type: Object
    }
  },
  computed: {
    categories () {
      return this.$store.getters.categories
    }
  },
  methods: {
    openArticle (article) {
      this.$router.push({
        name: 'Article',
        query: { id: article.id },
        params: { article }
      })
    },
    getCategoryName (categoryId) {
      return this.categories.find(item => item.id === categoryId).name
    }
  }
}
</script>

<style scoped>
 .article-card {
   width: 280px;
   margin: 20px;
   cursor: pointer;
 }
 .date {
   font-size: smaller;
   color: #a1a1a1;
 }
</style>
