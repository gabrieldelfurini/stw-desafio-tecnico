<template>
    <div class="container">
      <div class="card">
        <div class="card-header">
          <h4>Ingredientes</h4>
          <RouterLink to="ingredientes/create" class="btn btn-primary float-end"> 
            Adicionar Ingrediente
          </RouterLink>
        </div>
        <div class="card-body">
  
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Criado em</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody v-if = "this.ingredientes.length > 0">
              <tr v-for="(ingrediente, index) in this.ingredientes" :key = "index">
                <td> {{ ingrediente.codigo}} </td>
                <td> {{ ingrediente.descricao}} </td>
                <td> {{ ingrediente.created_at}} </td>
                <td>
                  <RouterLink class="btn btn-success" :to="{ path: '/ingredientes/' + ingrediente.id + '/edit' }">Editar</RouterLink>
                  <button type="buttom" class="btn btn-danger" @click="deletarIngrediente(ingrediente.id)">Deletar</button>
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr>
                <td colspan="5" >Carregando...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
  
  
  <script>  
    import axios from 'axios'
  
    export default {
      name: 'View',
      data() {
        return{
          ingredientes: []
        }
      },
      mounted(){
  
        this.getIngredientes();
      },
      methods: {
  
        deletarIngrediente(ingredienteId){
  
          if(confirm('Você tem certeza que deseja exlcuir esse ingrediente?!')){
            
            axios.delete(`http://127.0.0.1:8000/api/ingredientes/${ingredienteId}/delete`)
              .then(res => {
  
                alert(res.data.message);
                this.getIngredientes();
              })
              .catch(function (error) {
  
                if (error.response) {
                    if(error.response.status == 404){
                        alert(error.response.data.message);
                    }
                }
              })
          }
        },
  
        getIngredientes(){
  
          axios.get('http://127.0.0.1:8000/api/ingredientes').then(res => {
  
            this.ingredientes = res.data.ingredientes;
          });
        }
      }
    }
  </script>
  