<?php
/**
 * The base configurations of the WordPress.
 *
 * このファイルは、MySQL、テーブル接頭辞、秘密鍵、言語、ABSPATH の設定を含みます。
 * より詳しい情報は {@link http://wpdocs.sourceforge.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86 
 * wp-config.php の編集} を参照してください。MySQL の設定情報はホスティング先より入手できます。
 *
 * このファイルはインストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さず、このファイルを "wp-config.php" という名前でコピーして直接編集し値を
 * 入力してもかまいません。
 *
 * @package WordPress
 */

// 注意: 
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.sourceforge.jp/Codex:%E8%AB%87%E8%A9%B1%E5%AE%A4 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - こちらの情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'r-shinwa_jp');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'rkshinwa');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', '0A8435R9');

/** MySQL のホスト名 */
define('DB_HOST', 'webltm17.alpha-lt.net');

/** データベースのテーブルを作成する際のデータベースのキャラクターセット */
define('DB_CHARSET', 'utf8');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'LS||nMrsE;q_+9Oe=}_7lz@M.~9/]YR_(6&z_Hr0mMTYYaO^d*ot~qm`:*KuI}-a');
define('SECURE_AUTH_KEY',  '(.8Tx.7#>?pnD FAX-@9ZK{S+ {;9uIe>bg]m%UFv}PVb-ONi|ii&!}T2QZ7(Paq');
define('LOGGED_IN_KEY',    'b^r8ozKqpLJjI)aHHE$))m>iDZY0 J]njT`:2J=823_8PiOwQGKD@{RQ{n`a:[m]');
define('NONCE_KEY',        'i-u#L:@(v?| 8q#gWj:mvx73@k@3%W#J~BT-~Ruq9g{7,<e8??2Xd1,n/g_Oe8t5');
define('AUTH_SALT',        '|hCQ?!3SvaPRu +p4{;3z}juX.](Y9)G,1[:HS$l[ -$v&~ImJE>E7S1NQ/cS#Bj');
define('SECURE_AUTH_SALT', 'v{=V hji XIMydHz;kqEu0S7U %j1a~Vk`r8K&[i2~8@5O}`~*Vc0cG#c%sO$hG+');
define('LOGGED_IN_SALT',   'l[FKy~fu-ch#$1SI?EBW&-%hYFZgX7DHbzc@cYE_im==Oll-pWmBlX;vgRa(-UU|');
define('NONCE_SALT',       'Cima@,UWJ6T7:-r,(p:dY]<fs<Q#`/Tj)SV,-VvR*7.o_U|6n:i+ILH6wsx-1+QF');


/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * ローカル言語 - このパッケージでは初期値として 'ja' (日本語 UTF-8) が設定されています。
 *
 * WordPress のローカル言語を設定します。設定した言語に対応する MO ファイルが
 * wp-content/languages にインストールされている必要があります。例えば de.mo を
 * wp-content/languages にインストールし WPLANG を 'de' に設定することでドイツ語がサポートされます。
 */
define ('WPLANG', 'ja');

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 */
define('WP_DEBUG', false);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
