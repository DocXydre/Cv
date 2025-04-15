# Project name

This is a blank project; use it as a base to launch a new Alchimy project.

This is based on an official wordpress docker image, with a V2 Timber modified starter theme.

# Steps

### 1 - Create an .env file

Duplicate `.env.example` into `.env`.

### 2 - Manually add plugins if needed

### 3 - Add a theme / resolve its dependencies

`cd /themes/{theme_folder} `
`composer install `
`npm i`

Don't forget to configure your theme accordingly to its documentation.

Some common gotchas :

- URL not updated

### 4 - Check config files

See `custom.ini` for overriding php config.

Search for `[REPLACE_THIS]` and `[APP_NAME]` values in whole project.

### 5 - Launch project

`make up `
`cd /themes/{theme_folder}`
`npm run watch`

This will populate your folders

# IMPORTANT INFORMATIONS

### Plugins / Themes

    If a plugin / theme is part of your project, you MUST add it to .gitignore file as an exception.

    Themes have a folder name convention to work around this : prefix your folder with "alchimy_theme_" and it should automatically be tracked.

    Plugins / themes folders are designed as context specific and won't be included into repository.

    THIS SHOULD ABSOLUTELY STAY AS IT IS.
    DO NOT INCLUDE THIRD PARTY DEPENDENCIES IN REPO.
    THIS WOULD RESULT IN POSSIBLE OVERWRITING ISSUES IN PRODUCTION.

    As a rule of thumb : third party updates are resolved by imports / exports or wordpress automatic processes.

### Docker config variables

From official wordpress image documentation :

```
    WORDPRESS_DB_HOST=...
    WORDPRESS_DB_USER=...
    WORDPRESS_DB_PASSWORD=...
    WORDPRESS_DB_NAME=...
    WORDPRESS_TABLE_PREFIX=...
    WORDPRESS_AUTH_KEY=...
    WORDPRESS_SECURE_AUTH_KEY=...
    WORDPRESS_LOGGED_IN_KEY=...
    WORDPRESS_NONCE_KEY=...
    WORDPRESS_AUTH_SALT=...
    WORDPRESS_SECURE_AUTH_SALT=...
    WORDPRESS_LOGGED_IN_SALT=...
    WORDPRESS_NONCE_SALT=... (default to unique random SHA1s, but only if other environment variable configuration is provided)
    WORDPRESS_DEBUG=1 (defaults to disabled, non-empty value will enable WP_DEBUG in wp-config.php)
    WORDPRESS_CONFIG_EXTRA=... (defaults to nothing, non-empty value will be embedded verbatim inside wp-config.php -- especially useful for applying extra configuration values this image does not provide by default such as WP_ALLOW_MULTISITE; see docker-library/wordpress#142 for more details)
```

### Database

From official wordpress image documentation :

> The WORDPRESS_DB_NAME needs to already exist on the given MySQL server; it will not be created by the wordpress container.

### Known issues / possible improvements :

- [ENV] missing a lot of wordpress config variables
