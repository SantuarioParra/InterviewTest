<template>
    <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>
</template>

<script>
    export default {
        name: "breadcrumbs",///Mover a cada uno de los componentes
        data() {
            return {
                breadcrumbs: [
                    {text: 'Login', disable: false, to: {name: 'login'}, exact:true},
                    {text: 'Products', disable: false, to: {name: 'home'}, exact:true},
                    {text: 'Product Detail', disable: false, to: {name: 'productDetail'}, exact:true}//esto da bug por la falta de slug
                ]
            }
        }
    }
</script>

<style scoped>

</style>
