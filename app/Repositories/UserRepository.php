<?php

namespace App\Repositories;

use App\Models\{Role, User};
use Illuminate\Support\Str;
use App\Contracts\{UserContract, MediaContract};
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserRepository extends BaseRepository implements UserContract
{

    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function storeDetails($attributes)
    {
        DB::beginTransaction();
        try {
            $collection = collect($attributes);
            return $collection;
            // $role = $this->roleModel->where('slug', $collection['userType'])->first();
            $data =  $this->userModel->create([
                'uuid'  => Str::uuid(),
                'firstname' => $collection['firstname'],
                'lastname' => $collection['lastname'],
                'email' => $collection['email'],
                'mobile_number' => $collection['phone_number'],
                'password' => Hash::make($collection['password']),
                'is_active' => 1,
                'registration_ip' => $attributes->ip(),
            ]);
            if ($data) {
                // $data->roles()->attach($role);
                $profile = $data->profile()->updateorCreate([
                    'uuid'         => Str::uuid(),
                    'user_id' => $data->id,
                    'gender'     => $collection['gender'],
                    'address'     => trim($collection['address']),
                    'birthday'     => $collection['birthday'],
                    'country'     => $collection['country'],
                    'state'     => $collection['state'],
                    'city'     => $collection['city'],
                    'pincode'     => $collection['pin_code'],
                    'meta_details'     => $collection->has('meta_details') ? array_filter($collection['meta_details']) : '',
                ]);
                if ($data) {
                    DB::commit();
                    event(new Registered($data));
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            logger($e->getCode() . '->' . $e->getLine() . '->' . $e->getMessage());
        }
    }
}
