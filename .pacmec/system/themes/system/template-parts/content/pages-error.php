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
<style>
@import 'https://fonts.googleapis.com/css?family=VT323';

$light-grey: #e0e2f4;
$grey: #aaaaaa;
$blue: #0414a7;

$base-font-size: 20px;
$font-stack: 'VT323', monospace;

body,
h1,
h2,
h3,
h4,
p,
a { color: $light-grey; }

body,
p { font: normal #{$base-font-size}/1.25rem $font-stack; }
h1 { font: normal 2.75rem/1.05em $font-stack; }
h2 { font: normal 2.25rem/1.25em $font-stack; }
h3 { font: lighter 1.5rem/1.25em $font-stack; }
h4 { font: lighter 1.125rem/1.2222222em $font-stack; }

body { background: $blue; }

.container {
  width: 90%;
  margin: auto;
  max-width: 640px;
}

.bsod {
  padding-top: 10%;

  .neg {
    text-align: center;
    color: $blue;

    .bg {
      background: $grey;
      padding: 0 15px 2px 13px;
    }
  }
  .title { margin-bottom: 50px; }
  .nav {
    margin-top: 35px;
    text-align: center;

    .link {
      text-decoration: none;
      padding: 0 9px 2px 8px;

      &:hover,
      &:focus {
        background: $grey;
        color: $blue;
      }
    }
  }
}
</style>

<main class="bsod container">
  <h1 class="neg title"><span class="bg">Error - 404</span></h1>
  <p>An error has occured, to continue:</p>
  <p>* Return to our homepage.<br />
  * Send us an e-mail about this error and try later.</p>
  <nav class="nav">
    <a href="#" class="link">index</a>&nbsp;|&nbsp;<a href="#" class="link">webmaster</a>
  </nav>
</main>
