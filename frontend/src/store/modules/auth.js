import api from '@/common/api'

const state = {
  token: localStorage.getItem('access_token') || ''
}

const mutations = {
  authorize (state, token) {
    localStorage.setItem('access_token', token)
    state.token = token
    this.$http.defaults.headers.common.Authorization = `Bearer ${token}`
  },
  unauthorize (state) {
    localStorage.removeItem('access_token')
    state.token = ''
    delete this.$http.defaults.headers.common.Authorization
  }
}

const actions = {
  async login ({ commit, dispatch }, formData) {
    const response = await api.login(formData)
    if (response.success) {
      commit('authorize', response.data.access_token)
      dispatch('fetchUser')
    }
  },
  async register ({ state, dispatch, commit }, formData) {
    const response = await api.register(formData)
    if (response.success) {
      commit('authorize', response.data.access_token)
      dispatch('fetchUser')
    }
  },
  async logout ({ commit }) {
    await api.logout()
    commit('unauthorize')
  }
}

const getters = {
  isAuthenticated: state => !!state.token
}

export default {
  state,
  getters,
  actions,
  mutations
}
