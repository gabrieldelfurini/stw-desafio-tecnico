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
                model: {
                    receita: {
                        codigo: '',
                        descricao: ''
                    }   
                }
            }
        },
        methods: {
            salvarReceita(){

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
            }
        }
    }
</script>
