<template>
    <div>
        <h2>Seminarios</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <th>Titulo</th>
                <th>Descripcion</th>
            </thead>
           
                <transition-group tag="tbody" name="table-row"
                                    enter-active-class="animated slideInLeft"
                                    leave-active-class="animated slideOutRight">
                
                <tr v-for="(seminar,key) in seminars" :key="key">
                    <td :ref="'title'+seminar.id" contenteditable="true" @blur="edit(seminar,'title')">
                            {{seminar.title}}
                    </td>
                    <td>
                        <div  :ref="'description'+seminar.id" contenteditable @blur="edit(seminar,'description')">
                            {{seminar.description}}
                        </div>
                    </td>
                    <td>
                        <button class="btn btn-outline-danger" @click.prevent="del(seminar)">
                            <i class="fa fa-trash"></i>
                        </button>
                        <button class="btn btn-outline-info" @click.prevent="showEvents(seminar)">
                            <i class="fa fa-search-plus"></i>
                        </button>
                    </td>
                </tr>
                </transition-group>
            
        </table>
        <hr>
        <h5>Crear Seminario:</h5>
        <form action="" class="form form-inline row ml-1">
            <div class="col-12 mt-2 row  d-flex-flex-column">
                <label class="col-12" for="">Titulo</label>
                <input required class="form-control col-12" type="text" v-model="newSeminar.title">
            </div>
            <div class="col-12 mt-2  row d-flex-flex-column">
                <label class="col-12" for="">Descripcion</label>
                <textarea required class="form-control col-12" type="text" v-model="newSeminar.description"></textarea>
            </div>
            <button class="col-6 mt-2 col-lg-2 btn btn-outline-success align-self-end justify-self-end" @click.prevent="save">Guardar</button>
            
        </form>
    </div>
</template>
<script>
import { EventBus } from '../../../app.js';
export default {
    props : ['seminars'],
    data(){
        return{
            newSeminar : {
                title : '',
                description: ''
            }
        }
    },
    methods : {
        showEvents(seminar){
            this.$emit('showEvents',seminar);
        },
        save()
        {
             var vm = this;
            $.ajax({
                method :'post',
                url : '/admin/seminar/create',
                data : vm.newSeminar,
                success(response){
                    vm.$emit('seminarCreated',response);
                }
            });
        },

        del(seminar)
        {
            var vm = this;
            var futureEvents =  seminar.events.filter(function (el) {
                 return (new Date(el.date)) >= Date.now();
             });
            if (futureEvents.length == 0){      
                $.ajax({
                    method :'delete',
                    url : '/admin/seminar/'+seminar.id,
                    success(){
                        vm.$emit('seminarDeleted',seminar.id);
                    }
                });
            } else {
                swal ('El seminario tiene eventos futuros', 'si desea borrarlo,primero cancele los eventos','error');
            }
        },
        edit(seminar,field){
            var vm = this;
           var ref = field + seminar.id;
           var value = this.$refs[ref][0].innerText;
           
           var data = {
               field : field,
               value : value,
               seminarId : seminar.id
           }

           $.ajax({
               data : data,
               method : 'put',
               url : '/admin/seminar/',
               success(){
                   vm.$emit('updatedSeminar',data);
               }
           });
           
            
        }
    }
}
</script>
