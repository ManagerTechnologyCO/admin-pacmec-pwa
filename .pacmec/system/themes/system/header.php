<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Themes
 * @category   System
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 */
?>
<!DOCTYPE html>
<html <?= language_attributes(); ?>>
  <head>
    <meta charset="<?= pageinfo( 'charset' ); ?>" />
    <title><?= pageinfo( 'title' ); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php pacmec_head(); ?>
  </head>
  <body>
    <?php
    if(pageinfo("component") !== 'pages-error')
    {
      get_template_part( 'template-parts/header/site-header' );
    }
    ?>
