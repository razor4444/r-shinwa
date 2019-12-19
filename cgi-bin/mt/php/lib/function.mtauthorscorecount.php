<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: function.mtauthorscorecount.php 3455 2009-02-23 02:29:31Z auno $

require_once('rating_lib.php');

function smarty_function_mtauthorscorecount($args, &$ctx) {
    $count = hdlr_score_count($ctx, 'author', $args['namespace']);
    return $ctx->count_format($count, $args);
}
