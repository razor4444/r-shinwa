# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: WordPress.pm 3455 2009-02-23 02:29:31Z auno $

package MT::Auth::WordPress;

use strict;
use base qw( MT::Auth::OpenID );

sub url_for_userid {
    my $class = shift;
    my ($uid) = @_;
    return "http://$uid.wordpress.com/";
}

sub get_nickname {
    my $class = shift;
    my ($vident) = @_;

    my $url = $vident->url;
    if ( $url =~ m(^https?://([^\.]+)\.wordpress\.com\/$) ) {
        return $1;
    }
    return $class->SUPER::get_nickname(@_);
}

1;
