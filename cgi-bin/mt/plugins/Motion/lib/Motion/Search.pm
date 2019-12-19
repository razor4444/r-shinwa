# Movable Type (r) (C) 2007-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id$

package Motion::Search;

use strict;

sub process {
    my $app = shift;
    return $app->errtrans('This module works with MT::App::Search.')
        unless $app->isa('MT::App::Search');

    my ( $count, $out ) = $app->check_cache();
    if ( defined $out ) {
        $app->run_callbacks( 'search_cache_hit', $count, $out );
        return $out;
    }

    return $app->errtrans(
      'Specify the blog_id of a blog that has Motion template set.')
        unless $app->param('blog_id');

    $out = render( $app, $count );
    return unless $out;

    my $result;
    if (ref($out) && ($out->isa('MT::Template'))) {
        defined( $result = $out->build() )
            or return $app->error($out->errstr);
    }
    else {
        $result = $out;
    }

    $count = $out->context()->stash('number_of_events');

    $app->run_callbacks( 'search_post_render', $app, $count, $result );

    my $cache_driver = $app->{cache_driver};
    $cache_driver->set( $app->{cache_keys}{count},
        $count, $app->config->SearchCacheTTL );

    $result;
}

sub render {
    my $app = shift;
    my ( $count ) = @_;

    use MT::Entry;
    my $blog_id = $app->param('blog_id');
    $blog_id =~ s/\D//g;
    my $blog = $app->model('blog')->load( $blog_id )
        or return $app->errtrans('Invalid blog');
    require MT::Template::Context;
    my $ctx = MT::Template::Context->new;
    $ctx->stash('blog', $blog);
    $ctx->stash('blog_id', $blog_id);
    $ctx->stash('local_blog_id', $blog_id);
    $ctx->stash('count', $count) if defined $count;
    my $vars = $ctx->{__stash}{vars} ||= {};
    $vars->{this_blogid} = $blog_id;

    my $tmpl_class = $app->model('template');
    my $tmpl = $tmpl_class->load(
        { blog_id => $blog_id, identifier => 'widget_main_column_actions', type => 'widget' },
    );

    return $app->errtrans('Error loading template: [_1]', 'actions')
        unless $tmpl;

    $tmpl->context( $ctx );

    return $tmpl;
}

1;
__END__
