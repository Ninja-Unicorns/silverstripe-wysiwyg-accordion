<?php

/**
 * Class AccordionParser
 *
 * Parse the shortcode and return the rendered accordion template
 * Parsing requires a page reference which is taken from Page_Controller by default
 * In the case Page_Controller is not available there is an option to manually inject page reference before parsing
 */
class AccordionParser
{
    /**
     * @var Page
     */
    private static $page = null;

    public static function get_shortcodes()
    {
        return ['accordion'];
    }

    /**
     * @param array           $arguments array with the type
     * @param string          $code      string of the code to parse
     * @param ShortcodeParser $parser    Parser root user.
     * @param string          $shortcode
     * @param array           $extra
     *
     * @return String of parsed code.
     */
    public static function handle_shortcode($arguments, $code, $parser, $shortcode, $extra = array())
    {
        // page controller, this is the default case
        if (Controller::curr() instanceof Page_Controller) {
            // Only if we're on a Page, so the CMS doesn't crash.
            $page = Controller::curr()->dataRecord;
        }
        // attempt to load page via custom loader
        else {
            $page = static::$page;
        }

        // no page available, abort shortcode parsing
        if (is_null($page)) {
            return '[accordion]';
        }

        // render accordion
        $template = 'AccordionItems';
        $ssViewer = new SSViewer($template);
        if (array_key_exists('id', $arguments)) {
            $accordion = ArrayData::create([
                'AccordionId' => $arguments['id'],
                'AccordionItems' => $page->AccordionItems()->filter(['AccordionSet' => $arguments['id']])
            ]);
        }

        return $ssViewer->process($accordion);
    }

    /**
     * Use this in the custom parsing case (non Page_Controller case)
     * this is handy in cases where page can't be injected via controller
     * page has to support accordions
     * @param Page $page
     */
    public static function setPage(Page $page)
    {
        static::$page = $page;
    }

    /**
     * Clear the page after custom parsing
     */
    public static function clearPage()
    {
        static::$page = null;
    }
}
