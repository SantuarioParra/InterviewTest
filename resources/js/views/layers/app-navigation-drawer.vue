<template>
    <v-navigation-drawer app>
        <v-list
            dense
            nav
            class="py-0"
        >
            <v-list-item two-line>
                <v-list-item-avatar>
                    <img src="https://randomuser.me/api/portraits/men/81.jpg">
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title>Application</v-list-item-title>
                    <v-list-item-subtitle>Subtext</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

        </v-list>
    </v-navigation-drawer>
</template>

<script>
    export default {
        name: "app-navigation-drawer"
    }
</script>

<style scoped>

</style>
