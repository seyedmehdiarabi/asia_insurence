<?php


namespace Modules\address\Repository;

use DB;
use Auth;
use Modules\address\Models\Address;
use Modules\users\Models\User;

class EloquentAddressRepository  implements AddressRepositoryInterface
{

    public function all($user_id)
    {
        $address=Address::with(['getProvince','getCity'])->where('user_id',$user_id)
            ->orderBy('id','DESC')->get();
        return $address;
    }

    public function create($request)
    {
        $user=User::findOrFail($request->get('user_id'));
        $address=new Address($request->all());
        $address['user_id']=$user->id;
        $address['name']=$user->name;
        $address['mobile']=$user->mobile;

        if($address->save())
        {
            if($request->get('paginate')=='ok'){
                $addressList=$this->paginate($user->id);
            }
            else{
                $addressList=$this->all($user->id);
            }
            return $addressList;
        }
        else{
            return 'error';
        }
    }

    public function paginate($user_id){
        $address=Address::with(['getProvince','getCity'])->where('user_id',$user_id)
            ->orderBy('id','DESC')->paginate(10);
        return $address;
    }

    public function delete($user_id,$address_id,$request)
    {
        $delete=Address::where(['user_id'=>$user_id,'id'=>$address_id])->forceDelete();
        if($delete)
        {
            if($request->get('paginate')=='ok'){
                $AddressList=$this->paginate($user_id);
            }
            else{
                $AddressList=$this->all($user_id);
            }
            return $AddressList;
        }
        else{
            return 'error';
        }
    }

    public function update($user_id,$request)
    {
        $id=$request->get('id',0);
        $address=Address::where(['id'=>$id,'user_id'=>$user_id])->first();

        if($address)
        {
            $data = $request->all();
            foreach ($data as $key=>$value){
                if ($value=='null'){
                    unset($data[$key]);
                }
            }
            $address->update($data);
            if($request->get('paginate')=='ok'){
                $addressList=$this->paginate($user_id);
            }
            else{
                $addressList=$this->all($user_id);
            }
            return $addressList;
        }
        else{
            return 'error';
        }
    }

    public function first($where,$withTrashed=false)
    {
        $address=Address::where($where);
        if($withTrashed){
            $address=$address->withTrashed();
        }
        $address=$address->first();
        return $address;
    }
}
