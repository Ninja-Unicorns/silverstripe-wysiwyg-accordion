<?php

/**
 * Class AccordionItem
 * 
 * There are no permissions, as they're part of Page, and not a separate thing.
 *
 * @property string $Title
 * @property string $Content
 * @property int $AccordionSet
 * @property int $SortOrder
 * @property int $PageID
 * @method Page Page()
 */
class AccordionItem extends DataObject
{
    private static $db = [
        'Title'         => 'Varchar(255)',
        'Content'       => 'HTMLText',
        'AccordionSet'  => 'Int(1)',
        'SortOrder'     => 'Int',
    ];

    private static $has_one = [
        'Page' => 'Page'
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'Title' => 'Title',
        'AccordionSet' => 'Accordion ID',
    ];

    private static $default_sort = 'SortOrder ASC';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        /** @var $accordion NumericField */
        $accordion = $fields->fieldByName('Root.Main.AccordionSet');
        $description = 'All items that share the same accordion have to have the same accordion ID, accordion shortcode is [accordion,id=ID]';
        $accordionIds = $this->Page()->AccordionItems()->column('AccordionSet');

        if (count($accordionIds) > 0) {
            $accordionIds = array_unique($accordionIds);
            sort($accordionIds, SORT_NUMERIC);

            $description.= ' This page currently has following accordion IDs: ' . implode(', ', $accordionIds);
        }

        $accordion->setDescription($description);

        if ($this->ID == 0) {
            $accordion->setValue(1);
        }

        $fields->removeByName(['PageID', 'SortOrder', 'AccordionSet']);
        $fields->addFieldToTab('Root.Main', $accordion, 'Content');

        return $fields;
    }

}
