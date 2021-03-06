/**
** CONFIGURAÇÃÕES PARA O NOTIFICATION
**/
const projeto = 'Matheus Maydana',
      msg     = 'O arquivo "<%= file.relative %>" foi compilado com sucesso!';

/**
  DEPENDENCIAS

  # Node Versão 8
  curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
  sudo apt-get install -y nodejs

  # NPM ultima versão
  npm install npm@latest -g

  # verificar Node e npm instalado,
  node -v
  npm -v

  # Instalação Gulp
  # Gulp
    sudo npm install gulp-cli -g
    sudo npm install gulp -D

  # Dependencias
  # gulp-uglify-es
    npm install --save-dev gulp-uglify-es

  # gulp-rename
    npm i gulp-rename

  # gulp-concat
  npm install --save-dev gulp-concat

  # gul-sass
    npm install gulp-sass --save-dev
    'Se der problema com o Sass, execute isso'
    npm rebuild node-sass

  # gulp-notify
    npm i gulp-notify

  # gulp-sourcemaps
    npm i gulp-sourcemaps


  # ERRO ESCUTA GULP
    gulp watch fails with error: Error: watch ... ENOSPC

    ( SOLUÇÃO )
    - no terminal -
    echo fs.inotify.max_user_watches=524288 | sudo tee -a /etc/sysctl.conf
**/
const gulp   = require('gulp'),
      uglify = require('gulp-uglify-es').default,
      rename = require('gulp-rename'),
      concat = require('gulp-concat'),
      sass   = require('gulp-sass'),
      notify = require('gulp-notify'),
      sourcemaps = require('gulp-sourcemaps');

const contate_site = [
  'js/js/site.js',
  'js/js/Form/Form.js'
];

const contate_photon = [
  'js/js/Photon/tabs.js',
  'js/js/Photon/segment.js',
  'js/js/Photon/frame-list.js',
  'js/js/Photon/dialog.js',
  'js/js/Photon/range.js',
  'js/js/Photon/progress-circle.js',
  'js/js/Photon/circular-slider.js',
  'js/js/Photon/pane-size.js',
  'js/js/Photon/input.js'
];


/**
** FUNÇÕES
**/

gulp.task('Photon_producao', function(cb){
  // Função compila o Photon.JS SEM Map para produção
  return gulp.src(contate_photon)
    .pipe(uglify())
    .pipe(rename('photon.min.js'))
    .pipe(gulp.dest('js'))
    .on('error', function(err) {
        notify().write(err);
        this.emit('end');
    })
    .pipe(notify({ title:projeto+' - Produção', message: msg }));
});

gulp.task('Photon', function(cb){
  // Função compila o jQuery.JS com Map para Debugar
  return gulp.src(contate_photon)
    .pipe(sourcemaps.init())
    .pipe(rename('photon.min.js'))
    .pipe(sourcemaps.write('./map'))
    .pipe(gulp.dest('js'))
    .on('error', function(err) {
        notify().write(err);
        this.emit('end');
    })
    .pipe(notify({ title:projeto+' - Desenvolvimento', message: msg }));
});

gulp.task('scss_producao', function(){
  // Função compila o SCSS SEM Map para produção
  var sassFiles = 'css/scss/main.scss',
      cssDest = 'css';
    gulp.src(sassFiles)
      .pipe(rename('site.min.css'))
      .pipe(sass({outputStyle: 'compressed'}))
      .pipe(gulp.dest(cssDest))
      .pipe(sass({ errLogToConsole: false, }))
      .on('error', function(err) {
          notify().write(err);
          this.emit('end');
      })
      .pipe(notify({ title:projeto+' - Produção', message: msg }));
});

gulp.task('scss', function(){
  // Função compila o SCSS com Map para Debugar
  var sassFiles = 'css/scss/main.scss',
      cssDest = 'css';
    gulp.src(sassFiles)
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compiled'}))
      .pipe(rename('site.min.css'))
      .pipe(sourcemaps.write('./map'))
      .pipe(gulp.dest(cssDest))
      .on('error', function(err) {
          notify().write(err);
          this.emit('end');
      })
      .pipe(notify({ title:projeto+' - Desenvolvimento', message: msg }));
});


/**
** - ESCUTAS -
**
** COMANDOS:
** gulp           -- compila JS e SCSS para desenvolvimento, ambos com map (gera arquivo .min.css/js)
** gulp producao  -- compila JS e CSS para producao, ambos sem map (gera arquivo .min.css/js)
** gulp js        -- compila somente JS para desenvolvimento, com map (gera arquivo .min.js)
** gulp css       -- compila somente SCSS para desenvolvimento, com map (gera arquivo .min.css)
**/
gulp.task('default', function() {
    gulp.watch(['css/scss/**/*.scss'],['scss']);
    gulp.watch('js/js/Photon/*.js', ['Photon']);
});

gulp.task('css', function() {
    gulp.watch('css/scss/**/*.scss',['scss']);
});

gulp.task('js', function() {
  gulp.watch('js/js/Photon/*.js', ['Photon']);
});

gulp.task('producao', function() {
  gulp.watch('css/scss/**/*.scss',['scss_producao']);
  gulp.watch('js/js/Photon/*.js', ['Photon']);
});