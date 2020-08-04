# Better Seo

Add Noindex checkbox and Canonical Url, h1 field and manage mesh links, in the Seo tab in back

**For this module to work properly you need to install ```Sitemap``` module, ```AlternateHreflang``` module and ```CanonicalUrl``` module.**

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is BetterSeo.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/better-seo-module:~1.3.1
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
|$H1    | H1 |
|$MESH_TEXT_1    | mesh text 1 |
|$MESH_URL_1    | mesh url 1 |
|$MESH_TEXT_2    | mesh text 2 |
|$MESH_URL_2    | mesh url 2 |
|$MESH_TEXT_3    | mesh text 3 |
|$MESH_URL_3    | mesh url 3 |
|$MESH_TEXT_4    | mesh text 4 |
|$MESH_URL_4    | mesh url 4 |
|$MESH_TEXT_5    | mesh text 5 |
|$MESH_URL_5    | mesh url 5 |
|$MESH_1    | mesh 1 |
|$MESH_2    | mesh 2 |
|$MESH_3    | mesh 3 |
|$MESH_4    | mesh 4 |
|$MESH_5    | mesh 5 |
|$JSON_DATA    | JSON data for ld json |

### Exemple

    {loop type="better_seo_loop" name="exemple.loop" object_id="42" object_type="category" lang_id="1"}


To use ld json you need to add this part to the head of your pages (product, category, brand, folder, content)

    {loop name="loop-name" type="better_seo_loop" object_id=$object_id object_type=$object_type lang_id=$langId}
        <script type="application/ld+json">
                {$JSON_DATA nofilter}
        </script>
    {/loop}


