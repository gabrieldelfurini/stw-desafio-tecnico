import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import IngredienteView from '../views/Ingredientes/View.vue'
import CriarIngrediente from '../views/Ingredientes/Criar.vue'
import EditarIngrediente from '../views/Ingredientes/Editar.vue'

import ReceitaView from '../views/Receitas/View.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/ingredientes',
      name: 'ingredientes',
      component: IngredienteView
    },
    {
      path: '/ingredientes/create',
      name: 'criarIngrediente',
      component: CriarIngrediente
    },
    {
      path: '/ingredientes/:id/edit',
      name: 'editarIngrediente',
      component: EditarIngrediente
    },
    {
      path: '/receitas',
      name: 'receitas',
      component: ReceitaView
    }


    
  ]
})

export default router
