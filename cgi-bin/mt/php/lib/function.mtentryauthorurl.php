<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: function.mtentryauthorurl.php 3455 2009-02-23 02:29:31Z auno $

function smarty_function_mtentryauthorurl($args, &$ctx) {
    $entry = $ctx->stash('entry');
    return $entry['author_url'];
}
?>
