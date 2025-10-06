<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Str;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    const USERTOKEN = "userToken";

    const USER_BRIAN = 'brian';
    const USER_STEVE = 'steve';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Retrieve all users
     */
    public static function getUsers($exceptUserId=null)
    {
        $builder = self::select(
            array(
                'users.id',
                'users.name',
                'users.email'
            )
        )
            ->orderBy("users.name");

        if (isset($exceptUserId) && $exceptUserId > 0) {
            $builder
                ->where("users.id", "<>", $exceptUserId);
        }

        return $builder->get();
    }

    /**
     * Get a new, unique user_token.
     */
    public static function getNewToken()
    {
        $token = null;
        // Try to get a unique token
        for ($i=0; $i<10; $i++) {
            $token = Str::random(16);
            // Check the token is unique
            $user = User::where('user_token', $token)->first();
            if (!$user) {
                return $token;  // Ok, is unique
            }
        }
        throw new \Exception("Could not generate a unique token for new user");
    }

    /**
     * Check the user_token has been provided and is valid
     *
     * @param $userToken
     */
    public function checkUserToken($userToken)
    {
        if (!isset($userToken)) {
            throw new \Exception('API authentication not provided');
        }
        if ($userToken !== $this->user_token) {
            throw new \Exception('API authentication is invalid');
        }
    }
}
