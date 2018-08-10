<template>
    <div>
       <h3> Crear Seminario: </h3>
              <form @submit.prevent ="save">
                    <div class="row">
                        <label class="col-4">Titulo</label>
                        <input v-model="seminar.title" type="text" class="form-control">
                    </div>
                    <div class="row">
                        <label  class="col-4">Descripcion</label>
                        <textarea  v-model="seminar.description" rows="4" class="form-control"></textarea>
                    </div>
                    <button class="btn btn-lg btn-outline-success mt-3" type="submit">Guardar</button>
              </form>
    </div>
</template>

<script>
import { EventBus } from '../../../app.js';
export default {
    data(){
        return {
            seminar:{
                title : '',
                description : ''

            }
        }
    },
    methods : {
        save()
        {
            if (this.seminar.title.length > 1 && this.seminar.description.length > 1)
            {
                this.$http.post('/admin/seminar/create',this.seminar)
                    .then(response => {
                        EventBus.$emit('seminarCreated',response.data);
                    });
            } 
            else {
                swal ('Error','Complete titulo y descripción','error');
            }
        }
    }
}
</script>
