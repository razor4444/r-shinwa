<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: block.mtentrieswithsubcategories.php 3455 2009-02-23 02:29:31Z auno $

function smarty_block_mtentrieswithsubcategories($args, $content, &$ctx, &$repeat) {
    $localvars = array('entries');
    if (!isset($content)) {
        $cat = $args['category'];
        if (!$cat) {
            $cat = $ctx->stash('category');
            if (isset($cat))
                $args['category'] = $cat['category_label'];
        }
        $args['include_subcategories'] = 1;
        $ctx->localize($localvars);
        $ctx->stash('entries', null);
        require_once("block.mtentries.php");
    }
    $output = smarty_block_mtentries($args, $content, $ctx, $repeat);
    if (!$repeat)
        $ctx->restore($localvars);
    return $output;
}
?>
