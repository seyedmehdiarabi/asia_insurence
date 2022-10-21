<template>
    <div class="c-field">
        <v-row>
            <v-col class="col-md-6">
                <div class="c-combobox">
                    <v-combobox
                        v-model="select1"
                        :items="provinces"
                        label="استان"
                        outlined
                        item-text="title"
                        item-value="title"
                        return-object
                        @input="change"
                        item-color="white"
                        :rules="provinceRules"
                    ></v-combobox>
                    <input type="hidden" name="province_id" :value="province"/>
                </div>
                <div v-if="show_region==='true'">
                    <v-combobox
                        v-model="select3"
                        :items="regions"
                        label="شهر/منطقه"
                        outlined
                        item-text="title"
                        item-value="title"
                        return-object
                        @input="change3"
                        item-color="white"
                        :rules="regionRules"
                    ></v-combobox>
                    <input type="hidden" name="region_id" :value="region"/>
                </div>
            </v-col>
            <v-col class="col-md-6">
                <div class="c-combobox">
                    <v-combobox
                        v-model="select2"
                        :items="cites"
                        label="شهرستان"
                        outlined
                        item-text="title"
                        item-value="title"
                        return-object
                        @input="change2"
                        item-color="white"
                        :rules="cityRules"
                    ></v-combobox>
                    <input type="hidden" name="city_id" :value="city"/>
                </div>
                <div v-if="show_zone ==='true'">
                    <v-combobox
                        v-model="select4"
                        :items="zones"
                        label="بخش/روستا"
                        outlined
                        item-text="title"
                        item-value="title"
                        return-object
                        @input="change4"
                        item-color="white"
                        :rules="zoneRules"
                    ></v-combobox>
                    <input type="hidden" name="zone_id" :value="zone"/>
                </div>
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    name: "RegisterLocation",
    props: ['province_id', 'city_id', 'region_id', 'zone_id', 'show_region', 'show_zone'],
    data() {
        return {
            provinces: [],
            province: '',
            provinceRules: [
                v => !!v || 'استان نمیتواند خالی باشد'
            ],
            cites: [],
            city: '',
            cityRules: [
                v => !!v || 'شهرستان نمیتواند خالی باشد'
            ],
            regions: [],
            region: '',
            regionRules: [
                v => !!v || 'شهر/منطقه نمیتواند خالی باشد'
            ],
            zones: [],
            zone: '',
            zoneRules: [v => !!v || 'بخش/روستا نمیتواند خالی باشد'],
            select1: '',
            select2: '',
            select3: '',
            select4: '',
        }
    },
    mounted() {
        this.getProvinceList();
    },
    methods: {
        getProvinceList: function () {
            const url = this.$siteUrl + '/api/app/provinces';
            this.axios.get(url).then(response => {
                for (let i = 0; i < response.data.original.length; i++) {
                    const p = response.data.original[i];
                    this.provinces.push({'title': p.name, 'id': p.id});
                    if (this.province_id != undefined && p.id == this.province_id) {
                        this.select1 = {'title': p.name, 'id': p.id};
                        this.province = this.province_id;
                        this.getCityList();
                    }
                }
            });
        },
        getCityList: function () {
            const url = this.$siteUrl + '/api/get_city/' + this.province;
            this.axios.get(url).then(response => {
                this.city = '';
                this.select2 = null;
                this.cites = [];
                for (let i = 0; i < response.data.original.length; i++) {
                    const c = response.data.original[i];
                    this.cites.push({'title': c.name, 'id': c.id});
                    if (this.city_id != undefined && c.id == this.city_id) {
                        this.select2 = {'title': c.name, 'id': c.id};
                        this.city = this.city_id;
                        this.getRegionList();
                    }
                }
            });
        },
        getRegionList: function () {
            const url = this.$siteUrl + '/api/get_region/' + this.city;
            this.axios.get(url).then(response => {
                this.select3 = null;
                this.region = '';
                this.regions = [];
                for (let i = 0; i < response.data.original.length; i++) {
                    const c = response.data.original[i];
                    this.regions.push({'title': c.name, 'id': c.id});
                    if (this.region_id != undefined && c.id == this.region_id) {
                        this.select3 = {'title': c.name, 'id': c.id};
                        this.region = this.region_id;

                        this.getZoneList();
                    }
                }
            });
        },
        getZoneList: function () {
            const url = this.$siteUrl + '/api/get_zone/' + this.region;
            this.axios.get(url).then(response => {
                this.select4 = null;
                this.zone = '';
                this.zones = [];
                for (let i = 0; i < response.data.original.length; i++) {
                    const c = response.data.original[i];
                    this.zones.push({'title': c.name, 'id': c.id});
                    if (this.zone_id != undefined && c.id == this.zone_id) {
                        this.select4 = {'title': c.name, 'id': c.id};
                        this.zone = this.zone_id;
                    }
                }
            });
        },

        change: function (value) {
            this.province = value['id'];
            this.getCityList();
        },
        change2: function (value) {
            this.city = value['id'];
            this.getRegionList();
        },
        change3: function (value) {
            this.region = value['id'];
            this.getZoneList();
        },
        change4: function (value) {
            this.zone = value['id'];
        },
    }
}
</script>
