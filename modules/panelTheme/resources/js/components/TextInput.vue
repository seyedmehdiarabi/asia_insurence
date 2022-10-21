<template>
    <div :class="className">
        <v-text-field
            :label="label!=='false' ? label : ''"
            outlined
            :dense="dense"
            :type="type"
            v-model="input"
            :rules="rules"
            :suffix="suffix"
            :prepend-inner-icon="prepend_inner_icon"
            :append-icon="append_icon"
            :min="min"
            :disabled="disabled"
        ></v-text-field>
        <input type="hidden" :name="name" v-model="input" />
    </div>
</template>

<script>
import methods from "./../methods";
export default {
    name: "TextInput",
    props:['name','label','args','value','input_type'],
    mixins:[methods],
    data(){
        return {
            input:'',
            options:[],
            type:"string",
            className:'c-field',
            rules:[],
            prepend_inner_icon:'',
            append_icon:'',
            suffix:'',
            min:'',
            dense:true,
            disabled:false
        }
    },
    mounted() {
        if(this.input_type!==undefined){
            this.type=this.input_type;
        }
        this.input=this.value;
        if(this.value==='null'){
            this.input='';
        }
        if(this.args!==null){
            this.options=this.args;
            if(this.options['type']!==undefined){
                this.type=this.options['type'];
            }
            if(this.options['suffix']!==undefined){
                this.suffix=this.options['suffix'];
            }
            if(this.options['min']!==undefined){
                this.min=this.options['min'];
            }
            if(this.options['class']!==undefined){
                this.className=this.className+' '+this.options['class'];
            }
            if(this.options['validate']!==undefined){
                this.setValidate(this.options['validate']);
            }
            if(this.options['prepend']!==undefined){
                this.prepend_inner_icon=this.options['prepend'];
            }
            if(this.options['append_icon']!==undefined){
                this.append_icon=this.options['append_icon'];
            }
            if(this.options['dense']!==undefined){
                this.dense=this.options['dense'];
            }
            if(this.options['disabled']!==undefined){
                this.disabled=this.options['disabled'];
            }
        }
    }
}
</script>

<style>
@import "../style.css";
</style>
