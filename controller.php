<?php
//An example controller. If the application expands out then you can use this file to include your controllers
//instead of writing them here. Called from the route file (index.php)


function Boogers($matches)
{
    echo "I flick several booger at you, one named {$matches[1]} from" . $_SERVER['REQUEST_URI'];

}

function Booger($matches)
{

    echo "I flick a booger at you from " . $_SERVER['REQUEST_URI'];
}

function BoogersOverloaded($matches)
{
    echo "I flick several booger at you, one named {$matches[1]} who is under {$matches[2]} from" . $_SERVER['REQUEST_URI'];
}
