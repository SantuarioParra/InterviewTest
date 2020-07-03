<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12">
                <v-card v-if="editorMode===false" flat>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="blue"
                            dark
                            small
                            v-on:click.prevent="createUser"
                        >
                            <v-icon left>mdi-plus</v-icon>
                            new user
                        </v-btn>

                    </v-card-actions>
                    <v-data-table
                        :loading="loading"
                        :items="users"
                        :options.sync="options"
                        :server-items-length="pagination.totalUsers"
                        :headers="headers"
                        :footer-props="footer_props"
                    >
                        <template v-slot:item.deleted_at="{item}">
                            <v-chip color="blue-grey darken-4" dark small v-if="item.deleted_at !==null">
                                <v-icon small color="red" left>mdi-power-off</v-icon>
                                INACTIVE
                            </v-chip>
                            <v-chip dark text-color="white" color="blue-grey darken-4" small v-else>
                                <v-icon small color="blue" left>mdi-power</v-icon>
                                ACTIVE
                            </v-chip>
                        </template>
                        <template v-slot:item.options="{item}">
                            <v-btn
                                v-if="item.deleted_at===null"
                                icon
                                dark
                                color="blue"
                                v-on:click.prevent="editUser(item)"
                            >
                                <v-icon>mdi-square-edit-outline</v-icon>
                            </v-btn>
                            <v-btn
                                v-if="item.deleted_at===null"
                                icon
                                dark
                                color="error"
                                v-on:click="deleteUser(item.id)"
                            >
                                <v-icon>mdi-delete-outline</v-icon>
                            </v-btn>
                            <v-btn
                                v-if="item.deleted_at!==null"
                                icon
                                dark
                                color="warning"
                                v-on:click="restoreUser(item.id)"
                            >
                                <v-icon>mdi-delete-restore</v-icon>
                            </v-btn>

                        </template>
                    </v-data-table>
                </v-card>
                <v-card v-else flat>
                    <v-card-text>
                        <v-row fluid>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedUser.name"
                                    label="Name"
                                    clearable
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedUser.email"
                                    label="Email"
                                    prepend-inner-icon="mdi-email"
                                    clearable
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedUser.password"
                                    label="Password"
                                    prepend-inner-icon="mdi-form-textbox-password"
                                    clearable
                                    :type="showPassword ? 'text' : 'password'"
                                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append="showPassword = !showPassword"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedUser.password_confirmation"
                                    label="Password confirmation"
                                    prepend-inner-icon="mdi-form-textbox-password"
                                    clearable
                                    :type="showPassword ? 'text' : 'password'"
                                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append="showPassword = !showPassword"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-autocomplete
                                    v-model="editedUser.role"
                                    :items="roles"
                                    :loading="loading"
                                    item-text="name"
                                    item-value="name"
                                    label="User role"
                                    hide-selected
                                    :search-input.sync="new_role.name"
                                    v-on:keyup.enter="add_new_role(new_role)"
                                    clearable
                                ></v-autocomplete>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-row fluid>
                            <v-col cols="12">
                                <v-row fluid justify="end" align="end">
                                    <v-col cols="12" md="2" sm="2">
                                        <v-btn
                                            color="warning"
                                            dark
                                            small
                                            v-on:click.prevent="cancelEditUser"
                                        >
                                            <v-icon left>mdi-delete-empty</v-icon>
                                            cancel
                                        </v-btn>
                                    </v-col>
                                    <v-col cols="12" md="2" sm="2">
                                        <v-btn
                                            v-if="newUser === false"
                                            color="blue"
                                            dark
                                            small
                                            v-on:click.prevent="updateUser"
                                        >
                                            <v-icon left>mdi-content-save-outline</v-icon>
                                            update user
                                        </v-btn>
                                        <v-btn
                                            v-else
                                            color="blue"
                                            dark
                                            small
                                            v-on:click.prevent="saveUser"
                                        >
                                            <v-icon left>mdi-content-save-outline</v-icon>
                                            save user
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

</template>

<script>
    import usersService from '../../services/users';
    import roleServices from '../../services/roles';
    import {mapActions} from "vuex";

    export default {
        name: "users",
        data() {
            return {
                newUser: false,
                loading: false,
                /*Table config*/
                users: [],
                pagination: {
                    current: 1,
                    total: 0,
                    totalUsers: 0
                },
                footer_props: {
                    'items-per-page-options': [10, 15, 20, 50],
                },
                headers: [
                    {text: 'Name', value: 'name', align: "start", sortable: false},
                    {text: 'Email', value: 'email', sortable: false},
                    {text: 'Status', value: 'deleted_at', align: "center", sortable: false},
                    {text: 'Options', value: 'options', align: "center", sortable: false}
                ],
                options: {},
                /*User config*/
                editedUser: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    role: ''
                },
                defaultUser: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    role: ''
                },
                /*editor*/
                editorMode: false,
                showPassword: false,
                /*role Autocomplete*/
                new_role: {
                    name: '',
                    guard_name: 'api'
                }
            }
        },
        methods: {
            ...mapActions('users', ['updateUsers']),
            ...mapActions('roles', ['updateRoles']),
            async getAllData() {
                this.loading = true;
                const {page, itemsPerPage} = this.options;
                let usersResponse = await usersService.getUsers(page, itemsPerPage);
                this.users = usersResponse.data.users.data;
                this.pagination.total = usersResponse.data.users;
                this.pagination.totalUsers = usersResponse.data.users.total;
                this.$store.dispatch('users/updateUsers', this.users);
                let rolesResponse = await roleServices.getRoles();
                this.roles = rolesResponse.data.roles;
                this.$store.dispatch('roles/updateRoles', this.roles);
                this.loading = false;
            },

            async deleteUser(id) {
                if (confirm('Are you sure about delete this user?')) {
                    let response = await usersService.deleteUser(id);
                    console.log(response);
                    this.getAllData();
                }
            },
            async restoreUser(id) {
                if (confirm('Are you sure about restore this user?')) {
                    let response = await usersService.restoreUser(id);
                    console.log(response);
                    this.getAllData();
                }
            },
            editUser(item) {
                this.editedUser = item;
                this.editorMode = true;
            },

            cancelEditUser() {
                this.editedUser = this.defaultUser;
                this.editorMode = false;
            },

            async add_new_role(new_role) {
                this.loading = true;
                let roleResponse = await roleServices.saveRole(new_role);
                console.log(roleResponse);
                this.getAllData();
                this.loading = false;
            },

            async updateUser() {
                this.loading = true;
                let userResponse = await usersService.updateUser(this.editedUser, this.editedUser.id);
                console.log(userResponse.response);
                this.getAllData();
                this.editorMode = false;
            },
            createUser() {
                this.editorMode = true;
                this.newUser = true;
            },
            async saveUser() {
                this.loading = true;
                let userResponse = await usersService.saveUser(this.editedUser);
                console.log(userResponse.response);
                this.getAllData();
                this.editorMode = false;
                this.newUser = false;
            }
        },
        mounted() {
            this.getAllData();
        },
        watch: {
            options() {
                this.getAllData();
            },
        }
    }
</script>

<style scoped>

</style>
