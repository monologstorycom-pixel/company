<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateChatbotRuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['Super Admin', 'Admin']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $ruleId = $this->route('chatbot')?->id ?? $this->route('chatbot');

        return [
            'keyword' => [
                'required',
                'string',
                'max:255',
                Rule::unique('chatbot_rules', 'keyword')->ignore($ruleId),
            ],
            'response' => 'required|string|max:5000',
            'type' => 'required|in:text,link,product_reference',
            'priority' => 'required|integer|min:1|max:10',
            'status' => 'required|in:active,inactive',
        ];
    }
}

