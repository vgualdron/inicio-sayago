import Vue from 'vue'
import Router from 'vue-router'

// Containers
import Full from '@/containers/Full'

// Views
import Login from '@/views/Login'
import Home from '@/views/Home'
import Perfil from '@/views/Perfil'
import Error from '@/views/Error'

Vue.use(Router)

/* const ViewRedirect = Vue.extend({
  render: function () {
    console.log('Route.path ' + this.$route.path)
    console.log(this.$route)
    this.$router.replace('/view_' + this.$route.path.substring(1))
  }
}) */

export default new Router({
  mode: 'hash',
  linkActiveClass: 'open active',
  scrollBehavior: () => ({ y: 0 }),
  routes: [
    {
      path: '/',
      redirect: '/login',
      name: 'general',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: 'login',
          name: 'Login',
          component: Login
        },
      ]
    },
    {
      path: '/',
      redirect: '/home',
      name: 'Home',
      component: Full,
      children: [
        {
          path: 'home',
          name: 'Home',
          component: Home
        },
        {
          path: 'perfiles',
          name: 'Perfil',
          component: Perfil
        }
      ]
    },
    {
      path: '/error',
      name: 'Error',
      component: Error
    }
  ]
})
