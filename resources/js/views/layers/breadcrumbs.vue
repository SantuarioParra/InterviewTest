<template>
    <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>
</template>

<script>
    export default {
        name: "breadcrumbs",
        data() {
            return {
                breadcrumbs: [
                    {text: 'Products', disable: false, to: {name: 'home'}, exact:true},
                    {text: 'Product Detail', disable: false, to: {name: 'productDetail'}, exact:true}//esto da bug por la falta de slug
                ]
            }
        }
    }
</script>

<style scoped>

</style>
