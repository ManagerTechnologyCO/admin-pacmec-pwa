<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Themes
 * @category   Townhub
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 */
?>
<!DOCTYPE HTML>
<html <?= language_attributes(); ?>>
   <head>
       <meta charset="<?= pageinfo( 'charset' ); ?>" />
       <title><?= pageinfo( 'title' ); ?></title>
       <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
       <meta name="robots" content="index, follow"/>
       <meta name="keywords" content=""/>
       <meta name="description" content=""/>
       <?php pacmec_head(); ?>
       <!--//<link rel="shortcut icon" href="images/favicon.ico">-->
       <script>
        window.addEventListener('load', () => {
          $(".loader-wrap").fadeOut(300, function () {
              $("#main").animate({
                  opacity: "1"
              }, 600);
          });
        });
       </script>
   </head>
   <body>
       <div class="loader-wrap">
           <div class="loader-inner">
               <div class="loader-inner-cirle"></div>
           </div>
       </div>
       <div id="main">
        <?php get_template_part('template-parts/header/site-header'); ?>
