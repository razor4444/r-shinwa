<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: function.mtproductname.php 3455 2009-02-23 02:29:31Z auno $

function smarty_function_mtproductname($args, &$ctx) {
    $short_name = PRODUCT_NAME;
    if ($args['version']) {
        return $ctx->mt->translate("[_1] [_2]", array($short_name, VERSION_ID));
    } else {
        return $short_name;
    }
}
?>
