var XPWeather = Class.create();
XPWeather.prototype = {

	initialize: function(baseurl){
		
		this._baseurl = baseurl;
		this._suggest = new XPWeatherSuggest(baseurl, 'XPWeather_input', 'XPWeather_suggest_list');
		//this._suggest.finishedTagList = $('XPWeather_list')
		//this._suggest.clickAdd = function(tag){this.add_func(tag);}.bind(this);
	}
}

var XPWeatherSuggest = Class.create();
XPWeatherSuggest.prototype = {
	initialize: function(baseurl, input, list){
		
		if (!Form.Element.Observer.prototype.registerCallback)
		{
			Form.Element.Observer.prototype.registerCallback=function(){
				this.interval = setInterval(this.onTimerEvent.bind(this), this.frequency * 1000);
			};
		}
		if (!Form.Element.Observer.prototype.clearTimerEvent)
		{
			Form.Element.Observer.prototype.clearTimerEvent=function(){
				clearInterval(this.interval);
			};
		}
		if (!Form.Element.Observer.prototype.onTimerEvent)
		{
			Form.Element.Observer.prototype.onTimerEvent=function(){
				try{
					var node = this.element.parentNode.tagName;
				}catch(e){
					this.clearTimerEvent();
				}	 
				var value = this.getValue();
				if (this.lastValue != value) {
					this.callback(this.element, value);
					this.lastValue = value;
				}
			};
		}
		
		this._baseurl      = baseurl;
		this._posturl      = baseurl + "/modules/XP-Weather/complete.php";
		this.tagText       = $(input);
		this.candidateList = $(list);
		this.finishedTagList = null;
		this.candidateTags = new Array();
		this.selectedCandidateTagsIndex = 0;
		this.finishedTagText = "";
		this.inputtingTag = "";
		this.active = false;
		this.focus = false;
		this.observactive = false;
		this.clickAdd = false;
		
		this.nonhit_key = "";
		this.selected = false;
		this.reqestOption=['If-Modified-Since','Wed, 15 Nov 1995 00:00:00 GMT'];

		this.candidateList.style.position = 'absolute';
		this.tagText.setAttribute("autocomplete", "off");
		
		setTimeout(this.init_candidateList_pos.bind(this),300);
				
		this.hideCandidateList();
		this.startObserver();
	
		Event.observe(this.tagText, "keypress", this.onKeyPress.bindAsEventListener(this));
		Event.observe(this.tagText, "blur", this.onBlur.bindAsEventListener(this));
	},
	
	init_candidateList_pos: function() {
		var offsets = Position.positionedOffset(this.tagText);
		this.candidateList.style.left = offsets[0] + 'px';
		this.candidateList.style.top  = (offsets[1] + this.tagText.offsetHeight) + 'px';
		this.candidateList.style.width = this.tagText.offsetWidth + 'px';
	},
		
	startObserver: function(){
		if(this.observactive) return;
		this.observer = new Form.Element.Observer(this.tagText,0.3,this.tagTextOnChange.bind(this));
		this.observactive = true;
	},
	stopObserver: function(){
		this.observer.clearTimerEvent();
		this.observactive = false;
	},
	
	tagTextOnChange: function(){
		if($F(this.tagText).length == 0){
			this.candidateTags = new Array();
			this.selectedCandidateTagsIndex = 0;
			this.finishedTagText = "";
			this.inputtingTag = "";
			this.nonhit_key = "";
			this.updateCandidateTags();
			this.showCandidateList();
			return;
		}
		if (!this.nonhit_key || $F(this.tagText).indexOf(this.nonhit_key,0) != 0)
		{
			var _nowindex = this.selectedCandidateTagsIndex;
			if (this.candidateTags.length && $F(this.tagText) == this.quoteTag(this.getEntry(_nowindex).innerHTML))
			{
				return;
			}
			Log.info('server access');
			var params = "q=" + encodeURIComponent($F(this.tagText));
			Log.info(params);
			new Ajax.Request(
				this._posturl,{
				method: "get",
				parameters: params,
				onComplete: this.onTagSplitComplete.bind(this),
				requestHeaders: this.reqestOption
			});
		}
	},
	
	onTagSplitComplete: function(originalRequest){
		
		try{
			Log.debug(originalRequest.responseText);
			eval (originalRequest.responseText);
		}catch(e){Log.error(e);}		
	},
	
	setSuggest: function(q,tag)
	{
		if (tag.length < 1)
		{
			this.nonhit_key = q;
		}
		else
		{
			this.nonhit_key = "";
		}
		
		var tags = this.getFinishedTags();
		if (q != "") {

		}
		else
		{
			var _tag = new Array();
			tag.each( function(word) {
				if (tags.indexOf(word) == -1)
					_tag.push(word);
			});
			tag = _tag;
		}
		
		this.finishedTagText = "";
		this.inputtingTag = q;
		this.candidateTags = tag;
		this.selected = false;
		
		this.updateCandidateTags();
		this.showCandidateList();
	},

	getFinishedTags: function() {
		var tags = new Array();
		if (this.finishedTagList)
		{
			for(var i=0;i<this.finishedTagList.childNodes.length;i++){
				if(this.finishedTagList.childNodes[i].nodeName == 'SPAN'){
				    //@ref http://developer.mozilla.org/en/docs/Whitespace_in_the_DOM
					tags[tags.length] = this.finishedTagList.childNodes[i].firstChild.data.replace(/[\t\n\r ]+/g, "");
				}
			}
		}
		return tags;
	},

	isMatch: function(value, pattern) {
		value = this.escTag(value);
		if (!pattern) return value;
		pattern = this.escTag(pattern);
		pattern = this.regQuote(this.escTag(pattern));
		
		var re = new RegExp("(" + pattern + ")", "ig");
		return value.replace(re, "<b>$1</b>");
	},

	updateCandidateTags: function(){
		this.selectedCandidateTagsIndex=0;
		if(this.candidateList.firstChild) this.candidateList.removeChild(this.candidateList.firstChild);
		
		if(this.candidateTags.length == 0){
			this.hideCandidateList();
			return;
		}
		
		var ul = document.createElement("ul");
		for(var i=0;i<this.candidateTags.length;i++){
			var li = document.createElement("li");
			//li.appendChild(document.createTextNode(this.candidateTags[i]));
			li.innerHTML = this.isMatch(this.candidateTags[i],this.inputtingTag);
			li.autocompleteIndex = i;
			li.title=this.candidateTags[i];
			li.onmousedown = function(event){
				var ele = Event.findElement(event || window.event,'LI');
				if (this.clickAdd)
				{
					this.clickAdd(this.quoteTag(ele.innerHTML));
					setTimeout(function(){this.tagText.focus();}.bind(this),1);
				}
				else
				{
					this.focus = true;
					this.updateTagText(ele.innerHTML);
					setTimeout(function(){this.focus=false}.bind(this),1);
				}
			}.bind(this);
			li.onmouseover = function(event){
				var ele = Event.findElement(event || window.event,'LI');
				Element.addClassName(ele,"selected"); 
			}.bind(this);
			li.onmouseout = function(event){
				var ele = Event.findElement(event || window.event,'LI');
				Element.removeClassName(ele,"selected");
			}.bind(this);
			ul.appendChild(li);
		}
		
		this.candidateList.appendChild(ul);
	},
	
	showCandidateList: function(){
		this.hideCandidateList();
		if(this.candidateTags.length == 0) return;
		Element.show(this.candidateList);
		this.active = true;
		this.markSelected();
	},
	
	hideCandidateList: function(){
		Element.hide(this.candidateList);
		this.active = false;
	},
	
	onBlur: function(event){
		if(this.focus){
			Log.debug('onblur cancel. because focus:'+this.focus);
			Field.focus(this.tagText);
			if(this.tagText.createTextRange) {
				Log.info('createTextRange');
				var t=this.tagText.createTextRange();
				t.moveStart("character",this.tagText.value.length);
				t.select();
	      	}
			return;
		}
		this.hideCandidateList();
	},
	
	onKeyPress: function(event){
		if(this.active){
			switch(event.keyCode) {
				//case Event.KEY_TAB:
				//case Event.KEY_RETURN:
				//	this.selectEntry();
				//	Event.stop(event);
				//	return;
				case Event.KEY_ESC:
					this.hideCandidateList();
					return;
				//case Event.KEY_LEFT:
				case Event.KEY_UP:
					this.markPrevious();
					if(navigator.appVersion.indexOf('AppleWebKit')>0) Event.stop(event);
					return;
				//case Event.KEY_RIGHT:
				case Event.KEY_DOWN:
					this.markNext();
					if(navigator.appVersion.indexOf('AppleWebKit')>0) Event.stop(event);
					return;
				default:
					if(navigator.appVersion.indexOf('AppleWebKit')>0) this.hideCandidateList();
					return;
			}
		}else{
			if(event.keyCode == Event.KEY_DOWN || event.keyCode == Event.KEY_UP){
				if($F(this.tagText).match(/[\s]+$/) == null){
					this.tagTextOnChange();
					Event.stop(event);
				}
			}
		}
	},
  
	getEntry: function(index) {
		return this.candidateList.firstChild.childNodes[index];
	},

	markPrevious: function() {
		Element.removeClassName(this.getEntry(this.selectedCandidateTagsIndex),"selected");
		if(this.selectedCandidateTagsIndex > 0) this.selectedCandidateTagsIndex--
			else this.selectedCandidateTagsIndex = this.candidateTags.length-1;
		Element.addClassName(this.getEntry(this.selectedCandidateTagsIndex),"selected");
		$(this.tagText).value = this.quoteTag(this.getEntry(this.selectedCandidateTagsIndex).innerHTML);
		this.selected = true;
	},
  
	markNext: function() {
	
		Element.removeClassName(this.getEntry(this.selectedCandidateTagsIndex),"selected");
		if(this.selected && this.selectedCandidateTagsIndex < this.candidateTags.length-1) this.selectedCandidateTagsIndex++
			else this.selectedCandidateTagsIndex = 0;
		Element.addClassName(this.getEntry(this.selectedCandidateTagsIndex),"selected");
		$(this.tagText).value = this.quoteTag(this.getEntry(this.selectedCandidateTagsIndex).innerHTML);
		this.selected = true;
	},
	
	markSelected: function() {
		if( this.selected && this.candidateTags.length > 0) {
			for (var i = 0; i <	 this.candidateTags.length; i++){
				this.selectedCandidateTagsIndex==i ? 
					Element.addClassName(this.getEntry(i),"selected") : 
					Element.removeClassName(this.getEntry(i),"selected");
			}
		}
	},
	
	selectEntry: function() {
		var entry = this.getEntry(this.selectedCandidateTagsIndex);
		this.updateTagText(entry.innerHTML);
	},
	
	updateTagText: function(str) {
		str = this.quoteTag(str);
		Log.info('select tag : \"'+ str + '"');
		this.stopObserver();
		this.inputtingTag = str;
		
		this.tagText.value = str;
		this.hideCandidateList();

		if (this.tagText.setSelectionRange) {
			Log.info('setSelectionRange');
			this.tagText.select();
			this.tagText.setSelectionRange(this.tagText.value.length,this.tagText.value.length);
		}
		
		this.startObserver();
	},
	
	quoteTag: function(tag) {  
		tag = tag.replace(/^[\s]+/,"");
		tag = tag.replace(/[\s]+$/,"");
		tag = tag.replace(/[\s]+/g," ");
		tag = tag.replace(/<.+?>/g,"");
		
		tag = tag.replace(/&lt;/gi,"<");
		tag = tag.replace(/&gt;/gi,">");
		
		if(tag.length == 0) return "";
		
		return tag;
		/*
		var quote="";
		
		if(tag.match(/"/) && tag.match(/'/)){
			tag = tag.replace(/"/g,"'");
			quote = '"';
		}else if(tag.match(/"/)){
			(tag.match(/[\s,]/) || tag.match(/^"/)) ? quote = "'" : quote = "";
		}else if(tag.match(/'/)){
			(tag.match(/[\s,]/) || tag.match(/^'/)) ? quote = '"' : quote = "";
		}else if(tag.match(/[\s,]/)){
			 quote = '"';
		}
		return quote + tag + quote;
		*/
	},
	
	escTag : function(tag) {
		tag = tag.replace(/</g,"&lt;");
		tag = tag.replace(/>/g,"&gt;");
		return tag;
	},
	
	regQuote : function(v) {
		return v.replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g,"\\$1");
	}
}