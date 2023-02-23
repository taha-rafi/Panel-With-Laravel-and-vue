<?php

namespace App\SuperAdmin\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use App\Classes\Output;

class FrontCoreRequest extends FormRequest
{
    protected $user;

    /**
     * CoreRequest constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function formatErrors(\Illuminate\Contracts\Validation\Validator  $validator)
    {
        return Output::formErrors($validator);
    }
}
