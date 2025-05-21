<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => 'required',
            'content' => 'required|max:255',
            'image' => 'required||mimes:jpg,png',
            'condition' => 'required',
            'categories' => 'required',
            'price' => 'required|integer|min:0',
        ];
    }
    public function messages(){
        return [
            'name.required' => '商品名を入力してください',
            'content.required' => '商品説明を入力してください',
            'content.max' => '商品説明は255文字以内で入力してください',
            'image.required' => '商品画像をアップロードしてください',
            'image.mimes' => '画像ファイルはjpeg,もしくはpngファイルでアップロードしてください',
            'condition.required' => '商品状態を選択してください',
            'categories.required' => 'カテゴリーを少なくとも１つは選択してください',
            'price.required' => '販売価格の入力をしてください',
            'price.integer' => '販売価格は半角英数字で入力してください',
            'price.min' => '販売価格は1円以上の金額で入力してください',
        ];
    }

}
