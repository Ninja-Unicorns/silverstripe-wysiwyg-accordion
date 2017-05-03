<?php

ShortcodeParser::get('default')->register(
    'accordion',
    [AccordionParser::class, 'handle_shortcode']
);