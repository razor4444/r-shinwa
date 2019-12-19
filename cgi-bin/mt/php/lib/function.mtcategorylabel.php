<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: function.mtcategorylabel.php 3455 2009-02-23 02:29:31Z auno $

function smarty_function_mtcategorylabel($args, &$ctx) {
    $cat = $ctx->stash('category');
    if (!$cat) {
        if ($e = $ctx->stash('entry')) {
            if ($cat_id = $e['placement_category_id']) {
                $cat = $ctx->mt->db->fetch_category($cat_id);
            }
        }
    }
    if (!$cat) return '';
    return $cat['category_label'];
}
