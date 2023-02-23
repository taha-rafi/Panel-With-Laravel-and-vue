<?php

namespace App\Models;

use App\Classes\Common;
use App\Models\BaseModel;
use App\Models\Category;
use App\Models\Product;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class FrontWebsiteSettings extends BaseModel
{
    protected $table = 'front_website_settings';

    protected $default = ['xid'];

    protected $guarded = ['id'];

    protected $hidden = ['id', 'featured_categories', 'featured_products'];

    protected $casts = [
        'featured_categories' => 'array',
        'featured_products' => 'array',
        'features_lists' => 'json',
        'pages_widget' => 'json',
        'contact_info_widget' => 'json',
        'links_widget' => 'json',
        'top_banners' => 'json',
        'bottom_banners_1' => 'json',
        'bottom_banners_2' => 'json',
        'bottom_banners_3' => 'json',
    ];

    protected $appends = [
        'xid',
        'x_featured_categories',
        'x_featured_products',
        'featured_products_details',
        'featured_categories_details',
        'top_banners_details',
        'bottom_banners_1_details',
        'bottom_banners_2_details',
        'bottom_banners_3_details'
    ];

    protected $hashableGetterArrayFunctions = [
        'getXFeaturedCategoriesAttribute' => 'featured_categories',
        'getXFeaturedProductsAttribute' => 'featured_products',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);

        static::addGlobalScope('current_warehouse', function (Builder $builder) {
            $warehouse = warehouse();

            if ($warehouse) {
                $builder->where('front_website_settings.warehouse_id', $warehouse->id);
            }
        });
    }

    public function getFeaturedProductsDetailsAttribute()
    {
        $products = [];

        if ($this->featured_products && count($this->featured_products) > 0) {
            $products = Product::withoutGlobalScope(CompanyScope::class)
                ->withoutGlobalScope('current_warehouse')
                ->select('id', 'name', 'slug', 'image', 'description', 'category_id', 'brand_id')
                ->with(['details:id,product_id,sales_price,mrp,tax_id,sales_tax_type', 'details.tax:id,rate', 'brand:id,name,image', 'category:id,name,image'])
                ->whereIn('products.id', $this->featured_products)
                ->get();
        }

        return $products;
    }

    public function getFeaturedCategoriesDetailsAttribute()
    {
        $categories = [];

        if ($this->featured_categories && count($this->featured_categories) > 0) {
            $categories = Category::select('id', 'name', 'image', 'slug')
                ->whereIn('categories.id', $this->featured_categories)
                ->get();
        }

        return $categories;
    }

    public function getTopBannersDetailsAttribute()
    {
        $topBanners = [];
        $frontBannerPath = Common::getFolderPath('frontBannerPath');

        if ($this->top_banners && count($this->top_banners) > 0) {
            foreach ($this->top_banners as $banner) {
                $topBanners[] = [
                    'uid' => Str::random(10),
                    'name' => $banner,
                    'url' => Common::getFileUrl($frontBannerPath, $banner)
                ];
            }
        }

        return $topBanners;
    }

    public function getBottomBanners1DetailsAttribute()
    {
        $bottomBanners1 = [];
        $frontBannerPath = Common::getFolderPath('frontBannerPath');

        if ($this->bottom_banners_1 && count($this->bottom_banners_1) > 0) {
            foreach ($this->bottom_banners_1 as $banner) {
                $bottomBanners1[] = [
                    'uid' => Str::random(10),
                    'name' => $banner,
                    'url' => Common::getFileUrl($frontBannerPath, $banner)
                ];
            }
        }

        return $bottomBanners1;
    }

    public function getBottomBanners2DetailsAttribute()
    {
        $bottomBanners2 = [];
        $frontBannerPath = Common::getFolderPath('frontBannerPath');

        if ($this->bottom_banners_2 && count($this->bottom_banners_2) > 0) {
            foreach ($this->bottom_banners_2 as $banner) {
                $bottomBanners2[] = [
                    'uid' => Str::random(10),
                    'name' => $banner,
                    'url' => Common::getFileUrl($frontBannerPath, $banner)
                ];
            }
        }

        return $bottomBanners2;
    }

    public function getBottomBanners3DetailsAttribute()
    {
        $bottomBanners3 = [];
        $frontBannerPath = Common::getFolderPath('frontBannerPath');

        if ($this->bottom_banners_3 && count($this->bottom_banners_3) > 0) {
            foreach ($this->bottom_banners_3 as $banner) {
                $bottomBanners3[] = [
                    'uid' => Str::random(10),
                    'name' => $banner,
                    'url' => Common::getFileUrl($frontBannerPath, $banner)
                ];
            }
        }

        return $bottomBanners3;
    }
}
