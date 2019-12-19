# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: es.pm 116788 2009-12-16 06:05:21Z auno $

package Motion::L10N::es;

use strict;
use base 'Motion::L10N::en_us';
use vars qw( %Lexicon );
%Lexicon = (

## plugins/Motion/config.yaml
	'A Movable Type theme with structured entries and action streams.' => 'Tema de Movable Type con entradas estructuradas y torrentes de acciones.',
	'Adjusting field types for embed custom fields...' => 'Ajustando los tipos de campos para campos personalizados embebidos...',
	'Updating favoriting namespace for Motion...' => 'Actualizando el espacio de nombres de los favoritos para Motion...',
	'Reinstall Motion Templates' => 'Reinstalar plantillas de Motion',
	'Motion Themes' => 'Temas de Motion',
	'Themes for Motion template set' => 'Temas para el conjunto de plantillas Motion',
	'Motion' => 'Motion',
	'Post Type' => 'Tipo de entrada',
	'Photo' => 'Foto',
	'Embed Object' => 'Embeber objeto',
	'MT JavaScript' => 'MT JavaScript',
	'Motion MT JavaScript' => 'Motion MT JavaScript',
	'Motion JavaScript' => 'Motion JavaScript',
	'Entry Listing: Monthly' => 'Lista de entradas: Mensual',
	'Entry Listing: Category' => 'Lista de entradas: Categorías',
	'Entry Listing: Author' => 'Lista de entradas: Autor',
	'Entry Response' => 'Respuesta a la entrada',
	'Profile View' => 'Ver perfil',
	'Profile Edit Form' => 'Formulario de edición del perfil',
	'Profile Error' => 'Error del perfil',
	'Profile Feed' => 'Sindicación del perfil',
	'Login Form' => 'Formulario de inicio de sesión',
	'Register Confirmation' => 'Confirmación de registro',
	'Password Reset' => 'Reiniciar contraseña',
	'New Password Form' => 'Formulario de nueva contraseña', # Translate - New
	'User Profile' => 'Perfil del usuario',
	'Actions (Local)' => 'Acciones (local)',
	'Comment Detail' => 'Detalle del comentario',
	'Single Entry' => 'Entrada sencilla',
	'Messaging' => 'Mensajería',
	'Form Field' => 'Campo del formulario',
	'About Pages' => 'Páginas Acerca de',
	'About Site' => 'Sobre el sitio',
	'Gallery' => 'Galería',
	'Main Column Actions' => 'Acciones de la columna principal',
	'Main Column Posting Form (All Media)' => 'Formulario de publicación de la columna principal (Todos los medios)',
	'Main Column Posting Form (Text Only, Like Twitter)' => 'Formulario de publicación de la columna principal (Solo texto, como Twitter)',
	'Main Column Registration' => 'Registro de la columna principal',
	'Fans' => 'Fans',
	'Popular Entries' => 'Entradas populares',
	'Elsewhere' => 'En otros sitios',
	'Following' => 'Siguiendo',
	'Followers' => 'Seguidores',
	'User Archives' => 'Archivos de usuario',
	'Blogroll' => 'Enlaces',
	'Feeds' => 'Sindicación',
	'Main Column Content' => 'Contenido de la columna principal',
	'Main Index Widgets' => 'Widgets del índice principal',
	'Archive Widgets' => 'Widgets de los archivos',
	'Entry Widgets' => 'Widgets de la entrada',
	'Footer Widgets' => 'Widgets del pie',
	'Default Widgets' => 'Widgets predefinidos',
	'Profile Widgets' => 'Widgets del perfil',

## plugins/Motion/lib/Motion/Search.pm
	'This module works with MT::App::Search.' => 'Este módulo funciona con MT::App::Search.',
	'Specify the blog_id of a blog that has Motion template set.' => 'Especifique el blog_id de un blog que tenga el conjunto de plantillas de Motion.',
	'Error loading template: [_1]' => 'Error cargando plantilla: [_1]',

## plugins/Motion/tmpl/edit_linkpost.tmpl

## plugins/Motion/tmpl/edit_videopost.tmpl
	'Embed code' => 'Embeber código',

## plugins/Motion/templates/Motion/widget_search.mtml

## plugins/Motion/templates/Motion/banner_header.mtml
	'Home' => 'Inicio',

## plugins/Motion/templates/Motion/widget_recent_comments.mtml
	'<p>[_3]...</p><div class="comment-attribution">[_4]<br /><a href="[_1]">[_2]</a></div>' => '<p>[_3]...</p><div class="comment-attribution">[_4]<br /><a href="[_1]">[_2]</a></div>',

## plugins/Motion/templates/Motion/widget_popular_entries.mtml
	'posted by <a href="[_1]">[_2]</a> on [_3]' => 'publicado por <a href="[_1]">[_2]</a> en [_3]',

## plugins/Motion/templates/Motion/widget_followers.mtml
	'Not being followed' => 'Sin seguidores',

## plugins/Motion/templates/Motion/entry_response.mtml

## plugins/Motion/templates/Motion/comment_response.mtml
	'<strong>Bummer....</strong> [_1]' => '<strong>Qué mala suerte....</strong> [_1]',

## plugins/Motion/templates/Motion/widget_about_ssite.mtml
	'About' => 'Sobre mi',
	'The Motion Template Set is a great example of the type of site you can build with Movable Type.' => 'El conjunto de plantillas de Motion es un buen ejemplo del tipo de sitio que puede hacer con Movable Type.',

## plugins/Motion/templates/Motion/comment_detail.mtml

## plugins/Motion/templates/Motion/register.mtml
	'Enter a password for yourself.' => 'Introduzca su contraseña.',
	'The URL of your website.' => 'La URL de su sitio web.',

## plugins/Motion/templates/Motion/member_index.mtml

## plugins/Motion/templates/Motion/single_entry.mtml
	'By [_1] <span class="date">on [_2]</span>' => 'Por [_1] <span class="date">el [_2]</span>',
	'Unpublish this post' => 'Despublicar esta entrada',
	'1 <span>Comment</span>' => '1 <span>Comentario</span>',
	'# <span>Comments</span>' => '# <span>Comentarios</span>',
	'0 <span>Comments</span>' => '0 <span>Comentarios</span>',
	'1 <span>TrackBack</span>' => '1 <span>TrackBack</span>',
	'# <span>TrackBacks</span>' => '# <span>TrackBacks</span>',
	'0 <span>TrackBacks</span>' => '0 <span>TrackBacks</span>',
	'Note: This post is being held for approval by the site owner.' => 'Nota: Esta entrada está retenida hasta que el administrador del sitio la apruebe.',
	'<a href="[_1]">Most recent comment by <strong>[_2]</strong> on [_3]</a>' => '<a href="[_1]">Últimos comentarios de <strong>[_2]</strong> en [_3]</a>',
	'Posted to [_1]' => 'Publicado en [_1]',
	'[_1] posted [_2] on [_3]' => '[_1] publicó [_2] en [_3]',

## plugins/Motion/templates/Motion/widget_tag_cloud.mtml

## plugins/Motion/templates/Motion/password_reset.mtml
	'Reset Password' => 'Reiniciar la contraseña',

## plugins/Motion/templates/Motion/form_field.mtml
	'(Optional)' => '(Opcional)',

## plugins/Motion/templates/Motion/javascript.mtml
	'Please select a file to post.' => 'Por favor, seleccione un fichero para publicar.',
	'You selected an unsupported file type.' => 'Ha seleccionado un tipo de fichero no soportado.',

## plugins/Motion/templates/Motion/trackbacks.mtml

## plugins/Motion/templates/Motion/archive_index.mtml

## plugins/Motion/templates/Motion/new_password.mtml

## plugins/Motion/templates/Motion/entry_listing_author.mtml
	'Archived Entries from [_1]' => 'Entradas archivadas de [_1]',
	'Recent Entries from [_1]' => 'Entradas recientes de [_1]',

## plugins/Motion/templates/Motion/widget_categories.mtml

## plugins/Motion/templates/Motion/dynamic_error.mtml

## plugins/Motion/templates/Motion/widget_elsewhere.mtml
	'Are you sure you want to remove the [_1] from your profile?' => '¿Está seguro de que desea eliminar el [_1] del perfil?',
	'Your user name or ID is required.' => 'El usuario o el ID es obligatorio.',
	'Add a Service' => 'Añadir un servicio',
	'Service' => 'Servicio',
	'Select a service...' => 'Seleccionar un servicio...',
	'Your Other Profiles' => 'Sus otros perfiles',
	'Find [_1] Elsewhere' => 'Buscar [_1] en otro sitio',
	'Remove service' => 'Eliminar servicio',

## plugins/Motion/templates/Motion/widget_main_column_registration.mtml
	'<a href="javascript:void(0)" onclick="[_1]">Sign In</a>' => '<a href="javascript:void(0)" onclick="[_1]">Identifíquese</a>', # Translate - New
	'Not a member? <a href="[_1]">Register</a>' => '¿No es miembro? <a href="[_1]">Registrarse</a>',
	'(or <a href="javascript:void(0)" onclick="[_1]">Sign In</a>)' => '(o <a href="javascript:void(0)" onclick="[_1]">identifíquese</a>)',
	'No posting privileges.' => 'Sin privilegios de publicación.',

## plugins/Motion/templates/Motion/widget_following.mtml
	'Not following anyone' => 'No sigue a nadie',

## plugins/Motion/templates/Motion/widget_main_column_posting_form_text.mtml
	'QuickPost' => 'QuickPost',
	'Content' => 'Contenido',
	'more options' => 'más opciones',
	'Post' => 'Publicar',

## plugins/Motion/templates/Motion/comment_preview.mtml

## plugins/Motion/templates/Motion/actions_local.mtml
	'[_1] commented on [_2]' => '[_1] comentó en [_2]',
	'[_1] favorited [_2]' => '[_1] marcó como favorito [_2]', # Translate - New
	'No recent actions.' => 'Ninguna acción reciente',

## plugins/Motion/templates/Motion/main_index.mtml

## plugins/Motion/templates/Motion/page.mtml

## plugins/Motion/templates/Motion/entry_summary.mtml

## plugins/Motion/templates/Motion/widget_main_column_posting_form.mtml
	'Text post' => 'Texto',
	'Photo post' => 'Foto',
	'Link post' => 'Enlace',
	'Embed post' => 'Embebido',
	'Audio post' => 'Audio',
	'URL of web page' => 'URL de página web',
	'Select photo file' => 'Selccione una imagen',
	'Only GIF, JPEG and PNG image files are supported.' => 'Solo están soportados los formatos GIF, JPEG y PNG.',
	'Select audio file' => 'Seleccione un fichero de audio',
	'Only MP3 audio files are supported.' => 'Solo está soportado el formato MP3.',
	'Paste embed code' => 'Pegar código embebido',

## plugins/Motion/templates/Motion/widget_monthly_archives.mtml

## plugins/Motion/templates/Motion/profile_feed.mtml
	'Posted [_1] to [_2]' => '[_1] publicado en [_2]',
	'Commented on [_1] in [_2]' => 'Comentó en [_1] en [_2]',
	'followed [_1]' => 'sigue a [_1]',

## plugins/Motion/templates/Motion/widget_user_archives.mtml
	'Recenty entries from [_1]' => 'Entradas recientes de [_1]',

## plugins/Motion/templates/Motion/entry_listing_category.mtml

## plugins/Motion/templates/Motion/widget_signin.mtml
	'You are signed in as <a href="[_1]">[_2]</a>' => 'Está identificado como <a href="[_1]">[_2]</a>',
	'You are signed in as [_1]' => 'Está identificado como [_1]',
	'Edit profile' => 'Editar Perfil',
	'Sign out' => 'Salir',

## plugins/Motion/templates/Motion/widget_fans.mtml

## plugins/Motion/templates/Motion/entry_listing_monthly.mtml

## plugins/Motion/templates/Motion/register_confirmation.mtml
	'Authentication Email Sent' => 'Correo de autentificación enviado.',
	'Profile Created' => 'Perfil creado',
	'<a href="[_1]">Return to the original page.</a>' => '<a href="[_1]">Regresar a la página original.</a>',

## plugins/Motion/templates/Motion/entry.mtml

## plugins/Motion/templates/Motion/widget_gallery.mtml
	'Recent Photos' => 'Fotos recientes',

## plugins/Motion/templates/Motion/sidebar.mtml

## plugins/Motion/templates/Motion/widget_recent_entries.mtml
	'posted by [_1] on [_2]' => 'publicada por [_1] en [_2]',

## plugins/Motion/templates/Motion/banner_footer.mtml

## plugins/Motion/templates/Motion/widget_main_column_actions.mtml

## plugins/Motion/templates/Motion/comments.mtml
	'what will you say?' => '¿Qué va a decir?',
	'[_1] [_2]in reply to comment from [_3][_4]' => '[_1] [_2]en respuesta al comentario de [_3][_4]',
	'Write a comment...' => 'Escriba un comentario...',

## plugins/Motion/templates/Motion/search_results.mtml

## plugins/Motion/templates/Motion/login_form.mtml
	'Forgot?' => '¿Recordar?',

## plugins/Motion/templates/Motion/widget_members.mtml

## plugins/Motion/templates/Motion/user_profile.mtml
	'Recent Actions from [_1]' => 'Acciones recientes de [_1]',
	'Responses to Comments from [_1]' => 'Respuestas a los comentarios de [_1]',
	'You are following [_1].' => 'Estás siguiendo a [_1]',
	'Unfollow' => 'Dejar de seguir',
	'Follow' => 'Seguir',
	'Profile Data' => 'Datos del perfil',
	'More Entries by [_1]' => 'Más entradas de [_1]',
	'Recent Actions' => 'Acciones recientes',
	'_PROFILE_COMMENT_LENGTH' => '10',
	'Comment Threads' => 'Hilos de comentarios',
	'[_1] commented on ' => '[_1] comentó en',
	'No responses to comments.' => 'Sin respuestas a comentarios.',

## plugins/Motion/templates/Motion/actions.mtml
	'[_1] is now following [_2]' => '[_1] ahora sigue a [_2]',
	'[_1] favorited [_2] on [_3]' => '[_1] recomendó [_2] en [_3]',

## plugins/Motion/templates/Motion/motion_js.mtml
	'Add userpic' => 'Añadir avatar',

## plugins/Motion/templates/Motion/widget_powered_by.mtml

## plugins/Motion/templates/Motion/user_profile_edit.mtml
	'Go <a href="[_1]">back to the previous page</a> or <a href="[_2]">view your profile</a>.' => '<a href="[_1]">Regresar a la página anterior</a> o <a href="[_2]">vea su perfil</a>.',
	'Change' => 'cambiar',


);

1;
