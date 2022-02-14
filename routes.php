<?php

/** @var Array $routes */
/// //set up routes. regex => function name. Can include other files. classes are bloated in this ideology and are forced in a lot of frameworks
////by coders who have no understanding of web logic, only oop
$routes = [
    ';^/booger/?$;' => 'Booger',
    ';^/booger/([^/]+)/?$;' => 'Boogers',
    ';^/booger/([^/]+)/?([^/]+)/?$;' => 'BoogersOverloaded'
];
