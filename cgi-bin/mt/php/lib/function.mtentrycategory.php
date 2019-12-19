<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: function.mtentrycategory.php 3455 2009-02-23 02:29:31Z auno $

function smarty_function_mtentrycategory($args, &$ctx) {
    $entry = $ctx->stash('entry');
    if ($entry['placement_category_id']) {
        $cat = $ctx->mt->db->fetch_category($entry['placement_category_id']);
        if ($cat) {
            return $cat['category_label'];
        }
    }
    return '';
}
?>
