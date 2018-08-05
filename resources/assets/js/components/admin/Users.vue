<template>
    <div>
        <table class="table table-striped table-responsive-sm">
            <thead>
                <th>Email</th>
                <th>Nombre</th>
                <th>Rol</th>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">

                    <td> {{user.email}} </td>
                    <td> {{user.name}}  </td>
                    <td> 
                        <select v-model="user.role_id" @change="changeRole(user)">
                            <option value="1" class="font-weight-bold text-danger">Super</option>
                            <option value="2" class="font-weight-bold text-warning">Admin</option>
                            <option value="3" class="font-weight-bold text-info">User</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

export default {
    data(){
        return {
            users : []
        }
    },
    created(){
        var vm =this;
        this.$http.get('/super/getUsers')
            .then(response => {
                vm.users = response.data;
            });
    },
    methods : {
        changeRole(user)
        {
            this.$http.put(`/super/changeRole/${user.id}/${user.role_id}`)
                .then(response => {console.log(response.data)})
        }
    }
}
</script>
