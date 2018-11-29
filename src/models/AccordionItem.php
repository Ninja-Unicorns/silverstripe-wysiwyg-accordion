<?php

namespace NinjaUnicorns\WysiwygAccordion\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DB;
use SilverStripe\Versioned\Versioned;
use Page;

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
    private static $table_name = 'AccordionItem';

    private static $db = [
        'Title'        => 'Varchar(255)',
        'Content'      => 'HTMLText',
        'AccordionSet' => 'Int(1)',
        'SortOrder'    => 'Int',
    ];

    private static $has_one = [
        'Page' => Page::class
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'Title'        => 'Title',
        'AccordionSet' => 'Accordion ID',
    ];

    private static $default_sort = 'SortOrder ASC';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', LiteralField::create('message', '<h5></h5>'), 'Title');
        /** @var $accordion NumericField */
        $accordion = $fields->fieldByName('Root.Main.AccordionSet');
        $description = 'All items that share the same accordion have to have
         the same accordion ID, accordion shortcode is [accordion,id=ID]
         <br /><br /><strong>Important:</strong> Do not attempt to add an
          accordionset with the same ID as this accordion in the content.';
        $accordionIds = $this->Page()->AccordionItems()->column('AccordionSet');

        if (count($accordionIds) > 0) {
            $accordionIds = array_unique($accordionIds);
            sort($accordionIds, SORT_NUMERIC);

            $description .= '<br /><br />This page currently has following accordion IDs: ' . implode(
                ', ',
                $accordionIds
            );
        }

        $accordion->setDescription($description);

        if ($this->ID == 0) {
            $accordion->setValue(1);
        }

        $fields->removeByName(['PageID', 'SortOrder', 'AccordionSet']);
        $fields->addFieldToTab('Root.Main', $accordion, 'Content');

        return $fields;
    }

    public function canDelete($member = null)
    {
        $can = parent::canDelete($member);
        if ($this->wasPublished()) {
            return false;
        }

        return $can;
    }

    public function wasPublished()
    {
        return DB::prepared_query('SELECT "ID" FROM "AccordionItem_Live" WHERE "ID" = ?', array($this->ID))->value()
            ? true
            : false;
    }

    public function onAfterDelete()
    {
        parent::onAfterDelete();
        if ($this->isPublished()) {
            $this->deleteFromStage('Live');
        }
    }

    /**
     * Check if this page has been published.
     *
     * @return bool
     */
    public function isPublished()
    {
        if ($this->isNew()) {
            return false;
        }

        $isPublished = DB::prepared_query(
            'SELECT "ID" FROM "AccordionItem_Live" WHERE "ID" = ?',
            array($this->ID)
        )->value();
        if ($isPublished) {
            return Versioned::get_latest_version(static::class, $this->ID)->WasPublished;
        }

        return $isPublished;
    }

    /**
     * Check if this page is new - that is, if it has yet to have been written to the database.
     *
     * @return bool
     */
    public function isNew()
    {
        /**
         * This check was a problem for a self-hosted site, and may indicate a bug in the interpreter on their server,
         * or a bug here. Changing the condition from empty($this->ID) to !$this->ID && !$this->record['ID'] fixed this.
         */
        if (empty($this->ID)) {
            return true;
        }

        if (is_numeric($this->ID)) {
            return false;
        }

        return stripos($this->ID, 'new') === 0;
    }
}
