<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id$

function smarty_block_mtifanonymousrecommendallowed($args, $content, &$ctx, &$repeat) {
    # status: complete
    if (!isset($content)) {
        $blog = $ctx->stash('blog');
        if (!isset($blog)) {
            return $ctx->_hdlr_if($args, $content, $ctx, $repeat, 0);
        }
        if (array_key_exists('blog_allow_anon_recommend', $blog))
            $allowed = $blog['blog_allow_anon_recommend'] == 1 ? 1 : 0;
        else 
            $allowed = 0;
        return $ctx->_hdlr_if($args, $content, $ctx, $repeat, $allowed);
    } else {
        return $ctx->_hdlr_if($args, $content, $ctx, $repeat);
    }
}
?>
