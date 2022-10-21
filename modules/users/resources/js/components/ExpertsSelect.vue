<template>
    <div>
        <v-combobox
            v-model="select"
            :items="experts"
            :label="label"
            outlined
            item-text="title"
            item-value="title"
            return-object
            @input="change"
            item-color="white"
            :rules="expertRules"
        >
        </v-combobox>
        <input type="hidden" name="expert_id" :value="expert"/>
    </div>
</template>

<script>
export default {
    name: "ExpertsSelect",
    props:['expert_id','label'],
    data() {
        return {
            experts: [],
            expert: '',
            select: '',
            expertRules: [
                v => !!v || this.label + ' نمیتواند خالی باشد'
            ],
        }
    },
    mounted() {
        this.getExpertList();
    },
    methods: {
        getExpertList: function () {
            const url = this.$siteUrl + '/api/app/experts';
            this.axios.get(url).then(response => {
                for (let i = 0; i < response.data.original.length; i++) {
                    const p = response.data.original[i];
                    this.experts.push({'title': p.name, 'id': p.id});
                    if (this.expert_id !== undefined && p.id == this.expert_id) {
                        this.select = {'title': p.name, 'id': p.id};
                        this.expert = this.expert_id;
                    }
                }
            });
        },
        change: function (value) {
            this.expert = value['id'];
            this.$root.$emit('get_child_value',{name:"expert_id", value:this.expert});
        },
    }
}
</script>
