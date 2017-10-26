<?php


/**
 * Class AccordionPageExtension
 *
 * @property Page|AccordionPageExtension $owner
 * @method DataList|AccordionItem[] AccordionItems()
 */
class AccordionPageExtension extends DataExtension
{
    private static $description = '<p><h4>Note</h4>Create Accordion items here, the title will be the header and the content will show on click.<br />To add the accordion in the content, put <strong>[accordion,id=1]</strong> in the WYSIWYG editor at the place where you want the accordion to appear.<br /><u>Replace the 1 with the actual set you want to render.</u></p>';

    private static $has_many = [
        'AccordionItems' => 'AccordionItem'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        if (class_exists('GridFieldSiteTreeState')) {
            Requirements::css(LUMBERJACK_DIR . "/css/lumberjack.css");
        }

        $blacklistedPages = Config::inst()->get(self::class, 'PageBlacklist') ?: [];
        if (!count($blacklistedPages) || !in_array($this->owner->ClassName, $blacklistedPages, true)) {
            $helptext = _t('Accordion.HELP', self::$description);
            $helpField = LiteralField::create('Help', $helptext);
            $gridFieldConfig = GridFieldConfig_RecordEditor::create();
            $gridFieldConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
            if (class_exists('GridFieldSiteTreeState')) {
                $gridFieldConfig->addComponent(new GridFieldSiteTreeState());
            }
            $accordionGrid = GridField::create(
                'AccordionItems', 'AccordionItems', $this->owner->AccordionItems(),
                $gridFieldConfig
            );
            $gridFieldConfig->removeComponentsByType('GridFieldAddExistingAutocompleter');
            $fields->addFieldsToTab(
                'Root.Accordion', [
                    $helpField,
                    $accordionGrid
                ]
            );
        }
    }
}
