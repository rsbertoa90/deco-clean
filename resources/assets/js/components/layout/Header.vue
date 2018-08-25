<template>
  <b-navbar toggleable="md" type="dark" variant="info">

    <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

    <b-navbar-brand href="/home">
      <img v-if="user && user.avatar" :src="user.avatar" class="d-inline-block align-top img img-circle" alt="avatar">
      <span v-else>
        Deco
      </span>
    </b-navbar-brand>

    <b-collapse is-nav id="nav_collapse">

    <!-- <b-navbar-nav>
      <b-nav-item href="#">Link</b-nav-item>
      <b-nav-item href="#" disabled>Disabled</b-nav-item>
    </b-navbar-nav> -->

    <!-- Right aligned nav items -->
    <b-navbar-nav class="ml-auto">
     

     
        <!-- Using button-content slot -->
        <template slot="button-content">
          <b-img class="avatar" v-if="user && user.avatar" rounded="circle" :src="user.avatar"></b-img>
          <b-img class="avatar" v-else rounded="circle" src="/images/users/avatar-1.jpg"></b-img>
        </template>

        <b-nav-item v-if="superLogged" href="/super/users">Usuarios</b-nav-item>
        <b-nav-item v-if="user == null" href="/login">ingresar</b-nav-item>
        <b-nav-item v-if="user == null" href="/register">registrarse</b-nav-item>
        <b-nav-item v-if="adminLogged" href="/admin/crud">Administracion</b-nav-item>
        <b-nav-item v-if="adminLogged" href="/admin/inscripciones">Registrar pagos</b-nav-item>
        <!-- <b-dropdown-item href="#">Salir</b-dropdown-item> -->
      
        <b-nav-item v-if="user != null" @click="logout">Salir</b-nav-item>

       
        
     
    </b-navbar-nav>

  </b-collapse>
</b-navbar>

<!-- navbar-1.vue -->
</template>


<script>
import {userMixin} from '../../mixins/user.js'
export default {
    mixins: [userMixin],
    created(){
      // console.log('created')
      // console.log('aasdasda',this.user);
    },
    watch : {
      user(){
         console.log(this.user);
      }
    },
    methods : {
      logout(){
        FB.getLoginStatus(response => {
          console.log(response);
          if (response.status == 'connected') {
            
          } 
        });
      }
        
    }
    

}
</script>

<style>
    .avatar{width: 50px;}

</style>
