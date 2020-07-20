import api from '@/common/api'

const state = {
  user: {}
}

const getters = {
  user: state => state.user
}

const actions = {
  async fetchUser ({ state }) {
    const response = await api.getUserProfile()
    state.user = response.data
  },
  async updateUserProfile ({ state }, formData) {
    const response = await api.updateUserProfile(formData)
    state.user = response.data
  }
}

const mutations = {}

export default {
  state,
  getters,
  actions,
  mutations
}
