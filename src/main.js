import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import Croppa from 'vue-croppa'


//components 
import App from './App.vue'
import Gallery from './components/Gallery.vue'
import Edit from './components/Edit.vue'


Vue.use(VueRouter);
Vue.use(Vuetify);
Vue.use(Croppa)  
Vue.config.productionTip = false

const routes = [
  {
    path:'/',
    component: Gallery,
    name:'app-gallery'
  },
  {
    //path:'/edit/:file_url',
    path:'/edit/:file_url',
    name:'app-edit',
    component: Edit,

  },

];

const router = new VueRouter({ routes});

new Vue({ 
  el: '#app', 

  router, 
  vuetify : new Vuetify(),
  render: h => h(App) 
})
