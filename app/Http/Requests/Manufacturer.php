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

class Manufacturer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:4',
            'website' => 'sometimes|nullable|url',
            'country' => [function ($attribute, $value, $fail) {
                if (!\in_array($value, \array_keys(app(CountryRepository::class)->all()))) {
                    $fail($attribute);
                }
            }],
            'equipment_supplier' => 'boolean',
            'filament_supplier' => 'boolean',
        ];
    }
}
