<?php

namespace NinjaUnicorns\WysiwygAccordion\Tests\Unit;

use SilverStripe\Dev\SapphireTest;
use NinjaUnicorns\WysiwygAccordion\Parsers\AccordionParser;
use SilverStripe\View\Parsers\ShortcodeParser;
use NinjaUnicorns\WysiwygAccordion\Models\AccordionItem;
use Page;

class AccordionTest extends SapphireTest
{

    protected static $fixture_file = '../fixtures/accordion.yml';

    public function testAccordionConnected()
    {
        $page = $this->objFromFixture(Page::class, 'page1');
        $this->objFromFixture(AccordionItem::class, 'item1');
        $this->objFromFixture(AccordionItem::class, 'item2');

        $this->assertEquals(2, (int)$page->AccordionItems()->count());
    }

    public function testAccordionOutput()
    {
        /** @var $page Page */
        $page = $this->objFromFixture(Page::class, 'page1');
        $page->Content = '[accordion id=1]';
        $this->objFromFixture(AccordionItem::class, 'item1');
        $this->objFromFixture(AccordionItem::class, 'item2');

        AccordionParser::setPage($page);
        $html = ShortcodeParser::get_active()->parse($page->Content);
        AccordionParser::clearPage();

        $this->assertContains('AccordionItem1', $html);
        $this->assertContains('AccordionItem2', $html);
    }
}
