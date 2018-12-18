<?php

use SilverStripe\View\Parsers\ShortcodeParser;
use NinjaUnicorns\WysiwygAccordion\Parsers\AccordionParser;

ShortcodeParser::get('default')->register(
    'accordion',
    [AccordionParser::class, 'handle_shortcode']
);
