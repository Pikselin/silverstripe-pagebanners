<?php

namespace Pikselin\PageBanners\extensions;

use Pikselin\PageBanners\DataObjects\PageBanner;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class BaseSiteTreeExtension extends DataExtension {

    public function PageBanners() {

        $extraFilters = [
            'StartTime:LessThan' => date('Y-m-d H:i:s'),
            'EndTime:GreaterThan' => date('Y-m-d H:i:s'),
        ];
        $banners = PageBanner::get()
                ->filterAny(['isGlobal' => '1', 'PageID' => $this->owner->ID])
                ->filter($extraFilters);

        if ($banners) {
            $arrayData = new ArrayData([
                'Banners' => $banners
            ]);

            return $arrayData->renderWith('PageBanners');
        }
        return false;
    }

}
