<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>
                    Editar Ingrediente
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
                    <input type="text" class="form-control" v-model="model.ingrediente.codigo" />
                </div>
                <div class="mb-3">
                    <label for="">Descrição</label>
                    <input type="text" class="form-control" v-model="model.ingrediente.descricao"/>
                </div>
                <div class="botoes">
                    <div class="mb-3">
                        <button type="button" @click="atualizarIngrediente" class="btn btn-primary">Atualizar</button>
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
        name: 'EditarIngrediente',
        data(){
            return {
                ingredienteId: '',
                errorList: '',
                model: {
                    ingrediente: {
                        codigo: '',
                        descricao: '',
                    }   
                }
            }
        },
        mounted(){
            // console.log(this.$route.params.id)
            this.ingredienteId = this.$route.params.id;
            this.getIngredienteData(this.$route.params.id);
        },
        methods: {

            getIngredienteData(ingredienteId){

                axios.get(`http://127.0.0.1:8000/api/ingredientes/${this.ingredienteId}/edit`)
                    .then(res => {
                        console.log(res.data.ingrediente);

                        this.model.ingrediente = res.data.ingrediente;
                    })
                    .catch(function (error) {

                        if (error.response) {

                            if(error.response.status == 404){
                                
                                alert(error.response.data.message);
                            }
                            
                        }
                    })
            },

            atualizarIngrediente(){

                var mythis = this;
                axios.put(`http://127.0.0.1:8000/api/ingredientes/${this.ingredienteId}/edit`, this.model.ingrediente)
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

<style>
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
