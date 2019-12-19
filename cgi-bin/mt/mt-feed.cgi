#!/usr/bin/perl -w
  
# Movable Type (r) (C) 2005-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: mt-feed.cgi 3455 2009-02-23 02:29:31Z auno $

use strict;
use lib $ENV{MT_HOME} ? "$ENV{MT_HOME}/lib" : 'lib';
use MT::Bootstrap App => 'MT::App::ActivityFeeds';
