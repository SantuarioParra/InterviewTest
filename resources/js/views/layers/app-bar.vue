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
            >
                login
            </v-btn>
            <v-btn
                text
                text-color="white"
                small
                class="d-none d-sm-flex"
            >
                Sign up
            </v-btn>
            <v-btn
                icon
                text-color="white"
                small
                class="d-flex d-sm-none"
            >
                <v-icon >mdi-login-variant</v-icon>
            </v-btn>


        </v-toolbar-items>
    </v-app-bar>
</template>

<script>
    export default {
        name: "app-bar",
        data() {
            return {
                /*search*/
                search: ''
            }
        }
    }
</script>

<style scoped>

</style>
