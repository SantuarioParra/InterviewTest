<template>
    <v-container fluid>
        <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>
        <v-row>
            <v-col cols="12">
                <v-row>
                    <v-col cols="12" md="6" sm="6">
                        <v-card flat>
                            <v-card-title>
                                Total products: {{getProductsQuantity}}
                            </v-card-title>
                            <v-card-text>
                                <v-list>
                                    <v-list-item
                                        three-line
                                        v-for="product in getAllProducts"
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
                                            <v-list-item-title v-text="product.name "></v-list-item-title>
                                            <v-list-item-subtitle
                                                v-text="`$ ${product.price} X ${product.quantity}`"></v-list-item-subtitle>
                                            <v-list-item-subtitle v-text="product.description"></v-list-item-subtitle>
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
                                </v-list>
                            </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="6" sm="6">
                        <v-card>
                            <v-card-text>
                                <v-row fluid>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="check_out.name"
                                            label="Name"
                                            clearable
                                            :error-messages="nameErrors"
                                            @blur="$v.check_out.name.$touch()"
                                            @input="$v.check_out.name.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="check_out.address"
                                            label="Address"
                                            clearable
                                            append-outer-icon="mdi-map-marker"
                                            :error-messages="addressErrors"
                                            @blur="$v.check_out.address.$touch()"
                                            @input="$v.check_out.address.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md=6 sm="6">
                                        <v-text-field
                                            v-model="check_out.state"
                                            label="State"
                                            clearable
                                            :error-messages="stateErrors"
                                            @blur="$v.check_out.state.$touch()"
                                            @input="$v.check_out.state.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md=6 sm="6">
                                        <v-text-field
                                            v-model="check_out.country"
                                            label="Country"
                                            clearable
                                            :error-messages="countryErrors"
                                            @blur="$v.check_out.country.$touch()"
                                            @input="$v.check_out.country.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="check_out.creditCardNumber"
                                            label="Credit Card Number"
                                            clearable
                                            v-mask="'#### #### #### ####'"
                                            placeholder="Card Number"
                                            append-outer-icon="mdi-credit-card-outline"
                                            :error-messages="creditCardErrors"
                                            @blur="$v.check_out.creditCardNumber.$touch()"
                                            @input="$v.check_out.creditCardNumber.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col>
                                        <v-text-field
                                            v-model="check_out.expDate"
                                            label="Exp.Date"
                                            clearable
                                            v-mask="'##/##'"
                                            placeholder="MM/YY"
                                            append-outer-icon="mdi-calendar"
                                            :error-messages="expDateErrors"
                                            @blur="$v.check_out.expDate.$touch()"
                                            @input="$v.check_out.expDate.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col>
                                        <v-text-field
                                            v-model="check_out.cvc"
                                            label="CVV"
                                            clearable
                                            v-mask="'###'"
                                            :error-messages="cvcErrors"
                                            @blur="$v.check_out.cvc.$touch()"
                                            @input="$v.check_out.cvc.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn
                                    dark
                                    color="blue"
                                    block
                                >
                                    Pay ${{productsTotalPrice}} USD
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import {required} from "vuelidate/lib/validators";

    export default {
        name: "cart-check-out",
        data() {
            return {
                products: [],
                productsTotal: 0,
                check_out: {
                    name: '',
                    address: '',
                    state: '',
                    country: '',
                    creditCardNumber: '',
                    expDate: '',
                    cvc: ''
                },
                breadcrumbs: [
                    {text: 'Products', disable: false, to: {name: 'home'}, exact:true},
                    {text: 'Check Out', disable: false, to: {name: 'checkOut'}, exact:true}
                ],
            }
        },
        validations: {
            check_out: {
                name: {required},
                address: {required},
                state: {required},
                country: {required},
                creditCardNumber: {required},
                expDate: {required},
                cvc: {required}
            }
        },
        computed: {
            ...mapGetters('cart', ['getAllProducts', 'getProductsQuantity', 'productsTotalPrice']),
            getAllProducts() {
                return this.$store.getters['cart/getAllProducts'];
            },
            getProductsQuantity() {
                return this.$store.getters['cart/getProductsQuantity'];
            },
            productsTotalPrice() {
                return this.$store.getters['cart/productsTotalPrice']
            },
            nameErrors() {
                const errors = [];
                if (!this.$v.check_out.name.$dirty) return errors;
                !this.$v.check_out.name.required && errors.push('Name is required');
                return errors
            },
            addressErrors() {
                const errors = [];
                if (!this.$v.check_out.address.$dirty) return errors;
                !this.$v.check_out.address.required && errors.push('Address is required');
                return errors
            },
            stateErrors() {
                const errors = [];
                if (!this.$v.check_out.state.$dirty) return errors;
                !this.$v.check_out.state.required && errors.push('State is required');
                return errors
            },
            countryErrors() {
                const errors = [];
                if (!this.$v.check_out.country.$dirty) return errors;
                !this.$v.check_out.country.required && errors.push('Country is required');
                return errors
            },
            creditCardErrors() {
                const errors = [];
                if (!this.$v.check_out.creditCardNumber.$dirty) return errors;
                !this.$v.check_out.creditCardNumber.required && errors.push('Credit card number is required');
                return errors
            },
            expDateErrors() {
                const errors = [];
                if (!this.$v.check_out.expDate.$dirty) return errors;
                !this.$v.check_out.expDate.required && errors.push('Expiration date is required');
                return errors
            },
            cvcErrors() {
                const errors = [];
                if (!this.$v.check_out.cvc.$dirty) return errors;
                !this.$v.check_out.cvc.required && errors.push('CVC is required');
                return errors
            },
        },
        methods: {
            ...mapActions('cart', ['deleteProduct']),
            deleteCartProduct(product) {
                this.$store.commit('cart/deleteProduct', product)
            }
        },
        mounted() {
        },
    }
</script>

<style scoped>

</style>
