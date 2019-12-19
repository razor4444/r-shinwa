<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: modifier.sanitize.php 3455 2009-02-23 02:29:31Z auno $

function smarty_modifier_sanitize($text, $spec = '1') {
    if ($spec == '1') {
        global $mt;
        $ctx =& $mt->context();
        $blog = $ctx->stash('blog');
        $spec = $blog['blog_sanitize_spec'];
        $spec or $spec = $mt->config('GlobalSanitizeSpec');
    }
    require_once("sanitize_lib.php");
    return sanitize($text, $spec);
}
?>
