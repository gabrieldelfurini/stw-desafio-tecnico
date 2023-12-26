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
                            <th>Previsto em Kg</th>
                            <th>Ordem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody > <!-- v-if = "this.receitas.length > 0"-->
                        <tr v-for="(ingrediente, index) in this.model.receita.ingredientesSelecionados" :key="index">
                            <td> <p :class="'ingredienteId' + ingrediente.id">{{ ingrediente.descricao}}</p> </td>

                            <td v-if="ingrediente.pivot"> <input type="text" :class="'qtdPrevista' + ingrediente.id" :value="ingrediente.pivot.quantidade_prevista"> </td> 
                            <td v-else> <input type="text" :class="'qtdPrevista' + ingrediente.id"> </td> 


                            <td v-if="ingrediente.pivot"> <input type="text" :class= "'ordem' + ingrediente.id" :value="ingrediente.pivot.ordem"> </td>
                            <td v-else> <input type="text" :class= "'ordem' + ingrediente.id"> </td>
                            <td>
                            <button type="buttom" class="btn btn-danger" @click="deletarIngrediente(ingrediente.id)">Deletar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="botoes">
                    <div class="mb-3">
                        <button type="button" @click="atualizarReceita" class="btn btn-primary">Atualizar</button>
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
                selectedIngredientId: '',
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
                        console.log("dados do servido: ", res.data);

                        //Substituindo os valores do model da forma certa
                        this.model.receita.codigo = res.data.dadosReceitaComIngredientes.receita.codigo
                        this.model.receita.descricao = res.data.dadosReceitaComIngredientes.receita.descricao
                        // this.model.receita.ingredientesSelecionados = res.data.dadosReceitaComIngredientes.receita.ingredientes // O PROBLEMA ESTA AQUIIIIIII AHEEEE ACHEIIIII
                        
                        this.ingredientesNaoSelecionados = res.data.dadosReceitaComIngredientes.ingredientesNaoSelecionados// acho que resolvi o problema
                        this.model.receita.ingredientesSelecionados = res.data.dadosReceitaComIngredientes.receita.ingredientes

                        /*//loop para poder preencher o array "dadosIngredientesSelecionados"
                        console.log('entrou', res.data.dadosReceitaComIngredientes.dadosIngredientesSelecionados)
                        res.data.dadosReceitaComIngredientes.dadosIngredientesSelecionados.forEach(element => {
                            console.log("Elemento na iteração: ", element.ingrediente)
                            this.model.receita.ingredientesSelecionados.push(element.ingrediente);
                        });
                        
                        console.log("(depois) ingredientesSelecionados: ", this.model.receita.ingredientesSelecionados)*/
                        
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

                //Pegando os valores de dentro dos campos do array e adicionando dentro do vetor certo
                let vetorAuxiliar = [];
                
                this.model.receita.ingredientesSelecionados.forEach(elemento => {
                    let qtdPrevista = document.querySelector(`.qtdPrevista${elemento.id}`).value
                    let ordem = document.querySelector(`.ordem${elemento.id}`).value
                    console.log("qtdPrevista: ", qtdPrevista, "ordem:", ordem)

                    // console.log("verificando o ingredienteId: ", elemento.id)
                    
                    let ingrediente = {
                        ingredienteId: elemento.id,
                        qtdPrevista, 
                        ordem
                    }

                    vetorAuxiliar.push(ingrediente)
                });
                //Adicionando no vetor já existente no model
                this.model.receita.ingredientesSelecionados = vetorAuxiliar;
                console.log("NOVO VALOR de receita que vai pro backend: ", this.model.receita)




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

                //Pegar todos os ingredientes, para usar na logica depois
                axios.get('http://127.0.0.1:8000/api/ingredientes')
                .then(res => {
                    let ingredientesList = res.data.ingredientes;
                    console.log("todos os ingredientes: ", ingredientesList)

                    ingredientesList.forEach(element => {
                        if(element.id === this.selectedIngredientId){
                            this.model.receita.ingredientesSelecionados.push(element)
                        }
                    });

                    console.log("Antes de retirar elemento: ",this.ingredientesNaoSelecionados)
                    console.log("Tentando trasnformar em um array:", [...this.ingredientesNaoSelecionados])
                    console.log("É array?:", Array.isArray([...this.ingredientesNaoSelecionados]))


                    for (const chave in this.ingredientesNaoSelecionados) {
                        console.log(chave); 
                        console.log(this.ingredientesNaoSelecionados[chave].id);
                        if(this.ingredientesNaoSelecionados[chave].id === this.selectedIngredientId){
                            console.log("Elemento que vai adicionar: ", this.ingredientesNaoSelecionados[chave])
                            delete this.ingredientesNaoSelecionados[chave];
                        }
                    }

                    // Depois de usar "delete", parece que o index continua presente, mas sem o valor. Então pensei na solução abaixo para resolver esse problema
                    let vetorAuxiliar = [];
                    for(let index = 0; index < this.ingredientesNaoSelecionados.length; index++){
                        if(this.ingredientesNaoSelecionados[index]){
                            vetorAuxiliar.push(this.ingredientesNaoSelecionados[index]);
                        }
                    }
                    this.ingredientesNaoSelecionados = vetorAuxiliar;
                    
                    //Voltar esse valor para nada para ter que escolher outro index quando for adicionar novamente
                    this.selectedIngredientId = "";
                });
            },

            deletarIngrediente(ingredienteId) {
                //Tira da lista
                
                //Trasnformar this.ingredientesNaoSelecionados em um array
                let arrayAuxiliar = [];
                for(const index in this.ingredientesNaoSelecionados){
                    arrayAuxiliar.push(this.ingredientesNaoSelecionados[index])
                }
                this.ingredientesNaoSelecionados = arrayAuxiliar;
                console.log("ARRAY TRASNFORMADO: ", this.ingredientesNaoSelecionados)

                
                // console.log("Id pra deletar:", ingredienteId)
                // console.log("Retirar desse vetor: ", this.model.receita.ingredientesSelecionados)
                // console.log("Adicionar nesse vetor: ", this.ingredientesNaoSelecionados)
                
                let removido = '';
                this.model.receita.ingredientesSelecionados.forEach((elemento, index) => {
                    if(elemento.id === ingredienteId){
                        removido = this.model.receita.ingredientesSelecionados.splice(index, 1);
                    }
                })

                this.ingredientesNaoSelecionados.push(removido[0])
                console.log("Depois de ter adicionado o VALOR DE VOLTA: ", this.ingredientesNaoSelecionados)                
            }

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
