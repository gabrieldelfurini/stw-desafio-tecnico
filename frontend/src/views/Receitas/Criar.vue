<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>
                    Adicionar Receita
                </h4>
            </div>
            <div class="card-body">

                <ul v-if= "Object.keys(this.errorList).length > 0" class="alert alert-warning">
                    <li class="mb-0 ms-3" v-for = "(error, index) in this.errorList" :key= "index">
                        {{ error[0] }}
                    </li>
                </ul>

                <div class="mb-3">
                    <label for="">Código</label>
                    <input type="text" class="form-control" v-model="model.receita.codigo" />
                </div>
                <div class="mb-3">
                    <label for="">Descrição</label>
                    <input type="text" class="form-control" v-model="model.receita.descricao"/>
                </div>

                


                <div class="mb-3">
                    <label for="existingRecipes">Ingredientes</label>
                    <select id="existingRecipes" class="form-select" v-model="selectedIngredientId">
                        <option value="" disabled selected>Escolha um ingrediente existente</option>

                        <option v-for="ingrediente in ingredientesList" :key="ingrediente.id" :value="ingrediente.id">
                            {{ ingrediente.descricao }}
                        </option>
                    </select>
                    <button type="button" class="btn btn-outline-secondary mt-2" @click="adicionarIngrediente">Adicionar</button>
                </div>



                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Ingrediente</th>
                            <th>Quantidade Prevista</th>
                            <th>Ordem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody > <!-- v-if = "this.receitas.length > 0"-->
                        <tr v-for="(ingrediente, index) in this.model.receita.ingredientesAdicionados" :key="index"> <!--v-for="(receita, index) in this.receitas" :key = "index"-->
                            <td> {{ ingrediente.descricao}} </td>
                            <td> <input type="text"> </td>
                            <td> <input type="text"> </td>
                            <td>
                            <button type="buttom" class="btn btn-danger" @click="deletarReceita(receita.id)">Deletar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>



                <!-- PROBLEMA PRINCIPAL: FAZER AQUELES INGREDIENTES APARECEREM NA TABELA -->


                <!-- <div class="mb-3">
                    <label>Ingredientes Adicionados:</label>
                    <ul class="list-group">
                        <li class="list-group-item" v-for="(ingrediente, index) in this.model.receita.ingredientesAdicionados" :key="index">
                          <p>{{ ingrediente.descricao }}</p>

                          <label for="qtdPrevista">Quantidade Prevista:</label>
                          <input type="text" id="qtdPrevista">
                          <label for="ordem">Ordem:</label>
                          <input type="text" id="ordem">
                          <button>Excluir</button>

                        </li>
                    </ul>
                </div> -->

                

                <div class="mb-3">
                    <button type="button" @click="salvarReceita" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>    
    </div>    
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'CriarReceita', 
        data(){
            return {
                errorList: {},
                ingredientesList: [],
                selectedIngredientId: '',
                model: {
                    receita: {
                        codigo: '',
                        descricao: '',
                        ingredientesAdicionados: []
                    }
                },
            }
        },

        mounted(){
            this.getIngredientesData();

        },
        
        methods: {
            salvarReceita(){

                console.log(this.model.receita)
                
                var mythis = this;
                axios.post('http://127.0.0.1:8000/api/receitas', this.model.receita)
                    .then(res => {

                        console.log(res.data)
                        alert(res.data.message)

                        this.model.receita = {
                            codigo: '',
                            descricao: ''
                        }

                        this.errorList = "";
                    })
                    .catch(function (error) {

                        if (error.response) {

                            if(error.response.status == 422){
                                
                                mythis.errorList = error.response.data.errors;
                            }
                            
                        } else if (error.request) {
                            console.error(error.request);
                        } else {
                            console.error('Error', error.message);
                        }
                    })
            },

            getIngredientesData(){

                axios.get('http://127.0.0.1:8000/api/ingredientes').then(res => {
                
                    this.ingredientesList = res.data.ingredientes;

                });
            },

            adicionarIngrediente() {
                
                this.ingredientesList.forEach(element => {
                    if(element.id === this.selectedIngredientId){
                        this.model.receita.ingredientesAdicionados.push(element)
                    }
                });
                
                //Tirar ingrediente da lista quando for selecionado
                this.tirarIngredienteDaLista();
            },

            tirarIngredienteDaLista() {
                    this.ingredientesList.forEach(ingredienteRequisicao => {
                    this.model.receita.ingredientesAdicionados.forEach(ingredienteLista => {

                        if(ingredienteRequisicao.id === ingredienteLista.id){
                            
                            let elementoRemovida = this.ingredientesList.splice(this.ingredientesList[ingredienteRequisicao.id], 1);
                            console.log("Elemento removido: ", elementoRemovida)
                        }

                    })
                });            
            }
        }
    }










</script>




