<template>
    <div>
        <div v-if="has_changes_cart" class="alert alert-warning changes_cart">
            <span>توجه : قیمت یا موجودی بعضی از کالاهای سبد خرید شما تغییر کرده است</span>
            <a :href="$siteUrl+'/Cart'">مشاهده سبد خرید</a>
        </div>

        <button v-if="AddressLists.length==0" type="button" class="add_address_btn" v-on:click="show_address_box()" >
            <strong>ایجاد آدرس جدید</strong>
        </button>

        <div v-if="AddressLists.length>0" class="address_list">
            <div class="product_item_box default_address">
                <h6>تحویل گیرنده : {{ AddressLists[0]['name']}}</h6>
                <div class="address_content">
                    <div>آدرس : {{ AddressLists[0]['get_province']['name']}} {{ AddressLists[0]['get_city']['name']}} {{ AddressLists[0]['address']}} </div>
                    <ul>
                        <li>
                            کد پستی :‌
                            <span>{{ replaceNumber(AddressLists[0]['zip_code']) }}</span>
                        </li>
                        <li>
                            شماره همراه :‌
                            <span>{{ replaceNumber(AddressLists[0]['mobile']) }}</span>
                        </li>
                    </ul>

                    <a class="show_other_item" v-on:click="show_more_address()">
                        <span>تغییر آدرس ارسال</span>
                        <span class="fa fa-angle-left"></span>
                    </a>
                </div>
            </div>
        </div>

        <mobile-address-form  @setData="updateAddressList" @hideBox="hide_address_list_box()" ref="data"></mobile-address-form>

        <div class="mobile_data_box" v-if="show_address_list">
            <div class="header">
                <span>انتخاب آدرس</span>
                <a>
                    <span>بازگشت</span>
                    <span class="fa fa-angle-left"></span>
                </a>
            </div>

            <div class="content" >
                <button  type="button" class="add_address_btn" v-on:click="show_address_box()" >
                    <strong>ایجاد آدرس جدید</strong>
                </button>

                <div v-for="(address,key) in AddressLists">
                    <div class="product_item_box default_address">
                        <div class="address_item_header">
                            <h6>تحویل گیرنده : {{ address['name']}}</h6>
                            <div>
                                <span class="fa fa-edit" v-on:click="updateRow(address)"></span>
                                <span class="fa fa-trash-o"  v-on:click="remove_address(address)"></span>
                            </div>
                        </div>
                        <div class="address_content">
                            <div>آدرس : {{ address['get_province']['name']}} {{ address['get_city']['name']}} {{ address['address']}} </div>
                            <ul>
                                <li>
                                    کد پستی :‌
                                    <span>{{ replaceNumber(address['zip_code']) }}</span>
                                </li>
                                <li>
                                    شماره همراه :‌
                                    <span>{{ replaceNumber(address['mobile']) }}</span>
                                </li>
                            </ul>

                            <a>
                                <span v-if="key==0" class="select_address_tag">سفارش به این آدرس ارسال می شود</span>
                                <span v-else class="select_address_tag" style="color: black" v-on:click="change_default_address(key)">ارسال سفارش به این آدرس</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="message_div" v-if="show_dialog_box">
            <div class="message_box">
                <p id="msg">آیا مطمئنید که این آدرس حذف شود؟</p>
                <a class="alert alert-success" v-on:click="delete_address">بله</a>
                <a class="alert alert-danger" v-on:click="show_dialog_box=false">خیر</a>
            </div>

        </div>

    </div>
</template>

<script>
    import MobileAddressForm from './MobileAddressForm';
    import myMixin from "../../../../../resources/js/myMixin";
    export default {
        name: "AddressList",
        components:{MobileAddressForm},
        mixins:[myMixin],
        props:['data'],
        data(){
            return {
                AddressLists:[],
                show_address_list:false,
                show_default:true,
                city_id:0,
                show_dialog_box:false,
                remove_address_id:'',
                has_changes_cart:false
            }
        },
        mounted() {
            this.AddressLists=this.data;
            if(this.AddressLists.length>0)
            {
                this.city_id=this.AddressLists[0].city_id;
                document.getElementById('address_id').value=this.AddressLists[0].id;
            }
        },
        methods:{
            show_more_address:function () {
                this.show_address_list=true;
                this.show_mobile_box();
            },
            change_default_address:function (key) {
                let old_array=this.AddressLists;
                const first=old_array[0];
                const select=old_array[key];

                this.city_id=select.city_id;

                this.$set(this.AddressLists,0,select);
                this.$set(this.AddressLists,key,first);
                this.show_default=true;
                document.getElementById('address_id').value=select.id;
                this.$nextTick(function () {
                    $('body').css('overflow-y','auto');
                    const width=$(window).width();
                    const right="-"+width+"px";
                    setTimeout(function () {
                        $('.mobile_data_box').css({'right':right});
                    },50);
                });
            },
            updateAddressList:function (data,key) {
                this.AddressLists=data;
                if(key!=undefined && key>0){

                }
                if(this.AddressLists.length==1){
                    this.city_id=this.AddressLists[0].city_id;
                    this.show_default=true;
                    document.getElementById('address_id').value=this.AddressLists[0].id;
                }
                $('body').css('overflow-y','auto');
            },
            show_address_box:function(){
                this.$refs.data.setTitle('افزودن آدرس جدید');
            },
            hide_address_list_box:function()
            {
                this.show_address_list=false;
            },
            ChangeCartStatus:function () {
                this.has_changes_cart=true;
            }
        }
    }
</script>

<style scoped>

</style>
