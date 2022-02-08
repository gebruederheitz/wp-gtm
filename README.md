# Wordpress Simple Google Tag Manager

_A helper to include the Google Tag Manager in your Wordpress._

---

## Installation

via composer:
```shell
> composer require gebruederheitz/wp-gtm
```

Make sure you have Composer autoload or an alternative class loader present.

## Usage

```php
# functions.php (or controller class)
use Gebruederheitz\Wordpress\GoogleTagManager;

new GoogleTagManager();
```

```dotenv
# .env

#--------------------------------------------------------------------------------------------------#
#                                   GOOGLE TAGMANAGER                                              #
# Adds Google Tagmanager snippets                                                                  #
#--------------------------------------------------------------------------------------------------#
GTM_CONTAINER_ID=GTM-XXXXX
```

You can also add parameters to your container ID in order for example to use a staging environment.

If the environment variable is not defined, the script snippet will not be loaded,
unless you provide a custom GTM container ID to the constructor.

### Passing a container ID at runtime

Instead of providing the container ID through the environment, you can also pass
it through the constructor – which is handy when you're providing the user with
a setting through theme options in the database, for example.

```php
$containerId = get_option('namespace_gtm_container_id', null);
new \Gebruederheitz\Wordpress\GoogleTagManager($containerId);
```

An ID passed to the constructor will always override the environment setting.


### Using a custom template

By creating a file at `template-parts/blocks/gtm.php` inside your theme directory
you can override the default output (replace the snippet).

Alternatively you may pass a custom path (inside your theme directory) as the 
constructor's second parameter and use that file instead.

```php
new \Gebruederheitz\Wordpress\GoogleTagManager(null, 'partials/tagmanager.twig.php');
```



## Development

### Dependencies

- PHP >= 7.4
- [Composer 2.x](https://getcomposer.org)
- [NVM](https://github.com/nvm-sh/nvm) and nodeJS LTS (v16.x)
- Nice to have: GNU Make (or drop-in alternative)
