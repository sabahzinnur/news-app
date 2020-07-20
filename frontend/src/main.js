import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import dateFilter from '@/filters/dateFilter'

import axios from 'axios'
import join from 'url-join'
import config from './common/config'

import 'bulma/css/bulma.css'
import '@fortawesome/fontawesome-free/css/all.css'

const token = localStorage.getItem('access_token')
if (token) {
  axios.defaults.headers.common.Authorization = `Bearer ${token}`
}

const isAbsoluteURLRegex = /^(?:\w+:)\/\//
axios.interceptors.request.use((axiosRequestConfig) => {
  if (!isAbsoluteURLRegex.test(axiosRequestConfig.url)) {
    axiosRequestConfig.url = join(config.api, axiosRequestConfig.url)
  }
  return axiosRequestConfig
})

Vue.filter('date', dateFilter)
store.$http = axios
Vue.prototype.$http = axios
Vue.prototype.$config = config

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
