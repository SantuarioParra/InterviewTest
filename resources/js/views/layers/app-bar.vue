<template>
    <v-app-bar
        app
        flat
        color="grey darken-4"
        dark
    >
        <v-app-bar-nav-icon></v-app-bar-nav-icon>

        <v-toolbar-title class="d-none d-sm-flex">Interview test e-commerce</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-toolbar-items>
            <v-btn
                text
                text-color="white"
                small
                class="d-none d-sm-flex"
                :to="{name:'login'}"
            >
                login
            </v-btn>
            <v-btn
                text
                text-color="white"
                small
                class="d-none d-sm-flex"
                :to="{name:'signup'}"
            >
                Sign up
            </v-btn>
            <v-btn
                text
                text-color="white"
                small
                class="d-none d-sm-flex"
                v-on:click.prevent="logOut"
            >
                Log out
            </v-btn>
            <v-btn
                icon
                text-color="white"
                small
                class="d-flex d-sm-none"
            >
                <v-icon>mdi-login-variant</v-icon>
            </v-btn>
            <app-cart></app-cart>
        </v-toolbar-items>
    </v-app-bar>
</template>

<script>
    import authService from'../../services/auth'
    import {mapActions} from 'vuex'
    export default {
        name: "app-bar",
        data() {
            return {
                /*search*/
                search: ''
            }
        },
        methods:{
            ...mapActions('auth',['destroyToken']),
            logOut(){
                authService.logout().then(response=>{
                    this.$store.dispatch('auth/destroyToken')
                }).catch(error=>{
                    console.log(error)
                }).finally(()=>{
                    this.$router.push({name:'login'})
                })
            }
        }
    }
</script>

<style scoped>

</style>
