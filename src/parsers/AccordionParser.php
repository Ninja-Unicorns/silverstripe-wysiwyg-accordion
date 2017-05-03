<?php

/**
 * Class AccordionParser
 *
 * Parse the shortcode and return the rendered accordion template
 */
class AccordionParser
{
    public static function get_shortcodes()
    {
        return ['code'];
    }

    /**
     * @param string $arguments array with the type
     * @param array $code string of the code to parse
     * @param ShortcodeParser $parser Parser root user.
     * @param string $shortcode
     * @param array $extra
     *
     * @return String of parsed code.
     */
    public static function handle_shortcode($arguments, $code, $parser, $shortcode, $extra = array())
    {
        // Only if we're on a Page, so the CMS doesn't crash.
        if (Controller::curr() instanceof Page_Controller) {
            $accordionItems = Controller::curr()->dataRecord;
            $template = 'AccordionItems';
            $ssViewer = new SSViewer($template);

            return $ssViewer->process($accordionItems);
        }
    }
}