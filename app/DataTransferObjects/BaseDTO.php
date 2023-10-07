<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

abstract class BaseDTO implements DTOInterface
{
    /**
     * Validate the DTO data.
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(): void
    {
        Validator::validate($this->toArray(), static::rules());
    }

    /**
     * Convert the DTO to an array, excluding specified keys.
     *
     * @param array $except
     * @return array
     */
    public function toArrayExcept(array $except = []): array
    {
        return Arr::except($this->toArray(), $except);
    }

    /**
     * Convert the DTO to an array, filtering out null and empty values.
     *
     * @return array
     */
    public function toFilteredArray(): array
    {
        return array_filter($this->toArray());
    }

    /**
     * Convert the DTO to an array, filtering out null and empty values, excluding specified keys.
     *
     * @param array $except
     * @return array
     */
    public function toFilteredArrayExcept(array $except = []): array
    {
        return Arr::except(array_filter($this->toArray()), $except);
    }

    /**
     * Get the DTO data as an array.
     *
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * Get the validation rules for the DTO.
     *
     * @return array
     */
    abstract public static function rules(): array;
}
