import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import ManagerPub from './components/ManagerPub.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/:slug',
      name: 'ManagerPub',
      component: ManagerPub,
      props: true
    },
    {
      path: '/reg/:referred_by',
      name: 'Home Referral',
      component: Home,
      props: true
    },
    {
      path: '/reset/:token/:email',
      name: 'Home Reset Pass',
      component: Home,
      props: true
    },
  ]
})