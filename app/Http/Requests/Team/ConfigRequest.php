<?php

namespace App\Http\Requests\Team;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
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
            'name' => 'sometimes|required|min:2|max:100',
            'title1' => 'sometimes|nullable|min:2|max:100',
            'title2' => 'sometimes|nullable|min:2|max:100',
            'title3' => 'sometimes|nullable|min:2|max:100',
            'address_line1' => 'sometimes|required|min:2|max:100',
            'address_line2' => 'sometimes|nullable|min:2|max:100',
            'city' => 'sometimes|required|min:2|max:100',
            'state' => 'sometimes|required|min:2|max:100',
            'country' => 'sometimes|required|min:2|max:100',
            'zipcode' => 'sometimes|required|min:2|max:100',
            'phone' => 'sometimes|required|min:2|max:100',
            'email' => 'sometimes|required|email|min:2|max:100',
            'website' => 'sometimes|nullable|url|min:2|max:100',
            'fax' => 'sometimes|nullable|min:2|max:100',
        ];
    }

    /**
     * Translate fields with user friendly name.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('team.config.general.props.name'),
            'title1' => __('team.config.general.props.title1'),
            'title2' => __('team.config.general.props.title2'),
            'title3' => __('team.config.general.props.title3'),
            'address_line1' => __('team.config.general.props.address_line1'),
            'address_line2' => __('team.config.general.props.address_line2'),
            'city' => __('team.config.general.props.city'),
            'state' => __('team.config.general.props.state'),
            'country' => __('team.config.general.props.country'),
            'zipcode' => __('team.config.general.props.zipcode'),
            'phone' => __('team.config.general.props.phone'),
            'email' => __('team.config.general.props.email'),
            'website' => __('team.config.general.props.website'),
            'fax' => __('team.config.general.props.fax'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    public function withValidator($validator)
    {
        if (! $validator->passes()) {
            return;
        }

        $validator->after(function ($validator) {
            $team = $this->route('team');
        });
    }
}
