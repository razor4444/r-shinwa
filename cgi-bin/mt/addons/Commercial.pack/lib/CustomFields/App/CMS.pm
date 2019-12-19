# Movable Type (r) (C) 2007-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id$

# Original Copyright (c) 2005-2007 Arvind Satyanarayan

package CustomFields::App::CMS;

use strict;
use CustomFields::Util qw( get_meta save_meta field_loop _get_html );
use MT::Util qw( remove_html dirify encode_html encode_js );

sub load_list_filters {
    my $plugin = shift;
    my $app = MT->app;
    my $blog_id = $app->param('blog_id') || undef;
    my %filters;
    my $objects = MT->registry('customfield_objects');
    foreach my $object ( keys %$objects ) {
        next if defined($blog_id) && $objects->{$object}{context} eq 'system';

        my $class = MT->model($object);
        $filters{"cf_list_$object"} = {
            label   => sub {
                $plugin->translate('[_1] Fields', $class->class_label_plural)
            },
            handler => sub {
                my ( $terms, $args ) = @_;
                $terms->{obj_type} = $object;
            },
        };
    }
    my @objects =
      sort { $filters{$a}{label} cmp $filters{$b}{label} } keys %filters;
    my $order = 100;
    foreach (@objects) {
        $filters{$_}{order} = $order;
        $order += 100;
    }
    $filters{cf_list_entry}{order} = 0;

    my $filters = { field => \%filters };
    # $filters->{entry}{post_type}{handler} = sub {};

    return $filters;
}

sub load_customfield_types {
    my $customfield_types = {
        # type_key => {
        #   label => ' ',
        #   order => 999,
        #   field_html => ''
        #   options_field => '',
        #   options_delimiter => '',
        #   default_value => '',
        #   column_def => ''
        # },
        'text' => {
            label => 'Single-Line Text',
            field_html => q{
                <div class="textarea-wrapper">
                    <input type="text" name="<mt:var name="field_name">" id="<mt:var name="field_id">" value="<mt:var name="field_value" escape="html">" class="full-width ti" />
                </div>
            },
            column_def => 'vchar_idx',
            order => 100,
        },
        'textarea' => {
            label => 'Multi-Line Text',
            field_html => {
                default => q{
                    <div class="textarea-wrapper">
                        <textarea name="<mt:var name="field_name">" id="<mt:var name="field_id">" class="full-width ta" rows="3" cols="72"><mt:var name="field_value" escape="html"></textarea>
                    </div>
                },
                # author => q{
                #     <!-- code here if different for 'author' object -->
                # },
            },
            column_def => 'vclob',
            order => 200,
        },
        'checkbox' => {
            label => 'Checkbox',
            field_html => q{
                <input type="hidden" name="<mt:var name="field_name">_cb_beacon" value="1" /><input type="checkbox" name="<mt:var name="field_name">" value="1" id="<mt:var name="field_id">"<mt:if name="field_value"> checked="checked"</mt:if> class="cb" /> <label class="hint" for="<mt:var name="field_id">"><mt:var name="description"></label>
            },
            column_def => 'vinteger_idx',
            order => 300,
        },
        'url' => {
            label => 'URL',
            field_html => q{
                <div class="textarea-wrapper">
                    <input type="text" name="<mt:var name="field_name">" id="<mt:var name="field_id">" value="<mt:var name="field_value" escape="html">" class="full-width ti" />
                </div>
            },
            default_value => 'http://',
            column_def => 'vchar',
            order => 400,           
        },
        'datetime' => {
            label => 'Date and Time',
            field_html => 'date-picker.tmpl',
            field_html_params => sub {
                my ($key, $tmpl_key, $tmpl_param) = @_;

                my $blog;
                if ( my $blog_id = $tmpl_param->{blog_id} ) {
                    $blog = MT->model('blog')->load($blog_id);
                }
                my $ts = $tmpl_param->{value} || '';
                if (ref $ts) {
                    $tmpl_param->{'date'} = $ts->{'date'};
                    $tmpl_param->{'time'} = $ts->{'time'};
                    return;
                }
                $ts =~ s/\D//g;

                my $app = MT->instance->isa('MT::App') ? MT->instance : undef;
                if ($ts) {
                    $tmpl_param->{date} = MT::Util::format_ts( "%Y-%m-%d", $ts, $blog, $app && $app->user ? $app->user->preferred_language : undef );
                    $tmpl_param->{time} = MT::Util::format_ts( "%H:%M:%S", $ts, $blog, $app && $app->user ? $app->user->preferred_language : undef );
                }
            },
            options_field => q{
                <__trans phrase="Show">: <select name="options" id="options">
                    <option value="datetime"<mt:if name="options" eq="datetime"> selected="selected"</mt:if>><__trans phrase="Date & Time"></option>
                    <option value="date"<mt:if name="options" eq="date"> selected="selected"</mt:if>><__trans phrase="Date Only"></option>
                    <option value="time"<mt:if name="options" eq="time"> selected="selected"</mt:if>><__trans phrase="Time Only"></option>
                </select>
            },
            no_default => 1,
            order => 500,
            column_def => 'vdatetime_idx'
        },
        'select' => {
            label => 'Drop Down Menu',
            field_html => q{
                    <select name="<mt:var name="field_name">" id="<mt:var name="field_id">" class="se" mt:watch-change="1">
                        <mt:loop name="option_loop">
                            <option value="<mt:var name="option" escape="html">"<mt:if name="is_selected"> selected="selected"</mt:if>><mt:var name="label" escape="html"></option>
                        </mt:loop>
                    </select>
            },
            options_field => q{
                <div class="textarea-wrapper"><input type="text" name="options" value="<mt:var name="options" escape="html">" id="options" class="full-width" /></div>
                <p class="hint"><__trans phrase="Please enter all allowable options for this field as a comma delimited list"></p>
            },
            options_delimiter => ',',
            column_def => 'vchar_idx',
            order => 600,
        },
        'radio' => {
            label => 'Radio Buttons',
            field_html => q{
                <ul class="custom-field-radio-list">
                <mt:loop name="option_loop">
                    <li><input type="radio" name="<mt:var name="field_name">" value="<mt:var name="option" escape="html">" id="<mt:var name="field_id">_<mt:var name="__counter__">"<mt:if name="is_selected"> checked="checked"</mt:if> class="rb" /> <label for="<mt:var name="field_id">_<mt:var name="__counter__">"><mt:var name="label" escape="html"></label></li>
                </mt:loop>
                </ul>
            },
            options_field => q{
                <div class="textarea-wrapper"><input type="text" name="options" value="<mt:var name="options" escape="html">" id="options" class="full-width" /></div>
                <p class="hint"><__trans phrase="Please enter all allowable options for this field as a comma delimited list"></p>
            },
            options_delimiter => ',',
            column_def => 'vchar_idx',
            order => 700,
        },
        'embed' => {
            label => 'Embed Object',
            field_html => {
                default => q{
                    <div class="textarea-wrapper">
                        <textarea name="<mt:var name="field_name">" id="<mt:var name="field_id">" class="full-width ta" rows="3" cols="72"><mt:var name="field_value" escape="html"></textarea>
                    </div>
                },
            },
            column_def => 'vclob',
            order => 800,
            validate => \&sanitize_embed,
        },
        'post_type' => {
            label => 'Post Type',
            condition => sub { MT->app->mode eq 'view' },
            field_html_params => sub {
                my ($key, $tmpl_key, $tmpl_param) = @_;
                $tmpl_param->{field_value} = MT->app->param('post_type')
                    || $tmpl_param->{object_type}
                    unless defined $tmpl_param->{field_value};
            },
            field_html => 
                q{<input type="hidden" name="customfield_post_type" value="<$mt:var name="field_value" escape="html"$>" />
                <ul id="entry-types">
                    <mt:loop name="post_type_loop">
                    <li id="entry-<$mt:var name="type" escape="html"$>"<mt:if name="type" eq="$field_value"> class="active"</mt:if>><a href="#" onclick="return updateEntryFields('<$mt:var name="type" escape="js"$>')" title="<$mt:var name="label" escape="html"$>"><$mt:var name="label" escape="html"$></a></li>
                    </mt:loop>
                </ul>},
            column_def => 'vchar_idx',
            show_column => 0,
        },
    };

    # Add asset choosers
    require MT::Asset;
    my $asset_types = MT::Asset->class_labels;
    my @asset_types =
      sort { $asset_types->{$a} cmp $asset_types->{$b} } keys %$asset_types;

    my $order = 900;
    foreach my $a_type (@asset_types) {
        my $asset_type = $a_type;
        $asset_type =~ s/^asset\.//;
        $customfield_types->{$a_type} = {
            label   => sub { MT::Asset->class_handler($a_type)->class_label },
            field_html => 'asset-chooser.tmpl',
            field_html_params => sub {
                $_[2]->{asset_type} = $asset_type;
                $_[2]->{asset_type_label} = MT->translate($asset_type);
            },
            asset_type => $a_type,
            no_default => 1,
            column_def => 'vclob',
            order => $order,
            context => 'blog',
            sanitize => \&MT::Util::sanitize_asset,
        };
        $order += 100;
    }

    return $customfield_types;
}

sub list_field {
    my ($app) = @_;
    my $plugin = $app->component('Commercial');
    my $q = $app->param;

    my $blog_id = $q->param('blog_id');
    return $app->errtrans("Permission denied.") if !$app->user->is_superuser && !$blog_id;
    #
    # User must have can_edit_config, can_set_publish_path or can_administer_blog
    # in order to see the Custom Fields page.
    #
    my $perms = $app->permissions;
    return $app->error( $app->translate('Permission denied.') )
      unless $app->user->is_superuser()
      || (
        $perms
        && (   $perms->can_edit_config
            || $perms->can_set_publish_paths
            || $perms->can_administer_blog )
      );

    my (@customfield_objs);

    my $hasher = sub {
        my ($obj, $row) = @_;
        my $type_def = $app->registry('customfield_types', $obj->type);
        my $class = $app->model($obj->obj_type);

        $row->{type_label} = $type_def->{label};
        $row->{obj_type_label} = $class->class_label;

        my $fld_blog_id = $obj->blog_id;
        if(!$blog_id && $fld_blog_id) {
            require MT::Blog;
            my $fld_blog = MT::Blog->load($fld_blog_id);
            $row->{blog_name} = $fld_blog ? $fld_blog->name : "* " . $app->translate('Orphaned') . " *";
        }

    };

    $app->add_breadcrumb($app->translate("Custom Fields"));

    return $app->listing({
        terms => {
            $blog_id ? ( blog_id => [ $blog_id, 0 ] ) : ()
        },
        args => { sort => 'name', 'direction' => 'ascend' },
        no_limit => 1,
        type => 'field',
        code => $hasher,
        template => File::Spec->catdir($plugin->path,'tmpl','list_field.tmpl'),
        params => {
            ($blog_id ? (
                blog_id => [ $blog_id, 0 ],
                edit_blog_id => $blog_id,
            ) : ( system_overview => 1 )),
            list_noncron => 1,
            saved_deleted => $q->param('saved_deleted') || 0,
            saved => $q->param('saved') || 0,
            obj_types_loop => \@customfield_objs,
            cfg_customfield => 1,
            use_plugins => $app->config->UsePlugins
        },
    });
}

sub edit_field {
    my ($app, $param) = @_;
    my $q = $app->param;
    my $plugin = $app->component("Commercial");

    my $blog = $app->blog;
    my $blog_id = $blog ? $blog->id : 0;
    return $app->errtrans("Permission denied.") if !$app->user->is_superuser && !$blog_id;
    #
    # User must have can_edit_config, can_set_publish_path or can_administer_blog
    # in order to see the Custom Fields page.
    #
    my $perms = $app->permissions;
    return $app->error( $app->translate('Permission denied.') )
      unless $app->user->is_superuser()
      || (
        $perms
        && (   $perms->can_edit_config
            || $perms->can_set_publish_paths
            || $perms->can_administer_blog )
      );
    my $id = $app->param('id');

    my (@obj_types, @types_loop);

    require CustomFields::Field;
    for my $key (@{ CustomFields::Field->column_names() }) {
        if (my $val = $q->param($key)) {
            $param->{$key} = $val;
        }
    }
    $param->{object_label} = CustomFields::Field->class_label;

    my $obj_type = $q->param('obj_type');

    if ($id) {
        my $field = CustomFields::Field->load( { blog_id => $blog_id, id => $id } );
        $app->redirect(
            $app->uri( mode => 'list_field', args => { blog_id => $blog_id } ) ) if !$field;
        $obj_type ||= $field->obj_type;
        while (my ($key, $val) = each %{ $field->column_values() }) {
            $param->{$key} ||= encode_html($val);
        }
    }

    $param->{basename_limit} = ( $blog ? $blog->basename_limit : 0 ) || 30;

    my $customfield_objs = $app->registry('customfield_objects');

    foreach my $key (keys %$customfield_objs) {
        my $context = $customfield_objs->{$key}->{context};
        next if $context eq 'blog' && !$blog_id;
        next if $context eq 'system' && $blog_id;

        my $class = $app->model($key);
        push @obj_types, {
            obj_type => $key,
            obj_type_label => ucfirst($class->class_label),
            ($obj_type && $key eq $obj_type) ? ( selected => 1) : (),
        };
    }

    my $customfield_types = $app->registry('customfield_types');
    my @customfield_types_loop;

    # Resort it by the order key
    my @cf_types =
      sort { $customfield_types->{$a}{order} <=> $customfield_types->{$b}{order} } keys %$customfield_types;

    foreach my $key (@cf_types) {
        next if ref $key eq 'HASH';
        my $type = $customfield_types->{$key};

        my $context = $customfield_types->{$key}->{context} || '';
        next if $context eq 'blog' && !$blog_id;
        next if $context eq 'system' && $blog_id;

        # This $tmpl_param is used to build the default field and options field
        my $tmpl_param = $param;
        $tmpl_param->{key} = $key;
        $tmpl_param->{field_name} = 'default';
        $tmpl_param->{field_id} = 'default';
        $tmpl_param->{field_value} = $id ? $param->{default} : ( $param->{default} || $type->{default_value} );
        $tmpl_param->{options} = $param->{options};

        # If an options_delimiter is present, we need to populate an option_loop
        if($type->{options_delimiter} && $param->{options}) {
            my @option_loop;
            my $expr = '\s*' . $type->{options_delimiter} . '\s?';
            my @options = split /$expr/, $param->{options};
            foreach my $option (@options) {
                my $label = $option;
                if ($option =~ m/=/) {
                    ($option, $label) = split /\s*=\s*/, $option, 2;
                }
                my $option_row = { option => $option, label => $label };
                $option_row->{is_selected} = defined $tmpl_param->{field_value} ? ($tmpl_param->{field_value} eq $option) : 0;
                push @option_loop, $option_row;
            }
            $tmpl_param->{option_loop} = \@option_loop;
        }

        my $row = {
            key => $key,
            label => $type->{label},
            $type->{no_default} ? ( ) : ( default_field => _get_html($key, 'field_html', $tmpl_param) ),
            $type->{options_field} ? ( options_field => _get_html($key, 'options_field', $tmpl_param) ) : (),
            options_delimiter => $type->{options_delimiter},
            show_column => (defined $type->{show_column} ? $type->{show_column} : 1),
        };

        foreach my $k (keys %$row) {
            my $value = $row->{$k};
            if (ref($value) eq 'CODE') { # handle coderefs
                $row->{$k} = $value->(@_);
            }
        }

        push @customfield_types_loop, $row;
    }

    $param->{customfield_types_loop} = \@customfield_types_loop;
    $param->{obj_type_loop} = \@obj_types;

    eval { require MT::Image; MT::Image->new or die; };
    $param->{do_thumb} = !$@ ? 1 : 0;
    $param->{saved} = $app->param('saved') || 0;
    $param->{cfg_customfield} = 1;
    # $param->{return_args} = $app->param('return_args');
    $app->add_breadcrumb($app->translate("Custom Fields"), 
        $app->uri('mode' => 'list_field', args => { $blog_id ? (blog_id => $blog_id) : () }));

    $app->add_breadcrumb($app->translate('Edit Field'));
    $app->build_page($plugin->load_tmpl('edit_field.tmpl'), $param);
}

sub save_permission_filter {
    my ( $cb, $app, $id ) = @_;
    #
    # User must have can_edit_config, can_set_publish_path or can_administer_blog
    # in order to save the Custom Fields.
    #
    my $perms = $app->permissions;
    return $perms
        && (   $perms->can_edit_config
            || $perms->can_set_publish_paths
            || $perms->can_administer_blog );
}

# This routine decrements the schema_version stored for the plugin
# to automatically trigger an "upgrade"
sub prep_customfields_upgrade {
    my $plugin = shift;
    my ($app) = @_;

    my $cfg = MT->config;
    my $plugin_schema = $cfg->PluginSchemaVersion || {};
    $plugin_schema->{$plugin->id} = $plugin->schema_version - '0.0001';
    if (keys %$plugin_schema) {
        $cfg->PluginSchemaVersion($plugin_schema, 1);
    }
    $cfg->save_config;

    $app->call_return;
}

sub CMSPostSave_customfield_objs {
    my ($cb, $app, $obj) = @_;
    return 1 unless $app->isa('MT::App');

    my $q = $app->param;
    my $blog_id = $app->param('blog_id') || 0;

    return 1 if !$q->param('customfield_beacon');

    require CustomFields::Field;
    my $meta = {};
    foreach ($q->param()) {
        next if $_ eq 'customfield_beacon';
        if (m/^customfield_(.*?)$/) {
            my $field_name = $1;
            if ( m/^customfield_(.+?)_cb_beacon$/ ) {
                $field_name = $1;
                $meta->{$field_name} = defined( $q->param("customfield_$field_name") )
                  ? $q->param("customfield_$field_name")
                  : '0';
            }
            else {
                my $field = CustomFields::Field->load(
                  {
                    $blog_id ? ( blog_id => [ $blog_id, 0 ] ) : ( blog_id => $blog_id ),
                    basename => $field_name
                  }
                );
                if ($field->type eq 'datetime') {
                    $meta->{$field_name} =
                        $q->param("customfield_$field_name") ne ''
                        ? $q->param("customfield_$field_name")
                        : undef;
                } else {
                    $meta->{$field_name} =
                        $q->param("customfield_$field_name");
                }
            }
        }
    }

    save_meta( $obj, $meta ) if %$meta;

    1;
}

sub CMSSaveFilter_customfield_objs {
    my ( $eh, $app ) = @_;
    my $q = $app->param;
    return 1 if !$q->param('customfield_beacon');

    my $blog_id = $q->param('blog_id') || 0;
    my $obj_type = $app->param('_type');

    require CustomFields::Field;
    my $iter = CustomFields::Field->load_iter(
        {
            $blog_id ? ( blog_id => [ $blog_id, 0 ] ) : (),
            obj_type => $obj_type,
        }
    );

    my %fields;
    while ( my $field = $iter->() ) {
        my $row = $field->column_values();
        my $field_name = "customfield_" . $row->{basename};
        if ( $row->{type} eq 'datetime' ) {
            my $ts = '';
            if ($q->param("d_$field_name") || $q->param("t_$field_name")) {
                my $date = $q->param("d_$field_name");
                $date = '1970-01-01' if $row->{options} eq 'time';
                my $time = $q->param("t_$field_name");
                $time = '00:00:00' if $row->{options} eq 'date';
                my $ao =  $date . ' ' . $time;
                unless ( $ao =~
                    m!^(\d{4})-(\d{2})-(\d{2})\s+(\d{2}):(\d{2})(?::(\d{2}))?$! )
                {
                    return $eh->error(
                        $app->translate(
"Invalid date '[_1]'; dates must be in the format YYYY-MM-DD HH:MM:SS.",
                            $ao
                        )
                    );
                }
                my $s = $6 || 0;
                return $eh->error(
                    $app->translate(
"Invalid date '[_1]'; dates should be real dates.",
                        $ao
                    )
                  )
                  if (
                       $s > 59
                    || $s < 0
                    || $5 > 59
                    || $5 < 0
                    || $4 > 23
                    || $4 < 0
                    || $2 > 12
                    || $2 < 1
                    || $3 < 1
                    || ( MT::Util::days_in( $2, $1 ) < $3
                        && !MT::Util::leap_day( $0, $1, $2 ) )
                  );
                $ts = sprintf "%04d%02d%02d%02d%02d%02d", $1, $2, $3, $4, $5, $s;
            }
            $q->param( $field_name, $ts );
        }
        elsif ( $row->{type} =~ m/^asset/ ) {
            if (my $file = $q->param("file_$field_name")) { # see asset-chooser.tmpl for parameter
                $q->param( $field_name, $file );
            }
        }
        elsif ( ( $row->{type} eq 'url' ) && $q->param($field_name) ) {
            my $valid = 1;
            my $value = $q->param($field_name);
            $value = '' unless defined $value;
            if ( $row->{required} ) {
                $valid = MT::Util::is_url( $value );
            } else {
                if ( ($value ne '') && ($value ne ($row->{default} || '' )) ) {
                    $valid = MT::Util::is_url( $value );
                }
            }
            return $eh->error( $app->translate("Please enter valid URL for the URL field: [_1]", $row->{name}) )
                unless $valid;
        }

        if ( $row->{required} ) {
            return $eh->error(
                $app->translate(
                    "Please enter some value for required '[_1]' field.", $row->{name})
                ) if(($row->{type} eq 'checkbox' || $row->{type} eq 'select' || ($row->{type} eq 'radio')) && !defined $q->param($field_name)) ||
                    (($row->{type} ne 'checkbox' && $row->{type} ne 'select' && ($row->{type} ne 'radio')) && (!defined $q->param($field_name) || $q->param($field_name) eq ''))
        }

        my $type_def = $app->registry('customfield_types', $row->{type});

        # handle any special field-level validation
        if ($type_def && (my $h = $type_def->{validate})) {
            $h = MT->handler_to_coderef($h) unless ref($h);
            if (ref $h) {
                my $value = $q->param($field_name);
                $app->error(undef);
                $value = $h->($value);
                if (my $err = $app->errstr) {
                    return $eh->error( $err );
                }
                else {
                    $q->param($field_name, $value);
                }
            }
        }
    }

    1;
}

# Fixes bug where required checkbox became uncheckable
sub CMSPreSave_field {
    my ($cb, $app, $obj, $original) = @_;

    if($app->param('required') eq '') {
        $obj->required(0);
        $original->required(0);
    }

    if ( 'checkbox' eq $app->param('type')
      && ( $app->param('default_cb_beacon')
        && !$app->param('default') ) )
    {
        $obj->default('0');
    }

    1;
}

# This callback is run only if the basename of the field changes
# and updates $meta to use the basename. Why am I sticking with basename
# and not using the field_id as in v2.0? Because basename makes a lot of
# operations (such as custom sorting and posting from a 3rd party client)
# MUCH faster since I don't need to LOAD customfields and can just use the 
# basenames in the key => value

sub CMSPostSave_field {
    my ($cb, $app, $field) = @_;
    my $q = $app->param;

    # If 'required' was not found, this field changes to not required.
    if (!$app->param('required')) {
        $field->required(0);
        $field->save;
    }

    # Dirify to tag name
    my $tag = MT::Util::dirify($field->tag);
    if ($tag ne $field->tag) {
        $field->tag($tag);
        $field->save;
    }

    # Sanitize
    my $sanitize_spec = $app->config->GlobalSanitizeSpec;
    my $blog = $app->blog;
    $sanitize_spec = $blog->sanitize_spec
        if $blog && $blog->sanitize_spec;
    require MT::Sanitize;
    my $description = $q->param('description');
    if ($description) {
        $description = MT::Sanitize->sanitize($description, $sanitize_spec);
        $field->description($description);
        $field->save;
    }

    # Skip if the basename hasn't been manually changed (or if it's for a new field)
    return 1 unless ($q->param('basename_manual')
        && $q->param('basename_old'));

    my $basename_old = $q->param('basename_old');
    my $basename_new = $field->basename;

    my $class = $app->model($field->obj_type . ':meta');

    # Updates existing meta records, changing the existing
    # field.old_basename to field.new_basename
    my $driver = $class->driver;
    my $dbd = $driver->dbd;

    my $stmt = $dbd->sql_class->new;
    my $virtual_col = $dbd->db_column_name($class->datasource, 'type');
    $stmt->add_complex_where([ { $virtual_col => 'field.' . $basename_old } ]);

    my $sql = join q{ }, 'UPDATE', $driver->table_for($class), 'SET',
        $virtual_col, '= ?', $stmt->as_sql_where();

    my $dbh = $driver->rw_handle;
    $dbh->do($sql, {}, 'field.' . $basename_new, @{ $stmt->{bind} })
        or return $app->error($dbh->errstr || $DBI::errstr);

    1;
}

sub CMSSaveFilter_field {
    my ($eh, $app) = @_;
    my $q = $app->param;

    # Are the required fields supplied?
    my @required_fields = qw( obj_type name type tag );
    if ($q->param('basename_manual')) {
        push @required_fields, 'basename';
    }
    for my $field (@required_fields) {
        if (!$q->param($field)) {
            return $eh->error( $app->translate("Please ensure all required fields have been filled in.") );
        }
    }

    my $field_tag = lc $q->param('tag');
    return $eh->error( $app->translate("The template tag '[_1]' is an invalid tag name.", $q->param('tag')) )
        if $field_tag =~ /[^0-9A-Za-z_]/;

    # Is that tag already defined by some other field?
    my %unique_tag_terms = ( tag => $field_tag );
    $unique_tag_terms{blog_id} = [ $q->param('blog_id'), 0 ]
        if $q->param('blog_id');
    $unique_tag_terms{id} = { op => '!=', value => $q->param('id') }
        if $q->param('id');
    if (MT->model('field')->count(\%unique_tag_terms)) {
        return $eh->error( $app->translate(
            "The template tag '[_1]' is already in use.", $q->param('tag'),
        ) );
    }

    # Is that tag already defined by core or some other plugin?
    my @components = grep { lc $_->id ne 'commercial' } MT::Component->select();
    COMPONENT: for my $component (@components) {
        my $comp_tags = $component->registry("tags");
        SET: for my $type (qw( block function )) {
            my $tags = $comp_tags->{$type}
                or next SET;
            TAG: for my $tag ( keys %$tags ) {
                return $eh->error(
                    $app->translate(
                        "The template tag '[_1]' is already in use.", $q->param('tag'),
                    )
                ) if $field_tag eq lc $tag;
            }
        }
    }

    # Is the basename already used?
    if ($q->param('basename') && $q->param('basename') ne '') {
        my $basename = $q->param('basename');
        my $basename_is_unique = MT->model('field')->make_unique_field_basename(
            stem       => $basename,
            field_id   => $q->param('id')      || 0,
            blog_id    => $q->param('blog_id') || 0,
            type       => $q->param('type')    || q{},
            check_only => 1,
        );
        return $eh->error( $app->translate("The basename '[_1]' is already in use.", $basename) )
            if !$basename_is_unique;
    }

    1;
}

sub CMSPrePreview_customfield_objs {
    my ($cb, $app, $obj, $data) = @_;
    my $q = $app->param;

    return 1 if !$q->param('customfield_beacon');

    my $meta;
    foreach my $param ($q->param()) {
        if ($param =~ m/^(d_|t_)?customfield_(.*?)$/) {
            my $type = $1 || '';
            my $mf = $2;
            next unless $obj->has_meta('field.'.$mf);

            push @$data,
              {
                  data_name  => "${type}customfield_$mf",
                  data_value => scalar $q->param("${type}customfield_$mf")
              };
            next if $param eq 'customfield_beacon';

            my $value;
            if ($type eq 'd_' || $type eq 't_') {
                my $date = $q->param("d_customfield_$mf");
                $date = '1970-01-01' if $date eq '';
                my $time = $q->param("t_customfield_$mf");
                $time = '00:00:00' if $time eq '';
                my $ts =  $date . ' ' . $time;
                $value = $ts;
            } else {
                $value = $q->param("customfield_$mf");
            }
            $obj->meta('field.' . $mf, $value);
        }
    }
    push @$data, { data_name => 'customfield_beacon', data_value => 1 };

    1;
}

# Transformer callbacks

sub add_reorder_widget {
    my ($cb, $app, $param, $tmpl) = @_;
    my $plugin = $cb->plugin;

    # Get our header include using the DOM
    my ($header);
    my $includes = $tmpl->getElementsByTagName('include');
    foreach my $include (@$includes) {
        if($include->[1]->{name} =~ /header.tmpl$/) {
            $header = $include;
            last;
        }
    }

    return 1 unless $header;

    require MT::Template;
    bless $header, 'MT::Template::Node';

    require File::Spec;
    my $reorder_widget_tmpl = File::Spec->catdir($plugin->path,'tmpl','reorder_fields.tmpl');
    my $reorder_widget = $tmpl->createElement('include', { name => $reorder_widget_tmpl });

    $tmpl->insertBefore($reorder_widget, $header);
}

sub add_app_fields {
    my ($cb, $app, $param, $tmpl, $marker, $where) = @_;

    # For some reason, directly calling app:fields doesn't populate
    # a field_loop param. So
    populate_field_loop($cb, $app, $param, $tmpl);

    # Where should include the DOM method to insert app:fields relative to the marker
    $where ||= 'insertAfter';

    # Marker can contain either a node or an ID of a node
    unless(ref $marker eq 'MT::Template::Node') {
        $marker = $tmpl->getElementById($marker);
    }

    my $appfields = $tmpl->createElement('app:fields');
    $tmpl->$where($appfields, $marker); 
}

# Although app:fields gives us the entire field loop, on the entry page
# we actually want the field_loop *before* we add the app:fields tag
sub populate_field_loop {
    my ($cb, $app, $param, $tmpl) = @_;
    my $plugin = $cb->plugin;
    my $q = $app->param;

    my $mode = $app->mode;
    my $blog_id = $q->param('blog_id');
    my $object_id = $q->param('id');
    my $object_type = $q->param('_type');
    my $is_entry = ($object_type eq 'entry' || $object_type eq 'page' || $mode eq 'cfg_entry');

    my %param = (
        $blog_id ? ( blog_id => $blog_id ) : (),
        ($mode eq 'cfg_entry') ? ( object_type => 'entry' ) :
                ( object_type => $object_type, object_id => $object_id ),
        params => $param,
    );
    my $loop = $param->{field_loop};

    my $fields = field_loop(%param);
    foreach my $field (@$fields) {
        my $basename = $field->{basename};
        my $show = !$is_entry                                        ? 1
                 : $field->{required}                                ? 1
                 : $param->{"disp_prefs_show_customfield_$basename"} ? 1
                 :                                                     0
                 ;
        $field->{show_field} = $show;
        $field->{use_field} = $field->{required} ne ''
            if ! exists $field->{use_field}; # TODO: created by user
        $field->{lock_field} = 1 if $field->{required};
    }

    my %locked_fields;
    if ( $loop ) { # an existing field loop, merge our fields into it
        my $i = 100;
        FIELD: foreach my $field ( @$loop ) {
            if ( $field->{field_name} =~ m/^field\.(.+)$/ ) {
                $field->{field_name} = 'customfield_' . $1;
                $field->{field_id} = 'customfield_' . $1;
                $field->{field_order} = $i++
                    unless exists $field->{field_order};
            }
            $locked_fields{$field->{field_id}} = 1
                if $field->{lock_field};
            foreach my $cf ( @$fields ) {
                if ( $cf->{field_name} eq $field->{field_name} ) {
                    foreach (keys %$cf) {
                        $field->{$_} = $cf->{$_} unless exists $field->{$_};
                    }
                    $cf->{remove} = 1;
                    next FIELD;
                }
                $cf->{field_order} = $i++ unless exists $cf->{field_order};
            }
        }
        @$fields = grep { !$_->{remove} } @$fields;
        push @$loop, @$fields;
    }
    else {
        $loop = $param->{field_loop} = $fields;
        my $i = 0;
        foreach (@$loop) {
            $_->{field_order} = $i++;
        }
    }

    if (my $cf_loop = $param->{disp_prefs_custom_fields}) {
        # user supplied sort order
        my %order;
        my $i = 200;
        foreach (@$cf_loop) {
            $order{$_->{name}} = $i++
                unless exists $locked_fields{$_->{name}};
        }

        no warnings;
        @$loop = sort { ($order{$a->{field_id}} || $a->{field_order} || 0)
            <=> ($order{$b->{field_id}} || $b->{field_order} || 0) } @$loop;
    }
}

sub add_calendar_src {
    my ($cb, $app, $tmpl) = @_;
    my $plugin = $cb->plugin;

    # this MUST loaded after mt.js:
    my $js_include = <<TMPL;
<mt:setvarblock name="js_include" append="1">
<script type="text/javascript" src="<mt:var name="static_uri">js/edit.js?v=<mt:var name="mt_version" escape="url">"></script>
<mt:include name="include/calendar.tmpl">
</mt:setvarblock>
TMPL
    $$tmpl = $js_include . $$tmpl;
}

sub edit_entry_param {
    my ($cb, $app, $param, $tmpl) = @_;

    param_edit_entry_post_types( @_ );

    my $plugin = $cb->plugin;

    # YAY DOM
    # Add the custom fields to the customizable_fields and custom_fields javascript variables
    # for Display Options toggline
    my $header = $tmpl->getElementById('header_include');
    my $html_head = $tmpl->createElement('setvarblock', { name => 'html_head', append => 1 });
    my $innerHTML = q{
<script type="text/javascript">
/* <![CDATA[ */
    <mt:loop name="field_loop"><mt:if name="required">default_fields.push('<mt:var name="field_id">');</mt:if>
    </mt:loop>
/* ]]> */
</script>
};
    $html_head->innerHTML($innerHTML);
    $tmpl->insertBefore($html_head, $header);

    # Add <mtapp:fields> before tags
    populate_field_loop($cb, $app, $param, $tmpl);

    my $content_fields = $tmpl->getElementById('content_fields');
    my $beacon_tmpl = File::Spec->catdir($plugin->path, 'tmpl', 'field_beacon.tmpl');
    my $beacon = $tmpl->createElement('include', { name => $beacon_tmpl });
    $tmpl->insertAfter($beacon, $content_fields);

    # # Finally display our reorder widget
    add_reorder_widget($cb, $app, $param, $tmpl);
}

# Handling for structured post types on compose screen
sub param_edit_entry_post_types {
    my ($cb, $app, $param, $tmpl) = @_;

    my $e = MT::Entry->load( $param->{id} )
        if $param->{id};

    my $blog_id = $e ? $e->blog_id : $param->{blog_id};

    CustomFields::Field->exist({ blog_id => [ 0, $blog_id ], basename => 'post_type' })
        or return;

    # handle any conditional exclusions
    my $object_type = $app->param('_type');
    my $type = ($e ? $e->meta('field.post_type') : undef)
        || $app->param('customfield_post_type') || $object_type;
    $type = 'entry' unless defined($type);
    $param->{customfield_post_type} = $type;

    my $types = MT->registry( $object_type . "_types" )
        or return;
    my $post_type_param = {};
    my @post_type_loop;

    # Create a spot for the 'basic' entry type
    my $orig_loop = $param->{field_loop};
    $types->{ $object_type } = {
        key => $object_type,
        label => MT->model($object_type)->class_label,
        fields => join(', ', map { $_->{field_id} } grep { $_->{lock_field} } @$orig_loop),
        order => 0,
    } if !exists $types->{$object_type};

    TYPE: foreach my $t ( keys %$types ) {
        my $label = $types->{$t}{label};
        my @fields = split /\s*,\s*/, $types->{$t}{fields};
        foreach my $f (@fields) {
            if ( $f =~ m/^field.(.+)/) {
                my $basename = $1;
                next TYPE unless CustomFields::Field->exist({ blog_id => [ 0, $blog_id ], basename => $basename });
            }
            else {
                next TYPE unless MT::Entry->has_column($f);
            }
        }
        $label = $label->() if ref $label eq 'CODE';
        $post_type_param->{$t} = {
            fields => [ map { s/^field\./customfield_/; $_ } split /\s*,\s*/, $types->{$t}{fields} ],
            label => $label,
        };
        $types->{$t}{key} = $t;
        push @post_type_loop, { type => $t, label => $label, order => $types->{$t}{order} };
    }
    @post_type_loop = sort { $a->{order} <=> $b->{order} } @post_type_loop;

    $types = [ values %$types ];

    # $types = $app->filter_conditional_list( values %$types, $e );

    no warnings; # not all may specify order
    @$types = sort { $a->{order} <=> $b->{order} } @$types;

    my @all_fields;

    @all_fields = map { $_->{field_id} } grep { ! $_->{lock_field} } @$orig_loop;

    my %fields;
    my %show_fields;
    foreach my $t (@$types) {
        # Skips handling of post type when the fields to support
        # that type aren't present.
        next unless exists $post_type_param->{$t->{key}};

        if (my $fields = $t->{'fields'}) {
            my @type_fields = split /\s*,\s*/, $fields;
            if ( $type eq $t->{key} ) {
                # save this list for later
                $show_fields{$_} = 1 for @type_fields;
            }
            if ( $t->{key} ne $object_type ) {
                foreach my $field ( @type_fields ) {
                    $show_fields{$field} = 0
                        unless exists $show_fields{$field};
                }
            }
            my $insert_pos = 0;
            foreach my $field (@type_fields) {
                if (exists $fields{$field}) {
                    $insert_pos = $fields{$field} + 1;
                    next;
                }
                splice(@all_fields, $insert_pos, 0, $field);
                for (my $i = $insert_pos; $i <= $#all_fields; $i++) {
                    $fields{$all_fields[$i]} = $i;
                }
                $insert_pos++;
            }
        }
    }

    # This is a required element for any structured post type
    unshift @all_fields, 'field.post_type';
    $show_fields{'field.post_type'} = 1;

    # fields: title, field.photo, text
    # fields: title, field.url, text
    # fields: title, field.embed, text
    # fields: title, field.audio, text

    # preset the fields to display for the post type; custom fields
    # will run after this and amend this list; but the items set here
    # should be shown irrespective to user preference, since these are
    # particularly relevant fields for the display of this type
    my $field_loop = [];
    my $order = 1;
    foreach my $field ( @all_fields ) {
        push @$field_loop, {
            field_id => $field,
            field_name => $field,
            system_field => $field eq 'field.post_type',
            field_order => $order++,
            lock_field => exists $show_fields{$field} ? 1 : 0,
            use_field => 0,
            show_field => exists $show_fields{$field} ? $show_fields{$field} : $param->{'disp_prefs_show_' . $field},
            # Don't attempt to label custom fields; custom fields will label
            # themselves
            ( $field =~ m/^field\./ ? () : ( field_label => $app->translate( ucfirst( $field ) ) ) ),
        };
    }

    # "system_field" is a field that has special meaning to the app
    #     ("post_type" is currently the only system field recognized)
    # "lock_field" means don't allow user to turn on/off display of field
    # "show_field" means show the field or not (can be based on user
    #     preference, but this setting forces them on or off)
    # "use_field" controls whether the field is reorderable in the
    #     display preferences.

    # Update or assign the 'post_type_loop' and 'field_loop' variables,
    # which control the set of icons to display to switch among post types
    # and provide the metadata for showing/hiding post type fields.
    $param->{post_type_loop} = \@post_type_loop
        if @post_type_loop > 1;
    $param->{field_loop} = $field_loop;

    # Add link tag to pull in stylesheet for post-types.
    my $version = MT->component('Commercial')->version;
    my $static_uri = $app->static_path;
    $param->{html_head} ||= '';
    $param->{html_head} .= qq{    <link type="text/css" href="${static_uri}addons/Commercial.pack/css/post_types.css?v=$version" rel="stylesheet" />\n};

    # A bit of JavaScript to control display of fields on compose screen
    # when switching from one entry type to another; we hide the fields that
    # are not relevant to the edited type and show those that are.
    my $post_types_json = MT::Util::to_json( $post_type_param );
    $param->{js_include} ||= '';
    $param->{js_include} .= <<"HTML";
<script type="text/javascript">
/* <![CDATA[ */
var postTypes = $post_types_json;
function oc(a) {var o={};for(var i=0;i<a.length;i++){o[a[i]]=true};return o}
function updateEntryFields(entryType) {
    if (!entryType.length) return;
    var f = document.forms['entry_form'];
    var old_type = f['customfield_post_type'].value;

    // no change
    if (old_type == entryType)
        return false;

    var fields_to_hide = postTypes[old_type]['fields'];
    var fields_to_show = postTypes[entryType]['fields'];
    var show_list = oc(fields_to_show);
    for (var i = 0; i < fields_to_hide.length; i++) {
        var fld = fields_to_hide[i];
        if (!show_list[fld]) {
            TC.addClassName(TC.elementOrId(fld + '-field'), 'hidden');
            f[fld].disabled = true;
            var pref = getByID("custom-prefs-" + fld);
            if (pref)
                pref.checked = false;
        }
    }
    var els = [];
    for (var i = 0; i < fields_to_show.length; i++) {
        var fld = fields_to_show[i];
        var el = TC.elementOrId(fld + '-field');
        els[i] = el;
        f[fld].disabled = false;
        var pref = TC.elementOrId("custom-prefs-" + fld);
        if (pref)
            pref.checked = true;
    }
    var post_type_el = TC.elementOrId('customfield_post_type-field');
    for (var i = els.length-1; i >=0; i--) {
        if (els[i].id != 'text-field') { // text-field is a special case due to the iframe and editor; skip it
            els[i].parentNode.removeChild(els[i]);
            post_type_el.parentNode.insertBefore(els[i],
                post_type_el.nextSibling);
        }
        TC.removeClassName(els[i], 'hidden');
    }
    TC.removeClassName(TC.elementOrId('entry-' + old_type), 'active');
    TC.addClassName(TC.elementOrId('entry-' + entryType), 'active');
    f['customfield_post_type'].value = entryType;
    return false;
}
/* ]]> */
</script>
HTML
}

sub list_entry_param {
    my ($cb, $app, $param, $tmpl) = @_;
    $param->{html_head} ||= '';
    $param->{html_head} .= <<'HTML';
    <style type="text/css">
        .filter-post_type #filter-mode-only {
            display: inline !important;
        }
        #filter-post_type {
            display: none;
        }
        .filter-post_type #filter-post_type {
            display: inline !important;
        }
    </style>
HTML
    push @{ $param->{quickfilter_loop} ||= [] },
        {
            filter => 'post_type',
            label => $app->translate('type'),
            type => 'select',
            options => [
                {
                    key => 'link',
                    label => 'Link',
                },
            ],
        };
}

sub edit_category_param {
    my ($cb, $app, $param, $tmpl) = @_;

    # Add <mtapp:fields> after description
    add_app_fields($cb, $app, $param, $tmpl, 'description', 'insertAfter');

    # Finally display our reorder widget
    add_reorder_widget($cb, $app, $param, $tmpl);
}

sub edit_author_param {
    my ($cb, $app, $param, $tmpl) = @_;

    # Add <mtapp:fields> after description
    add_app_fields($cb, $app, $param, $tmpl, 'url', 'insertAfter');

    # Finally display our reorder widget
    add_reorder_widget($cb, $app, $param, $tmpl);
}

sub asset_insert_param {
    my ($cb, $app, $param, $tmpl) = @_;
    my $plugin = $cb->plugin;

    return 1 unless $app->param('edit_field') =~ /customfield/;

    my $block = $tmpl->getElementById('insert_script');
    return 1 unless $block;
    my $preview_html = '';
    my $ctx = $tmpl->context;
    if (my $asset = $ctx->stash('asset')) {
        if ($asset->class_type eq 'image') {
            my $view = encode_js( $app->translate("View image") );
            $preview_html = qq{<a href="<mt:asseturl>" target="_blank" title="$view"><img src="<mt:assetthumbnailurl width="240" height="240">" alt="" /></a>};
        }
    }
    $block->innerHTML(qq{top.insertCustomFieldAsset('<mt:var name="upload_html" escape="js">', '<mt:var name="edit_field" escape="js">', '$preview_html') });
}

sub cfg_content_nav_param {
    my ($cb, $app, $param, $tmpl) = @_;
    my $plugin = $cb->plugin;

    my $more = $tmpl->getElementById('more_items');
    return 1 unless $more;

    my $existing = $more->innerHTML;
    $more->innerHTML(<<HTML);
$existing
<li<mt:if name="cfg_customfield"> class="active"</mt:if>><a href="<mt:var name="script_url">?__mode=list_field<mt:if name="blog_id">&amp;blog_id=<mt:var name="blog_id"></mt:if>"><b><__trans_section component="commercial"><__trans phrase="Custom Fields"></__trans_section></b></a></li>  
HTML
}

sub cfg_entry_param {
    my ($cb, $app, $param, $tmpl) = @_;
    my $plugin = $cb->plugin;

    my $more = $tmpl->getElementById('more_fields');
    return 1 unless $more;

    my $existing = $more->innerHTML;
    $more->innerHTML(<<HTML);
$existing
    <mt:loop name="field_loop">
    <li><input type="checkbox" name="custom_prefs" id="custom-prefs-customfield_<mt:var name="basename">" value="customfield_<mt:var name="basename">" <mt:if name="show_field"> checked="checked"</mt:if> class="cb" /> <label for="custom-prefs-customfield_<mt:var name="basename">"><mt:var name="name"></label></li>
    </mt:loop>  
HTML
    populate_field_loop($cb, $app, $param, $tmpl);
}

sub blog_stats_entry {
    my ($cb, $app, $param, $tmpl) = @_;

    # Inject CSS for post type
    my $version = MT->component('Commercial')->version;
    my $static_uri = $app->static_path;
    my $innerHTML = qq{
    <link type="text/css" href="${static_uri}addons/Commercial.pack/css/post_types.css?v=$version" rel="stylesheet" />\n
};

    my $head = $tmpl->getElementById('html_head');
    $head->innerHTML($head->innerHTML() . $innerHTML);

    #Inject EntryPostType tag for post_type
    my $place = $tmpl->getElementById('entry_type');
    $place->innerHTML('<mt:EntryPostType>');
}

sub new_version_widget {
    my ($cb, $app, $param, $tmpl) = @_;
    
    $param->{feature_loop} ||= [];
    unshift @{ $param->{feature_loop} },
      {
        feature_label => MT->translate('Custom Fields'),
        feature_url  => $app->help_url('professional/custom-fields.html'),
        feature_description => MT->translate('Customize the forms and fields for entries, pages, folders, categories, and users, storing exactly the information you need.')
      };
}

sub post_remove_object {
    my ($eh, $obj) = @_;
    return 1 if $obj->has_meta();

    my $type = $obj->class_type || $obj->datasource;
    my $id   = $obj->id;
    require MT::PluginData;
    MT::PluginData->remove({ plugin => 'CustomFields', key => "${type}_${id}" });
}

sub pre_remove_objectasset {
    my ( $cb, $oa ) = @_;
    my $obj = MT->model( $oa->object_ds )->load({ id => $oa->object_id })
        or return;
    my @fields = MT->model( 'field' )->load({
        obj_type => $oa->object_ds,
        type     => { like => 'asset%' },
        blog_id  => $oa->blog_id,       #currently, we have no system-wide asset field.
    });
    my $updated = 0;
    foreach my $field ( @fields ) {
        my $meta_column = 'field.' . $field->basename;
        my $meta_data = $obj->$meta_column();
        my ($asset_id) = $meta_data =~ m/\smt:asset-id="(\d+)"/i;
        if ( $oa->asset_id == $asset_id ) {
            $obj->$meta_column('');
            $updated++;
        }
    }
    $obj->save if $updated;
}

sub sanitize_embed {
    my ($str) = @_;
    my $blog;
    my $app = MT->instance;
    $blog = $app->blog if $app->can('blog');
    return MT::Util::sanitize_embed($str, { error_handler => $app, blog => $blog });
}

1;

