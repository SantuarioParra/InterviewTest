<template>
    <v-row fluid>
        <v-col cols="12">
            <v-card
                flat
                v-if="loading"
                class="d-flex align-self-center"
            >
                <v-row>
                    <v-col cols="12" md="5" sm="5">
                        <v-skeleton-loader
                            type="image"
                            height="100%"
                            max-width="100%"
                        >
                        </v-skeleton-loader>
                    </v-col>
                    <v-col cols="12" md="7" sm="7">
                        <v-skeleton-loader
                            type="article,actions "
                            height="100%"
                            max-width="100%"
                        >
                        </v-skeleton-loader>

                    </v-col>
                </v-row>
            </v-card>
            <v-card
                flat
                v-else
            >
                <v-card-actions
                    v-if="isAdmin"
                    class="pb-0">
                    <v-spacer></v-spacer>
                    <v-btn
                        v-if="editorMode===false"
                        text
                        color="blue"
                        dark
                        v-on:click.prevent="editorMode = true"
                    >
                        <v-icon left small>mdi-square-edit-outline</v-icon>
                        edit
                    </v-btn>

                    <v-btn
                        v-if="editorMode===false"
                        text
                        color="error"
                        dark
                    >
                        <v-icon left small>mdi-close</v-icon>
                        delete
                    </v-btn>
                    <v-btn
                        v-if="editorMode === true"
                        text
                        color="blue"
                        dark
                        v-on:click.prevent="updateProduct"
                    >
                        <v-icon left small>mdi-content-save-outline</v-icon>
                        save
                    </v-btn>
                </v-card-actions>
                <v-row>
                    <v-col cols="12" md="5" sm="5">
                        <v-img
                            class="white--text align-end"
                            height="100%"
                            max-width="100%"
                            aspect-ratio="2"
                            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                        >
                        </v-img>
                    </v-col>
                    <v-col v-show="editorMode===false" cols="12" md="7" sm="7">
                        <v-card-title class="text-h3 pt-0">
                            {{product.name}}
                        </v-card-title>
                        <v-card-subtitle class="text-subtitle-1">
                            ${{product.price}}
                        </v-card-subtitle>
                        <v-card-text class="text-justify">
                            {{product.description}}
                        </v-card-text>
                        <v-card-actions v-if="!isAdmin" class="pb-0">
                            <v-row fluid>
                                <v-col class="pt-0 pb-0" cols="12">
                                    <v-row class="pt-0 pb-0" fluid>
                                        <v-col class="pt-0 pb-0" offset-md="4" offset-sm="4" sm="3" md="3">
                                            <v-text-field
                                                label="Quantity"
                                                type="number"
                                                min="1"
                                                max="10"
                                                solo
                                                rounded
                                                dense
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col cols="12"
                                       class="pt-0 pb-0"
                                >
                                    <v-btn
                                        color="blue"
                                        dark
                                        block
                                    >
                                        <v-icon left small>mdi-cart-plus</v-icon>
                                        Add to cart
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-card-actions>
                    </v-col>
                    <v-col v-show="editorMode" cols="12" md="7" sm="7">
                        <v-card-title class="text-h3 pt-0">
                            <v-text-field
                                v-model="product.name"
                                flat
                                label ="Name"
                            ></v-text-field>
                        </v-card-title>
                        <v-card-subtitle class="text-subtitle-1">
                            <v-text-field
                                v-model="product.price"
                                flat
                                label ="Price"
                                type="number"
                            ></v-text-field>
                        </v-card-subtitle>
                        <v-card-text class="text-justify">
                            <v-textarea
                                v-model="product.description"
                                flat
                                label ="Description"
                                auto-grow
                            ></v-textarea>
                        </v-card-text>
                    </v-col>
                </v-row>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import productServices from '../../services/products';
    import {mapGetters} from "vuex";

    export default {
        props: {slug: String},
        name: "Product",
        data() {
            return {
                /*skeleton loader*/
                loading: false,
                /*product*/
                product: {},
                /*Edit*/
                editorMode: false
            }
        },
        methods: {
            async getProduct() {
                try {
                    this.loading = true;
                    let productResponse = await productServices.getProduct(this.slug);
                    this.product = productResponse.data.product;
                } catch (e) {
                    console.log(e)
                } finally {
                    this.loading = false;
                }
            },
            async updateProduct(){
                try {
                    this.loading = true;
                    let productResponse = await productServices.updateProduct(this.product,this.product.id);
                    console.log(productResponse)
                }catch (e) {
                    console.log(e)
                }finally {
                    this.editorMode=false;
                    this.loading =false;
                }
            }
        },
        computed:{
          ...mapGetters('auth',['isAdmin']),
            isAdmin(){
              return this.$store.getters['auth/isAdmin']
            }
        },
        mounted() {
            this.getProduct();
        }
    }
</script>

<style scoped>

</style>
