<template>
    <div>
        <v-dialog
            width="630"
            v-model="show_address_dialog"
        >

            <v-card class="address-form" :loading="loading">


                <v-card-title class="headline lighten-2">
                    <h5>{{ title }}</h5>

                    <v-icon @click="show_address_dialog=false">mdi-close</v-icon>

                </v-card-title>

                <v-card-text>

                    <div v-if="step===1">

                        <div style="width: 580px;height: 400px;position: relative">
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
                                        <img :src="$siteUrl+'/modules/address/map_location.svg'"/>
                                    </l-icon>
                                </LMarker>

                            </l-map>

                            <div class="search-field">

                                <v-text-field
                                    outlined
                                    label="جستجوی آدرس"
                                    hide-details
                                    v-model="searchText"
                                    @input="searchAddress()"
                                    clearable
                                    solo
                                    :loading="searchRequest"
                                    @click.clear="closeSearchBox=true"
                                >

                                </v-text-field>

                                <div v-if="areas.length>0 && closeSearchBox===false" class="search-content">
                                    <div v-for="area in areas" style="font-size: 14px;padding: 5px;cursor: pointer"
                                         @click="setLocation(area)">
                                        {{ area.address }}
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div v-else-if="step===2">

                        <div class="row" v-if="server_error">
                            <v-alert type="warning" style="width: 100%">
                                خطا در ارسال اطلاعات،مجددا تلاش نمایید
                            </v-alert>
                        </div>

                        <v-form
                            ref="form"
                            v-model="valid"
                        >
                            <div class="row">
                                <div class="col-6">
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

                                <div class="col-6">
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
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <v-textarea
                                        v-model="address"
                                        outlined
                                        label="آدرس پستی"
                                        :rules="addressRules"
                                    >

                                    </v-textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <v-text-field
                                        outlined
                                        dense
                                        label="کد پستی"
                                        v-model="zip_code"
                                    >

                                    </v-text-field>
                                </div>
                            </div>

                        </v-form>
                    </div>

                    <v-divider></v-divider>
                </v-card-text>

                <v-card-actions>
                    <div>
                        <span>آدرس محل سکونت</span>
                    </div>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="#ef394e"
                        class="address-detail"
                        @click="set_address_detail"
                    >
                        <span v-if="step===1">تایید و افزودن جزییات</span>
                        <span v-else>تایید و ثبت آدرس</span>
                    </v-btn>
                </v-card-actions>

            </v-card>

        </v-dialog>
    </div>
</template>

<script>
import methods from "../methods";
import {LMap, LTileLayer, LMarker, LIcon} from 'vue2-leaflet';
import 'leaflet/dist/leaflet.css';

export default {
    name: "AddressFrom",
    props: ['paginate','userId'],
    components: {
        LMap,
        LTileLayer,
        LMarker,
        LIcon,
    },
    mixins: [methods],
    data() {
        return {
            show_address_dialog: false,
            id: 0,
            user_id:'',
            province_id: '',
            city_id: '',
            address: '',
            zip_code: '',
            province: [],
            city: [],
            title: 'افزودن آدرس جدید',
            btn_text: 'ثبت و ارسال به این آدرس',
            server_error: false,
            get_page: 'no',
            center: [35.34124, 59.22206],
            center2: [35.34124, 59.22206],
            areas: [],
            searchRequest: false,
            newSearchText: '',
            apiKey: "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjM1MmQ2MTcxMDhkZDNjOGU2ZTkxYTM1ZmE2NjZhY2UwMjM5NzFkY2Q1YmNkY2VjYTdhMzU0NTAxNDYwMWIxNWFiYmUyMGU1MzNiODE5ZTMxIn0.eyJhdWQiOiI4NjUzIiwianRpIjoiMzUyZDYxNzEwOGRkM2M4ZTZlOTFhMzVmYTY2NmFjZTAyMzk3MWRjZDViY2RjZWNhN2EzNTQ1MDE0NjAxYjE1YWJiZTIwZTUzM2I4MTllMzEiLCJpYXQiOjE1ODY1MzcxNjQsIm5iZiI6MTU4NjUzNzE2NCwiZXhwIjoxNTg5MTI5MTY0LCJzdWIiOiIiLCJzY29wZXMiOlsiYmFzaWMiXX0.tgNy6CsTIdDQzMtmeHvOO_lyZE934tP5slVyT34RabVrc2BsvivOt6mC9wIkZnGILiBu8oCsgjYhEXFJGbcwVTvIh-dwju0y5KFJV9RoTUwxAiY3YDxU6lNT9o8f0muR1O32zSYETDJHpuG0sYcUkHNo9e7LLXtknylaDfLqLnrEElrR7FzxLznHQcN2xvqKgi6ZUNbiuStrs5gtJLHD0jueaTm300lJESZyZ4g6Tfkaey0cpNYGPDLk5c2hZ6VkmcXFC7EZwBg8FM7mU3G9yCXJHYdhGOvkuwA8Wjqo_6K14SFFgqcXVuVzeN-RtHJTVJhiuf-QxBqLzKpeguuEGw",
            step: 1,
            getAddressDetail: false,
            searchAddressLoading: false,
            searchText: '',
            closeSearchBox: true,
            valid: null,
            province_select: null,
            city_select: null,
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
            loading: false,
            apiCity: '',
        }
    },
    mounted() {
        this.user_id=this.userId;
        this.getProvince();
        this.get_page = this.paginate === 'ok' ? 'ok' : 'no';
    },
    watch: {
        center2: function (newVal, oldVal) {
            this.getAddressDetail = true;
        }
    }
}
</script>

