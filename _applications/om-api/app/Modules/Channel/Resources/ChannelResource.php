<?php

namespace App\Modules\Channel\Resources;

use Common\Models\AbstractModel;
use Common\Http\Resources\AbstractResource;
use Symfony\Component\Translation\Exception\InvalidResourceException;

/**
 * Class ExampleResource
 * @package App\Modules\Example\Resources
 */
class ChannelResource extends AbstractResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        if (!$this->resource instanceof AbstractModel) {
            throw new InvalidResourceException();
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code'=> $this->code,
            'is_active' => $this->is_active
        ];
    }
}
