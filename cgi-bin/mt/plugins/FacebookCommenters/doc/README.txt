# Facebook Connect Commenters Plugin for Movable Type
# Authors: Mark Paschal and David Recordon
# Copyright 2008-2010 Six Apart, Ltd.
# License: Artistic, licensed under the same terms as Perl itself


OVERVIEW

The Facebook Connect Commenters plugin for Movable Type allows commenters to login to your
blog using their Facebook account.  It makes use of the Facebook Connect APIs to provide a
rich user experience.  Commenters are able to automatically bring their name, profile photo,
and friends with them when commenting on a blog running this plugin.

All of this profile information respects a user's privacy settings from Facebook; if they only
share their profile photo with their friends then it won't be displayed publicly on a blog.
Once a Facebook user has logged in, comments left from other Facebook users will display
additional data.  Profile photos and names that were hidden publicly will now be displayed
assuming the logged in user is able to see them on Facebook.com.  Additionally, comments left
from friends of the user on Facebook will be highlighted.

After leaving a comment, the Facebook user will be given the option to share with their
friends on Facebook that they commented on the blog post.  This in turn should help others
discover your blog.

PLEASE NOTE: Facebook Connect currently requires pre-approval in order for you to launch your
blog integration. As long as you are using the standard blog plugin, this should be painless
and quick – it should take just a few days at the most.   

Check here to see if Facebook Connect is available for launch with out approval: http://wiki.developers.facebook.com/index.php/Facebook_Connect_Launch_Plans

If approval is required, go here to submit your blog with Facebook Connect: http://www.facebook.com/connect/submit_site.php


PREREQUISITES

 - Movable Type 4.1 or higher (4.2 is recommended)
 - JSON::XS 2.0 or greater.

The Facebook Commenters plugin ships with all of the other external libraries you should
need to run it.


INSTALLATION

  1. Unpack the FacebookCommenters archive.
  2. Copy the contents of FacebookCommenters/mt-static into /path/to/mt/mt-static/
  3. Copy the contents of FacebookCommenters/plugins into /path/to/mt/plugins/
  4. Login to your Movable Type Dashboard which will install the plugin.
  5. Navigate to the Plugin Settings on the blog you wish to integrate Facebook Connect.
  6. Create a Facebook Application to represent your site.
   6a. Go to http://www.facebook.com/developers/editapp.php to create a new application.
   6b. Enter a name for your application in the Application Name field.
   6c. Click the Optional Fields link to see more entry fields.
   6d. Keep all of the defaults, except enter a Callback URL. This URL should point to
       the top-level directory of the site which will be implementing Facebook Connect
       (this is usually your domain, e.g. http://www.example.com, but could also be a
       subdirectory).
   6e. You should include a logo that appears on the Facebook Connect dialog. Next to
       Facebook Connect Logo, click Change your Facebook Connect logo and browse to an
       image file. The logo can be up to 99 pixels wide by 22 pixels tall, and must be
       in JPG, GIF, or PNG format.
   6f. Click Submit to save your changes.
   6g. Take note of the API Key and Secret as you'll need these shortly.
  7. Within your blog's Plugin Settings, input the API Key and Secret from Facebook.
  8. Edit your templates to include Facebook Connect tags and customize the display.
  9. Enable "Facebook" as a Registration Authentication Method via
     Preferences -> Registration and ensure that User Registration is allowed.
  10. Republish your blog for all of the changes to take effect.


TEMPLATE CODE

To add basic support for Facebook Connect, place the following tag in your Header template
before the closing "head" tag.  This will enable Facebook Connect on your blog, but will not
customize the display of your comments.

  <mt:GreetFacebookCommenters>

To display a Facebook user's profile photo next to their comment, you will have to use a
Comment Detail template which includes userpics.  The following template should work in most
cases and
http://www.movabletype.org/documentation/designer/publishing-comments-with-userpics.html is a
useful guide to adding userpics to your templates.

  <div class="comment"<MTIfArchiveTypeEnabled archive_type="Individual"> id="comment-<$MTCommentID$>"</MTIfArchiveTypeEnabled>>
      <div class="inner">
          <div class="comment-header">
              <div class="user-pic<mt:if tag="CommenterAuthType" eq="Facebook"> comment-fb-<$MTCommenterUsername></mt:if>">

              <mt:if tag="CommenterAuthType" eq="Facebook">
                  <a href="http://www.facebook.com/profile.php?id=<$MTCommenterUsername>" class="auth-icon"><img src="<$MTCommenterAuthIconURL size="logo_small"$>" alt="<$mt:CommenterAuthType$>"/></a>
                  <fb:profile-pic uid="<$MTCommenterUsername>" size="square" linked="true"><img src="http://static.ak.connect.facebook.com/pics/q_default.gif" /></fb:profile-pic>

              <mt:else>
                  <mt:if tag="CommenterAuthIconURL">
                      <a href="<$MTCommenterURL>" class="auth-icon"><img src="<$MTCommenterAuthIconURL size="logo_small"$>" alt="<$mt:CommenterAuthType$>"/></a>
                  </mt:if>
                  <img src="<$MTStaticWebPath>images/default-userpic-50.jpg" />
              </mt:if>
              </div>

              <div class="asset-meta">
                  <span class="byline">
                  <mt:if tag="CommenterAuthType" eq="Facebook">
                      By <span class="vcard author"><fb:name uid="<$MTCommenterUsername>" linked="true" useyou="false"><a href="http://www.facebook.com/profile.php?id=<$MTCommenterUsername>"><$MTCommenterName></a></fb:name></span> on <a href="#comment-<$MTCommentID$>"><abbr class="published" title="<$MTCommentDate format_name="iso8601"$>"><$MTCommentDate$></abbr></a></span>

  				<mt:else>
  					By <span class="vcard author"><mt:if tag="CommenterURL"><a href="<mt:CommenterURL>"><$MTCommentAuthor default_name="Anonymous" $></a><mt:else><mt:CommentAuthorLink default_name="Anonymous" show_email="0"></mt:if></span><MTIfNonEmpty tag="CommentAuthorIdentity"><$MTCommentAuthorIdentity$></MTIfNonEmpty> on <a href="#comment-<$MTCommentID$>"><abbr class="published" title="<$MTCommentDate format_name="iso8601"$>"><$MTCommentDate$></abbr></a></span>
  				</mt:if>
                  </span>
              </div>
          </div>
          <div class="comment-content">
              <$MTCommentBody$>
          </div>
      </div>
  </div>

The plugin's root directory also has an example file "comment_detail.mtml.example", which is the default Comment Detail template module of the Community Blog template set included in MT 4.23 that also has the functionality to add Facebook userpics described above.  If you are using the default template module without any changes, you can overwrite /path/to/mt/addons/Community.pack/templates/blog/comment_detail.mtml with this file, and refresh the template from the Template Listing screen.

STYLES

While you don't need to customize any of the CSS styles, there are many CSS classes which
can be tweaked to adjust the display of comments.

.comment-friend {
  background-color: #c3cddf;
}

