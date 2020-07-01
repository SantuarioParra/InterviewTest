<template>
    <v-container fluid>
        <v-row>
            <v-col>
                <v-snackbar
                    v-model="snackbar"
                    bottom
                    right
                    :color="color"
                    timeout="6000"
                >
                    {{ text }}

                    <template v-slot:action="{ attrs }">
                        <v-btn
                            dark
                            text
                            v-bind="attrs"
                            @click="snackbar = false"
                        >
                            Close
                        </v-btn>
                    </template>
                </v-snackbar>
                <v-card flat>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            v-show="editorMode !== true"
                            color="blue"
                            dark
                            small
                            v-on:click.prevent="editorMode = true"
                        >
                            <v-icon left>mdi-plus</v-icon>
                            add product
                        </v-btn>
                        <v-btn
                            v-show="editorMode === true"
                            color="blue"
                            dark
                            small
                            v-on:click.prevent="editorMode = true"
                        >
                            <v-icon left>mdi-content-save-outline</v-icon>
                            save product
                        </v-btn>
                        <v-btn
                            v-show="editorMode === true"
                            color="warning"
                            dark
                            small
                            v-on:click.prevent="discardProduct"
                        >
                            <v-icon left>mdi-delete-empty</v-icon>
                            discard product
                        </v-btn>
                    </v-card-actions>
                    <v-row v-show="editorMode">
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
                        <v-col cols="12" md="7" sm="7">
                            <v-card-title class="text-h3 pt-0">
                                <v-text-field
                                    v-model="newProduct.name"
                                    flat
                                    label ="Name"
                                ></v-text-field>
                            </v-card-title>
                            <v-card-subtitle class="text-subtitle-1">
                                <v-text-field
                                    v-model="newProduct.price"
                                    flat
                                    label ="Price"
                                    type="number"
                                ></v-text-field>
                            </v-card-subtitle>
                            <v-card-text class="text-justify">
                                <v-textarea
                                    v-model="newProduct.description"
                                    flat
                                    label ="Description"
                                    auto-grow
                                ></v-textarea>
                            </v-card-text>
                        </v-col>
                    </v-row>

                    <v-data-iterator
                        v-show="editorMode===false"
                        :items="products"
                        :options.sync="options"
                        :server-items-length="pagination.totalProducts"
                        :footer-props="footer_props"
                    >
                        <template v-slot:default="props">
                            <v-row>
                                <v-col
                                    v-for="(product) in props.items"
                                    :key="product.id"
                                    cols="12"
                                    sm="6"
                                    md="4"
                                    lg="4"
                                >
                                    <v-skeleton-loader
                                        v-if="loading"
                                        type="image,paragraph"
                                    ></v-skeleton-loader>
                                    <v-card
                                        v-if="loading === false"
                                    >
                                        <v-img
                                            class="white--text align-end"
                                            height="50%"
                                            max-width="100%"
                                            aspect-ratio="2"
                                            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                                        >
                                        </v-img>
                                        <v-card-title>
                                            {{product.name}}
                                        </v-card-title>
                                        <v-card-subtitle>
                                            ${{product.price}}
                                        </v-card-subtitle>
                                        <v-card-text>
                                            <span class="text-justify d-inline-block text-truncate"
                                                  style="max-width: 100%"
                                            >
                                                    {{product.description}}
                                            </span>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-row
                                            >
                                                <v-col
                                                    cols="12"
                                                    class="pt-0"
                                                >
                                                    <v-btn
                                                        color="blue"
                                                        dark
                                                        block
                                                    >
                                                        <v-icon small left>mdi-cart-plus</v-icon>
                                                        Add to cart
                                                    </v-btn>
                                                </v-col>
                                                <v-col
                                                    cols="12"
                                                    class="pt-0"
                                                >
                                                    <v-btn
                                                        text
                                                        color="blue"
                                                        dark
                                                        block
                                                        link
                                                        :to="{name:'productDetail',params:{'slug':product.slug}}"
                                                    >
                                                        See more...
                                                    </v-btn>
                                                    <v-btn
                                                        text
                                                        color="blue"
                                                        dark
                                                        block
                                                        link
                                                        v-on:click.prevent="deleteProduct(product)"
                                                    >
                                                        Eliminar
                                                    </v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-card-actions>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </template>
                    </v-data-iterator>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
    import {mapActions} from 'vuex';
    import productServices from '../../services/Products';

    export default {
        name: "Home",
        data() {
            return {
                /*loading*/
                loading: false,
                /*DataIterator*/
                products: [],
                pagination: {
                    current: 1,
                    total: 0,
                    totalProducts: 0
                },
                footer_props: {
                    'items-per-page-options': [10, 15, 20, 50],
                },
                options: {},
                /*Snackbar*/
                text: '',
                color: '',
                snackbar: false,
                /*New Product*/
                editorMode: false,
                newProduct: {
                    'name':'',
                    'slug':'',
                    'price':0,
                    'description':''
                },
                defaultProduct:{
                    'name':'',
                    'slug':'',
                    'price':0,
                    'description':''
                }
            }
        },
        mounted() {
            this.getAllProducts();
        },
        methods: {
            async getAllProducts() {
                this.loading = true;
                const {page, itemsPerPage} = this.options;
                let productsResponse = await productServices.getProducts(page, itemsPerPage);
                this.products = productsResponse.data.products.data;
                this.pagination.total = productsResponse.data.products;
                this.pagination.totalProducts = productsResponse.data.products.total;
                this.loading = false;
            },
            async addProduct() {
                try {
                    this.loading = true;

                } catch (e) {
                    console.log(e)
                } finally {
                    this.loading = false;
                }
            },
            discardProduct(){
              this.editorMode =false;
              this.newProduct = this.defaultProduct;
            },
            async deleteProduct(product) {
                if (confirm(`Are you sure about delete ${product.name}?`)) {
                    try {
                        let deleteResponse = await productServices.deleteProduct(product.id);
                        if (deleteResponse.status >= 200 && deleteResponse.status < 300) {
                            this.color = 'success'
                        } else if (deleteResponse.status >= 300 && deleteResponse.status < 500) {
                            this.color = 'warning'
                        } else if (deleteResponse.status >= 500) {
                            this.color = 'error'
                        }
                        this.text = deleteResponse.data.message;
                    } catch (e) {
                        console.log(e);
                    } finally {
                        this.snackbar = true;
                        this.getAllProducts()
                    }
                }
            },
        },
        watch: {
            search() {
                this.getAllProducts();
            },
            options() {
                this.getAllProducts();
            },
        },
    }
</script>

<style scoped>

</style>
