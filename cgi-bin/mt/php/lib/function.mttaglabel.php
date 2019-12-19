<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: function.mttaglabel.php 3455 2009-02-23 02:29:31Z auno $

require_once('function.mttagname.php');
function smarty_function_mttaglabel($args, &$ctx) {
    return smarty_function_mttagname($args, $ctx);
}
?>
