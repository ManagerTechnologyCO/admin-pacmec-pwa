<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Themes
 * @category   Panel club
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 */
#get_header();
/*
 if(route_active())
 { get_template_part( 'template-parts/content/'.$GLOBALS['PACMEC']['route']->component ); }
 else
 { get_template_part( 'template-parts/content/content-error' ); }
*/
#get_footer();
?>
<!doctype html>
<html <?= language_attributes(); ?>>
  <head>
    <meta charset="<?= pageinfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" charset="UTF-8" href="https://admin.pacmec.managertechnology.com.co/.pacmec/themes/townhub/assets/css/style-club.css" ordering="0.8"/>
    <?php pacmec_head(); ?>
    <title><?= pageinfo( 'title' ); ?></title>
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      .box-widget-author-title_opt:before {
        background-color: #212529;
        background: #212529;
      }
      .list-author-widget-contacts {
        margin-top: 5px;
        padding-bottom: 5px;
        border-bottom: none;
      }
      .no-list-style {
        padding-left: 0px;
      }
      .flex-shrink-0 {
        padding: 0 10px;
      }
    </style>
  </head>
  <body>
    <div id="main-app">
      <header class="py-3 mb-3 border-bottom">
        <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center col-lg-4 mb-2 mb-lg-0 link-dark text-decoration-none dropdown-toggle" id="dropdownNavLink" data-bs-toggle="dropdown" aria-expanded="false">
              <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/>
                <svg id="bootstrap" viewBox="0 0 118 94">
                  <title>Bootstrap</title>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"></path>
                </svg>
              </svg>
            </a>
            <pacmec-menu-api v-if="definition!==null" :subjects="definition.tags"></pacmec-menu-api>
          </div>

          <div class="d-flex align-items-center">
            <form class="w-100 me-3">
              <!--//
                <div class="input-group">
                  <input type="text" class="form-control" aria-label="Text input with segmented dropdown button">
                  <button type="button" class="btn btn-outline-secondary">Action</button>
                  <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                  </ul>
                </div>
              -->
            </form>

            <div class="flex-shrink-0 dropdown">
              <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                {{lang}}
              </a>
              <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li v-for="(gl, gl_i) in glossary">
                  <a class="dropdown-item" @click="lang=gl.tag">
                    {{gl.name}}
                  </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" @click="logout">{{translateField('logout')}}</a></li>
              </ul>
            </div>

            <!--//
            <div class="flex-shrink-0 dropdown">
              <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
              </a>
              <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
              </ul>
            </div>
            -->
          </div>
        </div>
      </header>

      <main class="container-fluid pb-3">
        <router-view :key="$route.fullPath" v-if="definition!==null" :definition="definition"></router-view>
      </main>

      <footer>
        <!-- // <p>{{options}}</p> -->
      </footer>
    </div>
    <?php get_footer(); ?>
