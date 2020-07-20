import Vue from 'vue'
import Vuex from 'vuex'
import auth from '@/store/modules/auth'
import user from '@/store/modules/user'
import news from '@/store/modules/news'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
  },
  mutations: {
  },
  actions: {
  },
  modules: {
    auth,
    user,
    news
  }
})
