<template>
    <v-app-bar absolute color="white" elevate-on-scroll height="60">

        <v-app-bar-nav-icon @click="$root.$emit('changeNavigation')"/>

        <div class="d-flex justify-lg-space-between align-center" style="width: 100%">
            <v-toolbar-title>پنل مدیریت (کاربر : {{ user['name'] }})</v-toolbar-title>
            <div class="ml-4">
                <v-tooltip bottom color="red">
                    <template v-slot:activator="{on,attrs}">
                        <v-icon
                            @click="logout"
                            color="red"
                            v-bind="attrs"
                            v-on="on"
                        >
                            mdi-logout
                        </v-icon>
                    </template>
                    <span>خروج از حساب کاربری</span>
                </v-tooltip>
            </div>
        </div>
    </v-app-bar>

</template>

<script>
export default {
    name: "PanelAppBar",
    props: ['user'],
    methods: {
        logout: function () {
            window.location.href = this.$siteUrl + '/logout'
        }
    }
}
</script>

<style scoped>

</style>
