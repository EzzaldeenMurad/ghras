<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $this->redirect = url()->previous() . '#review-div';
        // $this->redirect = url()->previous() . '#review-div';
        return [
            'review' => 'required|min:5|max:255',
            'article_id'=>'required',
            'rating'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'review.required' => 'حقل المراجعة فارغ',
            'review.min' => 'محتوى المراجعة قصير جدًا'
        ];
    }
}
