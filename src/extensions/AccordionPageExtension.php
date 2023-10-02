<?php

namespace NinjaUnicorns\WysiwygAccordion\Extensions;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\View\Requirements;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Lumberjack\Forms\GridFieldSiteTreeState;
use SilverStripe\Forms\GridField\GridField;
use NinjaUnicorns\WysiwygAccordion\Models\AccordionItem;

/**
 * Class AccordionPageExtension
 *
 * @property Page|AccordionPageExtension $owner
 * @method DataList|AccordionItem[] AccordionItems()
 */
class AccordionPageExtension extends DataExtension
{
    CONST NUMBER_OF_ITEMS_PER_PAGE = 20;

    private static $helpDescription = '<p><h4>Note</h4>Create Accordion items here, 
    the title will be the header and the content will show on click.<br />To add the
     accordion in the content, put <strong>[accordion,id=1]</strong> in the WYSIWYG 
     editor at the place where you want the accordion to appear.<br /><u>Replace
      the 1 with the actual set you want to render.</u></p>';

    private static $has_many = [
        'AccordionItems' => AccordionItem::class
    ];

    public function updateCMSFields(FieldList $fields)
    {
        if (class_exists('GridFieldSiteTreeState')) {
            Requirements::css(LUMBERJACK_DIR . "/css/lumberjack.css");
        }

        $blacklistedPages = Config::inst()->get(self::class, 'PageBlacklist') ?: [];
        if (!count($blacklistedPages) || !in_array($this->owner->ClassName, $blacklistedPages, true)) {
            $helptext = _t('Accordion.HELP', self::$helpDescription);
            $helpField = LiteralField::create('Help', $helptext);
            $gridFieldConfig = GridFieldConfig_RecordEditor::create();
            $gridFieldConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
            if (class_exists('GridFieldSiteTreeState')) {
                $gridFieldConfig->addComponent(new GridFieldSiteTreeState());
            }
            $accordionGrid = GridField::create(
                'AccordionItems',
                'AccordionItems',
                $this->owner->AccordionItems(),
                $gridFieldConfig
            );
            $gridFieldConfig->removeComponentsByType('GridFieldAddExistingAutocompleter');
            $fields->addFieldsToTab(
                'Root.Accordion',
                [
                    $helpField,
                    $accordionGrid
                ]
            );

            $gridFieldConfig
                ->getComponentByType(GridFieldPage::class)
                ->setItemsPerPage(self::NUMBER_OF_ITEMS_PER_PAGE); // Change 20 to your desired number
        }
    }
}
