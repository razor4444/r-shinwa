# Movable Type (r) (C) 2007-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: Comments.pm 116787 2009-12-16 06:00:51Z auno $
package CustomFields::App::Comments;

use strict;
use CustomFields::Util qw( field_loop );

sub signup_param {
    my ($cb, $app, $param, $tmpl) = @_;
    my %param = (
        object_type => 'author',
        simple      => 1,
    );
    $param->{field_loop} = field_loop(%param);
}

sub profile_param {
    my ($cb, $app, $param, $tmpl) = @_;
    return unless $app->user;
    my %param = (
        object_type => 'author',
        object_id   => $app->user->id,
        simple      => 1,
    );
    $param->{field_loop} = field_loop(%param);
}

1;
