<template>
    <div>
         <v-navigation-drawer
            width="100%"
            right
            v-model="show_address_dialog"
            fixed
        >

            <v-app-bar
                fixed
                elevation="0"
            >

                <div style="padding-left: 10px">
                    <v-icon @click="show_address_dialog=false">mdi-arrow-right</v-icon>
                </div>

                <v-toolbar-title>
                    <span v-if="id===0">ثبت آدرس</span>
                    <span v-else>ویرایش آدرس</span>
                </v-toolbar-title>

                <v-spacer></v-spacer>

                <v-icon @click="searchBox=true">mdi-magnify</v-icon>

            </v-app-bar>

            <div style="padding-top: 50px"></div>

            <div>

                <div class="row" v-if="step===1" style="margin: 0px">

                    <div style="width: 100%;height:100%;position: fixed">

                        <l-map
                            :center="center"
                            :zoom="16"
                            ref="myMap"
                            @dragend="changeMakerPosition()"
                            @drag="changeMakerPosition()"
                        >

                            <LTileLayer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"></LTileLayer>

                            <LMarker :lat-lng="center2">
                                <l-icon>
                                    <img :src="$siteUrl+'/modules/address/map_location.svg'" />
                                </l-icon>
                            </LMarker>

                        </l-map>

                        <div>
                            <v-btn
                                class="set-detail"
                                @click="set_address_detail"
                            >
                                <span>تایید و افزودن جزییات</span>
                            </v-btn>
                        </div>
                    </div>

                </div>

                <div v-else-if="step===2">

                    <v-card :loading="loading" :disabled="loading">

                        <div class="row" v-if="server_error">
                            <v-alert type="warning" style="width: 100%">
                                خطا در ارسال اطلاعات،مجددا تلاش نمایید
                            </v-alert>
                        </div>

                        <v-form
                            ref="form"
                            v-model="valid"
                            style="padding:10px"
                        >

                            <div style="padding-top: 10px">
                                <v-text-field
                                    outlined
                                    label="نام و نام خانوادگی تحویل گیرنده"
                                    v-model="name"
                                    dense
                                    :rules="nameRules"
                                ></v-text-field>
                            </div>

                            <div>
                                <v-text-field
                                    outlined
                                    label="شماره موبایل"
                                    v-model="mobile"
                                    dense
                                    :rules="[mobileRules.required,validateMobileNumber]"
                                ></v-text-field>
                            </div>

                            <div>
                                <v-combobox
                                    label="استان"
                                    outlined
                                    dense
                                    return-object
                                    v-model="province_select"
                                    :items="province"
                                    item-text="name"
                                    item-value="name"
                                    @change="getCity"
                                    :rules="provinceRules"
                                >

                                </v-combobox>
                            </div>

                            <div>

                                <v-combobox
                                    label="شهر"
                                    outlined
                                    dense
                                    return-object
                                    v-model="city_select"
                                    :items="city"
                                    item-text="name"
                                    item-value="name"
                                    @change="set_city_id"
                                    :rules="cityRules"
                                >

                                </v-combobox>
                            </div>

                            <div>
                                <v-textarea
                                    v-model="address"
                                    outlined
                                    label="آدرس پستی"
                                    :rules="addressRules"
                                >

                                </v-textarea>
                            </div>

                            <div>
                                <v-text-field
                                    outlined
                                    dense
                                    label="کد پستی"
                                    v-model="zip_code"
                                    :rules="[zipCodeRules.required,validateZipCode]"
                                >

                                </v-text-field>
                            </div>

                            <div>
                                <v-btn
                                    color="#ef394e"
                                    class="address-detail"
                                    style="width: 100%"
                                    @click="set_address_detail"
                                >
                                    تایید و ثبت آدرس
                                </v-btn>
                            </div>

                        </v-form>

                    </v-card>

                </div>

            </div>

        </v-navigation-drawer>

        <v-navigation-drawer
            width="100%"
            right
            v-model="searchBox"
            fixed
        >

            <v-app-bar
                fixed
                elevation="0"
                class="mobile-theme-search-address"
            >
                <v-text-field
                   hide-details
                   v-model="searchText"
                   placeholder="جستجوی آدرس"
                   :loading="searchRequest"
                   solo
                   @input="searchAddress"
                   prepend-inner-icon="mdi-arrow-right"
                   @click:prepend-inner="showForm()"
                ></v-text-field>

            </v-app-bar>

            <div style="padding-top: 50px"></div>

            <div v-if="areas.length>0 && closeSearchBox===false" class="search-content">
                <div v-for="area in areas" style="font-size: 14px;padding: 5px;cursor: pointer" @click="setLocation2(area)">
                    {{ area.address }}
                </div>
            </div>

        </v-navigation-drawer>
    </div>
</template>

<script>
    import methods from "../methods";
    import { LMap, LTileLayer, LMarker,LIcon } from 'vue2-leaflet';
    import 'leaflet/dist/leaflet.css';
    export default {
        name: "AddressFrom",
        data(){
            return{
                id:0,
                name:'',
                mobile:'',
                province_id:'',
                city_id:'',
                address:'',
                zip_code:'',
                show_box:false,
                province:[],
                city:[],
                title:'افزودن آدرس جدید',
                btn_text:'ثبت و ارسال به این آدرس',
                server_error:false,
                get_page:'no',
                center: [38.0718603, 46.2842501],
                center2: [38.0718603, 46.2842501],
                areas:[],
                searchText:'',
                searchRequest:false,
                newSearchText:'',
                apiKey:"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjE0MzIzZTE3Mzc3NTMyNTY3NzNlMTdhZTNhNTkxYmRlM2I3M2EzMWQ5NGU5NTJiNTgxODQ2YTI4YThiM2YwY2Q5NTY2ZTg0MDYwMjliZGRiIn0.eyJhdWQiOiI5MzkxIiwianRpIjoiMTQzMjNlMTczNzc1MzI1Njc3M2UxN2FlM2E1OTFiZGUzYjczYTMxZDk0ZTk1MmI1ODE4NDZhMjhhOGIzZjBjZDk1NjZlODQwNjAyOWJkZGIiLCJpYXQiOjE1OTA0ODA0NDksIm5iZiI6MTU5MDQ4MDQ0OSwiZXhwIjoxNTkzMDcyNDQ5LCJzdWIiOiIiLCJzY29wZXMiOlsiYmFzaWMiXX0.HMVuhLq9VEZjUwnA3P3B8u4otW_KrndIDW-teSGyDLj-NQ4x1JmynkMYIYmGXvVirh-tZ5G67xVhgj_dCmKp0Xm5dbQRnpBp-EKNCZkbSvADwjzkhxiao68_lrEZ3-M8Et4rjO0A_mVLnE_Owyc8ZqPjdrhZlr-2DdM9P_n9mjp7YxgUr2EU16G7Ibn9KizIDX7U_mhvgy1pJTk4sRokW5r9DNM5K9nO1V3S8vTpXEntY0zqFBDisDCdwRo2QJYgpOEL8ehmcVeYPKxd5Tg8FUB8ShkS0qQQgOGBqhlAbp6ae_5JU9q8uU-BCnphhh5fj9bihfe6C1ZEPlrxOf3COg",
                step:1,
                getAddressDetail:false,
                searchBox:false,
                show_address_dialog:false,
                valid:null,
                nameRules: [
                    v => !!v || 'نام و نام خانوادگی نمی تواند خالی باشد',
                    v => (v && v.length > 6) || 'نام و نام خانوادگی حداقل باید شامل ۶ کاراکتر باشد',
                ],
                mobileRules: {
                    required:v => !!v || 'لطفا شماره موبایل خود را وارد نمایید',
                },
                province_select:null,
                city_select:null,
                provinceRules: [
                    v => !!v || 'لطفا استان را انتخاب نمایید',
                ],
                cityRules: [
                    v => !!v || 'لطفا شهر را انتخاب نمایید',
                ],
                addressRules: [
                    v => !!v || 'آدرس نمی تواند خالی باشد',
                    v => (v && v.length > 10) || 'آدرس وارد شده کوتاه است',
                ],
                zipCodeRules: {
                    required: v => !!v || 'کد پستی نمی تواند خالی باشد',
                },
                loading:false
            }
        },
        mixins:[methods],
        props:['paginate'],
        components: {
            LMap,
            LTileLayer,
            LMarker,
            LIcon
        },
        mounted() {
            this.getProvince();
            this.get_page=this.paginate=='ok' ? 'ok' : 'no';
        },
        watch:{
            center2:function (newVal,oldVal){
                this.getAddressDetail=true;
            }
        }
    }
</script>

<style scoped>

</style>
