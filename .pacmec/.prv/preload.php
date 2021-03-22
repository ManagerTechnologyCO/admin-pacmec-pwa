<?php
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * ******************************/

define("PACMEC_ARRAY_DAYS_FMA", [
  "Friday",
  "Monday",
  "Saturday",
  "Sunday",
  "Thursday",
  "Tuesday",
  "Wednesday",
]);

define("PACMEC_ARRAY_DAYS_FMI", [
  "friday",
  "monday",
  "saturday",
  "sunday",
  "thursday",
  "tuesday",
  "wednesday",
]);

define("PACMEC_ARRAY_DAYS_SLIM", [
  "fri",
  "mon",
  "sat",
  "sun",
  "thu",
  "tue",
  "wed",
]);

define("PACMEC_ARRAY_DAYS_MIN", [
  "d",
  "l",
  "m",
  "w",
  "j",
  "v",
  "s",
]);


define("PACMEC_ARRAY_DAYS_SCHEDULE", [
  [
    "label" => "Friday",
    "min"   => "fri"
  ],
  [
    "label" => "Monday",
    "min"   => "fri"
  ],
  [
    "label" => "Saturday",
    "min"   => "fri"
  ],
  [
    "label" => "Sunday",
    "min"   => "fri"
  ],
  [
    "label" => "Thursday",
    "min"   => "fri"
  ],
  [
    "label" => "Tuesday",
    "min"   => "fri"
  ],
  [
    "label" => "Wednesday",
    "min"   => "fri"
  ]
]);


// SANEAMENTO DE DATOS ENTRANTES 1. TRATO A LOS DATOS
// POST JSON
if($_SERVER['REQUEST_METHOD'] == 'POST' && retrieveJsonPostData() !== null){
  $data_post = retrieveJsonPostData();
  foreach ($data_post as $key => $value) {
    $_POST[$key] = $value;
  }
}
