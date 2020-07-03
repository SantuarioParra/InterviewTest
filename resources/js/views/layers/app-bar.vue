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
                v-if="isLogged && isAdmin"
                text
                text-color="white"
                small
                :to="{name:'users'}"
            >
                users
            </v-btn>

            <v-btn
                v-if="!isLogged"
                text
                text-color="white"
                small
                class="d-none d-sm-flex"
                :to="{name:'login'}"
            >
                login
            </v-btn>
            <v-btn
                v-if="!isLogged"
                text
                text-color="white"
                small
                class="d-none d-sm-flex"
                :to="{name:'signup'}"
            >
                Sign up
            </v-btn>
            <v-btn
                v-if="isLogged"
                text
                text-color="white"
                small
                class="d-none d-sm-flex"
                v-on:click.prevent="logOut"
            >
                Log out
            </v-btn>
            <v-btn
                v-if="!isLogged"
                icon
                text-color="white"
                small
                class="d-flex d-sm-none"
                :to="{name:'login'}"
            >
                <v-icon>mdi-login-variant</v-icon>
            </v-btn>
            <v-btn
                v-if="isLogged"
                icon
                text-color="white"
                small
                class="d-flex d-sm-none"
            >
                <v-icon>mdi-logout-variant</v-icon>
            </v-btn>
            <app-cart v-if="!isAdmin"></app-cart>
        </v-toolbar-items>
    </v-app-bar>
</template>

<script>
    import authService from '../../services/auth'
    import {mapActions,mapGetters} from 'vuex'

    export default {
        name: "app-bar",
        data() {
            return {
                /*search*/
                search: ''
            }
        },
        methods: {
            ...mapActions('auth', ['destroyToken']),
            logOut() {
                authService.logout().then(response => {
                    this.$store.dispatch('auth/destroyToken')
                }).catch(error => {
                    console.log(error)
                }).finally(() => {
                    this.$router.push({name: 'login'})
                })
            }
        },
        computed:{
            ...mapGetters('auth',['isLogged','isAdmin']),
            isLogged(){
                return this.$store.getters['auth/isLogged'];
            },
            isAdmin(){
                return this.$store.getters['auth/isAdmin'];
            }
        }
    }
</script>

<style scoped>

</style>
