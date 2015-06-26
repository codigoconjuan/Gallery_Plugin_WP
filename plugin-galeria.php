<?php
/*
Plugin Name: Galeria Ayuntamiento de Guadalajara
Description: Plugin Para Galeria
Version:     1.0
Author:      Juan Pablo De la torre Valdez
Author URI:
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


/** estilos y scripts **/
function galleria_scripts() {
    wp_enqueue_style( 'colorbox-css', plugins_url( 'assets/colorbox.css', __FILE__ ) );
    wp_enqueue_style( 'colorbox-css' );

    wp_enqueue_style( 'estilos', plugins_url( 'assets/estilos.css', __FILE__ ) );
    wp_enqueue_style( 'estilos' );

		wp_enqueue_script( 'colorbox-js', plugins_url( 'assets/jquery.colorbox-min.js', __FILE__ ), array('jquery'), '20151020', false );

    	wp_enqueue_script( 'fitvids-js', plugins_url( 'assets/fitvids.js', __FILE__ ), array('jquery'), '20151020', false );
}
add_action( 'wp_enqueue_scripts', 'galleria_scripts' );

/** COLORBOX CON JQUERY **/
function colorbox_start() {
    if (is_single()) { ?>
        <script type="text/javascript">
          (function() {
               jQuery(".galeria").colorbox();

               jQuery('#video-noticia').fitVids();
          }());
      		</script>
    <?php  }
 }
add_action( 'wp_footer', 'colorbox_start' );

/** AGREGAR LOS CAMPOS**/
require_once plugin_dir_path( __FILE__ ) . '/fields.php';

/** HOOK / AGREGAR EN EL TEMPLATE galeria_noticias(); **/
function galeria_noticias() {
    do_action('galeria_noticias');
}

/** HOOK VIDEO / AGREGAR EN EL TEMPLATE video_noticias(); **/
function video_noticias() {
    do_action('video_noticias');
}

/** TEMPLATE DE GALERIA QUE SE AGREGARÁ AL HOOK **/
function template_galeria() {
   $fotografias =  get_post_meta( get_the_ID(), '_galeria_ayto_gdlfile_list', true );  ?>
   <?php if (!empty($fotografias)) { ?>

   <div class="galeria-noticias">
    <h2 class="galeria">Galería</h2>
        <?php foreach ($fotografias as $key => $foto) { ?>

            <?php $enlace_imagen_chica = wp_get_attachment_image_src( $key, 'imagen-miniatura' ); ?>
            <?php $enlace_imagen_grande = wp_get_attachment_image_src( $key, 'full' ); ?>

            <?php $imagenChica =  $enlace_imagen_chica[0]; ?>
            <?php $imagenGrande =  $enlace_imagen_grande[0] ?>

                <a class="galeria" href="<?php echo $imagenGrande; ?>" title="">
                     <img src="<?php echo $imagenChica;  ?>" alt="" />
                </a>
        <?php  } ?>
  </div>
    <?php } // fin de !empty ?>
  <?php
} // fin function template_galeria
add_action('galeria_noticias','template_galeria');


/****TEMPLATE DE VIDEO QUE SE AGREGARÁ AL HOOK **/

function template_video() { ?>

      <?php $url = esc_url( get_post_meta( get_the_ID(), '_video_youtube', 1 ) ); ?>
         <?php if (!empty($url)) { ?>
           <div class="video-noticia">
                  <h2 class="video">Video</h2>
                  <div id="video-noticia">
                      <?php echo wp_oembed_get( $url ); ?>
                  </div>
          </div>
         <?php } //fin de if ?>

<?php } // fin template_video

add_action('video_noticias', 'template_video');
