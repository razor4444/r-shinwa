# Movable Type (r) (C) 2007-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: Blog.pm 116787 2009-12-16 06:00:51Z auno $

package MT::Community::Blog;

use strict;
use base qw( MT::Blog );

__PACKAGE__->install_properties({
    column_defs => {
        'allow_anon_recommend' => 'integer meta',
        'upload_path'          => 'string meta',
    },
});

1;
