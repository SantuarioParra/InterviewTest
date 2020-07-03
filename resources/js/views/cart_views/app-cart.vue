<template>
    <v-menu
        offset-y
        open-on-hover
    >
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                color="white"
                icon
                dark
                v-bind="attrs"
                v-on="on"
            >
                <v-badge
                    color="blue"
                    :content="totalProducts"
                    :value="totalProducts"

                >
                    <v-icon>mdi-cart</v-icon>
                </v-badge>
            </v-btn>
        </template>
        <v-list>
            <v-list-item
                v-for="product in products"
                :key="product.id"
            >
                <v-list-item-avatar
                    tile
                >
                    <v-avatar
                        tile
                    >
                        <v-img
                            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                        >
                        </v-img>
                    </v-avatar>
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title>{{ product.name }}</v-list-item-title>
                    <v-list-item-subtitle v-text="`Quantity: ${product.quantity}`"></v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn
                        icon
                        color="red"
                        dark
                        v-on:click.prevent="deleteCartProduct(product)"
                    >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-list-item-action>
            </v-list-item>
            <v-list-item
            v-if="totalProducts!==0"
            >
                <v-btn
                    small
                    color="blue"
                    dark
                    :to="{name:'checkOut'}"
                >
                    check Out
                </v-btn>
            </v-list-item>
        </v-list>

    </v-menu>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        name: "app-cart",
        data() {
            return {}
        },
        methods: {
            ...mapActions('cart', ['deleteProduct']),
            deleteCartProduct(product) {
                this.$store.commit('cart/deleteProduct', product)
            }
        },
        computed: {
            ...mapGetters('cart', ['getAllProducts', 'getProductsQuantity']),
            products() {
                return this.$store.getters['cart/getAllProducts']
            },
            totalProducts() {
                return this.$store.getters['cart/getProductsQuantity']
            }
        }
    }
</script>

<style scoped>

</style>
