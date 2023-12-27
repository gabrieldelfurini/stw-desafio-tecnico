<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4>Adicionar Ingrediente</h4>
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
            v-model="model.ingrediente.codigo"
          />
        </div>
        <div class="mb-3">
          <label for="">Descrição</label>
          <input
            type="text"
            class="form-control"
            v-model="model.ingrediente.descricao"
          />
        </div>
        <div class="mb-3">
          <button
            type="button"
            @click="salvarIngrediente"
            class="btn btn-primary"
          >
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "CriarIngrediente",
  data() {
    return {
      errorList: {},
      model: {
        ingrediente: {
          codigo: "",
          descricao: "",
        },
      },
    };
  },
  methods: {
    salvarIngrediente() {
      var mythis = this;
      axios
        .post("http://127.0.0.1:8000/api/ingredientes", this.model.ingrediente)
        .then((res) => {
          console.log(res.data);
          alert(res.data.message);

          this.model.ingrediente = {
            codigo: "",
            descricao: "",
          };

          this.errorList = "";
        })
        .catch(function (error) {
          if (error.response) {
            if (error.response.status == 422) {
              mythis.errorList = error.response.data.errors;
            }
          } else if (error.request) {
            console.error(error.request);
          } else {
            console.error("Error", error.message);
          }
        });
    },
  },
};
</script>
