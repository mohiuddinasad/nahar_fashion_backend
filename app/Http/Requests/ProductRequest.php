<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Re-index variants array before validation runs
        // Fixes "Undefined array key" error when variant rows are deleted in browser
        if ($this->has('variants')) {
            $this->merge([
                'variants' => array_values(
                    array_filter((array) $this->input('variants'), function ($variant) {
                        return !empty($variant['variant_name']);
                    })
                ),
            ]);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'name'                    => 'required|string|max:255',
            'category_id'             => 'required|exists:categories,id',
            'slug'                    => 'nullable|string|unique:products,slug,' . $productId,
            'description'             => 'nullable|string',
            'price'                   => 'required|numeric|min:0',
            'discount_price'          => 'nullable|numeric|min:0',
            'discount_percentage'     => 'nullable|numeric|min:0|max:100',
            'quantity'                => 'required|integer|min:0',
            'stock_status'            => 'required|in:in_stock,out_of_stock,pre_order',
            'is_featured'             => 'nullable|boolean',
            'is_new'                  => 'nullable|boolean',
            'meta_title'              => 'nullable|string|max:255',
            'meta_description'        => 'nullable|string',
            'meta_keywords'           => 'nullable|string',
            'images'                  => 'nullable|array',
            'images.*'                => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'variants'                => 'nullable|array',
            'variants.*.variant_name' => 'required_with:variants|string|max:255',
            'variants.*.total_price'  => 'required_with:variants|numeric|min:0',
        ];
    }
}
