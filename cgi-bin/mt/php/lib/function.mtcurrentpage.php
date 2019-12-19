<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: function.mtcurrentpage.php 3455 2009-02-23 02:29:31Z auno $

function smarty_function_mtcurrentpage($args, &$ctx) {
    $limit = $ctx->stash('__pager_limit');
    $offset = $ctx->stash('__pager_offset');
    return $limit ? $offset / $limit + 1 : 1;
}
?>

