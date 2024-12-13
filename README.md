# OpenCart Related HTML blocks
[![License: GPLv3](https://img.shields.io/badge/license-GPL%20V3-green?style=plastic)](LICENSE)

The module allows you to create an unlimited number of HTML blocks (HTML content) and relate them to categories / products / manufacturers. And display all related blocks on the product / category / manufacturer page using modules.

## Other Languages

* [Russian](README_RU.md)

## Change Log

* [CHANGELOG.md](docs/CHANGELOG.md)

## Screenshots

* [SCREENSHOTS.md](docs/SCREENSHOTS.md)

## Advantages

* Uses the event mechanism, works without injection into files.

## Features

The module allows:

* create an unlimited number of HTML blocks;
* relate the created blocks with the product, category and manufacturer on the product / category / manufacturer editing page;
* display related blocks using the module on the product / category / manufacturer page;
* bulk edit blocks;
* the output module has the ability to wrap output blocks in another HTML wrapper code;
* it is possible to use yout tpl/twig file for module output. The blocks will be available as an array.

## Compatibility

* OpenCart 2.3, 3.x, 4.x.

## Demo

Admin

* [https://related-html.shtt.blog/admin/](https://related-html.shtt.blog/admin/) (auto login)

Catalog

* [https://related-html.shtt.blog/index.php?route=product/product&product_id=42](https://related-html.shtt.blog/index.php?route=product/product&product_id=42)
* [https://related-html.shtt.blog/index.php?route=product/category&path=33](https://related-html.shtt.blog/index.php?route=product/category&path=33)
* [https://related-html.shtt.blog/index.php?route=product/manufacturer/info&manufacturer_id=8](https://related-html.shtt.blog/index.php?route=product/manufacturer/info&manufacturer_id=8)

The demo site has a top menu for quick navigation.

## Installation

* Install the extension through the standard extension installation section.
* Go to the modules section and install the "Related HTML Blocks" module.

## Management

The module has 3 main sections:

* Block management section (list and add / edit form, block bulk edit form).
* Form for creating / editing a module for displaying related blocks.
* List of blocks for linking them on the pages for editing products / categories / manufacturers.

How does it work?

* Create the HTML blocks you need.
* On the editing page of the entity(product, category, manufacturer) you need, select the necessary blocks, and save.
* Create a block output module. If desired, it will be possible to wrap the output blocks in any other HTML wrapper code.
* Go to the design/layout section and place the created module on the desired page.s

If you have any questions, write to the support thread or send a private message.

## License

* [GPL v3.0](LICENSE.MD)

## Thank You for Using My Extensions!

I have decided to make all my OpenCart extensions free and open-source to benefit the community. Developing, maintaining, and updating these extensions takes time and effort.

If my extensions have been helpful for your project and you’d like to support my work, any donation is greatly appreciated.

### 💙 You can support me via:

* [PayPal](https://paypal.me/TalgatShashakhmetov?country.x=US&locale.x=en_US)
* [CashApp](https://cash.app/$TalgatShashakhmetov)

Your support inspires me to keep improving and developing these tools. Thank you!
