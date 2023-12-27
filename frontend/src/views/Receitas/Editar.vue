<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4>Ver Receita</h4>
      </div>
      <div class="card-body">
        <ul
          v-if="Object.keys(this.errorList).length > 0"
          class="alert alert-warning"
        >
          <li
            class="mb-0 ms-3"
            v-for="(error, index) in this.errorList"
            :key="index"
          >
            {{ error[0] }}
          </li>
        </ul>
        <div class="mb-3">
          <label for="">Código</label>
          <input
            type="text"
            class="form-control"
            v-model="model.receita.codigo"
          />
        </div>
        <div class="mb-3">
          <label for="">Descrição</label>
          <input
            type="text"
            class="form-control"
            v-model="model.receita.descricao"
          />
        </div>
        <div class="mb-3">
          <label for="existingRecipes">Ingredientes</label>
          <select
            id="existingRecipes"
            class="form-select"
            v-model="selectedIngredientId"
            ref="existingRecipes"
          >
            <option value="" disabled selected id="opcaoPadrao">
              Escolha um ingrediente existente
            </option>

            <option
              v-for="ingrediente in ingredientesNaoSelecionados"
              :key="ingrediente.id"
              :value="ingrediente.id"
            >
              {{ ingrediente.descricao }}
            </option>
          </select>
          <button
            type="button"
            class="btn btn-outline-secondary mt-2"
            @click="adicionarIngrediente"
          >
            Adicionar
          </button>
        </div>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Ingrediente</th>
              <th>Previsto em Kg</th>
              <th>Ordem</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(ingrediente, index) in this.model.receita
                .ingredientesSelecionados"
              :key="index"
            >
              <td>
                <p :class="'ingredienteId' + ingrediente.id">
                  {{ ingrediente.descricao }}
                </p>
              </td>

              <td v-if="ingrediente.pivot">
                <input
                  type="text"
                  :class="'qtdPrevista' + ingrediente.id"
                  :value="ingrediente.pivot.quantidade_prevista"
                />
              </td>
              <td v-else>
                <input type="text" :class="'qtdPrevista' + ingrediente.id" />
              </td>

              <td v-if="ingrediente.pivot">
                <input
                  type="text"
                  :class="'ordem' + ingrediente.id"
                  :value="ingrediente.pivot.ordem"
                />
              </td>
              <td v-else>
                <input type="text" :class="'ordem' + ingrediente.id" />
              </td>
              <td>
                <button
                  type="buttom"
                  class="btn btn-danger"
                  @click="deletarIngrediente(ingrediente.id)"
                >
                  Deletar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="botoes">
          <div class="mb-3">
            <button
              type="button"
              @click="atualizarReceita"
              class="btn btn-primary"
            >
              Atualizar
            </button>
            <a type="button" class="btn btn-primary" href="/receitas">Cancelar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "EditarReceita",
  data() {
    return {
      receitaId: "",
      errorList: "",
      selectedIngredientId: "",
      ingredientesNaoSelecionados: [],
      model: {
        receita: {
          codigo: "",
          descricao: "",
          ingredientesSelecionados: [],
        },
      },
    };
  },
  mounted() {
    this.receitaId = this.$route.params.id;
    this.getReceitaData(this.$route.params.id);
  },
  methods: {
    getReceitaData(receitaId) {
      axios
        .get(`http://127.0.0.1:8000/api/receitas/${this.receitaId}/edit`)
        .then((res) => {

          //Substituindo os valores do model da forma certa
          this.model.receita.codigo =
            res.data.dadosReceitaComIngredientes.receita.codigo;
          this.model.receita.descricao =
            res.data.dadosReceitaComIngredientes.receita.descricao;

          this.ingredientesNaoSelecionados =
            res.data.dadosReceitaComIngredientes.ingredientesNaoSelecionados;
          this.model.receita.ingredientesSelecionados =
            res.data.dadosReceitaComIngredientes.receita.ingredientes;
        })
        .catch(function (error) {
          if (error.response) {
            if (error.response.status == 404) {
              alert(error.response.data.message);
            }
          }
        });
    },

    atualizarReceita() {
      let vetorAuxiliar = [];

      this.model.receita.ingredientesSelecionados.forEach((elemento) => {
        let qtdPrevista = document.querySelector(
          `.qtdPrevista${elemento.id}`
        ).value;
        let ordem = document.querySelector(`.ordem${elemento.id}`).value;

        let ingrediente = {
          ingredienteId: elemento.id,
          qtdPrevista,
          ordem,
        };

        vetorAuxiliar.push(ingrediente);
      });

      //Adicionando no vetor já existente no model
      this.model.receita.ingredientesSelecionados = vetorAuxiliar;

      var mythis = this;
      axios
        .put(
          `http://127.0.0.1:8000/api/receitas/${this.receitaId}/edit`,
          this.model.receita
        )
        .then((res) => {
          console.log(res.data);
          alert(res.data.message);

          this.errorList = "";

          //Redireciona para outra tela
          window.location.href = '/receitas';
        })
        .catch(function (error) {
          if (error.response) {
            if (error.response.status == 422) {
              mythis.errorList = error.response.data.errors;
            }

            if (error.response.status == 404) {
              alert(error.response.data.message);
            }
          } else if (error.request) {
            console.error(error.request);
          } else {
            console.error("Error", error.message);
          }
        });
    },

    adicionarIngrediente() {

      //Pegar todos os ingredientes, para usar na logica depois
      axios.get("http://127.0.0.1:8000/api/ingredientes").then((res) => {
        let ingredientesList = res.data.ingredientes;

        ingredientesList.forEach((element) => {
          if (element.id === this.selectedIngredientId) {
            this.model.receita.ingredientesSelecionados.push(element);
          }
        });


        for (const chave in this.ingredientesNaoSelecionados) {
          if (
            this.ingredientesNaoSelecionados[chave].id ===
            this.selectedIngredientId
          ) {
            delete this.ingredientesNaoSelecionados[chave];
          }
        }

        // Depois de usar "delete", parece que o index continua presente, mas sem o valor. Então pensei na solução abaixo para resolver esse problema
        let vetorAuxiliar = [];
        for (
          let index = 0;
          index < this.ingredientesNaoSelecionados.length;
          index++
        ) {
          if (this.ingredientesNaoSelecionados[index]) {
            vetorAuxiliar.push(this.ingredientesNaoSelecionados[index]);
          }
        }
        this.ingredientesNaoSelecionados = vetorAuxiliar;

        //Voltar esse valor para nada para ter que escolher outro index quando for adicionar novamente
        this.selectedIngredientId = "";
      });
    },

    deletarIngrediente(ingredienteId) {

      //Trasnformar this.ingredientesNaoSelecionados em um array
      let arrayAuxiliar = [];
      for (const index in this.ingredientesNaoSelecionados) {
        arrayAuxiliar.push(this.ingredientesNaoSelecionados[index]);
      }
      this.ingredientesNaoSelecionados = arrayAuxiliar;

      let removido = "";
      this.model.receita.ingredientesSelecionados.forEach((elemento, index) => {
        if (elemento.id === ingredienteId) {
          removido = this.model.receita.ingredientesSelecionados.splice(
            index,
            1
          );
        }
      });

      this.ingredientesNaoSelecionados.push(removido[0]);
    },
  },
};
</script>

<style scoped>
.botoes {
  display: flex;
  align-items: center;
}
button {
  margin: 5px;
}
a {
  margin: 0px;
}
</style>
