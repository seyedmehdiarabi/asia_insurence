<template>
    <div>
        <v-combobox
            v-model="select"
            :items="users"
            :label="label"
            outlined
            item-text="title"
            return-object
            @input="change"
            item-color="white"
            :multiple="multiple"
        >
            <template v-slot:prepend-item v-if="multiple">
                <v-list-item
                    ripple
                    @mousedown.prevent
                    @click="toggle"
                >
                    <v-list-item-action>
                        <v-icon :color="select.length > 0 ? 'indigo darken-4' : ''">
                            {{ icon }}
                        </v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>
                            انتخاب همه
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-divider class="mt-2"></v-divider>
            </template>
        </v-combobox>
        <input type="hidden" name="user_id" :value="user"/>
    </div>
</template>

<script>
export default {
    name: "UsersSelect",
    props: ['user_id', 'type', 'labelName', 'where'],
    data() {
        return {
            users: [],
            user: '',
            select: [],
            multiple: false,
            label: 'اشخاص',
            whereIN: 'all'
        }
    },
    mounted() {
        this.getUserList();
        if (this.type !== undefined && this.type === 'multiple') {
            this.multiple = true;
        }
        if (this.labelName !== undefined) {
            this.label = this.labelName;
        }
    },
    computed: {
        likesAllUser() {
            return this.select.length === this.users.length
        },
        likesSomeUser() {
            return this.select.length > 0 && !this.likesAllUser
        },
        icon() {
            if (this.likesAllUser) return 'mdi-close-box'
            if (this.likesSomeUser) return 'mdi-minus-box'
            return 'mdi-checkbox-blank-outline'
        },
    },

    methods: {
        getUserList: function () {
            const url = this.$siteUrl + '/api/app/usersSelect';
            const formData = new FormData();
            if (this.where !== undefined) {
                this.whereIN = this.where;
            }
            formData.append('where', this.whereIN);
            this.axios.post(url, formData).then(response => {
                let add_data = response.data.original;
                for (let i = 0; i < add_data.length; i++) {
                    const p = add_data[i];
                    this.users.push({'title': p.name, 'id': p.id});
                }
                if (this.user_id !== undefined) {
                    let props_users = JSON.parse(this.user_id);
                    for (let j = 0; j < props_users.length; j++) {
                        const m = add_data[props_users[j]['id'] - 1];
                        if (m.id == props_users[j]['id']) {
                            this.select.push({'title': m.name, 'id': m.id});
                            this.user = JSON.stringify(props_users);
                        }
                    }
                }
            });
        },
        change: function (value) {
            if (this.multiple) {
                if (this.user_id !== undefined && this.user_id === '') {
                    this.user = JSON.stringify(value);
                } else {
                    this.user = value;
                }
            } else {
                this.user = value['id'];
            }
            this.$root.$emit('get_child_value', {name: "users", value: this.user});
        },
        toggle() {
            this.$nextTick(() => {
                if (this.likesAllUser) {
                    this.select = []
                } else {
                    this.select = this.users.slice();
                }
                //  this.$root.$emit('get_child_value',{name:"users", value:this.user});
            })
        },
    }
}
</script>

<style scoped>

</style>
