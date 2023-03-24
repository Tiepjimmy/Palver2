<?php

namespace App\Modules\User\Models;

use Common\Models\AbstractModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Class User
 * @package App\Modules\User\Models
 * @property TenancyContract $tenancyContract
 * @property integer $tenancy_contract_id
 * @property string $username
 */
class User extends AbstractModel
{


    public $table = 't_users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'tenancy_contract_id',
        'username'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tenancy_contract_id' => 'integer',
        'username' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'tenancy_contract_id' => 'nullable|integer',
        'username' => 'nullable|string|max:255'
    ];

    /**
     * @return BelongsTo
     **/
    public function tenancyContract()
    {
        return $this->belongsTo(TenancyContract::class, 'tenancy_contract_id');
    }
}
