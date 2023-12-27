<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4>Receitas</h4>
        <RouterLink to="receitas/create" class="btn btn-primary float-end">
          Adicionar Receita
        </RouterLink>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Código</th>
              <th>Descrição</th>
              <th>Data de Criação</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody v-if="this.receitas.length > 0">
            <tr v-for="(receita, index) in this.receitas" :key="index">
              <td>{{ receita.codigo }}</td>
              <td>{{ receita.descricao }}</td>
              <td>{{ formatarData(receita.created_at) }}</td>
              <td class="botoesAdicionarDeletar">
                <RouterLink
                  class="btn btn-success"
                  :to="{ path: '/receitas/' + receita.id + '/edit' }"
                  >Ver mais...</RouterLink
                >
                <button
                  type="buttom"
                  class="btn btn-danger"
                  @click="deletarReceita(receita.id)"
                >
                  Excluir
                </button>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td colspan="5">Carregando...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "View",
  data() {
    return {
      receitas: [],
    };
  },
  mounted() {
    this.getReceitas();
  },
  methods: {
    deletarReceita(receitaId) {
      if (confirm("Você tem certeza que deseja excluir essa receita?!")) {
        axios
          .delete(`http://127.0.0.1:8000/api/receitas/${receitaId}/delete`)
          .then((res) => {
            alert(res.data.message);
            this.getReceitas();
          })
          .catch(function (error) {
            if (error.response) {
              if (error.response.status == 404) {
                alert(error.response.data.message);
              }
            }
          });
      }
    },

    getReceitas() {
      axios.get("http://127.0.0.1:8000/api/receitas").then((res) => {
        this.receitas = res.data.receitas;
      });
    },

    formatarData(timestamp) {
      const data = new Date(timestamp);
      return data.toLocaleString();
    },
  },
};
</script>
