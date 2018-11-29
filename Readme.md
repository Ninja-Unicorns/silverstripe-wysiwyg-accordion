# Simplified management of Accordion content in WYSIWYG

[![Build Status](https://travis-ci.org/SilverStripe-Ninja-Unicorns/silverstripe-wysiwyg-accordion.svg?branch=master)](https://travis-ci.org/SilverStripe-Ninja-Unicorns/silverstripe-wysiwyg-accordion) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SilverStripe-Ninja-Unicorns/silverstripe-wysiwyg-accordion/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SilverStripe-Ninja-Unicorns/silverstripe-wysiwyg-accordion/?branch=master)

## Requirements

SilverStripe Framework `^4.2`

SilverStripe CMS `^4.2`

## Usage

Use `[accordion]` in the wysiwyg and create the accordion items accordingly!

The items can be ordered using drag-and-drop on the gridfield overview.

If you don't want the accordion option on certain pages, add the blacklisted pagetypes to your yml like this:
```yaml
NinjaUnicorns\WysiwygAccordion\Extensions\AccordionPageExtension:
  PageBlacklist:
    - MyApp\Pages\HomePage
```
**Reminder:** If you use namespacing don't forget to use the full namespace for the page.

## Reason

We've run in to it a few times, when clients want an accordion that's easy to place in the WYSIWYG editor. Often, it then comes down to Content Author precision on selecting the right styling so some javascript can be applied to make the accordion work.

This way of work is quite prone to errors on both the developer and the author side. This module makes creating and positioning an accordion easier. Although it is slightly more work for the content author, this is a more robust solution and less error prone.

## Installation

`composer require ninja-unicorns/wysiwyg-accordion`

## Documentation

The module comes without javascript, but it's default template is based on [Bootstrap 3](https://getbootstrap.com/javascript/#collapse).

No javascript is on purpose, to make sure the developer can use it's own preferred library.

To override the given template, copy it to your `themes/projectname` folder and customize the template.

## Testing

Yep

## Todo

- [ ] Multiple accordions on one page?
- [ ] Nested accordions?
- [x] Blacklist certain page types, so the accordion option won't show or work (useful for pages that should not have an accordion, making sure authors don't accidentally create one anyway).

## Did you say Ninja Unicorns?

```
                  .
                 /'
                //
            .  //
            |\//7
           /' " \
          .   . .
          | (    \     '._
          |  '._  '    '. '
          /    \'-'_---. ) )
         .              :.'
         |               \
         | .    .   .     .
         ' .    |  |      |
          \^   /_-':     /
          / | |    '\  .'
         / /| |     \\  |
         \ \( )     // /
          \ | |    // /
           L! !   // /
            [_]  L[_|
```

## License

BSD-3 clause