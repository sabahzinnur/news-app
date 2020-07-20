import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import authRoutes from './routes/auth'
import store from '../store/index'

Vue.use(VueRouter)

const ifAuthenticated = (to, from, next) => {
  if (store.getters.isAuthenticated) {
    next()
    return
  }
  next('/')
}

const routes = [
  ...authRoutes,
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/about',
    name: 'About',
    component: () => import('../views/About.vue')
  },
  {
    path: '/profile',
    name: 'Profile',
    beforeEnter: ifAuthenticated,
    component: () => import('../views/Profile.vue')
  },
  {
    path: '/article',
    name: 'Article',
    beforeEnter: ifAuthenticated,
    component: () => import('../views/Article.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
