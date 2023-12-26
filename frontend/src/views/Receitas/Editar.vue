<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>
                    Ver Receita
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

                        <option v-for="ingrediente in ingredientesNaoSelecionados" :key="ingrediente.id" :value="ingrediente.id">
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
                        <tr v-for="(ingrediente, index) in this.model.receita.ingredientesSelecionados" :key="index">
                            <td> <p :class="'ingredienteId' + ingrediente.id">{{ ingrediente.ingrediente.descricao}}</p> </td>
                            <td> <input type="text" :class="'qtdPrevista' + ingrediente.id" :value="ingrediente.qtdPrevista"> </td> 
                            <td> <input type="text" :class= "'ordem' + ingrediente.id" :value="ingrediente.ordem"> </td>
                            <td>
                            <button type="buttom" class="btn btn-danger" @click="deletarIngrediente(ingrediente.id)">Deletar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="botoes">
                    <div class="mb-3">
                    <button type="button" @click="atualizarReceita" class="btn btn-primary">Atualizar</button>
                    </div>
                    <div class="mb-3">
                        <a type="button" class="btn btn-primary" href="/">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>    
    </div>    
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'EditarReceita',
        data(){
            return {
                receitaId: '',
                errorList: '',
                ingredientesNaoSelecionados: [],
                model: {
                    receita: {
                        codigo: '',
                        descricao: '',
                        ingredientesSelecionados: []
                    }   
                }
            }
        },
        mounted(){
            this.receitaId = this.$route.params.id;
            this.getReceitaData(this.$route.params.id);
        },
        methods: {

            getReceitaData(receitaId){

                axios.get(`http://127.0.0.1:8000/api/receitas/${this.receitaId}/edit`)
                    .then(res => {
                        console.log("dados do servido: ", res.data.dadosReceitaComIngredientes);

                        //Colocando as informações na tela
                        this.model.receita = res.data.dadosReceitaComIngredientes.receita;
                        this.model.receita.ingredientesSelecionados = res.data.dadosReceitaComIngredientes.dadosIngredientesSelecionados
                        this.ingredientesNaoSelecionados = res.data.dadosReceitaComIngredientes.ingredientesNaoSelecionados
                    })
                    .catch(function (error) {

                        if (error.response) {

                            if(error.response.status == 404){
                                
                                alert(error.response.data.message);
                            }
                            
                        }
                    })
            },

            atualizarReceita(){

                var mythis = this;
                axios.put(`http://127.0.0.1:8000/api/receitas/${this.receitaId}/edit`, this.model.receita)
                    .then(res => {

                        console.log(res.data)
                        alert(res.data.message)

                        this.errorList = "";
                    })
                    .catch(function (error) {

                        if (error.response) {

                            if(error.response.status == 422){
                                
                                mythis.errorList = error.response.data.errors;
                            }

                            if(error.response.status == 404){
                                
                                alert(error.response.data.message);
                            }                            
                        } else if (error.request) {
                            console.error(error.request);
                        } else {
                            console.error('Error', error.message);
                        }
                    })
            },

            adicionarIngrediente() {
                
                this.ingredientesNaoSelecionados.forEach(element => {
                    if(element.id === this.selectedIngredientId){
                        this.model.receita.ingredientesSelecionados.push(element)
                    }
                });
                
                //Tirar ingrediente da lista quando for selecionado
                this.tirarIngredienteDaLista();
            },
        }
    }
</script>

<style scoped>
    .botoes{
        display: flex;
        align-items: center;
    }
    button{
        margin: 5px;
    }
    a{
        margin: 0px;
    }
</style>
