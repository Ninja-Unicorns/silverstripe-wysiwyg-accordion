<?php


/**
 * Class AccordionPageExtension
 *
 * @property Page|AccordionPageExtension $owner
 * @method DataList|AccordionItem[] AccordionItems()
 */
class AccordionPageExtension extends DataExtension
{
    private static $description = '<p>Create Accordion items here, the title will be the header and the content will show on click. To add the accordion in the content, simply put [accordion] in the WYSIWYG editor at the place where you want the accordion to appear.</p>';

    private static $has_many = [
        'AccordionItems' => 'AccordionItem'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $helptext = _t('Accordion.HELP', self::$description);
        $helpField = LiteralField::create('Help', $helptext);
        $gridFieldConfig = GridFieldConfig_RecordEditor::create();
        $gridFieldConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
        $accordionGrid = GridField::create('AccordionItems', 'AccordionItems', $this->owner->AccordionItems(),
            $gridFieldConfig);
        $gridFieldConfig->removeComponentsByType('GridFieldAddExistingAutocompleter');
        $fields->addFieldsToTab('Root.Accordion', [
            $helpField,
            $accordionGrid
        ]);
    }
}