<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'payment_method' =>'required',
            'postal_code' => 'required|size:8',
            'address' => 'required',
            'building' => 'required',
        ];
    }

    public function messages(){
        
        return [
            'payment_method.required' => '支払い方法を選択して下さい',
            'postal_code.required' => '郵便番号の記載がありません',
            'postal_code.size' => '郵便番号はハイフン含め半角8文字に変更して下さい',
            'address.required' => '住所の記載がありません。',
            'building.required' => '建物の記載がありません。',
        ];
    }
}
