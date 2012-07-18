<?php
function smarty_function_mtclearcookie ( $args, &$ctx ) {
    $reload = $args[ 'reload' ];
    $name   = $args[ 'name' ];
    $cookie_val = $_COOKIE[ $name ];
    $value  = '';
    $path   = $args[ 'path' ];
    if (! $path ) {
        $path = '/';
    }
    $domain = $args[ 'domain' ];
    $expires = time() - 3600;
    $secure  = $args[ 'secure' ];
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