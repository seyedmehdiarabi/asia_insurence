<?php


namespace Modules\address\Http\Controllers;

use Illuminate\Http\Request;
use Modules\address\Repository\AddressRepositoryInterface;
use Auth;
use Modules\users\Models\User;

class AddressController
{
   public function create(Request $request,AddressRepositoryInterface $repository){
       return $repository->create($request);
   }

   public function destroy($user_id,$address_id,Request $request,AddressRepositoryInterface $repository){
       return $repository->delete($user_id,$address_id,$request);
   }

   public function update($user_id,Request $request,AddressRepositoryInterface $repository){
       return $repository->update($user_id,$request);
   }

   public function getAddress($id,AddressRepositoryInterface $repository){
       $user=User::findOrFail($id);
       return $repository->paginate($user->id);
   }
}
