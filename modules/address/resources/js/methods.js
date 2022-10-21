export default {
    methods:{
        changeMakerPosition:function () {
            const latlng=this.$refs.myMap.mapObject.getCenter();
            this.center2=[latlng.lat,latlng.lng];
        },
        searchAddress:function () {
            if(!this.searchRequest){
                 const text=this.searchText;
                 if(text.trim().length>=2){
                     this.searchRequest=true;
                     this.newSearchText='';
                     const url ="https://map.ir/search/v2/autocomplete?text="+text+"&x-api-key="+this.apiKey+"&\$select=roads,poi";

                     this.axios.get(url).then(response=>{
                         this.searchRequest=false;
                         if(response.data!==undefined){
                             this.areas=response.data.value;
                             if(this.newSearchText!==''){
                                 this.searchAddress();
                             }
                             else if (this.closeSearchBox!==undefined){
                                 this.closeSearchBox=false;
                             }
                         }
                     }).catch(error=>{
                         this.searchRequest=false;
                     });

                 }
            }
            else {
                this.newSearchText=this.searchText;
            }
        },
        set_address_detail:function () {
            if(this.step===1){
                this.step=2;
                if(this.getAddressDetail){
                    this.getAddressDetail=false;
                    this.getAddress();
                }
            }
            else{
                this.add_address();
            }
        },
        validateMobileNumber:function () {
            if(this.mobile.toString().trim()==="")
            {
                return 'لطفا شماره موبایل خود را وارد نمایید';
            }
            else if(this.check_mobile_number())
            {
                return  'شماره موبایل وارد شده معتبر نمی باشد';
            }
            else{
                return  true;
            }
        },
        check_mobile_number() {
            if (isNaN(this.mobile)) {
                return true;
            } else {
                if (this.mobile.toString().trim().length == 11) {
                    if (this.mobile.toString().charAt(0) == '0' && this.mobile.toString().charAt(1) == '9') {
                        return false;
                    } else {
                        return true;
                    }
                } else if (this.mobile.toString().trim().length == 10) {
                    if (this.mobile.toString().charAt(0) == '9') {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }
            }
        },
        getProvince(){
            this.city_select=null;
            this.city_id=null;
            this.axios.get(this.$siteUrl+'/api/app/provinces').then(response=>{
                this.province=response.data.original;
            });
        },
        setLocation:function (area) {
            const latLng=area.geom.coordinates;
            this.center=[latLng[1],latLng[0]];
            this.center2=[latLng[1],latLng[0]];
            this.closeSearchBox=true;
        },
        setLocation2:function (area) {
            const latLng=area.geom.coordinates;
            this.center=[latLng[1],latLng[0]];
            this.center2=[latLng[1],latLng[0]];
            this.searchBox=false;
            const self=this;
            this.step=1;
            this.$nextTick(function () {
                setTimeout(function () {
                    self.show_address_dialog=true;
                },100);
            });
        },
        getCity:function (province,province_id) {
            this.province_id=province_id===undefined ? province['id'] : province_id;
            this.city=[];
            this.axios.get(this.$siteUrl+'/api/app/city/'+this.province_id).then(response=>{
                this.city=response.data.original;
                if(this.city_id>0){
                    for (let i = 0; i <this.city.length ; i++) {
                        if(this.city[i].id===this.city_id){
                            this.city_select=this.city[i]['name'];
                        }
                    }
                }
                else if(this.apiCity!==''){
                    for (let i = 0; i <this.city.length ; i++) {
                        if(this.city[i].name===this.apiCity){
                            this.city_select=this.city[i]['name'];
                            this.city_id=this.city[i]['id'];
                            this.apiCity='';
                        }
                    }
                }
            });
        },
        set_city_id:function (city) {
            if(city['id']!==undefined){
                this.city_id=city['id'];
            }
        },
        validateZipCode:function () {
            if(this.zip_code.toString().trim().length<10 || isNaN(this.zip_code) || this.zip_code.toString().trim().length>10)
            {
                return 'کد پستی معتبر نمی باشد';
            }
            else{
                return  true;
            }
        },
        add_address:function () {
            this.$refs.form.validate();
            if(this.valid){
                this.loading=true;
                const lat=this.center2[0];
                const lng=this.center2[1];
                const formData=new FormData();
                formData.append('id',this.id);
                formData.append('user_id',this.user_id);
                formData.append('address',this.address);
                formData.append('zip_code',this.zip_code);
                formData.append('city_id',this.city_id);
                formData.append('province_id',this.province_id);
                formData.append('lat',lat);
                formData.append('lng',lng);
                formData.append('paginate',this.get_page);
                let url=this.$siteUrl+'/user/addAddress';
                if (this.id!==''){
                     url=this.$siteUrl+'/user/updateAddress/'+this.user_id;
                }
                this.server_error=false;
                this.axios.post(url,formData).then(response=>{
                    this.loading=false;
                    if(response.data!=="error")
                    {
                        this.$emit('setData',response.data);
                        this.show_address_dialog=false;
                    }
                    else {
                        this.server_error=true;
                    }
                }).catch(error=>{
                    this.loading=false;
                    this.server_error=true;
                });
            }
        },
        get_my_location:function () {
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(this.set_my_location);
            }
        },
        set_my_location:function (position) {
            let lat=position.coords.latitude;
            let lng=position.coords.longitude;
            this.center=[lat,lng];
            this.center2=[lat,lng];
        },
        updateRow: function (address) {
            this.$refs.data.setUpdateData(address, 'ویرایش آدرس');
        },
        remove_address: function (address) {
            this.remove_address_id = address.id;
            this.show_dialog_box = true;
        },
        delete_address: function (paginate) {
            const string = paginate === undefined ? '' : "?paginate=ok";
            this.loading=true;
            this.show_dialog_box = false;
            const url = this.$siteUrl + "/user/removeAddress/"+ this.user_id +'/'+ this.remove_address_id + string;
            this.axios.delete(url).then(response => {
                this.loading=false;
                if (response.data !== "error") {
                    this.AddressList = response.data;
                }
                if (this.$siteUrl+'/shipping'===window.location.href){
                    this.$root.$emit('send_get_request',window.location.href);
                }
            }).catch(error => {
                this.loading=false;
            });
        },
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
        showModalBox: function () {
            this.$refs.data.setTitle('افزودن آدرس جدید');
        },
        setUpdateData:function (address,title) {
            this.btn_text='ویرایش';
            this.id=address.id;
            this.name=address.name;
            this.mobile=address.mobile;
            this.city_id=address.city_id;
            this.province_id=address.province_id;
            this.address=address.address;
            this.zip_code=address.zip_code;
            this.user_id=address.user_id;
            this.title=title;
            const self=this;
            if(this.province_id>0){
                for (let i = 0; i <this.province.length ; i++) {
                    if(this.province[i]['id']===this.province_id){
                        this.province_select=this.province[i]['name'];
                    }
                }
                this.getCity(undefined, this.province_id);
            }
            this.step=1;
            this.center=[address.lat,address.lng];
            this.center2=[address.lat,address.lng];
            this.show_address_dialog=true;
            this.$nextTick(function () {
                setTimeout(function () {
                    if(self.$refs.myMap!==undefined){
                        self.$refs.myMap.mapObject.invalidateSize();
                    }
                },100);
            });
        },
        setTitle:function (title) {
            this.title=title;
            this.id='';
            this.city_id='';
            this.province_id='';
            this.address='';
            this.zip_code='';
            this.btn_text='ثبت و ارسال به این آدرس';
            this.show_address_dialog=true;
            this.province_select=null;
            this.city_select=null;
            this.step=1;
            const self=this;
            this.$nextTick(function () {
                setTimeout(function () {
                    if(self.$refs.myMap!==undefined){
                        self.$refs.myMap.mapObject.invalidateSize();
                    }
                    self.get_my_location();
                },100);
            });
        },
        showForm:function () {
            this.searchBox=false;
            const self=this;
            this.$nextTick(function () {
               setTimeout(function () {
                   self.show_address_dialog=true;
               },100);
            });
        },
        getAddress:function (){
            const lat=this.center2[0];
            const lon=this.center2[1];
            var url ="https://map.ir/fast-reverse?lat="+lat+"&lon="+lon+"&x-api-key="+this.apiKey;
            this.axios.get(url).then(response=>{
                if(response.data!==undefined){
                    this.address=response.data.address_compact;
                    if(response.data.province!==''){
                        for (let i = 0; i <this.province.length ; i++) {
                            if(this.province[i]['name']===response.data.province){
                                this.province_select=this.province[i]['name'];
                                this.province_id=this.province[i]['id'];
                                this.apiCity=response.data.city;
                                this.getCity(undefined, this.province_id);
                            }
                        }
                    }
                }
            });
        }
    }
}
