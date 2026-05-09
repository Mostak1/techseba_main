<?php

namespace Modules\GlobalSetting\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemeColorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */

     public function rules()
    {
        $rules = [
            'theme_heading_color' => 'required',
            'theme_body_color' => 'required',
            'theme_accent_color' => 'required',
            'theme_white_color' => 'required',
            'theme_light_color1' => 'required',
            'theme_light_color2' => 'required',
            'theme_dark_bg' => 'required',
            'theme_dark_bg2' => 'required',
            'theme_dark_bg3' => 'required',
            'theme_white_bg' => 'required',
            'theme_accent_bg' => 'required',
            'theme_light_bg1' => 'required',
            'theme_light_bg2' => 'required',
            'theme_light_bg3' => 'required',
        ];

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'theme_heading_color.required' => trans('translate.Heading color is required'),
            'theme_body_color.required' => trans('translate.Body color is required'),
            // Add more as needed, but standard 'required' message is usually enough for colors
        ];
    }

}
