import { createRouter, createWebHistory } from 'vue-router'
import Register from '../views/Register.vue'
import Profile from '../views/Profile.vue'

const routes = [
  { path: '/', name: 'register', component: Register },
  { path: '/profile', name: 'profile', component: Profile },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router