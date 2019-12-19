<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: modifier.encode_url.php 3455 2009-02-23 02:29:31Z auno $

function smarty_modifier_encode_url($text) {
    $text = urlencode($text);
    $text = preg_replace('/\+/', '%20', $text);
    return $text;
}
?>
