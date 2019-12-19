# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: de.pm 116788 2009-12-16 06:05:21Z auno $

package Motion::L10N::de;

use strict;
use base 'Motion::L10N::en_us';
use vars qw( %Lexicon );
%Lexicon = (

## plugins/Motion/config.yaml
	'A Movable Type theme with structured entries and action streams.' => 'Ein Movable Type-Thema mit strukturierten Einträgen und Action Streams.',
	'Adjusting field types for embed custom fields...' => 'Passe Feldtypen für eingebettete individuelle Felder an...',
	'Updating favoriting namespace for Motion...' => 'Aktualisieren Favoriten-Namespace für Motion...',
	'Reinstall Motion Templates' => 'Motion-Vorlagen neu installieren',
	'Motion Themes' => 'Motion-Designs',
	'Themes for Motion template set' => 'Designs für die Motion-Vorlagengruppe',
	'Motion' => 'Motion',
	'Post Type' => 'Eintragsart',
	'Photo' => 'Foto',
	'Embed Object' => 'Objekt einbetten',
	'MT JavaScript' => 'MT-JavaScript',
	'Motion MT JavaScript' => 'Motion MT JavaScript',
	'Motion JavaScript' => 'Motion JavaScript',
	'Entry Listing: Monthly' => 'Eintragsliste: Monatlich',
	'Entry Listing: Category' => 'Eintragsliste: Kategorie',
	'Entry Listing: Author' => 'Eintragsliste: Autor',
	'Entry Response' => 'Eintragsantworten',
	'Profile View' => 'Profilansicht',
	'Profile Edit Form' => 'Profilbearbeitungsformular',
	'Profile Error' => 'Profilfehler',
	'Profile Feed' => 'Profil-Feed',
	'Login Form' => 'Anmeldeformular',
	'Register Confirmation' => 'Registrierungs-Bestätigung',
	'Password Reset' => 'Passwort zurücksetzen',
	'New Password Form' => 'Formular für neues Passwort', # Translate - New # OK
	'User Profile' => 'Benutzerprofil',
	'Actions (Local)' => 'Aktionen (lokal)',
	'Comment Detail' => 'Kommentardetails',
	'Single Entry' => 'Einzeleintrag',
	'Messaging' => 'Messaging',
	'Form Field' => 'Formularfeld',
	'About Pages' => 'Über-Seiten',
	'About Site' => 'Über-Site',
	'Gallery' => 'Galerie',
	'Main Column Actions' => 'Hauptspalte: Aktionen',
	'Main Column Posting Form (All Media)' => 'Hauptspalte: Eingabeformular (alle Medien)',
	'Main Column Posting Form (Text Only, Like Twitter)' => 'Hauptspalte: Eingabeformular (nur Text, z.B. Twitter)',
	'Main Column Registration' => 'Hauptspalte: Registrierung',
	'Fans' => 'Fans',
	'Popular Entries' => 'Beliebte Einträge',
	'Elsewhere' => 'Anderswo',
	'Following' => 'Benutzer, denen Sie folgen',
	'Followers' => 'Benutzer, die Ihnen folgen',
	'User Archives' => 'Benutzerarchiv',
	'Blogroll' => 'Blogrolle',
	'Feeds' => 'Feeds',
	'Main Column Content' => 'Hauptspalten-Inhalt',
	'Main Index Widgets' => 'Hauptspalten-Widgets',
	'Archive Widgets' => 'Archiv-Widgets',
	'Entry Widgets' => 'Eintrags-Widgets',
	'Footer Widgets' => 'Fußzeilen-Widgets',
	'Default Widgets' => 'Standard-Widgets',
	'Profile Widgets' => 'Profil-Widgets',

## plugins/Motion/lib/Motion/Search.pm
	'This module works with MT::App::Search.' => 'Dieses Modul verwendet MT::App:Search.',
	'Specify the blog_id of a blog that has Motion template set.' => 'Geben Sie die blog_id eines Blogs mit der Motion-Vorlagengruppe an.',
	'Error loading template: [_1]' => 'Fehler beim Laden der Vorlage: [_1]',

## plugins/Motion/tmpl/edit_linkpost.tmpl

## plugins/Motion/tmpl/edit_videopost.tmpl
	'Embed code' => 'Einbett-Code',

## plugins/Motion/templates/Motion/widget_search.mtml

## plugins/Motion/templates/Motion/banner_header.mtml
	'Home' => 'Startseite',

## plugins/Motion/templates/Motion/widget_recent_comments.mtml
	'<p>[_3]...</p><div class="comment-attribution">[_4]<br /><a href="[_1]">[_2]</a></div>' => '<p>[_3]...</p><div class="comment-attribution">[_4]<br /><a href="[_1]">[_2]</a></div>',

## plugins/Motion/templates/Motion/widget_popular_entries.mtml
	'posted by <a href="[_1]">[_2]</a> on [_3]' => 'von <a href="[_1]">[_2]</a> auf [_3]',

## plugins/Motion/templates/Motion/widget_followers.mtml
	'Not being followed' => 'Niemand folgt Ihnen',

## plugins/Motion/templates/Motion/entry_response.mtml

## plugins/Motion/templates/Motion/comment_response.mtml
	'<strong>Bummer....</strong> [_1]' => '<strong>Huch...</strong>',

## plugins/Motion/templates/Motion/widget_about_ssite.mtml
	'About' => 'Über',
	'The Motion Template Set is a great example of the type of site you can build with Movable Type.' => 'Die Motion-Vorlagengruppe ist ein tolles Beispiel für die große Bandbreite von Websites, die Sie mit Movable Type erstellen können.',

## plugins/Motion/templates/Motion/comment_detail.mtml

## plugins/Motion/templates/Motion/register.mtml
	'Enter a password for yourself.' => 'Geben Sie Ihr gewünschtes Passwort ein.',
	'The URL of your website.' => 'Die Adresse (URL) Ihrer Website.',

## plugins/Motion/templates/Motion/member_index.mtml

## plugins/Motion/templates/Motion/single_entry.mtml
	'By [_1] <span class="date">on [_2]</span>' => 'Von [_1] <span class="date">am [_2]</span>',
	'Unpublish this post' => 'Eintrag nicht mehr veröffentlichen',
	'1 <span>Comment</span>' => '1 <span>Kommentar</span>',
	'# <span>Comments</span>' => '# <span>Kommentare</span>',
	'0 <span>Comments</span>' => '0 <span>Kommentare</span>',
	'1 <span>TrackBack</span>' => '1 <span>TrackBack</span>',
	'# <span>TrackBacks</span>' => '# <span>TrackBacks</span>',
	'0 <span>TrackBacks</span>' => '0 <span>TrackBacks</span>',
	'Note: This post is being held for approval by the site owner.' => 'Hinweis: Dieser Eintrag ist vom Betreiber der Site noch nicht freigeschaltet worden.',
	'<a href="[_1]">Most recent comment by <strong>[_2]</strong> on [_3]</a>' => '<a href="[_1]">Aktuelle Kommentare von <strong>[_2]</strong> zu [_3]</a>',
	'Posted to [_1]' => 'Veröffentlicht in [_1]',
	'[_1] posted [_2] on [_3]' => '[_1] hat [_2] auf [_3] veröfentlicht',

## plugins/Motion/templates/Motion/widget_tag_cloud.mtml

## plugins/Motion/templates/Motion/password_reset.mtml
	'Reset Password' => 'Passwort zurücksetzen',

## plugins/Motion/templates/Motion/form_field.mtml
	'(Optional)' => '(Optional)',

## plugins/Motion/templates/Motion/javascript.mtml
	'Please select a file to post.' => 'Bitte wählen die Datei, die Sie hochladen möchten',
	'You selected an unsupported file type.' => 'Das gewählte Dateiformat wird nicht unterstützt.',

## plugins/Motion/templates/Motion/trackbacks.mtml

## plugins/Motion/templates/Motion/archive_index.mtml

## plugins/Motion/templates/Motion/new_password.mtml

## plugins/Motion/templates/Motion/entry_listing_author.mtml
	'Archived Entries from [_1]' => 'Archivierte Einträge von [_1]',
	'Recent Entries from [_1]' => 'Aktuelle Eintrage von [_1]',

## plugins/Motion/templates/Motion/widget_categories.mtml

## plugins/Motion/templates/Motion/dynamic_error.mtml

## plugins/Motion/templates/Motion/widget_elsewhere.mtml
	'Are you sure you want to remove the [_1] from your profile?' => '[_1] wirklich aus Ihrem Profil entfernen?',
	'Your user name or ID is required.' => 'Ihr Benutzername oder Ihre ID ist erforderlich.',
	'Add a Service' => 'Einen Dienst hinzufügen',
	'Service' => 'Dienst',
	'Select a service...' => 'Wählen Sie einen Dienst aus',
	'Your Other Profiles' => 'Ihre anderen Profile',
	'Find [_1] Elsewhere' => '[_1] anderswo finden',
	'Remove service' => 'Dienst entfernen',

## plugins/Motion/templates/Motion/widget_main_column_registration.mtml
	'<a href="javascript:void(0)" onclick="[_1]">Sign In</a>' => '<a href="javascript:void(0)" onclick="[_1]">Anmelden</a>', # Translate - New # OK
	'Not a member? <a href="[_1]">Register</a>' => 'Noch kein Mitglied? <a href="[_1]>Registieren</a>',
	'(or <a href="javascript:void(0)" onclick="[_1]">Sign In</a>)' => '(oder <a href="javascript:void(0)" onclick="[_1]">anmelden</a>)',
	'No posting privileges.' => 'Keine Veröffentlichungs-Rechte.',

## plugins/Motion/templates/Motion/widget_following.mtml
	'Not following anyone' => 'Sie folgen niemandem',

## plugins/Motion/templates/Motion/widget_main_column_posting_form_text.mtml
	'QuickPost' => 'QuickPost',
	'Content' => 'Inhalt',
	'more options' => 'Weitere Optionen',
	'Post' => 'Veröffentlichen',

## plugins/Motion/templates/Motion/comment_preview.mtml

## plugins/Motion/templates/Motion/actions_local.mtml
	'[_1] commented on [_2]' => '[_1] kommentierte auf [_2]',
	'[_1] favorited [_2]' => '[_1] hat [_2] zum Favoriten gemacht', # Translate - New # OK
	'No recent actions.' => 'Keine aktuellen Aktionen',

## plugins/Motion/templates/Motion/main_index.mtml

## plugins/Motion/templates/Motion/page.mtml

## plugins/Motion/templates/Motion/entry_summary.mtml

## plugins/Motion/templates/Motion/widget_main_column_posting_form.mtml
	'Text post' => 'Text',
	'Photo post' => 'Foto',
	'Link post' => 'Link',
	'Embed post' => 'Eingebettet',
	'Audio post' => 'Töne',
	'URL of web page' => 'Adresse (URL) der Webseite',
	'Select photo file' => 'Bilddatei wählen',
	'Only GIF, JPEG and PNG image files are supported.' => 'Unterstützt werden die Formate GIF, JPG und PNG.',
	'Select audio file' => 'Audiodatei wählen',
	'Only MP3 audio files are supported.' => 'Unterstützt wird das Format MP3.',
	'Paste embed code' => 'Einbett-Code einfügen',

## plugins/Motion/templates/Motion/widget_monthly_archives.mtml

## plugins/Motion/templates/Motion/profile_feed.mtml
	'Posted [_1] to [_2]' => '[_1] in [_2] veröffentlicht',
	'Commented on [_1] in [_2]' => '[_1] in [_2] kommentiert',
	'followed [_1]' => 'folgt [_1]',

## plugins/Motion/templates/Motion/widget_user_archives.mtml
	'Recenty entries from [_1]' => 'Aktuelle Einträge von [_1]',

## plugins/Motion/templates/Motion/entry_listing_category.mtml

## plugins/Motion/templates/Motion/widget_signin.mtml
	'You are signed in as <a href="[_1]">[_2]</a>' => 'Sie sind als <a href="[_1]">[_2]</a> angemeldet.',
	'You are signed in as [_1]' => 'Sie sind als [_1] angemeldet.',
	'Edit profile' => 'Profil bearbeiten',
	'Sign out' => 'Abmelden',

## plugins/Motion/templates/Motion/widget_fans.mtml

## plugins/Motion/templates/Motion/entry_listing_monthly.mtml

## plugins/Motion/templates/Motion/register_confirmation.mtml
	'Authentication Email Sent' => 'Authentifizierungsmail verschickt',
	'Profile Created' => 'Profil angelegt',
	'<a href="[_1]">Return to the original page.</a>' => '<a href="[_1]">Zurück zur Ausgangsseite</a>',

## plugins/Motion/templates/Motion/entry.mtml

## plugins/Motion/templates/Motion/widget_gallery.mtml
	'Recent Photos' => 'Aktuelle Fotos',

## plugins/Motion/templates/Motion/sidebar.mtml

## plugins/Motion/templates/Motion/widget_recent_entries.mtml
	'posted by [_1] on [_2]' => 'veröffentlicht von [_1] auf [_2]',

## plugins/Motion/templates/Motion/banner_footer.mtml

## plugins/Motion/templates/Motion/widget_main_column_actions.mtml

## plugins/Motion/templates/Motion/comments.mtml
	'what will you say?' => 'Was würden Sie sagen?',
	'[_1] [_2]in reply to comment from [_3][_4]' => '[_1] [_2] alt Antwort auf den Kommentar von [_3][_4]',
	'Write a comment...' => 'Schreiben Sie einen Kommmentar...',

## plugins/Motion/templates/Motion/search_results.mtml

## plugins/Motion/templates/Motion/login_form.mtml
	'Forgot?' => 'Vergessen?',

## plugins/Motion/templates/Motion/widget_members.mtml

## plugins/Motion/templates/Motion/user_profile.mtml
	'Recent Actions from [_1]' => 'Aktuelle Aktionen von [_1]',
	'Responses to Comments from [_1]' => 'Reaktionen auf Kommentare von  [_1]',
	'You are following [_1].' => 'Sie folgen [_1]',
	'Unfollow' => 'Nicht mehr folgen',
	'Follow' => 'Folgen',
	'Profile Data' => 'Profil-Daten',
	'More Entries by [_1]' => 'Weitere Einträge von [_1]',
	'Recent Actions' => 'Aktuelle Aktionen',
	'_PROFILE_COMMENT_LENGTH' => '10', # Translate - New # OK
	'Comment Threads' => 'Kommentar-Threads',
	'[_1] commented on ' => '[_1] kommentierte',
	'No responses to comments.' => 'Keine Kommentarantworten',

## plugins/Motion/templates/Motion/actions.mtml
	'[_1] is now following [_2]' => '[_1] folgt jetzt [_2]',
	'[_1] favorited [_2] on [_3]' => '[_1] hat [_2] auf [_3] zum Favoriten gemacht',

## plugins/Motion/templates/Motion/motion_js.mtml
	'Add userpic' => 'Benutzerbild einfügen',

## plugins/Motion/templates/Motion/widget_powered_by.mtml

## plugins/Motion/templates/Motion/user_profile_edit.mtml
	'Go <a href="[_1]">back to the previous page</a> or <a href="[_2]">view your profile</a>.' => '<a href="[_1]>Zurück zur Ausgangsseite</a> oder <a href="[_2]>Profil ansehen</a>.',
	'Change' => 'Ändern',


);

1;
