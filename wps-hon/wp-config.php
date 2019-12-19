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
define('DB_NAME', 'r-shinwa');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'root');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', '');

/** MySQL のホスト名 */
define('DB_HOST', 'localhost:3306');

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
define('AUTH_KEY',         'odsH*)_z3}[,~p_U)oKh|h!jS9q$C CCs=BB?$|w<O h7J]mWz/LX_x#K-oLx3_O');
define('SECURE_AUTH_KEY',  'Ts*?e>524DlQ+${PDBXpDsG.mhJl$H1(q`(rY.Aa3:#%.!vlc 4|==*+.g/+aRAO');
define('LOGGED_IN_KEY',    '-K_|N-Z3_e|6;C?wWknhG#N~TF7CzVJZ&uY0`/8^3%>svg2<W~nP.1A{roy2&w@)');
define('NONCE_KEY',        'q_2xSgXSm]^e_X};tx%OU|9h}X :YHy8yPN|AmG.&f7!LJ[u-9p$WuA!_1E1AK54');
define('AUTH_SALT',        'Zf5Rb4s@Be#-ugi|f[{;1j([RwaQwDA9.uf^;8;angfJ0pJ-n2]c6,KX+[(WMIm,');
define('SECURE_AUTH_SALT', '[|WREm_chd7P` &]hMtDoftSt1fq0or|W5`><lTVtD(r%qI7u,;t#LmIiEYW_mt(');
define('LOGGED_IN_SALT',   '! s+zf+yCU+L[O)5<Y-l5gk>l_p]7<k,:i7QyYN2=m3S775|6-$Di2g;TK}kAmfq');
define('NONCE_SALT',       'AC-xL~1,3IRh]dZxBd1#f|_/sR1C1}yVN+|HgjiavuY|`Hh0$?/z#V-7mMbu/1y+');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'casavilla_';

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
define('FTP_BASE', '/public_html/wps/');
define('FTP_CONTENT_DIR', FTP_BASE.'wp-content/');
define('FTP_PLUGIN_DIR', FTP_BASE.'wp-content/plugins/');

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
