# Movable Type (r) (C) 2007-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id$

package Motion::L10N::ja;

use strict;
use base 'Motion::L10N::en_us';
use vars qw( %Lexicon );
%Lexicon = (

## plugins/Motion/templates/Motion/comment_detail.mtml

## plugins/Motion/templates/Motion/single_entry.mtml
	'By [_1] <span class="date">on [_2]</span>' => '[_1]<span class="date">([_2])</span>',
	'Unpublish this post' => '投稿の公開を取り消し',
	'1 <span>Comment</span>' => '1 <span>コメント</span>',
	'# <span>Comments</span>' => '# <span>コメント</span>',
	'0 <span>Comments</span>' => '0 <span>コメント</span>',
	'1 <span>TrackBack</span>' => '1 <span>トラックバック</span>',
	'# <span>TrackBacks</span>' => '# <span>トラックバック</span>',
	'0 <span>TrackBacks</span>' => '0 <span>トラックバック</span>',
	'Note: This post is being held for approval by the site owner.' => '投稿はサイトの管理者が承認するまで保留されています。',
	'Photo' => '写真',
	'<a href="[_1]">Most recent comment by <strong>[_2]</strong> on [_3]</a>' => '<a href="[_1]"><strong>[_2]</strong>の最近のコメント([_3])</a>',
	'Posted to [_1]' => '[_1]に投稿しました',
	'[_1] posted [_2] on [_3]' => '[_1]が[_3]に[_2]を投稿しました',

## plugins/Motion/templates/Motion/entry_listing_category.mtml

## plugins/Motion/templates/Motion/widget_main_column_posting_form_text.mtml
	'QuickPost' => 'クイック投稿',
	'Content' => 'コンテンツ',
	'more options' => 'その他のオプション',
	'Post' => '投稿',

## plugins/Motion/templates/Motion/widget_search.mtml

## plugins/Motion/templates/Motion/widget_popular_entries.mtml
	'Popular Entries' => '人気の記事',
	'posted by <a href="[_1]">[_2]</a> on [_3]' => '[_3]の<a href="[_1]">[_2]</a>の投稿',

## plugins/Motion/templates/Motion/widget_monthly_archives.mtml

## plugins/Motion/templates/Motion/actions.mtml
	'Single Entry' => '記事内容',
	'[_1] commented on [_2]' => '[_1]は[_2]にコメントしました',
	'[_1] is now following [_2]' => '[_1]は[_2]を注目しています',
	'[_1] favorited [_2] on [_3]' => '[_1]は[_3]の[_2]をお気に入りに追加しました',
	'No recent actions.' => '最近のアクションはありません。',

## plugins/Motion/templates/Motion/user_profile_edit.mtml
	'Go <a href="[_1]">back to the previous page</a> or <a href="[_2]">view your profile</a>.' => '<a href="[_1]">前のページに戻る</a>または<a href="[_2]">プロフィールページに移動する</a>',
	'Messaging' => 'メッセージング',
	'Form Field' => 'フォームフィールド',
	'Change' => '変更',

## plugins/Motion/templates/Motion/archive_index.mtml

## plugins/Motion/templates/Motion/actions_local.mtml
	'Favorited [_1] on [_2]' => '[_2]の[_1]をお気に入りに追加しました',

## plugins/Motion/templates/Motion/widget_gallery.mtml
	'Recent Photos' => '最近の写真',

## plugins/Motion/templates/Motion/widget_following.mtml
	'Following' => '注目',
	'Not following anyone' => 'まだ誰にも注目していません',

## plugins/Motion/templates/Motion/profile_feed.mtml
	'Posted [_1] to [_2]' => '[_2]に[_1]を投稿しました',
	'Commented on [_1] in [_2]' => '[_2]の[_1]にコメントしました',
	'followed [_1]' => '[_1]を注目しました',

## plugins/Motion/templates/Motion/entry_response.mtml

## plugins/Motion/templates/Motion/widget_recent_entries.mtml
	'posted by [_1] on [_2]' => '[_1] [_2]',

## plugins/Motion/templates/Motion/comment_response.mtml
	'Comment Detail' => 'コメント詳細',
	'<strong>Bummer....</strong> [_1]' => '<strong>エラーです...</strong>: [_1]',

## plugins/Motion/templates/Motion/widget_signin.mtml
	'You are signed in as <a href="[_1]">[_2]</a>' => 'ユーザー名: <a href="[_1]">[_2]</a>',
	'You are signed in as [_1]' => 'ユーザー名: [_1]',
	'Edit profile' => 'ユーザー情報の編集',
	'Sign out' => 'サインアウト',
	'Not a member? <a href="[_1]">Register</a>' => '<a href="[_1]">サインアップ</a>',

## plugins/Motion/templates/Motion/trackbacks.mtml

## plugins/Motion/templates/Motion/banner_footer.mtml
	'Footer Widgets' => 'フッターウィジェット',

## plugins/Motion/templates/Motion/banner_header.mtml
	'Home' => 'ホーム',

## plugins/Motion/templates/Motion/dynamic_error.mtml

## plugins/Motion/templates/Motion/widget_members.mtml

## plugins/Motion/templates/Motion/main_index.mtml
	'Main Column Content' => 'メインカラムコンテンツ',

## plugins/Motion/templates/Motion/sidebar.mtml
	'Profile Widgets' => 'プロフィールウィジェット',
	'Main Index Widgets' => 'メインインデックスウィジェット',
	'Archive Widgets' => 'アーカイブウィジェット',
	'Entry Widgets' => 'ブログ記事ウィジェット',
	'Default Widgets' => 'デフォルトウィジェット',

## plugins/Motion/templates/Motion/widget_main_column_posting_form.mtml
	'Text post' => 'テキスト投稿',
	'Photo post' => '写真投稿',
	'Link post' => 'リンク投稿',
	'Embed post' => '埋め込み投稿',
	'Audio post' => 'オーディオ投稿',
	'URL of web page' => 'ウェブURL',
	'Select photo file' => '写真を選択する',
	'Only GIF, JPEG and PNG image files are supported.' => 'GIF, JPEG, PNG画像ファイルのみサポートされています。',
	'Select audio file' => 'オーディオファイルを選択',
	'Only MP3 audio files are supported.' => 'MP3のみサポートされています。',
	'Paste embed code' => '埋め込みコードを貼り付け',

## plugins/Motion/templates/Motion/widget_main_column_registration.mtml
	'<a href="javascript:void(0)" onclick="[_1]">Sign In</a>' => '<a href="javascript:void(0)" onclick="[_1]">サインイン</a>',
	'(or <a href="javascript:void(0)" onclick="[_1]">Sign In</a>)' => '(<a href="javascript:void(0)" onclick="[_1]">サインイン</a>)',
	'No posting privileges.' => '投稿する権限がありません。',

## plugins/Motion/templates/Motion/comments.mtml
	'what will you say?' => 'コメント?',
	'[_1] [_2]in reply to comment from [_3][_4]' => '[_1][_2]から[_3]のコメントへの返信[_4]',
	'Write a comment...' => 'コメントを書く...',

## plugins/Motion/templates/Motion/page.mtml

## plugins/Motion/templates/Motion/login_form.mtml
	'Forgot?' => 'お忘れですか?',

## plugins/Motion/templates/Motion/widget_powered_by.mtml

## plugins/Motion/templates/Motion/form_field.mtml
	'(Optional)' => '(オプション)',

## plugins/Motion/templates/Motion/widget_user_archives.mtml
	'Recenty entries from [_1]' => '[_1]の最近の記事',

## plugins/Motion/templates/Motion/widget_followers.mtml
	'Followers' => '被注目',
	'Not being followed' => 'まだ注目されていないようです',

## plugins/Motion/templates/Motion/widget_main_column_actions.mtml
	'Actions (Local)' => 'アクション(ローカル)',

## plugins/Motion/templates/Motion/actions_local.mtml
	'[_1] favorited [_2]' => '[_1]は[_2]をお気に入りに追加しました。',

## plugins/Motion/templates/Motion/user_profile.mtml
	'Recent Actions from [_1]' => '[_1]の最近のアクション',
	'Recent Entries from [_1]' => '[_1]の最近の記事',
	'Responses to Comments from [_1]' => '[_1]のコメントスレッド',
	'You are following [_1].' => '[_1]に注目しています。',
	'Unfollow' => '注目をやめる',
	'Follow' => '注目する',
	'Profile Data' => 'プロフィールデータ',
	'More Entries by [_1]' => '[_1]の記事をもっと見る',
	'Recent Actions' => '最近のアクション',
	'_PROFILE_COMMENT_LENGTH' => '35',
	'Comment Threads' => 'コメントスレッド',
	'[_1] commented on ' => '[_1]のコメント',
	'No responses to comments.' => 'コメントの返信がありません。',

## plugins/Motion/templates/Motion/comment_preview.mtml

## plugins/Motion/templates/Motion/entry.mtml

## plugins/Motion/templates/Motion/widget_elsewhere.mtml
	'Are you sure you want to remove the [_1] from your profile?' => 'プロフィールから[_1]を本当に削除しますか?',
	'Your user name or ID is required.' => 'ユーザー名またはIDは必須です。',
	'Add a Service' => 'サービス追加',
	'Service' => 'サービス',
	'Select a service...' => 'サービスの選択...',
	'Your Other Profiles' => '利用サービス',
	'Find [_1] Elsewhere' => '[_1]の利用サービス',
	'Remove service' => 'サービスを削除',

## plugins/Motion/templates/Motion/entry_summary.mtml

## plugins/Motion/templates/Motion/member_index.mtml

## plugins/Motion/templates/Motion/widget_categories.mtml

## plugins/Motion/templates/Motion/register_confirmation.mtml
	'Authentication Email Sent' => '認証メール送信',
	'Profile Created' => 'プロフィール作成',
	'<a href="[_1]">Return to the original page.</a>' => '<a href="[_1]">元のページ</a>に戻る。',

## plugins/Motion/templates/Motion/widget_recent_comments.mtml
	'<p>[_3]...</p><div class="comment-attribution">[_4]<br /><a href="[_1]">[_2]</a></div>' => '<p>[_3]...</p><div class="comment-attribution">[_4]<br /><a href="[_1]">[_2]</a></div>',

## plugins/Motion/templates/Motion/entry_listing_monthly.mtml

## plugins/Motion/templates/Motion/entry_listing_author.mtml
	'Archived Entries from [_1]' => '[_1]のアーカイブ記事',

## plugins/Motion/templates/Motion/search_results.mtml

## plugins/Motion/templates/Motion/motion_js.mtml
	'Add userpic' => 'ユーザー画像追加',

## plugins/Motion/templates/Motion/widget_fans.mtml
	'Fans' => 'お気に入り登録しているメンバー',

## plugins/Motion/templates/Motion/register.mtml
	'Enter a password for yourself.' => 'パスワード入力',
	'The URL of your website.' => '自分のウェブサイトのURL',

## plugins/Motion/templates/Motion/javascript.mtml
	'Please select a file to post.' => '投稿するファイルを選択してください。',
	'You selected an unsupported file type.' => 'サポートされていないファイル形式を選択しました。',

## plugins/Motion/templates/Motion/widget_about_ssite.mtml
	'About' => 'About',
	'The Motion Template Set is a great example of the type of site you can build with Movable Type.' => 'このサイトはMovable Typeのモーションテンプレートセットによって構築されています。',

## plugins/Motion/templates/Motion/password_reset.mtml
	'Reset Password' => 'パスワードリセット',
	'Back to the original page' => '元のページに戻る',

## plugins/Motion/templates/Motion/widget_tag_cloud.mtml

## plugins/Motion/tmpl/edit_linkpost.tmpl

## plugins/Motion/tmpl/edit_videopost.tmpl
	'Embed code' => '埋め込みコード',

## plugins/Motion/config.yaml
	'A Movable Type theme with structured entries and action streams.' => '構造化されたブログ記事とアクションストリームを表示するMovable Typeテーマです。',
	'Adjusting field types for embed custom fields...' => '埋め込みカスタムフィールドのフィールドタイプを調整しています',
	'Updating favoriting namespace for Motion...' => 'モーション用にネームスペースを更新しています...',
	'Reinstall Motion Templates' => 'モーションテンプレートを再インストールする',
	'Motion Themes' => 'モーションテーマ',
	'Themes for Motion template set' => 'モーションテンプレートセットテーマ',
	'Motion' => 'モーション',
	'Post Type' => '投稿タイプ',
	'Embed Object' => '埋め込みオブジェクト',
	'MT JavaScript' => 'MT JavaScript',
	'Motion MT JavaScript' => 'モーションMT JavaScript',
	'Motion JavaScript' => 'モーションJavaScript',
	'Entry Listing: Monthly' => 'ブログ記事リスト: 月別',
	'Entry Listing: Category' => 'ブログ記事リスト: カテゴリー別',
	'Entry Listing: Author' => 'ブログ記事リスト: ユーザー別',
	'Entry Response' => '投稿完了',
	'Profile View' => 'プロフィール',
	'Profile Edit Form' => 'プロフィールの編集フォーム',
	'Profile Error' => 'プロフィールエラー',
	'Profile Feed' => 'プロフィールフィード',
	'Login Form' => 'ログインフォーム',
	'Register Confirmation' => '登録確認',
	'New Password Reset Form' => '新しいパスワード再設定フォーム',
	'New Password Form' => '新しいパスワードの設定フォーム',
	'User Profile' => 'ユーザープロフィール',
	'About Pages' => 'Aboutページ',
	'About Site' => 'サイトについて',
	'Gallery' => 'ギャラリー',
	'Main Column Actions' => 'メインカラム: アクション',
	'Main Column Posting Form (All Media)' => 'メインカラム: 投稿フォーム(全メディア)',
	'Main Column Posting Form (Text Only, Like Twitter)' => 'メインカラム: 投稿フォーム(テキスト - 例: Twitter)',
	'Main Column Registration' => 'メインカラム: 登録',
	'Elsewhere' => '利用サービス',
	'User Archives' => 'ユーザーアーカイブ',
	'Blogroll' => 'ブログロール',
	'Feeds' => 'フィード',

## plugins/Motion/lib/Motion/Search.pm
	'This module works with MT::App::Search.' => 'このモジュールはMT::App::Searchと一緒に使います。',
	'Specify the blog_id of a blog that has Motion template set.' => 'モーション テンプレートセットが設定されているブログのIDを指定してください。',
	'Error loading template: [_1]' => 'テンプレートをロードできませんでした: [_1]',

);

1;
