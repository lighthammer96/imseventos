<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

// referencia: https://laracasts.com/discuss/channels/laravel/determining-if-a-translation-in-specific-locale-exists

function traducir($valor){
    App::setLocale("es");
    // dd(Lang::hasForLocale('traductor.item', 'es'));
    // if(Lang::has($valor)) {
    if(Lang::hasForLocale($valor, "es")) {
        return trans($valor);
    } else {
        App::setLocale("es");
        return trans($valor);
    }
}


// referencia: https://github.com/laravel/framework/commit/3c4ec8112daee69bd50c5a5fa174642924a151ea
?>
