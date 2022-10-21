<?php


namespace Modules\address\Repository;


interface AddressRepositoryInterface
{
    public function all($user_id);

    public function create($request);

    public function delete($user_id,$address_id,$request);

    public function update($user_id,$request);

    public function paginate($user_id);

    public function first($where,$withTrashed=false);
}
