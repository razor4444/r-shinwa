# Movable Type (r) (C) 2007-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id$

package Motion::Tags;

use strict;

# TBD:
# sub motion_type_filter {
#     my ($ctx, $args, $cond) = @_;
# 
#     # validate motion_type
#     defined(my $type = $args->{motion_type}) or return;
#     MT->model('motion_' . $type) or return;
# 
#     # adjust join arguments in context; if we supported multiple
#     # joins, we would adjust "joins" key
#     push @{ $ctx->{join} ||= [] }, {
#         to => MT::Entry->meta_pkg,
#         terms => {
#             entry_id => \'= entry_id',
#             type => 'motion_type',
#             vchar_idx => $type
#         }
#     };
# }
# 
# sub featured_filter {
#     my ($ctx, $args, $cond) = @_;
# 
#     # validate motion_type
#     defined(my $featured = $args->{featured}) or return;
# 
#     # adjust join arguments in context; if we supported multiple
#     # joins, we would adjust "joins" key
#     push @{ $ctx->{joins} ||= [] }, {
#         to => MT::Entry->meta_pkg,
#         terms => {
#             entry_id => \'= entry_id',
#             type => 'featured',
#             vinteger_idx => $featured ? 1 : [ undef, 0 ],
#         },
#         args => {
#             ( $featured ? () : ( join_type => 'left outer' ) ),
#         },
#     };
# }

# sub entry_meta {
#     my ($ctx, $args, $cond) = @_;
#     my $e = $ctx->stash('entry') or return '';
#     my $m = $args->{name} or return '';
#     my $v = '';
#     if ($e->is_meta_column($m)) {
#         $v = $e->meta($m);
#         $v = '' unless defined $v;
#     }
#     return $v;
# }

1;
