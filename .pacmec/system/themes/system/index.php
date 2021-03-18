<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Themes
 * @category   System
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 */
get_header();
if(route_active())
{ get_template_part( 'template-parts/content/'.$GLOBALS['PACMEC']['route']->component ); }
else
{ get_template_part( 'template-parts/content/content-error' ); }
get_footer();
