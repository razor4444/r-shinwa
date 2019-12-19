<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: modifier.spam_protect.php 3455 2009-02-23 02:29:31Z auno $

function smarty_modifier_spam_protect($text, $value) {
    # defined in mt.php itself
    if (isset($value) && $value) {
        return spam_protect($text);
    } else {
        return $text;
    }
}
?>
