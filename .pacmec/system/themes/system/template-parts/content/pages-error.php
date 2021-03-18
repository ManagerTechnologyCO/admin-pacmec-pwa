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

<div class="noise"></div>
<div class="overlay"></div>
<div class="terminal">
  <h1><?= pageinfo("title"); ?> <span class="errorcode"> <?= (pageinfo("id") == -1) ? "404" : "9999"; ?></span></h1>
  <p class="output"><?= pageinfo("description"); ?></p>
  <p class="output">Please try to <a href="#1">go back</a> or <a href="#2">return to the homepage</a>.</p>
  <p class="output">Good luck.</p>
</div>
