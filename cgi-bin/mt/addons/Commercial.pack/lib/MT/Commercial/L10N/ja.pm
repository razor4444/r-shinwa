# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: ja.pm 116787 2009-12-16 06:00:51Z auno $

package MT::Commercial::L10N::ja;

use strict;
use base 'MT::Commercial::L10N::en_us';
use vars qw( %Lexicon );

## The following is the translation table.

%Lexicon = (

## addons/Commercial.pack/templates/professional/recent_comments.mtml
	'<a href="[_1]">[_2] commented on [_3]</a>: [_4]' => '<a href="[_1]">[_2] から [_3] に対するコメント</a>: [_4]',

## addons/Commercial.pack/templates/professional/comment_detail.mtml

## addons/Commercial.pack/templates/professional/openid.mtml

## addons/Commercial.pack/templates/professional/recent_assets.mtml

## addons/Commercial.pack/templates/professional/comment_form.mtml

## addons/Commercial.pack/templates/professional/comment_throttle.mtml

## addons/Commercial.pack/templates/professional/recent_entries_expanded.mtml
	'By [_1] | Comments ([_2])' => '[_1] | コメント([_2])',

## addons/Commercial.pack/templates/professional/tag_cloud.mtml

## addons/Commercial.pack/templates/professional/powered_by_footer.mtml

## addons/Commercial.pack/templates/professional/archive_index.mtml
	'Header' => 'ヘッダー',
	'Footer' => 'フッター',

## addons/Commercial.pack/templates/professional/footer_links.mtml
	'Links' => 'リンク',
	'Home' => 'ホーム',

## addons/Commercial.pack/templates/professional/navigation.mtml

## addons/Commercial.pack/templates/professional/new-comment.mtml

## addons/Commercial.pack/templates/professional/entry_listing.mtml
	'Recently by <em>[_1]</em>' => '<em>[_1]</em>による最近のブログ記事',

## addons/Commercial.pack/templates/professional/tags.mtml

## addons/Commercial.pack/templates/professional/comment_response.mtml

## addons/Commercial.pack/templates/professional/footer.mtml
	'Powered By (Footer)' => 'Powered By (フッター)',
	'Footer Links' => 'フッターのリンク',

## addons/Commercial.pack/templates/professional/commenter_notify.mtml

## addons/Commercial.pack/templates/professional/entry_detail.mtml
	'Entry Metadata' => 'ブログ記事のメタデータ',

## addons/Commercial.pack/templates/professional/verify-subscribe.mtml

## addons/Commercial.pack/templates/professional/footer-email.mtml

## addons/Commercial.pack/templates/professional/trackbacks.mtml

## addons/Commercial.pack/templates/professional/dynamic_error.mtml

## addons/Commercial.pack/templates/professional/recover-password.mtml

## addons/Commercial.pack/templates/professional/main_index.mtml

## addons/Commercial.pack/templates/professional/category_archive_list.mtml

## addons/Commercial.pack/templates/professional/sidebar.mtml
	'Main Sidebar' => 'メインサイドバー',
	'Blog Activity' => 'アクティビティ',
	'Blog Archives' => 'アーカイブ',

## addons/Commercial.pack/templates/professional/comments.mtml
	'Comment Detail' => 'コメント詳細',

## addons/Commercial.pack/templates/professional/page.mtml
	'Page Detail' => 'ウェブページの詳細',

## addons/Commercial.pack/templates/professional/search.mtml

## addons/Commercial.pack/templates/professional/entry_metadata.mtml

## addons/Commercial.pack/templates/professional/notify-entry.mtml

## addons/Commercial.pack/templates/professional/comment_preview.mtml

## addons/Commercial.pack/templates/professional/entry.mtml
	'Entry Detail' => 'ブログ記事の詳細',

## addons/Commercial.pack/templates/professional/header.mtml
	'Navigation' => 'ナビゲーション',

## addons/Commercial.pack/templates/professional/entry_summary.mtml

## addons/Commercial.pack/templates/professional/monthly_archive_list.mtml

## addons/Commercial.pack/templates/professional/commenter_confirm.mtml

## addons/Commercial.pack/templates/professional/search_results.mtml

## addons/Commercial.pack/templates/professional/javascript.mtml

## addons/Commercial.pack/templates/professional/blog_index.mtml

## addons/Commercial.pack/templates/professional/signin.mtml

## addons/Commercial.pack/templates/professional/categories.mtml

## addons/Commercial.pack/templates/professional/new-ping.mtml

## addons/Commercial.pack/tmpl/date-picker.tmpl
	'Select date' => '日付を選択',

## addons/Commercial.pack/tmpl/edit_field.tmpl
	'Edit Field' => 'フィールドの編集',
	'New Field' => 'フィールドを作成',
	'The selected fields(s) has been deleted from the database.' => '選択されたフィールドはデータベースから削除されました。',
	'Please ensure all required fields (highlighted) have been filled in.' => 'すべての必須フィールドに値を入力してください。',
	'System Object' => 'システムオブジェクト',
	'Select the system object this field is for' => 'フィールドを追加するオブジェクトを選択してください。',
	'Select...' => '選択...',
	'Required?' => '必須?',
	'Should a value be chosen or entered into this field?' => 'フィールドに値は必須ですか?',
	'Default' => '既定値',
	'You will need to first save this field in order to set a default value' => '既定値を設定する前にフィールドを保存する必要があります。',
	'_CF_BASENAME' => 'ベースネーム',
	'The basename is used for entering custom field data through a 3rd party client. It must be unique.' => 'ベースネームはサードパーティのクライアントから利用されることがあります。名前は一意でなければなりません。',
	'Unlock this for editing' => 'ロックを解除して編集します',
	'Warning: Changing this field\'s basename may require changes to existing templates.' => '警告: このフィールドのベースネームを変更すると、テンプレートにも修正が必要になることがあります。',
	'Template Tag' => 'テンプレートタグ',
	'Create a custom template tag for this field.' => 'このフィールドの値を出力するテンプレートタグを作成します。',
	'Example Template Code' => 'テンプレートの例',
	'Save this field (s)' => 'このフィールドを保存 (s)',
	'field' => 'フィールド',
	'fields' => 'フィールド',
	'Delete this field (x)' => 'フィールドを削除 (x)',

## addons/Commercial.pack/tmpl/asset-chooser.tmpl
	'Choose [_1]' => '[_1]を選択',
	'Remove [_1]' => '[_1]を削除',

## addons/Commercial.pack/tmpl/list_field.tmpl
	'Custom Fields' => 'カスタムフィールド',
	'New [_1] Field' => '[_1]フィールドを作成',
	'Delete selected fields (x)' => '選択されたフィールドを削除する (x)',
	'No fields could be found.' => 'フィールドが見つかりませんでした。',
	'System-Wide' => 'システム全体',

## addons/Commercial.pack/tmpl/reorder_fields.tmpl
	'open' => '開く',
	'click-down and drag to move this field' => 'フィールドをドラッグして移動します。',
	'click to %toggle% this box' => '%toggle%ときはクリックします。',
	'use the arrow keys to move this box' => '矢印キーでボックスを移動します。',
	', or press the enter key to %toggle% it' => '%toggle%ときはENTERキーを押します。',

## addons/Commercial.pack/config.yaml
	'Photo' => '写真',
	'Embed' => '埋め込み',
	'Updating Universal Template Set to Professional Website set...' => '汎用テンプレートセットをプロフェッショナルウェブサイトテンプレートセットにアップデートしています...',
	'Professional Website' => 'プロフェッショナル ウェブサイト',
	'Themes that are compatible with the Professional Website template set.' => 'プロフェッショナル ウェブサイト テンプレートセットに対応したテーマ',
	'Blog Index' => 'ブログのメインページ',
	'Blog Entry Listing' => 'ブログ記事のリスト',
	'Recent Entries Expanded' => '最近のブログ記事 (拡張)',

## addons/Commercial.pack/lib/CustomFields/Field.pm
	'Field' => 'フィールド',

## addons/Commercial.pack/lib/CustomFields/Template/ContextHandlers.pm
	'Are you sure you have used a \'[_1]\' tag in the correct context? We could not find the [_2]' => '[_2]が見つかりませんでした。[_1]タグを正しいコンテキストで使用しているか確認してください。',
	'You used an \'[_1]\' tag outside of the context of the correct content; ' => '[_1]タグを正しいコンテキストで使用していません。',

## addons/Commercial.pack/lib/CustomFields/BackupRestore.pm
	'Restoring custom fields data stored in MT::PluginData...' => 'MT::PluginDataに保存されているカスタムフィールドのデータを復元しています...',
	'Restoring asset associations found in custom fields ( [_1] ) ...' => 'カスタムフィールド([_1])に含まれるアイテムとの関連付けを復元しています...',
	'Restoring url of the assets associated in custom fields ( [_1] )...' => 'カスタムフィールド([_1])に含まれるアイテムのURLを復元しています...',

## addons/Commercial.pack/lib/CustomFields/Upgrade.pm
	'Moving metadata storage for pages...' => 'ウェブページのメタデータ格納先を変更しています...',

## addons/Commercial.pack/lib/CustomFields/App/CMS.pm
	'Show' => '表示',
	'Date & Time' => '日付と時刻',
	'Date Only' => '日付',
	'Time Only' => '時刻',
	'Please enter all allowable options for this field as a comma delimited list' => 'このフィールドで有効なすべてのオプションをカンマで区切って入力してください。',
	'[_1] Fields' => '[_1]フィールド',
	'Invalid date \'[_1]\'; dates must be in the format YYYY-MM-DD HH:MM:SS.' => '日時が不正です。日時はYYYY-MM-DD HH:MM:SSの形式で入力してください。',
	'Invalid date \'[_1]\'; dates should be real dates.' => '日時が不正です。',
	'Please enter valid URL for the URL field: [_1]' => 'URLを入力してください。[_1]',
	'Please enter some value for required \'[_1]\' field.' => '「[_1]」は必須です。値を入力してください。',
	'Please ensure all required fields have been filled in.' => '必須のフィールドに値が入力されていません。',
	'The template tag \'[_1]\' is an invalid tag name.' => '[_1]というタグ名は不正です。',
	'The template tag \'[_1]\' is already in use.' => '[_1]というタグは既に存在します。',
	'The basename \'[_1]\' is already in use.' => '[_1]という名前はすでに使われています。',
	'Customize the forms and fields for entries, pages, folders, categories, and users, storing exactly the information you need.' => 'ブログ記事、ウェブページ、フォルダ、カテゴリ、ユーザーのフォームとフィールドをカスタマイズして、必要な情報を格納することができます。',
	' ' => ' ',
	'Single-Line Text' => 'テキスト',
	'Multi-Line Text' => 'テキスト(複数行)',
	'Checkbox' => 'チェックボックス',
	'Date and Time' => '日付と時刻',
	'Drop Down Menu' => 'ドロップダウン',
	'Radio Buttons' => 'ラジオボタン',
	'Embed Object' => '埋め込みオブジェクト',
	'Post Type' => '投稿タイプ',

## addons/Commercial.pack/lib/MT/Commercial/Util.pm
	'Could not install custom field [_1]: field attribute [_2] is required' => 'カスタムフィールド [_1] をインストールできませんでした。[_2] 属性は必須です。',
	'Could not install custom field [_1] on blog [_2]: the blog already has a field [_1] with a conflicting type' => 'ブログ [_2] にカスタムフィールド [_1] をインストールできませんでした。ブログに既に[_1]というフィールドが存在しますが、種類が異なります。',
	'Blog [_1] using template set [_2]' => 'ブログ「[_1]」はテンプレートセット「[_2]」を使います。',
	'About' => 'About',
	'_PTS_REPLACE_THIS' => '<p><strong>以下の文章はサンプルです。内容を適切に書き換えてください。</strong></p>',
	'_PTS_SAMPLE_ABOUT' => '
<p>いろはにほへと ちりぬるを わかよたれそ つねならむ うゐのおくやま けふこえて あさきゆめみし ゑひもせす</p>
<p>色は匂へど 散りぬるを 我が世誰ぞ 常ならむ 有為の奥山 今日越えて 浅き夢見じ 酔ひもせず</p>
',
	'_PTS_EDIT_LINK' => '
<!-- 以下のリンクは削除してください。 -->
<p class="admin-edit-link">
<a href="#" onclick="location.href=adminurl + \'?__mode=view&_type=page&id=\' + page_id + \'&blog_id=\' + blog_id; return false">コンテンツを編集</a>
</p>
',
	'Could not create page: [_1]' => 'ウェブページを作成できませんでした: [_1]',
	'Created page \'[_1]\'' => 'ウェブページ「[_1]」を作成しました。',
	'_PTS_CONTACT' => 'お問い合わせ',
	'_PTS_SAMPLE_CONTACT' => '
<p>お問い合わせはメールで: email (at) domainname.com</p>
',
	'Welcome to our new website!' => '私たちの新しいウェブサイトへようこそ!',
	'_PTS_SAMPLE_WELCOME' => '
<p>いろはにほへと ちりぬるを わかよたれそ つねならむ うゐのおくやま けふこえて あさきゆめみし ゑひもせす</p>
<p>色は匂へど 散りぬるを 我が世誰ぞ 常ならむ 有為の奥山 今日越えて 浅き夢見じ 酔ひもせず</p>
<p>あめ つち ほし そら やま かは みね たに くも きり むろ こけ ひと いぬ うへ すゑ ゆわ さる おふ せよ えのえを なれ ゐて</p>
',
	'New design launched using Movable Type' => 'Movable Type を利用してウェブサイトをリニューアルしました',
	'_PTS_SAMPLE_NEWDESIGN' => '
<p>私たちのウェブサイトは、<a href="http://www.movabletype.jp">Movable Type</a>と汎用テンプレートセットを使って生まれ変わりました。汎用テンプレートセットを使えば、Movable Typeを使って新しいウェブサイトを誰でも簡単に、実際に数回のマウスクリックだけで立ち上げることができます。ウェブサイトのためのブログを作成して、汎用ウェブサイトのセットを選んで、再構築するだけです。ほらご覧のとおり！Movable Type のおかげでこんなに簡単にウェブサイトを作成できました！</p>
',
	'Could not create entry: [_1]' => 'ブログ記事を作成できませんでした: [_1]',
	'John Doe' => '匿名希望',
	'Great new site. I can\'t wait to try Movable Type. Congrats!' => '素敵なサイトですね。私もMovable Type試してみます！',
	'Created entry and comment \'[_1]\'' => 'ブログ記事とコメント「[_1]」を作成しました。',

);

1;

