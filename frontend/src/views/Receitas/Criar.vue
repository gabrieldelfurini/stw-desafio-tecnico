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
                    <select id="existingRecipes" class="form-select" v-model="selectedIngredientId" ref="existingRecipes">
                        <option value="" disabled selected id="opcaoPadrao">Escolha um ingrediente existente</option>

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
                        <tr v-for="(ingrediente, index) in this.model.receita.ingredientesAdicionados" :key="index">
                            <td> <p :class="'ingredienteId' + ingrediente.id">{{ ingrediente.descricao}}</p> </td>
                            <td> <input type="text" :class="'qtdPrevista' + ingrediente.id" > </td>
                            <td> <input type="text" :class= "'ordem' + ingrediente.id"> </td>
                            <td>
                            <button type="buttom" class="btn btn-danger" @click="deletarIngrediente(ingrediente.id)">Deletar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>    
                
                
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
                ingredientesSelecionados: [],
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


                //Pegando os valores de dentro dos campos do array e adicionando dentro do vetor certo
                this.model.receita.ingredientesAdicionados.forEach(elemento => {
                    let qtdPrevista = document.querySelector(`.qtdPrevista${elemento.id}`).value
                    let ordem = document.querySelector(`.ordem${elemento.id}`).value

                    console.log("verificando o ingredienteId: ", elemento.id)
                    
                    let ingrediente = {
                        ingredienteId: elemento.id,
                        qtdPrevista, 
                        ordem
                    }

                    this.ingredientesSelecionados.push(ingrediente)
                });
                //Adicionando no vetor já existente no model
                this.model.receita.ingredientesAdicionados = this.ingredientesSelecionados;

                console.log("Vendo os tipos de dados: ", this.model.receita)

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
                        }
                    })
                });            
            },

            deletarIngrediente(ingredienteId){
                //Tira da lista
                let retirado = '';
                for(let index = 0; index < this.model.receita.ingredientesAdicionados.length; index++){

                    if(this.model.receita.ingredientesAdicionados[index].id === ingredienteId){

                        retirado = this.model.receita.ingredientesAdicionados[index]
                        this.model.receita.ingredientesAdicionados.splice(this.model.receita.ingredientesAdicionados[index], 1);
                    }
                }


                        //DESAFIO: "Coloca" no select novamente
                this.ingredientesList = this.ingredientesList.concat(retirado)
                // console.log(this.ingredientesList)
            }
        }
    }










</script>




