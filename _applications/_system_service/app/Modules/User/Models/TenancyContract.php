<?php

namespace App\Modules\User\Models;

use Common\Models\AbstractModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TenancyContract
 * @package App\Modules\User\Models
 *
 * @property Collection $users
 * @property string $login_endpoint
 * @property string $logout_endpoint
 * @property string $callback_endpoint
 * @property string $user_info_endpoint
 * @property string $public_key
 * @property string $private_key
 * @property string $db_username
 * @property string $db_password
 * @property string $db_host
 */
class TenancyContract extends AbstractModel
{

    public $table = 't_tenancy_contracts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $fillable = [
        'login_endpoint',
        'logout_endpoint',
        'callback_endpoint',
        'user_info_endpoint',
        'private_key',
        'public_key',
        'db_username',
        'db_password',
        'db_host'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'login_endpoint' => 'string',
        'logout_endpoint' => 'string',
        'callback_endpoint' => 'string',
        'user_info_endpoint' => 'string',
        'private_key' => 'string',
        'public_key' => 'string',
        'db_username' => 'string',
        'db_password' => 'string',
        'db_host' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'login_endpoint' => 'nullable|string|max:512',
        'logout_endpoint' => 'nullable|string|max:512',
        'callback_endpoint' => 'nullable|string|max:512',
        'user_info_endpoint' => 'nullable|string|max:512',
        'private_key' => 'nullable|string|max:4068',
        'public_key' => 'nullable|string|max:4068',
        'db_username' => 'nullable|string|max:255',
        'db_password' => 'nullable|string|max:255',
        'db_host' => 'nullable|string|max:128'
    ];

    /**
     * @return HasMany
     **/
    public function users()
    {
        return $this->hasMany(User::class, 'tenancy_contract_id');
    }
}
