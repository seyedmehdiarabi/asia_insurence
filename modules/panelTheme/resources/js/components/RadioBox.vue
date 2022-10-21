<template>
    <div>
        <v-radio-group
            :label="label"
            v-model="radioBox"
            :class="className"
            :name="name"
        >
            <div class="radio-box">
                <v-radio
                    v-for="(value,key) in args.data"
                    :key="key"
                    :label=value
                    :value="key"
                    :color="color[key-1]"
                ></v-radio>
            </div>
        </v-radio-group>

        <input type="hidden" v-model="radioBox" :name="name"/>
    </div>
</template>

<script>
import methods from "../methods";
export default {
    name: "RadioBox",
    props: ['label', 'args', 'value', 'name'],
    mixins:[methods],
    data() {
        return {
            radioBox: "1",
            className: '',
            color: ['warning', 'success', 'red'],
        }
    },
    mounted() {
        if (this.value!==''){
            this.radioBox = this.value;
        }
        if (this.args['class'] !== undefined) {
            this.className = this.className + ' ' + this.args['class'];
        }
    },
}
</script>
<style>
.radio-box {
    display: flex;
    justify-content: space-around;
    align-items: baseline;
}

.label-radio .v-label:first-child {
    text-align: right !important;
    font-size: 16px !important;
    color: black;
}
</style>
