<template>
    <v-app>
        <!--<app-navigation-drawer></app-navigation-drawer>-->

       <app-bar></app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>
            <!-- Provides the application the proper gutter -->
            <v-container fluid>
                <breadcrumbs></breadcrumbs>
                <!-- If using vue-router -->
                <router-view></router-view>
            </v-container>
        </v-main>

        <v-footer app>
            <!-- -->
        </v-footer>
    </v-app>
</template>

<script>
    export default {
        name: "app",

    }
</script>

<style scoped>

</style>
