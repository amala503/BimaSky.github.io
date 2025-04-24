<?php

function register_handlebars_helpers($handlebars) {
    $handlebars->addHelper('format_number', function($number) {
        return number_format($number, 0, ',', '.');
    });
}