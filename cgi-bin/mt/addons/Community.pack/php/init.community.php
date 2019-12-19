<?php
# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: init.community.php 116787 2009-12-16 06:00:51Z auno $

global $mt;

if ( isset( $mt->db ) )
    array_push( $mt->db->object_meta['blog'], 'allow_anon_recommend:vinteger' );
?>
