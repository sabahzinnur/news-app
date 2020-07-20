import api from '@/common/api'

const state = {
  news: {},
  categories: [],
  filters: {
    limit: 12,
    offset: 0,
    search: '',
    total: 0,
    category: null
  }
}

const mutations = {
  setFilters (state, filters) {
    state.filters = filters
  }
}

const actions = {
  async fetchNews ({ state }) {
    const response = await api.getNews(state.filters)
    state.news = state.filters.search ? response.data.news.data : response.data.news
    state.filters.total = response.data.total
  },
  async fetchCategories ({ state }) {
    const response = await api.getCategories()
    state.categories = response.data
  },
  async fetchArticle ({ state }, articleId) {
    const response = await api.getArticle(articleId)
    return response.data
  }

}

const getters = {
  news: state => state.news,
  categories: state => state.categories,
  filters: state => state.filters
}

export default {
  state,
  getters,
  actions,
  mutations
}
