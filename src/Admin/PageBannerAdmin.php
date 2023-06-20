<?php

namespace Pikselin\PageBanners\admin;

use Pikselin\PageBanners\DataObjects\PageBanner;
use SilverStripe\Admin\ModelAdmin;

/**
 * Class \Pikselin\PageBanners\admin\PageBannerAdmin
 *
 */
class PageBannerAdmin extends ModelAdmin
{
    private static $icon = 'font-icon-attention';
    private static $menu_icon_class = 'font-icon-attention';

    /**
     *
     * @var array
     */
    private static $managed_models = array(
        PageBanner::class
    );

    /**
     *
     * @var string
     */
    private static $url_segment = 'page-banners';

    /**
     *
     * @var string
     */
    private static $menu_title = 'Page banners';
}
