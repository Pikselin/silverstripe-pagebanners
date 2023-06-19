# silverstripe-pagebanners
Add page or site level alert banners to a Silverstripe site.

## Features
- Allow multiple banners to be displayed in sequence (ordered by LastEdited)
- Site wide or page specific banners (both allowed on one page)
- Optional date embargo on banners - set a start and end date or leave open ended
- Add a link to each banner (using gorriecoe Link module)
- Optional dismiss button on banner (uses local storage)

## Notes
Banners are managed from the main admin section.

Template can be overridden, just copy PageBanners.ss to {theme}/templates and edit the mark-up.

Simple CSS for laying out the banners is included.

## Adding to your templates
This module uses an extension on SiteTree and an internal template render call. Just use

``$PageBanners

In your template to add them in.
