function conditional_block(cond, id) {
    var true_block = document.getElementById(id);
    var false_block = document.getElementById(id + '_else');
    if (cond) {
        if (true_block) {
            var display = true_block.getAttribute('mt:display_style');
            if (!display && false_block)
                display = false_block.getAttribute('mt:display_style');
            if (!display) display = '';
            true_block.style.display = display;
            DOM.removeClassName(true_block, 'hidden');
        }
        if (false_block) {
            false_block.style.display = 'none';
            DOM.addClassName(false_block, 'hidden');
        }
    }
    else {
        if (true_block) {
            true_block.style.display = 'none';
            DOM.addClassName(true_block, 'hidden');
        }
        if (false_block) {
            var display = false_block.getAttribute('mt:display_style');
            if (!display && true_block)
                display = false_block.getAttribute('mt:display_style');
            if (!display) display = '';
            false_block.style.display = display;
            DOM.removeClassName(false_block, 'hidden');
        }
    }
}



function mtScore(entry_id) {
    var span = DOM.getElement('scoring-id-' + entry_id);
    if (!span) return false;
    if (DOM.hasClassName(span, 'scoring-pending')) return false;
    if (DOM.hasClassName(span, 'scoring-scored')) return false;
    if (!DOM.hasClassName(span, 'scoring-scorable')) return false;

    var xh = mtGetXmlHttp();
    if (!xh) return false;

    DOM.addClassName( span, 'scoring-pending' );
    var url = 'http://www.r-shinwa.jp/cgi-bin/mt/mt-cp.cgi';
    xh.open('POST', url, true);
    xh.onreadystatechange = function() {
        if ( xh.readyState == 4 ) {
            if ( xh.status && ( xh.status != 200 ) ) {
                // error - ignore
            } else {
                eval(xh.responseText);
            }
        }
    };
    xh.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
    xh.send( '__mode=vote&blog_id=1&f=scored,count&jsonp=mtScore_cb&id=' + entry_id);
    return false;
}

function mtUpdateScores() {
    var u = mtGetUser();
    
        if (!u) return false;
    

    var entry_ids = '';
    var scores = DOM.getElementsByClassName("scoring");
    for (var i = 0; i < scores.length; i++) {
        var id = scores[i].id;
        id = id.replace(/^scoring-id-/, '');
        if (entry_ids != '') entry_ids += ",";
        entry_ids += id;
    }
    if (entry_ids == '') return false;

    var xh = mtGetXmlHttp();
    if (!xh) return false;

    var url = 'http://www.r-shinwa.jp/cgi-bin/mt/mt-cp.cgi';
    xh.open('POST', url, true);
    xh.onreadystatechange = function() {
        if ( xh.readyState == 4 ) {
            if ( xh.status && ( xh.status != 200 ) ) {
                // error - ignore
            } else {
                eval(xh.responseText);
            }
        }
    };
    xh.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
    xh.send( '__mode=score&blog_id=1&f=scored,count&jsonp=mtScore_cb&id=' + entry_ids);
    return false;
}

function mtScore_cb(s_hash) {
    var u = mtGetUser();
    if (s_hash['error']) {
        var els = DOM.getElementsByClassName('scoring-pending');
        for (var i = 0; i < els.length; i++)
            DOM.removeClassName(els[i], 'scoring-pending');
        // display error
        alert(s_hash['error']);
        return;
    }
    for (var id in s_hash) {
        var span = DOM.getElement('scoring-id-' + id);
        if ( span ) {
            DOM.removeClassName( span, 'scoring-pending' );
            DOM.removeClassName( span, 'scoring-scorable' );
            if ( s_hash[id].scored ) {
                DOM.addClassName( span, 'scoring-scored' );
            } else {
    
                if ( u && u.is_authenticated )
                    DOM.addClassName( span, 'scoring-scorable' );
    
            }
        }
        var score = DOM.getElement('scoring-score-' + id);
        if ( score )
            score.innerHTML = s_hash[id].count ? s_hash[id].count : 0;
        var label = DOM.getElement('scoring-score-label-' + id);
        if ( label ) {
            switch ( s_hash[id].count ) {
                case 1:
                    label.innerHTML = '票';
                    break;
                default:
                    label.innerHTML = '票';
                    break;
            }
        }
    }
}



function script_follow(id) {
    var u = mtGetUser();
    if (!u || !u.name) return;
    var xh = mtGetXmlHttp();
    if (!xh) return false;
    xh.open('POST', 'http://www.r-shinwa.jp/cgi-bin/mt/mt-cp.cgi', true);
    xh.onreadystatechange = function() {
        if ( xh.readyState == 4 ) {
            if (xh.status && ( xh.status != 200 ) ) {
                // error - ignore
            } else {
                eval( xh.responseText );
            }
        }
    };
    xh.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
    xh.send( '__mode=follow&id=' + id + '&magic_token=' + u.sid + '&jsonp=follow' );
    DOM.addClassName( 'following_' + id + '_else', 'hidden');
    var span = document.getElementById('following-status');
    if (span) span.innerHTML = '<img src="http://www.r-shinwa.jp/cgi-bin/mt/mt-static/images/indicator.white.gif" height="10" width="10" alt="Following..." />';
}

function script_leave(id) {
    var u = mtGetUser();
    if (!u || !u.name) return;
    var xh = mtGetXmlHttp();
    if (!xh) return false;
    xh.open('POST', 'http://www.r-shinwa.jp/cgi-bin/mt/mt-cp.cgi', true);
    xh.onreadystatechange = function() {
        if ( xh.readyState == 4 ) {
            if (xh.status && ( xh.status != 200 ) ) {
                // error - ignore
            } else {
                eval( xh.responseText );
            }
        }
    };
    xh.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
    xh.send( '__mode=leave&id=' + id + '&magic_token=' + u.sid + '&jsonp=leave' );
    DOM.addClassName('following_' + id, "hidden");
    var span = document.getElementById('following-status');
    if (span) span.innerHTML = '<img src="http://www.r-shinwa.jp/cgi-bin/mt/mt-static/images/indicator.white.gif" height="10" width="10" alt="Leaving..." />';
}

function follow(user_info) {
    conditional_block(true, 'following_' + user_info['id']);
    var span = document.getElementById('following-status');
    if (span) span.innerHTML = '';
}

function leave(user_info) {
    conditional_block(false, 'following_' + user_info['id']);
    var span = document.getElementById('following-status');
    if (span) span.innerHTML = '';
}



req = null;
function getCommenterName() {
    var u = mtGetUser();
    if (u && u.name) return u.name;
    return "";
}

function trimString (str) {
    str = this != window? this : str;
    return str.replace(/^\s+/g, '').replace(/\s+$/g, '');
}

defined = function( x ) { return x !== undefined; };

if ( !window.Event )
    try { window.Event = {} } catch(e) { };

Event.prep = function( ev ) {
        ev = ev || window.event;
        if( !defined( ev.stop ) )
            ev.stop = this.stop;
        if( !defined( ev.target ) )
            ev.target = ev.srcElement;
        if( !defined( ev.relatedTarget ) ) {
            ev.relatedTarget = (event.type == "mouseover" || event.type == "mouseenter")
                ? ev.fromElement
                : ev.toElement;
        }
        return ev;
    };

if ( !window.DOM )
    DOM = {

        getElement: function( e ) {
            return (typeof e == "string" || typeof e == "number") ? document.getElementById( e ) : e;
        },
    
    
        addEventListener: function( e, en, f, uc ) {
            try {
                if( e.addEventListener )
                    e.addEventListener( en, f, uc );
                else if( e.attachEvent )
                    e.attachEvent( "on" + en, f );
                else
                    e[ "on" + en ] = f;
            } catch( e ) {}
        },

    
        getClassNames: function( e ) {
            if( !e || !e.className )
                return [];
            return e.className.split( /\s+/g );
        },
    
    
        hasClassName: function( e, cn ) {
            e = DOM.getElement( e );
            if( !e || !e.className )
                return false;
            var cs = DOM.getClassNames( e );
            for( var i = 0; i < cs.length; i++ ) {
                if( cs[ i ] == cn )
                    return true;
            }
            return false;
        },
    
    
        addClassName: function( e, cn ) {
            e = DOM.getElement( e );
            if( !e || !cn )
                return false;
            var cs = DOM.getClassNames( e );
            for( var i = 0; i < cs.length; i++ ) {
                if( cs[ i ] == cn )
                    return true;
            }
            cs.push( cn );
            e.className = cs.join( " " );
            return false;
        },
    
    
        removeClassName: function( e, cn ) {
            var r = false;
            e = DOM.getElement( e );
            if( !e || !e.className || !cn )
                return r;
            var cs = (e.className && e.className.length)
                ? e.className.split( /\s+/g )
                : [];
            var ncs = [];
            /* support regex */
            if( cn instanceof RegExp ) {
                for( var i = 0; i < cs.length; i++ ) {
                    if ( cn.test( cs[ i ] ) ) {
                        r = true;
                        continue;
                    }
                    ncs.push( cs[ i ] );
                }
            } else {
                for( var i = 0; i < cs.length; i++ ) {
                    if( cs[ i ] == cn ) {
                        r = true;
                        continue;
                    }
                    ncs.push( cs[ i ] );
                }
            }
            if( r )
                e.className = ncs.join( " " );
            return r;
        },


        getElementsByTagAndClassName: function( tagName, className, root ) {
            root = DOM.getElement( root );
            if( !root )
                root = document;
            var allElements = root.getElementsByTagName( tagName );
            var elements = [];
            for( var i = 0; i < allElements.length; i++ ) {
                var element = allElements[ i ];
                if( !element )
                    continue;
                if( DOM.hasClassName( element, className ) )
                    elements[ elements.length ] = element;
            }
            return elements;
        },


        getElementsByClassName: function( className, root ) {
            return DOM.getElementsByTagAndClassName( "*", className, root );
        }


    };


function switchTabs( id, el ) {
    var hash = document.location.hash;
    if ( hash )
        hash = hash.replace( /^#/, '' );
    
    if ( el === undefined && hash )
        el = hash;
    else if ( el !== undefined )
        el = el.href.match( /#(.*)/ )[ 1 ];

    var tablist = DOM.getElement( id );
    var es = tablist.getElementsByTagName( "*" );
    var tabContent, tabId;
    for ( var i = 0, len = es.length; i < len; i++ ) {
        if ( es[ i ].href && es[ i ].href.match( /#.*/ ) ) {
            tabId = es[ i ].href.match( /#(.*)/ )[ 1 ];
            var tabContent = DOM.getElement( tabId );
            if ( tabContent === undefined )
                continue;

            if ( el ) {
                if ( tabId == el ) {
                    DOM.addClassName( es[ i ], "active" );
                    DOM.removeClassName( tabContent, "hidden" );
                } else {
                    DOM.removeClassName( es[ i ], "active" );
                    DOM.addClassName( tabContent, "hidden" );
                }
            }
        }
    }
}

function defaultInputFocus( event ) {
    try {
        event = Event.prep( event );
    } catch( e ) {};

    var el = event.target;
    if ( el.value == el.getAttribute( "mt:default" ) ) {
        el.value = '';
        DOM.removeClassName( el, "input-default" );
    }
}

function defaultInputBlur( event ) {
    try {
        event = Event.prep( event );
    } catch( e ) {};

    var el = event.target;
    if ( el.value == '' ) {
        el.value = el.getAttribute( "mt:default" );
        DOM.addClassName( el, "input-default" );
    }
}

function setupInputDefault() {
    var es = document.getElementsByTagName( "INPUT" );
    for ( var i = 0, len = es.length; i < len; i++ ) {
        if ( !es[ i ].getAttribute )
            continue;
        var val = es[ i ].getAttribute( "mt:default" );
        if ( !val )
            continue;

        if ( es[ i ].value == '' ) {
            DOM.addClassName( es[ i ], 'input-default' );
            es[ i ].value = val;
        }
        DOM.addEventListener( es[ i ], 'focus', defaultInputFocus );
        DOM.addEventListener( es[ i ], 'focusin', defaultInputFocus );
        DOM.addEventListener( es[ i ], 'blur', defaultInputBlur );
    }
}






// The cookie name to use for storing the blog-side comment session cookie.
var mtCookieName = "mt_blog1_user";
var mtCookieDomain = ".r-shinwa.jp";
var mtCookiePath = "/kodawari/";
var mtCookieTimeout = 14400;


function mtHide(id) {
    var el = (typeof id == "string") ? document.getElementById(id) : id;
    if (el) el.style.display = 'none';
}


function mtShow(id) {
    var el = (typeof id == "string") ? document.getElementById(id) : id;
    if (el) el.style.display = 'block';
}


function mtAttachEvent(eventName,func) {
    var onEventName = 'on' + eventName;
    var old = window[onEventName];
    if( typeof old != 'function' )
        window[onEventName] = func;
    else {
        window[onEventName] = function( evt ) {
            old( evt );
            return func( evt );
        };
    }
}


function mtFireEvent(eventName,param) {
    var fn = window['on' + eventName];
    if (typeof fn == 'function') return fn(param);
    return;
}


function mtRelativeDate(ts, fds) {
    var now = new Date();
    var ref = ts;
    var delta = Math.floor((now.getTime() - ref.getTime()) / 1000);

    var str;
    if (delta < 60) {
        str = '直前';
    } else if (delta <= 86400) {
        // less than 1 day
        var hours = Math.floor(delta / 3600);
        var min = Math.floor((delta % 3600) / 60);
        if (hours == 1)
            str = '1 時間前';
        else if (hours > 1)
            str = '2 時間前'.replace(/2/, hours);
        else if (min == 1)
            str = '1 分前';
        else
            str = '2 分前'.replace(/2/, min);
    } else if (delta <= 604800) {
        // less than 1 week
        var days = Math.floor(delta / 86400);
        var hours = Math.floor((delta % 86400) / 3600);
        if (days == 1)
            str = '1 日前';
        else if (days > 1)
            str = '2 日前'.replace(/2/, days);
        else if (hours == 1)
            str = '1 時間前';
        else
            str = '2 時間前'.replace(/2/, hours);
    }
    return str ? str : fds;
}


function mtEditLink(entry_id, author_id) {
    var u = mtGetUser();
    if (! u) return;
    if (! entry_id) return;
    if (! author_id) return;
    if (u.id != author_id) return;
    var link = '<a href="mt.cgi?__mode=view&amp;_type=entry&amp;id=' + entry_id + '">編集</a>';
    document.write(link);
}


function mtCommentFormOnFocus() {
    // if CAPTCHA is enabled, this causes the captcha image to be
    // displayed if it hasn't been already.
    mtShowCaptcha();
}


var mtCaptchaVisible = false;
function mtShowCaptcha() {
    var u = mtGetUser();
    if ( u && u.is_authenticated ) return;
    if (mtCaptchaVisible) return;
    var div = document.getElementById('comments-open-captcha');
    if (div) {
        div.innerHTML = '';
        mtCaptchaVisible = true;
    }
}



var is_preview;
var user;

function mtSetUser(u) {
    if (u) {
        // persist this
        user = u;
        mtSaveUser();
        // sync up user greeting
        mtFireEvent('usersignin');
    }
}


function mtEscapeJS(s) {
    s = s.replace(/'/g, "&apos;");
    return s;
}


function mtUnescapeJS(s) {
    s = s.replace(/&apos;/g, "'");
    return s;
}


function mtBakeUserCookie(u) {
    var str = "";
    if (u.name) str += "name:'" + mtEscapeJS(u.name) + "';";
    if (u.url) str += "url:'" + mtEscapeJS(u.url) + "';";
    if (u.email) str += "email:'" + mtEscapeJS(u.email) + "';";
    if (u.is_authenticated) str += "is_authenticated:'1';";
    if (u.profile) str += "profile:'" + mtEscapeJS(u.profile) + "';";
    if (u.userpic) str += "userpic:'" + mtEscapeJS(u.userpic) + "';";
    if (u.sid) str += "sid:'" + mtEscapeJS(u.sid) + "';";
    str += "is_trusted:'" + (u.is_trusted ? "1" : "0") + "';";
    str += "is_author:'" + (u.is_author ? "1" : "0") + "';";
    str += "is_banned:'" + (u.is_banned ? "1" : "0") + "';";
    str += "can_post:'" + (u.can_post ? "1" : "0") + "';";
    str += "can_comment:'" + (u.can_comment ? "1" : "0") + "';";
    str = str.replace(/;$/, '');
    return str;
}


function mtUnbakeUserCookie(s) {
    if (!s) return;

    var u = {};
    var m;
    while (m = s.match(/^((name|url|email|is_authenticated|profile|userpic|sid|is_trusted|is_author|is_banned|can_post|can_comment):'([^']+?)';?)/)) {
        s = s.substring(m[1].length);
        if (m[2].match(/^(is|can)_/)) // boolean fields
            u[m[2]] = m[3] == '1' ? true : false;
        else
            u[m[2]] = mtUnescapeJS(m[3]);
    }
    if (u.is_authenticated) {
        u.is_anonymous = false;
    } else {
        u.is_anonymous = true;
        u.can_post = false;
        u.is_author = false;
        u.is_banned = false;
        u.is_trusted = false;
    }
    return u;
}


function mtGetUser() {
    if (!user) {
        var cookie = mtGetCookie(mtCookieName);
        if (!cookie) return;
        user = mtUnbakeUserCookie(cookie);
        if (! user) {
            user = {};
            user.is_anonymous = true;
            user.can_post = false;
            user.is_author = false;
            user.is_banned = false;
            user.is_trusted = false;
        }
    }
    return user;
}


var mtFetchedUser = false;

function mtFetchUser(cb) {
    if (!cb) cb = 'mtSetUser';
    if ( ( cb == 'mtSetUser' ) && mtGetUser() ) {
        var url = document.URL;
        url = url.replace(/#.+$/, '');
        url += '#comments-open';
        location.href = url;
    } else {
        // we aren't using AJAX for this, since we may have to request
        // from a different domain. JSONP to the rescue.
        mtFetchedUser = true;
        var script = document.createElement('script');
        var ts = new Date().getTime();
        script.src = 'http://www.r-shinwa.jp/cgi-bin/mt/mt-comments.cgi?__mode=session_js&blog_id=1&jsonp=' + cb + '&ts=' + ts;
        (document.getElementsByTagName('head'))[0].appendChild(script);
    }
}



function mtRememberMeOnClick(b) {
    if (!b.checked)
        mtClearUser(b.form);
    return true;
}



var mtRequestSubmitted = false;
function mtCommentOnSubmit(f) {
    if (!mtRequestSubmitted) {
        mtRequestSubmitted = true;

        if (f.armor)
            f.armor.value = 'f96049657e028a9c5379c3b1bd03eb6860fd9b6f';
        if (f.bakecookie && f.bakecookie.checked)
            mtSaveUser(f);

        // disable submit buttons
        if (f.preview_button) f.preview_button.disabled = true;
        if (f.post) f.post.disabled = true;

        var u = mtGetUser();
        if ( !is_preview && ( u && u.is_authenticated ) ) {
            // validate session; then submit
            mtFetchedUser = false;
            mtFetchUser('mtCommentSessionVerify');
            return false;
        }

        return true;
    }
    return false;
}

function mtCommentSessionVerify(app_user) {
    var u = mtGetUser();
    var f = document['comments_form'];
    if ( u && app_user && app_user.sid && ( u.sid == app_user.sid ) ) {
        f.submit();
    } else {
        alert('セッションの有効期限が切れています。再度サインインしてください。');
        mtClearUser();
        mtFireEvent('usersignin');

        mtShow('comments-form');
        mtHide('comments-open-footer');

    }
}

function mtUserOnLoad() {
    var u = mtGetUser();

    // if the user is authenticated, hide the 'anonymous' fields
    // and any captcha input if already shown
    if ( document.getElementById('comments-form')) {
        if ( u && u.is_authenticated ) {
            mtShow('comments-form');
            mtHide('comments-open-data');
            if (mtCaptchaVisible)
                mtHide('comments-open-captcha');
        } else {

            mtHide('comments-form');

        }
        if ( u && u.is_banned )
            mtHide('comments-form');

        // if we're previewing a comment, make sure the captcha
        // field is visible
        if (is_preview)
            mtShowCaptcha();
        else
            mtShowGreeting();

        // populate anonymous comment fields if user is cookied as anonymous
        var cf = document['comments_form'];
        if (cf) {
            if (u && u.is_anonymous) {
                if (u.email) cf.email.value = u.email;
                if (u.name) cf.author.value = u.name;
                if (u.url) cf.url.value = u.url;
                if (cf.bakecookie)
                    cf.bakecookie.checked = u.name || u.email;
            } else {
                if (u && u.sid && cf.sid)
                    cf.sid.value = u.sid;
            }
            if (cf.post.disabled)
                cf.post.disabled = false;
            if (cf.preview_button.disabled)
                cf.preview_button.disabled = false;
            mtRequestSubmitted = false;
        }
    }
}




function mtEntryOnLoad() {
    
    
    mtFireEvent('usersignin');
}

function mtEntryOnUnload() {
    if (mtRequestSubmitted) {
        var cf = document['comments_form'];
        if (cf) {
            if (cf.post && cf.post.disabled)
                cf.post.disabled = false;
            if (cf.preview_button && cf.preview_button.disabled)
                cf.preview_button.disabled = false;
        }
        mtRequestSubmitted = false;
    }
    return true;
}

mtAttachEvent('usersignin', mtUserOnLoad);



function mtSignIn() {
    var doc_url = document.URL;
    doc_url = doc_url.replace(/#.+/, '');
    var url = 'http://www.r-shinwa.jp/cgi-bin/mt/mt-cp.cgi?__mode=login&blog_id=1';
    if (is_preview) {
        if ( document['comments_form'] ) {
            var entry_id = document['comments_form'].entry_id.value;
            url += '&entry_id=' + entry_id;
        } else {
            url += '&return_url=http%3A%2F%2Fwww.r-shinwa.jp%2Fkodawari%2F';
        }
    } else {
        url += '&return_url=' + encodeURIComponent(doc_url);
    }
    mtClearUser();
    location.href = url;
}

function mtSignInOnClick(sign_in_element) {
    var el;
    if (sign_in_element) {
        // display throbber
        el = document.getElementById(sign_in_element);
        if (!el)  // legacy MT 4.x element id
            el = document.getElementById('comment-form-external-auth');
    }
    if (el)
        el.innerHTML = 'サインインします... <span class="status-indicator">&nbsp;</span>';

    mtClearUser(); // clear any 'anonymous' user cookie to allow sign in
    mtFetchUser('mtSetUserOrLogin');
    return false;
}

function mtSetUserOrLogin(u) {
    if (u && u.is_authenticated) {
        mtSetUser(u);
    } else {
        // user really isn't logged in; so let's do this!
        mtSignIn();
    }
}


function mtSignOut(entry_id) {
    mtClearUser();
    var doc_url = document.URL;
    doc_url = doc_url.replace(/#.+/, '');
    var url = 'http://www.r-shinwa.jp/cgi-bin/mt/mt-cp.cgi?__mode=logout&blog_id=1';
    if (is_preview) {
        if ( document['comments_form'] ) {
            var entry_id = document['comments_form'].entry_id.value;
            url += '&entry_id=' + entry_id;
        } else {
            url += '&return_url=http%3A%2F%2Fwww.r-shinwa.jp%2Fkodawari%2F';
        }
    } else {
        url += '&return_url=' + encodeURIComponent(doc_url);
    }
    location.href = url;
}


function mtSignOutOnClick() {
    mtSignOut();
    return false;
}



function mtShowGreeting() {

    var reg_reqd = true;

    var cf = document['comments_form'];
    if (!cf) return;

    var el = document.getElementById('comment-greeting');
    if (!el)  // legacy MT 4.x element id
        el = document.getElementById('comment-form-external-auth');
    if (!el) return;

    var eid = cf.entry_id;
    var entry_id;
    if (eid) entry_id = eid.value;

    var phrase;
    var u = mtGetUser();

    if ( u && u.is_authenticated ) {
        if ( u.is_banned ) {
            phrase = 'このブログにコメントする権限を持っていません。(\<a href=\"javas\cript:void(0);\" onclick=\"return mtSignOutOnClick();\"\>サインアウトする\<\/a\>)';
        } else {
            var user_link;
            if ( u.is_author ) {
                user_link = '<a href="http://www.r-shinwa.jp/cgi-bin/mt/mt-cp.cgi?__mode=edit&amp;return_to=' + encodeURIComponent(document.URL) + '&amp;blog_id=1';
                user_link += '">' + u.name + '</a>';
            } else {
                // registered user, but not a user with posting rights
                if (u.url)
                    user_link = '<a href="' + u.url + '">' + u.name + '</a>';
                else
                    user_link = u.name;
            }
            // TBD: supplement phrase with userpic if one is available.
            phrase = '__NAME__としてサインインしています。(\<a href=\"javas\cript:void(0)\" onclick=\"return mtSignOutOnClick();\"\>サインアウト\<\/a\>)';
            phrase = phrase.replace(/__NAME__/, user_link);
        }
    } else {
        if (reg_reqd) {
            phrase = 'コメントするにはまず\<a href=\"javas\cript:void(0)\" onclick=\"return mtSignInOnClick(\'comment-greeting\')\"\>サインイン\<\/a\>してください。';
        } else {
            phrase = 'コメントする前に\<a href=\"javas\cript:void(0)\" onclick=\"return mtSignInOnClick(\'comment-greeting\')\"\>サインイン\<\/a\>することもできます。';
        }
    }
    el.innerHTML = phrase;

}



function mtReplyCommentOnClick(parent_id, author) {
    mtShow('comment-form-reply');

    var checkbox = document.getElementById('comment-reply');
    var label = document.getElementById('comment-reply-label');
    var text = document.getElementById('comment-text');

    // Populate label with new values
    var reply_text = '\<a href=\"#comment-__PARENT__\" onclick=\"location.href=this.href; return false\"\>__AUTHOR__からのコメント\<\/a\>に返信';
    reply_text = reply_text.replace(/__PARENT__/, parent_id);
    reply_text = reply_text.replace(/__AUTHOR__/, author);
    label.innerHTML = reply_text;

    checkbox.value = parent_id; 
    checkbox.checked = true;
    try {
        // text field may be hidden
        text.focus();
    } catch(e) {
    }

    mtSetCommentParentID();
}


function mtSetCommentParentID() {
    var checkbox = document.getElementById('comment-reply');
    var parent_id_field = document.getElementById('comment-parent-id');
    if (!checkbox || !parent_id_field) return;

    var pid = 0;
    if (checkbox.checked == true)
        pid = checkbox.value;
    parent_id_field.value = pid;
}


function mtSaveUser(f) {
    // We can't reliably store the user cookie during a preview.
    if (is_preview) return;

    var u = mtGetUser();

    if (f && (!u || u.is_anonymous)) {
        if ( !u ) {
            u = {};
            u.is_authenticated = false;
            u.can_comment = true;
            u.is_author = false;
            u.is_banned = false;
            u.is_anonymous = true;
            u.is_trusted = false;
        }
        if (f.author != undefined) u.name = f.author.value;
        if (f.email != undefined) u.email = f.email.value;
        if (f.url != undefined) u.url = f.url.value;
    }

    if (!u) return;

    var cache_period = mtCookieTimeout * 1000;

    // cache anonymous user info for a long period if the
    // user has requested to be remembered
    if (u.is_anonymous && f && f.bakecookie && f.bakecookie.checked)
        cache_period = 365 * 24 * 60 * 60 * 1000;

    var now = new Date();
    mtFixDate(now);
    now.setTime(now.getTime() + cache_period);

    var cmtcookie = mtBakeUserCookie(u);
    mtSetCookie(mtCookieName, cmtcookie, now, mtCookiePath, mtCookieDomain,
        location.protocol == 'https:');
}


function mtClearUser() {
    user = null;
    mtDeleteCookie(mtCookieName, mtCookiePath, mtCookieDomain,
        location.protocol == 'https:');
}


function mtSetCookie(name, value, expires, path, domain, secure) {
    if (domain && domain.match(/^\.?localhost$/))
        domain = null;
    var curCookie = name + "=" + escape(value) +
        (expires ? "; expires=" + expires.toGMTString() : "") +
        (path ? "; path=" + path : "") +
        (domain ? "; domain=" + domain : "") +
        (secure ? "; secure" : "");
    document.cookie = curCookie;
}


function mtGetCookie(name) {
    var prefix = name + '=';
    var c = document.cookie;
    var cookieStartIndex = c.indexOf(prefix);
    if (cookieStartIndex == -1)
        return '';
    var cookieEndIndex = c.indexOf(";", cookieStartIndex + prefix.length);
    if (cookieEndIndex == -1)
        cookieEndIndex = c.length;
    return unescape(c.substring(cookieStartIndex + prefix.length, cookieEndIndex));
}


function mtDeleteCookie(name, path, domain, secure) {
    if (mtGetCookie(name)) {
        if (domain && domain.match(/^\.?localhost$/))
            domain = null;
        document.cookie = name + "=" +
            (path ? "; path=" + path : "") +
            (domain ? "; domain=" + domain : "") +
            (secure ? "; secure" : "") +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
}

function mtFixDate(date) {
    var skew = (new Date(0)).getTime();
    if (skew > 0)
        date.setTime(date.getTime() - skew);
}


function mtGetXmlHttp() {
    if ( !window.XMLHttpRequest ) {
        window.XMLHttpRequest = function() {
            var types = [
                "Microsoft.XMLHTTP",
                "MSXML2.XMLHTTP.5.0",
                "MSXML2.XMLHTTP.4.0",
                "MSXML2.XMLHTTP.3.0",
                "MSXML2.XMLHTTP"
            ];

            for ( var i = 0; i < types.length; i++ ) {
                try {
                    return new ActiveXObject( types[ i ] );
                } catch( e ) {}
            }

            return undefined;
        };
    }
    if ( window.XMLHttpRequest )
        return new XMLHttpRequest();
}

// BEGIN: fast browser onload init
// Modifications by David Davis, DWD
// Dean Edwards/Matthias Miller/John Resig
// http://dean.edwards.name/weblog/2006/06/again/?full#comment5338

function mtInit() {
    // quit if this function has already been called
    if (arguments.callee.done) return;

    // flag this function so we don't do the same thing twice
    arguments.callee.done = true;

    // kill the timer
    // DWD - check against window
    if ( window._timer ) clearInterval(window._timer);

    // DWD - fire the window onload now, and replace it
    if ( window.onload && ( window.onload !== window.mtInit ) ) {
        window.onload();
        window.onload = function() {};
    }
}

/* for Mozilla/Opera9 */
if (document.addEventListener) {
    document.addEventListener("DOMContentLoaded", mtInit, false);
}

/* for Internet Explorer */
/*@cc_on @*/
/*@if (@_win32)
document.write("<script id=__ie_onload defer src=javascript:void(0)><\/script>");
var script = document.getElementById("__ie_onload");
script.onreadystatechange = function() {
    if (this.readyState == "complete") {
        mtInit(); // call the onload handler
    }
};
/*@end @*/

/* for Safari */
if (/WebKit/i.test(navigator.userAgent)) { // sniff
    _timer = setInterval(function() {
        if (/loaded|complete/.test(document.readyState)) {
            mtInit(); // call the onload handler
        }
    }, 10);
}

/* for other browsers */
window.onload = mtInit;

// END: fast browser onload init



/***
 * If request contains a '#_login' or '#_logout' hash, use this to
 * also delete the blog-side user cookie, since we're coming back from
 * a login, logout or edit profile operation.
 */
var clearCookie = ( window.location.hash && window.location.hash.match( /^#_log(in|out)/ ) ) ? true : false;
if (clearCookie) {
    // clear any logged in state
    mtClearUser();
    if (RegExp.$1 == 'in')
        mtFetchUser();
} else {
    
    if ( is_preview && !user )
        mtFetchUser();
}





