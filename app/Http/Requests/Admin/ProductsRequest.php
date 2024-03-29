<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductsRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $model = $this->route('product');

        return [
            'name' => [
                'bail',
                'required', 
                'string', 
                'max:100',
            ],
            'slug' => [
                'bail',
                'required', 
                'string', 
                'max:50',
                Rule::unique(Product::class)->ignore($model->id ?? null)
            ],
            'description' => [
                'bail',
                'required',
                'string'
            ],
            'costPrice' => [
                'bail',
                'required',
                'integer'
            ],
            'price' => [
                'bail',
                'required',
                'integer'
            ],
            'featured' => [
                'bail',
                'boolean',
            ],
            'showOnSlider' => [
                'bail',
                'boolean',
            ],
            'active' => [
                'bail',
                'boolean'
            ],
            'categoryId' => [
                'bail',
                'required',
                Rule::exists(Category::class, 'id')->whereNull('parent_id'),
            ],
            'subCategoryId' => [
                'bail',
                'nullable',
                Rule::exists(Category::class, 'id')->whereNotNull('parent_id'),
            ]
        ];
    }

    public function saveData()
    {
        $data = $this->safe()->only(['name', 'slug', 'description', 'price', 'featured', 'active']);
        $data['cost_price'] = $this->costPrice;
        $data['show_on_slider'] = $this->showOnSlider;

        if (!$this->route('product')) {
            $data['creator_id'] = $this->user()->id;
        }

        return $data;
    }

    public function categoryIds(): Collection
    {
        return collect([$this->categoryId, $this->subCategoryId])->filter()->values();
    }
}
