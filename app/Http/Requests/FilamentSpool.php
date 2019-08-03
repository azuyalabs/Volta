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

use Illuminate\Foundation\Http\FormRequest;

class FilamentSpool extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'         => 'required|max:128',
            'manufacturer' => 'exists:manufacturers,id',
            'material'     => 'in:pla,abs,pet',
            'weight'       => 'required|numeric|min:1',
            'diameter'     => 'required|numeric|min:1|max:5',
            'density'      => 'required|numeric|min:1|max:5',
            'color'        => 'required|string'
        ];
    }
}
