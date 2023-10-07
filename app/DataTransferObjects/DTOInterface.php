<?php

namespace App\DataTransferObjects;

use Illuminate\Http\Request;

interface DTOInterface
{
    /**
     * Create a new DTO instance from an HTTP request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return self
     */
    public static function fromRequest(Request $request): self;

    /**
     * Create a new DTO instance from an array of data.
     *
     * @param  array  $data
     * @return self
     */
    public static function fromArray(array $data): self;

    /**
     * Convert the DTO to an array.
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Get the validation rules for the DTO.
     *
     * @return array
     */
    public static function rules(): array;

    /**
     * Validate the DTO data.
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(): void;
}
