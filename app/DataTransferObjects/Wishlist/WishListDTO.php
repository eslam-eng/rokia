<?php

namespace App\DataTransferObjects\Wishlist;

use App\DataTransferObjects\BaseDTO;
use Illuminate\Support\Arr;

class WishListDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public int  $user_id,
        public int  $relatable_id,
        public string     $relatable_type,
    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            user_id: $request->user_id,
            relatable_id: $request->relatable_id,
            relatable_type: $request->relatable_type,
        );
    }

    /**
     * @param array $data
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            user_id: Arr::get($data, 'user_id'),
            relatable_id: Arr::get($data, 'relatable_id'),
            relatable_type: Arr::get($data, 'relatable_type'),
        );
    }

    public static function rules(): array
    {
        return [
            'user_id' => 'required|integer',
            'relatable_id' => 'required|integer',
            'relatable_type' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "user_id" => $this->user_id,
            "relatable_id" => $this->relatable_id,
            "relatable_type" => $this->relatable_type,
        ];
    }
}
