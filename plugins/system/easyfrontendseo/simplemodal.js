/*
* Mootools Simple Modal
* Version 1.0
* Copyright (c) 2011 Marco Dell'Anna - http://www.plasm.it
*
* EFSEO - Easy Frontend SEO - http://joomla-extensions.kubik-rubik.de/efseo-easy-frontend-seo
*/
var SimpleModal=new Class({Implements:[Options],request:null,buttons:[],options:{onAppend:Function,offsetTop:null,overlayOpacity:.8,overlayColor:"#000000",width:400,draggable:true,overlayClick:true,closeButton:true,hideHeader:false,hideFooter:false,btn_ok:"OK",btn_cancel:"Cancel",template:'<div class="simple-modal-header"> \n            <h1>{_TITLE_}</h1> \n          </div> \n          <div class="simple-modal-body"> \n            <div class="contents">{_CONTENTS_}</div> \n          </div> \n          <div class="simple-modal-footer"></div>'},initialize:function(a){this.setOptions(a)},show:function(a){if(!a)a={};this._overlay("show");switch(a.model){case"confirm":this.addButton(this.options.btn_ok,"btn primary btn-margin",function(){try{a.callback()}catch(b){}this.hide()});this.addButton(this.options.btn_cancel,"btn secondary");var b=this._drawWindow(a);break;case"modal":var b=this._drawWindow(a);break;case"modal-ajax":var b=this._drawWindow(a);this._loadContents({url:a.param.url||"",onRequestComplete:a.param.onRequestComplete||Function});break;default:this.addButton(this.options.btn_ok,"btn primary");var b=this._drawWindow(a);break}b.setStyles({width:this.options.width});if(this.options.hideHeader)b.addClass("hide-header");if(this.options.hideFooter)b.addClass("hide-footer");if(this.options.closeButton)this._addCloseButton();if(this.options.draggable){var c=b.getElement(".simple-modal-header");new Drag(b,{handle:c});c.setStyle("cursor","move");b.addClass("draggable")}this._display()},hide:function(){try{if(typeof this.request=="object")this.request.cancel()}catch(a){}this._overlay("hide");return},_drawWindow:function(a){var b=new Element("div#simple-modal",{"class":"simple-modal"});b.inject($$("body")[0]);var c=this._template(this.options.template,{_TITLE_:a.title||"Untitled",_CONTENTS_:a.contents||""});b.set("html",c);this._injectAllButtons();this.options.onAppend();return b},addButton:function(a,b,c){var d=new Element("a",{title:a,text:a,"class":b,events:{click:(c||this.hide).bind(this)}});this.buttons.push(d);return d},_injectAllButtons:function(){this.buttons.each(function(a,b){a.inject($("simple-modal").getElement(".simple-modal-footer"))});return},_addCloseButton:function(){var a=new Element("a",{"class":"close",href:"#",html:"x"});a.inject($("simple-modal"),"top");a.addEvent("click",function(a){if(a)a.stop();this.hide()}.bind(this));return a},_overlay:function(a){switch(a){case"show":this._overlay("hide");var b=new Element("div",{id:"simple-modal-overlay"});b.inject($$("body")[0]);b.setStyle("background-color",this.options.overlayColor);b.fade("hide").fade(this.options.overlayOpacity);if(this.options.overlayClick){b.addEvent("click",function(a){if(a)a.stop();this.hide()}.bind(this))}this.__resize=this._display.bind(this);window.addEvent("resize",this.__resize);break;case"hide":window.removeEvent("resize");try{$("simple-modal-overlay").destroy()}catch(c){}try{$("simple-modal").destroy()}catch(c){}break}return},_loadContents:function(param){$("simple-modal").addClass("loading");var re=new RegExp(/([^\/\\]+)\.(jpg|png|gif)$/i);if(param.url.match(re)){$("simple-modal").addClass("hide-footer");$("simple-modal-overlay").removeEvents();var images=[param.url];new Asset.images(images,{onProgress:function(a){immagine=this},onComplete:function(){try{$("simple-modal").removeClass("loading");var a=$("simple-modal").getElement(".contents");var b=a.getStyle("padding").split(" ");var c=immagine.get("width").toInt()+(b[1].toInt()+b[3].toInt());var d=immagine.get("height").toInt();var e=(new Fx.Tween($("simple-modal"),{duration:"normal",transition:"sine:out",link:"cancel",property:"width"})).start($("simple-modal").getCoordinates().width,c);var f=(new Fx.Tween(a,{duration:"normal",transition:"sine:out",link:"cancel",property:"height"})).start(a.getCoordinates().height,d).chain(function(){immagine.inject($("simple-modal").getElement(".contents").empty()).fade("hide").fade("in");this._display()}.bind(this));var g=(new Fx.Tween($("simple-modal"),{duration:"normal",transition:"sine:out",link:"cancel",property:"left"})).start($("simple-modal").getCoordinates().left,(window.getCoordinates().width-c)/2)}catch(h){}}.bind(this)})}else{this.request=(new Request.HTML({evalScripts:false,url:param.url,method:"get",onRequest:function(){},onSuccess:function(responseTree,responseElements,responseHTML,responseJavaScript){$("simple-modal").removeClass("loading");param.onRequestComplete();$("simple-modal").getElement(".contents").set("html",responseHTML);eval(responseJavaScript);this._display()}.bind(this),onFailure:function(){$("simple-modal").removeClass("loading");$("simple-modal").getElement(".contents").set("html","loading failed")}})).send()}},_display:function(){try{$("simple-modal-overlay").setStyles({height:window.getCoordinates().height})}catch(a){}try{var b=this.options.offsetTop||40;$("simple-modal").setStyles({top:b,left:(window.getCoordinates().width-$("simple-modal").getCoordinates().width)/2})}catch(a){}return},_template:function(a,b){for(var c in b)a=a.replace(new RegExp("{"+c+"}","g"),b[c]);return a}})