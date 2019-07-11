<?php
require 'includes/function.php';

//echo sendMail('Wonderful Subject', 'chayannick@hotmail.fr', 'kikou');

echo sendMail(  "coucou",
            ["chayannick@hotmail.fr", "y.chargueraud@hotmail.fr"],
            ["html" => "<a href=#>c'est trop cool</a>", "text"=> "c'est trop cool"]
          );