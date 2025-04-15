let mix = require("laravel-mix");
mix
  .webpackConfig({
    stats: {
      children: true,
    },
  })
  .js("assets/src/js/**/*.js", "assets/dist/main.js")
  .sass("assets/src/scss/main.scss", "assets/dist/main.css")
  .browserSync({
    proxy: "http://localhost/", //this is for dev using localwp servers
    files: [
      "./assets/src/js/**/*.js",
      "./assets/src/scss/**/*.scss",
      "./assets/src/img/**/*.+(png|jpg|svg)",
      "./**/*.+(html|php)",
      "./templates/**/*.+(html|twig)",
    ],
  });
