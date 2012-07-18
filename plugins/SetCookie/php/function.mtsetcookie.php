<?php
function smarty_function_mtsetcookie ( $args, &$ctx ) {
    $reload = $args[ 'reload' ];
    $name   = $args[ 'name' ];
    $cookie_val = $_COOKIE[ $name ];
    $value  = $args[ 'value' ];
    $path   = $args[ 'path' ];
    if (! $path ) {
        $path = '/';
    }
    $domain = $args[ 'domain' ];
    $expires = $args[ 'expires' ];
    if ( $expires ) {
        $expires += time();
    } else {
        $expires = 0;
    }
    $secure = $args[ 'secure' ];
    if ( $secure ) {
        $secure = TRUE;
    }
    if ( setcookie( $name, $value, $expire, $path, $domain, $secure ) ) {
        if ( $cookie_val != $value ) {
            if ( $reload ) {
                $app = $ctx->stash( 'bootstrapper' );
                $return_url = $app->base() . $app->request;
                if ( $query_string = $app->query_string() ) {
                    $return_url .= '?' . $query_string;
                }
                header( 'Location: ' . $return_url );
            }
        }
    }
}
?>