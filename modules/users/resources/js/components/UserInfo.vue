<template>
    <div class="row">
        <div class="col-md-12">
            <v-card class="mx-auto mt-3" max-width="97%">
                <v-list-item three-line>

                    <v-list-item-avatar tile size="80" color="grey">
                        <img v-if="user['pic_profile']" v-bind:src="$siteUrl+'/files/user/'+user['pic_profile']">
                        <img v-else v-bind:src="$siteUrl+'/files/icons/default_user.png'">
                    </v-list-item-avatar>

                    <v-list-item-content class="visit-kart">

                        <v-list-item-title class="text-h5 mb-1"> {{ ceremonial + ' ' + user['name'] }}
                        </v-list-item-title>

                        <v-list-item-subtitle>{{ replaceNumber(user['mobile']) }}</v-list-item-subtitle>

                        <v-list-item-action-text>آدرس:</v-list-item-action-text>

                    </v-list-item-content>

                </v-list-item>

            </v-card>
            <v-card class="mx-auto mt-3" max-width="97%">
                <v-list-item>
                    <v-list-item-content class="visit-kart">
                        <v-list-item-title v-for="(key, index) in info" class="text-h6 mb-3 info-item">
                            <v-icon>{{ info[index]['icon'] }}</v-icon>
                            <span>{{ info[index]['title'] }}</span>
                            <span>{{info[index]['value']}}</span>
                        </v-list-item-title>
                    </v-list-item-content>

                </v-list-item>

            </v-card>
        </div>

    </div>
</template>

<script>
export default {
    name: "UserInfo",
    props: ['user_info', 'additional_info', 'count', 'ceremonial'],
    data() {
        return {
            info: JSON.parse(this.additional_info),
            user: JSON.parse(this.user_info)
        }
    },
    methods: {
        replaceNumber: function (n) {
            if (n != undefined) {
                n = n.toString();
                const find = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                const replace = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
                for (let i = 0; i < find.length; i++) {
                    n = n.replace(new RegExp(find[i], 'g'), replace[i]);
                }
                return n;
            }
        },
    },
    mounted() {

    }
}
</script>

<style>
@import "../style.css";
</style>
