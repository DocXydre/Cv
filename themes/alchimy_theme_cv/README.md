# The Alchimy Starter Theme

A Timber based theme build to kickstart projects at Alchimy.

## Installing the Theme

Install this theme as you would any other. But hey, let's break it down into some bullets:

1. Rename the folder to something that makes sense for your website (generally no spaces and all lowercase).
2. Launch a `composer update` to install PHP dependencies.
3. Same for `npm i` to install node packages.
4. Search for `[REPLACE_THIS]` and `[APP_NAME]` values in whole project.
   . Activate the theme in Appearance > Themes.
5. Do your thing! And read [the docs](https://timber.github.io/docs/).

## Commands

Use `npm run [command_name]` syntax in your terminal at `package.json` file level.

Commands available:

- `dev` will build development files and proxy to local dev server
- `build_dev` will only build dev files
- `watch` watch for files changes and proxy to local dev server
- `watch_poll` try this if watch doesn't seem to work; enables polling (aka waiting for response) for 1s when watching files
- `watch_hot` same as watch with hot reloading (autorefresh on changes)
- `prod` && `build_prod` will both build files for production in `assets/dist`

## Troubleshoot

- `code: ERR_INVALID_URL in terminal`
  You probably forgot to rename proxy url in `webpack.mix.js`
