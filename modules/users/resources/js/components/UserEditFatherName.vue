<template>
    <v-dialog
      v-model="dialog"
      width="450"
    >

        <v-card :loading="loading" :disabled="loading">

            <v-card-title style="font-size: 16px">
                <v-btn
                   icon
                   @click="dialog=false"
                >
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                نام پدر
            </v-card-title>

            <v-card-text style="padding-top: 20px">

                  <v-form ref="form" v-model="valid">

                      <v-alert v-if="error" type="error">
                          {{ error }}
                      </v-alert>


                      <v-text-field
                         outlined
                         label="نام پدر"
                         v-model="fatherName"
                         :rules="fatherNameRules"
                      ></v-text-field>

                  </v-form>

            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="success"
                    @click="updateName()"
                >
                    ثبت
                </v-btn>
            </v-card-actions>
        </v-card>

    </v-dialog>
</template>

<script>
export default {
    name: "UserEditFatherName",
    props:['id'],
    data(){
        return {
            fatherName:'',
            dialog:false,
            error:false,
            loading:false,
            valid:false,
            fatherNameRules: [
                v => !!v || 'نام پدر نمی‌تواند خالی باشد',
            ]
        }
    },
    mounted() {
        this.$root.$on('edit_user_father_name',(value)=>{
             if(value!=='-'){
                 this.fatherName=value;
             }
             this.dialog=true;
        });
    },
    methods:{
        updateName:function (){
            this.$refs.form.validate();
            if(this.valid){
                this.loading=true;
                this.error=false;
                const formData=new FormData();
                formData.append('father_name',this.fatherName);
                const url=this.$siteUrl+'/add/register_detail/'+this.id;
                this.axios.post(url,formData).then(response=>{
                    this.loading=false;
                    if(response.data==='ok'){
                        this.dialog=false;
                        this.$root.$emit('send_get_request',window.location.href);
                    }
                    else {
                        this.error='خطا در ارسال اطلاعات،مجددا تلاش نمایید';
                    }
                }).catch(error=>{
                    this.loading=false;
                    this.error='خطا در ارسال اطلاعات،مجددا تلاش نمایید';
                });
            }
        }
    }
}
</script>
