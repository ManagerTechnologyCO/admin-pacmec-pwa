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

if(!isStaff()){
  header("Location: ".infosite('siteurl').infosite('homeurl'));
}
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
      .logo-holder {
        width: 25px;
      }
    </style>
  </head>
  <body>
    <div id="main-app">
      <header class="py-3 mb-3 border-bottom">
        <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center col-lg-4 mb-2 mb-lg-0 link-dark text-decoration-none dropdown-toggle" id="dropdownNavLink" data-bs-toggle="dropdown" aria-expanded="false">
              <?= (siteinfo('site_logo') !== 'NaN') ? "<img class=\"bi me-2\" width=\"40\" height=\"32\" src=\"".siteinfo('site_logo')."\" />" : siteinfo('sitename'); ?>
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


      <main class="container-fluid pb-3" v-if="definition!==null">
        <h1 v-if="glossary==null" class="h3 mb-3 fw-normal"><?= _autoT('loading'); ?></h1>
        <router-view v-else :key="$route.fullPath" :definition="definition"></router-view>
      </main>

      <!--//
        <main class="form-signin" v-else>
          <form action="javascript:return;" v-on:submit="login">
            <h1 class="h3 mb-3 fw-normal"><?= _autoT('signin'); ?></h1>
            <div class="form-floating">
              <input type="text" class="form-control" id="floatingInput" placeholder="<?= _autoT('username'); ?>" v-model="forms.login.username" required="" />
              <label for="floatingInput"><?= _autoT('username'); ?></label>
            </div>
            <div class="form-floating">
              <input type="password" class="form-control" id="floatingPassword" placeholder="<?= _autoT('password'); ?>" v-model="forms.login.password" required="" />
              <label for="floatingPassword"><?= _autoT('password'); ?></label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit"><button class="w-100 btn btn-lg btn-primary" type="submit"><?= _autoT('signin'); ?></button></button>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
          </form>
        </main>
      -->

      <footer>
        <!-- // <p>{{options}}</p> -->
      </footer>
    </div>
    <?php get_footer(); ?>
