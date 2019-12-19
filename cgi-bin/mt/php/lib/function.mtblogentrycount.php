<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: function.mtblogentrycount.php 3455 2009-02-23 02:29:31Z auno $

function smarty_function_mtblogentrycount($args, &$ctx) {
    // status: complete
    // parameters: none
    $args['blog_id'] = $ctx->stash('blog_id');
    $count = $ctx->mt->db->blog_entry_count($args);
    return $ctx->count_format($count, $args);
}
