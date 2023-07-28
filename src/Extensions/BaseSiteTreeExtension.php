<?php

namespace Pikselin\PageBanners\extensions;

use Pikselin\PageBanners\DataObjects\PageBanner;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;

/**
 * Class \Pikselin\PageBanners\extensions\BaseSiteTreeExtension
 *
 * @property SiteTree|BaseSiteTreeExtension $owner
 */
class BaseSiteTreeExtension extends DataExtension
{
    public function PageBanners()
    {
        Requirements::css('pikselin/silverstripe-pagebanners: client/css/pagebanners.css');
        Requirements::javascript('pikselin/silverstripe-pagebanners: client/javascript/pagebanners.js');


        $banners = PageBanner::get()
            ->filterAny(['isGlobal' => '1', 'PageID' => $this->owner->ID])
            ->filterByCallback(function ($item, $list) {
                if ($item->TimeSensitive == 0) {
                    return true;
                } elseif ($item->TimeSensitive == 1 && strtotime($item->StartTime) < strtotime(date('Y-m-d H:i:s')) && strtotime($item->EndTime) > strtotime(date('Y-m-d H:i:s'))
                ) {
                    return true;
                } else {
                    return false;
                }
            });

        if ($banners) {
            $arrayData = new ArrayData([
                'Banners' => $banners
            ]);

            return $arrayData->renderWith('PageBanners');
        }

        return false;
    }
}
