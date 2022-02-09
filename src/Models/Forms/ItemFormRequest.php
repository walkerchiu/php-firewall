<?php

namespace WalkerChiu\Firewall\Models\Forms;

use Illuminate\Support\Facades\Request;
use WalkerChiu\Core\Models\Forms\FormRequest;

class ItemFormRequest extends FormRequest
{
    /**
     * @Override Illuminate\Foundation\Http\FormRequest::getValidatorInstance
     */
    protected function getValidatorInstance()
    {
        $request = Request::instance();
        $data = $this->all();
        if (
            $request->isMethod('put')
            && empty($data['id'])
            && isset($request->id)
        ) {
            $data['id'] = (string) $request->id;
            $this->getInputSource()->replace($data);
        }

        return parent::getValidatorInstance();
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return Array
     */
    public function attributes()
    {
        return [
            'setting_id' => trans('php-firewall::item.setting_id'),
            'user_id'    => trans('php-firewall::item.user_id')
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return Array
     */
    public function rules()
    {
        $rules = [
            'setting_id' => ['required','string','exists:'.config('wk-core.table.firewall.settings').',id'],
            'user_id'    => ['required','string','exists:'.config('wk-core.table.user').',id']
        ];

        $request = Request::instance();
        if (
            $request->isMethod('put')
            && isset($request->id)
        ) {
            $rules = array_merge($rules, ['id' => ['required','string','exists:'.config('wk-core.table.firewall.items').',id']]);
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return Array
     */
    public function messages()
    {
        return [
            'id.required'         => trans('php-core::validation.required'),
            'id.string'           => trans('php-core::validation.string'),
            'id.exists'           => trans('php-core::validation.exists'),
            'setting_id.required' => trans('php-core::validation.required'),
            'setting_id.string'   => trans('php-core::validation.string'),
            'setting_id.exists'   => trans('php-core::validation.exists'),
            'user_id.required'    => trans('php-core::validation.required'),
            'user_id.string'      => trans('php-core::validation.string'),
            'user_id.exists'      => trans('php-core::validation.exists')
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
    }
}
