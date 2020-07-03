<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12">
                <v-container fill-height fluid>
                    <v-row align="center"
                           justify="center">
                        <v-col cols="12" md="6" sm="6">
                            <v-card>
                                <v-img
                                    class="white--text align-end"
                                    height="100px"
                                    max-height="50%"
                                    max-width="100%"
                                    aspect-ratio="2"
                                    src="https://i.picsum.photos/id/1060/5598/3732.jpg?hmac=31kU0jp5ejnPTdEt-8tAXU5sE-buU-y1W1qk_BsiUC8"
                                >
                                    <v-card-title class="text-h4">Login</v-card-title>
                                </v-img>
                                <v-card-text>
                                    <v-row fluid>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="credentials.email"
                                                label="Email"
                                                prepend-inner-icon="mdi-email"
                                                clearable
                                                :error-messages="emailErrors"
                                                @blur="$v.credentials.email.$touch()"
                                                @input="$v.credentials.email.$touch()"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="credentials.password"
                                                label="Password"
                                                prepend-inner-icon="mdi-form-textbox-password"
                                                clearable
                                                :type="showPassword ? 'text' : 'password'"
                                                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                                @click:append="showPassword = !showPassword"
                                                :error-messages="passwordErrors"
                                                @blur="$v.credentials.password.$touch()"
                                                @input="$v.credentials.password.$touch()"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                                <v-card-actions>
                                    <v-row fluid>
                                        <v-col cols="6">
                                            <v-row
                                                align="start"
                                                justify="start"
                                            >
                                                <v-col>
                                                    <v-btn
                                                        text
                                                        dark
                                                        color="blue"
                                                        :to="{name:'signup'}"
                                                    >signup
                                                    </v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-row
                                                align="end"
                                                justify="end"
                                            >
                                                <v-col
                                                    cols="12"
                                                    lg="6"
                                                    md="9"
                                                    sm="6"
                                                >
                                                    <v-btn
                                                        dark
                                                        color="blue"
                                                        v-on:click.prevent="login"
                                                    >login
                                                    </v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                    </v-row>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-col>
        </v-row>
    </v-container>

</template>

<script>
    import authService from '../../services/auth';
    import {mapActions} from 'vuex';
    import {required,email,minLength} from "vuelidate/lib/validators";

    export default {
        name: "login",
        data() {
            return {
                showPassword: false,
                credentials: {
                    'email': '',
                    'password': '',
                }
            }
        },
        validations:{
            credentials:{
                email:{required,email},
                password:{required,minLength:minLength(8)}
            }
        },
        computed:{
            emailErrors() {
                const errors = [];
                if (!this.$v.credentials.email.$dirty) return errors;
                !this.$v.credentials.email.required && errors.push('Email is required.');
                !this.$v.credentials.email.email && errors.push('Invalid email given.');
                return errors
            },
            passwordErrors() {
                const errors = [];
                if (!this.$v.credentials.password.$dirty) return errors;
                !this.$v.credentials.password.required && errors.push('Password is required');
                !this.$v.credentials.password.minLength && errors.push('Password length is too short, min:8 characters.');
                return errors
            },
        },
        methods: {
            ...mapActions('auth', ['saveToken','refresh']),
            login() {
                authService.login(this.credentials).then(response => {
                    this.$store.dispatch('auth/saveToken', response);

                }).catch(error => {
                    console.log(error.response);
                }).finally(() => {
                    this.$router.push({name: 'home'});
                    this.$store.dispatch('auth/refresh');
                });

            }
        }
    }
</script>

<style scoped>

</style>
