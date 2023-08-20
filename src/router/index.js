import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    redirect: '/home'
  },
  {
    path: '/home',
    name: 'home',
    component: () => import('@/views/index/index.vue')
  },
  {
    path: '/404',
    component: () => import('@/views/404.vue'),
    hidden: true
  },
  { path: '*', redirect: '/404', hidden: true }
]

const router = new VueRouter({
  routes
})

export default router
