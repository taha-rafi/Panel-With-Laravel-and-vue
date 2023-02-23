<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Product;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Builder;

class FrontProductCard extends BaseModel
{
    protected $table = 'front_product_cards';

    protected $default = ['xid'];

    protected $guarded = ['id'];

    protected $hidden = ['id', 'products'];

    protected $casts = [
        'products' => 'array'
    ];

    protected $filterable = ['title'];

    protected $appends = ['xid', 'x_products', 'products_details'];

    protected $hashableGetterArrayFunctions = [
        'getXProductsAttribute' => 'products',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);

        static::addGlobalScope('current_warehouse', function (Builder $builder) {
            $warehouse = warehouse();

            if ($warehouse) {
                $builder->where('front_product_cards.warehouse_id', $warehouse->id);
            }
        });
    }

    public function getProductsDetailsAttribute()
    {
        $products = Product::withoutGlobalScope(CompanyScope::class)
            ->withoutGlobalScope('current_warehouse')
            ->select('id', 'name', 'slug', 'image', 'description', 'brand_id', 'category_id')
            ->with(['details:id,product_id,sales_price,mrp,tax_id,sales_tax_type,current_stock', 'details.tax:id,rate', 'brand:id,name,slug,image', 'category:id,name,slug,image'])
            ->whereIn('products.id', $this->products)
            ->get();

        return $products;
    }
}
