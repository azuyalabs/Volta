<?php
/**
 * This file is part of the Volta Project.
 *
 * Copyright (c) 2018 - 2019. AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

namespace App\Http\Requests;

use App\Repositories\CountryRepository;
use Illuminate\Foundation\Http\FormRequest;

class ManufacturerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'    => 'required|min:2',
            'website' => 'sometimes|nullable|url',
            'country' => [static function ($attribute, $value, $fail) {
                if (!array_key_exists($value, app(CountryRepository::class)->all())) {
                    $fail($attribute);
                }
            }],
            'equipment_supplier' => 'boolean',
            'filament_supplier'  => 'boolean',
            'system'             => 'boolean',
        ];
    }
}
