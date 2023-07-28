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
    private static string $icon = 'font-icon-attention';
    private static string $menu_icon_class = 'font-icon-attention';

    /**
     *
     * @var array
     */
    private static array $managed_models = array(
        PageBanner::class
    );

    /**
     *
     * @var string
     */
    private static string $url_segment = 'page-banners';

    /**
     *
     * @var string
     */
    private static string $menu_title = 'Page banners';
}
