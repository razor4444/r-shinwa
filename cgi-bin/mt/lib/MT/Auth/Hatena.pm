# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: Vox.pm 1174 2008-01-08 21:02:50Z bchoate $

package MT::Auth::Hatena;
use strict;

use base qw( MT::Auth::OpenID );

sub url_for_userid {
    my $class = shift;
    my ($uid) = @_;
    
    return "http://www.hatena.ne.jp/$uid/";
}

sub get_nickname {
    my $class = shift;
    my ($vident) = @_;

    my $url = $vident->url;
    if ( $url =~ m(^http://www\.hatena\.ne\.jp\/([^\.]+)/$) ) {
        return $1;
    }
    return $class->SUPER::get_nickname(@_);
}

1;
