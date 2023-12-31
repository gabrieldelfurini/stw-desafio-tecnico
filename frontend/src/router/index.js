import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import IngredienteView from "../views/Ingredientes/View.vue";
import CriarIngrediente from "../views/Ingredientes/Criar.vue";
import EditarIngrediente from "../views/Ingredientes/Editar.vue";

import ReceitaView from "../views/Receitas/View.vue";
import CriarReceita from "../views/Receitas/Criar.vue";
import EditarReceita from "../views/Receitas/Editar.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },

    {
      path: "/ingredientes",
      name: "ingredientes",
      component: IngredienteView,
    },
    {
      path: "/ingredientes/create",
      name: "criarIngrediente",
      component: CriarIngrediente,
    },
    {
      path: "/ingredientes/:id/edit",
      name: "editarIngrediente",
      component: EditarIngrediente,
    },

    {
      path: "/receitas",
      name: "receitas",
      component: ReceitaView,
    },
    {
      path: "/receitas/create",
      name: "criarReceita",
      component: CriarReceita,
    },
    {
      path: "/receitas/:id/edit",
      name: "editarReceita",
      component: EditarReceita,
    },
  ],
});

export default router;
