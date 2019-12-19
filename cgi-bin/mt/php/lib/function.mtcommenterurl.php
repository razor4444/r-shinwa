<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: function.mtcommenterurl.php 3455 2009-02-23 02:29:31Z auno $

function smarty_function_mtcommenterurl($args, &$ctx) {
    $comment = $ctx->stash('comment');
    if (!$comment) return '';
    $cmntr = $ctx->stash('commenter');
    if (!$cmntr) return '';
    return $cmntr['author_url'];
}
?>
