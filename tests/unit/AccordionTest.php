<?php


class AccordionTest extends SapphireTest
{

    protected static $fixture_file = '../fixtures/accordion.yml';

    public function testAccordionConnected()
    {
        $page = $this->objFromFixture('Page', 'page1');
        $this->objFromFixture('AccordionItem', 'item1');
        $this->objFromFixture('AccordionItem', 'item2');

        $this->assertEquals(2, (int)$page->AccordionItems()->count());
    }

    public function testAccordionOutput()
    {
        $page = $this->objFromFixture('Page', 'page1');
        $page->Content = '[accordion]';
        $this->objFromFixture('AccordionItem', 'item1');
        $this->objFromFixture('AccordionItem', 'item2');

        $backend = new SSViewer('AccordionItems');
        $html = $backend->process($page);
        $this->assertContains('AccordionItem1', $html);
        $this->assertContains('AccordionItem2', $html);

    }
}
