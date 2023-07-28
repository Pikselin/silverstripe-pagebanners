<?php

namespace Pikselin\PageBanners\DataObjects;

use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;
use Page;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;
use SilverStripe\Security\Security;
use UncleCheese\DisplayLogic\Forms\Wrapper;

/**
 * Class \Pikselin\PageBanners\DataObjects\PageBanner
 *
 * @property string $Text
 * @property string $Type
 * @property bool $isGlobal
 * @property string $StartTime
 * @property string $EndTime
 * @property bool $Dismiss
 * @property bool $TimeSensitive
 * @property int $PageID
 * @property int $LinksToID
 * @method Page Page()
 * @method Link LinksTo()
 */
class PageBanner extends DataObject implements PermissionProvider
{
    private static string $singular_name = 'Page banner';
    private static string $default_sort = 'LastEdited Desc';
    private static string $icon = 'font-icon-attention';
    private static array $db = array(
        'Text'          => 'Text',
        'Type'          => "Enum('Notice, Warning, Info','Info')",
        'isGlobal'      => 'Boolean',
        'StartTime'     => 'Datetime',
        'EndTime'       => 'Datetime',
        'Dismiss'       => 'Boolean',
        'TimeSensitive' => 'Boolean'
    );
    private static array $has_one = array(
        'Page'    => Page::class,
        //'LinksTo' => Page::class,
        'LinksTo' => Link::class
    );
    private static array $summary_fields = array(
        'Text'          => 'Text',
        'Type'          => 'Type',
        'IsGlobalNice'  => 'Global Message',
        'IsDismissNice' => 'Can dismiss',
        'StartTime'     => 'Show from',
        'EndTime'       => 'until'
    );
    private static string $table_name = 'PageBanners';

    public function canView($member = null): bool
    {
        return true;
    }

    public function canDelete($member = null)
    {
        return Permission::check('ALERT_CREATE');
    }

    public function canCreate($member = null, $context = array())
    {
        return Permission::check('ALERT_CREATE');
    }

    public function canEdit($member = null)
    {
        return Permission::check('ALERT_CREATE');
    }

    public function providePermissions(): array
    {
        return array(
            'ALERT_CREATE'  => array(
                'name'     => 'Manage page banners <em>(remember to provide either Create Alert, Notice or Info permissions too!)</em>',
                'category' => 'Page banner Management',
                'sort'     => -100
            ),
            'ALERT_NOTICE'  => array(
                'name'     => 'Create Notices',
                'category' => 'Page banner Management'
            ),
            'ALERT_WARNING' => array(
                'name'     => 'Create Warnings',
                'category' => 'Page banner Management'
            ),
            'ALERT_INFO'    => array(
                'name'     => 'Create Information',
                'category' => 'Page banner Management'
            ),
        );
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
    }

    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Title');
        $fields->removeByName('Dismiss');
        $fields->removeByName('StartTime');
        $fields->removeByName('EndTime');
        $fields->removeByName('PageID');
        $fields->removeByName('LinksToID');

        $Dismiss = CheckboxField::create('Dismiss', 'Can be closed')->setDescription('Can this banner be closed by the user?');

        $IsGlobal = CheckboxField::create('isGlobal', 'Global banner');
        $IsGlobal->setDescription('Global banners will be displayed on every page.');

        $Text = TextareaField::create('Text', 'Banner Text');

        $TargetPage = Wrapper::create(TreeDropdownField::create('PageID', 'Display On Page', SiteTree::class))->displayUnless('isGlobal')->isChecked()->end();

        $LinksToConfig = [
            'types' => [
                'SiteTree' => true,
                'URL'      => true,
                'Email'    => true,
                'Phone'    => true,
                'File'     => true,
            ],
        ];
        $LinksTo = LinkField::create('LinksTo', 'Banner link', $this, $LinksToConfig)->setDescription('Optionally link this alert to another page in the site.');

        $TimeSensitive = CheckboxField::create('TimeSensitive', 'Time sensitive');
        $TimeSensitive->setDescription('Should this banner only be displayed between certain dates?');

        $DateTimeExplain = Wrapper::create(LiteralField::create(
            'dateTimeExplain',
            'Only show this alert between these times. Enter time format in simple 24h notation, eg <strong>15:30</strong>, Start and End date/times are required. If none are entered then the alert will never show.'
        ))->displayIf('TimeSensitive')->isChecked()->end();

        $DateTimeFields = [];

        $startTimeField = DatetimeField::create('StartTime', 'Start Date/Time');
        $startTimeField->setValue(date('Y-m-d H:i')); // requires ->setHTML5(false)

        $endTimeField = DatetimeField::create('EndTime', 'End Date/Time');
        $endTimeField->setValue(date('Y-m-d H:i', strtotime('now +1 Month'))); // requires ->setHTML5(false)

        $DateTimeFields[] = $startTimeField;
        $DateTimeFields[] = $endTimeField;
        $DateTimeField = Wrapper::create(FieldGroup::create('Date and time', $DateTimeFields))->displayIf('TimeSensitive')->isChecked()->end();

        $alerts = array();
        $currentMember = Security::getCurrentUser();
        if (Permission::check('ALERT_NOTICE', 'any', $currentMember)) {
            $alerts['Notice'] = 'Notice';
        }
        if (Permission::check('ALERT_WARNING', 'any', $currentMember)) {
            $alerts['Warning'] = 'Warning';
        }
        if (Permission::check('ALERT_INFO', 'any', $currentMember)) {
            $alerts['Info'] = 'Information';
        }
        $Type = DropdownField::create(
            'Type',
            'Type of alert',
            $alerts
        );
        $fields->addFieldToTab('Root.Main', $IsGlobal);
        $fields->addFieldToTab('Root.Main', $TargetPage);
        $fields->addFieldToTab('Root.Main', $Type);
        $fields->addFieldToTab('Root.Main', $Text);
        $fields->addFieldToTab('Root.Main', $LinksTo);
        $fields->addFieldToTab('Root.Main', $Dismiss);
        $fields->addfieldToTab('Root.Main', $TimeSensitive);
        $fields->addfieldToTab('Root.Main', $DateTimeExplain);
        $fields->addfieldToTab('Root.Main', $DateTimeField);

        return $fields;
    }

    public function getIsGlobalNice(): string
    {
        return $this->isGlobal == 1 ? 'Yes' : 'No';
    }

    public function getIsDismissNice(): string
    {
        return $this->Dismiss == 1 ? 'Yes' : 'No';
    }
}
