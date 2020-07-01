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
                    {text: 'Product Detail', disable: false, to: {name: 'productDetail'}, exact:true}
                ]
            }
        }
    }
</script>

<style scoped>

</style>
