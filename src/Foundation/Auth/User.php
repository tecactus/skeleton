<?php

namespace Tecactus\Skeleton\Foundation\Auth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Tecactus\Skeleton\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Tecactus\Skeleton\Auth\Activation\CanActivateAccount;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Tecactus\Skeleton\Contracts\CanActivateAccount as CanActivateAccountContract;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    CanActivateAccountContract
{
    use Authenticatable, Authorizable, CanResetPassword, CanActivateAccount;
}
