import Vue from 'vue'
import App from './App.vue'
// 路由
import router from './router'
// elementui
import ElementUI from 'element-ui'
// element-ui主题依赖
import 'element-ui/lib/theme-chalk/index.css'
import './element-variables.scss'
// 自定义指令防抖
import throttle from '@/directive/fangdou'
// 注册指令
Vue.directive('throttle', throttle)

Vue.use(ElementUI)

Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
