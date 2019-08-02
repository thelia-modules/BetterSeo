# Better Seo

Add Noindex checkbox and Canonical Url field in the Seo tab in back

**For this module to work properly you need to install ```Sitemap``` module, ```AlternateHreflang``` module and ```CanonicalUrl``` module.**

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is BetterSeo.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/better-seo-module:~1.0
```

## Loop

[better_seo_loop]

### Input arguments

|Argument |Description |
|---      |---         |
|**object_id** | The id of the object to display, exemple: object_id="12" |
|**object_type** | The type of the object to display (product, category, brand, folder, content) exemple object_type="brand"|
|**lang_id** | The id of the language|

### Output arguments

|Variable   |Description |
|---        |--- |
|$ID   | the id in seo_noindex table |
|$OBJECT_ID    | the id of the object |
|$OBJECT_TYPE    | the type of the object |
|$NOINDEX    | if the page of the object is index or not (value 0 or 1) |
|$NOFOLLOW   | if the page of the object is follow or not (value 0 or 1) |
|$CANONICAL    | Canonical Url |

### Exemple

{loop type="better_seo_loop" name"exemple.loop" object_id="42" object_type="category" lang_id="1"}


