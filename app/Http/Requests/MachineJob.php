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

class MachineJob extends FormRequest
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
            'job_id' => 'sometimes|required|string|size:16',
            'name' => 'sometimes|required|min:2',
            'machine' => 'exists:machines,id',
            'duration' => 'integer|min:0',
            'status' => 'sometimes|in:success,failed,in_progress',
            'type' => 'sometimes|in:laser,3dprinter,router',
            'details' => 'sometimes|json'
        ];
    }
}
