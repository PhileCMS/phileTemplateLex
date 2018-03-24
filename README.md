**NOTE**: This repository is not maintained anymore and archived.

phileTemplateLex
================

Use the [Lex](https://github.com/pyrocms/lex) parser in your templates for [PhileCMS](https://github.com/PhileCMS/Phile)

### 1.1 Installation (composer)
```
php composer.phar require phile/template-lex:*
```

### 1.2 Installation (Download)

* Install the latest version of [Phile](https://github.com/PhileCMS/Phile)
* Clone this repo into `plugins/phile/templateLex`

### 2. Activation

After you have installed the plugin. You need to add the following line to your `config.php` file:

```
$config['plugins']['phile\\templateLex'] = array('active' => true);
```

#### Install Lex via composer

Just add the Lex dependency to your composer.json file:

```json
{
  "require": {
    "twig/twig": "1.14.*",
    "michelf/php-markdown": "1.3",
    "pyrocms/lex": "2.2.*" // this is the new line you will need
  }
}
```

Now run your `composer install` command as normal.

Modify your `config.php` file:

```php
$config['plugins'] = array(
  // disable the Twig template engine
  'phile\\templateTwig' => array('active' => false),
  // enable the Lex template engine
  'phile\\templateLex' => array('active' => true)
);
```

### Disclaimer

Due to the nature of the Page model in Phile, and the fact that Lex doesn't like some objects, there are some slightly different properties available to the `pages` array.

* title
* url
* content
* meta

This covers most of the things that the `pages` array covers in Twig.

### Not a drop in replacement for Twig

If you have not used Lex before, please read the [docs](https://github.com/pyrocms/lex/wiki#basic-usage) because there are a few differences in syntax, and philosophy, over Twig.

I have included an `index.lex` file to show how to recreate the index page from the default theme.

### Why use this over Twig

* Different syntax (all curly braces, no {% %} braces)
* Lighter weight (but this is debatable)
* Much simpler than Twig or Smarty (less functions)
