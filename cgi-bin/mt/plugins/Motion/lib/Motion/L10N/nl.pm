# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: nl.pm 116788 2009-12-16 06:05:21Z auno $

package Motion::L10N::nl;

use strict;
use base 'Motion::L10N::en_us';
use vars qw( %Lexicon );
%Lexicon = (

## plugins/Motion/config.yaml
	'A Movable Type theme with structured entries and action streams.' => 'Een Movable Type thema met gestructureerde berichten en action streams.',
	'Adjusting field types for embed custom fields...' => 'Veldtypes aan het aanpassen voor gepersonaliseerde velden van type embed...',
	'Updating favoriting namespace for Motion...' => 'Favoriting namespace aan het bijwerken voor Motion...',
	'Reinstall Motion Templates' => 'Motion sjablonen opnieuw installeren',
	'Motion Themes' => 'Motion sjablonen',
	'Themes for Motion template set' => 'Thema\'s voor de Motion sjabloonset',
	'Motion' => 'Motion',
	'Post Type' => 'Type bericht',
	'Photo' => 'Foto',
	'Embed Object' => 'Embedded object',
	'MT JavaScript' => 'MT javascript',
	'Motion MT JavaScript' => 'Motion MT JavaScript',
	'Motion JavaScript' => 'Motion Javascript',
	'Entry Listing: Monthly' => 'Overzicht berichten: per maand',
	'Entry Listing: Category' => 'Overzicht berichten: per categorie',
	'Entry Listing: Author' => 'Overzicht berichten: per auteur',
	'Entry Response' => 'Antwoord op bericht',
	'Profile View' => 'Profiel bekijken',
	'Profile Edit Form' => 'Bewerkingsformulier profiel',
	'Profile Error' => 'Profielfout',
	'Profile Feed' => 'Profielfeed',
	'Login Form' => 'Aanmeldformulier',
	'Register Confirmation' => 'Bevestiging registratie',
	'Password Reset' => 'Wachtwoord vernieuwen',
	'New Password Form' => 'Formulier nieuw wachtwoord', # Translate - New
	'User Profile' => 'Gebruikersprofiel',
	'Actions (Local)' => 'Acties (lokaal)',
	'Comment Detail' => 'Details reactie',
	'Single Entry' => 'Enkel bericht',
	'Messaging' => 'Boodschappen',
	'Form Field' => 'Veld in formulier',
	'About Pages' => '\'Over\' pagina\'s',
	'About Site' => 'Over deze site',
	'Gallery' => 'Galerij',
	'Main Column Actions' => 'Hoofdkolom-acties',
	'Main Column Posting Form (All Media)' => 'Hoofdkolom publicatieformulier (alle media)',
	'Main Column Posting Form (Text Only, Like Twitter)' => 'Hoofdkolom publicatieformulier (enkel tekst, zoals Twitter)',
	'Main Column Registration' => 'Hoofdkolom registratie',
	'Fans' => 'Fans',
	'Popular Entries' => 'Populaire berichten',
	'Elsewhere' => 'Elders',
	'Following' => 'Volgt',
	'Followers' => 'Volgers',
	'User Archives' => 'Gebruikersarchieven',
	'Blogroll' => 'Blogroll',
	'Feeds' => 'Feeds',
	'Main Column Content' => 'Hoofdkolom inhoud',
	'Main Index Widgets' => 'Hoofdindexwidgets',
	'Archive Widgets' => 'Archiefwidgets',
	'Entry Widgets' => 'Berichtwidgets',
	'Footer Widgets' => 'Voettekstwidgets',
	'Default Widgets' => 'Standaardwidgets',
	'Profile Widgets' => 'Profielwidgets',

## plugins/Motion/lib/Motion/Search.pm
	'This module works with MT::App::Search.' => 'Deze module werkt met MT::App::Search.',
	'Specify the blog_id of a blog that has Motion template set.' => 'Geef het blog_id op van een blog die de Motion sjabloonset gebruikt.',
	'Error loading template: [_1]' => 'Fout bij laden sjabloon: [_1]',

## plugins/Motion/tmpl/edit_linkpost.tmpl

## plugins/Motion/tmpl/edit_videopost.tmpl
	'Embed code' => 'Embed-code',

## plugins/Motion/templates/Motion/widget_search.mtml

## plugins/Motion/templates/Motion/banner_header.mtml
	'Home' => 'Hoofdpagina',

## plugins/Motion/templates/Motion/widget_recent_comments.mtml
	'<p>[_3]...</p><div class="comment-attribution">[_4]<br /><a href="[_1]">[_2]</a></div>' => '<p>[_3]...</p><div class="comment-attribution">[_4]<br /><a href="[_1]">[_2]</a></div>',

## plugins/Motion/templates/Motion/widget_popular_entries.mtml
	'posted by <a href="[_1]">[_2]</a> on [_3]' => 'gepubliceerd door <a href="[_1]">[_2]</a> op [_3]',

## plugins/Motion/templates/Motion/widget_followers.mtml
	'Not being followed' => 'Wordt niet gevolgd',

## plugins/Motion/templates/Motion/entry_response.mtml

## plugins/Motion/templates/Motion/comment_response.mtml
	'<strong>Bummer....</strong> [_1]' => '<strong>Jammer...</strong> [_1]',

## plugins/Motion/templates/Motion/widget_about_ssite.mtml
	'About' => 'Over',
	'The Motion Template Set is a great example of the type of site you can build with Movable Type.' => 'De Motion sjabloonset is een goed voorbeeld van het soort site dat met Movable Type gebouwd kan worden.',

## plugins/Motion/templates/Motion/comment_detail.mtml

## plugins/Motion/templates/Motion/register.mtml
	'Enter a password for yourself.' => 'Kies een wachtwoord voor uzelf.',
	'The URL of your website.' => 'De URL van uw website.',

## plugins/Motion/templates/Motion/member_index.mtml

## plugins/Motion/templates/Motion/single_entry.mtml
	'By [_1] <span class="date">on [_2]</span>' => 'Door [_1] <span class="date">op [_2]</span>',
	'Unpublish this post' => 'Publicatie van dit bericht ongedaan maken',
	'1 <span>Comment</span>' => '1 <span>reactie</span>',
	'# <span>Comments</span>' => '# <span>reacties</span>',
	'0 <span>Comments</span>' => '0 <span>reacties</span>',
	'1 <span>TrackBack</span>' => '1 <span>TrackBack</span>',
	'# <span>TrackBacks</span>' => '# <span>TrackBacks</span>',
	'0 <span>TrackBacks</span>' => '0 <span>TrackBacks</span>',
	'Note: This post is being held for approval by the site owner.' => 'Opmerking: dit bericht wordt tegengehouden tot de eigenaar van de site het goedkeurt.',
	'<a href="[_1]">Most recent comment by <strong>[_2]</strong> on [_3]</a>' => '<a href="[_1]">Recentste reactie van <strong>[_2]</strong> op [_3]</a>',
	'Posted to [_1]' => 'Gepubliceerd op [_1]',
	'[_1] posted [_2] on [_3]' => '[_1] publiceerde [_2] op [_3]',

## plugins/Motion/templates/Motion/widget_tag_cloud.mtml

## plugins/Motion/templates/Motion/password_reset.mtml
	'Reset Password' => 'Wachtwoord opnieuw instellen',

## plugins/Motion/templates/Motion/form_field.mtml
	'(Optional)' => '(optioneel)',

## plugins/Motion/templates/Motion/javascript.mtml
	'Please select a file to post.' => 'Gelieve een bestand te kiezen om te publiceren.',
	'You selected an unsupported file type.' => 'U selecteerde een type bestand dat niet wordt ondersteund.',

## plugins/Motion/templates/Motion/trackbacks.mtml

## plugins/Motion/templates/Motion/archive_index.mtml

## plugins/Motion/templates/Motion/new_password.mtml

## plugins/Motion/templates/Motion/entry_listing_author.mtml
	'Archived Entries from [_1]' => 'Gearchiveerde berichten van [_1]',
	'Recent Entries from [_1]' => 'Recente berichten van [_1]',

## plugins/Motion/templates/Motion/widget_categories.mtml

## plugins/Motion/templates/Motion/dynamic_error.mtml

## plugins/Motion/templates/Motion/widget_elsewhere.mtml
	'Are you sure you want to remove the [_1] from your profile?' => 'Zeker om [_1] van uw profiel verwijderen?',
	'Your user name or ID is required.' => 'Uw gebruikersnaam of ID is vereist.',
	'Add a Service' => 'Service toevoegen',
	'Service' => 'Service',
	'Select a service...' => 'Selecteer een service...',
	'Your Other Profiles' => 'Uw andere profielen',
	'Find [_1] Elsewhere' => 'Elders [_1] vinden',
	'Remove service' => 'Service verwijderen',

## plugins/Motion/templates/Motion/widget_main_column_registration.mtml
	'<a href="javascript:void(0)" onclick="[_1]">Sign In</a>' => '<a href="javascript:void(0)" onclick="[_1]">Aanmelden</a>', # Translate - New
	'Not a member? <a href="[_1]">Register</a>' => 'Nog geen lid? <a href="[_1]">Registreer nu</a>',
	'(or <a href="javascript:void(0)" onclick="[_1]">Sign In</a>)' => '(of <a href="javascript:void(0)" onclick="[_1]">meld u aan</a>)',
	'No posting privileges.' => 'Geen rechten om berichten te publiceren',

## plugins/Motion/templates/Motion/widget_following.mtml
	'Not following anyone' => 'Volgt niemand',

## plugins/Motion/templates/Motion/widget_main_column_posting_form_text.mtml
	'QuickPost' => 'SnelBericht',
	'Content' => 'Inhoud',
	'more options' => 'meer opties',
	'Post' => 'Publiceren',

## plugins/Motion/templates/Motion/comment_preview.mtml

## plugins/Motion/templates/Motion/actions_local.mtml
	'[_1] commented on [_2]' => '[_1] reageerde op [_2]',
	'[_1] favorited [_2]' => '[1] markeerde [_2] als favoriet', # Translate - New
	'No recent actions.' => 'Geen recente acties.',

## plugins/Motion/templates/Motion/main_index.mtml

## plugins/Motion/templates/Motion/page.mtml

## plugins/Motion/templates/Motion/entry_summary.mtml

## plugins/Motion/templates/Motion/widget_main_column_posting_form.mtml
	'Text post' => 'TekstBericht',
	'Photo post' => 'FotoBericht',
	'Link post' => 'LinkBericht',
	'Embed post' => 'EmbedBericht',
	'Audio post' => 'AudioBericht',
	'URL of web page' => 'URL van webpagina',
	'Select photo file' => 'Selecteer fotobestand',
	'Only GIF, JPEG and PNG image files are supported.' => 'Enkel GIF, JPEG en PNG afbeeldingsbestanden worden ondersteund.',
	'Select audio file' => 'Selecteer audiobestand',
	'Only MP3 audio files are supported.' => 'Alleen MP3 audiobestanden worden ondersteund.',
	'Paste embed code' => 'Plak embed code hier',

## plugins/Motion/templates/Motion/widget_monthly_archives.mtml

## plugins/Motion/templates/Motion/profile_feed.mtml
	'Posted [_1] to [_2]' => 'Publiceerde [_1] op [_2]',
	'Commented on [_1] in [_2]' => 'Reageerde op [_1] op [_2]',
	'followed [_1]' => 'volgde [_1]',

## plugins/Motion/templates/Motion/widget_user_archives.mtml
	'Recenty entries from [_1]' => 'Recente berichten van [_]',

## plugins/Motion/templates/Motion/entry_listing_category.mtml

## plugins/Motion/templates/Motion/widget_signin.mtml
	'You are signed in as <a href="[_1]">[_2]</a>' => 'U bent aangemeld als <a href="[_1]">[_2]</a>',
	'You are signed in as [_1]' => 'U bent aangemeld als [_1]',
	'Edit profile' => 'Profiel bewerken',
	'Sign out' => 'Afmelden',

## plugins/Motion/templates/Motion/widget_fans.mtml

## plugins/Motion/templates/Motion/entry_listing_monthly.mtml

## plugins/Motion/templates/Motion/register_confirmation.mtml
	'Authentication Email Sent' => 'Authenticatiemail verzonden',
	'Profile Created' => 'Profiel aangemaakt',
	'<a href="[_1]">Return to the original page.</a>' => '<a href="[_1]">Terugkeren naar de oorspronkelijke pagina.</a>',

## plugins/Motion/templates/Motion/entry.mtml

## plugins/Motion/templates/Motion/widget_gallery.mtml
	'Recent Photos' => 'Recente afbeeldingen',

## plugins/Motion/templates/Motion/sidebar.mtml

## plugins/Motion/templates/Motion/widget_recent_entries.mtml
	'posted by [_1] on [_2]' => 'gepubliceerd door [_1] op [_2]',

## plugins/Motion/templates/Motion/banner_footer.mtml

## plugins/Motion/templates/Motion/widget_main_column_actions.mtml

## plugins/Motion/templates/Motion/comments.mtml
	'what will you say?' => 'wat zegt u?',
	'[_1] [_2]in reply to comment from [_3][_4]' => '[_1] [_2]als antwoord op reactie van [_3][_4]',
	'Write a comment...' => 'Laat een reactie achter...',

## plugins/Motion/templates/Motion/search_results.mtml

## plugins/Motion/templates/Motion/login_form.mtml
	'Forgot?' => 'Vergeten?',

## plugins/Motion/templates/Motion/widget_members.mtml

## plugins/Motion/templates/Motion/user_profile.mtml
	'Recent Actions from [_1]' => 'Recente acties van [_1]',
	'Responses to Comments from [_1]' => 'Antwoorden op reacties van [_1]',
	'You are following [_1].' => 'U volgt [_1].',
	'Unfollow' => 'Niet langer volgen',
	'Follow' => 'Volgen',
	'Profile Data' => 'Profielgegevens',
	'More Entries by [_1]' => 'Meer berichten van [_1]',
	'Recent Actions' => 'Recente acties',
	'_PROFILE_COMMENT_LENGTH' => '10', # Translate - New
	'Comment Threads' => 'Reactie threads',
	'[_1] commented on ' => '[_1] reageerde op ',
	'No responses to comments.' => 'Geen antwoorden op reacties.',

## plugins/Motion/templates/Motion/actions.mtml
	'[_1] is now following [_2]' => '[_1] volgt nu [_2]',
	'[_1] favorited [_2] on [_3]' => '[_1] markeerde [_2] als favoriet op [_3]',

## plugins/Motion/templates/Motion/motion_js.mtml
	'Add userpic' => 'Voeg gebruikersafbeelding toe',

## plugins/Motion/templates/Motion/widget_powered_by.mtml

## plugins/Motion/templates/Motion/user_profile_edit.mtml
	'Go <a href="[_1]">back to the previous page</a> or <a href="[_2]">view your profile</a>.' => 'Ga <a href="[_1]">terug naar de vorige pagina</a> of <a href="[_2]">bekijk uw profiel</a>.',
	'Change' => 'Wijzig',

);

1;
