<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>
                    Editar Receita
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
                    <button type="button" @click="atualizarReceita" class="btn btn-primary">Atualizar</button>
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
                model: {
                    receita: {
                        codigo: '',
                        descricao: '',
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
                        console.log(res.data.receita);

                        this.model.receita = res.data.receita;
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
            }
        }
    }
</script>
