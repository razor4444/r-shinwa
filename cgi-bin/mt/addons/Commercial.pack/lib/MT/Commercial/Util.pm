# Movable Type (r) (C) 2007-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: Util.pm 116787 2009-12-16 06:00:51Z auno $

# Original Copyright (c) 2005-2007 Arvind Satyanarayan

package MT::Commercial::Util;

use strict;

sub init_request {
    my $cb = shift;
    my $plugin = $cb->plugin;
    my ($app) = @_;
    return if $app->id eq 'wizard';

    if (($app->mode || '') =~ /^stylecatcher_/) {
        my $r = $plugin->registry;
        my $path = $app->static_path;
        if ($path !~ m!^https?://!) {
            $path = $app->base . $path;
        }
        $path .= '/' unless $path =~ m!/$!;
        $r->{stylecatcher_libraries}{professional_themes}{url} = $path . 'addons/Commercial.pack/themes/professional.html';
    }
}

sub on_template_set_change {
    install_template_set_fields(@_);
    install_professional_default_content(@_);
}

sub install_template_set_fields {
    my ($cb, $param) = @_;
    my $blog = $param->{blog} or return;

    my $set_name = $blog->template_set or return;
    my $set = MT->app->registry('template_sets', $set_name)
        or return;
    my $fields = $set->{fields} or return;

    FIELD: while (my ($field_id, $field_data) = each %$fields) {
        next if UNIVERSAL::isa($field_data, 'MT::Component');  # plugin

        my %field = %$field_data;
        delete @field{qw( blog_id basename )};
        my $field_name = delete $field{label};
        $field_name = $field_name->() if 'CODE' eq ref $field_name;
        REQUIRED: for my $required (qw( obj_type tag )) {
            next REQUIRED if $field{$required};

            MT->log({
                level   => MT->model('log')->ERROR(),
                blog_id => $blog->id,
                message => MT->translate(
                    'Could not install custom field [_1]: field attribute [_2] is required',
                    $field_id, $required,
                ),
            });
            next FIELD;
        }

        # Does the blog have a field with this basename?
        my $field_obj = MT->model('field')->load({
            blog_id  => $blog->id,
            basename => $field_id,
            obj_type => $field_data->{obj_type} || q{},
        });

        if ($field_obj) {
            # Warn if the type is different.
            MT->log({
                level   => MT->model('log')->WARNING(),
                blog_id => $blog->id,
                message => MT->translate(
                    'Could not install custom field [_1] on blog [_2]: the blog already has a field [_1] with a conflicting type',
                    $field_id,
                ),
            }) if $field_obj->type ne $field_data->{type};
            next FIELD;
        }

        $field_obj = MT->model('field')->new;
        $field_obj->set_values({
            blog_id  => $blog->id,
            name     => $field_name,
            basename => $field_id,
            %field,
        });
        $field_obj->save() or die $field_obj->errstr();
    }
}

sub install_professional_default_content {
    my ($cb, $param) = @_;
    my $blog_template_set = $param->{blog}->template_set || '';
    return 1
        if 'professional_website' ne $blog_template_set;
    my $component = MT->component("Commercial");
    MT->log($component->translate("Blog [_1] using template set [_2]", $param->{blog}->name, $blog_template_set));
    require MT::Page;
    require MT::Folder;
    my ($page, $page2, $text);
    my $author = MT->instance->{author}->id;

    if (!(_page_exists_with_tag($param,'@about'))) {
        $page = MT::Page->new;
        $page->title($component->translate('About'));
        $page->blog_id($param->{blog}->id);
        $page->status(MT::Entry::RELEASE());
        $page->basename('index');
        $page->author_id($author);
        $text =
            $component->translate('_PTS_REPLACE_THIS')
          . $component->translate('_PTS_SAMPLE_ABOUT')
          . $component->translate('_PTS_EDIT_LINK');
        $page->text($text);
        $page->tags( '@about' );
        $page->allow_comments(0);
        $page->allow_pings(0);
        $page->save() or MT->log($component->translate("Could not create page: [_1]", $page->errstr));

        my $f = MT::Folder->new;
        $f->blog_id($param->{blog}->id);
        $f->label('About');
        $f->basename('about');
        $f->author_id($author);
        $f->save
            or die $f->errstr;
        _assign_folder($param->{blog}->id, $page->id, $f->id);
        MT->log($component->translate("Created page '[_1]'", $page->title()));
    }

    if (!(_page_exists_with_tag($param,'@contact'))) {
        $page = MT::Page->new;
        $page->title($component->translate('_PTS_CONTACT'));
        $page->blog_id($param->{blog}->id);
        $page->status(MT::Entry::RELEASE());
        $page->basename('index');
        $page->author_id($author);
        $text =
            $component->translate('_PTS_REPLACE_THIS')
          . $component->translate('_PTS_SAMPLE_CONTACT')
          . $component->translate('_PTS_EDIT_LINK');
        $page->text($text);
        $page->tags( '@contact' );
        $page->allow_comments(0);
        $page->allow_pings(0);
        $page->save() or MT->log($component->translate("Could not create page: [_1]", $page->errstr));

        my $f = MT::Folder->new;
        $f->blog_id($param->{blog}->id);
        $f->label('Contact');
        $f->basename('contact');
        $f->author_id($author);
        $f->save
            or die $f->errstr;
        _assign_folder($param->{blog}->id, $page->id, $f->id);
        MT->log($component->translate("Created page '[_1]'", $page->title()));
    }

    if (!(_page_exists_with_tag($param,'@home'))) {
        $page = MT::Page->new;
        $page->title($component->translate('Welcome to our new website!'));
        $page->blog_id($param->{blog}->id);
        $page->status(MT::Entry::RELEASE());
        $page->basename('homepage');
        $page->author_id($author);
        $text =
            $component->translate('_PTS_REPLACE_THIS')
          . $component->translate('_PTS_SAMPLE_WELCOME')
          . $component->translate('_PTS_EDIT_LINK');
        $page->text($text);
        $page->tags( '@home' );
        $page->allow_comments(0);
        $page->allow_pings(0);
        $page->save() or MT->log($component->translate("Could not create page: [_1]", $page->errstr));

        MT->log($component->translate("Created page '[_1]'", $page->title()));
    }
    require MT::Entry;
    if (MT::Entry->count({ blog_id => $param->{blog}->id }) == 0) {
        $page = MT::Entry->new;
        $page->title($component->translate('New design launched using Movable Type'));
        $page->blog_id($param->{blog}->id);
        $page->status(MT::Entry::RELEASE());
        $page->author_id($author);
        $text = $component->translate('_PTS_SAMPLE_NEWDESIGN');
        $page->text($text);
        $page->tags( 'awesome', 'design', 'movable type', 'professional' );
        $page->allow_comments(1);
        $page->allow_pings(0);
        $page->save() or MT->log($component->translate("Could not create entry: [_1]", $page->errstr));

        require MT::Comment;
        my $comment = MT::Comment->new;
        $comment->blog_id($page->blog_id);
        $comment->entry_id($page->id);
        $comment->author($component->translate('John Doe'));
        $comment->text($component->translate("Great new site. I can't wait to try Movable Type. Congrats!"));
        $comment->save
           or die $comment->errstr;

        MT->log($component->translate("Created entry and comment '[_1]'", $page->title()));
    }
}

sub _assign_folder {
    my ($blog_id, $entry_id, $category_id) = @_;

    require MT::Placement;
    my $place = MT::Placement->new;
    $place->entry_id($entry_id);
    $place->blog_id($blog_id);
    $place->category_id($category_id);
    $place->is_primary(1);
    $place->save
        or die $place->errstr;
    return 1;
}

sub _page_exists_with_tag {
    my ($param,$tag) = @_;

    my %terms = ( 
        'blog_id' => $param->{blog}->id,
        'class' => 'page',
    ); 
    my %args = ( 'lastn' => 1 );

    require MT::Tag;
    require MT::ObjectTag;
    my @tag_names = MT::Tag->split(',', $tag);
    my %tags = map { $_ => 1, MT::Tag->normalize($_) => 1 } @tag_names;
    my @tags = MT::Tag->load({ name => [ keys %tags ] });
    my @tag_ids;
    foreach (@tags) {
        push @tag_ids, $_->id;
        my @more = MT::Tag->load({ n8d_id => $_->n8d_id ? $_->n8d_id : $_->id });
        push @tag_ids, $_->id foreach @more;
    }
    @tag_ids = ( 0 ) unless @tags;
    $args{'join'} = ['MT::ObjectTag', 'object_id',
        { tag_id => \@tag_ids, object_datasource => MT::Entry->datasource }, { unique => 1 } ];
    my $p = MT::Page->load(\%terms, \%args);
    return 1 if $p;
    return 0;
}

1;
