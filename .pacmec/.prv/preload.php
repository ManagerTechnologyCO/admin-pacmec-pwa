<?php
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * ******************************/
// SANEAMENTO DE DATOS ENTRANTES 1. TRATO A LOS DATOS

// POST JSON
if($_SERVER['REQUEST_METHOD'] == 'POST' && retrieveJsonPostData() !== null){
  $data_post = retrieveJsonPostData();
  foreach ($data_post as $key => $value) {
    $_POST[$key] = $value;
  }
}
