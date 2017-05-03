<?php

/**
 * Class AccordionItem
 * 
 * There are no permissions, as they're part of Page, and not a separate thing.
 *
 * @property string $Title
 * @property string $Content
 * @property int $SortOrder
 * @property int $PageID
 * @method Page Page()
 */
class AccordionItem extends DataObject
{
    private static $db = [
        'Title'     => 'Varchar(255)',
        'Content'   => 'HTMLText',
        'SortOrder' => 'Int',
    ];

    private static $has_one = [
        'Page' => 'Page'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName(['PageID', 'SortOrder']);

        return $fields;
    }

}