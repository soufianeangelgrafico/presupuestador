"use strict";

// Load plugins
const browsersync = require("browser-sync").create();
const del = require("del");
const gulp = require("gulp");
const merge = require("merge-stream");

// BrowserSync
function browserSync(done) {
  browsersync.init({
    server: {
      baseDir: "./"
    },
    port: 3000
  });
  done();
}

// BrowserSync reload
function browserSyncReload(done) {
  browsersync.reload();
  done();
}

// Clean vendor
function clean() {
  return del(["./vendor/"]);
}

// Bring third party dependencies from node_modules into vendor directory
function modules() {
  // Bootstrap
  var bootstrap = gulp.src('./node_modules/bootstrap/dist/**/*')
    .pipe(gulp.dest('./vendor/bootstrap'));
  // jQuery
  var jquery = gulp.src([
      './node_modules/jquery/dist/*',
      '!./node_modules/jquery/dist/core.js'
    ])
    .pipe(gulp.dest('./vendor/jquery'));
  return merge(bootstrap, jquery);
}

// Watch files
function watchFiles() {
  gulp.watch("./**/*.css", browserSyncReload);
  gulp.watch("./**/*.html", browserSyncReload);
}

// Define complex tasks
const vendor = gulp.series(clean, modules);
const build = gulp.series(vendor);
const watch = gulp.series(build, gulp.parallel(watchFiles, browserSync));

// Export tasks
exports.clean = clean;
exports.vendor = vendor;
exports.build = build;
exports.watch = watch;
exports.default = build;

/*//zra9: ES 🇪🇸 => Resumen del código 
 * La primera línea "use strict"; es una directiva que indica al navegador para ejecutar el código en "modo estricto" lo que obliga a seguir ciertas reglas y buenas prácticas en el código, con el fin de evitar errores y mejorar su rendimiento.
 * A continuación, se cargan los módulos/ complementos necesarios para hacer uso de sus funcionalidades facilitando la creación de tareas en las siguientes líneas de código:
 * browser-sync (automatización de desarrollo y pruebas locales)
 * del(eliminar archivos y directorios)
 * gulp (realizar diferentes tareas de forma automática)
 * merge-stream (fusionar varias corrientes).
 * Luego, se definen las funciones browserSync, browserSyncReload,clean, modules, y watchFiles. La funcion browserSync() inicializa el paquete browsersync con configuraciones específicas, mientras que browserSyncReload() vuelve a cargar el navegador cuando hay algún cambio en el código.
 * La función clean() elimina determinados directorios del proyecto y modules() trae las dependencias de terceros desde node_modules y las guarda en el directorio vendor/ del proyecto.
 * La tarea compleja vendor corresponde a una serie de tareas: limpiar el directorio vendor y, a continuación, traer las dependencias a él. Otro conjunto de tareas llamado build se encargará de crear todo el proyecto llamando la tarea vendor.
 * En resumen, las tareas principales son:
 * clean: limpia el archivo almacenado en el directorio vendor.
 * vendor: agrega todas las dependencias del proyecto.
 * build: crea todo el proyecto.
 * watch: observa los cambios en los archivos y actualiza automáticamente en la pantalla.
 * Por último, se exportan cada una de estas tareas especificándolas como objetos dentro del método exports para poder acceder a ellas desde otro lugar del código.
 *******************************************************************************************************************/