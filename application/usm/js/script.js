/**
 * jQuery EasyUI 1.5.2
 *
 * Copyright (c) 2009-2017 www.jeasyui.com. All rights reserved.
 *
 * Licensed under the freeware license: http://www.jeasyui.com/license_freeware.php
 * To use it on other terms please contact us: info@jeasyui.com
 *
 */
(function($){
$.easyui={indexOfArray:function(a,o,id){
for(var i=0,_1=a.length;i<_1;i++){
if(id==undefined){
if(a[i]==o){
return i;
}
}else{
if(a[i][o]==id){
return i;
}
}
}
return -1;
},removeArrayItem:function(a,o,id){
if(typeof o=="string"){
for(var i=0,_2=a.length;i<_2;i++){
if(a[i][o]==id){
a.splice(i,1);
return;
}
}
}else{
var _3=this.indexOfArray(a,o);
if(_3!=-1){
a.splice(_3,1);
}
}
},addArrayItem:function(a,o,r){
var _4=this.indexOfArray(a,o,r?r[o]:undefined);
if(_4==-1){
a.push(r?r:o);
}else{
a[_4]=r?r:o;
}
},getArrayItem:function(a,o,id){
var _5=this.indexOfArray(a,o,id);
return _5==-1?null:a[_5];
},forEach:function(_6,_7,_8){
var _9=[];
for(var i=0;i<_6.length;i++){
_9.push(_6[i]);
}
while(_9.length){
var _a=_9.shift();
if(_8(_a)==false){
return;
}
if(_7&&_a.children){
for(var i=_a.children.length-1;i>=0;i--){
_9.unshift(_a.children[i]);
}
}
}
}};
$.parser={auto:true,onComplete:function(_b){
},plugins:["draggable","droppable","resizable","pagination","tooltip","linkbutton","menu","menubutton","splitbutton","switchbutton","progressbar","tree","textbox","passwordbox","filebox","combo","combobox","combotree","combogrid","combotreegrid","tagbox","numberbox","validatebox","searchbox","spinner","numberspinner","timespinner","datetimespinner","calendar","datebox","datetimebox","slider","layout","panel","datagrid","propertygrid","treegrid","datalist","tabs","accordion","window","dialog","form"],parse:function(_c){
var aa=[];
for(var i=0;i<$.parser.plugins.length;i++){
var _d=$.parser.plugins[i];
var r=$(".easyui-"+_d,_c);
if(r.length){
if(r[_d]){
r.each(function(){
$(this)[_d]($.data(this,"options")||{});
});
}else{
aa.push({name:_d,jq:r});
}
}
}
if(aa.length&&window.easyloader){
var _e=[];
for(var i=0;i<aa.length;i++){
_e.push(aa[i].name);
}
easyloader.load(_e,function(){
for(var i=0;i<aa.length;i++){
var _f=aa[i].name;
var jq=aa[i].jq;
jq.each(function(){
$(this)[_f]($.data(this,"options")||{});
});
}
$.parser.onComplete.call($.parser,_c);
});
}else{
$.parser.onComplete.call($.parser,_c);
}
},parseValue:function(_10,_11,_12,_13){
_13=_13||0;
var v=$.trim(String(_11||""));
var _14=v.substr(v.length-1,1);
if(_14=="%"){
v=parseFloat(v.substr(0,v.length-1));
if(_10.toLowerCase().indexOf("width")>=0){
v=Math.floor((_12.width()-_13)*v/100);
}else{
v=Math.floor((_12.height()-_13)*v/100);
}
}else{
v=parseInt(v)||undefined;
}
return v;
},parseOptions:function(_15,_16){
var t=$(_15);
var _17={};
var s=$.trim(t.attr("data-options"));
if(s){
if(s.substring(0,1)!="{"){
s="{"+s+"}";
}
_17=(new Function("return "+s))();
}
$.map(["width","height","left","top","minWidth","maxWidth","minHeight","maxHeight"],function(p){
var pv=$.trim(_15.style[p]||"");
if(pv){
if(pv.indexOf("%")==-1){
pv=parseInt(pv);
if(isNaN(pv)){
pv=undefined;
}
}
_17[p]=pv;
}
});
if(_16){
var _18={};
for(var i=0;i<_16.length;i++){
var pp=_16[i];
if(typeof pp=="string"){
_18[pp]=t.attr(pp);
}else{
for(var _19 in pp){
var _1a=pp[_19];
if(_1a=="boolean"){
_18[_19]=t.attr(_19)?(t.attr(_19)=="true"):undefined;
}else{
if(_1a=="number"){
_18[_19]=t.attr(_19)=="0"?0:parseFloat(t.attr(_19))||undefined;
}
}
}
}
}
$.extend(_17,_18);
}
return _17;
}};
$(function(){
var d=$("<div style=\"position:absolute;top:-1000px;width:100px;height:100px;padding:5px\"></div>").appendTo("body");
$._boxModel=d.outerWidth()!=100;
d.remove();
d=$("<div style=\"position:fixed\"></div>").appendTo("body");
$._positionFixed=(d.css("position")=="fixed");
d.remove();
if(!window.easyloader&&$.parser.auto){
$.parser.parse();
}
});
$.fn._outerWidth=function(_1b){
if(_1b==undefined){
if(this[0]==window){
return this.width()||document.body.clientWidth;
}
return this.outerWidth()||0;
}
return this._size("width",_1b);
};
$.fn._outerHeight=function(_1c){
if(_1c==undefined){
if(this[0]==window){
return this.height()||document.body.clientHeight;
}
return this.outerHeight()||0;
}
return this._size("height",_1c);
};
$.fn._scrollLeft=function(_1d){
if(_1d==undefined){
return this.scrollLeft();
}else{
return this.each(function(){
$(this).scrollLeft(_1d);
});
}
};
$.fn._propAttr=$.fn.prop||$.fn.attr;
$.fn._size=function(_1e,_1f){
if(typeof _1e=="string"){
if(_1e=="clear"){
return this.each(function(){
$(this).css({width:"",minWidth:"",maxWidth:"",height:"",minHeight:"",maxHeight:""});
});
}else{
if(_1e=="fit"){
return this.each(function(){
_20(this,this.tagName=="BODY"?$("body"):$(this).parent(),true);
});
}else{
if(_1e=="unfit"){
return this.each(function(){
_20(this,$(this).parent(),false);
});
}else{
if(_1f==undefined){
return _21(this[0],_1e);
}else{
return this.each(function(){
_21(this,_1e,_1f);
});
}
}
}
}
}else{
return this.each(function(){
_1f=_1f||$(this).parent();
$.extend(_1e,_20(this,_1f,_1e.fit)||{});
var r1=_22(this,"width",_1f,_1e);
var r2=_22(this,"height",_1f,_1e);
if(r1||r2){
$(this).addClass("easyui-fluid");
}else{
$(this).removeClass("easyui-fluid");
}
});
}
function _20(_23,_24,fit){
if(!_24.length){
return false;
}
var t=$(_23)[0];
var p=_24[0];
var _25=p.fcount||0;
if(fit){
if(!t.fitted){
t.fitted=true;
p.fcount=_25+1;
$(p).addClass("panel-noscroll");
if(p.tagName=="BODY"){
$("html").addClass("panel-fit");
}
}
return {width:($(p).width()||1),height:($(p).height()||1)};
}else{
if(t.fitted){
t.fitted=false;
p.fcount=_25-1;
if(p.fcount==0){
$(p).removeClass("panel-noscroll");
if(p.tagName=="BODY"){
$("html").removeClass("panel-fit");
}
}
}
return false;
}
};
function _22(_26,_27,_28,_29){
var t=$(_26);
var p=_27;
var p1=p.substr(0,1).toUpperCase()+p.substr(1);
var min=$.parser.parseValue("min"+p1,_29["min"+p1],_28);
var max=$.parser.parseValue("max"+p1,_29["max"+p1],_28);
var val=$.parser.parseValue(p,_29[p],_28);
var _2a=(String(_29[p]||"").indexOf("%")>=0?true:false);
if(!isNaN(val)){
var v=Math.min(Math.max(val,min||0),max||99999);
if(!_2a){
_29[p]=v;
}
t._size("min"+p1,"");
t._size("max"+p1,"");
t._size(p,v);
}else{
t._size(p,"");
t._size("min"+p1,min);
t._size("max"+p1,max);
}
return _2a||_29.fit;
};
function _21(_2b,_2c,_2d){
var t=$(_2b);
if(_2d==undefined){
_2d=parseInt(_2b.style[_2c]);
if(isNaN(_2d)){
return undefined;
}
if($._boxModel){
_2d+=_2e();
}
return _2d;
}else{
if(_2d===""){
t.css(_2c,"");
}else{
if($._boxModel){
_2d-=_2e();
if(_2d<0){
_2d=0;
}
}
t.css(_2c,_2d+"px");
}
}
function _2e(){
if(_2c.toLowerCase().indexOf("width")>=0){
return t.outerWidth()-t.width();
}else{
return t.outerHeight()-t.height();
}
};
};
};
})(jQuery);
(function($){
var _2f=null;
var _30=null;
var _31=false;
function _32(e){
if(e.touches.length!=1){
return;
}
if(!_31){
_31=true;
dblClickTimer=setTimeout(function(){
_31=false;
},500);
}else{
clearTimeout(dblClickTimer);
_31=false;
_33(e,"dblclick");
}
_2f=setTimeout(function(){
_33(e,"contextmenu",3);
},1000);
_33(e,"mousedown");
if($.fn.draggable.isDragging||$.fn.resizable.isResizing){
e.preventDefault();
}
};
function _34(e){
if(e.touches.length!=1){
return;
}
if(_2f){
clearTimeout(_2f);
}
_33(e,"mousemove");
if($.fn.draggable.isDragging||$.fn.resizable.isResizing){
e.preventDefault();
}
};
function _35(e){
if(_2f){
clearTimeout(_2f);
}
_33(e,"mouseup");
if($.fn.draggable.isDragging||$.fn.resizable.isResizing){
e.preventDefault();
}
};
function _33(e,_36,_37){
var _38=new $.Event(_36);
_38.pageX=e.changedTouches[0].pageX;
_38.pageY=e.changedTouches[0].pageY;
_38.which=_37||1;
$(e.target).trigger(_38);
};
if(document.addEventListener){
document.addEventListener("touchstart",_32,true);
document.addEventListener("touchmove",_34,true);
document.addEventListener("touchend",_35,true);
}
})(jQuery);
(function($){
function _39(e){
var _3a=$.data(e.data.target,"draggable");
var _3b=_3a.options;
var _3c=_3a.proxy;
var _3d=e.data;
var _3e=_3d.startLeft+e.pageX-_3d.startX;
var top=_3d.startTop+e.pageY-_3d.startY;
if(_3c){
if(_3c.parent()[0]==document.body){
if(_3b.deltaX!=null&&_3b.deltaX!=undefined){
_3e=e.pageX+_3b.deltaX;
}else{
_3e=e.pageX-e.data.offsetWidth;
}
if(_3b.deltaY!=null&&_3b.deltaY!=undefined){
top=e.pageY+_3b.deltaY;
}else{
top=e.pageY-e.data.offsetHeight;
}
}else{
if(_3b.deltaX!=null&&_3b.deltaX!=undefined){
_3e+=e.data.offsetWidth+_3b.deltaX;
}
if(_3b.deltaY!=null&&_3b.deltaY!=undefined){
top+=e.data.offsetHeight+_3b.deltaY;
}
}
}
if(e.data.parent!=document.body){
_3e+=$(e.data.parent).scrollLeft();
top+=$(e.data.parent).scrollTop();
}
if(_3b.axis=="h"){
_3d.left=_3e;
}else{
if(_3b.axis=="v"){
_3d.top=top;
}else{
_3d.left=_3e;
_3d.top=top;
}
}
};
function _3f(e){
var _40=$.data(e.data.target,"draggable");
var _41=_40.options;
var _42=_40.proxy;
if(!_42){
_42=$(e.data.target);
}
_42.css({left:e.data.left,top:e.data.top});
$("body").css("cursor",_41.cursor);
};
function _43(e){
if(!$.fn.draggable.isDragging){
return false;
}
var _44=$.data(e.data.target,"draggable");
var _45=_44.options;
var _46=$(".droppable:visible").filter(function(){
return e.data.target!=this;
}).filter(function(){
var _47=$.data(this,"droppable").options.accept;
if(_47){
return $(_47).filter(function(){
return this==e.data.target;
}).length>0;
}else{
return true;
}
});
_44.droppables=_46;
var _48=_44.proxy;
if(!_48){
if(_45.proxy){
if(_45.proxy=="clone"){
_48=$(e.data.target).clone().insertAfter(e.data.target);
}else{
_48=_45.proxy.call(e.data.target,e.data.target);
}
_44.proxy=_48;
}else{
_48=$(e.data.target);
}
}
_48.css("position","absolute");
_39(e);
_3f(e);
_45.onStartDrag.call(e.data.target,e);
return false;
};
function _49(e){
if(!$.fn.draggable.isDragging){
return false;
}
var _4a=$.data(e.data.target,"draggable");
_39(e);
if(_4a.options.onDrag.call(e.data.target,e)!=false){
_3f(e);
}
var _4b=e.data.target;
_4a.droppables.each(function(){
var _4c=$(this);
if(_4c.droppable("options").disabled){
return;
}
var p2=_4c.offset();
if(e.pageX>p2.left&&e.pageX<p2.left+_4c.outerWidth()&&e.pageY>p2.top&&e.pageY<p2.top+_4c.outerHeight()){
if(!this.entered){
$(this).trigger("_dragenter",[_4b]);
this.entered=true;
}
$(this).trigger("_dragover",[_4b]);
}else{
if(this.entered){
$(this).trigger("_dragleave",[_4b]);
this.entered=false;
}
}
});
return false;
};
function _4d(e){
if(!$.fn.draggable.isDragging){
_4e();
return false;
}
_49(e);
var _4f=$.data(e.data.target,"draggable");
var _50=_4f.proxy;
var _51=_4f.options;
if(_51.revert){
if(_52()==true){
$(e.data.target).css({position:e.data.startPosition,left:e.data.startLeft,top:e.data.startTop});
}else{
if(_50){
var _53,top;
if(_50.parent()[0]==document.body){
_53=e.data.startX-e.data.offsetWidth;
top=e.data.startY-e.data.offsetHeight;
}else{
_53=e.data.startLeft;
top=e.data.startTop;
}
_50.animate({left:_53,top:top},function(){
_54();
});
}else{
$(e.data.target).animate({left:e.data.startLeft,top:e.data.startTop},function(){
$(e.data.target).css("position",e.data.startPosition);
});
}
}
}else{
$(e.data.target).css({position:"absolute",left:e.data.left,top:e.data.top});
_52();
}
_51.onStopDrag.call(e.data.target,e);
_4e();
function _54(){
if(_50){
_50.remove();
}
_4f.proxy=null;
};
function _52(){
var _55=false;
_4f.droppables.each(function(){
var _56=$(this);
if(_56.droppable("options").disabled){
return;
}
var p2=_56.offset();
if(e.pageX>p2.left&&e.pageX<p2.left+_56.outerWidth()&&e.pageY>p2.top&&e.pageY<p2.top+_56.outerHeight()){
if(_51.revert){
$(e.data.target).css({position:e.data.startPosition,left:e.data.startLeft,top:e.data.startTop});
}
$(this).trigger("_drop",[e.data.target]);
_54();
_55=true;
this.entered=false;
return false;
}
});
if(!_55&&!_51.revert){
_54();
}
return _55;
};
return false;
};
function _4e(){
if($.fn.draggable.timer){
clearTimeout($.fn.draggable.timer);
$.fn.draggable.timer=undefined;
}
$(document).unbind(".draggable");
$.fn.draggable.isDragging=false;
setTimeout(function(){
$("body").css("cursor","");
},100);
};
$.fn.draggable=function(_57,_58){
if(typeof _57=="string"){
return $.fn.draggable.methods[_57](this,_58);
}
return this.each(function(){
var _59;
var _5a=$.data(this,"draggable");
if(_5a){
_5a.handle.unbind(".draggable");
_59=$.extend(_5a.options,_57);
}else{
_59=$.extend({},$.fn.draggable.defaults,$.fn.draggable.parseOptions(this),_57||{});
}
var _5b=_59.handle?(typeof _59.handle=="string"?$(_59.handle,this):_59.handle):$(this);
$.data(this,"draggable",{options:_59,handle:_5b});
if(_59.disabled){
$(this).css("cursor","");
return;
}
_5b.unbind(".draggable").bind("mousemove.draggable",{target:this},function(e){
if($.fn.draggable.isDragging){
return;
}
var _5c=$.data(e.data.target,"draggable").options;
if(_5d(e)){
$(this).css("cursor",_5c.cursor);
}else{
$(this).css("cursor","");
}
}).bind("mouseleave.draggable",{target:this},function(e){
$(this).css("cursor","");
}).bind("mousedown.draggable",{target:this},function(e){
if(_5d(e)==false){
return;
}
$(this).css("cursor","");
var _5e=$(e.data.target).position();
var _5f=$(e.data.target).offset();
var _60={startPosition:$(e.data.target).css("position"),startLeft:_5e.left,startTop:_5e.top,left:_5e.left,top:_5e.top,startX:e.pageX,startY:e.pageY,width:$(e.data.target).outerWidth(),height:$(e.data.target).outerHeight(),offsetWidth:(e.pageX-_5f.left),offsetHeight:(e.pageY-_5f.top),target:e.data.target,parent:$(e.data.target).parent()[0]};
$.extend(e.data,_60);
var _61=$.data(e.data.target,"draggable").options;
if(_61.onBeforeDrag.call(e.data.target,e)==false){
return;
}
$(document).bind("mousedown.draggable",e.data,_43);
$(document).bind("mousemove.draggable",e.data,_49);
$(document).bind("mouseup.draggable",e.data,_4d);
$.fn.draggable.timer=setTimeout(function(){
$.fn.draggable.isDragging=true;
_43(e);
},_61.delay);
return false;
});
function _5d(e){
var _62=$.data(e.data.target,"draggable");
var _63=_62.handle;
var _64=$(_63).offset();
var _65=$(_63).outerWidth();
var _66=$(_63).outerHeight();
var t=e.pageY-_64.top;
var r=_64.left+_65-e.pageX;
var b=_64.top+_66-e.pageY;
var l=e.pageX-_64.left;
return Math.min(t,r,b,l)>_62.options.edge;
};
});
};
$.fn.draggable.methods={options:function(jq){
return $.data(jq[0],"draggable").options;
},proxy:function(jq){
return $.data(jq[0],"draggable").proxy;
},enable:function(jq){
return jq.each(function(){
$(this).draggable({disabled:false});
});
},disable:function(jq){
return jq.each(function(){
$(this).draggable({disabled:true});
});
}};
$.fn.draggable.parseOptions=function(_67){
var t=$(_67);
return $.extend({},$.parser.parseOptions(_67,["cursor","handle","axis",{"revert":"boolean","deltaX":"number","deltaY":"number","edge":"number","delay":"number"}]),{disabled:(t.attr("disabled")?true:undefined)});
};
$.fn.draggable.defaults={proxy:null,revert:false,cursor:"move",deltaX:null,deltaY:null,handle:null,disabled:false,edge:0,axis:null,delay:100,onBeforeDrag:function(e){
},onStartDrag:function(e){
},onDrag:function(e){
},onStopDrag:function(e){
}};
$.fn.draggable.isDragging=false;
})(jQuery);
(function($){
function _68(_69){
$(_69).addClass("droppable");
$(_69).bind("_dragenter",function(e,_6a){
$.data(_69,"droppable").options.onDragEnter.apply(_69,[e,_6a]);
});
$(_69).bind("_dragleave",function(e,_6b){
$.data(_69,"droppable").options.onDragLeave.apply(_69,[e,_6b]);
});
$(_69).bind("_dragover",function(e,_6c){
$.data(_69,"droppable").options.onDragOver.apply(_69,[e,_6c]);
});
$(_69).bind("_drop",function(e,_6d){
$.data(_69,"droppable").options.onDrop.apply(_69,[e,_6d]);
});
};
$.fn.droppable=function(_6e,_6f){
if(typeof _6e=="string"){
return $.fn.droppable.methods[_6e](this,_6f);
}
_6e=_6e||{};
return this.each(function(){
var _70=$.data(this,"droppable");
if(_70){
$.extend(_70.options,_6e);
}else{
_68(this);
$.data(this,"droppable",{options:$.extend({},$.fn.droppable.defaults,$.fn.droppable.parseOptions(this),_6e)});
}
});
};
$.fn.droppable.methods={options:function(jq){
return $.data(jq[0],"droppable").options;
},enable:function(jq){
return jq.each(function(){
$(this).droppable({disabled:false});
});
},disable:function(jq){
return jq.each(function(){
$(this).droppable({disabled:true});
});
}};
$.fn.droppable.parseOptions=function(_71){
var t=$(_71);
return $.extend({},$.parser.parseOptions(_71,["accept"]),{disabled:(t.attr("disabled")?true:undefined)});
};
$.fn.droppable.defaults={accept:null,disabled:false,onDragEnter:function(e,_72){
},onDragOver:function(e,_73){
},onDragLeave:function(e,_74){
},onDrop:function(e,_75){
}};
})(jQuery);
(function($){
$.fn.resizable=function(_76,_77){
if(typeof _76=="string"){
return $.fn.resizable.methods[_76](this,_77);
}
function _78(e){
var _79=e.data;
var _7a=$.data(_79.target,"resizable").options;
if(_79.dir.indexOf("e")!=-1){
var _7b=_79.startWidth+e.pageX-_79.startX;
_7b=Math.min(Math.max(_7b,_7a.minWidth),_7a.maxWidth);
_79.width=_7b;
}
if(_79.dir.indexOf("s")!=-1){
var _7c=_79.startHeight+e.pageY-_79.startY;
_7c=Math.min(Math.max(_7c,_7a.minHeight),_7a.maxHeight);
_79.height=_7c;
}
if(_79.dir.indexOf("w")!=-1){
var _7b=_79.startWidth-e.pageX+_79.startX;
_7b=Math.min(Math.max(_7b,_7a.minWidth),_7a.maxWidth);
_79.width=_7b;
_79.left=_79.startLeft+_79.startWidth-_79.width;
}
if(_79.dir.indexOf("n")!=-1){
var _7c=_79.startHeight-e.pageY+_79.startY;
_7c=Math.min(Math.max(_7c,_7a.minHeight),_7a.maxHeight);
_79.height=_7c;
_79.top=_79.startTop+_79.startHeight-_79.height;
}
};
function _7d(e){
var _7e=e.data;
var t=$(_7e.target);
t.css({left:_7e.left,top:_7e.top});
if(t.outerWidth()!=_7e.width){
t._outerWidth(_7e.width);
}
if(t.outerHeight()!=_7e.height){
t._outerHeight(_7e.height);
}
};
function _7f(e){
$.fn.resizable.isResizing=true;
$.data(e.data.target,"resizable").options.onStartResize.call(e.data.target,e);
return false;
};
function _80(e){
_78(e);
if($.data(e.data.target,"resizable").options.onResize.call(e.data.target,e)!=false){
_7d(e);
}
return false;
};
function _81(e){
$.fn.resizable.isResizing=false;
_78(e,true);
_7d(e);
$.data(e.data.target,"resizable").options.onStopResize.call(e.data.target,e);
$(document).unbind(".resizable");
$("body").css("cursor","");
return false;
};
return this.each(function(){
var _82=null;
var _83=$.data(this,"resizable");
if(_83){
$(this).unbind(".resizable");
_82=$.extend(_83.options,_76||{});
}else{
_82=$.extend({},$.fn.resizable.defaults,$.fn.resizable.parseOptions(this),_76||{});
$.data(this,"resizable",{options:_82});
}
if(_82.disabled==true){
return;
}
$(this).bind("mousemove.resizable",{target:this},function(e){
if($.fn.resizable.isResizing){
return;
}
var dir=_84(e);
if(dir==""){
$(e.data.target).css("cursor","");
}else{
$(e.data.target).css("cursor",dir+"-resize");
}
}).bind("mouseleave.resizable",{target:this},function(e){
$(e.data.target).css("cursor","");
}).bind("mousedown.resizable",{target:this},function(e){
var dir=_84(e);
if(dir==""){
return;
}
function _85(css){
var val=parseInt($(e.data.target).css(css));
if(isNaN(val)){
return 0;
}else{
return val;
}
};
var _86={target:e.data.target,dir:dir,startLeft:_85("left"),startTop:_85("top"),left:_85("left"),top:_85("top"),startX:e.pageX,startY:e.pageY,startWidth:$(e.data.target).outerWidth(),startHeight:$(e.data.target).outerHeight(),width:$(e.data.target).outerWidth(),height:$(e.data.target).outerHeight(),deltaWidth:$(e.data.target).outerWidth()-$(e.data.target).width(),deltaHeight:$(e.data.target).outerHeight()-$(e.data.target).height()};
$(document).bind("mousedown.resizable",_86,_7f);
$(document).bind("mousemove.resizable",_86,_80);
$(document).bind("mouseup.resizable",_86,_81);
$("body").css("cursor",dir+"-resize");
});
function _84(e){
var tt=$(e.data.target);
var dir="";
var _87=tt.offset();
var _88=tt.outerWidth();
var _89=tt.outerHeight();
var _8a=_82.edge;
if(e.pageY>_87.top&&e.pageY<_87.top+_8a){
dir+="n";
}else{
if(e.pageY<_87.top+_89&&e.pageY>_87.top+_89-_8a){
dir+="s";
}
}
if(e.pageX>_87.left&&e.pageX<_87.left+_8a){
dir+="w";
}else{
if(e.pageX<_87.left+_88&&e.pageX>_87.left+_88-_8a){
dir+="e";
}
}
var _8b=_82.handles.split(",");
for(var i=0;i<_8b.length;i++){
var _8c=_8b[i].replace(/(^\s*)|(\s*$)/g,"");
if(_8c=="all"||_8c==dir){
return dir;
}
}
return "";
};
});
};
$.fn.resizable.methods={options:function(jq){
return $.data(jq[0],"resizable").options;
},enable:function(jq){
return jq.each(function(){
$(this).resizable({disabled:false});
});
},disable:function(jq){
return jq.each(function(){
$(this).resizable({disabled:true});
});
}};
$.fn.resizable.parseOptions=function(_8d){
var t=$(_8d);
return $.extend({},$.parser.parseOptions(_8d,["handles",{minWidth:"number",minHeight:"number",maxWidth:"number",maxHeight:"number",edge:"number"}]),{disabled:(t.attr("disabled")?true:undefined)});
};
$.fn.resizable.defaults={disabled:false,handles:"n, e, s, w, ne, se, sw, nw, all",minWidth:10,minHeight:10,maxWidth:10000,maxHeight:10000,edge:5,onStartResize:function(e){
},onResize:function(e){
},onStopResize:function(e){
}};
$.fn.resizable.isResizing=false;
})(jQuery);
(function($){
function _8e(_8f,_90){
var _91=$.data(_8f,"linkbutton").options;
if(_90){
$.extend(_91,_90);
}
if(_91.width||_91.height||_91.fit){
var btn=$(_8f);
var _92=btn.parent();
var _93=btn.is(":visible");
if(!_93){
var _94=$("<div style=\"display:none\"></div>").insertBefore(_8f);
var _95={position:btn.css("position"),display:btn.css("display"),left:btn.css("left")};
btn.appendTo("body");
btn.css({position:"absolute",display:"inline-block",left:-20000});
}
btn._size(_91,_92);
var _96=btn.find(".l-btn-left");
_96.css("margin-top",0);
_96.css("margin-top",parseInt((btn.height()-_96.height())/2)+"px");
if(!_93){
btn.insertAfter(_94);
btn.css(_95);
_94.remove();
}
}
};
function _97(_98){
var _99=$.data(_98,"linkbutton").options;
var t=$(_98).empty();
t.addClass("l-btn").removeClass("l-btn-plain l-btn-selected l-btn-plain-selected l-btn-outline");
t.removeClass("l-btn-small l-btn-medium l-btn-large").addClass("l-btn-"+_99.size);
if(_99.plain){
t.addClass("l-btn-plain");
}
if(_99.outline){
t.addClass("l-btn-outline");
}
if(_99.selected){
t.addClass(_99.plain?"l-btn-selected l-btn-plain-selected":"l-btn-selected");
}
t.attr("group",_99.group||"");
t.attr("id",_99.id||"");
var _9a=$("<span class=\"l-btn-left\"></span>").appendTo(t);
if(_99.text){
$("<span class=\"l-btn-text\"></span>").html(_99.text).appendTo(_9a);
}else{
$("<span class=\"l-btn-text l-btn-empty\">&nbsp;</span>").appendTo(_9a);
}
if(_99.iconCls){
$("<span class=\"l-btn-icon\">&nbsp;</span>").addClass(_99.iconCls).appendTo(_9a);
_9a.addClass("l-btn-icon-"+_99.iconAlign);
}
t.unbind(".linkbutton").bind("focus.linkbutton",function(){
if(!_99.disabled){
$(this).addClass("l-btn-focus");
}
}).bind("blur.linkbutton",function(){
$(this).removeClass("l-btn-focus");
}).bind("click.linkbutton",function(){
if(!_99.disabled){
if(_99.toggle){
if(_99.selected){
$(this).linkbutton("unselect");
}else{
$(this).linkbutton("select");
}
}
_99.onClick.call(this);
}
});
_9b(_98,_99.selected);
_9c(_98,_99.disabled);
};
function _9b(_9d,_9e){
var _9f=$.data(_9d,"linkbutton").options;
if(_9e){
if(_9f.group){
$("a.l-btn[group=\""+_9f.group+"\"]").each(function(){
var o=$(this).linkbutton("options");
if(o.toggle){
$(this).removeClass("l-btn-selected l-btn-plain-selected");
o.selected=false;
}
});
}
$(_9d).addClass(_9f.plain?"l-btn-selected l-btn-plain-selected":"l-btn-selected");
_9f.selected=true;
}else{
if(!_9f.group){
$(_9d).removeClass("l-btn-selected l-btn-plain-selected");
_9f.selected=false;
}
}
};
function _9c(_a0,_a1){
var _a2=$.data(_a0,"linkbutton");
var _a3=_a2.options;
$(_a0).removeClass("l-btn-disabled l-btn-plain-disabled");
if(_a1){
_a3.disabled=true;
var _a4=$(_a0).attr("href");
if(_a4){
_a2.href=_a4;
$(_a0).attr("href","javascript:;");
}
if(_a0.onclick){
_a2.onclick=_a0.onclick;
_a0.onclick=null;
}
_a3.plain?$(_a0).addClass("l-btn-disabled l-btn-plain-disabled"):$(_a0).addClass("l-btn-disabled");
}else{
_a3.disabled=false;
if(_a2.href){
$(_a0).attr("href",_a2.href);
}
if(_a2.onclick){
_a0.onclick=_a2.onclick;
}
}
};
$.fn.linkbutton=function(_a5,_a6){
if(typeof _a5=="string"){
return $.fn.linkbutton.methods[_a5](this,_a6);
}
_a5=_a5||{};
return this.each(function(){
var _a7=$.data(this,"linkbutton");
if(_a7){
$.extend(_a7.options,_a5);
}else{
$.data(this,"linkbutton",{options:$.extend({},$.fn.linkbutton.defaults,$.fn.linkbutton.parseOptions(this),_a5)});
$(this).removeAttr("disabled");
$(this).bind("_resize",function(e,_a8){
if($(this).hasClass("easyui-fluid")||_a8){
_8e(this);
}
return false;
});
}
_97(this);
_8e(this);
});
};
$.fn.linkbutton.methods={options:function(jq){
return $.data(jq[0],"linkbutton").options;
},resize:function(jq,_a9){
return jq.each(function(){
_8e(this,_a9);
});
},enable:function(jq){
return jq.each(function(){
_9c(this,false);
});
},disable:function(jq){
return jq.each(function(){
_9c(this,true);
});
},select:function(jq){
return jq.each(function(){
_9b(this,true);
});
},unselect:function(jq){
return jq.each(function(){
_9b(this,false);
});
}};
$.fn.linkbutton.parseOptions=function(_aa){
var t=$(_aa);
return $.extend({},$.parser.parseOptions(_aa,["id","iconCls","iconAlign","group","size","text",{plain:"boolean",toggle:"boolean",selected:"boolean",outline:"boolean"}]),{disabled:(t.attr("disabled")?true:undefined),text:($.trim(t.html())||undefined),iconCls:(t.attr("icon")||t.attr("iconCls"))});
};
$.fn.linkbutton.defaults={id:null,disabled:false,toggle:false,selected:false,outline:false,group:null,plain:false,text:"",iconCls:null,iconAlign:"left",size:"small",onClick:function(){
}};
})(jQuery);
(function($){
function _ab(_ac){
var _ad=$.data(_ac,"pagination");
var _ae=_ad.options;
var bb=_ad.bb={};
var _af=$(_ac).addClass("pagination").html("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr></tr></table>");
var tr=_af.find("tr");
var aa=$.extend([],_ae.layout);
if(!_ae.showPageList){
_b0(aa,"list");
}
if(!_ae.showPageInfo){
_b0(aa,"info");
}
if(!_ae.showRefresh){
_b0(aa,"refresh");
}
if(aa[0]=="sep"){
aa.shift();
}
if(aa[aa.length-1]=="sep"){
aa.pop();
}
for(var _b1=0;_b1<aa.length;_b1++){
var _b2=aa[_b1];
if(_b2=="list"){
var ps=$("<select class=\"pagination-page-list\"></select>");
ps.bind("change",function(){
_ae.pageSize=parseInt($(this).val());
_ae.onChangePageSize.call(_ac,_ae.pageSize);
_b8(_ac,_ae.pageNumber);
});
for(var i=0;i<_ae.pageList.length;i++){
$("<option></option>").text(_ae.pageList[i]).appendTo(ps);
}
$("<td></td>").append(ps).appendTo(tr);
}else{
if(_b2=="sep"){
$("<td><div class=\"pagination-btn-separator\"></div></td>").appendTo(tr);
}else{
if(_b2=="first"){
bb.first=_b3("first");
}else{
if(_b2=="prev"){
bb.prev=_b3("prev");
}else{
if(_b2=="next"){
bb.next=_b3("next");
}else{
if(_b2=="last"){
bb.last=_b3("last");
}else{
if(_b2=="manual"){
$("<span style=\"padding-left:6px;\"></span>").html(_ae.beforePageText).appendTo(tr).wrap("<td></td>");
bb.num=$("<input class=\"pagination-num\" type=\"text\" value=\"1\" size=\"2\">").appendTo(tr).wrap("<td></td>");
bb.num.unbind(".pagination").bind("keydown.pagination",function(e){
if(e.keyCode==13){
var _b4=parseInt($(this).val())||1;
_b8(_ac,_b4);
return false;
}
});
bb.after=$("<span style=\"padding-right:6px;\"></span>").appendTo(tr).wrap("<td></td>");
}else{
if(_b2=="refresh"){
bb.refresh=_b3("refresh");
}else{
if(_b2=="links"){
$("<td class=\"pagination-links\"></td>").appendTo(tr);
}else{
if(_b2=="info"){
if(_b1==aa.length-1){
$("<div class=\"pagination-info\"></div>").appendTo(_af);
$("<div style=\"clear:both;\"></div>").appendTo(_af);
}else{
$("<td><div class=\"pagination-info\"></div></td>").appendTo(tr);
}
}
}
}
}
}
}
}
}
}
}
}
if(_ae.buttons){
$("<td><div class=\"pagination-btn-separator\"></div></td>").appendTo(tr);
if($.isArray(_ae.buttons)){
for(var i=0;i<_ae.buttons.length;i++){
var btn=_ae.buttons[i];
if(btn=="-"){
$("<td><div class=\"pagination-btn-separator\"></div></td>").appendTo(tr);
}else{
var td=$("<td></td>").appendTo(tr);
var a=$("<a href=\"javascript:;\"></a>").appendTo(td);
a[0].onclick=eval(btn.handler||function(){
});
a.linkbutton($.extend({},btn,{plain:true}));
}
}
}else{
var td=$("<td></td>").appendTo(tr);
$(_ae.buttons).appendTo(td).show();
}
}
function _b3(_b5){
var btn=_ae.nav[_b5];
var a=$("<a href=\"javascript:;\"></a>").appendTo(tr);
a.wrap("<td></td>");
a.linkbutton({iconCls:btn.iconCls,plain:true}).unbind(".pagination").bind("click.pagination",function(){
btn.handler.call(_ac);
});
return a;
};
function _b0(aa,_b6){
var _b7=$.inArray(_b6,aa);
if(_b7>=0){
aa.splice(_b7,1);
}
return aa;
};
};
function _b8(_b9,_ba){
var _bb=$.data(_b9,"pagination").options;
_bc(_b9,{pageNumber:_ba});
_bb.onSelectPage.call(_b9,_bb.pageNumber,_bb.pageSize);
};
function _bc(_bd,_be){
var _bf=$.data(_bd,"pagination");
var _c0=_bf.options;
var bb=_bf.bb;
$.extend(_c0,_be||{});
var ps=$(_bd).find("select.pagination-page-list");
if(ps.length){
ps.val(_c0.pageSize+"");
_c0.pageSize=parseInt(ps.val());
}
var _c1=Math.ceil(_c0.total/_c0.pageSize)||1;
if(_c0.pageNumber<1){
_c0.pageNumber=1;
}
if(_c0.pageNumber>_c1){
_c0.pageNumber=_c1;
}
if(_c0.total==0){
_c0.pageNumber=0;
_c1=0;
}
if(bb.num){
bb.num.val(_c0.pageNumber);
}
if(bb.after){
bb.after.html(_c0.afterPageText.replace(/{pages}/,_c1));
}
var td=$(_bd).find("td.pagination-links");
if(td.length){
td.empty();
var _c2=_c0.pageNumber-Math.floor(_c0.links/2);
if(_c2<1){
_c2=1;
}
var _c3=_c2+_c0.links-1;
if(_c3>_c1){
_c3=_c1;
}
_c2=_c3-_c0.links+1;
if(_c2<1){
_c2=1;
}
for(var i=_c2;i<=_c3;i++){
var a=$("<a class=\"pagination-link\" href=\"javascript:;\"></a>").appendTo(td);
a.linkbutton({plain:true,text:i});
if(i==_c0.pageNumber){
a.linkbutton("select");
}else{
a.unbind(".pagination").bind("click.pagination",{pageNumber:i},function(e){
_b8(_bd,e.data.pageNumber);
});
}
}
}
var _c4=_c0.displayMsg;
_c4=_c4.replace(/{from}/,_c0.total==0?0:_c0.pageSize*(_c0.pageNumber-1)+1);
_c4=_c4.replace(/{to}/,Math.min(_c0.pageSize*(_c0.pageNumber),_c0.total));
_c4=_c4.replace(/{total}/,_c0.total);
$(_bd).find("div.pagination-info").html(_c4);
if(bb.first){
bb.first.linkbutton({disabled:((!_c0.total)||_c0.pageNumber==1)});
}
if(bb.prev){
bb.prev.linkbutton({disabled:((!_c0.total)||_c0.pageNumber==1)});
}
if(bb.next){
bb.next.linkbutton({disabled:(_c0.pageNumber==_c1)});
}
if(bb.last){
bb.last.linkbutton({disabled:(_c0.pageNumber==_c1)});
}
_c5(_bd,_c0.loading);
};
function _c5(_c6,_c7){
var _c8=$.data(_c6,"pagination");
var _c9=_c8.options;
_c9.loading=_c7;
if(_c9.showRefresh&&_c8.bb.refresh){
_c8.bb.refresh.linkbutton({iconCls:(_c9.loading?"pagination-loading":"pagination-load")});
}
};
$.fn.pagination=function(_ca,_cb){
if(typeof _ca=="string"){
return $.fn.pagination.methods[_ca](this,_cb);
}
_ca=_ca||{};
return this.each(function(){
var _cc;
var _cd=$.data(this,"pagination");
if(_cd){
_cc=$.extend(_cd.options,_ca);
}else{
_cc=$.extend({},$.fn.pagination.defaults,$.fn.pagination.parseOptions(this),_ca);
$.data(this,"pagination",{options:_cc});
}
_ab(this);
_bc(this);
});
};
$.fn.pagination.methods={options:function(jq){
return $.data(jq[0],"pagination").options;
},loading:function(jq){
return jq.each(function(){
_c5(this,true);
});
},loaded:function(jq){
return jq.each(function(){
_c5(this,false);
});
},refresh:function(jq,_ce){
return jq.each(function(){
_bc(this,_ce);
});
},select:function(jq,_cf){
return jq.each(function(){
_b8(this,_cf);
});
}};
$.fn.pagination.parseOptions=function(_d0){
var t=$(_d0);
return $.extend({},$.parser.parseOptions(_d0,[{total:"number",pageSize:"number",pageNumber:"number",links:"number"},{loading:"boolean",showPageList:"boolean",showPageInfo:"boolean",showRefresh:"boolean"}]),{pageList:(t.attr("pageList")?eval(t.attr("pageList")):undefined)});
};
$.fn.pagination.defaults={total:1,pageSize:10,pageNumber:1,pageList:[10,20,30,50],loading:false,buttons:null,showPageList:true,showPageInfo:true,showRefresh:true,links:10,layout:["list","sep","first","prev","sep","manual","sep","next","last","sep","refresh","info"],onSelectPage:function(_d1,_d2){
},onBeforeRefresh:function(_d3,_d4){
},onRefresh:function(_d5,_d6){
},onChangePageSize:function(_d7){
},beforePageText:"Page",afterPageText:"of {pages}",displayMsg:"Displaying {from} to {to} of {total} items",nav:{first:{iconCls:"pagination-first",handler:function(){
var _d8=$(this).pagination("options");
if(_d8.pageNumber>1){
$(this).pagination("select",1);
}
}},prev:{iconCls:"pagination-prev",handler:function(){
var _d9=$(this).pagination("options");
if(_d9.pageNumber>1){
$(this).pagination("select",_d9.pageNumber-1);
}
}},next:{iconCls:"pagination-next",handler:function(){
var _da=$(this).pagination("options");
var _db=Math.ceil(_da.total/_da.pageSize);
if(_da.pageNumber<_db){
$(this).pagination("select",_da.pageNumber+1);
}
}},last:{iconCls:"pagination-last",handler:function(){
var _dc=$(this).pagination("options");
var _dd=Math.ceil(_dc.total/_dc.pageSize);
if(_dc.pageNumber<_dd){
$(this).pagination("select",_dd);
}
}},refresh:{iconCls:"pagination-refresh",handler:function(){
var _de=$(this).pagination("options");
if(_de.onBeforeRefresh.call(this,_de.pageNumber,_de.pageSize)!=false){
$(this).pagination("select",_de.pageNumber);
_de.onRefresh.call(this,_de.pageNumber,_de.pageSize);
}
}}}};
})(jQuery);
(function($){
function _df(_e0){
var _e1=$(_e0);
_e1.addClass("tree");
return _e1;
};
function _e2(_e3){
var _e4=$.data(_e3,"tree").options;
$(_e3).unbind().bind("mouseover",function(e){
var tt=$(e.target);
var _e5=tt.closest("div.tree-node");
if(!_e5.length){
return;
}
_e5.addClass("tree-node-hover");
if(tt.hasClass("tree-hit")){
if(tt.hasClass("tree-expanded")){
tt.addClass("tree-expanded-hover");
}else{
tt.addClass("tree-collapsed-hover");
}
}
e.stopPropagation();
}).bind("mouseout",function(e){
var tt=$(e.target);
var _e6=tt.closest("div.tree-node");
if(!_e6.length){
return;
}
_e6.removeClass("tree-node-hover");
if(tt.hasClass("tree-hit")){
if(tt.hasClass("tree-expanded")){
tt.removeClass("tree-expanded-hover");
}else{
tt.removeClass("tree-collapsed-hover");
}
}
e.stopPropagation();
}).bind("click",function(e){
var tt=$(e.target);
var _e7=tt.closest("div.tree-node");
if(!_e7.length){
return;
}
if(tt.hasClass("tree-hit")){
_145(_e3,_e7[0]);
return false;
}else{
if(tt.hasClass("tree-checkbox")){
_10c(_e3,_e7[0]);
return false;
}else{
_188(_e3,_e7[0]);
_e4.onClick.call(_e3,_ea(_e3,_e7[0]));
}
}
e.stopPropagation();
}).bind("dblclick",function(e){
var _e8=$(e.target).closest("div.tree-node");
if(!_e8.length){
return;
}
_188(_e3,_e8[0]);
_e4.onDblClick.call(_e3,_ea(_e3,_e8[0]));
e.stopPropagation();
}).bind("contextmenu",function(e){
var _e9=$(e.target).closest("div.tree-node");
if(!_e9.length){
return;
}
_e4.onContextMenu.call(_e3,e,_ea(_e3,_e9[0]));
e.stopPropagation();
});
};
function _eb(_ec){
var _ed=$.data(_ec,"tree").options;
_ed.dnd=false;
var _ee=$(_ec).find("div.tree-node");
_ee.draggable("disable");
_ee.css("cursor","pointer");
};
function _ef(_f0){
var _f1=$.data(_f0,"tree");
var _f2=_f1.options;
var _f3=_f1.tree;
_f1.disabledNodes=[];
_f2.dnd=true;
_f3.find("div.tree-node").draggable({disabled:false,revert:true,cursor:"pointer",proxy:function(_f4){
var p=$("<div class=\"tree-node-proxy\"></div>").appendTo("body");
p.html("<span class=\"tree-dnd-icon tree-dnd-no\">&nbsp;</span>"+$(_f4).find(".tree-title").html());
p.hide();
return p;
},deltaX:15,deltaY:15,onBeforeDrag:function(e){
if(_f2.onBeforeDrag.call(_f0,_ea(_f0,this))==false){
return false;
}
if($(e.target).hasClass("tree-hit")||$(e.target).hasClass("tree-checkbox")){
return false;
}
if(e.which!=1){
return false;
}
var _f5=$(this).find("span.tree-indent");
if(_f5.length){
e.data.offsetWidth-=_f5.length*_f5.width();
}
},onStartDrag:function(e){
$(this).next("ul").find("div.tree-node").each(function(){
$(this).droppable("disable");
_f1.disabledNodes.push(this);
});
$(this).draggable("proxy").css({left:-10000,top:-10000});
_f2.onStartDrag.call(_f0,_ea(_f0,this));
var _f6=_ea(_f0,this);
if(_f6.id==undefined){
_f6.id="easyui_tree_node_id_temp";
_12c(_f0,_f6);
}
_f1.draggingNodeId=_f6.id;
},onDrag:function(e){
var x1=e.pageX,y1=e.pageY,x2=e.data.startX,y2=e.data.startY;
var d=Math.sqrt((x1-x2)*(x1-x2)+(y1-y2)*(y1-y2));
if(d>3){
$(this).draggable("proxy").show();
}
this.pageY=e.pageY;
},onStopDrag:function(){
for(var i=0;i<_f1.disabledNodes.length;i++){
$(_f1.disabledNodes[i]).droppable("enable");
}
_f1.disabledNodes=[];
var _f7=_182(_f0,_f1.draggingNodeId);
if(_f7&&_f7.id=="easyui_tree_node_id_temp"){
_f7.id="";
_12c(_f0,_f7);
}
_f2.onStopDrag.call(_f0,_f7);
}}).droppable({accept:"div.tree-node",onDragEnter:function(e,_f8){
if(_f2.onDragEnter.call(_f0,this,_f9(_f8))==false){
_fa(_f8,false);
$(this).removeClass("tree-node-append tree-node-top tree-node-bottom");
$(this).droppable("disable");
_f1.disabledNodes.push(this);
}
},onDragOver:function(e,_fb){
if($(this).droppable("options").disabled){
return;
}
var _fc=_fb.pageY;
var top=$(this).offset().top;
var _fd=top+$(this).outerHeight();
_fa(_fb,true);
$(this).removeClass("tree-node-append tree-node-top tree-node-bottom");
if(_fc>top+(_fd-top)/2){
if(_fd-_fc<5){
$(this).addClass("tree-node-bottom");
}else{
$(this).addClass("tree-node-append");
}
}else{
if(_fc-top<5){
$(this).addClass("tree-node-top");
}else{
$(this).addClass("tree-node-append");
}
}
if(_f2.onDragOver.call(_f0,this,_f9(_fb))==false){
_fa(_fb,false);
$(this).removeClass("tree-node-append tree-node-top tree-node-bottom");
$(this).droppable("disable");
_f1.disabledNodes.push(this);
}
},onDragLeave:function(e,_fe){
_fa(_fe,false);
$(this).removeClass("tree-node-append tree-node-top tree-node-bottom");
_f2.onDragLeave.call(_f0,this,_f9(_fe));
},onDrop:function(e,_ff){
var dest=this;
var _100,_101;
if($(this).hasClass("tree-node-append")){
_100=_102;
_101="append";
}else{
_100=_103;
_101=$(this).hasClass("tree-node-top")?"top":"bottom";
}
if(_f2.onBeforeDrop.call(_f0,dest,_f9(_ff),_101)==false){
$(this).removeClass("tree-node-append tree-node-top tree-node-bottom");
return;
}
_100(_ff,dest,_101);
$(this).removeClass("tree-node-append tree-node-top tree-node-bottom");
}});
function _f9(_104,pop){
return $(_104).closest("ul.tree").tree(pop?"pop":"getData",_104);
};
function _fa(_105,_106){
var icon=$(_105).draggable("proxy").find("span.tree-dnd-icon");
icon.removeClass("tree-dnd-yes tree-dnd-no").addClass(_106?"tree-dnd-yes":"tree-dnd-no");
};
function _102(_107,dest){
if(_ea(_f0,dest).state=="closed"){
_13d(_f0,dest,function(){
_108();
});
}else{
_108();
}
function _108(){
var node=_f9(_107,true);
$(_f0).tree("append",{parent:dest,data:[node]});
_f2.onDrop.call(_f0,dest,node,"append");
};
};
function _103(_109,dest,_10a){
var _10b={};
if(_10a=="top"){
_10b.before=dest;
}else{
_10b.after=dest;
}
var node=_f9(_109,true);
_10b.data=node;
$(_f0).tree("insert",_10b);
_f2.onDrop.call(_f0,dest,node,_10a);
};
};
function _10c(_10d,_10e,_10f,_110){
var _111=$.data(_10d,"tree");
var opts=_111.options;
if(!opts.checkbox){
return;
}
var _112=_ea(_10d,_10e);
if(!_112.checkState){
return;
}
var ck=$(_10e).find(".tree-checkbox");
if(_10f==undefined){
if(ck.hasClass("tree-checkbox1")){
_10f=false;
}else{
if(ck.hasClass("tree-checkbox0")){
_10f=true;
}else{
if(_112._checked==undefined){
_112._checked=$(_10e).find(".tree-checkbox").hasClass("tree-checkbox1");
}
_10f=!_112._checked;
}
}
}
_112._checked=_10f;
if(_10f){
if(ck.hasClass("tree-checkbox1")){
return;
}
}else{
if(ck.hasClass("tree-checkbox0")){
return;
}
}
if(!_110){
if(opts.onBeforeCheck.call(_10d,_112,_10f)==false){
return;
}
}
if(opts.cascadeCheck){
_113(_10d,_112,_10f);
_114(_10d,_112);
}else{
_115(_10d,_112,_10f?"1":"0");
}
if(!_110){
opts.onCheck.call(_10d,_112,_10f);
}
};
function _113(_116,_117,_118){
var opts=$.data(_116,"tree").options;
var flag=_118?1:0;
_115(_116,_117,flag);
if(opts.deepCheck){
$.easyui.forEach(_117.children||[],true,function(n){
_115(_116,n,flag);
});
}else{
var _119=[];
if(_117.children&&_117.children.length){
_119.push(_117);
}
$.easyui.forEach(_117.children||[],true,function(n){
if(!n.hidden){
_115(_116,n,flag);
if(n.children&&n.children.length){
_119.push(n);
}
}
});
for(var i=_119.length-1;i>=0;i--){
var node=_119[i];
_115(_116,node,_11a(node));
}
}
};
function _115(_11b,_11c,flag){
var opts=$.data(_11b,"tree").options;
if(!_11c.checkState||flag==undefined){
return;
}
if(_11c.hidden&&!opts.deepCheck){
return;
}
var ck=$("#"+_11c.domId).find(".tree-checkbox");
_11c.checkState=["unchecked","checked","indeterminate"][flag];
_11c.checked=(_11c.checkState=="checked");
ck.removeClass("tree-checkbox0 tree-checkbox1 tree-checkbox2");
ck.addClass("tree-checkbox"+flag);
};
function _114(_11d,_11e){
var pd=_11f(_11d,$("#"+_11e.domId)[0]);
if(pd){
_115(_11d,pd,_11a(pd));
_114(_11d,pd);
}
};
function _11a(row){
var c0=0;
var c1=0;
var len=0;
$.easyui.forEach(row.children||[],false,function(r){
if(r.checkState){
len++;
if(r.checkState=="checked"){
c1++;
}else{
if(r.checkState=="unchecked"){
c0++;
}
}
}
});
if(len==0){
return undefined;
}
var flag=0;
if(c0==len){
flag=0;
}else{
if(c1==len){
flag=1;
}else{
flag=2;
}
}
return flag;
};
function _120(_121,_122){
var opts=$.data(_121,"tree").options;
if(!opts.checkbox){
return;
}
var node=$(_122);
var ck=node.find(".tree-checkbox");
var _123=_ea(_121,_122);
if(opts.view.hasCheckbox(_121,_123)){
if(!ck.length){
_123.checkState=_123.checkState||"unchecked";
$("<span class=\"tree-checkbox\"></span>").insertBefore(node.find(".tree-title"));
}
if(_123.checkState=="checked"){
_10c(_121,_122,true,true);
}else{
if(_123.checkState=="unchecked"){
_10c(_121,_122,false,true);
}else{
var flag=_11a(_123);
if(flag===0){
_10c(_121,_122,false,true);
}else{
if(flag===1){
_10c(_121,_122,true,true);
}
}
}
}
}else{
ck.remove();
_123.checkState=undefined;
_123.checked=undefined;
_114(_121,_123);
}
};
function _124(_125,ul,data,_126,_127){
var _128=$.data(_125,"tree");
var opts=_128.options;
var _129=$(ul).prevAll("div.tree-node:first");
data=opts.loadFilter.call(_125,data,_129[0]);
var _12a=_12b(_125,"domId",_129.attr("id"));
if(!_126){
_12a?_12a.children=data:_128.data=data;
$(ul).empty();
}else{
if(_12a){
_12a.children?_12a.children=_12a.children.concat(data):_12a.children=data;
}else{
_128.data=_128.data.concat(data);
}
}
opts.view.render.call(opts.view,_125,ul,data);
if(opts.dnd){
_ef(_125);
}
if(_12a){
_12c(_125,_12a);
}
for(var i=0;i<_128.tmpIds.length;i++){
_10c(_125,$("#"+_128.tmpIds[i])[0],true,true);
}
_128.tmpIds=[];
setTimeout(function(){
_12d(_125,_125);
},0);
if(!_127){
opts.onLoadSuccess.call(_125,_12a,data);
}
};
function _12d(_12e,ul,_12f){
var opts=$.data(_12e,"tree").options;
if(opts.lines){
$(_12e).addClass("tree-lines");
}else{
$(_12e).removeClass("tree-lines");
return;
}
if(!_12f){
_12f=true;
$(_12e).find("span.tree-indent").removeClass("tree-line tree-join tree-joinbottom");
$(_12e).find("div.tree-node").removeClass("tree-node-last tree-root-first tree-root-one");
var _130=$(_12e).tree("getRoots");
if(_130.length>1){
$(_130[0].target).addClass("tree-root-first");
}else{
if(_130.length==1){
$(_130[0].target).addClass("tree-root-one");
}
}
}
$(ul).children("li").each(function(){
var node=$(this).children("div.tree-node");
var ul=node.next("ul");
if(ul.length){
if($(this).next().length){
_131(node);
}
_12d(_12e,ul,_12f);
}else{
_132(node);
}
});
var _133=$(ul).children("li:last").children("div.tree-node").addClass("tree-node-last");
_133.children("span.tree-join").removeClass("tree-join").addClass("tree-joinbottom");
function _132(node,_134){
var icon=node.find("span.tree-icon");
icon.prev("span.tree-indent").addClass("tree-join");
};
function _131(node){
var _135=node.find("span.tree-indent, span.tree-hit").length;
node.next().find("div.tree-node").each(function(){
$(this).children("span:eq("+(_135-1)+")").addClass("tree-line");
});
};
};
function _136(_137,ul,_138,_139){
var opts=$.data(_137,"tree").options;
_138=$.extend({},opts.queryParams,_138||{});
var _13a=null;
if(_137!=ul){
var node=$(ul).prev();
_13a=_ea(_137,node[0]);
}
if(opts.onBeforeLoad.call(_137,_13a,_138)==false){
return;
}
var _13b=$(ul).prev().children("span.tree-folder");
_13b.addClass("tree-loading");
var _13c=opts.loader.call(_137,_138,function(data){
_13b.removeClass("tree-loading");
_124(_137,ul,data);
if(_139){
_139();
}
},function(){
_13b.removeClass("tree-loading");
opts.onLoadError.apply(_137,arguments);
if(_139){
_139();
}
});
if(_13c==false){
_13b.removeClass("tree-loading");
}
};
function _13d(_13e,_13f,_140){
var opts=$.data(_13e,"tree").options;
var hit=$(_13f).children("span.tree-hit");
if(hit.length==0){
return;
}
if(hit.hasClass("tree-expanded")){
return;
}
var node=_ea(_13e,_13f);
if(opts.onBeforeExpand.call(_13e,node)==false){
return;
}
hit.removeClass("tree-collapsed tree-collapsed-hover").addClass("tree-expanded");
hit.next().addClass("tree-folder-open");
var ul=$(_13f).next();
if(ul.length){
if(opts.animate){
ul.slideDown("normal",function(){
node.state="open";
opts.onExpand.call(_13e,node);
if(_140){
_140();
}
});
}else{
ul.css("display","block");
node.state="open";
opts.onExpand.call(_13e,node);
if(_140){
_140();
}
}
}else{
var _141=$("<ul style=\"display:none\"></ul>").insertAfter(_13f);
_136(_13e,_141[0],{id:node.id},function(){
if(_141.is(":empty")){
_141.remove();
}
if(opts.animate){
_141.slideDown("normal",function(){
node.state="open";
opts.onExpand.call(_13e,node);
if(_140){
_140();
}
});
}else{
_141.css("display","block");
node.state="open";
opts.onExpand.call(_13e,node);
if(_140){
_140();
}
}
});
}
};
function _142(_143,_144){
var opts=$.data(_143,"tree").options;
var hit=$(_144).children("span.tree-hit");
if(hit.length==0){
return;
}
if(hit.hasClass("tree-collapsed")){
return;
}
var node=_ea(_143,_144);
if(opts.onBeforeCollapse.call(_143,node)==false){
return;
}
hit.removeClass("tree-expanded tree-expanded-hover").addClass("tree-collapsed");
hit.next().removeClass("tree-folder-open");
var ul=$(_144).next();
if(opts.animate){
ul.slideUp("normal",function(){
node.state="closed";
opts.onCollapse.call(_143,node);
});
}else{
ul.css("display","none");
node.state="closed";
opts.onCollapse.call(_143,node);
}
};
function _145(_146,_147){
var hit=$(_147).children("span.tree-hit");
if(hit.length==0){
return;
}
if(hit.hasClass("tree-expanded")){
_142(_146,_147);
}else{
_13d(_146,_147);
}
};
function _148(_149,_14a){
var _14b=_14c(_149,_14a);
if(_14a){
_14b.unshift(_ea(_149,_14a));
}
for(var i=0;i<_14b.length;i++){
_13d(_149,_14b[i].target);
}
};
function _14d(_14e,_14f){
var _150=[];
var p=_11f(_14e,_14f);
while(p){
_150.unshift(p);
p=_11f(_14e,p.target);
}
for(var i=0;i<_150.length;i++){
_13d(_14e,_150[i].target);
}
};
function _151(_152,_153){
var c=$(_152).parent();
while(c[0].tagName!="BODY"&&c.css("overflow-y")!="auto"){
c=c.parent();
}
var n=$(_153);
var ntop=n.offset().top;
if(c[0].tagName!="BODY"){
var ctop=c.offset().top;
if(ntop<ctop){
c.scrollTop(c.scrollTop()+ntop-ctop);
}else{
if(ntop+n.outerHeight()>ctop+c.outerHeight()-18){
c.scrollTop(c.scrollTop()+ntop+n.outerHeight()-ctop-c.outerHeight()+18);
}
}
}else{
c.scrollTop(ntop);
}
};
function _154(_155,_156){
var _157=_14c(_155,_156);
if(_156){
_157.unshift(_ea(_155,_156));
}
for(var i=0;i<_157.length;i++){
_142(_155,_157[i].target);
}
};
function _158(_159,_15a){
var node=$(_15a.parent);
var data=_15a.data;
if(!data){
return;
}
data=$.isArray(data)?data:[data];
if(!data.length){
return;
}
var ul;
if(node.length==0){
ul=$(_159);
}else{
if(_15b(_159,node[0])){
var _15c=node.find("span.tree-icon");
_15c.removeClass("tree-file").addClass("tree-folder tree-folder-open");
var hit=$("<span class=\"tree-hit tree-expanded\"></span>").insertBefore(_15c);
if(hit.prev().length){
hit.prev().remove();
}
}
ul=node.next();
if(!ul.length){
ul=$("<ul></ul>").insertAfter(node);
}
}
_124(_159,ul[0],data,true,true);
};
function _15d(_15e,_15f){
var ref=_15f.before||_15f.after;
var _160=_11f(_15e,ref);
var data=_15f.data;
if(!data){
return;
}
data=$.isArray(data)?data:[data];
if(!data.length){
return;
}
_158(_15e,{parent:(_160?_160.target:null),data:data});
var _161=_160?_160.children:$(_15e).tree("getRoots");
for(var i=0;i<_161.length;i++){
if(_161[i].domId==$(ref).attr("id")){
for(var j=data.length-1;j>=0;j--){
_161.splice((_15f.before?i:(i+1)),0,data[j]);
}
_161.splice(_161.length-data.length,data.length);
break;
}
}
var li=$();
for(var i=0;i<data.length;i++){
li=li.add($("#"+data[i].domId).parent());
}
if(_15f.before){
li.insertBefore($(ref).parent());
}else{
li.insertAfter($(ref).parent());
}
};
function _162(_163,_164){
var _165=del(_164);
$(_164).parent().remove();
if(_165){
if(!_165.children||!_165.children.length){
var node=$(_165.target);
node.find(".tree-icon").removeClass("tree-folder").addClass("tree-file");
node.find(".tree-hit").remove();
$("<span class=\"tree-indent\"></span>").prependTo(node);
node.next().remove();
}
_12c(_163,_165);
}
_12d(_163,_163);
function del(_166){
var id=$(_166).attr("id");
var _167=_11f(_163,_166);
var cc=_167?_167.children:$.data(_163,"tree").data;
for(var i=0;i<cc.length;i++){
if(cc[i].domId==id){
cc.splice(i,1);
break;
}
}
return _167;
};
};
function _12c(_168,_169){
var opts=$.data(_168,"tree").options;
var node=$(_169.target);
var data=_ea(_168,_169.target);
if(data.iconCls){
node.find(".tree-icon").removeClass(data.iconCls);
}
$.extend(data,_169);
node.find(".tree-title").html(opts.formatter.call(_168,data));
if(data.iconCls){
node.find(".tree-icon").addClass(data.iconCls);
}
_120(_168,_169.target);
};
function _16a(_16b,_16c){
if(_16c){
var p=_11f(_16b,_16c);
while(p){
_16c=p.target;
p=_11f(_16b,_16c);
}
return _ea(_16b,_16c);
}else{
var _16d=_16e(_16b);
return _16d.length?_16d[0]:null;
}
};
function _16e(_16f){
var _170=$.data(_16f,"tree").data;
for(var i=0;i<_170.length;i++){
_171(_170[i]);
}
return _170;
};
function _14c(_172,_173){
var _174=[];
var n=_ea(_172,_173);
var data=n?(n.children||[]):$.data(_172,"tree").data;
$.easyui.forEach(data,true,function(node){
_174.push(_171(node));
});
return _174;
};
function _11f(_175,_176){
var p=$(_176).closest("ul").prevAll("div.tree-node:first");
return _ea(_175,p[0]);
};
function _177(_178,_179){
_179=_179||"checked";
if(!$.isArray(_179)){
_179=[_179];
}
var _17a=[];
$.easyui.forEach($.data(_178,"tree").data,true,function(n){
if(n.checkState&&$.easyui.indexOfArray(_179,n.checkState)!=-1){
_17a.push(_171(n));
}
});
return _17a;
};
function _17b(_17c){
var node=$(_17c).find("div.tree-node-selected");
return node.length?_ea(_17c,node[0]):null;
};
function _17d(_17e,_17f){
var data=_ea(_17e,_17f);
if(data&&data.children){
$.easyui.forEach(data.children,true,function(node){
_171(node);
});
}
return data;
};
function _ea(_180,_181){
return _12b(_180,"domId",$(_181).attr("id"));
};
function _182(_183,id){
return _12b(_183,"id",id);
};
function _12b(_184,_185,_186){
var data=$.data(_184,"tree").data;
var _187=null;
$.easyui.forEach(data,true,function(node){
if(node[_185]==_186){
_187=_171(node);
return false;
}
});
return _187;
};
function _171(node){
node.target=$("#"+node.domId)[0];
return node;
};
function _188(_189,_18a){
var opts=$.data(_189,"tree").options;
var node=_ea(_189,_18a);
if(opts.onBeforeSelect.call(_189,node)==false){
return;
}
$(_189).find("div.tree-node-selected").removeClass("tree-node-selected");
$(_18a).addClass("tree-node-selected");
opts.onSelect.call(_189,node);
};
function _15b(_18b,_18c){
return $(_18c).children("span.tree-hit").length==0;
};
function _18d(_18e,_18f){
var opts=$.data(_18e,"tree").options;
var node=_ea(_18e,_18f);
if(opts.onBeforeEdit.call(_18e,node)==false){
return;
}
$(_18f).css("position","relative");
var nt=$(_18f).find(".tree-title");
var _190=nt.outerWidth();
nt.empty();
var _191=$("<input class=\"tree-editor\">").appendTo(nt);
_191.val(node.text).focus();
_191.width(_190+20);
_191._outerHeight(18);
_191.bind("click",function(e){
return false;
}).bind("mousedown",function(e){
e.stopPropagation();
}).bind("mousemove",function(e){
e.stopPropagation();
}).bind("keydown",function(e){
if(e.keyCode==13){
_192(_18e,_18f);
return false;
}else{
if(e.keyCode==27){
_196(_18e,_18f);
return false;
}
}
}).bind("blur",function(e){
e.stopPropagation();
_192(_18e,_18f);
});
};
function _192(_193,_194){
var opts=$.data(_193,"tree").options;
$(_194).css("position","");
var _195=$(_194).find("input.tree-editor");
var val=_195.val();
_195.remove();
var node=_ea(_193,_194);
node.text=val;
_12c(_193,node);
opts.onAfterEdit.call(_193,node);
};
function _196(_197,_198){
var opts=$.data(_197,"tree").options;
$(_198).css("position","");
$(_198).find("input.tree-editor").remove();
var node=_ea(_197,_198);
_12c(_197,node);
opts.onCancelEdit.call(_197,node);
};
function _199(_19a,q){
var _19b=$.data(_19a,"tree");
var opts=_19b.options;
var ids={};
$.easyui.forEach(_19b.data,true,function(node){
if(opts.filter.call(_19a,q,node)){
$("#"+node.domId).removeClass("tree-node-hidden");
ids[node.domId]=1;
node.hidden=false;
}else{
$("#"+node.domId).addClass("tree-node-hidden");
node.hidden=true;
}
});
for(var id in ids){
_19c(id);
}
function _19c(_19d){
var p=$(_19a).tree("getParent",$("#"+_19d)[0]);
while(p){
$(p.target).removeClass("tree-node-hidden");
p.hidden=false;
p=$(_19a).tree("getParent",p.target);
}
};
};
$.fn.tree=function(_19e,_19f){
if(typeof _19e=="string"){
return $.fn.tree.methods[_19e](this,_19f);
}
var _19e=_19e||{};
return this.each(function(){
var _1a0=$.data(this,"tree");
var opts;
if(_1a0){
opts=$.extend(_1a0.options,_19e);
_1a0.options=opts;
}else{
opts=$.extend({},$.fn.tree.defaults,$.fn.tree.parseOptions(this),_19e);
$.data(this,"tree",{options:opts,tree:_df(this),data:[],tmpIds:[]});
var data=$.fn.tree.parseData(this);
if(data.length){
_124(this,this,data);
}
}
_e2(this);
if(opts.data){
_124(this,this,$.extend(true,[],opts.data));
}
_136(this,this);
});
};
$.fn.tree.methods={options:function(jq){
return $.data(jq[0],"tree").options;
},loadData:function(jq,data){
return jq.each(function(){
_124(this,this,data);
});
},getNode:function(jq,_1a1){
return _ea(jq[0],_1a1);
},getData:function(jq,_1a2){
return _17d(jq[0],_1a2);
},reload:function(jq,_1a3){
return jq.each(function(){
if(_1a3){
var node=$(_1a3);
var hit=node.children("span.tree-hit");
hit.removeClass("tree-expanded tree-expanded-hover").addClass("tree-collapsed");
node.next().remove();
_13d(this,_1a3);
}else{
$(this).empty();
_136(this,this);
}
});
},getRoot:function(jq,_1a4){
return _16a(jq[0],_1a4);
},getRoots:function(jq){
return _16e(jq[0]);
},getParent:function(jq,_1a5){
return _11f(jq[0],_1a5);
},getChildren:function(jq,_1a6){
return _14c(jq[0],_1a6);
},getChecked:function(jq,_1a7){
return _177(jq[0],_1a7);
},getSelected:function(jq){
return _17b(jq[0]);
},isLeaf:function(jq,_1a8){
return _15b(jq[0],_1a8);
},find:function(jq,id){
return _182(jq[0],id);
},select:function(jq,_1a9){
return jq.each(function(){
_188(this,_1a9);
});
},check:function(jq,_1aa){
return jq.each(function(){
_10c(this,_1aa,true);
});
},uncheck:function(jq,_1ab){
return jq.each(function(){
_10c(this,_1ab,false);
});
},collapse:function(jq,_1ac){
return jq.each(function(){
_142(this,_1ac);
});
},expand:function(jq,_1ad){
return jq.each(function(){
_13d(this,_1ad);
});
},collapseAll:function(jq,_1ae){
return jq.each(function(){
_154(this,_1ae);
});
},expandAll:function(jq,_1af){
return jq.each(function(){
_148(this,_1af);
});
},expandTo:function(jq,_1b0){
return jq.each(function(){
_14d(this,_1b0);
});
},scrollTo:function(jq,_1b1){
return jq.each(function(){
_151(this,_1b1);
});
},toggle:function(jq,_1b2){
return jq.each(function(){
_145(this,_1b2);
});
},append:function(jq,_1b3){
return jq.each(function(){
_158(this,_1b3);
});
},insert:function(jq,_1b4){
return jq.each(function(){
_15d(this,_1b4);
});
},remove:function(jq,_1b5){
return jq.each(function(){
_162(this,_1b5);
});
},pop:function(jq,_1b6){
var node=jq.tree("getData",_1b6);
jq.tree("remove",_1b6);
return node;
},update:function(jq,_1b7){
return jq.each(function(){
_12c(this,$.extend({},_1b7,{checkState:_1b7.checked?"checked":(_1b7.checked===false?"unchecked":undefined)}));
});
},enableDnd:function(jq){
return jq.each(function(){
_ef(this);
});
},disableDnd:function(jq){
return jq.each(function(){
_eb(this);
});
},beginEdit:function(jq,_1b8){
return jq.each(function(){
_18d(this,_1b8);
});
},endEdit:function(jq,_1b9){
return jq.each(function(){
_192(this,_1b9);
});
},cancelEdit:function(jq,_1ba){
return jq.each(function(){
_196(this,_1ba);
});
},doFilter:function(jq,q){
return jq.each(function(){
_199(this,q);
});
}};
$.fn.tree.parseOptions=function(_1bb){
var t=$(_1bb);
return $.extend({},$.parser.parseOptions(_1bb,["url","method",{checkbox:"boolean",cascadeCheck:"boolean",onlyLeafCheck:"boolean"},{animate:"boolean",lines:"boolean",dnd:"boolean"}]));
};
$.fn.tree.parseData=function(_1bc){
var data=[];
_1bd(data,$(_1bc));
return data;
function _1bd(aa,tree){
tree.children("li").each(function(){
var node=$(this);
var item=$.extend({},$.parser.parseOptions(this,["id","iconCls","state"]),{checked:(node.attr("checked")?true:undefined)});
item.text=node.children("span").html();
if(!item.text){
item.text=node.html();
}
var _1be=node.children("ul");
if(_1be.length){
item.children=[];
_1bd(item.children,_1be);
}
aa.push(item);
});
};
};
var _1bf=1;
var _1c0={render:function(_1c1,ul,data){
var _1c2=$.data(_1c1,"tree");
var opts=_1c2.options;
var _1c3=$(ul).prev(".tree-node");
var _1c4=_1c3.length?$(_1c1).tree("getNode",_1c3[0]):null;
var _1c5=_1c3.find("span.tree-indent, span.tree-hit").length;
var cc=_1c6.call(this,_1c5,data);
$(ul).append(cc.join(""));
function _1c6(_1c7,_1c8){
var cc=[];
for(var i=0;i<_1c8.length;i++){
var item=_1c8[i];
if(item.state!="open"&&item.state!="closed"){
item.state="open";
}
item.domId="_easyui_tree_"+_1bf++;
cc.push("<li>");
cc.push("<div id=\""+item.domId+"\" class=\"tree-node\">");
for(var j=0;j<_1c7;j++){
cc.push("<span class=\"tree-indent\"></span>");
}
if(item.state=="closed"){
cc.push("<span class=\"tree-hit tree-collapsed\"></span>");
cc.push("<span class=\"tree-icon tree-folder "+(item.iconCls?item.iconCls:"")+"\"></span>");
}else{
if(item.children&&item.children.length){
cc.push("<span class=\"tree-hit tree-expanded\"></span>");
cc.push("<span class=\"tree-icon tree-folder tree-folder-open "+(item.iconCls?item.iconCls:"")+"\"></span>");
}else{
cc.push("<span class=\"tree-indent\"></span>");
cc.push("<span class=\"tree-icon tree-file "+(item.iconCls?item.iconCls:"")+"\"></span>");
}
}
if(this.hasCheckbox(_1c1,item)){
var flag=0;
if(_1c4&&_1c4.checkState=="checked"&&opts.cascadeCheck){
flag=1;
item.checked=true;
}else{
if(item.checked){
$.easyui.addArrayItem(_1c2.tmpIds,item.domId);
}
}
item.checkState=flag?"checked":"unchecked";
cc.push("<span class=\"tree-checkbox tree-checkbox"+flag+"\"></span>");
}else{
item.checkState=undefined;
item.checked=undefined;
}
cc.push("<span class=\"tree-title\">"+opts.formatter.call(_1c1,item)+"</span>");
cc.push("</div>");
if(item.children&&item.children.length){
var tmp=_1c6.call(this,_1c7+1,item.children);
cc.push("<ul style=\"display:"+(item.state=="closed"?"none":"block")+"\">");
cc=cc.concat(tmp);
cc.push("</ul>");
}
cc.push("</li>");
}
return cc;
};
},hasCheckbox:function(_1c9,item){
var _1ca=$.data(_1c9,"tree");
var opts=_1ca.options;
if(opts.checkbox){
if($.isFunction(opts.checkbox)){
if(opts.checkbox.call(_1c9,item)){
return true;
}else{
return false;
}
}else{
if(opts.onlyLeafCheck){
if(item.state=="open"&&!(item.children&&item.children.length)){
return true;
}
}else{
return true;
}
}
}
return false;
}};
$.fn.tree.defaults={url:null,method:"post",animate:false,checkbox:false,cascadeCheck:true,onlyLeafCheck:false,lines:false,dnd:false,data:null,queryParams:{},formatter:function(node){
return node.text;
},filter:function(q,node){
var qq=[];
$.map($.isArray(q)?q:[q],function(q){
q=$.trim(q);
if(q){
qq.push(q);
}
});
for(var i=0;i<qq.length;i++){
var _1cb=node.text.toLowerCase().indexOf(qq[i].toLowerCase());
if(_1cb>=0){
return true;
}
}
return !qq.length;
},loader:function(_1cc,_1cd,_1ce){
var opts=$(this).tree("options");
if(!opts.url){
return false;
}
$.ajax({type:opts.method,url:opts.url,data:_1cc,dataType:"json",success:function(data){
_1cd(data);
},error:function(){
_1ce.apply(this,arguments);
}});
},loadFilter:function(data,_1cf){
return data;
},view:_1c0,onBeforeLoad:function(node,_1d0){
},onLoadSuccess:function(node,data){
},onLoadError:function(){
},onClick:function(node){
},onDblClick:function(node){
},onBeforeExpand:function(node){
},onExpand:function(node){
},onBeforeCollapse:function(node){
},onCollapse:function(node){
},onBeforeCheck:function(node,_1d1){
},onCheck:function(node,_1d2){
},onBeforeSelect:function(node){
},onSelect:function(node){
},onContextMenu:function(e,node){
},onBeforeDrag:function(node){
},onStartDrag:function(node){
},onStopDrag:function(node){
},onDragEnter:function(_1d3,_1d4){
},onDragOver:function(_1d5,_1d6){
},onDragLeave:function(_1d7,_1d8){
},onBeforeDrop:function(_1d9,_1da,_1db){
},onDrop:function(_1dc,_1dd,_1de){
},onBeforeEdit:function(node){
},onAfterEdit:function(node){
},onCancelEdit:function(node){
}};
})(jQuery);
(function($){
function init(_1df){
$(_1df).addClass("progressbar");
$(_1df).html("<div class=\"progressbar-text\"></div><div class=\"progressbar-value\"><div class=\"progressbar-text\"></div></div>");
$(_1df).bind("_resize",function(e,_1e0){
if($(this).hasClass("easyui-fluid")||_1e0){
_1e1(_1df);
}
return false;
});
return $(_1df);
};
function _1e1(_1e2,_1e3){
var opts=$.data(_1e2,"progressbar").options;
var bar=$.data(_1e2,"progressbar").bar;
if(_1e3){
opts.width=_1e3;
}
bar._size(opts);
bar.find("div.progressbar-text").css("width",bar.width());
bar.find("div.progressbar-text,div.progressbar-value").css({height:bar.height()+"px",lineHeight:bar.height()+"px"});
};
$.fn.progressbar=function(_1e4,_1e5){
if(typeof _1e4=="string"){
var _1e6=$.fn.progressbar.methods[_1e4];
if(_1e6){
return _1e6(this,_1e5);
}
}
_1e4=_1e4||{};
return this.each(function(){
var _1e7=$.data(this,"progressbar");
if(_1e7){
$.extend(_1e7.options,_1e4);
}else{
_1e7=$.data(this,"progressbar",{options:$.extend({},$.fn.progressbar.defaults,$.fn.progressbar.parseOptions(this),_1e4),bar:init(this)});
}
$(this).progressbar("setValue",_1e7.options.value);
_1e1(this);
});
};
$.fn.progressbar.methods={options:function(jq){
return $.data(jq[0],"progressbar").options;
},resize:function(jq,_1e8){
return jq.each(function(){
_1e1(this,_1e8);
});
},getValue:function(jq){
return $.data(jq[0],"progressbar").options.value;
},setValue:function(jq,_1e9){
if(_1e9<0){
_1e9=0;
}
if(_1e9>100){
_1e9=100;
}
return jq.each(function(){
var opts=$.data(this,"progressbar").options;
var text=opts.text.replace(/{value}/,_1e9);
var _1ea=opts.value;
opts.value=_1e9;
$(this).find("div.progressbar-value").width(_1e9+"%");
$(this).find("div.progressbar-text").html(text);
if(_1ea!=_1e9){
opts.onChange.call(this,_1e9,_1ea);
}
});
}};
$.fn.progressbar.parseOptions=function(_1eb){
return $.extend({},$.parser.parseOptions(_1eb,["width","height","text",{value:"number"}]));
};
$.fn.progressbar.defaults={width:"auto",height:22,value:0,text:"{value}%",onChange:function(_1ec,_1ed){
}};
})(jQuery);
(function($){
function init(_1ee){
$(_1ee).addClass("tooltip-f");
};
function _1ef(_1f0){
var opts=$.data(_1f0,"tooltip").options;
$(_1f0).unbind(".tooltip").bind(opts.showEvent+".tooltip",function(e){
$(_1f0).tooltip("show",e);
}).bind(opts.hideEvent+".tooltip",function(e){
$(_1f0).tooltip("hide",e);
}).bind("mousemove.tooltip",function(e){
if(opts.trackMouse){
opts.trackMouseX=e.pageX;
opts.trackMouseY=e.pageY;
$(_1f0).tooltip("reposition");
}
});
};
function _1f1(_1f2){
var _1f3=$.data(_1f2,"tooltip");
if(_1f3.showTimer){
clearTimeout(_1f3.showTimer);
_1f3.showTimer=null;
}
if(_1f3.hideTimer){
clearTimeout(_1f3.hideTimer);
_1f3.hideTimer=null;
}
};
function _1f4(_1f5){
var _1f6=$.data(_1f5,"tooltip");
if(!_1f6||!_1f6.tip){
return;
}
var opts=_1f6.options;
var tip=_1f6.tip;
var pos={left:-100000,top:-100000};
if($(_1f5).is(":visible")){
pos=_1f7(opts.position);
if(opts.position=="top"&&pos.top<0){
pos=_1f7("bottom");
}else{
if((opts.position=="bottom")&&(pos.top+tip._outerHeight()>$(window)._outerHeight()+$(document).scrollTop())){
pos=_1f7("top");
}
}
if(pos.left<0){
if(opts.position=="left"){
pos=_1f7("right");
}else{
$(_1f5).tooltip("arrow").css("left",tip._outerWidth()/2+pos.left);
pos.left=0;
}
}else{
if(pos.left+tip._outerWidth()>$(window)._outerWidth()+$(document)._scrollLeft()){
if(opts.position=="right"){
pos=_1f7("left");
}else{
var left=pos.left;
pos.left=$(window)._outerWidth()+$(document)._scrollLeft()-tip._outerWidth();
$(_1f5).tooltip("arrow").css("left",tip._outerWidth()/2-(pos.left-left));
}
}
}
}
tip.css({left:pos.left,top:pos.top,zIndex:(opts.zIndex!=undefined?opts.zIndex:($.fn.window?$.fn.window.defaults.zIndex++:""))});
opts.onPosition.call(_1f5,pos.left,pos.top);
function _1f7(_1f8){
opts.position=_1f8||"bottom";
tip.removeClass("tooltip-top tooltip-bottom tooltip-left tooltip-right").addClass("tooltip-"+opts.position);
var left,top;
var _1f9=$.isFunction(opts.deltaX)?opts.deltaX.call(_1f5,opts.position):opts.deltaX;
var _1fa=$.isFunction(opts.deltaY)?opts.deltaY.call(_1f5,opts.position):opts.deltaY;
if(opts.trackMouse){
t=$();
left=opts.trackMouseX+_1f9;
top=opts.trackMouseY+_1fa;
}else{
var t=$(_1f5);
left=t.offset().left+_1f9;
top=t.offset().top+_1fa;
}
switch(opts.position){
case "right":
left+=t._outerWidth()+12+(opts.trackMouse?12:0);
top-=(tip._outerHeight()-t._outerHeight())/2;
break;
case "left":
left-=tip._outerWidth()+12+(opts.trackMouse?12:0);
top-=(tip._outerHeight()-t._outerHeight())/2;
break;
case "top":
left-=(tip._outerWidth()-t._outerWidth())/2;
top-=tip._outerHeight()+12+(opts.trackMouse?12:0);
break;
case "bottom":
left-=(tip._outerWidth()-t._outerWidth())/2;
top+=t._outerHeight()+12+(opts.trackMouse?12:0);
break;
}
return {left:left,top:top};
};
};
function _1fb(_1fc,e){
var _1fd=$.data(_1fc,"tooltip");
var opts=_1fd.options;
var tip=_1fd.tip;
if(!tip){
tip=$("<div tabindex=\"-1\" class=\"tooltip\">"+"<div class=\"tooltip-content\"></div>"+"<div class=\"tooltip-arrow-outer\"></div>"+"<div class=\"tooltip-arrow\"></div>"+"</div>").appendTo("body");
_1fd.tip=tip;
_1fe(_1fc);
}
_1f1(_1fc);
_1fd.showTimer=setTimeout(function(){
$(_1fc).tooltip("reposition");
tip.show();
opts.onShow.call(_1fc,e);
var _1ff=tip.children(".tooltip-arrow-outer");
var _200=tip.children(".tooltip-arrow");
var bc="border-"+opts.position+"-color";
_1ff.add(_200).css({borderTopColor:"",borderBottomColor:"",borderLeftColor:"",borderRightColor:""});
_1ff.css(bc,tip.css(bc));
_200.css(bc,tip.css("backgroundColor"));
},opts.showDelay);
};
function _201(_202,e){
var _203=$.data(_202,"tooltip");
if(_203&&_203.tip){
_1f1(_202);
_203.hideTimer=setTimeout(function(){
_203.tip.hide();
_203.options.onHide.call(_202,e);
},_203.options.hideDelay);
}
};
function _1fe(_204,_205){
var _206=$.data(_204,"tooltip");
var opts=_206.options;
if(_205){
opts.content=_205;
}
if(!_206.tip){
return;
}
var cc=typeof opts.content=="function"?opts.content.call(_204):opts.content;
_206.tip.children(".tooltip-content").html(cc);
opts.onUpdate.call(_204,cc);
};
function _207(_208){
var _209=$.data(_208,"tooltip");
if(_209){
_1f1(_208);
var opts=_209.options;
if(_209.tip){
_209.tip.remove();
}
if(opts._title){
$(_208).attr("title",opts._title);
}
$.removeData(_208,"tooltip");
$(_208).unbind(".tooltip").removeClass("tooltip-f");
opts.onDestroy.call(_208);
}
};
$.fn.tooltip=function(_20a,_20b){
if(typeof _20a=="string"){
return $.fn.tooltip.methods[_20a](this,_20b);
}
_20a=_20a||{};
return this.each(function(){
var _20c=$.data(this,"tooltip");
if(_20c){
$.extend(_20c.options,_20a);
}else{
$.data(this,"tooltip",{options:$.extend({},$.fn.tooltip.defaults,$.fn.tooltip.parseOptions(this),_20a)});
init(this);
}
_1ef(this);
_1fe(this);
});
};
$.fn.tooltip.methods={options:function(jq){
return $.data(jq[0],"tooltip").options;
},tip:function(jq){
return $.data(jq[0],"tooltip").tip;
},arrow:function(jq){
return jq.tooltip("tip").children(".tooltip-arrow-outer,.tooltip-arrow");
},show:function(jq,e){
return jq.each(function(){
_1fb(this,e);
});
},hide:function(jq,e){
return jq.each(function(){
_201(this,e);
});
},update:function(jq,_20d){
return jq.each(function(){
_1fe(this,_20d);
});
},reposition:function(jq){
return jq.each(function(){
_1f4(this);
});
},destroy:function(jq){
return jq.each(function(){
_207(this);
});
}};
$.fn.tooltip.parseOptions=function(_20e){
var t=$(_20e);
var opts=$.extend({},$.parser.parseOptions(_20e,["position","showEvent","hideEvent","content",{trackMouse:"boolean",deltaX:"number",deltaY:"number",showDelay:"number",hideDelay:"number"}]),{_title:t.attr("title")});
t.attr("title","");
if(!opts.content){
opts.content=opts._title;
}
return opts;
};
$.fn.tooltip.defaults={position:"bottom",content:null,trackMouse:false,deltaX:0,deltaY:0,showEvent:"mouseenter",hideEvent:"mouseleave",showDelay:200,hideDelay:100,onShow:function(e){
},onHide:function(e){
},onUpdate:function(_20f){
},onPosition:function(left,top){
},onDestroy:function(){
}};
})(jQuery);
(function($){
$.fn._remove=function(){
return this.each(function(){
$(this).remove();
try{
this.outerHTML="";
}
catch(err){
}
});
};
function _210(node){
node._remove();
};
function _211(_212,_213){
var _214=$.data(_212,"panel");
var opts=_214.options;
var _215=_214.panel;
var _216=_215.children(".panel-header");
var _217=_215.children(".panel-body");
var _218=_215.children(".panel-footer");
var _219=(opts.halign=="left"||opts.halign=="right");
if(_213){
$.extend(opts,{width:_213.width,height:_213.height,minWidth:_213.minWidth,maxWidth:_213.maxWidth,minHeight:_213.minHeight,maxHeight:_213.maxHeight,left:_213.left,top:_213.top});
}
_215._size(opts);
if(!_219){
_216._outerWidth(_215.width());
}
_217._outerWidth(_215.width());
if(!isNaN(parseInt(opts.height))){
if(_219){
if(opts.header){
var _21a=$(opts.header)._outerWidth();
}else{
_216.css("width","");
var _21a=_216._outerWidth();
}
var _21b=_216.find(".panel-title");
_21a+=Math.min(_21b._outerWidth(),_21b._outerHeight());
var _21c=_215.height();
_216._outerWidth(_21a)._outerHeight(_21c);
_21b._outerWidth(_216.height());
_217._outerWidth(_215.width()-_21a-_218._outerWidth())._outerHeight(_21c);
_218._outerHeight(_21c);
_217.css({left:"",right:""}).css(opts.halign,(_216.position()[opts.halign]+_21a)+"px");
opts.panelCssWidth=_215.css("width");
if(opts.collapsed){
_215._outerWidth(_21a+_218._outerWidth());
}
}else{
_217._outerHeight(_215.height()-_216._outerHeight()-_218._outerHeight());
}
}else{
_217.css("height","");
var min=$.parser.parseValue("minHeight",opts.minHeight,_215.parent());
var max=$.parser.parseValue("maxHeight",opts.maxHeight,_215.parent());
var _21d=_216._outerHeight()+_218._outerHeight()+_215._outerHeight()-_215.height();
_217._size("minHeight",min?(min-_21d):"");
_217._size("maxHeight",max?(max-_21d):"");
}
_215.css({height:(_219?undefined:""),minHeight:"",maxHeight:"",left:opts.left,top:opts.top});
opts.onResize.apply(_212,[opts.width,opts.height]);
$(_212).panel("doLayout");
};
function _21e(_21f,_220){
var _221=$.data(_21f,"panel");
var opts=_221.options;
var _222=_221.panel;
if(_220){
if(_220.left!=null){
opts.left=_220.left;
}
if(_220.top!=null){
opts.top=_220.top;
}
}
_222.css({left:opts.left,top:opts.top});
_222.find(".tooltip-f").each(function(){
$(this).tooltip("reposition");
});
opts.onMove.apply(_21f,[opts.left,opts.top]);
};
function _223(_224){
$(_224).addClass("panel-body")._size("clear");
var _225=$("<div class=\"panel\"></div>").insertBefore(_224);
_225[0].appendChild(_224);
_225.bind("_resize",function(e,_226){
if($(this).hasClass("easyui-fluid")||_226){
_211(_224);
}
return false;
});
return _225;
};
function _227(_228){
var _229=$.data(_228,"panel");
var opts=_229.options;
var _22a=_229.panel;
_22a.css(opts.style);
_22a.addClass(opts.cls);
_22a.removeClass("panel-hleft panel-hright").addClass("panel-h"+opts.halign);
_22b();
_22c();
var _22d=$(_228).panel("header");
var body=$(_228).panel("body");
var _22e=$(_228).siblings(".panel-footer");
if(opts.border){
_22d.removeClass("panel-header-noborder");
body.removeClass("panel-body-noborder");
_22e.removeClass("panel-footer-noborder");
}else{
_22d.addClass("panel-header-noborder");
body.addClass("panel-body-noborder");
_22e.addClass("panel-footer-noborder");
}
_22d.addClass(opts.headerCls);
body.addClass(opts.bodyCls);
$(_228).attr("id",opts.id||"");
if(opts.content){
$(_228).panel("clear");
$(_228).html(opts.content);
$.parser.parse($(_228));
}
function _22b(){
if(opts.noheader||(!opts.title&&!opts.header)){
_210(_22a.children(".panel-header"));
_22a.children(".panel-body").addClass("panel-body-noheader");
}else{
if(opts.header){
$(opts.header).addClass("panel-header").prependTo(_22a);
}else{
var _22f=_22a.children(".panel-header");
if(!_22f.length){
_22f=$("<div class=\"panel-header\"></div>").prependTo(_22a);
}
if(!$.isArray(opts.tools)){
_22f.find("div.panel-tool .panel-tool-a").appendTo(opts.tools);
}
_22f.empty();
var _230=$("<div class=\"panel-title\"></div>").html(opts.title).appendTo(_22f);
if(opts.iconCls){
_230.addClass("panel-with-icon");
$("<div class=\"panel-icon\"></div>").addClass(opts.iconCls).appendTo(_22f);
}
if(opts.halign=="left"||opts.halign=="right"){
_230.addClass("panel-title-"+opts.titleDirection);
}
var tool=$("<div class=\"panel-tool\"></div>").appendTo(_22f);
tool.bind("click",function(e){
e.stopPropagation();
});
if(opts.tools){
if($.isArray(opts.tools)){
$.map(opts.tools,function(t){
_231(tool,t.iconCls,eval(t.handler));
});
}else{
$(opts.tools).children().each(function(){
$(this).addClass($(this).attr("iconCls")).addClass("panel-tool-a").appendTo(tool);
});
}
}
if(opts.collapsible){
_231(tool,"panel-tool-collapse",function(){
if(opts.collapsed==true){
_251(_228,true);
}else{
_242(_228,true);
}
});
}
if(opts.minimizable){
_231(tool,"panel-tool-min",function(){
_257(_228);
});
}
if(opts.maximizable){
_231(tool,"panel-tool-max",function(){
if(opts.maximized==true){
_25a(_228);
}else{
_241(_228);
}
});
}
if(opts.closable){
_231(tool,"panel-tool-close",function(){
_243(_228);
});
}
}
_22a.children("div.panel-body").removeClass("panel-body-noheader");
}
};
function _231(c,icon,_232){
var a=$("<a href=\"javascript:;\"></a>").addClass(icon).appendTo(c);
a.bind("click",_232);
};
function _22c(){
if(opts.footer){
$(opts.footer).addClass("panel-footer").appendTo(_22a);
$(_228).addClass("panel-body-nobottom");
}else{
_22a.children(".panel-footer").remove();
$(_228).removeClass("panel-body-nobottom");
}
};
};
function _233(_234,_235){
var _236=$.data(_234,"panel");
var opts=_236.options;
if(_237){
opts.queryParams=_235;
}
if(!opts.href){
return;
}
if(!_236.isLoaded||!opts.cache){
var _237=$.extend({},opts.queryParams);
if(opts.onBeforeLoad.call(_234,_237)==false){
return;
}
_236.isLoaded=false;
if(opts.loadingMessage){
$(_234).panel("clear");
$(_234).html($("<div class=\"panel-loading\"></div>").html(opts.loadingMessage));
}
opts.loader.call(_234,_237,function(data){
var _238=opts.extractor.call(_234,data);
$(_234).panel("clear");
$(_234).html(_238);
$.parser.parse($(_234));
opts.onLoad.apply(_234,arguments);
_236.isLoaded=true;
},function(){
opts.onLoadError.apply(_234,arguments);
});
}
};
function _239(_23a){
var t=$(_23a);
t.find(".combo-f").each(function(){
$(this).combo("destroy");
});
t.find(".m-btn").each(function(){
$(this).menubutton("destroy");
});
t.find(".s-btn").each(function(){
$(this).splitbutton("destroy");
});
t.find(".tooltip-f").each(function(){
$(this).tooltip("destroy");
});
t.children("div").each(function(){
$(this)._size("unfit");
});
t.empty();
};
function _23b(_23c){
$(_23c).panel("doLayout",true);
};
function _23d(_23e,_23f){
var opts=$.data(_23e,"panel").options;
var _240=$.data(_23e,"panel").panel;
if(_23f!=true){
if(opts.onBeforeOpen.call(_23e)==false){
return;
}
}
_240.stop(true,true);
if($.isFunction(opts.openAnimation)){
opts.openAnimation.call(_23e,cb);
}else{
switch(opts.openAnimation){
case "slide":
_240.slideDown(opts.openDuration,cb);
break;
case "fade":
_240.fadeIn(opts.openDuration,cb);
break;
case "show":
_240.show(opts.openDuration,cb);
break;
default:
_240.show();
cb();
}
}
function cb(){
opts.closed=false;
opts.minimized=false;
var tool=_240.children(".panel-header").find("a.panel-tool-restore");
if(tool.length){
opts.maximized=true;
}
opts.onOpen.call(_23e);
if(opts.maximized==true){
opts.maximized=false;
_241(_23e);
}
if(opts.collapsed==true){
opts.collapsed=false;
_242(_23e);
}
if(!opts.collapsed){
_233(_23e);
_23b(_23e);
}
};
};
function _243(_244,_245){
var _246=$.data(_244,"panel");
var opts=_246.options;
var _247=_246.panel;
if(_245!=true){
if(opts.onBeforeClose.call(_244)==false){
return;
}
}
_247.find(".tooltip-f").each(function(){
$(this).tooltip("hide");
});
_247.stop(true,true);
_247._size("unfit");
if($.isFunction(opts.closeAnimation)){
opts.closeAnimation.call(_244,cb);
}else{
switch(opts.closeAnimation){
case "slide":
_247.slideUp(opts.closeDuration,cb);
break;
case "fade":
_247.fadeOut(opts.closeDuration,cb);
break;
case "hide":
_247.hide(opts.closeDuration,cb);
break;
default:
_247.hide();
cb();
}
}
function cb(){
opts.closed=true;
opts.onClose.call(_244);
};
};
function _248(_249,_24a){
var _24b=$.data(_249,"panel");
var opts=_24b.options;
var _24c=_24b.panel;
if(_24a!=true){
if(opts.onBeforeDestroy.call(_249)==false){
return;
}
}
$(_249).panel("clear").panel("clear","footer");
_210(_24c);
opts.onDestroy.call(_249);
};
function _242(_24d,_24e){
var opts=$.data(_24d,"panel").options;
var _24f=$.data(_24d,"panel").panel;
var body=_24f.children(".panel-body");
var _250=_24f.children(".panel-header");
var tool=_250.find("a.panel-tool-collapse");
if(opts.collapsed==true){
return;
}
body.stop(true,true);
if(opts.onBeforeCollapse.call(_24d)==false){
return;
}
tool.addClass("panel-tool-expand");
if(_24e==true){
if(opts.halign=="left"||opts.halign=="right"){
_24f.animate({width:_250._outerWidth()+_24f.children(".panel-footer")._outerWidth()},function(){
cb();
});
}else{
body.slideUp("normal",function(){
cb();
});
}
}else{
if(opts.halign=="left"||opts.halign=="right"){
_24f._outerWidth(_250._outerWidth()+_24f.children(".panel-footer")._outerWidth());
}
cb();
}
function cb(){
body.hide();
opts.collapsed=true;
opts.onCollapse.call(_24d);
};
};
function _251(_252,_253){
var opts=$.data(_252,"panel").options;
var _254=$.data(_252,"panel").panel;
var body=_254.children(".panel-body");
var tool=_254.children(".panel-header").find("a.panel-tool-collapse");
if(opts.collapsed==false){
return;
}
body.stop(true,true);
if(opts.onBeforeExpand.call(_252)==false){
return;
}
tool.removeClass("panel-tool-expand");
if(_253==true){
if(opts.halign=="left"||opts.halign=="right"){
body.show();
_254.animate({width:opts.panelCssWidth},function(){
cb();
});
}else{
body.slideDown("normal",function(){
cb();
});
}
}else{
if(opts.halign=="left"||opts.halign=="right"){
_254.css("width",opts.panelCssWidth);
}
cb();
}
function cb(){
body.show();
opts.collapsed=false;
opts.onExpand.call(_252);
_233(_252);
_23b(_252);
};
};
function _241(_255){
var opts=$.data(_255,"panel").options;
var _256=$.data(_255,"panel").panel;
var tool=_256.children(".panel-header").find("a.panel-tool-max");
if(opts.maximized==true){
return;
}
tool.addClass("panel-tool-restore");
if(!$.data(_255,"panel").original){
$.data(_255,"panel").original={width:opts.width,height:opts.height,left:opts.left,top:opts.top,fit:opts.fit};
}
opts.left=0;
opts.top=0;
opts.fit=true;
_211(_255);
opts.minimized=false;
opts.maximized=true;
opts.onMaximize.call(_255);
};
function _257(_258){
var opts=$.data(_258,"panel").options;
var _259=$.data(_258,"panel").panel;
_259._size("unfit");
_259.hide();
opts.minimized=true;
opts.maximized=false;
opts.onMinimize.call(_258);
};
function _25a(_25b){
var opts=$.data(_25b,"panel").options;
var _25c=$.data(_25b,"panel").panel;
var tool=_25c.children(".panel-header").find("a.panel-tool-max");
if(opts.maximized==false){
return;
}
_25c.show();
tool.removeClass("panel-tool-restore");
$.extend(opts,$.data(_25b,"panel").original);
_211(_25b);
opts.minimized=false;
opts.maximized=false;
$.data(_25b,"panel").original=null;
opts.onRestore.call(_25b);
};
function _25d(_25e,_25f){
$.data(_25e,"panel").options.title=_25f;
$(_25e).panel("header").find("div.panel-title").html(_25f);
};
var _260=null;
$(window).unbind(".panel").bind("resize.panel",function(){
if(_260){
clearTimeout(_260);
}
_260=setTimeout(function(){
var _261=$("body.layout");
if(_261.length){
_261.layout("resize");
$("body").children(".easyui-fluid:visible").each(function(){
$(this).triggerHandler("_resize");
});
}else{
$("body").panel("doLayout");
}
_260=null;
},100);
});
$.fn.panel=function(_262,_263){
if(typeof _262=="string"){
return $.fn.panel.methods[_262](this,_263);
}
_262=_262||{};
return this.each(function(){
var _264=$.data(this,"panel");
var opts;
if(_264){
opts=$.extend(_264.options,_262);
_264.isLoaded=false;
}else{
opts=$.extend({},$.fn.panel.defaults,$.fn.panel.parseOptions(this),_262);
$(this).attr("title","");
_264=$.data(this,"panel",{options:opts,panel:_223(this),isLoaded:false});
}
_227(this);
$(this).show();
if(opts.doSize==true){
_264.panel.css("display","block");
_211(this);
}
if(opts.closed==true||opts.minimized==true){
_264.panel.hide();
}else{
_23d(this);
}
});
};
$.fn.panel.methods={options:function(jq){
return $.data(jq[0],"panel").options;
},panel:function(jq){
return $.data(jq[0],"panel").panel;
},header:function(jq){
return $.data(jq[0],"panel").panel.children(".panel-header");
},footer:function(jq){
return jq.panel("panel").children(".panel-footer");
},body:function(jq){
return $.data(jq[0],"panel").panel.children(".panel-body");
},setTitle:function(jq,_265){
return jq.each(function(){
_25d(this,_265);
});
},open:function(jq,_266){
return jq.each(function(){
_23d(this,_266);
});
},close:function(jq,_267){
return jq.each(function(){
_243(this,_267);
});
},destroy:function(jq,_268){
return jq.each(function(){
_248(this,_268);
});
},clear:function(jq,type){
return jq.each(function(){
_239(type=="footer"?$(this).panel("footer"):this);
});
},refresh:function(jq,href){
return jq.each(function(){
var _269=$.data(this,"panel");
_269.isLoaded=false;
if(href){
if(typeof href=="string"){
_269.options.href=href;
}else{
_269.options.queryParams=href;
}
}
_233(this);
});
},resize:function(jq,_26a){
return jq.each(function(){
_211(this,_26a);
});
},doLayout:function(jq,all){
return jq.each(function(){
_26b(this,"body");
_26b($(this).siblings(".panel-footer")[0],"footer");
function _26b(_26c,type){
if(!_26c){
return;
}
var _26d=_26c==$("body")[0];
var s=$(_26c).find("div.panel:visible,div.accordion:visible,div.tabs-container:visible,div.layout:visible,.easyui-fluid:visible").filter(function(_26e,el){
var p=$(el).parents(".panel-"+type+":first");
return _26d?p.length==0:p[0]==_26c;
});
s.each(function(){
$(this).triggerHandler("_resize",[all||false]);
});
};
});
},move:function(jq,_26f){
return jq.each(function(){
_21e(this,_26f);
});
},maximize:function(jq){
return jq.each(function(){
_241(this);
});
},minimize:function(jq){
return jq.each(function(){
_257(this);
});
},restore:function(jq){
return jq.each(function(){
_25a(this);
});
},collapse:function(jq,_270){
return jq.each(function(){
_242(this,_270);
});
},expand:function(jq,_271){
return jq.each(function(){
_251(this,_271);
});
}};
$.fn.panel.parseOptions=function(_272){
var t=$(_272);
var hh=t.children(".panel-header,header");
var ff=t.children(".panel-footer,footer");
return $.extend({},$.parser.parseOptions(_272,["id","width","height","left","top","title","iconCls","cls","headerCls","bodyCls","tools","href","method","header","footer","halign","titleDirection",{cache:"boolean",fit:"boolean",border:"boolean",noheader:"boolean"},{collapsible:"boolean",minimizable:"boolean",maximizable:"boolean"},{closable:"boolean",collapsed:"boolean",minimized:"boolean",maximized:"boolean",closed:"boolean"},"openAnimation","closeAnimation",{openDuration:"number",closeDuration:"number"},]),{loadingMessage:(t.attr("loadingMessage")!=undefined?t.attr("loadingMessage"):undefined),header:(hh.length?hh.removeClass("panel-header"):undefined),footer:(ff.length?ff.removeClass("panel-footer"):undefined)});
};
$.fn.panel.defaults={id:null,title:null,iconCls:null,width:"auto",height:"auto",left:null,top:null,cls:null,headerCls:null,bodyCls:null,style:{},href:null,cache:true,fit:false,border:true,doSize:true,noheader:false,content:null,halign:"top",titleDirection:"down",collapsible:false,minimizable:false,maximizable:false,closable:false,collapsed:false,minimized:false,maximized:false,closed:false,openAnimation:false,openDuration:400,closeAnimation:false,closeDuration:400,tools:null,footer:null,header:null,queryParams:{},method:"get",href:null,loadingMessage:"Loading...",loader:function(_273,_274,_275){
var opts=$(this).panel("options");
if(!opts.href){
return false;
}
$.ajax({type:opts.method,url:opts.href,cache:false,data:_273,dataType:"html",success:function(data){
_274(data);
},error:function(){
_275.apply(this,arguments);
}});
},extractor:function(data){
var _276=/<body[^>]*>((.|[\n\r])*)<\/body>/im;
var _277=_276.exec(data);
if(_277){
return _277[1];
}else{
return data;
}
},onBeforeLoad:function(_278){
},onLoad:function(){
},onLoadError:function(){
},onBeforeOpen:function(){
},onOpen:function(){
},onBeforeClose:function(){
},onClose:function(){
},onBeforeDestroy:function(){
},onDestroy:function(){
},onResize:function(_279,_27a){
},onMove:function(left,top){
},onMaximize:function(){
},onRestore:function(){
},onMinimize:function(){
},onBeforeCollapse:function(){
},onBeforeExpand:function(){
},onCollapse:function(){
},onExpand:function(){
}};
})(jQuery);
(function($){
function _27b(_27c,_27d){
var _27e=$.data(_27c,"window");
if(_27d){
if(_27d.left!=null){
_27e.options.left=_27d.left;
}
if(_27d.top!=null){
_27e.options.top=_27d.top;
}
}
$(_27c).panel("move",_27e.options);
if(_27e.shadow){
_27e.shadow.css({left:_27e.options.left,top:_27e.options.top});
}
};
function _27f(_280,_281){
var opts=$.data(_280,"window").options;
var pp=$(_280).window("panel");
var _282=pp._outerWidth();
if(opts.inline){
var _283=pp.parent();
opts.left=Math.ceil((_283.width()-_282)/2+_283.scrollLeft());
}else{
opts.left=Math.ceil(($(window)._outerWidth()-_282)/2+$(document).scrollLeft());
}
if(_281){
_27b(_280);
}
};
function _284(_285,_286){
var opts=$.data(_285,"window").options;
var pp=$(_285).window("panel");
var _287=pp._outerHeight();
if(opts.inline){
var _288=pp.parent();
opts.top=Math.ceil((_288.height()-_287)/2+_288.scrollTop());
}else{
opts.top=Math.ceil(($(window)._outerHeight()-_287)/2+$(document).scrollTop());
}
if(_286){
_27b(_285);
}
};
function _289(_28a){
var _28b=$.data(_28a,"window");
var opts=_28b.options;
var win=$(_28a).panel($.extend({},_28b.options,{border:false,doSize:true,closed:true,cls:"window "+(!opts.border?"window-thinborder window-noborder ":(opts.border=="thin"?"window-thinborder ":""))+(opts.cls||""),headerCls:"window-header "+(opts.headerCls||""),bodyCls:"window-body "+(opts.noheader?"window-body-noheader ":" ")+(opts.bodyCls||""),onBeforeDestroy:function(){
if(opts.onBeforeDestroy.call(_28a)==false){
return false;
}
if(_28b.shadow){
_28b.shadow.remove();
}
if(_28b.mask){
_28b.mask.remove();
}
},onClose:function(){
if(_28b.shadow){
_28b.shadow.hide();
}
if(_28b.mask){
_28b.mask.hide();
}
opts.onClose.call(_28a);
},onOpen:function(){
if(_28b.mask){
_28b.mask.css($.extend({display:"block",zIndex:$.fn.window.defaults.zIndex++},$.fn.window.getMaskSize(_28a)));
}
if(_28b.shadow){
_28b.shadow.css({display:"block",zIndex:$.fn.window.defaults.zIndex++,left:opts.left,top:opts.top,width:_28b.window._outerWidth(),height:_28b.window._outerHeight()});
}
_28b.window.css("z-index",$.fn.window.defaults.zIndex++);
opts.onOpen.call(_28a);
},onResize:function(_28c,_28d){
var _28e=$(this).panel("options");
$.extend(opts,{width:_28e.width,height:_28e.height,left:_28e.left,top:_28e.top});
if(_28b.shadow){
_28b.shadow.css({left:opts.left,top:opts.top,width:_28b.window._outerWidth(),height:_28b.window._outerHeight()});
}
opts.onResize.call(_28a,_28c,_28d);
},onMinimize:function(){
if(_28b.shadow){
_28b.shadow.hide();
}
if(_28b.mask){
_28b.mask.hide();
}
_28b.options.onMinimize.call(_28a);
},onBeforeCollapse:function(){
if(opts.onBeforeCollapse.call(_28a)==false){
return false;
}
if(_28b.shadow){
_28b.shadow.hide();
}
},onExpand:function(){
if(_28b.shadow){
_28b.shadow.show();
}
opts.onExpand.call(_28a);
}}));
_28b.window=win.panel("panel");
if(_28b.mask){
_28b.mask.remove();
}
if(opts.modal){
_28b.mask=$("<div class=\"window-mask\" style=\"display:none\"></div>").insertAfter(_28b.window);
}
if(_28b.shadow){
_28b.shadow.remove();
}
if(opts.shadow){
_28b.shadow=$("<div class=\"window-shadow\" style=\"display:none\"></div>").insertAfter(_28b.window);
}
var _28f=opts.closed;
if(opts.left==null){
_27f(_28a);
}
if(opts.top==null){
_284(_28a);
}
_27b(_28a);
if(!_28f){
win.window("open");
}
};
function _290(left,top,_291,_292){
var _293=this;
var _294=$.data(_293,"window");
var opts=_294.options;
if(!opts.constrain){
return {};
}
if($.isFunction(opts.constrain)){
return opts.constrain.call(_293,left,top,_291,_292);
}
var win=$(_293).window("window");
var _295=opts.inline?win.parent():$(window);
if(left<0){
left=0;
}
if(top<_295.scrollTop()){
top=_295.scrollTop();
}
if(left+_291>_295.width()){
if(_291==win.outerWidth()){
left=_295.width()-_291;
}else{
_291=_295.width()-left;
}
}
if(top-_295.scrollTop()+_292>_295.height()){
if(_292==win.outerHeight()){
top=_295.height()-_292+_295.scrollTop();
}else{
_292=_295.height()-top+_295.scrollTop();
}
}
return {left:left,top:top,width:_291,height:_292};
};
function _296(_297){
var _298=$.data(_297,"window");
_298.window.draggable({handle:">div.panel-header>div.panel-title",disabled:_298.options.draggable==false,onBeforeDrag:function(e){
if(_298.mask){
_298.mask.css("z-index",$.fn.window.defaults.zIndex++);
}
if(_298.shadow){
_298.shadow.css("z-index",$.fn.window.defaults.zIndex++);
}
_298.window.css("z-index",$.fn.window.defaults.zIndex++);
},onStartDrag:function(e){
_299(e);
},onDrag:function(e){
_29a(e);
return false;
},onStopDrag:function(e){
_29b(e,"move");
}});
_298.window.resizable({disabled:_298.options.resizable==false,onStartResize:function(e){
_299(e);
},onResize:function(e){
_29a(e);
return false;
},onStopResize:function(e){
_29b(e,"resize");
}});
function _299(e){
if(_298.pmask){
_298.pmask.remove();
}
_298.pmask=$("<div class=\"window-proxy-mask\"></div>").insertAfter(_298.window);
_298.pmask.css({display:"none",zIndex:$.fn.window.defaults.zIndex++,left:e.data.left,top:e.data.top,width:_298.window._outerWidth(),height:_298.window._outerHeight()});
if(_298.proxy){
_298.proxy.remove();
}
_298.proxy=$("<div class=\"window-proxy\"></div>").insertAfter(_298.window);
_298.proxy.css({display:"none",zIndex:$.fn.window.defaults.zIndex++,left:e.data.left,top:e.data.top});
_298.proxy._outerWidth(e.data.width)._outerHeight(e.data.height);
_298.proxy.hide();
setTimeout(function(){
if(_298.pmask){
_298.pmask.show();
}
if(_298.proxy){
_298.proxy.show();
}
},500);
};
function _29a(e){
$.extend(e.data,_290.call(_297,e.data.left,e.data.top,e.data.width,e.data.height));
_298.pmask.show();
_298.proxy.css({display:"block",left:e.data.left,top:e.data.top});
_298.proxy._outerWidth(e.data.width);
_298.proxy._outerHeight(e.data.height);
};
function _29b(e,_29c){
$.extend(e.data,_290.call(_297,e.data.left,e.data.top,e.data.width+0.1,e.data.height+0.1));
$(_297).window(_29c,e.data);
_298.pmask.remove();
_298.pmask=null;
_298.proxy.remove();
_298.proxy=null;
};
};
$(function(){
if(!$._positionFixed){
$(window).resize(function(){
$("body>div.window-mask:visible").css({width:"",height:""});
setTimeout(function(){
$("body>div.window-mask:visible").css($.fn.window.getMaskSize());
},50);
});
}
});
$.fn.window=function(_29d,_29e){
if(typeof _29d=="string"){
var _29f=$.fn.window.methods[_29d];
if(_29f){
return _29f(this,_29e);
}else{
return this.panel(_29d,_29e);
}
}
_29d=_29d||{};
return this.each(function(){
var _2a0=$.data(this,"window");
if(_2a0){
$.extend(_2a0.options,_29d);
}else{
_2a0=$.data(this,"window",{options:$.extend({},$.fn.window.defaults,$.fn.window.parseOptions(this),_29d)});
if(!_2a0.options.inline){
document.body.appendChild(this);
}
}
_289(this);
_296(this);
});
};
$.fn.window.methods={options:function(jq){
var _2a1=jq.panel("options");
var _2a2=$.data(jq[0],"window").options;
return $.extend(_2a2,{closed:_2a1.closed,collapsed:_2a1.collapsed,minimized:_2a1.minimized,maximized:_2a1.maximized});
},window:function(jq){
return $.data(jq[0],"window").window;
},move:function(jq,_2a3){
return jq.each(function(){
_27b(this,_2a3);
});
},hcenter:function(jq){
return jq.each(function(){
_27f(this,true);
});
},vcenter:function(jq){
return jq.each(function(){
_284(this,true);
});
},center:function(jq){
return jq.each(function(){
_27f(this);
_284(this);
_27b(this);
});
}};
$.fn.window.getMaskSize=function(_2a4){
var _2a5=$(_2a4).data("window");
if(_2a5&&_2a5.options.inline){
return {};
}else{
if($._positionFixed){
return {position:"fixed"};
}else{
return {width:$(document).width(),height:$(document).height()};
}
}
};
$.fn.window.parseOptions=function(_2a6){
return $.extend({},$.fn.panel.parseOptions(_2a6),$.parser.parseOptions(_2a6,[{draggable:"boolean",resizable:"boolean",shadow:"boolean",modal:"boolean",inline:"boolean"}]));
};
$.fn.window.defaults=$.extend({},$.fn.panel.defaults,{zIndex:9000,draggable:true,resizable:true,shadow:true,modal:false,border:true,inline:false,title:"New Window",collapsible:true,minimizable:true,maximizable:true,closable:true,closed:false,constrain:false});
})(jQuery);
(function($){
function _2a7(_2a8){
var opts=$.data(_2a8,"dialog").options;
opts.inited=false;
$(_2a8).window($.extend({},opts,{onResize:function(w,h){
if(opts.inited){
_2ad(this);
opts.onResize.call(this,w,h);
}
}}));
var win=$(_2a8).window("window");
if(opts.toolbar){
if($.isArray(opts.toolbar)){
$(_2a8).siblings("div.dialog-toolbar").remove();
var _2a9=$("<div class=\"dialog-toolbar\"><table cellspacing=\"0\" cellpadding=\"0\"><tr></tr></table></div>").appendTo(win);
var tr=_2a9.find("tr");
for(var i=0;i<opts.toolbar.length;i++){
var btn=opts.toolbar[i];
if(btn=="-"){
$("<td><div class=\"dialog-tool-separator\"></div></td>").appendTo(tr);
}else{
var td=$("<td></td>").appendTo(tr);
var tool=$("<a href=\"javascript:;\"></a>").appendTo(td);
tool[0].onclick=eval(btn.handler||function(){
});
tool.linkbutton($.extend({},btn,{plain:true}));
}
}
}else{
$(opts.toolbar).addClass("dialog-toolbar").appendTo(win);
$(opts.toolbar).show();
}
}else{
$(_2a8).siblings("div.dialog-toolbar").remove();
}
if(opts.buttons){
if($.isArray(opts.buttons)){
$(_2a8).siblings("div.dialog-button").remove();
var _2aa=$("<div class=\"dialog-button\"></div>").appendTo(win);
for(var i=0;i<opts.buttons.length;i++){
var p=opts.buttons[i];
var _2ab=$("<a href=\"javascript:;\"></a>").appendTo(_2aa);
if(p.handler){
_2ab[0].onclick=p.handler;
}
_2ab.linkbutton(p);
}
}else{
$(opts.buttons).addClass("dialog-button").appendTo(win);
$(opts.buttons).show();
}
}else{
$(_2a8).siblings("div.dialog-button").remove();
}
opts.inited=true;
var _2ac=opts.closed;
win.show();
$(_2a8).window("resize");
if(_2ac){
win.hide();
}
};
function _2ad(_2ae,_2af){
var t=$(_2ae);
var opts=t.dialog("options");
var _2b0=opts.noheader;
var tb=t.siblings(".dialog-toolbar");
var bb=t.siblings(".dialog-button");
tb.insertBefore(_2ae).css({borderTopWidth:(_2b0?1:0),top:(_2b0?tb.length:0)});
bb.insertAfter(_2ae);
tb.add(bb)._outerWidth(t._outerWidth()).find(".easyui-fluid:visible").each(function(){
$(this).triggerHandler("_resize");
});
var _2b1=tb._outerHeight()+bb._outerHeight();
if(!isNaN(parseInt(opts.height))){
t._outerHeight(t._outerHeight()-_2b1);
}else{
var _2b2=t._size("min-height");
if(_2b2){
t._size("min-height",_2b2-_2b1);
}
var _2b3=t._size("max-height");
if(_2b3){
t._size("max-height",_2b3-_2b1);
}
}
var _2b4=$.data(_2ae,"window").shadow;
if(_2b4){
var cc=t.panel("panel");
_2b4.css({width:cc._outerWidth(),height:cc._outerHeight()});
}
};
$.fn.dialog=function(_2b5,_2b6){
if(typeof _2b5=="string"){
var _2b7=$.fn.dialog.methods[_2b5];
if(_2b7){
return _2b7(this,_2b6);
}else{
return this.window(_2b5,_2b6);
}
}
_2b5=_2b5||{};
return this.each(function(){
var _2b8=$.data(this,"dialog");
if(_2b8){
$.extend(_2b8.options,_2b5);
}else{
$.data(this,"dialog",{options:$.extend({},$.fn.dialog.defaults,$.fn.dialog.parseOptions(this),_2b5)});
}
_2a7(this);
});
};
$.fn.dialog.methods={options:function(jq){
var _2b9=$.data(jq[0],"dialog").options;
var _2ba=jq.panel("options");
$.extend(_2b9,{width:_2ba.width,height:_2ba.height,left:_2ba.left,top:_2ba.top,closed:_2ba.closed,collapsed:_2ba.collapsed,minimized:_2ba.minimized,maximized:_2ba.maximized});
return _2b9;
},dialog:function(jq){
return jq.window("window");
}};
$.fn.dialog.parseOptions=function(_2bb){
var t=$(_2bb);
return $.extend({},$.fn.window.parseOptions(_2bb),$.parser.parseOptions(_2bb,["toolbar","buttons"]),{toolbar:(t.children(".dialog-toolbar").length?t.children(".dialog-toolbar").removeClass("dialog-toolbar"):undefined),buttons:(t.children(".dialog-button").length?t.children(".dialog-button").removeClass("dialog-button"):undefined)});
};
$.fn.dialog.defaults=$.extend({},$.fn.window.defaults,{title:"New Dialog",collapsible:false,minimizable:false,maximizable:false,resizable:false,toolbar:null,buttons:null});
})(jQuery);
(function($){
function _2bc(){
$(document).unbind(".messager").bind("keydown.messager",function(e){
if(e.keyCode==27){
$("body").children("div.messager-window").children("div.messager-body").each(function(){
$(this).dialog("close");
});
}else{
if(e.keyCode==9){
var win=$("body").children("div.messager-window");
if(!win.length){
return;
}
var _2bd=win.find(".messager-input,.messager-button .l-btn");
for(var i=0;i<_2bd.length;i++){
if($(_2bd[i]).is(":focus")){
$(_2bd[i>=_2bd.length-1?0:i+1]).focus();
return false;
}
}
}else{
if(e.keyCode==13){
var _2be=$(e.target).closest("input.messager-input");
if(_2be.length){
var dlg=_2be.closest(".messager-body");
_2bf(dlg,_2be.val());
}
}
}
}
});
};
function _2c0(){
$(document).unbind(".messager");
};
function _2c1(_2c2){
var opts=$.extend({},$.messager.defaults,{modal:false,shadow:false,draggable:false,resizable:false,closed:true,style:{left:"",top:"",right:0,zIndex:$.fn.window.defaults.zIndex++,bottom:-document.body.scrollTop-document.documentElement.scrollTop},title:"",width:250,height:100,minHeight:0,showType:"slide",showSpeed:600,content:_2c2.msg,timeout:4000},_2c2);
var dlg=$("<div class=\"messager-body\"></div>").appendTo("body");
dlg.dialog($.extend({},opts,{noheader:(opts.title?false:true),openAnimation:(opts.showType),closeAnimation:(opts.showType=="show"?"hide":opts.showType),openDuration:opts.showSpeed,closeDuration:opts.showSpeed,onOpen:function(){
dlg.dialog("dialog").hover(function(){
if(opts.timer){
clearTimeout(opts.timer);
}
},function(){
_2c3();
});
_2c3();
function _2c3(){
if(opts.timeout>0){
opts.timer=setTimeout(function(){
if(dlg.length&&dlg.data("dialog")){
dlg.dialog("close");
}
},opts.timeout);
}
};
if(_2c2.onOpen){
_2c2.onOpen.call(this);
}else{
opts.onOpen.call(this);
}
},onClose:function(){
if(opts.timer){
clearTimeout(opts.timer);
}
if(_2c2.onClose){
_2c2.onClose.call(this);
}else{
opts.onClose.call(this);
}
dlg.dialog("destroy");
}}));
dlg.dialog("dialog").css(opts.style);
dlg.dialog("open");
return dlg;
};
function _2c4(_2c5){
_2bc();
var dlg=$("<div class=\"messager-body\"></div>").appendTo("body");
dlg.dialog($.extend({},_2c5,{noheader:(_2c5.title?false:true),onClose:function(){
_2c0();
if(_2c5.onClose){
_2c5.onClose.call(this);
}
setTimeout(function(){
dlg.dialog("destroy");
},100);
}}));
var win=dlg.dialog("dialog").addClass("messager-window");
win.find(".dialog-button").addClass("messager-button").find("a:first").focus();
return dlg;
};
function _2bf(dlg,_2c6){
dlg.dialog("close");
dlg.dialog("options").fn(_2c6);
};
$.messager={show:function(_2c7){
return _2c1(_2c7);
},alert:function(_2c8,msg,icon,fn){
var opts=typeof _2c8=="object"?_2c8:{title:_2c8,msg:msg,icon:icon,fn:fn};
var cls=opts.icon?"messager-icon messager-"+opts.icon:"";
opts=$.extend({},$.messager.defaults,{content:"<div class=\""+cls+"\"></div>"+"<div>"+opts.msg+"</div>"+"<div style=\"clear:both;\"/>"},opts);
if(!opts.buttons){
opts.buttons=[{text:opts.ok,onClick:function(){
_2bf(dlg);
}}];
}
var dlg=_2c4(opts);
return dlg;
},confirm:function(_2c9,msg,fn){
var opts=typeof _2c9=="object"?_2c9:{title:_2c9,msg:msg,fn:fn};
opts=$.extend({},$.messager.defaults,{content:"<div class=\"messager-icon messager-question\"></div>"+"<div>"+opts.msg+"</div>"+"<div style=\"clear:both;\"/>"},opts);
if(!opts.buttons){
opts.buttons=[{text:opts.ok,onClick:function(){
_2bf(dlg,true);
}},{text:opts.cancel,onClick:function(){
_2bf(dlg,false);
}}];
}
var dlg=_2c4(opts);
return dlg;
},prompt:function(_2ca,msg,fn){
var opts=typeof _2ca=="object"?_2ca:{title:_2ca,msg:msg,fn:fn};
opts=$.extend({},$.messager.defaults,{content:"<div class=\"messager-icon messager-question\"></div>"+"<div>"+opts.msg+"</div>"+"<br/>"+"<div style=\"clear:both;\"/>"+"<div><input class=\"messager-input\" type=\"text\"/></div>"},opts);
if(!opts.buttons){
opts.buttons=[{text:opts.ok,onClick:function(){
_2bf(dlg,dlg.find(".messager-input").val());
}},{text:opts.cancel,onClick:function(){
_2bf(dlg);
}}];
}
var dlg=_2c4(opts);
dlg.find(".messager-input").focus();
return dlg;
},progress:function(_2cb){
var _2cc={bar:function(){
return $("body>div.messager-window").find("div.messager-p-bar");
},close:function(){
var dlg=$("body>div.messager-window>div.messager-body:has(div.messager-progress)");
if(dlg.length){
dlg.dialog("close");
}
}};
if(typeof _2cb=="string"){
var _2cd=_2cc[_2cb];
return _2cd();
}
_2cb=_2cb||{};
var opts=$.extend({},{title:"",minHeight:0,content:undefined,msg:"",text:undefined,interval:300},_2cb);
var dlg=_2c4($.extend({},$.messager.defaults,{content:"<div class=\"messager-progress\"><div class=\"messager-p-msg\">"+opts.msg+"</div><div class=\"messager-p-bar\"></div></div>",closable:false,doSize:false},opts,{onClose:function(){
if(this.timer){
clearInterval(this.timer);
}
if(_2cb.onClose){
_2cb.onClose.call(this);
}else{
$.messager.defaults.onClose.call(this);
}
}}));
var bar=dlg.find("div.messager-p-bar");
bar.progressbar({text:opts.text});
dlg.dialog("resize");
if(opts.interval){
dlg[0].timer=setInterval(function(){
var v=bar.progressbar("getValue");
v+=10;
if(v>100){
v=0;
}
bar.progressbar("setValue",v);
},opts.interval);
}
return dlg;
}};
$.messager.defaults=$.extend({},$.fn.dialog.defaults,{ok:"Ok",cancel:"Cancel",width:300,height:"auto",minHeight:150,modal:true,collapsible:false,minimizable:false,maximizable:false,resizable:false,fn:function(){
}});
})(jQuery);
(function($){
function _2ce(_2cf,_2d0){
var _2d1=$.data(_2cf,"accordion");
var opts=_2d1.options;
var _2d2=_2d1.panels;
var cc=$(_2cf);
var _2d3=(opts.halign=="left"||opts.halign=="right");
cc.children(".panel-last").removeClass("panel-last");
cc.children(".panel:last").addClass("panel-last");
if(_2d0){
$.extend(opts,{width:_2d0.width,height:_2d0.height});
}
cc._size(opts);
var _2d4=0;
var _2d5="auto";
var _2d6=cc.find(">.panel>.accordion-header");
if(_2d6.length){
if(_2d3){
$(_2d2[0]).panel("resize",{width:cc.width(),height:cc.height()});
_2d4=$(_2d6[0])._outerWidth();
}else{
_2d4=$(_2d6[0]).css("height","")._outerHeight();
}
}
if(!isNaN(parseInt(opts.height))){
if(_2d3){
_2d5=cc.width()-_2d4*_2d6.length;
}else{
_2d5=cc.height()-_2d4*_2d6.length;
}
}
_2d7(true,_2d5-_2d7(false));
function _2d7(_2d8,_2d9){
var _2da=0;
for(var i=0;i<_2d2.length;i++){
var p=_2d2[i];
if(_2d3){
var h=p.panel("header")._outerWidth(_2d4);
}else{
var h=p.panel("header")._outerHeight(_2d4);
}
if(p.panel("options").collapsible==_2d8){
var _2db=isNaN(_2d9)?undefined:(_2d9+_2d4*h.length);
if(_2d3){
p.panel("resize",{height:cc.height(),width:(_2d8?_2db:undefined)});
_2da+=p.panel("panel")._outerWidth()-_2d4*h.length;
}else{
p.panel("resize",{width:cc.width(),height:(_2d8?_2db:undefined)});
_2da+=p.panel("panel").outerHeight()-_2d4*h.length;
}
}
}
return _2da;
};
};
function _2dc(_2dd,_2de,_2df,all){
var _2e0=$.data(_2dd,"accordion").panels;
var pp=[];
for(var i=0;i<_2e0.length;i++){
var p=_2e0[i];
if(_2de){
if(p.panel("options")[_2de]==_2df){
pp.push(p);
}
}else{
if(p[0]==$(_2df)[0]){
return i;
}
}
}
if(_2de){
return all?pp:(pp.length?pp[0]:null);
}else{
return -1;
}
};
function _2e1(_2e2){
return _2dc(_2e2,"collapsed",false,true);
};
function _2e3(_2e4){
var pp=_2e1(_2e4);
return pp.length?pp[0]:null;
};
function _2e5(_2e6,_2e7){
return _2dc(_2e6,null,_2e7);
};
function _2e8(_2e9,_2ea){
var _2eb=$.data(_2e9,"accordion").panels;
if(typeof _2ea=="number"){
if(_2ea<0||_2ea>=_2eb.length){
return null;
}else{
return _2eb[_2ea];
}
}
return _2dc(_2e9,"title",_2ea);
};
function _2ec(_2ed){
var opts=$.data(_2ed,"accordion").options;
var cc=$(_2ed);
if(opts.border){
cc.removeClass("accordion-noborder");
}else{
cc.addClass("accordion-noborder");
}
};
function init(_2ee){
var _2ef=$.data(_2ee,"accordion");
var cc=$(_2ee);
cc.addClass("accordion");
_2ef.panels=[];
cc.children("div").each(function(){
var opts=$.extend({},$.parser.parseOptions(this),{selected:($(this).attr("selected")?true:undefined)});
var pp=$(this);
_2ef.panels.push(pp);
_2f1(_2ee,pp,opts);
});
cc.bind("_resize",function(e,_2f0){
if($(this).hasClass("easyui-fluid")||_2f0){
_2ce(_2ee);
}
return false;
});
};
function _2f1(_2f2,pp,_2f3){
var opts=$.data(_2f2,"accordion").options;
pp.panel($.extend({},{collapsible:true,minimizable:false,maximizable:false,closable:false,doSize:false,collapsed:true,headerCls:"accordion-header",bodyCls:"accordion-body",halign:opts.halign},_2f3,{onBeforeExpand:function(){
if(_2f3.onBeforeExpand){
if(_2f3.onBeforeExpand.call(this)==false){
return false;
}
}
if(!opts.multiple){
var all=$.grep(_2e1(_2f2),function(p){
return p.panel("options").collapsible;
});
for(var i=0;i<all.length;i++){
_2fb(_2f2,_2e5(_2f2,all[i]));
}
}
var _2f4=$(this).panel("header");
_2f4.addClass("accordion-header-selected");
_2f4.find(".accordion-collapse").removeClass("accordion-expand");
},onExpand:function(){
$(_2f2).find(">.panel-last>.accordion-header").removeClass("accordion-header-border");
if(_2f3.onExpand){
_2f3.onExpand.call(this);
}
opts.onSelect.call(_2f2,$(this).panel("options").title,_2e5(_2f2,this));
},onBeforeCollapse:function(){
if(_2f3.onBeforeCollapse){
if(_2f3.onBeforeCollapse.call(this)==false){
return false;
}
}
$(_2f2).find(">.panel-last>.accordion-header").addClass("accordion-header-border");
var _2f5=$(this).panel("header");
_2f5.removeClass("accordion-header-selected");
_2f5.find(".accordion-collapse").addClass("accordion-expand");
},onCollapse:function(){
if(isNaN(parseInt(opts.height))){
$(_2f2).find(">.panel-last>.accordion-header").removeClass("accordion-header-border");
}
if(_2f3.onCollapse){
_2f3.onCollapse.call(this);
}
opts.onUnselect.call(_2f2,$(this).panel("options").title,_2e5(_2f2,this));
}}));
var _2f6=pp.panel("header");
var tool=_2f6.children("div.panel-tool");
tool.children("a.panel-tool-collapse").hide();
var t=$("<a href=\"javascript:;\"></a>").addClass("accordion-collapse accordion-expand").appendTo(tool);
t.bind("click",function(){
_2f7(pp);
return false;
});
pp.panel("options").collapsible?t.show():t.hide();
if(opts.halign=="left"||opts.halign=="right"){
t.hide();
}
_2f6.click(function(){
_2f7(pp);
return false;
});
function _2f7(p){
var _2f8=p.panel("options");
if(_2f8.collapsible){
var _2f9=_2e5(_2f2,p);
if(_2f8.collapsed){
_2fa(_2f2,_2f9);
}else{
_2fb(_2f2,_2f9);
}
}
};
};
function _2fa(_2fc,_2fd){
var p=_2e8(_2fc,_2fd);
if(!p){
return;
}
_2fe(_2fc);
var opts=$.data(_2fc,"accordion").options;
p.panel("expand",opts.animate);
};
function _2fb(_2ff,_300){
var p=_2e8(_2ff,_300);
if(!p){
return;
}
_2fe(_2ff);
var opts=$.data(_2ff,"accordion").options;
p.panel("collapse",opts.animate);
};
function _301(_302){
var opts=$.data(_302,"accordion").options;
$(_302).find(">.panel-last>.accordion-header").addClass("accordion-header-border");
var p=_2dc(_302,"selected",true);
if(p){
_303(_2e5(_302,p));
}else{
_303(opts.selected);
}
function _303(_304){
var _305=opts.animate;
opts.animate=false;
_2fa(_302,_304);
opts.animate=_305;
};
};
function _2fe(_306){
var _307=$.data(_306,"accordion").panels;
for(var i=0;i<_307.length;i++){
_307[i].stop(true,true);
}
};
function add(_308,_309){
var _30a=$.data(_308,"accordion");
var opts=_30a.options;
var _30b=_30a.panels;
if(_309.selected==undefined){
_309.selected=true;
}
_2fe(_308);
var pp=$("<div></div>").appendTo(_308);
_30b.push(pp);
_2f1(_308,pp,_309);
_2ce(_308);
opts.onAdd.call(_308,_309.title,_30b.length-1);
if(_309.selected){
_2fa(_308,_30b.length-1);
}
};
function _30c(_30d,_30e){
var _30f=$.data(_30d,"accordion");
var opts=_30f.options;
var _310=_30f.panels;
_2fe(_30d);
var _311=_2e8(_30d,_30e);
var _312=_311.panel("options").title;
var _313=_2e5(_30d,_311);
if(!_311){
return;
}
if(opts.onBeforeRemove.call(_30d,_312,_313)==false){
return;
}
_310.splice(_313,1);
_311.panel("destroy");
if(_310.length){
_2ce(_30d);
var curr=_2e3(_30d);
if(!curr){
_2fa(_30d,0);
}
}
opts.onRemove.call(_30d,_312,_313);
};
$.fn.accordion=function(_314,_315){
if(typeof _314=="string"){
return $.fn.accordion.methods[_314](this,_315);
}
_314=_314||{};
return this.each(function(){
var _316=$.data(this,"accordion");
if(_316){
$.extend(_316.options,_314);
}else{
$.data(this,"accordion",{options:$.extend({},$.fn.accordion.defaults,$.fn.accordion.parseOptions(this),_314),accordion:$(this).addClass("accordion"),panels:[]});
init(this);
}
_2ec(this);
_2ce(this);
_301(this);
});
};
$.fn.accordion.methods={options:function(jq){
return $.data(jq[0],"accordion").options;
},panels:function(jq){
return $.data(jq[0],"accordion").panels;
},resize:function(jq,_317){
return jq.each(function(){
_2ce(this,_317);
});
},getSelections:function(jq){
return _2e1(jq[0]);
},getSelected:function(jq){
return _2e3(jq[0]);
},getPanel:function(jq,_318){
return _2e8(jq[0],_318);
},getPanelIndex:function(jq,_319){
return _2e5(jq[0],_319);
},select:function(jq,_31a){
return jq.each(function(){
_2fa(this,_31a);
});
},unselect:function(jq,_31b){
return jq.each(function(){
_2fb(this,_31b);
});
},add:function(jq,_31c){
return jq.each(function(){
add(this,_31c);
});
},remove:function(jq,_31d){
return jq.each(function(){
_30c(this,_31d);
});
}};
$.fn.accordion.parseOptions=function(_31e){
var t=$(_31e);
return $.extend({},$.parser.parseOptions(_31e,["width","height","halign",{fit:"boolean",border:"boolean",animate:"boolean",multiple:"boolean",selected:"number"}]));
};
$.fn.accordion.defaults={width:"auto",height:"auto",fit:false,border:true,animate:true,multiple:false,selected:0,halign:"top",onSelect:function(_31f,_320){
},onUnselect:function(_321,_322){
},onAdd:function(_323,_324){
},onBeforeRemove:function(_325,_326){
},onRemove:function(_327,_328){
}};
})(jQuery);
(function($){
function _329(c){
var w=0;
$(c).children().each(function(){
w+=$(this).outerWidth(true);
});
return w;
};
function _32a(_32b){
var opts=$.data(_32b,"tabs").options;
if(opts.tabPosition=="left"||opts.tabPosition=="right"||!opts.showHeader){
return;
}
var _32c=$(_32b).children("div.tabs-header");
var tool=_32c.children("div.tabs-tool:not(.tabs-tool-hidden)");
var _32d=_32c.children("div.tabs-scroller-left");
var _32e=_32c.children("div.tabs-scroller-right");
var wrap=_32c.children("div.tabs-wrap");
var _32f=_32c.outerHeight();
if(opts.plain){
_32f-=_32f-_32c.height();
}
tool._outerHeight(_32f);
var _330=_329(_32c.find("ul.tabs"));
var _331=_32c.width()-tool._outerWidth();
if(_330>_331){
_32d.add(_32e).show()._outerHeight(_32f);
if(opts.toolPosition=="left"){
tool.css({left:_32d.outerWidth(),right:""});
wrap.css({marginLeft:_32d.outerWidth()+tool._outerWidth(),marginRight:_32e._outerWidth(),width:_331-_32d.outerWidth()-_32e.outerWidth()});
}else{
tool.css({left:"",right:_32e.outerWidth()});
wrap.css({marginLeft:_32d.outerWidth(),marginRight:_32e.outerWidth()+tool._outerWidth(),width:_331-_32d.outerWidth()-_32e.outerWidth()});
}
}else{
_32d.add(_32e).hide();
if(opts.toolPosition=="left"){
tool.css({left:0,right:""});
wrap.css({marginLeft:tool._outerWidth(),marginRight:0,width:_331});
}else{
tool.css({left:"",right:0});
wrap.css({marginLeft:0,marginRight:tool._outerWidth(),width:_331});
}
}
};
function _332(_333){
var opts=$.data(_333,"tabs").options;
var _334=$(_333).children("div.tabs-header");
if(opts.tools){
if(typeof opts.tools=="string"){
$(opts.tools).addClass("tabs-tool").appendTo(_334);
$(opts.tools).show();
}else{
_334.children("div.tabs-tool").remove();
var _335=$("<div class=\"tabs-tool\"><table cellspacing=\"0\" cellpadding=\"0\" style=\"height:100%\"><tr></tr></table></div>").appendTo(_334);
var tr=_335.find("tr");
for(var i=0;i<opts.tools.length;i++){
var td=$("<td></td>").appendTo(tr);
var tool=$("<a href=\"javascript:;\"></a>").appendTo(td);
tool[0].onclick=eval(opts.tools[i].handler||function(){
});
tool.linkbutton($.extend({},opts.tools[i],{plain:true}));
}
}
}else{
_334.children("div.tabs-tool").remove();
}
};
function _336(_337,_338){
var _339=$.data(_337,"tabs");
var opts=_339.options;
var cc=$(_337);
if(!opts.doSize){
return;
}
if(_338){
$.extend(opts,{width:_338.width,height:_338.height});
}
cc._size(opts);
var _33a=cc.children("div.tabs-header");
var _33b=cc.children("div.tabs-panels");
var wrap=_33a.find("div.tabs-wrap");
var ul=wrap.find(".tabs");
ul.children("li").removeClass("tabs-first tabs-last");
ul.children("li:first").addClass("tabs-first");
ul.children("li:last").addClass("tabs-last");
if(opts.tabPosition=="left"||opts.tabPosition=="right"){
_33a._outerWidth(opts.showHeader?opts.headerWidth:0);
_33b._outerWidth(cc.width()-_33a.outerWidth());
_33a.add(_33b)._size("height",isNaN(parseInt(opts.height))?"":cc.height());
wrap._outerWidth(_33a.width());
ul._outerWidth(wrap.width()).css("height","");
}else{
_33a.children("div.tabs-scroller-left,div.tabs-scroller-right,div.tabs-tool:not(.tabs-tool-hidden)").css("display",opts.showHeader?"block":"none");
_33a._outerWidth(cc.width()).css("height","");
if(opts.showHeader){
_33a.css("background-color","");
wrap.css("height","");
}else{
_33a.css("background-color","transparent");
_33a._outerHeight(0);
wrap._outerHeight(0);
}
ul._outerHeight(opts.tabHeight).css("width","");
ul._outerHeight(ul.outerHeight()-ul.height()-1+opts.tabHeight).css("width","");
_33b._size("height",isNaN(parseInt(opts.height))?"":(cc.height()-_33a.outerHeight()));
_33b._size("width",cc.width());
}
if(_339.tabs.length){
var d1=ul.outerWidth(true)-ul.width();
var li=ul.children("li:first");
var d2=li.outerWidth(true)-li.width();
var _33c=_33a.width()-_33a.children(".tabs-tool:not(.tabs-tool-hidden)")._outerWidth();
var _33d=Math.floor((_33c-d1-d2*_339.tabs.length)/_339.tabs.length);
$.map(_339.tabs,function(p){
_33e(p,(opts.justified&&$.inArray(opts.tabPosition,["top","bottom"])>=0)?_33d:undefined);
});
if(opts.justified&&$.inArray(opts.tabPosition,["top","bottom"])>=0){
var _33f=_33c-d1-_329(ul);
_33e(_339.tabs[_339.tabs.length-1],_33d+_33f);
}
}
_32a(_337);
function _33e(p,_340){
var _341=p.panel("options");
var p_t=_341.tab.find("a.tabs-inner");
var _340=_340?_340:(parseInt(_341.tabWidth||opts.tabWidth||undefined));
if(_340){
p_t._outerWidth(_340);
}else{
p_t.css("width","");
}
p_t._outerHeight(opts.tabHeight);
p_t.css("lineHeight",p_t.height()+"px");
p_t.find(".easyui-fluid:visible").triggerHandler("_resize");
};
};
function _342(_343){
var opts=$.data(_343,"tabs").options;
var tab=_344(_343);
if(tab){
var _345=$(_343).children("div.tabs-panels");
var _346=opts.width=="auto"?"auto":_345.width();
var _347=opts.height=="auto"?"auto":_345.height();
tab.panel("resize",{width:_346,height:_347});
}
};
function _348(_349){
var tabs=$.data(_349,"tabs").tabs;
var cc=$(_349).addClass("tabs-container");
var _34a=$("<div class=\"tabs-panels\"></div>").insertBefore(cc);
cc.children("div").each(function(){
_34a[0].appendChild(this);
});
cc[0].appendChild(_34a[0]);
$("<div class=\"tabs-header\">"+"<div class=\"tabs-scroller-left\"></div>"+"<div class=\"tabs-scroller-right\"></div>"+"<div class=\"tabs-wrap\">"+"<ul class=\"tabs\"></ul>"+"</div>"+"</div>").prependTo(_349);
cc.children("div.tabs-panels").children("div").each(function(i){
var opts=$.extend({},$.parser.parseOptions(this),{disabled:($(this).attr("disabled")?true:undefined),selected:($(this).attr("selected")?true:undefined)});
_357(_349,opts,$(this));
});
cc.children("div.tabs-header").find(".tabs-scroller-left, .tabs-scroller-right").hover(function(){
$(this).addClass("tabs-scroller-over");
},function(){
$(this).removeClass("tabs-scroller-over");
});
cc.bind("_resize",function(e,_34b){
if($(this).hasClass("easyui-fluid")||_34b){
_336(_349);
_342(_349);
}
return false;
});
};
function _34c(_34d){
var _34e=$.data(_34d,"tabs");
var opts=_34e.options;
$(_34d).children("div.tabs-header").unbind().bind("click",function(e){
if($(e.target).hasClass("tabs-scroller-left")){
$(_34d).tabs("scrollBy",-opts.scrollIncrement);
}else{
if($(e.target).hasClass("tabs-scroller-right")){
$(_34d).tabs("scrollBy",opts.scrollIncrement);
}else{
var li=$(e.target).closest("li");
if(li.hasClass("tabs-disabled")){
return false;
}
var a=$(e.target).closest("a.tabs-close");
if(a.length){
_370(_34d,_34f(li));
}else{
if(li.length){
var _350=_34f(li);
var _351=_34e.tabs[_350].panel("options");
if(_351.collapsible){
_351.closed?_367(_34d,_350):_384(_34d,_350);
}else{
_367(_34d,_350);
}
}
}
return false;
}
}
}).bind("contextmenu",function(e){
var li=$(e.target).closest("li");
if(li.hasClass("tabs-disabled")){
return;
}
if(li.length){
opts.onContextMenu.call(_34d,e,li.find("span.tabs-title").html(),_34f(li));
}
});
function _34f(li){
var _352=0;
li.parent().children("li").each(function(i){
if(li[0]==this){
_352=i;
return false;
}
});
return _352;
};
};
function _353(_354){
var opts=$.data(_354,"tabs").options;
var _355=$(_354).children("div.tabs-header");
var _356=$(_354).children("div.tabs-panels");
_355.removeClass("tabs-header-top tabs-header-bottom tabs-header-left tabs-header-right");
_356.removeClass("tabs-panels-top tabs-panels-bottom tabs-panels-left tabs-panels-right");
if(opts.tabPosition=="top"){
_355.insertBefore(_356);
}else{
if(opts.tabPosition=="bottom"){
_355.insertAfter(_356);
_355.addClass("tabs-header-bottom");
_356.addClass("tabs-panels-top");
}else{
if(opts.tabPosition=="left"){
_355.addClass("tabs-header-left");
_356.addClass("tabs-panels-right");
}else{
if(opts.tabPosition=="right"){
_355.addClass("tabs-header-right");
_356.addClass("tabs-panels-left");
}
}
}
}
if(opts.plain==true){
_355.addClass("tabs-header-plain");
}else{
_355.removeClass("tabs-header-plain");
}
_355.removeClass("tabs-header-narrow").addClass(opts.narrow?"tabs-header-narrow":"");
var tabs=_355.find(".tabs");
tabs.removeClass("tabs-pill").addClass(opts.pill?"tabs-pill":"");
tabs.removeClass("tabs-narrow").addClass(opts.narrow?"tabs-narrow":"");
tabs.removeClass("tabs-justified").addClass(opts.justified?"tabs-justified":"");
if(opts.border==true){
_355.removeClass("tabs-header-noborder");
_356.removeClass("tabs-panels-noborder");
}else{
_355.addClass("tabs-header-noborder");
_356.addClass("tabs-panels-noborder");
}
opts.doSize=true;
};
function _357(_358,_359,pp){
_359=_359||{};
var _35a=$.data(_358,"tabs");
var tabs=_35a.tabs;
if(_359.index==undefined||_359.index>tabs.length){
_359.index=tabs.length;
}
if(_359.index<0){
_359.index=0;
}
var ul=$(_358).children("div.tabs-header").find("ul.tabs");
var _35b=$(_358).children("div.tabs-panels");
var tab=$("<li>"+"<a href=\"javascript:;\" class=\"tabs-inner\">"+"<span class=\"tabs-title\"></span>"+"<span class=\"tabs-icon\"></span>"+"</a>"+"</li>");
if(!pp){
pp=$("<div></div>");
}
if(_359.index>=tabs.length){
tab.appendTo(ul);
pp.appendTo(_35b);
tabs.push(pp);
}else{
tab.insertBefore(ul.children("li:eq("+_359.index+")"));
pp.insertBefore(_35b.children("div.panel:eq("+_359.index+")"));
tabs.splice(_359.index,0,pp);
}
pp.panel($.extend({},_359,{tab:tab,border:false,noheader:true,closed:true,doSize:false,iconCls:(_359.icon?_359.icon:undefined),onLoad:function(){
if(_359.onLoad){
_359.onLoad.call(this,arguments);
}
_35a.options.onLoad.call(_358,$(this));
},onBeforeOpen:function(){
if(_359.onBeforeOpen){
if(_359.onBeforeOpen.call(this)==false){
return false;
}
}
var p=$(_358).tabs("getSelected");
if(p){
if(p[0]!=this){
$(_358).tabs("unselect",_362(_358,p));
p=$(_358).tabs("getSelected");
if(p){
return false;
}
}else{
_342(_358);
return false;
}
}
var _35c=$(this).panel("options");
_35c.tab.addClass("tabs-selected");
var wrap=$(_358).find(">div.tabs-header>div.tabs-wrap");
var left=_35c.tab.position().left;
var _35d=left+_35c.tab.outerWidth();
if(left<0||_35d>wrap.width()){
var _35e=left-(wrap.width()-_35c.tab.width())/2;
$(_358).tabs("scrollBy",_35e);
}else{
$(_358).tabs("scrollBy",0);
}
var _35f=$(this).panel("panel");
_35f.css("display","block");
_342(_358);
_35f.css("display","none");
},onOpen:function(){
if(_359.onOpen){
_359.onOpen.call(this);
}
var _360=$(this).panel("options");
_35a.selectHis.push(_360.title);
_35a.options.onSelect.call(_358,_360.title,_362(_358,this));
},onBeforeClose:function(){
if(_359.onBeforeClose){
if(_359.onBeforeClose.call(this)==false){
return false;
}
}
$(this).panel("options").tab.removeClass("tabs-selected");
},onClose:function(){
if(_359.onClose){
_359.onClose.call(this);
}
var _361=$(this).panel("options");
_35a.options.onUnselect.call(_358,_361.title,_362(_358,this));
}}));
$(_358).tabs("update",{tab:pp,options:pp.panel("options"),type:"header"});
};
function _363(_364,_365){
var _366=$.data(_364,"tabs");
var opts=_366.options;
if(_365.selected==undefined){
_365.selected=true;
}
_357(_364,_365);
opts.onAdd.call(_364,_365.title,_365.index);
if(_365.selected){
_367(_364,_365.index);
}
};
function _368(_369,_36a){
_36a.type=_36a.type||"all";
var _36b=$.data(_369,"tabs").selectHis;
var pp=_36a.tab;
var opts=pp.panel("options");
var _36c=opts.title;
$.extend(opts,_36a.options,{iconCls:(_36a.options.icon?_36a.options.icon:undefined)});
if(_36a.type=="all"||_36a.type=="body"){
pp.panel();
}
if(_36a.type=="all"||_36a.type=="header"){
var tab=opts.tab;
if(opts.header){
tab.find(".tabs-inner").html($(opts.header));
}else{
var _36d=tab.find("span.tabs-title");
var _36e=tab.find("span.tabs-icon");
_36d.html(opts.title);
_36e.attr("class","tabs-icon");
tab.find("a.tabs-close").remove();
if(opts.closable){
_36d.addClass("tabs-closable");
$("<a href=\"javascript:;\" class=\"tabs-close\"></a>").appendTo(tab);
}else{
_36d.removeClass("tabs-closable");
}
if(opts.iconCls){
_36d.addClass("tabs-with-icon");
_36e.addClass(opts.iconCls);
}else{
_36d.removeClass("tabs-with-icon");
}
if(opts.tools){
var _36f=tab.find("span.tabs-p-tool");
if(!_36f.length){
var _36f=$("<span class=\"tabs-p-tool\"></span>").insertAfter(tab.find("a.tabs-inner"));
}
if($.isArray(opts.tools)){
_36f.empty();
for(var i=0;i<opts.tools.length;i++){
var t=$("<a href=\"javascript:;\"></a>").appendTo(_36f);
t.addClass(opts.tools[i].iconCls);
if(opts.tools[i].handler){
t.bind("click",{handler:opts.tools[i].handler},function(e){
if($(this).parents("li").hasClass("tabs-disabled")){
return;
}
e.data.handler.call(this);
});
}
}
}else{
$(opts.tools).children().appendTo(_36f);
}
var pr=_36f.children().length*12;
if(opts.closable){
pr+=8;
_36f.css("right","");
}else{
pr-=3;
_36f.css("right","5px");
}
_36d.css("padding-right",pr+"px");
}else{
tab.find("span.tabs-p-tool").remove();
_36d.css("padding-right","");
}
}
if(_36c!=opts.title){
for(var i=0;i<_36b.length;i++){
if(_36b[i]==_36c){
_36b[i]=opts.title;
}
}
}
}
if(opts.disabled){
opts.tab.addClass("tabs-disabled");
}else{
opts.tab.removeClass("tabs-disabled");
}
_336(_369);
$.data(_369,"tabs").options.onUpdate.call(_369,opts.title,_362(_369,pp));
};
function _370(_371,_372){
var opts=$.data(_371,"tabs").options;
var tabs=$.data(_371,"tabs").tabs;
var _373=$.data(_371,"tabs").selectHis;
if(!_374(_371,_372)){
return;
}
var tab=_375(_371,_372);
var _376=tab.panel("options").title;
var _377=_362(_371,tab);
if(opts.onBeforeClose.call(_371,_376,_377)==false){
return;
}
var tab=_375(_371,_372,true);
tab.panel("options").tab.remove();
tab.panel("destroy");
opts.onClose.call(_371,_376,_377);
_336(_371);
for(var i=0;i<_373.length;i++){
if(_373[i]==_376){
_373.splice(i,1);
i--;
}
}
var _378=_373.pop();
if(_378){
_367(_371,_378);
}else{
if(tabs.length){
_367(_371,0);
}
}
};
function _375(_379,_37a,_37b){
var tabs=$.data(_379,"tabs").tabs;
var tab=null;
if(typeof _37a=="number"){
if(_37a>=0&&_37a<tabs.length){
tab=tabs[_37a];
if(_37b){
tabs.splice(_37a,1);
}
}
}else{
var tmp=$("<span></span>");
for(var i=0;i<tabs.length;i++){
var p=tabs[i];
tmp.html(p.panel("options").title);
if(tmp.text()==_37a){
tab=p;
if(_37b){
tabs.splice(i,1);
}
break;
}
}
tmp.remove();
}
return tab;
};
function _362(_37c,tab){
var tabs=$.data(_37c,"tabs").tabs;
for(var i=0;i<tabs.length;i++){
if(tabs[i][0]==$(tab)[0]){
return i;
}
}
return -1;
};
function _344(_37d){
var tabs=$.data(_37d,"tabs").tabs;
for(var i=0;i<tabs.length;i++){
var tab=tabs[i];
if(tab.panel("options").tab.hasClass("tabs-selected")){
return tab;
}
}
return null;
};
function _37e(_37f){
var _380=$.data(_37f,"tabs");
var tabs=_380.tabs;
for(var i=0;i<tabs.length;i++){
var opts=tabs[i].panel("options");
if(opts.selected&&!opts.disabled){
_367(_37f,i);
return;
}
}
_367(_37f,_380.options.selected);
};
function _367(_381,_382){
var p=_375(_381,_382);
if(p&&!p.is(":visible")){
_383(_381);
if(!p.panel("options").disabled){
p.panel("open");
}
}
};
function _384(_385,_386){
var p=_375(_385,_386);
if(p&&p.is(":visible")){
_383(_385);
p.panel("close");
}
};
function _383(_387){
$(_387).children("div.tabs-panels").each(function(){
$(this).stop(true,true);
});
};
function _374(_388,_389){
return _375(_388,_389)!=null;
};
function _38a(_38b,_38c){
var opts=$.data(_38b,"tabs").options;
opts.showHeader=_38c;
$(_38b).tabs("resize");
};
function _38d(_38e,_38f){
var tool=$(_38e).find(">.tabs-header>.tabs-tool");
if(_38f){
tool.removeClass("tabs-tool-hidden").show();
}else{
tool.addClass("tabs-tool-hidden").hide();
}
$(_38e).tabs("resize").tabs("scrollBy",0);
};
$.fn.tabs=function(_390,_391){
if(typeof _390=="string"){
return $.fn.tabs.methods[_390](this,_391);
}
_390=_390||{};
return this.each(function(){
var _392=$.data(this,"tabs");
if(_392){
$.extend(_392.options,_390);
}else{
$.data(this,"tabs",{options:$.extend({},$.fn.tabs.defaults,$.fn.tabs.parseOptions(this),_390),tabs:[],selectHis:[]});
_348(this);
}
_332(this);
_353(this);
_336(this);
_34c(this);
_37e(this);
});
};
$.fn.tabs.methods={options:function(jq){
var cc=jq[0];
var opts=$.data(cc,"tabs").options;
var s=_344(cc);
opts.selected=s?_362(cc,s):-1;
return opts;
},tabs:function(jq){
return $.data(jq[0],"tabs").tabs;
},resize:function(jq,_393){
return jq.each(function(){
_336(this,_393);
_342(this);
});
},add:function(jq,_394){
return jq.each(function(){
_363(this,_394);
});
},close:function(jq,_395){
return jq.each(function(){
_370(this,_395);
});
},getTab:function(jq,_396){
return _375(jq[0],_396);
},getTabIndex:function(jq,tab){
return _362(jq[0],tab);
},getSelected:function(jq){
return _344(jq[0]);
},select:function(jq,_397){
return jq.each(function(){
_367(this,_397);
});
},unselect:function(jq,_398){
return jq.each(function(){
_384(this,_398);
});
},exists:function(jq,_399){
return _374(jq[0],_399);
},update:function(jq,_39a){
return jq.each(function(){
_368(this,_39a);
});
},enableTab:function(jq,_39b){
return jq.each(function(){
var opts=$(this).tabs("getTab",_39b).panel("options");
opts.tab.removeClass("tabs-disabled");
opts.disabled=false;
});
},disableTab:function(jq,_39c){
return jq.each(function(){
var opts=$(this).tabs("getTab",_39c).panel("options");
opts.tab.addClass("tabs-disabled");
opts.disabled=true;
});
},showHeader:function(jq){
return jq.each(function(){
_38a(this,true);
});
},hideHeader:function(jq){
return jq.each(function(){
_38a(this,false);
});
},showTool:function(jq){
return jq.each(function(){
_38d(this,true);
});
},hideTool:function(jq){
return jq.each(function(){
_38d(this,false);
});
},scrollBy:function(jq,_39d){
return jq.each(function(){
var opts=$(this).tabs("options");
var wrap=$(this).find(">div.tabs-header>div.tabs-wrap");
var pos=Math.min(wrap._scrollLeft()+_39d,_39e());
wrap.animate({scrollLeft:pos},opts.scrollDuration);
function _39e(){
var w=0;
var ul=wrap.children("ul");
ul.children("li").each(function(){
w+=$(this).outerWidth(true);
});
return w-wrap.width()+(ul.outerWidth()-ul.width());
};
});
}};
$.fn.tabs.parseOptions=function(_39f){
return $.extend({},$.parser.parseOptions(_39f,["tools","toolPosition","tabPosition",{fit:"boolean",border:"boolean",plain:"boolean"},{headerWidth:"number",tabWidth:"number",tabHeight:"number",selected:"number"},{showHeader:"boolean",justified:"boolean",narrow:"boolean",pill:"boolean"}]));
};
$.fn.tabs.defaults={width:"auto",height:"auto",headerWidth:150,tabWidth:"auto",tabHeight:27,selected:0,showHeader:true,plain:false,fit:false,border:true,justified:false,narrow:false,pill:false,tools:null,toolPosition:"right",tabPosition:"top",scrollIncrement:100,scrollDuration:400,onLoad:function(_3a0){
},onSelect:function(_3a1,_3a2){
},onUnselect:function(_3a3,_3a4){
},onBeforeClose:function(_3a5,_3a6){
},onClose:function(_3a7,_3a8){
},onAdd:function(_3a9,_3aa){
},onUpdate:function(_3ab,_3ac){
},onContextMenu:function(e,_3ad,_3ae){
}};
})(jQuery);
(function($){
var _3af=false;
function _3b0(_3b1,_3b2){
var _3b3=$.data(_3b1,"layout");
var opts=_3b3.options;
var _3b4=_3b3.panels;
var cc=$(_3b1);
if(_3b2){
$.extend(opts,{width:_3b2.width,height:_3b2.height});
}
if(_3b1.tagName.toLowerCase()=="body"){
cc._size("fit");
}else{
cc._size(opts);
}
var cpos={top:0,left:0,width:cc.width(),height:cc.height()};
_3b5(_3b6(_3b4.expandNorth)?_3b4.expandNorth:_3b4.north,"n");
_3b5(_3b6(_3b4.expandSouth)?_3b4.expandSouth:_3b4.south,"s");
_3b7(_3b6(_3b4.expandEast)?_3b4.expandEast:_3b4.east,"e");
_3b7(_3b6(_3b4.expandWest)?_3b4.expandWest:_3b4.west,"w");
_3b4.center.panel("resize",cpos);
function _3b5(pp,type){
if(!pp.length||!_3b6(pp)){
return;
}
var opts=pp.panel("options");
pp.panel("resize",{width:cc.width(),height:opts.height});
var _3b8=pp.panel("panel").outerHeight();
pp.panel("move",{left:0,top:(type=="n"?0:cc.height()-_3b8)});
cpos.height-=_3b8;
if(type=="n"){
cpos.top+=_3b8;
if(!opts.split&&opts.border){
cpos.top--;
}
}
if(!opts.split&&opts.border){
cpos.height++;
}
};
function _3b7(pp,type){
if(!pp.length||!_3b6(pp)){
return;
}
var opts=pp.panel("options");
pp.panel("resize",{width:opts.width,height:cpos.height});
var _3b9=pp.panel("panel").outerWidth();
pp.panel("move",{left:(type=="e"?cc.width()-_3b9:0),top:cpos.top});
cpos.width-=_3b9;
if(type=="w"){
cpos.left+=_3b9;
if(!opts.split&&opts.border){
cpos.left--;
}
}
if(!opts.split&&opts.border){
cpos.width++;
}
};
};
function init(_3ba){
var cc=$(_3ba);
cc.addClass("layout");
function _3bb(el){
var _3bc=$.fn.layout.parsePanelOptions(el);
if("north,south,east,west,center".indexOf(_3bc.region)>=0){
_3bf(_3ba,_3bc,el);
}
};
var opts=cc.layout("options");
var _3bd=opts.onAdd;
opts.onAdd=function(){
};
cc.find(">div,>form>div").each(function(){
_3bb(this);
});
opts.onAdd=_3bd;
cc.append("<div class=\"layout-split-proxy-h\"></div><div class=\"layout-split-proxy-v\"></div>");
cc.bind("_resize",function(e,_3be){
if($(this).hasClass("easyui-fluid")||_3be){
_3b0(_3ba);
}
return false;
});
};
function _3bf(_3c0,_3c1,el){
_3c1.region=_3c1.region||"center";
var _3c2=$.data(_3c0,"layout").panels;
var cc=$(_3c0);
var dir=_3c1.region;
if(_3c2[dir].length){
return;
}
var pp=$(el);
if(!pp.length){
pp=$("<div></div>").appendTo(cc);
}
var _3c3=$.extend({},$.fn.layout.paneldefaults,{width:(pp.length?parseInt(pp[0].style.width)||pp.outerWidth():"auto"),height:(pp.length?parseInt(pp[0].style.height)||pp.outerHeight():"auto"),doSize:false,collapsible:true,onOpen:function(){
var tool=$(this).panel("header").children("div.panel-tool");
tool.children("a.panel-tool-collapse").hide();
var _3c4={north:"up",south:"down",east:"right",west:"left"};
if(!_3c4[dir]){
return;
}
var _3c5="layout-button-"+_3c4[dir];
var t=tool.children("a."+_3c5);
if(!t.length){
t=$("<a href=\"javascript:;\"></a>").addClass(_3c5).appendTo(tool);
t.bind("click",{dir:dir},function(e){
_3dc(_3c0,e.data.dir);
return false;
});
}
$(this).panel("options").collapsible?t.show():t.hide();
}},_3c1,{cls:((_3c1.cls||"")+" layout-panel layout-panel-"+dir),bodyCls:((_3c1.bodyCls||"")+" layout-body")});
pp.panel(_3c3);
_3c2[dir]=pp;
var _3c6={north:"s",south:"n",east:"w",west:"e"};
var _3c7=pp.panel("panel");
if(pp.panel("options").split){
_3c7.addClass("layout-split-"+dir);
}
_3c7.resizable($.extend({},{handles:(_3c6[dir]||""),disabled:(!pp.panel("options").split),onStartResize:function(e){
_3af=true;
if(dir=="north"||dir=="south"){
var _3c8=$(">div.layout-split-proxy-v",_3c0);
}else{
var _3c8=$(">div.layout-split-proxy-h",_3c0);
}
var top=0,left=0,_3c9=0,_3ca=0;
var pos={display:"block"};
if(dir=="north"){
pos.top=parseInt(_3c7.css("top"))+_3c7.outerHeight()-_3c8.height();
pos.left=parseInt(_3c7.css("left"));
pos.width=_3c7.outerWidth();
pos.height=_3c8.height();
}else{
if(dir=="south"){
pos.top=parseInt(_3c7.css("top"));
pos.left=parseInt(_3c7.css("left"));
pos.width=_3c7.outerWidth();
pos.height=_3c8.height();
}else{
if(dir=="east"){
pos.top=parseInt(_3c7.css("top"))||0;
pos.left=parseInt(_3c7.css("left"))||0;
pos.width=_3c8.width();
pos.height=_3c7.outerHeight();
}else{
if(dir=="west"){
pos.top=parseInt(_3c7.css("top"))||0;
pos.left=_3c7.outerWidth()-_3c8.width();
pos.width=_3c8.width();
pos.height=_3c7.outerHeight();
}
}
}
}
_3c8.css(pos);
$("<div class=\"layout-mask\"></div>").css({left:0,top:0,width:cc.width(),height:cc.height()}).appendTo(cc);
},onResize:function(e){
if(dir=="north"||dir=="south"){
var _3cb=_3cc(this);
$(this).resizable("options").maxHeight=_3cb;
var _3cd=$(">div.layout-split-proxy-v",_3c0);
var top=dir=="north"?e.data.height-_3cd.height():$(_3c0).height()-e.data.height;
_3cd.css("top",top);
}else{
var _3ce=_3cc(this);
$(this).resizable("options").maxWidth=_3ce;
var _3cd=$(">div.layout-split-proxy-h",_3c0);
var left=dir=="west"?e.data.width-_3cd.width():$(_3c0).width()-e.data.width;
_3cd.css("left",left);
}
return false;
},onStopResize:function(e){
cc.children("div.layout-split-proxy-v,div.layout-split-proxy-h").hide();
pp.panel("resize",e.data);
_3b0(_3c0);
_3af=false;
cc.find(">div.layout-mask").remove();
}},_3c1));
cc.layout("options").onAdd.call(_3c0,dir);
function _3cc(p){
var _3cf="expand"+dir.substring(0,1).toUpperCase()+dir.substring(1);
var _3d0=_3c2["center"];
var _3d1=(dir=="north"||dir=="south")?"minHeight":"minWidth";
var _3d2=(dir=="north"||dir=="south")?"maxHeight":"maxWidth";
var _3d3=(dir=="north"||dir=="south")?"_outerHeight":"_outerWidth";
var _3d4=$.parser.parseValue(_3d2,_3c2[dir].panel("options")[_3d2],$(_3c0));
var _3d5=$.parser.parseValue(_3d1,_3d0.panel("options")[_3d1],$(_3c0));
var _3d6=_3d0.panel("panel")[_3d3]()-_3d5;
if(_3b6(_3c2[_3cf])){
_3d6+=_3c2[_3cf][_3d3]()-1;
}else{
_3d6+=$(p)[_3d3]();
}
if(_3d6>_3d4){
_3d6=_3d4;
}
return _3d6;
};
};
function _3d7(_3d8,_3d9){
var _3da=$.data(_3d8,"layout").panels;
if(_3da[_3d9].length){
_3da[_3d9].panel("destroy");
_3da[_3d9]=$();
var _3db="expand"+_3d9.substring(0,1).toUpperCase()+_3d9.substring(1);
if(_3da[_3db]){
_3da[_3db].panel("destroy");
_3da[_3db]=undefined;
}
$(_3d8).layout("options").onRemove.call(_3d8,_3d9);
}
};
function _3dc(_3dd,_3de,_3df){
if(_3df==undefined){
_3df="normal";
}
var _3e0=$.data(_3dd,"layout").panels;
var p=_3e0[_3de];
var _3e1=p.panel("options");
if(_3e1.onBeforeCollapse.call(p)==false){
return;
}
var _3e2="expand"+_3de.substring(0,1).toUpperCase()+_3de.substring(1);
if(!_3e0[_3e2]){
_3e0[_3e2]=_3e3(_3de);
var ep=_3e0[_3e2].panel("panel");
if(!_3e1.expandMode){
ep.css("cursor","default");
}else{
ep.bind("click",function(){
if(_3e1.expandMode=="dock"){
_3ef(_3dd,_3de);
}else{
p.panel("expand",false).panel("open");
var _3e4=_3e5();
p.panel("resize",_3e4.collapse);
p.panel("panel").animate(_3e4.expand,function(){
$(this).unbind(".layout").bind("mouseleave.layout",{region:_3de},function(e){
if(_3af==true){
return;
}
if($("body>div.combo-p>div.combo-panel:visible").length){
return;
}
_3dc(_3dd,e.data.region);
});
$(_3dd).layout("options").onExpand.call(_3dd,_3de);
});
}
return false;
});
}
}
var _3e6=_3e5();
if(!_3b6(_3e0[_3e2])){
_3e0.center.panel("resize",_3e6.resizeC);
}
p.panel("panel").animate(_3e6.collapse,_3df,function(){
p.panel("collapse",false).panel("close");
_3e0[_3e2].panel("open").panel("resize",_3e6.expandP);
$(this).unbind(".layout");
$(_3dd).layout("options").onCollapse.call(_3dd,_3de);
});
function _3e3(dir){
var _3e7={"east":"left","west":"right","north":"down","south":"up"};
var isns=(_3e1.region=="north"||_3e1.region=="south");
var icon="layout-button-"+_3e7[dir];
var p=$("<div></div>").appendTo(_3dd);
p.panel($.extend({},$.fn.layout.paneldefaults,{cls:("layout-expand layout-expand-"+dir),title:"&nbsp;",titleDirection:_3e1.titleDirection,iconCls:(_3e1.hideCollapsedContent?null:_3e1.iconCls),closed:true,minWidth:0,minHeight:0,doSize:false,region:_3e1.region,collapsedSize:_3e1.collapsedSize,noheader:(!isns&&_3e1.hideExpandTool),tools:((isns&&_3e1.hideExpandTool)?null:[{iconCls:icon,handler:function(){
_3ef(_3dd,_3de);
return false;
}}]),onResize:function(){
var _3e8=$(this).children(".layout-expand-title");
if(_3e8.length){
_3e8._outerWidth($(this).height());
var left=($(this).width()-Math.min(_3e8._outerWidth(),_3e8._outerHeight()))/2;
var top=Math.max(_3e8._outerWidth(),_3e8._outerHeight());
if(_3e8.hasClass("layout-expand-title-down")){
left+=Math.min(_3e8._outerWidth(),_3e8._outerHeight());
top=0;
}
_3e8.css({left:(left+"px"),top:(top+"px")});
}
}}));
if(!_3e1.hideCollapsedContent){
var _3e9=typeof _3e1.collapsedContent=="function"?_3e1.collapsedContent.call(p[0],_3e1.title):_3e1.collapsedContent;
isns?p.panel("setTitle",_3e9):p.html(_3e9);
}
p.panel("panel").hover(function(){
$(this).addClass("layout-expand-over");
},function(){
$(this).removeClass("layout-expand-over");
});
return p;
};
function _3e5(){
var cc=$(_3dd);
var _3ea=_3e0.center.panel("options");
var _3eb=_3e1.collapsedSize;
if(_3de=="east"){
var _3ec=p.panel("panel")._outerWidth();
var _3ed=_3ea.width+_3ec-_3eb;
if(_3e1.split||!_3e1.border){
_3ed++;
}
return {resizeC:{width:_3ed},expand:{left:cc.width()-_3ec},expandP:{top:_3ea.top,left:cc.width()-_3eb,width:_3eb,height:_3ea.height},collapse:{left:cc.width(),top:_3ea.top,height:_3ea.height}};
}else{
if(_3de=="west"){
var _3ec=p.panel("panel")._outerWidth();
var _3ed=_3ea.width+_3ec-_3eb;
if(_3e1.split||!_3e1.border){
_3ed++;
}
return {resizeC:{width:_3ed,left:_3eb-1},expand:{left:0},expandP:{left:0,top:_3ea.top,width:_3eb,height:_3ea.height},collapse:{left:-_3ec,top:_3ea.top,height:_3ea.height}};
}else{
if(_3de=="north"){
var _3ee=p.panel("panel")._outerHeight();
var hh=_3ea.height;
if(!_3b6(_3e0.expandNorth)){
hh+=_3ee-_3eb+((_3e1.split||!_3e1.border)?1:0);
}
_3e0.east.add(_3e0.west).add(_3e0.expandEast).add(_3e0.expandWest).panel("resize",{top:_3eb-1,height:hh});
return {resizeC:{top:_3eb-1,height:hh},expand:{top:0},expandP:{top:0,left:0,width:cc.width(),height:_3eb},collapse:{top:-_3ee,width:cc.width()}};
}else{
if(_3de=="south"){
var _3ee=p.panel("panel")._outerHeight();
var hh=_3ea.height;
if(!_3b6(_3e0.expandSouth)){
hh+=_3ee-_3eb+((_3e1.split||!_3e1.border)?1:0);
}
_3e0.east.add(_3e0.west).add(_3e0.expandEast).add(_3e0.expandWest).panel("resize",{height:hh});
return {resizeC:{height:hh},expand:{top:cc.height()-_3ee},expandP:{top:cc.height()-_3eb,left:0,width:cc.width(),height:_3eb},collapse:{top:cc.height(),width:cc.width()}};
}
}
}
}
};
};
function _3ef(_3f0,_3f1){
var _3f2=$.data(_3f0,"layout").panels;
var p=_3f2[_3f1];
var _3f3=p.panel("options");
if(_3f3.onBeforeExpand.call(p)==false){
return;
}
var _3f4="expand"+_3f1.substring(0,1).toUpperCase()+_3f1.substring(1);
if(_3f2[_3f4]){
_3f2[_3f4].panel("close");
p.panel("panel").stop(true,true);
p.panel("expand",false).panel("open");
var _3f5=_3f6();
p.panel("resize",_3f5.collapse);
p.panel("panel").animate(_3f5.expand,function(){
_3b0(_3f0);
$(_3f0).layout("options").onExpand.call(_3f0,_3f1);
});
}
function _3f6(){
var cc=$(_3f0);
var _3f7=_3f2.center.panel("options");
if(_3f1=="east"&&_3f2.expandEast){
return {collapse:{left:cc.width(),top:_3f7.top,height:_3f7.height},expand:{left:cc.width()-p.panel("panel")._outerWidth()}};
}else{
if(_3f1=="west"&&_3f2.expandWest){
return {collapse:{left:-p.panel("panel")._outerWidth(),top:_3f7.top,height:_3f7.height},expand:{left:0}};
}else{
if(_3f1=="north"&&_3f2.expandNorth){
return {collapse:{top:-p.panel("panel")._outerHeight(),width:cc.width()},expand:{top:0}};
}else{
if(_3f1=="south"&&_3f2.expandSouth){
return {collapse:{top:cc.height(),width:cc.width()},expand:{top:cc.height()-p.panel("panel")._outerHeight()}};
}
}
}
}
};
};
function _3b6(pp){
if(!pp){
return false;
}
if(pp.length){
return pp.panel("panel").is(":visible");
}else{
return false;
}
};
function _3f8(_3f9){
var _3fa=$.data(_3f9,"layout");
var opts=_3fa.options;
var _3fb=_3fa.panels;
var _3fc=opts.onCollapse;
opts.onCollapse=function(){
};
_3fd("east");
_3fd("west");
_3fd("north");
_3fd("south");
opts.onCollapse=_3fc;
function _3fd(_3fe){
var p=_3fb[_3fe];
if(p.length&&p.panel("options").collapsed){
_3dc(_3f9,_3fe,0);
}
};
};
function _3ff(_400,_401,_402){
var p=$(_400).layout("panel",_401);
p.panel("options").split=_402;
var cls="layout-split-"+_401;
var _403=p.panel("panel").removeClass(cls);
if(_402){
_403.addClass(cls);
}
_403.resizable({disabled:(!_402)});
_3b0(_400);
};
$.fn.layout=function(_404,_405){
if(typeof _404=="string"){
return $.fn.layout.methods[_404](this,_405);
}
_404=_404||{};
return this.each(function(){
var _406=$.data(this,"layout");
if(_406){
$.extend(_406.options,_404);
}else{
var opts=$.extend({},$.fn.layout.defaults,$.fn.layout.parseOptions(this),_404);
$.data(this,"layout",{options:opts,panels:{center:$(),north:$(),south:$(),east:$(),west:$()}});
init(this);
}
_3b0(this);
_3f8(this);
});
};
$.fn.layout.methods={options:function(jq){
return $.data(jq[0],"layout").options;
},resize:function(jq,_407){
return jq.each(function(){
_3b0(this,_407);
});
},panel:function(jq,_408){
return $.data(jq[0],"layout").panels[_408];
},collapse:function(jq,_409){
return jq.each(function(){
_3dc(this,_409);
});
},expand:function(jq,_40a){
return jq.each(function(){
_3ef(this,_40a);
});
},add:function(jq,_40b){
return jq.each(function(){
_3bf(this,_40b);
_3b0(this);
if($(this).layout("panel",_40b.region).panel("options").collapsed){
_3dc(this,_40b.region,0);
}
});
},remove:function(jq,_40c){
return jq.each(function(){
_3d7(this,_40c);
_3b0(this);
});
},split:function(jq,_40d){
return jq.each(function(){
_3ff(this,_40d,true);
});
},unsplit:function(jq,_40e){
return jq.each(function(){
_3ff(this,_40e,false);
});
}};
$.fn.layout.parseOptions=function(_40f){
return $.extend({},$.parser.parseOptions(_40f,[{fit:"boolean"}]));
};
$.fn.layout.defaults={fit:false,onExpand:function(_410){
},onCollapse:function(_411){
},onAdd:function(_412){
},onRemove:function(_413){
}};
$.fn.layout.parsePanelOptions=function(_414){
var t=$(_414);
return $.extend({},$.fn.panel.parseOptions(_414),$.parser.parseOptions(_414,["region",{split:"boolean",collpasedSize:"number",minWidth:"number",minHeight:"number",maxWidth:"number",maxHeight:"number"}]));
};
$.fn.layout.paneldefaults=$.extend({},$.fn.panel.defaults,{region:null,split:false,collapsedSize:28,expandMode:"float",hideExpandTool:false,hideCollapsedContent:true,collapsedContent:function(_415){
var p=$(this);
var opts=p.panel("options");
if(opts.region=="north"||opts.region=="south"){
return _415;
}
var cc=[];
if(opts.iconCls){
cc.push("<div class=\"panel-icon "+opts.iconCls+"\"></div>");
}
cc.push("<div class=\"panel-title layout-expand-title");
cc.push(" layout-expand-title-"+opts.titleDirection);
cc.push(opts.iconCls?" layout-expand-with-icon":"");
cc.push("\">");
cc.push(_415);
cc.push("</div>");
return cc.join("");
},minWidth:10,minHeight:10,maxWidth:10000,maxHeight:10000});
})(jQuery);
(function($){
$(function(){
$(document).unbind(".menu").bind("mousedown.menu",function(e){
var m=$(e.target).closest("div.menu,div.combo-p");
if(m.length){
return;
}
$("body>div.menu-top:visible").not(".menu-inline").menu("hide");
_416($("body>div.menu:visible").not(".menu-inline"));
});
});
function init(_417){
var opts=$.data(_417,"menu").options;
$(_417).addClass("menu-top");
opts.inline?$(_417).addClass("menu-inline"):$(_417).appendTo("body");
$(_417).bind("_resize",function(e,_418){
if($(this).hasClass("easyui-fluid")||_418){
$(_417).menu("resize",_417);
}
return false;
});
var _419=_41a($(_417));
for(var i=0;i<_419.length;i++){
_41d(_417,_419[i]);
}
function _41a(menu){
var _41b=[];
menu.addClass("menu");
_41b.push(menu);
if(!menu.hasClass("menu-content")){
menu.children("div").each(function(){
var _41c=$(this).children("div");
if(_41c.length){
_41c.appendTo("body");
this.submenu=_41c;
var mm=_41a(_41c);
_41b=_41b.concat(mm);
}
});
}
return _41b;
};
};
function _41d(_41e,div){
var menu=$(div).addClass("menu");
if(!menu.data("menu")){
menu.data("menu",{options:$.parser.parseOptions(menu[0],["width","height"])});
}
if(!menu.hasClass("menu-content")){
menu.children("div").each(function(){
_41f(_41e,this);
});
$("<div class=\"menu-line\"></div>").prependTo(menu);
}
_420(_41e,menu);
if(!menu.hasClass("menu-inline")){
menu.hide();
}
_421(_41e,menu);
};
function _41f(_422,div,_423){
var item=$(div);
var _424=$.extend({},$.parser.parseOptions(item[0],["id","name","iconCls","href",{separator:"boolean"}]),{disabled:(item.attr("disabled")?true:undefined),text:$.trim(item.html()),onclick:item[0].onclick},_423||{});
_424.onclick=_424.onclick||_424.handler||null;
item.data("menuitem",{options:_424});
if(_424.separator){
item.addClass("menu-sep");
}
if(!item.hasClass("menu-sep")){
item.addClass("menu-item");
item.empty().append($("<div class=\"menu-text\"></div>").html(_424.text));
if(_424.iconCls){
$("<div class=\"menu-icon\"></div>").addClass(_424.iconCls).appendTo(item);
}
if(_424.id){
item.attr("id",_424.id);
}
if(_424.onclick){
if(typeof _424.onclick=="string"){
item.attr("onclick",_424.onclick);
}else{
item[0].onclick=eval(_424.onclick);
}
}
if(_424.disabled){
_425(_422,item[0],true);
}
if(item[0].submenu){
$("<div class=\"menu-rightarrow\"></div>").appendTo(item);
}
}
};
function _420(_426,menu){
var opts=$.data(_426,"menu").options;
var _427=menu.attr("style")||"";
var _428=menu.is(":visible");
menu.css({display:"block",left:-10000,height:"auto",overflow:"hidden"});
menu.find(".menu-item").each(function(){
$(this)._outerHeight(opts.itemHeight);
$(this).find(".menu-text").css({height:(opts.itemHeight-2)+"px",lineHeight:(opts.itemHeight-2)+"px"});
});
menu.removeClass("menu-noline").addClass(opts.noline?"menu-noline":"");
var _429=menu.data("menu").options;
var _42a=_429.width;
var _42b=_429.height;
if(isNaN(parseInt(_42a))){
_42a=0;
menu.find("div.menu-text").each(function(){
if(_42a<$(this).outerWidth()){
_42a=$(this).outerWidth();
}
});
_42a=_42a?_42a+40:"";
}
var _42c=menu.outerHeight();
if(isNaN(parseInt(_42b))){
_42b=_42c;
if(menu.hasClass("menu-top")&&opts.alignTo){
var at=$(opts.alignTo);
var h1=at.offset().top-$(document).scrollTop();
var h2=$(window)._outerHeight()+$(document).scrollTop()-at.offset().top-at._outerHeight();
_42b=Math.min(_42b,Math.max(h1,h2));
}else{
if(_42b>$(window)._outerHeight()){
_42b=$(window).height();
}
}
}
menu.attr("style",_427);
menu.show();
menu._size($.extend({},_429,{width:_42a,height:_42b,minWidth:_429.minWidth||opts.minWidth,maxWidth:_429.maxWidth||opts.maxWidth}));
menu.find(".easyui-fluid").triggerHandler("_resize",[true]);
menu.css("overflow",menu.outerHeight()<_42c?"auto":"hidden");
menu.children("div.menu-line")._outerHeight(_42c-2);
if(!_428){
menu.hide();
}
};
function _421(_42d,menu){
var _42e=$.data(_42d,"menu");
var opts=_42e.options;
menu.unbind(".menu");
for(var _42f in opts.events){
menu.bind(_42f+".menu",{target:_42d},opts.events[_42f]);
}
};
function _430(e){
var _431=e.data.target;
var _432=$.data(_431,"menu");
if(_432.timer){
clearTimeout(_432.timer);
_432.timer=null;
}
};
function _433(e){
var _434=e.data.target;
var _435=$.data(_434,"menu");
if(_435.options.hideOnUnhover){
_435.timer=setTimeout(function(){
_436(_434,$(_434).hasClass("menu-inline"));
},_435.options.duration);
}
};
function _437(e){
var _438=e.data.target;
var item=$(e.target).closest(".menu-item");
if(item.length){
item.siblings().each(function(){
if(this.submenu){
_416(this.submenu);
}
$(this).removeClass("menu-active");
});
item.addClass("menu-active");
if(item.hasClass("menu-item-disabled")){
item.addClass("menu-active-disabled");
return;
}
var _439=item[0].submenu;
if(_439){
$(_438).menu("show",{menu:_439,parent:item});
}
}
};
function _43a(e){
var item=$(e.target).closest(".menu-item");
if(item.length){
item.removeClass("menu-active menu-active-disabled");
var _43b=item[0].submenu;
if(_43b){
if(e.pageX>=parseInt(_43b.css("left"))){
item.addClass("menu-active");
}else{
_416(_43b);
}
}else{
item.removeClass("menu-active");
}
}
};
function _43c(e){
var _43d=e.data.target;
var item=$(e.target).closest(".menu-item");
if(item.length){
var opts=$(_43d).data("menu").options;
var _43e=item.data("menuitem").options;
if(_43e.disabled){
return;
}
if(!item[0].submenu){
_436(_43d,opts.inline);
if(_43e.href){
location.href=_43e.href;
}
}
item.trigger("mouseenter");
opts.onClick.call(_43d,$(_43d).menu("getItem",item[0]));
}
};
function _436(_43f,_440){
var _441=$.data(_43f,"menu");
if(_441){
if($(_43f).is(":visible")){
_416($(_43f));
if(_440){
$(_43f).show();
}else{
_441.options.onHide.call(_43f);
}
}
}
return false;
};
function _442(_443,_444){
_444=_444||{};
var left,top;
var opts=$.data(_443,"menu").options;
var menu=$(_444.menu||_443);
$(_443).menu("resize",menu[0]);
if(menu.hasClass("menu-top")){
$.extend(opts,_444);
left=opts.left;
top=opts.top;
if(opts.alignTo){
var at=$(opts.alignTo);
left=at.offset().left;
top=at.offset().top+at._outerHeight();
if(opts.align=="right"){
left+=at.outerWidth()-menu.outerWidth();
}
}
if(left+menu.outerWidth()>$(window)._outerWidth()+$(document)._scrollLeft()){
left=$(window)._outerWidth()+$(document).scrollLeft()-menu.outerWidth()-5;
}
if(left<0){
left=0;
}
top=_445(top,opts.alignTo);
}else{
var _446=_444.parent;
left=_446.offset().left+_446.outerWidth()-2;
if(left+menu.outerWidth()+5>$(window)._outerWidth()+$(document).scrollLeft()){
left=_446.offset().left-menu.outerWidth()+2;
}
top=_445(_446.offset().top-3);
}
function _445(top,_447){
if(top+menu.outerHeight()>$(window)._outerHeight()+$(document).scrollTop()){
if(_447){
top=$(_447).offset().top-menu._outerHeight();
}else{
top=$(window)._outerHeight()+$(document).scrollTop()-menu.outerHeight();
}
}
if(top<0){
top=0;
}
return top;
};
menu.css(opts.position.call(_443,menu[0],left,top));
menu.show(0,function(){
if(!menu[0].shadow){
menu[0].shadow=$("<div class=\"menu-shadow\"></div>").insertAfter(menu);
}
menu[0].shadow.css({display:(menu.hasClass("menu-inline")?"none":"block"),zIndex:$.fn.menu.defaults.zIndex++,left:menu.css("left"),top:menu.css("top"),width:menu.outerWidth(),height:menu.outerHeight()});
menu.css("z-index",$.fn.menu.defaults.zIndex++);
if(menu.hasClass("menu-top")){
opts.onShow.call(_443);
}
});
};
function _416(menu){
if(menu&&menu.length){
_448(menu);
menu.find("div.menu-item").each(function(){
if(this.submenu){
_416(this.submenu);
}
$(this).removeClass("menu-active");
});
}
function _448(m){
m.stop(true,true);
if(m[0].shadow){
m[0].shadow.hide();
}
m.hide();
};
};
function _449(_44a,text){
var _44b=null;
var tmp=$("<div></div>");
function find(menu){
menu.children("div.menu-item").each(function(){
var item=$(_44a).menu("getItem",this);
var s=tmp.empty().html(item.text).text();
if(text==$.trim(s)){
_44b=item;
}else{
if(this.submenu&&!_44b){
find(this.submenu);
}
}
});
};
find($(_44a));
tmp.remove();
return _44b;
};
function _425(_44c,_44d,_44e){
var t=$(_44d);
if(t.hasClass("menu-item")){
var opts=t.data("menuitem").options;
opts.disabled=_44e;
if(_44e){
t.addClass("menu-item-disabled");
t[0].onclick=null;
}else{
t.removeClass("menu-item-disabled");
t[0].onclick=opts.onclick;
}
}
};
function _44f(_450,_451){
var opts=$.data(_450,"menu").options;
var menu=$(_450);
if(_451.parent){
if(!_451.parent.submenu){
var _452=$("<div></div>").appendTo("body");
_451.parent.submenu=_452;
$("<div class=\"menu-rightarrow\"></div>").appendTo(_451.parent);
_41d(_450,_452);
}
menu=_451.parent.submenu;
}
var div=$("<div></div>").appendTo(menu);
_41f(_450,div,_451);
};
function _453(_454,_455){
function _456(el){
if(el.submenu){
el.submenu.children("div.menu-item").each(function(){
_456(this);
});
var _457=el.submenu[0].shadow;
if(_457){
_457.remove();
}
el.submenu.remove();
}
$(el).remove();
};
_456(_455);
};
function _458(_459,_45a,_45b){
var menu=$(_45a).parent();
if(_45b){
$(_45a).show();
}else{
$(_45a).hide();
}
_420(_459,menu);
};
function _45c(_45d){
$(_45d).children("div.menu-item").each(function(){
_453(_45d,this);
});
if(_45d.shadow){
_45d.shadow.remove();
}
$(_45d).remove();
};
$.fn.menu=function(_45e,_45f){
if(typeof _45e=="string"){
return $.fn.menu.methods[_45e](this,_45f);
}
_45e=_45e||{};
return this.each(function(){
var _460=$.data(this,"menu");
if(_460){
$.extend(_460.options,_45e);
}else{
_460=$.data(this,"menu",{options:$.extend({},$.fn.menu.defaults,$.fn.menu.parseOptions(this),_45e)});
init(this);
}
$(this).css({left:_460.options.left,top:_460.options.top});
});
};
$.fn.menu.methods={options:function(jq){
return $.data(jq[0],"menu").options;
},show:function(jq,pos){
return jq.each(function(){
_442(this,pos);
});
},hide:function(jq){
return jq.each(function(){
_436(this);
});
},destroy:function(jq){
return jq.each(function(){
_45c(this);
});
},setText:function(jq,_461){
return jq.each(function(){
var item=$(_461.target).data("menuitem").options;
item.text=_461.text;
$(_461.target).children("div.menu-text").html(_461.text);
});
},setIcon:function(jq,_462){
return jq.each(function(){
var item=$(_462.target).data("menuitem").options;
item.iconCls=_462.iconCls;
$(_462.target).children("div.menu-icon").remove();
if(_462.iconCls){
$("<div class=\"menu-icon\"></div>").addClass(_462.iconCls).appendTo(_462.target);
}
});
},getItem:function(jq,_463){
var item=$(_463).data("menuitem").options;
return $.extend({},item,{target:$(_463)[0]});
},findItem:function(jq,text){
return _449(jq[0],text);
},appendItem:function(jq,_464){
return jq.each(function(){
_44f(this,_464);
});
},removeItem:function(jq,_465){
return jq.each(function(){
_453(this,_465);
});
},enableItem:function(jq,_466){
return jq.each(function(){
_425(this,_466,false);
});
},disableItem:function(jq,_467){
return jq.each(function(){
_425(this,_467,true);
});
},showItem:function(jq,_468){
return jq.each(function(){
_458(this,_468,true);
});
},hideItem:function(jq,_469){
return jq.each(function(){
_458(this,_469,false);
});
},resize:function(jq,_46a){
return jq.each(function(){
_420(this,_46a?$(_46a):$(this));
});
}};
$.fn.menu.parseOptions=function(_46b){
return $.extend({},$.parser.parseOptions(_46b,[{minWidth:"number",itemHeight:"number",duration:"number",hideOnUnhover:"boolean"},{fit:"boolean",inline:"boolean",noline:"boolean"}]));
};
$.fn.menu.defaults={zIndex:110000,left:0,top:0,alignTo:null,align:"left",minWidth:120,itemHeight:22,duration:100,hideOnUnhover:true,inline:false,fit:false,noline:false,events:{mouseenter:_430,mouseleave:_433,mouseover:_437,mouseout:_43a,click:_43c},position:function(_46c,left,top){
return {left:left,top:top};
},onShow:function(){
},onHide:function(){
},onClick:function(item){
}};
})(jQuery);
(function($){
function init(_46d){
var opts=$.data(_46d,"menubutton").options;
var btn=$(_46d);
btn.linkbutton(opts);
if(opts.hasDownArrow){
btn.removeClass(opts.cls.btn1+" "+opts.cls.btn2).addClass("m-btn");
btn.removeClass("m-btn-small m-btn-medium m-btn-large").addClass("m-btn-"+opts.size);
var _46e=btn.find(".l-btn-left");
$("<span></span>").addClass(opts.cls.arrow).appendTo(_46e);
$("<span></span>").addClass("m-btn-line").appendTo(_46e);
}
$(_46d).menubutton("resize");
if(opts.menu){
$(opts.menu).menu({duration:opts.duration});
var _46f=$(opts.menu).menu("options");
var _470=_46f.onShow;
var _471=_46f.onHide;
$.extend(_46f,{onShow:function(){
var _472=$(this).menu("options");
var btn=$(_472.alignTo);
var opts=btn.menubutton("options");
btn.addClass((opts.plain==true)?opts.cls.btn2:opts.cls.btn1);
_470.call(this);
},onHide:function(){
var _473=$(this).menu("options");
var btn=$(_473.alignTo);
var opts=btn.menubutton("options");
btn.removeClass((opts.plain==true)?opts.cls.btn2:opts.cls.btn1);
_471.call(this);
}});
}
};
function _474(_475){
var opts=$.data(_475,"menubutton").options;
var btn=$(_475);
var t=btn.find("."+opts.cls.trigger);
if(!t.length){
t=btn;
}
t.unbind(".menubutton");
var _476=null;
t.bind("click.menubutton",function(){
if(!_477()){
_478(_475);
return false;
}
}).bind("mouseenter.menubutton",function(){
if(!_477()){
_476=setTimeout(function(){
_478(_475);
},opts.duration);
return false;
}
}).bind("mouseleave.menubutton",function(){
if(_476){
clearTimeout(_476);
}
$(opts.menu).triggerHandler("mouseleave");
});
function _477(){
return $(_475).linkbutton("options").disabled;
};
};
function _478(_479){
var opts=$(_479).menubutton("options");
if(opts.disabled||!opts.menu){
return;
}
$("body>div.menu-top").menu("hide");
var btn=$(_479);
var mm=$(opts.menu);
if(mm.length){
mm.menu("options").alignTo=btn;
mm.menu("show",{alignTo:btn,align:opts.menuAlign});
}
btn.blur();
};
$.fn.menubutton=function(_47a,_47b){
if(typeof _47a=="string"){
var _47c=$.fn.menubutton.methods[_47a];
if(_47c){
return _47c(this,_47b);
}else{
return this.linkbutton(_47a,_47b);
}
}
_47a=_47a||{};
return this.each(function(){
var _47d=$.data(this,"menubutton");
if(_47d){
$.extend(_47d.options,_47a);
}else{
$.data(this,"menubutton",{options:$.extend({},$.fn.menubutton.defaults,$.fn.menubutton.parseOptions(this),_47a)});
$(this).removeAttr("disabled");
}
init(this);
_474(this);
});
};
$.fn.menubutton.methods={options:function(jq){
var _47e=jq.linkbutton("options");
return $.extend($.data(jq[0],"menubutton").options,{toggle:_47e.toggle,selected:_47e.selected,disabled:_47e.disabled});
},destroy:function(jq){
return jq.each(function(){
var opts=$(this).menubutton("options");
if(opts.menu){
$(opts.menu).menu("destroy");
}
$(this).remove();
});
}};
$.fn.menubutton.parseOptions=function(_47f){
var t=$(_47f);
return $.extend({},$.fn.linkbutton.parseOptions(_47f),$.parser.parseOptions(_47f,["menu",{plain:"boolean",hasDownArrow:"boolean",duration:"number"}]));
};
$.fn.menubutton.defaults=$.extend({},$.fn.linkbutton.defaults,{plain:true,hasDownArrow:true,menu:null,menuAlign:"left",duration:100,cls:{btn1:"m-btn-active",btn2:"m-btn-plain-active",arrow:"m-btn-downarrow",trigger:"m-btn"}});
})(jQuery);
(function($){
function init(_480){
var opts=$.data(_480,"splitbutton").options;
$(_480).menubutton(opts);
$(_480).addClass("s-btn");
};
$.fn.splitbutton=function(_481,_482){
if(typeof _481=="string"){
var _483=$.fn.splitbutton.methods[_481];
if(_483){
return _483(this,_482);
}else{
return this.menubutton(_481,_482);
}
}
_481=_481||{};
return this.each(function(){
var _484=$.data(this,"splitbutton");
if(_484){
$.extend(_484.options,_481);
}else{
$.data(this,"splitbutton",{options:$.extend({},$.fn.splitbutton.defaults,$.fn.splitbutton.parseOptions(this),_481)});
$(this).removeAttr("disabled");
}
init(this);
});
};
$.fn.splitbutton.methods={options:function(jq){
var _485=jq.menubutton("options");
var _486=$.data(jq[0],"splitbutton").options;
$.extend(_486,{disabled:_485.disabled,toggle:_485.toggle,selected:_485.selected});
return _486;
}};
$.fn.splitbutton.parseOptions=function(_487){
var t=$(_487);
return $.extend({},$.fn.linkbutton.parseOptions(_487),$.parser.parseOptions(_487,["menu",{plain:"boolean",duration:"number"}]));
};
$.fn.splitbutton.defaults=$.extend({},$.fn.linkbutton.defaults,{plain:true,menu:null,duration:100,cls:{btn1:"m-btn-active s-btn-active",btn2:"m-btn-plain-active s-btn-plain-active",arrow:"m-btn-downarrow",trigger:"m-btn-line"}});
})(jQuery);
(function($){
function init(_488){
var _489=$("<span class=\"switchbutton\">"+"<span class=\"switchbutton-inner\">"+"<span class=\"switchbutton-on\"></span>"+"<span class=\"switchbutton-handle\"></span>"+"<span class=\"switchbutton-off\"></span>"+"<input class=\"switchbutton-value\" type=\"checkbox\">"+"</span>"+"</span>").insertAfter(_488);
var t=$(_488);
t.addClass("switchbutton-f").hide();
var name=t.attr("name");
if(name){
t.removeAttr("name").attr("switchbuttonName",name);
_489.find(".switchbutton-value").attr("name",name);
}
_489.bind("_resize",function(e,_48a){
if($(this).hasClass("easyui-fluid")||_48a){
_48b(_488);
}
return false;
});
return _489;
};
function _48b(_48c,_48d){
var _48e=$.data(_48c,"switchbutton");
var opts=_48e.options;
var _48f=_48e.switchbutton;
if(_48d){
$.extend(opts,_48d);
}
var _490=_48f.is(":visible");
if(!_490){
_48f.appendTo("body");
}
_48f._size(opts);
var w=_48f.width();
var h=_48f.height();
var w=_48f.outerWidth();
var h=_48f.outerHeight();
var _491=parseInt(opts.handleWidth)||_48f.height();
var _492=w*2-_491;
_48f.find(".switchbutton-inner").css({width:_492+"px",height:h+"px",lineHeight:h+"px"});
_48f.find(".switchbutton-handle")._outerWidth(_491)._outerHeight(h).css({marginLeft:-_491/2+"px"});
_48f.find(".switchbutton-on").css({width:(w-_491/2)+"px",textIndent:(opts.reversed?"":"-")+_491/2+"px"});
_48f.find(".switchbutton-off").css({width:(w-_491/2)+"px",textIndent:(opts.reversed?"-":"")+_491/2+"px"});
opts.marginWidth=w-_491;
_493(_48c,opts.checked,false);
if(!_490){
_48f.insertAfter(_48c);
}
};
function _494(_495){
var _496=$.data(_495,"switchbutton");
var opts=_496.options;
var _497=_496.switchbutton;
var _498=_497.find(".switchbutton-inner");
var on=_498.find(".switchbutton-on").html(opts.onText);
var off=_498.find(".switchbutton-off").html(opts.offText);
var _499=_498.find(".switchbutton-handle").html(opts.handleText);
if(opts.reversed){
off.prependTo(_498);
on.insertAfter(_499);
}else{
on.prependTo(_498);
off.insertAfter(_499);
}
_497.find(".switchbutton-value")._propAttr("checked",opts.checked);
_497.removeClass("switchbutton-disabled").addClass(opts.disabled?"switchbutton-disabled":"");
_497.removeClass("switchbutton-reversed").addClass(opts.reversed?"switchbutton-reversed":"");
_493(_495,opts.checked);
_49a(_495,opts.readonly);
$(_495).switchbutton("setValue",opts.value);
};
function _493(_49b,_49c,_49d){
var _49e=$.data(_49b,"switchbutton");
var opts=_49e.options;
opts.checked=_49c;
var _49f=_49e.switchbutton.find(".switchbutton-inner");
var _4a0=_49f.find(".switchbutton-on");
var _4a1=opts.reversed?(opts.checked?opts.marginWidth:0):(opts.checked?0:opts.marginWidth);
var dir=_4a0.css("float").toLowerCase();
var css={};
css["margin-"+dir]=-_4a1+"px";
_49d?_49f.animate(css,200):_49f.css(css);
var _4a2=_49f.find(".switchbutton-value");
var ck=_4a2.is(":checked");
$(_49b).add(_4a2)._propAttr("checked",opts.checked);
if(ck!=opts.checked){
opts.onChange.call(_49b,opts.checked);
}
};
function _4a3(_4a4,_4a5){
var _4a6=$.data(_4a4,"switchbutton");
var opts=_4a6.options;
var _4a7=_4a6.switchbutton;
var _4a8=_4a7.find(".switchbutton-value");
if(_4a5){
opts.disabled=true;
$(_4a4).add(_4a8).attr("disabled","disabled");
_4a7.addClass("switchbutton-disabled");
}else{
opts.disabled=false;
$(_4a4).add(_4a8).removeAttr("disabled");
_4a7.removeClass("switchbutton-disabled");
}
};
function _49a(_4a9,mode){
var _4aa=$.data(_4a9,"switchbutton");
var opts=_4aa.options;
opts.readonly=mode==undefined?true:mode;
_4aa.switchbutton.removeClass("switchbutton-readonly").addClass(opts.readonly?"switchbutton-readonly":"");
};
function _4ab(_4ac){
var _4ad=$.data(_4ac,"switchbutton");
var opts=_4ad.options;
_4ad.switchbutton.unbind(".switchbutton").bind("click.switchbutton",function(){
if(!opts.disabled&&!opts.readonly){
_493(_4ac,opts.checked?false:true,true);
}
});
};
$.fn.switchbutton=function(_4ae,_4af){
if(typeof _4ae=="string"){
return $.fn.switchbutton.methods[_4ae](this,_4af);
}
_4ae=_4ae||{};
return this.each(function(){
var _4b0=$.data(this,"switchbutton");
if(_4b0){
$.extend(_4b0.options,_4ae);
}else{
_4b0=$.data(this,"switchbutton",{options:$.extend({},$.fn.switchbutton.defaults,$.fn.switchbutton.parseOptions(this),_4ae),switchbutton:init(this)});
}
_4b0.options.originalChecked=_4b0.options.checked;
_494(this);
_48b(this);
_4ab(this);
});
};
$.fn.switchbutton.methods={options:function(jq){
var _4b1=jq.data("switchbutton");
return $.extend(_4b1.options,{value:_4b1.switchbutton.find(".switchbutton-value").val()});
},resize:function(jq,_4b2){
return jq.each(function(){
_48b(this,_4b2);
});
},enable:function(jq){
return jq.each(function(){
_4a3(this,false);
});
},disable:function(jq){
return jq.each(function(){
_4a3(this,true);
});
},readonly:function(jq,mode){
return jq.each(function(){
_49a(this,mode);
});
},check:function(jq){
return jq.each(function(){
_493(this,true);
});
},uncheck:function(jq){
return jq.each(function(){
_493(this,false);
});
},clear:function(jq){
return jq.each(function(){
_493(this,false);
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).switchbutton("options");
_493(this,opts.originalChecked);
});
},setValue:function(jq,_4b3){
return jq.each(function(){
$(this).val(_4b3);
$.data(this,"switchbutton").switchbutton.find(".switchbutton-value").val(_4b3);
});
}};
$.fn.switchbutton.parseOptions=function(_4b4){
var t=$(_4b4);
return $.extend({},$.parser.parseOptions(_4b4,["onText","offText","handleText",{handleWidth:"number",reversed:"boolean"}]),{value:(t.val()||undefined),checked:(t.attr("checked")?true:undefined),disabled:(t.attr("disabled")?true:undefined),readonly:(t.attr("readonly")?true:undefined)});
};
$.fn.switchbutton.defaults={handleWidth:"auto",width:60,height:26,checked:false,disabled:false,readonly:false,reversed:false,onText:"ON",offText:"OFF",handleText:"",value:"on",onChange:function(_4b5){
}};
})(jQuery);
(function($){
function init(_4b6){
$(_4b6).addClass("validatebox-text");
};
function _4b7(_4b8){
var _4b9=$.data(_4b8,"validatebox");
_4b9.validating=false;
if(_4b9.vtimer){
clearTimeout(_4b9.vtimer);
}
if(_4b9.ftimer){
clearTimeout(_4b9.ftimer);
}
$(_4b8).tooltip("destroy");
$(_4b8).unbind();
$(_4b8).remove();
};
function _4ba(_4bb){
var opts=$.data(_4bb,"validatebox").options;
$(_4bb).unbind(".validatebox");
if(opts.novalidate||opts.disabled){
return;
}
for(var _4bc in opts.events){
$(_4bb).bind(_4bc+".validatebox",{target:_4bb},opts.events[_4bc]);
}
};
function _4bd(e){
var _4be=e.data.target;
var _4bf=$.data(_4be,"validatebox");
var opts=_4bf.options;
if($(_4be).attr("readonly")){
return;
}
_4bf.validating=true;
_4bf.value=opts.val(_4be);
(function(){
if(!$(_4be).is(":visible")){
_4bf.validating=false;
}
if(_4bf.validating){
var _4c0=opts.val(_4be);
if(_4bf.value!=_4c0){
_4bf.value=_4c0;
if(_4bf.vtimer){
clearTimeout(_4bf.vtimer);
}
_4bf.vtimer=setTimeout(function(){
$(_4be).validatebox("validate");
},opts.delay);
}else{
if(_4bf.message){
opts.err(_4be,_4bf.message);
}
}
_4bf.ftimer=setTimeout(arguments.callee,opts.interval);
}
})();
};
function _4c1(e){
var _4c2=e.data.target;
var _4c3=$.data(_4c2,"validatebox");
var opts=_4c3.options;
_4c3.validating=false;
if(_4c3.vtimer){
clearTimeout(_4c3.vtimer);
_4c3.vtimer=undefined;
}
if(_4c3.ftimer){
clearTimeout(_4c3.ftimer);
_4c3.ftimer=undefined;
}
if(opts.validateOnBlur){
setTimeout(function(){
$(_4c2).validatebox("validate");
},0);
}
opts.err(_4c2,_4c3.message,"hide");
};
function _4c4(e){
var _4c5=e.data.target;
var _4c6=$.data(_4c5,"validatebox");
_4c6.options.err(_4c5,_4c6.message,"show");
};
function _4c7(e){
var _4c8=e.data.target;
var _4c9=$.data(_4c8,"validatebox");
if(!_4c9.validating){
_4c9.options.err(_4c8,_4c9.message,"hide");
}
};
function _4ca(_4cb,_4cc,_4cd){
var _4ce=$.data(_4cb,"validatebox");
var opts=_4ce.options;
var t=$(_4cb);
if(_4cd=="hide"||!_4cc){
t.tooltip("hide");
}else{
if((t.is(":focus")&&_4ce.validating)||_4cd=="show"){
t.tooltip($.extend({},opts.tipOptions,{content:_4cc,position:opts.tipPosition,deltaX:opts.deltaX,deltaY:opts.deltaY})).tooltip("show");
}
}
};
function _4cf(_4d0){
var _4d1=$.data(_4d0,"validatebox");
var opts=_4d1.options;
var box=$(_4d0);
opts.onBeforeValidate.call(_4d0);
var _4d2=_4d3();
_4d2?box.removeClass("validatebox-invalid"):box.addClass("validatebox-invalid");
opts.err(_4d0,_4d1.message);
opts.onValidate.call(_4d0,_4d2);
return _4d2;
function _4d4(msg){
_4d1.message=msg;
};
function _4d5(_4d6,_4d7){
var _4d8=opts.val(_4d0);
var _4d9=/([a-zA-Z_]+)(.*)/.exec(_4d6);
var rule=opts.rules[_4d9[1]];
if(rule&&_4d8){
var _4da=_4d7||opts.validParams||eval(_4d9[2]);
if(!rule["validator"].call(_4d0,_4d8,_4da)){
var _4db=rule["message"];
if(_4da){
for(var i=0;i<_4da.length;i++){
_4db=_4db.replace(new RegExp("\\{"+i+"\\}","g"),_4da[i]);
}
}
_4d4(opts.invalidMessage||_4db);
return false;
}
}
return true;
};
function _4d3(){
_4d4("");
if(!opts._validateOnCreate){
setTimeout(function(){
opts._validateOnCreate=true;
},0);
return true;
}
if(opts.novalidate||opts.disabled){
return true;
}
if(opts.required){
if(opts.val(_4d0)==""){
_4d4(opts.missingMessage);
return false;
}
}
if(opts.validType){
if($.isArray(opts.validType)){
for(var i=0;i<opts.validType.length;i++){
if(!_4d5(opts.validType[i])){
return false;
}
}
}else{
if(typeof opts.validType=="string"){
if(!_4d5(opts.validType)){
return false;
}
}else{
for(var _4dc in opts.validType){
var _4dd=opts.validType[_4dc];
if(!_4d5(_4dc,_4dd)){
return false;
}
}
}
}
}
return true;
};
};
function _4de(_4df,_4e0){
var opts=$.data(_4df,"validatebox").options;
if(_4e0!=undefined){
opts.disabled=_4e0;
}
if(opts.disabled){
$(_4df).addClass("validatebox-disabled").attr("disabled","disabled");
}else{
$(_4df).removeClass("validatebox-disabled").removeAttr("disabled");
}
};
function _4e1(_4e2,mode){
var opts=$.data(_4e2,"validatebox").options;
opts.readonly=mode==undefined?true:mode;
if(opts.readonly||!opts.editable){
$(_4e2).triggerHandler("blur.validatebox");
$(_4e2).addClass("validatebox-readonly").attr("readonly","readonly");
}else{
$(_4e2).removeClass("validatebox-readonly").removeAttr("readonly");
}
};
$.fn.validatebox=function(_4e3,_4e4){
if(typeof _4e3=="string"){
return $.fn.validatebox.methods[_4e3](this,_4e4);
}
_4e3=_4e3||{};
return this.each(function(){
var _4e5=$.data(this,"validatebox");
if(_4e5){
$.extend(_4e5.options,_4e3);
}else{
init(this);
_4e5=$.data(this,"validatebox",{options:$.extend({},$.fn.validatebox.defaults,$.fn.validatebox.parseOptions(this),_4e3)});
}
_4e5.options._validateOnCreate=_4e5.options.validateOnCreate;
_4de(this,_4e5.options.disabled);
_4e1(this,_4e5.options.readonly);
_4ba(this);
_4cf(this);
});
};
$.fn.validatebox.methods={options:function(jq){
return $.data(jq[0],"validatebox").options;
},destroy:function(jq){
return jq.each(function(){
_4b7(this);
});
},validate:function(jq){
return jq.each(function(){
_4cf(this);
});
},isValid:function(jq){
return _4cf(jq[0]);
},enableValidation:function(jq){
return jq.each(function(){
$(this).validatebox("options").novalidate=false;
_4ba(this);
_4cf(this);
});
},disableValidation:function(jq){
return jq.each(function(){
$(this).validatebox("options").novalidate=true;
_4ba(this);
_4cf(this);
});
},resetValidation:function(jq){
return jq.each(function(){
var opts=$(this).validatebox("options");
opts._validateOnCreate=opts.validateOnCreate;
_4cf(this);
});
},enable:function(jq){
return jq.each(function(){
_4de(this,false);
_4ba(this);
_4cf(this);
});
},disable:function(jq){
return jq.each(function(){
_4de(this,true);
_4ba(this);
_4cf(this);
});
},readonly:function(jq,mode){
return jq.each(function(){
_4e1(this,mode);
_4ba(this);
_4cf(this);
});
}};
$.fn.validatebox.parseOptions=function(_4e6){
var t=$(_4e6);
return $.extend({},$.parser.parseOptions(_4e6,["validType","missingMessage","invalidMessage","tipPosition",{delay:"number",interval:"number",deltaX:"number"},{editable:"boolean",validateOnCreate:"boolean",validateOnBlur:"boolean"}]),{required:(t.attr("required")?true:undefined),disabled:(t.attr("disabled")?true:undefined),readonly:(t.attr("readonly")?true:undefined),novalidate:(t.attr("novalidate")!=undefined?true:undefined)});
};
$.fn.validatebox.defaults={required:false,validType:null,validParams:null,delay:200,interval:200,missingMessage:"This field is required.",invalidMessage:null,tipPosition:"right",deltaX:0,deltaY:0,novalidate:false,editable:true,disabled:false,readonly:false,validateOnCreate:true,validateOnBlur:false,events:{focus:_4bd,blur:_4c1,mouseenter:_4c4,mouseleave:_4c7,click:function(e){
var t=$(e.data.target);
if(t.attr("type")=="checkbox"||t.attr("type")=="radio"){
t.focus().validatebox("validate");
}
}},val:function(_4e7){
return $(_4e7).val();
},err:function(_4e8,_4e9,_4ea){
_4ca(_4e8,_4e9,_4ea);
},tipOptions:{showEvent:"none",hideEvent:"none",showDelay:0,hideDelay:0,zIndex:"",onShow:function(){
$(this).tooltip("tip").css({color:"#000",borderColor:"#CC9933",backgroundColor:"#FFFFCC"});
},onHide:function(){
$(this).tooltip("destroy");
}},rules:{email:{validator:function(_4eb){
return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(_4eb);
},message:"Please enter a valid email address."},url:{validator:function(_4ec){
return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(_4ec);
},message:"Please enter a valid URL."},length:{validator:function(_4ed,_4ee){
var len=$.trim(_4ed).length;
return len>=_4ee[0]&&len<=_4ee[1];
},message:"Please enter a value between {0} and {1}."},remote:{validator:function(_4ef,_4f0){
var data={};
data[_4f0[1]]=_4ef;
var _4f1=$.ajax({url:_4f0[0],dataType:"json",data:data,async:false,cache:false,type:"post"}).responseText;
return _4f1=="true";
},message:"Please fix this field."}},onBeforeValidate:function(){
},onValidate:function(_4f2){
}};
})(jQuery);
(function($){
var _4f3=0;
function init(_4f4){
$(_4f4).addClass("textbox-f").hide();
var span=$("<span class=\"textbox\">"+"<input class=\"textbox-text\" autocomplete=\"off\">"+"<input type=\"hidden\" class=\"textbox-value\">"+"</span>").insertAfter(_4f4);
var name=$(_4f4).attr("name");
if(name){
span.find("input.textbox-value").attr("name",name);
$(_4f4).removeAttr("name").attr("textboxName",name);
}
return span;
};
function _4f5(_4f6){
var _4f7=$.data(_4f6,"textbox");
var opts=_4f7.options;
var tb=_4f7.textbox;
var _4f8="_easyui_textbox_input"+(++_4f3);
tb.addClass(opts.cls);
tb.find(".textbox-text").remove();
if(opts.multiline){
$("<textarea id=\""+_4f8+"\" class=\"textbox-text\" autocomplete=\"off\"></textarea>").prependTo(tb);
}else{
$("<input id=\""+_4f8+"\" type=\""+opts.type+"\" class=\"textbox-text\" autocomplete=\"off\">").prependTo(tb);
}
$("#"+_4f8).attr("tabindex",$(_4f6).attr("tabindex")||"").css("text-align",_4f6.style.textAlign||"");
tb.find(".textbox-addon").remove();
var bb=opts.icons?$.extend(true,[],opts.icons):[];
if(opts.iconCls){
bb.push({iconCls:opts.iconCls,disabled:true});
}
if(bb.length){
var bc=$("<span class=\"textbox-addon\"></span>").prependTo(tb);
bc.addClass("textbox-addon-"+opts.iconAlign);
for(var i=0;i<bb.length;i++){
bc.append("<a href=\"javascript:;\" class=\"textbox-icon "+bb[i].iconCls+"\" icon-index=\""+i+"\" tabindex=\"-1\"></a>");
}
}
tb.find(".textbox-button").remove();
if(opts.buttonText||opts.buttonIcon){
var btn=$("<a href=\"javascript:;\" class=\"textbox-button\"></a>").prependTo(tb);
btn.addClass("textbox-button-"+opts.buttonAlign).linkbutton({text:opts.buttonText,iconCls:opts.buttonIcon,onClick:function(){
var t=$(this).parent().prev();
t.textbox("options").onClickButton.call(t[0]);
}});
}
if(opts.label){
if(typeof opts.label=="object"){
_4f7.label=$(opts.label);
_4f7.label.attr("for",_4f8);
}else{
$(_4f7.label).remove();
_4f7.label=$("<label class=\"textbox-label\"></label>").html(opts.label);
_4f7.label.css("textAlign",opts.labelAlign).attr("for",_4f8);
if(opts.labelPosition=="after"){
_4f7.label.insertAfter(tb);
}else{
_4f7.label.insertBefore(_4f6);
}
_4f7.label.removeClass("textbox-label-left textbox-label-right textbox-label-top");
_4f7.label.addClass("textbox-label-"+opts.labelPosition);
}
}else{
$(_4f7.label).remove();
}
_4f9(_4f6);
_4fa(_4f6,opts.disabled);
_4fb(_4f6,opts.readonly);
};
function _4fc(_4fd){
var _4fe=$.data(_4fd,"textbox");
var tb=_4fe.textbox;
tb.find(".textbox-text").validatebox("destroy");
tb.remove();
$(_4fe.label).remove();
$(_4fd).remove();
};
function _4ff(_500,_501){
var _502=$.data(_500,"textbox");
var opts=_502.options;
var tb=_502.textbox;
var _503=tb.parent();
if(_501){
if(typeof _501=="object"){
$.extend(opts,_501);
}else{
opts.width=_501;
}
}
if(isNaN(parseInt(opts.width))){
var c=$(_500).clone();
c.css("visibility","hidden");
c.insertAfter(_500);
opts.width=c.outerWidth();
c.remove();
}
var _504=tb.is(":visible");
if(!_504){
tb.appendTo("body");
}
var _505=tb.find(".textbox-text");
var btn=tb.find(".textbox-button");
var _506=tb.find(".textbox-addon");
var _507=_506.find(".textbox-icon");
if(opts.height=="auto"){
_505.css({margin:"",paddingTop:"",paddingBottom:"",height:"",lineHeight:""});
}
tb._size(opts,_503);
if(opts.label&&opts.labelPosition){
if(opts.labelPosition=="top"){
_502.label._size({width:opts.labelWidth=="auto"?tb.outerWidth():opts.labelWidth},tb);
if(opts.height!="auto"){
tb._size("height",tb.outerHeight()-_502.label.outerHeight());
}
}else{
_502.label._size({width:opts.labelWidth,height:tb.outerHeight()},tb);
if(!opts.multiline){
_502.label.css("lineHeight",_502.label.height()+"px");
}
tb._size("width",tb.outerWidth()-_502.label.outerWidth());
}
}
if(opts.buttonAlign=="left"||opts.buttonAlign=="right"){
btn.linkbutton("resize",{height:tb.height()});
}else{
btn.linkbutton("resize",{width:"100%"});
}
var _508=tb.width()-_507.length*opts.iconWidth-_509("left")-_509("right");
var _50a=opts.height=="auto"?_505.outerHeight():(tb.height()-_509("top")-_509("bottom"));
_506.css(opts.iconAlign,_509(opts.iconAlign)+"px");
_506.css("top",_509("top")+"px");
_507.css({width:opts.iconWidth+"px",height:_50a+"px"});
_505.css({paddingLeft:(_500.style.paddingLeft||""),paddingRight:(_500.style.paddingRight||""),marginLeft:_50b("left"),marginRight:_50b("right"),marginTop:_509("top"),marginBottom:_509("bottom")});
if(opts.multiline){
_505.css({paddingTop:(_500.style.paddingTop||""),paddingBottom:(_500.style.paddingBottom||"")});
_505._outerHeight(_50a);
}else{
_505.css({paddingTop:0,paddingBottom:0,height:_50a+"px",lineHeight:_50a+"px"});
}
_505._outerWidth(_508);
opts.onResizing.call(_500,opts.width,opts.height);
if(!_504){
tb.insertAfter(_500);
}
opts.onResize.call(_500,opts.width,opts.height);
function _50b(_50c){
return (opts.iconAlign==_50c?_506._outerWidth():0)+_509(_50c);
};
function _509(_50d){
var w=0;
btn.filter(".textbox-button-"+_50d).each(function(){
if(_50d=="left"||_50d=="right"){
w+=$(this).outerWidth();
}else{
w+=$(this).outerHeight();
}
});
return w;
};
};
function _4f9(_50e){
var opts=$(_50e).textbox("options");
var _50f=$(_50e).textbox("textbox");
_50f.validatebox($.extend({},opts,{deltaX:function(_510){
return $(_50e).textbox("getTipX",_510);
},deltaY:function(_511){
return $(_50e).textbox("getTipY",_511);
},onBeforeValidate:function(){
opts.onBeforeValidate.call(_50e);
var box=$(this);
if(!box.is(":focus")){
if(box.val()!==opts.value){
opts.oldInputValue=box.val();
box.val(opts.value);
}
}
},onValidate:function(_512){
var box=$(this);
if(opts.oldInputValue!=undefined){
box.val(opts.oldInputValue);
opts.oldInputValue=undefined;
}
var tb=box.parent();
if(_512){
tb.removeClass("textbox-invalid");
}else{
tb.addClass("textbox-invalid");
}
opts.onValidate.call(_50e,_512);
}}));
};
function _513(_514){
var _515=$.data(_514,"textbox");
var opts=_515.options;
var tb=_515.textbox;
var _516=tb.find(".textbox-text");
_516.attr("placeholder",opts.prompt);
_516.unbind(".textbox");
$(_515.label).unbind(".textbox");
if(!opts.disabled&&!opts.readonly){
if(_515.label){
$(_515.label).bind("click.textbox",function(e){
if(!opts.hasFocusMe){
_516.focus();
$(_514).textbox("setSelectionRange",{start:0,end:_516.val().length});
}
});
}
_516.bind("blur.textbox",function(e){
if(!tb.hasClass("textbox-focused")){
return;
}
opts.value=$(this).val();
if(opts.value==""){
$(this).val(opts.prompt).addClass("textbox-prompt");
}else{
$(this).removeClass("textbox-prompt");
}
tb.removeClass("textbox-focused");
}).bind("focus.textbox",function(e){
opts.hasFocusMe=true;
if(tb.hasClass("textbox-focused")){
return;
}
if($(this).val()!=opts.value){
$(this).val(opts.value);
}
$(this).removeClass("textbox-prompt");
tb.addClass("textbox-focused");
});
for(var _517 in opts.inputEvents){
_516.bind(_517+".textbox",{target:_514},opts.inputEvents[_517]);
}
}
var _518=tb.find(".textbox-addon");
_518.unbind().bind("click",{target:_514},function(e){
var icon=$(e.target).closest("a.textbox-icon:not(.textbox-icon-disabled)");
if(icon.length){
var _519=parseInt(icon.attr("icon-index"));
var conf=opts.icons[_519];
if(conf&&conf.handler){
conf.handler.call(icon[0],e);
}
opts.onClickIcon.call(_514,_519);
}
});
_518.find(".textbox-icon").each(function(_51a){
var conf=opts.icons[_51a];
var icon=$(this);
if(!conf||conf.disabled||opts.disabled||opts.readonly){
icon.addClass("textbox-icon-disabled");
}else{
icon.removeClass("textbox-icon-disabled");
}
});
var btn=tb.find(".textbox-button");
btn.linkbutton((opts.disabled||opts.readonly)?"disable":"enable");
tb.unbind(".textbox").bind("_resize.textbox",function(e,_51b){
if($(this).hasClass("easyui-fluid")||_51b){
_4ff(_514);
}
return false;
});
};
function _4fa(_51c,_51d){
var _51e=$.data(_51c,"textbox");
var opts=_51e.options;
var tb=_51e.textbox;
var _51f=tb.find(".textbox-text");
var ss=$(_51c).add(tb.find(".textbox-value"));
opts.disabled=_51d;
if(opts.disabled){
_51f.blur();
_51f.validatebox("disable");
tb.addClass("textbox-disabled");
ss.attr("disabled","disabled");
$(_51e.label).addClass("textbox-label-disabled");
}else{
_51f.validatebox("enable");
tb.removeClass("textbox-disabled");
ss.removeAttr("disabled");
$(_51e.label).removeClass("textbox-label-disabled");
}
};
function _4fb(_520,mode){
var _521=$.data(_520,"textbox");
var opts=_521.options;
var tb=_521.textbox;
var _522=tb.find(".textbox-text");
opts.readonly=mode==undefined?true:mode;
if(opts.readonly){
_522.triggerHandler("blur.textbox");
}
_522.validatebox("readonly",opts.readonly);
tb.removeClass("textbox-readonly").addClass(opts.readonly?"textbox-readonly":"");
};
$.fn.textbox=function(_523,_524){
if(typeof _523=="string"){
var _525=$.fn.textbox.methods[_523];
if(_525){
return _525(this,_524);
}else{
return this.each(function(){
var _526=$(this).textbox("textbox");
_526.validatebox(_523,_524);
});
}
}
_523=_523||{};
return this.each(function(){
var _527=$.data(this,"textbox");
if(_527){
$.extend(_527.options,_523);
if(_523.value!=undefined){
_527.options.originalValue=_523.value;
}
}else{
_527=$.data(this,"textbox",{options:$.extend({},$.fn.textbox.defaults,$.fn.textbox.parseOptions(this),_523),textbox:init(this)});
_527.options.originalValue=_527.options.value;
}
_4f5(this);
_513(this);
if(_527.options.doSize){
_4ff(this);
}
var _528=_527.options.value;
_527.options.value="";
$(this).textbox("initValue",_528);
});
};
$.fn.textbox.methods={options:function(jq){
return $.data(jq[0],"textbox").options;
},cloneFrom:function(jq,from){
return jq.each(function(){
var t=$(this);
if(t.data("textbox")){
return;
}
if(!$(from).data("textbox")){
$(from).textbox();
}
var opts=$.extend(true,{},$(from).textbox("options"));
var name=t.attr("name")||"";
t.addClass("textbox-f").hide();
t.removeAttr("name").attr("textboxName",name);
var span=$(from).next().clone().insertAfter(t);
var _529="_easyui_textbox_input"+(++_4f3);
span.find(".textbox-value").attr("name",name);
span.find(".textbox-text").attr("id",_529);
var _52a=$($(from).textbox("label")).clone();
if(_52a.length){
_52a.attr("for",_529);
if(opts.labelPosition=="after"){
_52a.insertAfter(t.next());
}else{
_52a.insertBefore(t);
}
}
$.data(this,"textbox",{options:opts,textbox:span,label:(_52a.length?_52a:undefined)});
var _52b=$(from).textbox("button");
if(_52b.length){
t.textbox("button").linkbutton($.extend(true,{},_52b.linkbutton("options")));
}
_513(this);
_4f9(this);
});
},textbox:function(jq){
return $.data(jq[0],"textbox").textbox.find(".textbox-text");
},button:function(jq){
return $.data(jq[0],"textbox").textbox.find(".textbox-button");
},label:function(jq){
return $.data(jq[0],"textbox").label;
},destroy:function(jq){
return jq.each(function(){
_4fc(this);
});
},resize:function(jq,_52c){
return jq.each(function(){
_4ff(this,_52c);
});
},disable:function(jq){
return jq.each(function(){
_4fa(this,true);
_513(this);
});
},enable:function(jq){
return jq.each(function(){
_4fa(this,false);
_513(this);
});
},readonly:function(jq,mode){
return jq.each(function(){
_4fb(this,mode);
_513(this);
});
},isValid:function(jq){
return jq.textbox("textbox").validatebox("isValid");
},clear:function(jq){
return jq.each(function(){
$(this).textbox("setValue","");
});
},setText:function(jq,_52d){
return jq.each(function(){
var opts=$(this).textbox("options");
var _52e=$(this).textbox("textbox");
_52d=_52d==undefined?"":String(_52d);
if($(this).textbox("getText")!=_52d){
_52e.val(_52d);
}
opts.value=_52d;
if(!_52e.is(":focus")){
if(_52d){
_52e.removeClass("textbox-prompt");
}else{
_52e.val(opts.prompt).addClass("textbox-prompt");
}
}
$(this).textbox("validate");
});
},initValue:function(jq,_52f){
return jq.each(function(){
var _530=$.data(this,"textbox");
$(this).textbox("setText",_52f);
_530.textbox.find(".textbox-value").val(_52f);
$(this).val(_52f);
});
},setValue:function(jq,_531){
return jq.each(function(){
var opts=$.data(this,"textbox").options;
var _532=$(this).textbox("getValue");
$(this).textbox("initValue",_531);
if(_532!=_531){
opts.onChange.call(this,_531,_532);
$(this).closest("form").trigger("_change",[this]);
}
});
},getText:function(jq){
var _533=jq.textbox("textbox");
if(_533.is(":focus")){
return _533.val();
}else{
return jq.textbox("options").value;
}
},getValue:function(jq){
return jq.data("textbox").textbox.find(".textbox-value").val();
},reset:function(jq){
return jq.each(function(){
var opts=$(this).textbox("options");
$(this).textbox("textbox").val(opts.originalValue);
$(this).textbox("setValue",opts.originalValue);
});
},getIcon:function(jq,_534){
return jq.data("textbox").textbox.find(".textbox-icon:eq("+_534+")");
},getTipX:function(jq,_535){
var _536=jq.data("textbox");
var opts=_536.options;
var tb=_536.textbox;
var _537=tb.find(".textbox-text");
var _535=_535||opts.tipPosition;
var p1=tb.offset();
var p2=_537.offset();
var w1=tb.outerWidth();
var w2=_537.outerWidth();
if(_535=="right"){
return w1-w2-p2.left+p1.left;
}else{
if(_535=="left"){
return p1.left-p2.left;
}else{
return (w1-w2-p2.left+p1.left)/2-(p2.left-p1.left)/2;
}
}
},getTipY:function(jq,_538){
var _539=jq.data("textbox");
var opts=_539.options;
var tb=_539.textbox;
var _53a=tb.find(".textbox-text");
var _538=_538||opts.tipPosition;
var p1=tb.offset();
var p2=_53a.offset();
var h1=tb.outerHeight();
var h2=_53a.outerHeight();
if(_538=="left"||_538=="right"){
return (h1-h2-p2.top+p1.top)/2-(p2.top-p1.top)/2;
}else{
if(_538=="bottom"){
return (h1-h2-p2.top+p1.top);
}else{
return (p1.top-p2.top);
}
}
},getSelectionStart:function(jq){
return jq.textbox("getSelectionRange").start;
},getSelectionRange:function(jq){
var _53b=jq.textbox("textbox")[0];
var _53c=0;
var end=0;
if(typeof _53b.selectionStart=="number"){
_53c=_53b.selectionStart;
end=_53b.selectionEnd;
}else{
if(_53b.createTextRange){
var s=document.selection.createRange();
var _53d=_53b.createTextRange();
_53d.setEndPoint("EndToStart",s);
_53c=_53d.text.length;
end=_53c+s.text.length;
}
}
return {start:_53c,end:end};
},setSelectionRange:function(jq,_53e){
return jq.each(function(){
var _53f=$(this).textbox("textbox")[0];
var _540=_53e.start;
var end=_53e.end;
if(_53f.setSelectionRange){
_53f.setSelectionRange(_540,end);
}else{
if(_53f.createTextRange){
var _541=_53f.createTextRange();
_541.collapse();
_541.moveEnd("character",end);
_541.moveStart("character",_540);
_541.select();
}
}
});
}};
$.fn.textbox.parseOptions=function(_542){
var t=$(_542);
return $.extend({},$.fn.validatebox.parseOptions(_542),$.parser.parseOptions(_542,["prompt","iconCls","iconAlign","buttonText","buttonIcon","buttonAlign","label","labelPosition","labelAlign",{multiline:"boolean",iconWidth:"number",labelWidth:"number"}]),{value:(t.val()||undefined),type:(t.attr("type")?t.attr("type"):undefined)});
};
$.fn.textbox.defaults=$.extend({},$.fn.validatebox.defaults,{doSize:true,width:"auto",height:"auto",cls:null,prompt:"",value:"",type:"text",multiline:false,icons:[],iconCls:null,iconAlign:"right",iconWidth:18,buttonText:"",buttonIcon:null,buttonAlign:"right",label:null,labelWidth:"auto",labelPosition:"before",labelAlign:"left",inputEvents:{blur:function(e){
var t=$(e.data.target);
var opts=t.textbox("options");
if(t.textbox("getValue")!=opts.value){
t.textbox("setValue",opts.value);
}
},keydown:function(e){
if(e.keyCode==13){
var t=$(e.data.target);
t.textbox("setValue",t.textbox("getText"));
}
}},onChange:function(_543,_544){
},onResizing:function(_545,_546){
},onResize:function(_547,_548){
},onClickButton:function(){
},onClickIcon:function(_549){
}});
})(jQuery);
(function($){
function _54a(_54b){
var _54c=$.data(_54b,"passwordbox");
var opts=_54c.options;
var _54d=$.extend(true,[],opts.icons);
if(opts.showEye){
_54d.push({iconCls:"passwordbox-open",handler:function(e){
opts.revealed=!opts.revealed;
_54e(_54b);
}});
}
$(_54b).addClass("passwordbox-f").textbox($.extend({},opts,{icons:_54d}));
_54e(_54b);
};
function _54f(_550,_551,all){
var t=$(_550);
var opts=t.passwordbox("options");
if(opts.revealed){
t.textbox("setValue",_551);
return;
}
var _552=unescape(opts.passwordChar);
var cc=_551.split("");
var vv=t.passwordbox("getValue").split("");
for(var i=0;i<cc.length;i++){
var c=cc[i];
if(c!=vv[i]){
if(c!=_552){
vv.splice(i,0,c);
}
}
}
var pos=t.passwordbox("getSelectionStart");
if(cc.length<vv.length){
vv.splice(pos,vv.length-cc.length,"");
}
for(var i=0;i<cc.length;i++){
if(all||i!=pos-1){
cc[i]=_552;
}
}
t.textbox("setValue",vv.join(""));
t.textbox("setText",cc.join(""));
t.textbox("setSelectionRange",{start:pos,end:pos});
};
function _54e(_553,_554){
var t=$(_553);
var opts=t.passwordbox("options");
var icon=t.next().find(".passwordbox-open");
var _555=unescape(opts.passwordChar);
_554=_554==undefined?t.textbox("getValue"):_554;
t.textbox("setValue",_554);
t.textbox("setText",opts.revealed?_554:_554.replace(/./ig,_555));
opts.revealed?icon.addClass("passwordbox-close"):icon.removeClass("passwordbox-close");
};
function _556(e){
var _557=e.data.target;
var t=$(e.data.target);
var _558=t.data("passwordbox");
var opts=t.data("passwordbox").options;
_558.checking=true;
_558.value=t.passwordbox("getText");
(function(){
if(_558.checking){
var _559=t.passwordbox("getText");
if(_558.value!=_559){
_558.value=_559;
if(_558.lastTimer){
clearTimeout(_558.lastTimer);
_558.lastTimer=undefined;
}
_54f(_557,_559);
_558.lastTimer=setTimeout(function(){
_54f(_557,t.passwordbox("getText"),true);
_558.lastTimer=undefined;
},opts.lastDelay);
}
setTimeout(arguments.callee,opts.checkInterval);
}
})();
};
function _55a(e){
var _55b=e.data.target;
var _55c=$(_55b).data("passwordbox");
_55c.checking=false;
if(_55c.lastTimer){
clearTimeout(_55c.lastTimer);
_55c.lastTimer=undefined;
}
_54e(_55b);
};
$.fn.passwordbox=function(_55d,_55e){
if(typeof _55d=="string"){
var _55f=$.fn.passwordbox.methods[_55d];
if(_55f){
return _55f(this,_55e);
}else{
return this.textbox(_55d,_55e);
}
}
_55d=_55d||{};
return this.each(function(){
var _560=$.data(this,"passwordbox");
if(_560){
$.extend(_560.options,_55d);
}else{
_560=$.data(this,"passwordbox",{options:$.extend({},$.fn.passwordbox.defaults,$.fn.passwordbox.parseOptions(this),_55d)});
}
_54a(this);
});
};
$.fn.passwordbox.methods={options:function(jq){
return $.data(jq[0],"passwordbox").options;
},setValue:function(jq,_561){
return jq.each(function(){
_54e(this,_561);
});
},clear:function(jq){
return jq.each(function(){
_54e(this,"");
});
},reset:function(jq){
return jq.each(function(){
$(this).textbox("reset");
_54e(this);
});
},showPassword:function(jq){
return jq.each(function(){
var opts=$(this).passwordbox("options");
opts.revealed=true;
_54e(this);
});
},hidePassword:function(jq){
return jq.each(function(){
var opts=$(this).passwordbox("options");
opts.revealed=false;
_54e(this);
});
}};
$.fn.passwordbox.parseOptions=function(_562){
return $.extend({},$.fn.textbox.parseOptions(_562),$.parser.parseOptions(_562,["passwordChar",{checkInterval:"number",lastDelay:"number",revealed:"boolean",showEye:"boolean"}]));
};
$.fn.passwordbox.defaults=$.extend({},$.fn.textbox.defaults,{passwordChar:"%u25CF",checkInterval:200,lastDelay:500,revealed:false,showEye:true,inputEvents:{focus:_556,blur:_55a},val:function(_563){
return $(_563).parent().prev().passwordbox("getValue");
}});
})(jQuery);
(function($){
var _564=0;
function _565(_566){
var _567=$.data(_566,"filebox");
var opts=_567.options;
opts.fileboxId="filebox_file_id_"+(++_564);
$(_566).addClass("filebox-f").textbox(opts);
$(_566).textbox("textbox").attr("readonly","readonly");
_567.filebox=$(_566).next().addClass("filebox");
var file=_568(_566);
var btn=$(_566).filebox("button");
if(btn.length){
$("<label class=\"filebox-label\" for=\""+opts.fileboxId+"\"></label>").appendTo(btn);
if(btn.linkbutton("options").disabled){
file.attr("disabled","disabled");
}else{
file.removeAttr("disabled");
}
}
};
function _568(_569){
var _56a=$.data(_569,"filebox");
var opts=_56a.options;
_56a.filebox.find(".textbox-value").remove();
opts.oldValue="";
var file=$("<input type=\"file\" class=\"textbox-value\">").appendTo(_56a.filebox);
file.attr("id",opts.fileboxId).attr("name",$(_569).attr("textboxName")||"");
file.attr("accept",opts.accept);
file.attr("capture",opts.capture);
if(opts.multiple){
file.attr("multiple","multiple");
}
file.change(function(){
var _56b=this.value;
if(this.files){
_56b=$.map(this.files,function(file){
return file.name;
}).join(opts.separator);
}
$(_569).filebox("setText",_56b);
opts.onChange.call(_569,_56b,opts.oldValue);
opts.oldValue=_56b;
});
return file;
};
$.fn.filebox=function(_56c,_56d){
if(typeof _56c=="string"){
var _56e=$.fn.filebox.methods[_56c];
if(_56e){
return _56e(this,_56d);
}else{
return this.textbox(_56c,_56d);
}
}
_56c=_56c||{};
return this.each(function(){
var _56f=$.data(this,"filebox");
if(_56f){
$.extend(_56f.options,_56c);
}else{
$.data(this,"filebox",{options:$.extend({},$.fn.filebox.defaults,$.fn.filebox.parseOptions(this),_56c)});
}
_565(this);
});
};
$.fn.filebox.methods={options:function(jq){
var opts=jq.textbox("options");
return $.extend($.data(jq[0],"filebox").options,{width:opts.width,value:opts.value,originalValue:opts.originalValue,disabled:opts.disabled,readonly:opts.readonly});
},clear:function(jq){
return jq.each(function(){
$(this).textbox("clear");
_568(this);
});
},reset:function(jq){
return jq.each(function(){
$(this).filebox("clear");
});
},setValue:function(jq){
return jq;
},setValues:function(jq){
return jq;
}};
$.fn.filebox.parseOptions=function(_570){
var t=$(_570);
return $.extend({},$.fn.textbox.parseOptions(_570),$.parser.parseOptions(_570,["accept","capture","separator"]),{multiple:(t.attr("multiple")?true:undefined)});
};
$.fn.filebox.defaults=$.extend({},$.fn.textbox.defaults,{buttonIcon:null,buttonText:"Choose File",buttonAlign:"right",inputEvents:{},accept:"",capture:"",separator:",",multiple:false});
})(jQuery);
(function($){
function _571(_572){
var _573=$.data(_572,"searchbox");
var opts=_573.options;
var _574=$.extend(true,[],opts.icons);
_574.push({iconCls:"searchbox-button",handler:function(e){
var t=$(e.data.target);
var opts=t.searchbox("options");
opts.searcher.call(e.data.target,t.searchbox("getValue"),t.searchbox("getName"));
}});
_575();
var _576=_577();
$(_572).addClass("searchbox-f").textbox($.extend({},opts,{icons:_574,buttonText:(_576?_576.text:"")}));
$(_572).attr("searchboxName",$(_572).attr("textboxName"));
_573.searchbox=$(_572).next();
_573.searchbox.addClass("searchbox");
_578(_576);
function _575(){
if(opts.menu){
_573.menu=$(opts.menu).menu();
var _579=_573.menu.menu("options");
var _57a=_579.onClick;
_579.onClick=function(item){
_578(item);
_57a.call(this,item);
};
}else{
if(_573.menu){
_573.menu.menu("destroy");
}
_573.menu=null;
}
};
function _577(){
if(_573.menu){
var item=_573.menu.children("div.menu-item:first");
_573.menu.children("div.menu-item").each(function(){
var _57b=$.extend({},$.parser.parseOptions(this),{selected:($(this).attr("selected")?true:undefined)});
if(_57b.selected){
item=$(this);
return false;
}
});
return _573.menu.menu("getItem",item[0]);
}else{
return null;
}
};
function _578(item){
if(!item){
return;
}
$(_572).textbox("button").menubutton({text:item.text,iconCls:(item.iconCls||null),menu:_573.menu,menuAlign:opts.buttonAlign,plain:false});
_573.searchbox.find("input.textbox-value").attr("name",item.name||item.text);
$(_572).searchbox("resize");
};
};
$.fn.searchbox=function(_57c,_57d){
if(typeof _57c=="string"){
var _57e=$.fn.searchbox.methods[_57c];
if(_57e){
return _57e(this,_57d);
}else{
return this.textbox(_57c,_57d);
}
}
_57c=_57c||{};
return this.each(function(){
var _57f=$.data(this,"searchbox");
if(_57f){
$.extend(_57f.options,_57c);
}else{
$.data(this,"searchbox",{options:$.extend({},$.fn.searchbox.defaults,$.fn.searchbox.parseOptions(this),_57c)});
}
_571(this);
});
};
$.fn.searchbox.methods={options:function(jq){
var opts=jq.textbox("options");
return $.extend($.data(jq[0],"searchbox").options,{width:opts.width,value:opts.value,originalValue:opts.originalValue,disabled:opts.disabled,readonly:opts.readonly});
},menu:function(jq){
return $.data(jq[0],"searchbox").menu;
},getName:function(jq){
return $.data(jq[0],"searchbox").searchbox.find("input.textbox-value").attr("name");
},selectName:function(jq,name){
return jq.each(function(){
var menu=$.data(this,"searchbox").menu;
if(menu){
menu.children("div.menu-item").each(function(){
var item=menu.menu("getItem",this);
if(item.name==name){
$(this).triggerHandler("click");
return false;
}
});
}
});
},destroy:function(jq){
return jq.each(function(){
var menu=$(this).searchbox("menu");
if(menu){
menu.menu("destroy");
}
$(this).textbox("destroy");
});
}};
$.fn.searchbox.parseOptions=function(_580){
var t=$(_580);
return $.extend({},$.fn.textbox.parseOptions(_580),$.parser.parseOptions(_580,["menu"]),{searcher:(t.attr("searcher")?eval(t.attr("searcher")):undefined)});
};
$.fn.searchbox.defaults=$.extend({},$.fn.textbox.defaults,{inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{keydown:function(e){
if(e.keyCode==13){
e.preventDefault();
var t=$(e.data.target);
var opts=t.searchbox("options");
t.searchbox("setValue",$(this).val());
opts.searcher.call(e.data.target,t.searchbox("getValue"),t.searchbox("getName"));
return false;
}
}}),buttonAlign:"left",menu:null,searcher:function(_581,name){
}});
})(jQuery);
(function($){
function _582(_583,_584){
var opts=$.data(_583,"form").options;
$.extend(opts,_584||{});
var _585=$.extend({},opts.queryParams);
if(opts.onSubmit.call(_583,_585)==false){
return;
}
var _586=$(_583).find(".textbox-text:focus");
_586.triggerHandler("blur");
_586.focus();
var _587=null;
if(opts.dirty){
var ff=[];
$.map(opts.dirtyFields,function(f){
if($(f).hasClass("textbox-f")){
$(f).next().find(".textbox-value").each(function(){
ff.push(this);
});
}else{
ff.push(f);
}
});
_587=$(_583).find("input[name]:enabled,textarea[name]:enabled,select[name]:enabled").filter(function(){
return $.inArray(this,ff)==-1;
});
_587.attr("disabled","disabled");
}
if(opts.ajax){
if(opts.iframe){
_588(_583,_585);
}else{
if(window.FormData!==undefined){
_589(_583,_585);
}else{
_588(_583,_585);
}
}
}else{
$(_583).submit();
}
if(opts.dirty){
_587.removeAttr("disabled");
}
};
function _588(_58a,_58b){
var opts=$.data(_58a,"form").options;
var _58c="easyui_frame_"+(new Date().getTime());
var _58d=$("<iframe id="+_58c+" name="+_58c+"></iframe>").appendTo("body");
_58d.attr("src",window.ActiveXObject?"javascript:false":"about:blank");
_58d.css({position:"absolute",top:-1000,left:-1000});
_58d.bind("load",cb);
_58e(_58b);
function _58e(_58f){
var form=$(_58a);
if(opts.url){
form.attr("action",opts.url);
}
var t=form.attr("target"),a=form.attr("action");
form.attr("target",_58c);
var _590=$();
try{
for(var n in _58f){
var _591=$("<input type=\"hidden\" name=\""+n+"\">").val(_58f[n]).appendTo(form);
_590=_590.add(_591);
}
_592();
form[0].submit();
}
finally{
form.attr("action",a);
t?form.attr("target",t):form.removeAttr("target");
_590.remove();
}
};
function _592(){
var f=$("#"+_58c);
if(!f.length){
return;
}
try{
var s=f.contents()[0].readyState;
if(s&&s.toLowerCase()=="uninitialized"){
setTimeout(_592,100);
}
}
catch(e){
cb();
}
};
var _593=10;
function cb(){
var f=$("#"+_58c);
if(!f.length){
return;
}
f.unbind();
var data="";
try{
var body=f.contents().find("body");
data=body.html();
if(data==""){
if(--_593){
setTimeout(cb,100);
return;
}
}
var ta=body.find(">textarea");
if(ta.length){
data=ta.val();
}else{
var pre=body.find(">pre");
if(pre.length){
data=pre.html();
}
}
}
catch(e){
}
opts.success.call(_58a,data);
setTimeout(function(){
f.unbind();
f.remove();
},100);
};
};
function _589(_594,_595){
var opts=$.data(_594,"form").options;
var _596=new FormData($(_594)[0]);
for(var name in _595){
_596.append(name,_595[name]);
}
$.ajax({url:opts.url,type:"post",xhr:function(){
var xhr=$.ajaxSettings.xhr();
if(xhr.upload){
xhr.upload.addEventListener("progress",function(e){
if(e.lengthComputable){
var _597=e.total;
var _598=e.loaded||e.position;
var _599=Math.ceil(_598*100/_597);
opts.onProgress.call(_594,_599);
}
},false);
}
return xhr;
},data:_596,dataType:"html",cache:false,contentType:false,processData:false,complete:function(res){
opts.success.call(_594,res.responseText);
}});
};
function load(_59a,data){
var opts=$.data(_59a,"form").options;
if(typeof data=="string"){
var _59b={};
if(opts.onBeforeLoad.call(_59a,_59b)==false){
return;
}
$.ajax({url:data,data:_59b,dataType:"json",success:function(data){
_59c(data);
},error:function(){
opts.onLoadError.apply(_59a,arguments);
}});
}else{
_59c(data);
}
function _59c(data){
var form=$(_59a);
for(var name in data){
var val=data[name];
if(!_59d(name,val)){
if(!_59e(name,val)){
form.find("input[name=\""+name+"\"]").val(val);
form.find("textarea[name=\""+name+"\"]").val(val);
form.find("select[name=\""+name+"\"]").val(val);
}
}
}
opts.onLoadSuccess.call(_59a,data);
form.form("validate");
};
function _59d(name,val){
var cc=$(_59a).find("[switchbuttonName=\""+name+"\"]");
if(cc.length){
cc.switchbutton("uncheck");
cc.each(function(){
if(_59f($(this).switchbutton("options").value,val)){
$(this).switchbutton("check");
}
});
return true;
}
cc=$(_59a).find("input[name=\""+name+"\"][type=radio], input[name=\""+name+"\"][type=checkbox]");
if(cc.length){
cc._propAttr("checked",false);
cc.each(function(){
if(_59f($(this).val(),val)){
$(this)._propAttr("checked",true);
}
});
return true;
}
return false;
};
function _59f(v,val){
if(v==String(val)||$.inArray(v,$.isArray(val)?val:[val])>=0){
return true;
}else{
return false;
}
};
function _59e(name,val){
var _5a0=$(_59a).find("[textboxName=\""+name+"\"],[sliderName=\""+name+"\"]");
if(_5a0.length){
for(var i=0;i<opts.fieldTypes.length;i++){
var type=opts.fieldTypes[i];
var _5a1=_5a0.data(type);
if(_5a1){
if(_5a1.options.multiple||_5a1.options.range){
_5a0[type]("setValues",val);
}else{
_5a0[type]("setValue",val);
}
return true;
}
}
}
return false;
};
};
function _5a2(_5a3){
$("input,select,textarea",_5a3).each(function(){
if($(this).hasClass("textbox-value")){
return;
}
var t=this.type,tag=this.tagName.toLowerCase();
if(t=="text"||t=="hidden"||t=="password"||tag=="textarea"){
this.value="";
}else{
if(t=="file"){
var file=$(this);
if(!file.hasClass("textbox-value")){
var _5a4=file.clone().val("");
_5a4.insertAfter(file);
if(file.data("validatebox")){
file.validatebox("destroy");
_5a4.validatebox();
}else{
file.remove();
}
}
}else{
if(t=="checkbox"||t=="radio"){
this.checked=false;
}else{
if(tag=="select"){
this.selectedIndex=-1;
}
}
}
}
});
var tmp=$();
var form=$(_5a3);
var opts=$.data(_5a3,"form").options;
for(var i=0;i<opts.fieldTypes.length;i++){
var type=opts.fieldTypes[i];
var _5a5=form.find("."+type+"-f").not(tmp);
if(_5a5.length&&_5a5[type]){
_5a5[type]("clear");
tmp=tmp.add(_5a5);
}
}
form.form("validate");
};
function _5a6(_5a7){
_5a7.reset();
var form=$(_5a7);
var opts=$.data(_5a7,"form").options;
for(var i=opts.fieldTypes.length-1;i>=0;i--){
var type=opts.fieldTypes[i];
var _5a8=form.find("."+type+"-f");
if(_5a8.length&&_5a8[type]){
_5a8[type]("reset");
}
}
form.form("validate");
};
function _5a9(_5aa){
var _5ab=$.data(_5aa,"form").options;
$(_5aa).unbind(".form");
if(_5ab.ajax){
$(_5aa).bind("submit.form",function(){
setTimeout(function(){
_582(_5aa,_5ab);
},0);
return false;
});
}
$(_5aa).bind("_change.form",function(e,t){
if($.inArray(t,_5ab.dirtyFields)==-1){
_5ab.dirtyFields.push(t);
}
_5ab.onChange.call(this,t);
}).bind("change.form",function(e){
var t=e.target;
if(!$(t).hasClass("textbox-text")){
if($.inArray(t,_5ab.dirtyFields)==-1){
_5ab.dirtyFields.push(t);
}
_5ab.onChange.call(this,t);
}
});
_5ac(_5aa,_5ab.novalidate);
};
function _5ad(_5ae,_5af){
_5af=_5af||{};
var _5b0=$.data(_5ae,"form");
if(_5b0){
$.extend(_5b0.options,_5af);
}else{
$.data(_5ae,"form",{options:$.extend({},$.fn.form.defaults,$.fn.form.parseOptions(_5ae),_5af)});
}
};
function _5b1(_5b2){
if($.fn.validatebox){
var t=$(_5b2);
t.find(".validatebox-text:not(:disabled)").validatebox("validate");
var _5b3=t.find(".validatebox-invalid");
_5b3.filter(":not(:disabled):first").focus();
return _5b3.length==0;
}
return true;
};
function _5ac(_5b4,_5b5){
var opts=$.data(_5b4,"form").options;
opts.novalidate=_5b5;
$(_5b4).find(".validatebox-text:not(:disabled)").validatebox(_5b5?"disableValidation":"enableValidation");
};
$.fn.form=function(_5b6,_5b7){
if(typeof _5b6=="string"){
this.each(function(){
_5ad(this);
});
return $.fn.form.methods[_5b6](this,_5b7);
}
return this.each(function(){
_5ad(this,_5b6);
_5a9(this);
});
};
$.fn.form.methods={options:function(jq){
return $.data(jq[0],"form").options;
},submit:function(jq,_5b8){
return jq.each(function(){
_582(this,_5b8);
});
},load:function(jq,data){
return jq.each(function(){
load(this,data);
});
},clear:function(jq){
return jq.each(function(){
_5a2(this);
});
},reset:function(jq){
return jq.each(function(){
_5a6(this);
});
},validate:function(jq){
return _5b1(jq[0]);
},disableValidation:function(jq){
return jq.each(function(){
_5ac(this,true);
});
},enableValidation:function(jq){
return jq.each(function(){
_5ac(this,false);
});
},resetValidation:function(jq){
return jq.each(function(){
$(this).find(".validatebox-text:not(:disabled)").validatebox("resetValidation");
});
},resetDirty:function(jq){
return jq.each(function(){
$(this).form("options").dirtyFields=[];
});
}};
$.fn.form.parseOptions=function(_5b9){
var t=$(_5b9);
return $.extend({},$.parser.parseOptions(_5b9,[{ajax:"boolean",dirty:"boolean"}]),{url:(t.attr("action")?t.attr("action"):undefined)});
};
$.fn.form.defaults={fieldTypes:["combobox","combotree","combogrid","combotreegrid","datetimebox","datebox","combo","datetimespinner","timespinner","numberspinner","spinner","slider","searchbox","numberbox","passwordbox","filebox","textbox","switchbutton"],novalidate:false,ajax:true,iframe:true,dirty:false,dirtyFields:[],url:null,queryParams:{},onSubmit:function(_5ba){
return $(this).form("validate");
},onProgress:function(_5bb){
},success:function(data){
},onBeforeLoad:function(_5bc){
},onLoadSuccess:function(data){
},onLoadError:function(){
},onChange:function(_5bd){
}};
})(jQuery);
(function($){
function _5be(_5bf){
var _5c0=$.data(_5bf,"numberbox");
var opts=_5c0.options;
$(_5bf).addClass("numberbox-f").textbox(opts);
$(_5bf).textbox("textbox").css({imeMode:"disabled"});
$(_5bf).attr("numberboxName",$(_5bf).attr("textboxName"));
_5c0.numberbox=$(_5bf).next();
_5c0.numberbox.addClass("numberbox");
var _5c1=opts.parser.call(_5bf,opts.value);
var _5c2=opts.formatter.call(_5bf,_5c1);
$(_5bf).numberbox("initValue",_5c1).numberbox("setText",_5c2);
};
function _5c3(_5c4,_5c5){
var _5c6=$.data(_5c4,"numberbox");
var opts=_5c6.options;
opts.value=parseFloat(_5c5);
var _5c5=opts.parser.call(_5c4,_5c5);
var text=opts.formatter.call(_5c4,_5c5);
opts.value=_5c5;
$(_5c4).textbox("setText",text).textbox("setValue",_5c5);
text=opts.formatter.call(_5c4,$(_5c4).textbox("getValue"));
$(_5c4).textbox("setText",text);
};
$.fn.numberbox=function(_5c7,_5c8){
if(typeof _5c7=="string"){
var _5c9=$.fn.numberbox.methods[_5c7];
if(_5c9){
return _5c9(this,_5c8);
}else{
return this.textbox(_5c7,_5c8);
}
}
_5c7=_5c7||{};
return this.each(function(){
var _5ca=$.data(this,"numberbox");
if(_5ca){
$.extend(_5ca.options,_5c7);
}else{
_5ca=$.data(this,"numberbox",{options:$.extend({},$.fn.numberbox.defaults,$.fn.numberbox.parseOptions(this),_5c7)});
}
_5be(this);
});
};
$.fn.numberbox.methods={options:function(jq){
var opts=jq.data("textbox")?jq.textbox("options"):{};
return $.extend($.data(jq[0],"numberbox").options,{width:opts.width,originalValue:opts.originalValue,disabled:opts.disabled,readonly:opts.readonly});
},fix:function(jq){
return jq.each(function(){
var opts=$(this).numberbox("options");
opts.value=null;
var _5cb=opts.parser.call(this,$(this).numberbox("getText"));
$(this).numberbox("setValue",_5cb);
});
},setValue:function(jq,_5cc){
return jq.each(function(){
_5c3(this,_5cc);
});
},clear:function(jq){
return jq.each(function(){
$(this).textbox("clear");
$(this).numberbox("options").value="";
});
},reset:function(jq){
return jq.each(function(){
$(this).textbox("reset");
$(this).numberbox("setValue",$(this).numberbox("getValue"));
});
}};
$.fn.numberbox.parseOptions=function(_5cd){
var t=$(_5cd);
return $.extend({},$.fn.textbox.parseOptions(_5cd),$.parser.parseOptions(_5cd,["decimalSeparator","groupSeparator","suffix",{min:"number",max:"number",precision:"number"}]),{prefix:(t.attr("prefix")?t.attr("prefix"):undefined)});
};
$.fn.numberbox.defaults=$.extend({},$.fn.textbox.defaults,{inputEvents:{keypress:function(e){
var _5ce=e.data.target;
var opts=$(_5ce).numberbox("options");
return opts.filter.call(_5ce,e);
},blur:function(e){
$(e.data.target).numberbox("fix");
},keydown:function(e){
if(e.keyCode==13){
$(e.data.target).numberbox("fix");
}
}},min:null,max:null,precision:0,decimalSeparator:".",groupSeparator:"",prefix:"",suffix:"",filter:function(e){
var opts=$(this).numberbox("options");
var s=$(this).numberbox("getText");
if(e.metaKey||e.ctrlKey){
return true;
}
if($.inArray(String(e.which),["46","8","13","0"])>=0){
return true;
}
var tmp=$("<span></span>");
tmp.html(String.fromCharCode(e.which));
var c=tmp.text();
tmp.remove();
if(!c){
return true;
}
if(c=="-"||c==opts.decimalSeparator){
return (s.indexOf(c)==-1)?true:false;
}else{
if(c==opts.groupSeparator){
return true;
}else{
if("0123456789".indexOf(c)>=0){
return true;
}else{
return false;
}
}
}
},formatter:function(_5cf){
if(!_5cf){
return _5cf;
}
_5cf=_5cf+"";
var opts=$(this).numberbox("options");
var s1=_5cf,s2="";
var dpos=_5cf.indexOf(".");
if(dpos>=0){
s1=_5cf.substring(0,dpos);
s2=_5cf.substring(dpos+1,_5cf.length);
}
if(opts.groupSeparator){
var p=/(\d+)(\d{3})/;
while(p.test(s1)){
s1=s1.replace(p,"$1"+opts.groupSeparator+"$2");
}
}
if(s2){
return opts.prefix+s1+opts.decimalSeparator+s2+opts.suffix;
}else{
return opts.prefix+s1+opts.suffix;
}
},parser:function(s){
s=s+"";
var opts=$(this).numberbox("options");
if(opts.prefix){
s=$.trim(s.replace(new RegExp("\\"+$.trim(opts.prefix),"g"),""));
}
if(opts.suffix){
s=$.trim(s.replace(new RegExp("\\"+$.trim(opts.suffix),"g"),""));
}
if(parseFloat(s)!=opts.value){
if(opts.groupSeparator){
s=$.trim(s.replace(new RegExp("\\"+opts.groupSeparator,"g"),""));
}
if(opts.decimalSeparator){
s=$.trim(s.replace(new RegExp("\\"+opts.decimalSeparator,"g"),"."));
}
s=s.replace(/\s/g,"");
}
var val=parseFloat(s).toFixed(opts.precision);
if(isNaN(val)){
val="";
}else{
if(typeof (opts.min)=="number"&&val<opts.min){
val=opts.min.toFixed(opts.precision);
}else{
if(typeof (opts.max)=="number"&&val>opts.max){
val=opts.max.toFixed(opts.precision);
}
}
}
return val;
}});
})(jQuery);
(function($){
function _5d0(_5d1,_5d2){
var opts=$.data(_5d1,"calendar").options;
var t=$(_5d1);
if(_5d2){
$.extend(opts,{width:_5d2.width,height:_5d2.height});
}
t._size(opts,t.parent());
t.find(".calendar-body")._outerHeight(t.height()-t.find(".calendar-header")._outerHeight());
if(t.find(".calendar-menu").is(":visible")){
_5d3(_5d1);
}
};
function init(_5d4){
$(_5d4).addClass("calendar").html("<div class=\"calendar-header\">"+"<div class=\"calendar-nav calendar-prevmonth\"></div>"+"<div class=\"calendar-nav calendar-nextmonth\"></div>"+"<div class=\"calendar-nav calendar-prevyear\"></div>"+"<div class=\"calendar-nav calendar-nextyear\"></div>"+"<div class=\"calendar-title\">"+"<span class=\"calendar-text\"></span>"+"</div>"+"</div>"+"<div class=\"calendar-body\">"+"<div class=\"calendar-menu\">"+"<div class=\"calendar-menu-year-inner\">"+"<span class=\"calendar-nav calendar-menu-prev\"></span>"+"<span><input class=\"calendar-menu-year\" type=\"text\"></input></span>"+"<span class=\"calendar-nav calendar-menu-next\"></span>"+"</div>"+"<div class=\"calendar-menu-month-inner\">"+"</div>"+"</div>"+"</div>");
$(_5d4).bind("_resize",function(e,_5d5){
if($(this).hasClass("easyui-fluid")||_5d5){
_5d0(_5d4);
}
return false;
});
};
function _5d6(_5d7){
var opts=$.data(_5d7,"calendar").options;
var menu=$(_5d7).find(".calendar-menu");
menu.find(".calendar-menu-year").unbind(".calendar").bind("keypress.calendar",function(e){
if(e.keyCode==13){
_5d8(true);
}
});
$(_5d7).unbind(".calendar").bind("mouseover.calendar",function(e){
var t=_5d9(e.target);
if(t.hasClass("calendar-nav")||t.hasClass("calendar-text")||(t.hasClass("calendar-day")&&!t.hasClass("calendar-disabled"))){
t.addClass("calendar-nav-hover");
}
}).bind("mouseout.calendar",function(e){
var t=_5d9(e.target);
if(t.hasClass("calendar-nav")||t.hasClass("calendar-text")||(t.hasClass("calendar-day")&&!t.hasClass("calendar-disabled"))){
t.removeClass("calendar-nav-hover");
}
}).bind("click.calendar",function(e){
var t=_5d9(e.target);
if(t.hasClass("calendar-menu-next")||t.hasClass("calendar-nextyear")){
_5da(1);
}else{
if(t.hasClass("calendar-menu-prev")||t.hasClass("calendar-prevyear")){
_5da(-1);
}else{
if(t.hasClass("calendar-menu-month")){
menu.find(".calendar-selected").removeClass("calendar-selected");
t.addClass("calendar-selected");
_5d8(true);
}else{
if(t.hasClass("calendar-prevmonth")){
_5db(-1);
}else{
if(t.hasClass("calendar-nextmonth")){
_5db(1);
}else{
if(t.hasClass("calendar-text")){
if(menu.is(":visible")){
menu.hide();
}else{
_5d3(_5d7);
}
}else{
if(t.hasClass("calendar-day")){
if(t.hasClass("calendar-disabled")){
return;
}
var _5dc=opts.current;
t.closest("div.calendar-body").find(".calendar-selected").removeClass("calendar-selected");
t.addClass("calendar-selected");
var _5dd=t.attr("abbr").split(",");
var y=parseInt(_5dd[0]);
var m=parseInt(_5dd[1]);
var d=parseInt(_5dd[2]);
opts.current=new Date(y,m-1,d);
opts.onSelect.call(_5d7,opts.current);
if(!_5dc||_5dc.getTime()!=opts.current.getTime()){
opts.onChange.call(_5d7,opts.current,_5dc);
}
if(opts.year!=y||opts.month!=m){
opts.year=y;
opts.month=m;
show(_5d7);
}
}
}
}
}
}
}
}
});
function _5d9(t){
var day=$(t).closest(".calendar-day");
if(day.length){
return day;
}else{
return $(t);
}
};
function _5d8(_5de){
var menu=$(_5d7).find(".calendar-menu");
var year=menu.find(".calendar-menu-year").val();
var _5df=menu.find(".calendar-selected").attr("abbr");
if(!isNaN(year)){
opts.year=parseInt(year);
opts.month=parseInt(_5df);
show(_5d7);
}
if(_5de){
menu.hide();
}
};
function _5da(_5e0){
opts.year+=_5e0;
show(_5d7);
menu.find(".calendar-menu-year").val(opts.year);
};
function _5db(_5e1){
opts.month+=_5e1;
if(opts.month>12){
opts.year++;
opts.month=1;
}else{
if(opts.month<1){
opts.year--;
opts.month=12;
}
}
show(_5d7);
menu.find("td.calendar-selected").removeClass("calendar-selected");
menu.find("td:eq("+(opts.month-1)+")").addClass("calendar-selected");
};
};
function _5d3(_5e2){
var opts=$.data(_5e2,"calendar").options;
$(_5e2).find(".calendar-menu").show();
if($(_5e2).find(".calendar-menu-month-inner").is(":empty")){
$(_5e2).find(".calendar-menu-month-inner").empty();
var t=$("<table class=\"calendar-mtable\"></table>").appendTo($(_5e2).find(".calendar-menu-month-inner"));
var idx=0;
for(var i=0;i<3;i++){
var tr=$("<tr></tr>").appendTo(t);
for(var j=0;j<4;j++){
$("<td class=\"calendar-nav calendar-menu-month\"></td>").html(opts.months[idx++]).attr("abbr",idx).appendTo(tr);
}
}
}
var body=$(_5e2).find(".calendar-body");
var sele=$(_5e2).find(".calendar-menu");
var _5e3=sele.find(".calendar-menu-year-inner");
var _5e4=sele.find(".calendar-menu-month-inner");
_5e3.find("input").val(opts.year).focus();
_5e4.find("td.calendar-selected").removeClass("calendar-selected");
_5e4.find("td:eq("+(opts.month-1)+")").addClass("calendar-selected");
sele._outerWidth(body._outerWidth());
sele._outerHeight(body._outerHeight());
_5e4._outerHeight(sele.height()-_5e3._outerHeight());
};
function _5e5(_5e6,year,_5e7){
var opts=$.data(_5e6,"calendar").options;
var _5e8=[];
var _5e9=new Date(year,_5e7,0).getDate();
for(var i=1;i<=_5e9;i++){
_5e8.push([year,_5e7,i]);
}
var _5ea=[],week=[];
var _5eb=-1;
while(_5e8.length>0){
var date=_5e8.shift();
week.push(date);
var day=new Date(date[0],date[1]-1,date[2]).getDay();
if(_5eb==day){
day=0;
}else{
if(day==(opts.firstDay==0?7:opts.firstDay)-1){
_5ea.push(week);
week=[];
}
}
_5eb=day;
}
if(week.length){
_5ea.push(week);
}
var _5ec=_5ea[0];
if(_5ec.length<7){
while(_5ec.length<7){
var _5ed=_5ec[0];
var date=new Date(_5ed[0],_5ed[1]-1,_5ed[2]-1);
_5ec.unshift([date.getFullYear(),date.getMonth()+1,date.getDate()]);
}
}else{
var _5ed=_5ec[0];
var week=[];
for(var i=1;i<=7;i++){
var date=new Date(_5ed[0],_5ed[1]-1,_5ed[2]-i);
week.unshift([date.getFullYear(),date.getMonth()+1,date.getDate()]);
}
_5ea.unshift(week);
}
var _5ee=_5ea[_5ea.length-1];
while(_5ee.length<7){
var _5ef=_5ee[_5ee.length-1];
var date=new Date(_5ef[0],_5ef[1]-1,_5ef[2]+1);
_5ee.push([date.getFullYear(),date.getMonth()+1,date.getDate()]);
}
if(_5ea.length<6){
var _5ef=_5ee[_5ee.length-1];
var week=[];
for(var i=1;i<=7;i++){
var date=new Date(_5ef[0],_5ef[1]-1,_5ef[2]+i);
week.push([date.getFullYear(),date.getMonth()+1,date.getDate()]);
}
_5ea.push(week);
}
return _5ea;
};
function show(_5f0){
var opts=$.data(_5f0,"calendar").options;
if(opts.current&&!opts.validator.call(_5f0,opts.current)){
opts.current=null;
}
var now=new Date();
var _5f1=now.getFullYear()+","+(now.getMonth()+1)+","+now.getDate();
var _5f2=opts.current?(opts.current.getFullYear()+","+(opts.current.getMonth()+1)+","+opts.current.getDate()):"";
var _5f3=6-opts.firstDay;
var _5f4=_5f3+1;
if(_5f3>=7){
_5f3-=7;
}
if(_5f4>=7){
_5f4-=7;
}
$(_5f0).find(".calendar-title span").html(opts.months[opts.month-1]+" "+opts.year);
var body=$(_5f0).find("div.calendar-body");
body.children("table").remove();
var data=["<table class=\"calendar-dtable\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">"];
data.push("<thead><tr>");
if(opts.showWeek){
data.push("<th class=\"calendar-week\">"+opts.weekNumberHeader+"</th>");
}
for(var i=opts.firstDay;i<opts.weeks.length;i++){
data.push("<th>"+opts.weeks[i]+"</th>");
}
for(var i=0;i<opts.firstDay;i++){
data.push("<th>"+opts.weeks[i]+"</th>");
}
data.push("</tr></thead>");
data.push("<tbody>");
var _5f5=_5e5(_5f0,opts.year,opts.month);
for(var i=0;i<_5f5.length;i++){
var week=_5f5[i];
var cls="";
if(i==0){
cls="calendar-first";
}else{
if(i==_5f5.length-1){
cls="calendar-last";
}
}
data.push("<tr class=\""+cls+"\">");
if(opts.showWeek){
var _5f6=opts.getWeekNumber(new Date(week[0][0],parseInt(week[0][1])-1,week[0][2]));
data.push("<td class=\"calendar-week\">"+_5f6+"</td>");
}
for(var j=0;j<week.length;j++){
var day=week[j];
var s=day[0]+","+day[1]+","+day[2];
var _5f7=new Date(day[0],parseInt(day[1])-1,day[2]);
var d=opts.formatter.call(_5f0,_5f7);
var css=opts.styler.call(_5f0,_5f7);
var _5f8="";
var _5f9="";
if(typeof css=="string"){
_5f9=css;
}else{
if(css){
_5f8=css["class"]||"";
_5f9=css["style"]||"";
}
}
var cls="calendar-day";
if(!(opts.year==day[0]&&opts.month==day[1])){
cls+=" calendar-other-month";
}
if(s==_5f1){
cls+=" calendar-today";
}
if(s==_5f2){
cls+=" calendar-selected";
}
if(j==_5f3){
cls+=" calendar-saturday";
}else{
if(j==_5f4){
cls+=" calendar-sunday";
}
}
if(j==0){
cls+=" calendar-first";
}else{
if(j==week.length-1){
cls+=" calendar-last";
}
}
cls+=" "+_5f8;
if(!opts.validator.call(_5f0,_5f7)){
cls+=" calendar-disabled";
}
data.push("<td class=\""+cls+"\" abbr=\""+s+"\" style=\""+_5f9+"\">"+d+"</td>");
}
data.push("</tr>");
}
data.push("</tbody>");
data.push("</table>");
body.append(data.join(""));
body.children("table.calendar-dtable").prependTo(body);
opts.onNavigate.call(_5f0,opts.year,opts.month);
};
$.fn.calendar=function(_5fa,_5fb){
if(typeof _5fa=="string"){
return $.fn.calendar.methods[_5fa](this,_5fb);
}
_5fa=_5fa||{};
return this.each(function(){
var _5fc=$.data(this,"calendar");
if(_5fc){
$.extend(_5fc.options,_5fa);
}else{
_5fc=$.data(this,"calendar",{options:$.extend({},$.fn.calendar.defaults,$.fn.calendar.parseOptions(this),_5fa)});
init(this);
}
if(_5fc.options.border==false){
$(this).addClass("calendar-noborder");
}
_5d0(this);
_5d6(this);
show(this);
$(this).find("div.calendar-menu").hide();
});
};
$.fn.calendar.methods={options:function(jq){
return $.data(jq[0],"calendar").options;
},resize:function(jq,_5fd){
return jq.each(function(){
_5d0(this,_5fd);
});
},moveTo:function(jq,date){
return jq.each(function(){
if(!date){
var now=new Date();
$(this).calendar({year:now.getFullYear(),month:now.getMonth()+1,current:date});
return;
}
var opts=$(this).calendar("options");
if(opts.validator.call(this,date)){
var _5fe=opts.current;
$(this).calendar({year:date.getFullYear(),month:date.getMonth()+1,current:date});
if(!_5fe||_5fe.getTime()!=date.getTime()){
opts.onChange.call(this,opts.current,_5fe);
}
}
});
}};
$.fn.calendar.parseOptions=function(_5ff){
var t=$(_5ff);
return $.extend({},$.parser.parseOptions(_5ff,["weekNumberHeader",{firstDay:"number",fit:"boolean",border:"boolean",showWeek:"boolean"}]));
};
$.fn.calendar.defaults={width:180,height:180,fit:false,border:true,showWeek:false,firstDay:0,weeks:["S","M","T","W","T","F","S"],months:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],year:new Date().getFullYear(),month:new Date().getMonth()+1,current:(function(){
var d=new Date();
return new Date(d.getFullYear(),d.getMonth(),d.getDate());
})(),weekNumberHeader:"",getWeekNumber:function(date){
var _600=new Date(date.getTime());
_600.setDate(_600.getDate()+4-(_600.getDay()||7));
var time=_600.getTime();
_600.setMonth(0);
_600.setDate(1);
return Math.floor(Math.round((time-_600)/86400000)/7)+1;
},formatter:function(date){
return date.getDate();
},styler:function(date){
return "";
},validator:function(date){
return true;
},onSelect:function(date){
},onChange:function(_601,_602){
},onNavigate:function(year,_603){
}};
})(jQuery);
(function($){
function _604(_605){
var _606=$.data(_605,"spinner");
var opts=_606.options;
var _607=$.extend(true,[],opts.icons);
if(opts.spinAlign=="left"||opts.spinAlign=="right"){
opts.spinArrow=true;
opts.iconAlign=opts.spinAlign;
var _608={iconCls:"spinner-arrow",handler:function(e){
var spin=$(e.target).closest(".spinner-arrow-up,.spinner-arrow-down");
_612(e.data.target,spin.hasClass("spinner-arrow-down"));
}};
if(opts.spinAlign=="left"){
_607.unshift(_608);
}else{
_607.push(_608);
}
}else{
opts.spinArrow=false;
if(opts.spinAlign=="vertical"){
if(opts.buttonAlign!="top"){
opts.buttonAlign="bottom";
}
opts.clsLeft="textbox-button-bottom";
opts.clsRight="textbox-button-top";
}else{
opts.clsLeft="textbox-button-left";
opts.clsRight="textbox-button-right";
}
}
$(_605).addClass("spinner-f").textbox($.extend({},opts,{icons:_607,doSize:false,onResize:function(_609,_60a){
if(!opts.spinArrow){
var span=$(this).next();
var btn=span.find(".textbox-button:not(.spinner-button)");
if(btn.length){
var _60b=btn.outerWidth();
var _60c=btn.outerHeight();
var _60d=span.find(".spinner-button."+opts.clsLeft);
var _60e=span.find(".spinner-button."+opts.clsRight);
if(opts.buttonAlign=="right"){
_60e.css("marginRight",_60b+"px");
}else{
if(opts.buttonAlign=="left"){
_60d.css("marginLeft",_60b+"px");
}else{
if(opts.buttonAlign=="top"){
_60e.css("marginTop",_60c+"px");
}else{
_60d.css("marginBottom",_60c+"px");
}
}
}
}
}
opts.onResize.call(this,_609,_60a);
}}));
$(_605).attr("spinnerName",$(_605).attr("textboxName"));
_606.spinner=$(_605).next();
_606.spinner.addClass("spinner");
if(opts.spinArrow){
var _60f=_606.spinner.find(".spinner-arrow");
_60f.append("<a href=\"javascript:;\" class=\"spinner-arrow-up\" tabindex=\"-1\"></a>");
_60f.append("<a href=\"javascript:;\" class=\"spinner-arrow-down\" tabindex=\"-1\"></a>");
}else{
var _610=$("<a href=\"javascript:;\" class=\"textbox-button spinner-button\"></a>").addClass(opts.clsLeft).appendTo(_606.spinner);
var _611=$("<a href=\"javascript:;\" class=\"textbox-button spinner-button\"></a>").addClass(opts.clsRight).appendTo(_606.spinner);
_610.linkbutton({iconCls:opts.reversed?"spinner-button-up":"spinner-button-down",onClick:function(){
_612(_605,!opts.reversed);
}});
_611.linkbutton({iconCls:opts.reversed?"spinner-button-down":"spinner-button-up",onClick:function(){
_612(_605,opts.reversed);
}});
if(opts.disabled){
$(_605).spinner("disable");
}
if(opts.readonly){
$(_605).spinner("readonly");
}
}
$(_605).spinner("resize");
};
function _612(_613,down){
var opts=$(_613).spinner("options");
opts.spin.call(_613,down);
opts[down?"onSpinDown":"onSpinUp"].call(_613);
$(_613).spinner("validate");
};
$.fn.spinner=function(_614,_615){
if(typeof _614=="string"){
var _616=$.fn.spinner.methods[_614];
if(_616){
return _616(this,_615);
}else{
return this.textbox(_614,_615);
}
}
_614=_614||{};
return this.each(function(){
var _617=$.data(this,"spinner");
if(_617){
$.extend(_617.options,_614);
}else{
_617=$.data(this,"spinner",{options:$.extend({},$.fn.spinner.defaults,$.fn.spinner.parseOptions(this),_614)});
}
_604(this);
});
};
$.fn.spinner.methods={options:function(jq){
var opts=jq.textbox("options");
return $.extend($.data(jq[0],"spinner").options,{width:opts.width,value:opts.value,originalValue:opts.originalValue,disabled:opts.disabled,readonly:opts.readonly});
}};
$.fn.spinner.parseOptions=function(_618){
return $.extend({},$.fn.textbox.parseOptions(_618),$.parser.parseOptions(_618,["min","max","spinAlign",{increment:"number",reversed:"boolean"}]));
};
$.fn.spinner.defaults=$.extend({},$.fn.textbox.defaults,{min:null,max:null,increment:1,spinAlign:"right",reversed:false,spin:function(down){
},onSpinUp:function(){
},onSpinDown:function(){
}});
})(jQuery);
(function($){
function _619(_61a){
$(_61a).addClass("numberspinner-f");
var opts=$.data(_61a,"numberspinner").options;
$(_61a).numberbox($.extend({},opts,{doSize:false})).spinner(opts);
$(_61a).numberbox("setValue",opts.value);
};
function _61b(_61c,down){
var opts=$.data(_61c,"numberspinner").options;
var v=parseFloat($(_61c).numberbox("getValue")||opts.value)||0;
if(down){
v-=opts.increment;
}else{
v+=opts.increment;
}
$(_61c).numberbox("setValue",v);
};
$.fn.numberspinner=function(_61d,_61e){
if(typeof _61d=="string"){
var _61f=$.fn.numberspinner.methods[_61d];
if(_61f){
return _61f(this,_61e);
}else{
return this.numberbox(_61d,_61e);
}
}
_61d=_61d||{};
return this.each(function(){
var _620=$.data(this,"numberspinner");
if(_620){
$.extend(_620.options,_61d);
}else{
$.data(this,"numberspinner",{options:$.extend({},$.fn.numberspinner.defaults,$.fn.numberspinner.parseOptions(this),_61d)});
}
_619(this);
});
};
$.fn.numberspinner.methods={options:function(jq){
var opts=jq.numberbox("options");
return $.extend($.data(jq[0],"numberspinner").options,{width:opts.width,value:opts.value,originalValue:opts.originalValue,disabled:opts.disabled,readonly:opts.readonly});
}};
$.fn.numberspinner.parseOptions=function(_621){
return $.extend({},$.fn.spinner.parseOptions(_621),$.fn.numberbox.parseOptions(_621),{});
};
$.fn.numberspinner.defaults=$.extend({},$.fn.spinner.defaults,$.fn.numberbox.defaults,{spin:function(down){
_61b(this,down);
}});
})(jQuery);
(function($){
function _622(_623){
var opts=$.data(_623,"timespinner").options;
$(_623).addClass("timespinner-f").spinner(opts);
var _624=opts.formatter.call(_623,opts.parser.call(_623,opts.value));
$(_623).timespinner("initValue",_624);
};
function _625(e){
var _626=e.data.target;
var opts=$.data(_626,"timespinner").options;
var _627=$(_626).timespinner("getSelectionStart");
for(var i=0;i<opts.selections.length;i++){
var _628=opts.selections[i];
if(_627>=_628[0]&&_627<=_628[1]){
_629(_626,i);
return;
}
}
};
function _629(_62a,_62b){
var opts=$.data(_62a,"timespinner").options;
if(_62b!=undefined){
opts.highlight=_62b;
}
var _62c=opts.selections[opts.highlight];
if(_62c){
var tb=$(_62a).timespinner("textbox");
$(_62a).timespinner("setSelectionRange",{start:_62c[0],end:_62c[1]});
tb.focus();
}
};
function _62d(_62e,_62f){
var opts=$.data(_62e,"timespinner").options;
var _62f=opts.parser.call(_62e,_62f);
var text=opts.formatter.call(_62e,_62f);
$(_62e).spinner("setValue",text);
};
function _630(_631,down){
var opts=$.data(_631,"timespinner").options;
var s=$(_631).timespinner("getValue");
var _632=opts.selections[opts.highlight];
var s1=s.substring(0,_632[0]);
var s2=s.substring(_632[0],_632[1]);
var s3=s.substring(_632[1]);
var v=s1+((parseInt(s2,10)||0)+opts.increment*(down?-1:1))+s3;
$(_631).timespinner("setValue",v);
_629(_631);
};
$.fn.timespinner=function(_633,_634){
if(typeof _633=="string"){
var _635=$.fn.timespinner.methods[_633];
if(_635){
return _635(this,_634);
}else{
return this.spinner(_633,_634);
}
}
_633=_633||{};
return this.each(function(){
var _636=$.data(this,"timespinner");
if(_636){
$.extend(_636.options,_633);
}else{
$.data(this,"timespinner",{options:$.extend({},$.fn.timespinner.defaults,$.fn.timespinner.parseOptions(this),_633)});
}
_622(this);
});
};
$.fn.timespinner.methods={options:function(jq){
var opts=jq.data("spinner")?jq.spinner("options"):{};
return $.extend($.data(jq[0],"timespinner").options,{width:opts.width,value:opts.value,originalValue:opts.originalValue,disabled:opts.disabled,readonly:opts.readonly});
},setValue:function(jq,_637){
return jq.each(function(){
_62d(this,_637);
});
},getHours:function(jq){
var opts=$.data(jq[0],"timespinner").options;
var vv=jq.timespinner("getValue").split(opts.separator);
return parseInt(vv[0],10);
},getMinutes:function(jq){
var opts=$.data(jq[0],"timespinner").options;
var vv=jq.timespinner("getValue").split(opts.separator);
return parseInt(vv[1],10);
},getSeconds:function(jq){
var opts=$.data(jq[0],"timespinner").options;
var vv=jq.timespinner("getValue").split(opts.separator);
return parseInt(vv[2],10)||0;
}};
$.fn.timespinner.parseOptions=function(_638){
return $.extend({},$.fn.spinner.parseOptions(_638),$.parser.parseOptions(_638,["separator",{showSeconds:"boolean",highlight:"number"}]));
};
$.fn.timespinner.defaults=$.extend({},$.fn.spinner.defaults,{inputEvents:$.extend({},$.fn.spinner.defaults.inputEvents,{click:function(e){
_625.call(this,e);
},blur:function(e){
var t=$(e.data.target);
t.timespinner("setValue",t.timespinner("getText"));
},keydown:function(e){
if(e.keyCode==13){
var t=$(e.data.target);
t.timespinner("setValue",t.timespinner("getText"));
}
}}),formatter:function(date){
if(!date){
return "";
}
var opts=$(this).timespinner("options");
var tt=[_639(date.getHours()),_639(date.getMinutes())];
if(opts.showSeconds){
tt.push(_639(date.getSeconds()));
}
return tt.join(opts.separator);
function _639(_63a){
return (_63a<10?"0":"")+_63a;
};
},parser:function(s){
var opts=$(this).timespinner("options");
var date=_63b(s);
if(date){
var min=_63b(opts.min);
var max=_63b(opts.max);
if(min&&min>date){
date=min;
}
if(max&&max<date){
date=max;
}
}
return date;
function _63b(s){
if(!s){
return null;
}
var tt=s.split(opts.separator);
return new Date(1900,0,0,parseInt(tt[0],10)||0,parseInt(tt[1],10)||0,parseInt(tt[2],10)||0);
};
},selections:[[0,2],[3,5],[6,8]],separator:":",showSeconds:false,highlight:0,spin:function(down){
_630(this,down);
}});
})(jQuery);
(function($){
function _63c(_63d){
var opts=$.data(_63d,"datetimespinner").options;
$(_63d).addClass("datetimespinner-f").timespinner(opts);
};
$.fn.datetimespinner=function(_63e,_63f){
if(typeof _63e=="string"){
var _640=$.fn.datetimespinner.methods[_63e];
if(_640){
return _640(this,_63f);
}else{
return this.timespinner(_63e,_63f);
}
}
_63e=_63e||{};
return this.each(function(){
var _641=$.data(this,"datetimespinner");
if(_641){
$.extend(_641.options,_63e);
}else{
$.data(this,"datetimespinner",{options:$.extend({},$.fn.datetimespinner.defaults,$.fn.datetimespinner.parseOptions(this),_63e)});
}
_63c(this);
});
};
$.fn.datetimespinner.methods={options:function(jq){
var opts=jq.timespinner("options");
return $.extend($.data(jq[0],"datetimespinner").options,{width:opts.width,value:opts.value,originalValue:opts.originalValue,disabled:opts.disabled,readonly:opts.readonly});
}};
$.fn.datetimespinner.parseOptions=function(_642){
return $.extend({},$.fn.timespinner.parseOptions(_642),$.parser.parseOptions(_642,[]));
};
$.fn.datetimespinner.defaults=$.extend({},$.fn.timespinner.defaults,{formatter:function(date){
if(!date){
return "";
}
return $.fn.datebox.defaults.formatter.call(this,date)+" "+$.fn.timespinner.defaults.formatter.call(this,date);
},parser:function(s){
s=$.trim(s);
if(!s){
return null;
}
var dt=s.split(" ");
var _643=$.fn.datebox.defaults.parser.call(this,dt[0]);
if(dt.length<2){
return _643;
}
var _644=$.fn.timespinner.defaults.parser.call(this,dt[1]);
return new Date(_643.getFullYear(),_643.getMonth(),_643.getDate(),_644.getHours(),_644.getMinutes(),_644.getSeconds());
},selections:[[0,2],[3,5],[6,10],[11,13],[14,16],[17,19]]});
})(jQuery);
(function($){
var _645=0;
function _646(a,o){
return $.easyui.indexOfArray(a,o);
};
function _647(a,o,id){
$.easyui.removeArrayItem(a,o,id);
};
function _648(a,o,r){
$.easyui.addArrayItem(a,o,r);
};
function _649(_64a,aa){
return $.data(_64a,"treegrid")?aa.slice(1):aa;
};
function _64b(_64c){
var _64d=$.data(_64c,"datagrid");
var opts=_64d.options;
var _64e=_64d.panel;
var dc=_64d.dc;
var ss=null;
if(opts.sharedStyleSheet){
ss=typeof opts.sharedStyleSheet=="boolean"?"head":opts.sharedStyleSheet;
}else{
ss=_64e.closest("div.datagrid-view");
if(!ss.length){
ss=dc.view;
}
}
var cc=$(ss);
var _64f=$.data(cc[0],"ss");
if(!_64f){
_64f=$.data(cc[0],"ss",{cache:{},dirty:[]});
}
return {add:function(_650){
var ss=["<style type=\"text/css\" easyui=\"true\">"];
for(var i=0;i<_650.length;i++){
_64f.cache[_650[i][0]]={width:_650[i][1]};
}
var _651=0;
for(var s in _64f.cache){
var item=_64f.cache[s];
item.index=_651++;
ss.push(s+"{width:"+item.width+"}");
}
ss.push("</style>");
$(ss.join("\n")).appendTo(cc);
cc.children("style[easyui]:not(:last)").remove();
},getRule:function(_652){
var _653=cc.children("style[easyui]:last")[0];
var _654=_653.styleSheet?_653.styleSheet:(_653.sheet||document.styleSheets[document.styleSheets.length-1]);
var _655=_654.cssRules||_654.rules;
return _655[_652];
},set:function(_656,_657){
var item=_64f.cache[_656];
if(item){
item.width=_657;
var rule=this.getRule(item.index);
if(rule){
rule.style["width"]=_657;
}
}
},remove:function(_658){
var tmp=[];
for(var s in _64f.cache){
if(s.indexOf(_658)==-1){
tmp.push([s,_64f.cache[s].width]);
}
}
_64f.cache={};
this.add(tmp);
},dirty:function(_659){
if(_659){
_64f.dirty.push(_659);
}
},clean:function(){
for(var i=0;i<_64f.dirty.length;i++){
this.remove(_64f.dirty[i]);
}
_64f.dirty=[];
}};
};
function _65a(_65b,_65c){
var _65d=$.data(_65b,"datagrid");
var opts=_65d.options;
var _65e=_65d.panel;
if(_65c){
$.extend(opts,_65c);
}
if(opts.fit==true){
var p=_65e.panel("panel").parent();
opts.width=p.width();
opts.height=p.height();
}
_65e.panel("resize",opts);
};
function _65f(_660){
var _661=$.data(_660,"datagrid");
var opts=_661.options;
var dc=_661.dc;
var wrap=_661.panel;
var _662=wrap.width();
var _663=wrap.height();
var view=dc.view;
var _664=dc.view1;
var _665=dc.view2;
var _666=_664.children("div.datagrid-header");
var _667=_665.children("div.datagrid-header");
var _668=_666.find("table");
var _669=_667.find("table");
view.width(_662);
var _66a=_666.children("div.datagrid-header-inner").show();
_664.width(_66a.find("table").width());
if(!opts.showHeader){
_66a.hide();
}
_665.width(_662-_664._outerWidth());
_664.children()._outerWidth(_664.width());
_665.children()._outerWidth(_665.width());
var all=_666.add(_667).add(_668).add(_669);
all.css("height","");
var hh=Math.max(_668.height(),_669.height());
all._outerHeight(hh);
view.children(".datagrid-empty").css("top",hh+"px");
dc.body1.add(dc.body2).children("table.datagrid-btable-frozen").css({position:"absolute",top:dc.header2._outerHeight()});
var _66b=dc.body2.children("table.datagrid-btable-frozen")._outerHeight();
var _66c=_66b+_667._outerHeight()+_665.children(".datagrid-footer")._outerHeight();
wrap.children(":not(.datagrid-view,.datagrid-mask,.datagrid-mask-msg)").each(function(){
_66c+=$(this)._outerHeight();
});
var _66d=wrap.outerHeight()-wrap.height();
var _66e=wrap._size("minHeight")||"";
var _66f=wrap._size("maxHeight")||"";
_664.add(_665).children("div.datagrid-body").css({marginTop:_66b,height:(isNaN(parseInt(opts.height))?"":(_663-_66c)),minHeight:(_66e?_66e-_66d-_66c:""),maxHeight:(_66f?_66f-_66d-_66c:"")});
view.height(_665.height());
};
function _670(_671,_672,_673){
var rows=$.data(_671,"datagrid").data.rows;
var opts=$.data(_671,"datagrid").options;
var dc=$.data(_671,"datagrid").dc;
if(!dc.body1.is(":empty")&&(!opts.nowrap||opts.autoRowHeight||_673)){
if(_672!=undefined){
var tr1=opts.finder.getTr(_671,_672,"body",1);
var tr2=opts.finder.getTr(_671,_672,"body",2);
_674(tr1,tr2);
}else{
var tr1=opts.finder.getTr(_671,0,"allbody",1);
var tr2=opts.finder.getTr(_671,0,"allbody",2);
_674(tr1,tr2);
if(opts.showFooter){
var tr1=opts.finder.getTr(_671,0,"allfooter",1);
var tr2=opts.finder.getTr(_671,0,"allfooter",2);
_674(tr1,tr2);
}
}
}
_65f(_671);
if(opts.height=="auto"){
var _675=dc.body1.parent();
var _676=dc.body2;
var _677=_678(_676);
var _679=_677.height;
if(_677.width>_676.width()){
_679+=18;
}
_679-=parseInt(_676.css("marginTop"))||0;
_675.height(_679);
_676.height(_679);
dc.view.height(dc.view2.height());
}
dc.body2.triggerHandler("scroll");
function _674(trs1,trs2){
for(var i=0;i<trs2.length;i++){
var tr1=$(trs1[i]);
var tr2=$(trs2[i]);
tr1.css("height","");
tr2.css("height","");
var _67a=Math.max(tr1.height(),tr2.height());
tr1.css("height",_67a);
tr2.css("height",_67a);
}
};
function _678(cc){
var _67b=0;
var _67c=0;
$(cc).children().each(function(){
var c=$(this);
if(c.is(":visible")){
_67c+=c._outerHeight();
if(_67b<c._outerWidth()){
_67b=c._outerWidth();
}
}
});
return {width:_67b,height:_67c};
};
};
function _67d(_67e,_67f){
var _680=$.data(_67e,"datagrid");
var opts=_680.options;
var dc=_680.dc;
if(!dc.body2.children("table.datagrid-btable-frozen").length){
dc.body1.add(dc.body2).prepend("<table class=\"datagrid-btable datagrid-btable-frozen\" cellspacing=\"0\" cellpadding=\"0\"></table>");
}
_681(true);
_681(false);
_65f(_67e);
function _681(_682){
var _683=_682?1:2;
var tr=opts.finder.getTr(_67e,_67f,"body",_683);
(_682?dc.body1:dc.body2).children("table.datagrid-btable-frozen").append(tr);
};
};
function _684(_685,_686){
function _687(){
var _688=[];
var _689=[];
$(_685).children("thead").each(function(){
var opt=$.parser.parseOptions(this,[{frozen:"boolean"}]);
$(this).find("tr").each(function(){
var cols=[];
$(this).find("th").each(function(){
var th=$(this);
var col=$.extend({},$.parser.parseOptions(this,["id","field","align","halign","order","width",{sortable:"boolean",checkbox:"boolean",resizable:"boolean",fixed:"boolean"},{rowspan:"number",colspan:"number"}]),{title:(th.html()||undefined),hidden:(th.attr("hidden")?true:undefined),formatter:(th.attr("formatter")?eval(th.attr("formatter")):undefined),styler:(th.attr("styler")?eval(th.attr("styler")):undefined),sorter:(th.attr("sorter")?eval(th.attr("sorter")):undefined)});
if(col.width&&String(col.width).indexOf("%")==-1){
col.width=parseInt(col.width);
}
if(th.attr("editor")){
var s=$.trim(th.attr("editor"));
if(s.substr(0,1)=="{"){
col.editor=eval("("+s+")");
}else{
col.editor=s;
}
}
cols.push(col);
});
opt.frozen?_688.push(cols):_689.push(cols);
});
});
return [_688,_689];
};
var _68a=$("<div class=\"datagrid-wrap\">"+"<div class=\"datagrid-view\">"+"<div class=\"datagrid-view1\">"+"<div class=\"datagrid-header\">"+"<div class=\"datagrid-header-inner\"></div>"+"</div>"+"<div class=\"datagrid-body\">"+"<div class=\"datagrid-body-inner\"></div>"+"</div>"+"<div class=\"datagrid-footer\">"+"<div class=\"datagrid-footer-inner\"></div>"+"</div>"+"</div>"+"<div class=\"datagrid-view2\">"+"<div class=\"datagrid-header\">"+"<div class=\"datagrid-header-inner\"></div>"+"</div>"+"<div class=\"datagrid-body\"></div>"+"<div class=\"datagrid-footer\">"+"<div class=\"datagrid-footer-inner\"></div>"+"</div>"+"</div>"+"</div>"+"</div>").insertAfter(_685);
_68a.panel({doSize:false,cls:"datagrid"});
$(_685).addClass("datagrid-f").hide().appendTo(_68a.children("div.datagrid-view"));
var cc=_687();
var view=_68a.children("div.datagrid-view");
var _68b=view.children("div.datagrid-view1");
var _68c=view.children("div.datagrid-view2");
return {panel:_68a,frozenColumns:cc[0],columns:cc[1],dc:{view:view,view1:_68b,view2:_68c,header1:_68b.children("div.datagrid-header").children("div.datagrid-header-inner"),header2:_68c.children("div.datagrid-header").children("div.datagrid-header-inner"),body1:_68b.children("div.datagrid-body").children("div.datagrid-body-inner"),body2:_68c.children("div.datagrid-body"),footer1:_68b.children("div.datagrid-footer").children("div.datagrid-footer-inner"),footer2:_68c.children("div.datagrid-footer").children("div.datagrid-footer-inner")}};
};
function _68d(_68e){
var _68f=$.data(_68e,"datagrid");
var opts=_68f.options;
var dc=_68f.dc;
var _690=_68f.panel;
_68f.ss=$(_68e).datagrid("createStyleSheet");
_690.panel($.extend({},opts,{id:null,doSize:false,onResize:function(_691,_692){
if($.data(_68e,"datagrid")){
_65f(_68e);
$(_68e).datagrid("fitColumns");
opts.onResize.call(_690,_691,_692);
}
},onExpand:function(){
if($.data(_68e,"datagrid")){
$(_68e).datagrid("fixRowHeight").datagrid("fitColumns");
opts.onExpand.call(_690);
}
}}));
_68f.rowIdPrefix="datagrid-row-r"+(++_645);
_68f.cellClassPrefix="datagrid-cell-c"+_645;
_693(dc.header1,opts.frozenColumns,true);
_693(dc.header2,opts.columns,false);
_694();
dc.header1.add(dc.header2).css("display",opts.showHeader?"block":"none");
dc.footer1.add(dc.footer2).css("display",opts.showFooter?"block":"none");
if(opts.toolbar){
if($.isArray(opts.toolbar)){
$("div.datagrid-toolbar",_690).remove();
var tb=$("<div class=\"datagrid-toolbar\"><table cellspacing=\"0\" cellpadding=\"0\"><tr></tr></table></div>").prependTo(_690);
var tr=tb.find("tr");
for(var i=0;i<opts.toolbar.length;i++){
var btn=opts.toolbar[i];
if(btn=="-"){
$("<td><div class=\"datagrid-btn-separator\"></div></td>").appendTo(tr);
}else{
var td=$("<td></td>").appendTo(tr);
var tool=$("<a href=\"javascript:;\"></a>").appendTo(td);
tool[0].onclick=eval(btn.handler||function(){
});
tool.linkbutton($.extend({},btn,{plain:true}));
}
}
}else{
$(opts.toolbar).addClass("datagrid-toolbar").prependTo(_690);
$(opts.toolbar).show();
}
}else{
$("div.datagrid-toolbar",_690).remove();
}
$("div.datagrid-pager",_690).remove();
if(opts.pagination){
var _695=$("<div class=\"datagrid-pager\"></div>");
if(opts.pagePosition=="bottom"){
_695.appendTo(_690);
}else{
if(opts.pagePosition=="top"){
_695.addClass("datagrid-pager-top").prependTo(_690);
}else{
var ptop=$("<div class=\"datagrid-pager datagrid-pager-top\"></div>").prependTo(_690);
_695.appendTo(_690);
_695=_695.add(ptop);
}
}
_695.pagination({total:0,pageNumber:opts.pageNumber,pageSize:opts.pageSize,pageList:opts.pageList,onSelectPage:function(_696,_697){
opts.pageNumber=_696||1;
opts.pageSize=_697;
_695.pagination("refresh",{pageNumber:_696,pageSize:_697});
_6df(_68e);
}});
opts.pageSize=_695.pagination("options").pageSize;
}
function _693(_698,_699,_69a){
if(!_699){
return;
}
$(_698).show();
$(_698).empty();
var tmp=$("<div class=\"datagrid-cell\" style=\"position:absolute;left:-99999px\"></div>").appendTo("body");
tmp._outerWidth(99);
var _69b=100-parseInt(tmp[0].style.width);
tmp.remove();
var _69c=[];
var _69d=[];
var _69e=[];
if(opts.sortName){
_69c=opts.sortName.split(",");
_69d=opts.sortOrder.split(",");
}
var t=$("<table class=\"datagrid-htable\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tbody></tbody></table>").appendTo(_698);
for(var i=0;i<_699.length;i++){
var tr=$("<tr class=\"datagrid-header-row\"></tr>").appendTo($("tbody",t));
var cols=_699[i];
for(var j=0;j<cols.length;j++){
var col=cols[j];
var attr="";
if(col.rowspan){
attr+="rowspan=\""+col.rowspan+"\" ";
}
if(col.colspan){
attr+="colspan=\""+col.colspan+"\" ";
if(!col.id){
col.id=["datagrid-td-group"+_645,i,j].join("-");
}
}
if(col.id){
attr+="id=\""+col.id+"\"";
}
var td=$("<td "+attr+"></td>").appendTo(tr);
if(col.checkbox){
td.attr("field",col.field);
$("<div class=\"datagrid-header-check\"></div>").html("<input type=\"checkbox\"/>").appendTo(td);
}else{
if(col.field){
td.attr("field",col.field);
td.append("<div class=\"datagrid-cell\"><span></span><span class=\"datagrid-sort-icon\"></span></div>");
td.find("span:first").html(col.title);
var cell=td.find("div.datagrid-cell");
var pos=_646(_69c,col.field);
if(pos>=0){
cell.addClass("datagrid-sort-"+_69d[pos]);
}
if(col.sortable){
cell.addClass("datagrid-sort");
}
if(col.resizable==false){
cell.attr("resizable","false");
}
if(col.width){
var _69f=$.parser.parseValue("width",col.width,dc.view,opts.scrollbarSize+(opts.rownumbers?opts.rownumberWidth:0));
col.deltaWidth=_69b;
col.boxWidth=_69f-_69b;
}else{
col.auto=true;
}
cell.css("text-align",(col.halign||col.align||""));
col.cellClass=_68f.cellClassPrefix+"-"+col.field.replace(/[\.|\s]/g,"-");
cell.addClass(col.cellClass);
}else{
$("<div class=\"datagrid-cell-group\"></div>").html(col.title).appendTo(td);
}
}
if(col.hidden){
td.hide();
_69e.push(col.field);
}
}
}
if(_69a&&opts.rownumbers){
var td=$("<td rowspan=\""+opts.frozenColumns.length+"\"><div class=\"datagrid-header-rownumber\"></div></td>");
if($("tr",t).length==0){
td.wrap("<tr class=\"datagrid-header-row\"></tr>").parent().appendTo($("tbody",t));
}else{
td.prependTo($("tr:first",t));
}
}
for(var i=0;i<_69e.length;i++){
_6e1(_68e,_69e[i],-1);
}
};
function _694(){
var _6a0=[[".datagrid-header-rownumber",(opts.rownumberWidth-1)+"px"],[".datagrid-cell-rownumber",(opts.rownumberWidth-1)+"px"]];
var _6a1=_6a2(_68e,true).concat(_6a2(_68e));
for(var i=0;i<_6a1.length;i++){
var col=_6a3(_68e,_6a1[i]);
if(col&&!col.checkbox){
_6a0.push(["."+col.cellClass,col.boxWidth?col.boxWidth+"px":"auto"]);
}
}
_68f.ss.add(_6a0);
_68f.ss.dirty(_68f.cellSelectorPrefix);
_68f.cellSelectorPrefix="."+_68f.cellClassPrefix;
};
};
function _6a4(_6a5){
var _6a6=$.data(_6a5,"datagrid");
var _6a7=_6a6.panel;
var opts=_6a6.options;
var dc=_6a6.dc;
var _6a8=dc.header1.add(dc.header2);
_6a8.unbind(".datagrid");
for(var _6a9 in opts.headerEvents){
_6a8.bind(_6a9+".datagrid",opts.headerEvents[_6a9]);
}
var _6aa=_6a8.find("div.datagrid-cell");
var _6ab=opts.resizeHandle=="right"?"e":(opts.resizeHandle=="left"?"w":"e,w");
_6aa.each(function(){
$(this).resizable({handles:_6ab,disabled:($(this).attr("resizable")?$(this).attr("resizable")=="false":false),minWidth:25,onStartResize:function(e){
_6a6.resizing=true;
_6a8.css("cursor",$("body").css("cursor"));
if(!_6a6.proxy){
_6a6.proxy=$("<div class=\"datagrid-resize-proxy\"></div>").appendTo(dc.view);
}
_6a6.proxy.css({left:e.pageX-$(_6a7).offset().left-1,display:"none"});
setTimeout(function(){
if(_6a6.proxy){
_6a6.proxy.show();
}
},500);
},onResize:function(e){
_6a6.proxy.css({left:e.pageX-$(_6a7).offset().left-1,display:"block"});
return false;
},onStopResize:function(e){
_6a8.css("cursor","");
$(this).css("height","");
var _6ac=$(this).parent().attr("field");
var col=_6a3(_6a5,_6ac);
col.width=$(this)._outerWidth();
col.boxWidth=col.width-col.deltaWidth;
col.auto=undefined;
$(this).css("width","");
$(_6a5).datagrid("fixColumnSize",_6ac);
_6a6.proxy.remove();
_6a6.proxy=null;
if($(this).parents("div:first.datagrid-header").parent().hasClass("datagrid-view1")){
_65f(_6a5);
}
$(_6a5).datagrid("fitColumns");
opts.onResizeColumn.call(_6a5,_6ac,col.width);
setTimeout(function(){
_6a6.resizing=false;
},0);
}});
});
var bb=dc.body1.add(dc.body2);
bb.unbind();
for(var _6a9 in opts.rowEvents){
bb.bind(_6a9,opts.rowEvents[_6a9]);
}
dc.body1.bind("mousewheel DOMMouseScroll",function(e){
e.preventDefault();
var e1=e.originalEvent||window.event;
var _6ad=e1.wheelDelta||e1.detail*(-1);
if("deltaY" in e1){
_6ad=e1.deltaY*-1;
}
var dg=$(e.target).closest("div.datagrid-view").children(".datagrid-f");
var dc=dg.data("datagrid").dc;
dc.body2.scrollTop(dc.body2.scrollTop()-_6ad);
});
dc.body2.bind("scroll",function(){
var b1=dc.view1.children("div.datagrid-body");
b1.scrollTop($(this).scrollTop());
var c1=dc.body1.children(":first");
var c2=dc.body2.children(":first");
if(c1.length&&c2.length){
var top1=c1.offset().top;
var top2=c2.offset().top;
if(top1!=top2){
b1.scrollTop(b1.scrollTop()+top1-top2);
}
}
dc.view2.children("div.datagrid-header,div.datagrid-footer")._scrollLeft($(this)._scrollLeft());
dc.body2.children("table.datagrid-btable-frozen").css("left",-$(this)._scrollLeft());
});
};
function _6ae(_6af){
return function(e){
var td=$(e.target).closest("td[field]");
if(td.length){
var _6b0=_6b1(td);
if(!$(_6b0).data("datagrid").resizing&&_6af){
td.addClass("datagrid-header-over");
}else{
td.removeClass("datagrid-header-over");
}
}
};
};
function _6b2(e){
var _6b3=_6b1(e.target);
var opts=$(_6b3).datagrid("options");
var ck=$(e.target).closest("input[type=checkbox]");
if(ck.length){
if(opts.singleSelect&&opts.selectOnCheck){
return false;
}
if(ck.is(":checked")){
_6b4(_6b3);
}else{
_6b5(_6b3);
}
e.stopPropagation();
}else{
var cell=$(e.target).closest(".datagrid-cell");
if(cell.length){
var p1=cell.offset().left+5;
var p2=cell.offset().left+cell._outerWidth()-5;
if(e.pageX<p2&&e.pageX>p1){
_6b6(_6b3,cell.parent().attr("field"));
}
}
}
};
function _6b7(e){
var _6b8=_6b1(e.target);
var opts=$(_6b8).datagrid("options");
var cell=$(e.target).closest(".datagrid-cell");
if(cell.length){
var p1=cell.offset().left+5;
var p2=cell.offset().left+cell._outerWidth()-5;
var cond=opts.resizeHandle=="right"?(e.pageX>p2):(opts.resizeHandle=="left"?(e.pageX<p1):(e.pageX<p1||e.pageX>p2));
if(cond){
var _6b9=cell.parent().attr("field");
var col=_6a3(_6b8,_6b9);
if(col.resizable==false){
return;
}
$(_6b8).datagrid("autoSizeColumn",_6b9);
col.auto=false;
}
}
};
function _6ba(e){
var _6bb=_6b1(e.target);
var opts=$(_6bb).datagrid("options");
var td=$(e.target).closest("td[field]");
opts.onHeaderContextMenu.call(_6bb,e,td.attr("field"));
};
function _6bc(_6bd){
return function(e){
var tr=_6be(e.target);
if(!tr){
return;
}
var _6bf=_6b1(tr);
if($.data(_6bf,"datagrid").resizing){
return;
}
var _6c0=_6c1(tr);
if(_6bd){
_6c2(_6bf,_6c0);
}else{
var opts=$.data(_6bf,"datagrid").options;
opts.finder.getTr(_6bf,_6c0).removeClass("datagrid-row-over");
}
};
};
function _6c3(e){
var tr=_6be(e.target);
if(!tr){
return;
}
var _6c4=_6b1(tr);
var opts=$.data(_6c4,"datagrid").options;
var _6c5=_6c1(tr);
var tt=$(e.target);
if(tt.parent().hasClass("datagrid-cell-check")){
if(opts.singleSelect&&opts.selectOnCheck){
tt._propAttr("checked",!tt.is(":checked"));
_6c6(_6c4,_6c5);
}else{
if(tt.is(":checked")){
tt._propAttr("checked",false);
_6c6(_6c4,_6c5);
}else{
tt._propAttr("checked",true);
_6c7(_6c4,_6c5);
}
}
}else{
var row=opts.finder.getRow(_6c4,_6c5);
var td=tt.closest("td[field]",tr);
if(td.length){
var _6c8=td.attr("field");
opts.onClickCell.call(_6c4,_6c5,_6c8,row[_6c8]);
}
if(opts.singleSelect==true){
_6c9(_6c4,_6c5);
}else{
if(opts.ctrlSelect){
if(e.metaKey||e.ctrlKey){
if(tr.hasClass("datagrid-row-selected")){
_6ca(_6c4,_6c5);
}else{
_6c9(_6c4,_6c5);
}
}else{
if(e.shiftKey){
$(_6c4).datagrid("clearSelections");
var _6cb=Math.min(opts.lastSelectedIndex||0,_6c5);
var _6cc=Math.max(opts.lastSelectedIndex||0,_6c5);
for(var i=_6cb;i<=_6cc;i++){
_6c9(_6c4,i);
}
}else{
$(_6c4).datagrid("clearSelections");
_6c9(_6c4,_6c5);
opts.lastSelectedIndex=_6c5;
}
}
}else{
if(tr.hasClass("datagrid-row-selected")){
_6ca(_6c4,_6c5);
}else{
_6c9(_6c4,_6c5);
}
}
}
opts.onClickRow.apply(_6c4,_649(_6c4,[_6c5,row]));
}
};
function _6cd(e){
var tr=_6be(e.target);
if(!tr){
return;
}
var _6ce=_6b1(tr);
var opts=$.data(_6ce,"datagrid").options;
var _6cf=_6c1(tr);
var row=opts.finder.getRow(_6ce,_6cf);
var td=$(e.target).closest("td[field]",tr);
if(td.length){
var _6d0=td.attr("field");
opts.onDblClickCell.call(_6ce,_6cf,_6d0,row[_6d0]);
}
opts.onDblClickRow.apply(_6ce,_649(_6ce,[_6cf,row]));
};
function _6d1(e){
var tr=_6be(e.target);
if(tr){
var _6d2=_6b1(tr);
var opts=$.data(_6d2,"datagrid").options;
var _6d3=_6c1(tr);
var row=opts.finder.getRow(_6d2,_6d3);
opts.onRowContextMenu.call(_6d2,e,_6d3,row);
}else{
var body=_6be(e.target,".datagrid-body");
if(body){
var _6d2=_6b1(body);
var opts=$.data(_6d2,"datagrid").options;
opts.onRowContextMenu.call(_6d2,e,-1,null);
}
}
};
function _6b1(t){
return $(t).closest("div.datagrid-view").children(".datagrid-f")[0];
};
function _6be(t,_6d4){
var tr=$(t).closest(_6d4||"tr.datagrid-row");
if(tr.length&&tr.parent().length){
return tr;
}else{
return undefined;
}
};
function _6c1(tr){
if(tr.attr("datagrid-row-index")){
return parseInt(tr.attr("datagrid-row-index"));
}else{
return tr.attr("node-id");
}
};
function _6b6(_6d5,_6d6){
var _6d7=$.data(_6d5,"datagrid");
var opts=_6d7.options;
_6d6=_6d6||{};
var _6d8={sortName:opts.sortName,sortOrder:opts.sortOrder};
if(typeof _6d6=="object"){
$.extend(_6d8,_6d6);
}
var _6d9=[];
var _6da=[];
if(_6d8.sortName){
_6d9=_6d8.sortName.split(",");
_6da=_6d8.sortOrder.split(",");
}
if(typeof _6d6=="string"){
var _6db=_6d6;
var col=_6a3(_6d5,_6db);
if(!col.sortable||_6d7.resizing){
return;
}
var _6dc=col.order||"asc";
var pos=_646(_6d9,_6db);
if(pos>=0){
var _6dd=_6da[pos]=="asc"?"desc":"asc";
if(opts.multiSort&&_6dd==_6dc){
_6d9.splice(pos,1);
_6da.splice(pos,1);
}else{
_6da[pos]=_6dd;
}
}else{
if(opts.multiSort){
_6d9.push(_6db);
_6da.push(_6dc);
}else{
_6d9=[_6db];
_6da=[_6dc];
}
}
_6d8.sortName=_6d9.join(",");
_6d8.sortOrder=_6da.join(",");
}
if(opts.onBeforeSortColumn.call(_6d5,_6d8.sortName,_6d8.sortOrder)==false){
return;
}
$.extend(opts,_6d8);
var dc=_6d7.dc;
var _6de=dc.header1.add(dc.header2);
_6de.find("div.datagrid-cell").removeClass("datagrid-sort-asc datagrid-sort-desc");
for(var i=0;i<_6d9.length;i++){
var col=_6a3(_6d5,_6d9[i]);
_6de.find("div."+col.cellClass).addClass("datagrid-sort-"+_6da[i]);
}
if(opts.remoteSort){
_6df(_6d5);
}else{
_6e0(_6d5,$(_6d5).datagrid("getData"));
}
opts.onSortColumn.call(_6d5,opts.sortName,opts.sortOrder);
};
function _6e1(_6e2,_6e3,_6e4){
_6e5(true);
_6e5(false);
function _6e5(_6e6){
var aa=_6e7(_6e2,_6e6);
if(aa.length){
var _6e8=aa[aa.length-1];
var _6e9=_646(_6e8,_6e3);
if(_6e9>=0){
for(var _6ea=0;_6ea<aa.length-1;_6ea++){
var td=$("#"+aa[_6ea][_6e9]);
var _6eb=parseInt(td.attr("colspan")||1)+(_6e4||0);
td.attr("colspan",_6eb);
if(_6eb){
td.show();
}else{
td.hide();
}
}
}
}
};
};
function _6ec(_6ed){
var _6ee=$.data(_6ed,"datagrid");
var opts=_6ee.options;
var dc=_6ee.dc;
var _6ef=dc.view2.children("div.datagrid-header");
dc.body2.css("overflow-x","");
_6f0();
_6f1();
_6f2();
_6f0(true);
if(_6ef.width()>=_6ef.find("table").width()){
dc.body2.css("overflow-x","hidden");
}
function _6f2(){
if(!opts.fitColumns){
return;
}
if(!_6ee.leftWidth){
_6ee.leftWidth=0;
}
var _6f3=0;
var cc=[];
var _6f4=_6a2(_6ed,false);
for(var i=0;i<_6f4.length;i++){
var col=_6a3(_6ed,_6f4[i]);
if(_6f5(col)){
_6f3+=col.width;
cc.push({field:col.field,col:col,addingWidth:0});
}
}
if(!_6f3){
return;
}
cc[cc.length-1].addingWidth-=_6ee.leftWidth;
var _6f6=_6ef.children("div.datagrid-header-inner").show();
var _6f7=_6ef.width()-_6ef.find("table").width()-opts.scrollbarSize+_6ee.leftWidth;
var rate=_6f7/_6f3;
if(!opts.showHeader){
_6f6.hide();
}
for(var i=0;i<cc.length;i++){
var c=cc[i];
var _6f8=parseInt(c.col.width*rate);
c.addingWidth+=_6f8;
_6f7-=_6f8;
}
cc[cc.length-1].addingWidth+=_6f7;
for(var i=0;i<cc.length;i++){
var c=cc[i];
if(c.col.boxWidth+c.addingWidth>0){
c.col.boxWidth+=c.addingWidth;
c.col.width+=c.addingWidth;
}
}
_6ee.leftWidth=_6f7;
$(_6ed).datagrid("fixColumnSize");
};
function _6f1(){
var _6f9=false;
var _6fa=_6a2(_6ed,true).concat(_6a2(_6ed,false));
$.map(_6fa,function(_6fb){
var col=_6a3(_6ed,_6fb);
if(String(col.width||"").indexOf("%")>=0){
var _6fc=$.parser.parseValue("width",col.width,dc.view,opts.scrollbarSize+(opts.rownumbers?opts.rownumberWidth:0))-col.deltaWidth;
if(_6fc>0){
col.boxWidth=_6fc;
_6f9=true;
}
}
});
if(_6f9){
$(_6ed).datagrid("fixColumnSize");
}
};
function _6f0(fit){
var _6fd=dc.header1.add(dc.header2).find(".datagrid-cell-group");
if(_6fd.length){
_6fd.each(function(){
$(this)._outerWidth(fit?$(this).parent().width():10);
});
if(fit){
_65f(_6ed);
}
}
};
function _6f5(col){
if(String(col.width||"").indexOf("%")>=0){
return false;
}
if(!col.hidden&&!col.checkbox&&!col.auto&&!col.fixed){
return true;
}
};
};
function _6fe(_6ff,_700){
var _701=$.data(_6ff,"datagrid");
var opts=_701.options;
var dc=_701.dc;
var tmp=$("<div class=\"datagrid-cell\" style=\"position:absolute;left:-9999px\"></div>").appendTo("body");
if(_700){
_65a(_700);
$(_6ff).datagrid("fitColumns");
}else{
var _702=false;
var _703=_6a2(_6ff,true).concat(_6a2(_6ff,false));
for(var i=0;i<_703.length;i++){
var _700=_703[i];
var col=_6a3(_6ff,_700);
if(col.auto){
_65a(_700);
_702=true;
}
}
if(_702){
$(_6ff).datagrid("fitColumns");
}
}
tmp.remove();
function _65a(_704){
var _705=dc.view.find("div.datagrid-header td[field=\""+_704+"\"] div.datagrid-cell");
_705.css("width","");
var col=$(_6ff).datagrid("getColumnOption",_704);
col.width=undefined;
col.boxWidth=undefined;
col.auto=true;
$(_6ff).datagrid("fixColumnSize",_704);
var _706=Math.max(_707("header"),_707("allbody"),_707("allfooter"))+1;
_705._outerWidth(_706-1);
col.width=_706;
col.boxWidth=parseInt(_705[0].style.width);
col.deltaWidth=_706-col.boxWidth;
_705.css("width","");
$(_6ff).datagrid("fixColumnSize",_704);
opts.onResizeColumn.call(_6ff,_704,col.width);
function _707(type){
var _708=0;
if(type=="header"){
_708=_709(_705);
}else{
opts.finder.getTr(_6ff,0,type).find("td[field=\""+_704+"\"] div.datagrid-cell").each(function(){
var w=_709($(this));
if(_708<w){
_708=w;
}
});
}
return _708;
function _709(cell){
return cell.is(":visible")?cell._outerWidth():tmp.html(cell.html())._outerWidth();
};
};
};
};
function _70a(_70b,_70c){
var _70d=$.data(_70b,"datagrid");
var opts=_70d.options;
var dc=_70d.dc;
var _70e=dc.view.find("table.datagrid-btable,table.datagrid-ftable");
_70e.css("table-layout","fixed");
if(_70c){
fix(_70c);
}else{
var ff=_6a2(_70b,true).concat(_6a2(_70b,false));
for(var i=0;i<ff.length;i++){
fix(ff[i]);
}
}
_70e.css("table-layout","");
_70f(_70b);
_670(_70b);
_710(_70b);
function fix(_711){
var col=_6a3(_70b,_711);
if(col.cellClass){
_70d.ss.set("."+col.cellClass,col.boxWidth?col.boxWidth+"px":"auto");
}
};
};
function _70f(_712,tds){
var dc=$.data(_712,"datagrid").dc;
tds=tds||dc.view.find("td.datagrid-td-merged");
tds.each(function(){
var td=$(this);
var _713=td.attr("colspan")||1;
if(_713>1){
var col=_6a3(_712,td.attr("field"));
var _714=col.boxWidth+col.deltaWidth-1;
for(var i=1;i<_713;i++){
td=td.next();
col=_6a3(_712,td.attr("field"));
_714+=col.boxWidth+col.deltaWidth;
}
$(this).children("div.datagrid-cell")._outerWidth(_714);
}
});
};
function _710(_715){
var dc=$.data(_715,"datagrid").dc;
dc.view.find("div.datagrid-editable").each(function(){
var cell=$(this);
var _716=cell.parent().attr("field");
var col=$(_715).datagrid("getColumnOption",_716);
cell._outerWidth(col.boxWidth+col.deltaWidth-1);
var ed=$.data(this,"datagrid.editor");
if(ed.actions.resize){
ed.actions.resize(ed.target,cell.width());
}
});
};
function _6a3(_717,_718){
function find(_719){
if(_719){
for(var i=0;i<_719.length;i++){
var cc=_719[i];
for(var j=0;j<cc.length;j++){
var c=cc[j];
if(c.field==_718){
return c;
}
}
}
}
return null;
};
var opts=$.data(_717,"datagrid").options;
var col=find(opts.columns);
if(!col){
col=find(opts.frozenColumns);
}
return col;
};
function _6e7(_71a,_71b){
var opts=$.data(_71a,"datagrid").options;
var _71c=_71b?opts.frozenColumns:opts.columns;
var aa=[];
var _71d=_71e();
for(var i=0;i<_71c.length;i++){
aa[i]=new Array(_71d);
}
for(var _71f=0;_71f<_71c.length;_71f++){
$.map(_71c[_71f],function(col){
var _720=_721(aa[_71f]);
if(_720>=0){
var _722=col.field||col.id||"";
for(var c=0;c<(col.colspan||1);c++){
for(var r=0;r<(col.rowspan||1);r++){
aa[_71f+r][_720]=_722;
}
_720++;
}
}
});
}
return aa;
function _71e(){
var _723=0;
$.map(_71c[0]||[],function(col){
_723+=col.colspan||1;
});
return _723;
};
function _721(a){
for(var i=0;i<a.length;i++){
if(a[i]==undefined){
return i;
}
}
return -1;
};
};
function _6a2(_724,_725){
var aa=_6e7(_724,_725);
return aa.length?aa[aa.length-1]:aa;
};
function _6e0(_726,data){
var _727=$.data(_726,"datagrid");
var opts=_727.options;
var dc=_727.dc;
data=opts.loadFilter.call(_726,data);
if($.isArray(data)){
data={total:data.length,rows:data};
}
data.total=parseInt(data.total);
_727.data=data;
if(data.footer){
_727.footer=data.footer;
}
if(!opts.remoteSort&&opts.sortName){
var _728=opts.sortName.split(",");
var _729=opts.sortOrder.split(",");
data.rows.sort(function(r1,r2){
var r=0;
for(var i=0;i<_728.length;i++){
var sn=_728[i];
var so=_729[i];
var col=_6a3(_726,sn);
var _72a=col.sorter||function(a,b){
return a==b?0:(a>b?1:-1);
};
r=_72a(r1[sn],r2[sn])*(so=="asc"?1:-1);
if(r!=0){
return r;
}
}
return r;
});
}
if(opts.view.onBeforeRender){
opts.view.onBeforeRender.call(opts.view,_726,data.rows);
}
opts.view.render.call(opts.view,_726,dc.body2,false);
opts.view.render.call(opts.view,_726,dc.body1,true);
if(opts.showFooter){
opts.view.renderFooter.call(opts.view,_726,dc.footer2,false);
opts.view.renderFooter.call(opts.view,_726,dc.footer1,true);
}
if(opts.view.onAfterRender){
opts.view.onAfterRender.call(opts.view,_726);
}
_727.ss.clean();
var _72b=$(_726).datagrid("getPager");
if(_72b.length){
var _72c=_72b.pagination("options");
if(_72c.total!=data.total){
_72b.pagination("refresh",{total:data.total});
if(opts.pageNumber!=_72c.pageNumber&&_72c.pageNumber>0){
opts.pageNumber=_72c.pageNumber;
_6df(_726);
}
}
}
_670(_726);
dc.body2.triggerHandler("scroll");
$(_726).datagrid("setSelectionState");
$(_726).datagrid("autoSizeColumn");
opts.onLoadSuccess.call(_726,data);
};
function _72d(_72e){
var _72f=$.data(_72e,"datagrid");
var opts=_72f.options;
var dc=_72f.dc;
dc.header1.add(dc.header2).find("input[type=checkbox]")._propAttr("checked",false);
if(opts.idField){
var _730=$.data(_72e,"treegrid")?true:false;
var _731=opts.onSelect;
var _732=opts.onCheck;
opts.onSelect=opts.onCheck=function(){
};
var rows=opts.finder.getRows(_72e);
for(var i=0;i<rows.length;i++){
var row=rows[i];
var _733=_730?row[opts.idField]:$(_72e).datagrid("getRowIndex",row[opts.idField]);
if(_734(_72f.selectedRows,row)){
_6c9(_72e,_733,true,true);
}
if(_734(_72f.checkedRows,row)){
_6c6(_72e,_733,true);
}
}
opts.onSelect=_731;
opts.onCheck=_732;
}
function _734(a,r){
for(var i=0;i<a.length;i++){
if(a[i][opts.idField]==r[opts.idField]){
a[i]=r;
return true;
}
}
return false;
};
};
function _735(_736,row){
var _737=$.data(_736,"datagrid");
var opts=_737.options;
var rows=_737.data.rows;
if(typeof row=="object"){
return _646(rows,row);
}else{
for(var i=0;i<rows.length;i++){
if(rows[i][opts.idField]==row){
return i;
}
}
return -1;
}
};
function _738(_739){
var _73a=$.data(_739,"datagrid");
var opts=_73a.options;
var data=_73a.data;
if(opts.idField){
return _73a.selectedRows;
}else{
var rows=[];
opts.finder.getTr(_739,"","selected",2).each(function(){
rows.push(opts.finder.getRow(_739,$(this)));
});
return rows;
}
};
function _73b(_73c){
var _73d=$.data(_73c,"datagrid");
var opts=_73d.options;
if(opts.idField){
return _73d.checkedRows;
}else{
var rows=[];
opts.finder.getTr(_73c,"","checked",2).each(function(){
rows.push(opts.finder.getRow(_73c,$(this)));
});
return rows;
}
};
function _73e(_73f,_740){
var _741=$.data(_73f,"datagrid");
var dc=_741.dc;
var opts=_741.options;
var tr=opts.finder.getTr(_73f,_740);
if(tr.length){
if(tr.closest("table").hasClass("datagrid-btable-frozen")){
return;
}
var _742=dc.view2.children("div.datagrid-header")._outerHeight();
var _743=dc.body2;
var _744=opts.scrollbarSize;
if(_743[0].offsetHeight&&_743[0].clientHeight&&_743[0].offsetHeight<=_743[0].clientHeight){
_744=0;
}
var _745=_743.outerHeight(true)-_743.outerHeight();
var top=tr.position().top-_742-_745;
if(top<0){
_743.scrollTop(_743.scrollTop()+top);
}else{
if(top+tr._outerHeight()>_743.height()-_744){
_743.scrollTop(_743.scrollTop()+top+tr._outerHeight()-_743.height()+_744);
}
}
}
};
function _6c2(_746,_747){
var _748=$.data(_746,"datagrid");
var opts=_748.options;
opts.finder.getTr(_746,_748.highlightIndex).removeClass("datagrid-row-over");
opts.finder.getTr(_746,_747).addClass("datagrid-row-over");
_748.highlightIndex=_747;
};
function _6c9(_749,_74a,_74b,_74c){
var _74d=$.data(_749,"datagrid");
var opts=_74d.options;
var row=opts.finder.getRow(_749,_74a);
if(!row){
return;
}
if(opts.onBeforeSelect.apply(_749,_649(_749,[_74a,row]))==false){
return;
}
if(opts.singleSelect){
_74e(_749,true);
_74d.selectedRows=[];
}
if(!_74b&&opts.checkOnSelect){
_6c6(_749,_74a,true);
}
if(opts.idField){
_648(_74d.selectedRows,opts.idField,row);
}
opts.finder.getTr(_749,_74a).addClass("datagrid-row-selected");
opts.onSelect.apply(_749,_649(_749,[_74a,row]));
if(!_74c&&opts.scrollOnSelect){
_73e(_749,_74a);
}
};
function _6ca(_74f,_750,_751){
var _752=$.data(_74f,"datagrid");
var dc=_752.dc;
var opts=_752.options;
var row=opts.finder.getRow(_74f,_750);
if(!row){
return;
}
if(opts.onBeforeUnselect.apply(_74f,_649(_74f,[_750,row]))==false){
return;
}
if(!_751&&opts.checkOnSelect){
_6c7(_74f,_750,true);
}
opts.finder.getTr(_74f,_750).removeClass("datagrid-row-selected");
if(opts.idField){
_647(_752.selectedRows,opts.idField,row[opts.idField]);
}
opts.onUnselect.apply(_74f,_649(_74f,[_750,row]));
};
function _753(_754,_755){
var _756=$.data(_754,"datagrid");
var opts=_756.options;
var rows=opts.finder.getRows(_754);
var _757=$.data(_754,"datagrid").selectedRows;
if(!_755&&opts.checkOnSelect){
_6b4(_754,true);
}
opts.finder.getTr(_754,"","allbody").addClass("datagrid-row-selected");
if(opts.idField){
for(var _758=0;_758<rows.length;_758++){
_648(_757,opts.idField,rows[_758]);
}
}
opts.onSelectAll.call(_754,rows);
};
function _74e(_759,_75a){
var _75b=$.data(_759,"datagrid");
var opts=_75b.options;
var rows=opts.finder.getRows(_759);
var _75c=$.data(_759,"datagrid").selectedRows;
if(!_75a&&opts.checkOnSelect){
_6b5(_759,true);
}
opts.finder.getTr(_759,"","selected").removeClass("datagrid-row-selected");
if(opts.idField){
for(var _75d=0;_75d<rows.length;_75d++){
_647(_75c,opts.idField,rows[_75d][opts.idField]);
}
}
opts.onUnselectAll.call(_759,rows);
};
function _6c6(_75e,_75f,_760){
var _761=$.data(_75e,"datagrid");
var opts=_761.options;
var row=opts.finder.getRow(_75e,_75f);
if(!row){
return;
}
if(opts.onBeforeCheck.apply(_75e,_649(_75e,[_75f,row]))==false){
return;
}
if(opts.singleSelect&&opts.selectOnCheck){
_6b5(_75e,true);
_761.checkedRows=[];
}
if(!_760&&opts.selectOnCheck){
_6c9(_75e,_75f,true);
}
var tr=opts.finder.getTr(_75e,_75f).addClass("datagrid-row-checked");
tr.find("div.datagrid-cell-check input[type=checkbox]")._propAttr("checked",true);
tr=opts.finder.getTr(_75e,"","checked",2);
if(tr.length==opts.finder.getRows(_75e).length){
var dc=_761.dc;
dc.header1.add(dc.header2).find("input[type=checkbox]")._propAttr("checked",true);
}
if(opts.idField){
_648(_761.checkedRows,opts.idField,row);
}
opts.onCheck.apply(_75e,_649(_75e,[_75f,row]));
};
function _6c7(_762,_763,_764){
var _765=$.data(_762,"datagrid");
var opts=_765.options;
var row=opts.finder.getRow(_762,_763);
if(!row){
return;
}
if(opts.onBeforeUncheck.apply(_762,_649(_762,[_763,row]))==false){
return;
}
if(!_764&&opts.selectOnCheck){
_6ca(_762,_763,true);
}
var tr=opts.finder.getTr(_762,_763).removeClass("datagrid-row-checked");
tr.find("div.datagrid-cell-check input[type=checkbox]")._propAttr("checked",false);
var dc=_765.dc;
var _766=dc.header1.add(dc.header2);
_766.find("input[type=checkbox]")._propAttr("checked",false);
if(opts.idField){
_647(_765.checkedRows,opts.idField,row[opts.idField]);
}
opts.onUncheck.apply(_762,_649(_762,[_763,row]));
};
function _6b4(_767,_768){
var _769=$.data(_767,"datagrid");
var opts=_769.options;
var rows=opts.finder.getRows(_767);
if(!_768&&opts.selectOnCheck){
_753(_767,true);
}
var dc=_769.dc;
var hck=dc.header1.add(dc.header2).find("input[type=checkbox]");
var bck=opts.finder.getTr(_767,"","allbody").addClass("datagrid-row-checked").find("div.datagrid-cell-check input[type=checkbox]");
hck.add(bck)._propAttr("checked",true);
if(opts.idField){
for(var i=0;i<rows.length;i++){
_648(_769.checkedRows,opts.idField,rows[i]);
}
}
opts.onCheckAll.call(_767,rows);
};
function _6b5(_76a,_76b){
var _76c=$.data(_76a,"datagrid");
var opts=_76c.options;
var rows=opts.finder.getRows(_76a);
if(!_76b&&opts.selectOnCheck){
_74e(_76a,true);
}
var dc=_76c.dc;
var hck=dc.header1.add(dc.header2).find("input[type=checkbox]");
var bck=opts.finder.getTr(_76a,"","checked").removeClass("datagrid-row-checked").find("div.datagrid-cell-check input[type=checkbox]");
hck.add(bck)._propAttr("checked",false);
if(opts.idField){
for(var i=0;i<rows.length;i++){
_647(_76c.checkedRows,opts.idField,rows[i][opts.idField]);
}
}
opts.onUncheckAll.call(_76a,rows);
};
function _76d(_76e,_76f){
var opts=$.data(_76e,"datagrid").options;
var tr=opts.finder.getTr(_76e,_76f);
var row=opts.finder.getRow(_76e,_76f);
if(tr.hasClass("datagrid-row-editing")){
return;
}
if(opts.onBeforeEdit.apply(_76e,_649(_76e,[_76f,row]))==false){
return;
}
tr.addClass("datagrid-row-editing");
_770(_76e,_76f);
_710(_76e);
tr.find("div.datagrid-editable").each(function(){
var _771=$(this).parent().attr("field");
var ed=$.data(this,"datagrid.editor");
ed.actions.setValue(ed.target,row[_771]);
});
_772(_76e,_76f);
opts.onBeginEdit.apply(_76e,_649(_76e,[_76f,row]));
};
function _773(_774,_775,_776){
var _777=$.data(_774,"datagrid");
var opts=_777.options;
var _778=_777.updatedRows;
var _779=_777.insertedRows;
var tr=opts.finder.getTr(_774,_775);
var row=opts.finder.getRow(_774,_775);
if(!tr.hasClass("datagrid-row-editing")){
return;
}
if(!_776){
if(!_772(_774,_775)){
return;
}
var _77a=false;
var _77b={};
tr.find("div.datagrid-editable").each(function(){
var _77c=$(this).parent().attr("field");
var ed=$.data(this,"datagrid.editor");
var t=$(ed.target);
var _77d=t.data("textbox")?t.textbox("textbox"):t;
if(_77d.is(":focus")){
_77d.triggerHandler("blur");
}
var _77e=ed.actions.getValue(ed.target);
if(row[_77c]!==_77e){
row[_77c]=_77e;
_77a=true;
_77b[_77c]=_77e;
}
});
if(_77a){
if(_646(_779,row)==-1){
if(_646(_778,row)==-1){
_778.push(row);
}
}
}
opts.onEndEdit.apply(_774,_649(_774,[_775,row,_77b]));
}
tr.removeClass("datagrid-row-editing");
_77f(_774,_775);
$(_774).datagrid("refreshRow",_775);
if(!_776){
opts.onAfterEdit.apply(_774,_649(_774,[_775,row,_77b]));
}else{
opts.onCancelEdit.apply(_774,_649(_774,[_775,row]));
}
};
function _780(_781,_782){
var opts=$.data(_781,"datagrid").options;
var tr=opts.finder.getTr(_781,_782);
var _783=[];
tr.children("td").each(function(){
var cell=$(this).find("div.datagrid-editable");
if(cell.length){
var ed=$.data(cell[0],"datagrid.editor");
_783.push(ed);
}
});
return _783;
};
function _784(_785,_786){
var _787=_780(_785,_786.index!=undefined?_786.index:_786.id);
for(var i=0;i<_787.length;i++){
if(_787[i].field==_786.field){
return _787[i];
}
}
return null;
};
function _770(_788,_789){
var opts=$.data(_788,"datagrid").options;
var tr=opts.finder.getTr(_788,_789);
tr.children("td").each(function(){
var cell=$(this).find("div.datagrid-cell");
var _78a=$(this).attr("field");
var col=_6a3(_788,_78a);
if(col&&col.editor){
var _78b,_78c;
if(typeof col.editor=="string"){
_78b=col.editor;
}else{
_78b=col.editor.type;
_78c=col.editor.options;
}
var _78d=opts.editors[_78b];
if(_78d){
var _78e=cell.html();
var _78f=cell._outerWidth();
cell.addClass("datagrid-editable");
cell._outerWidth(_78f);
cell.html("<table border=\"0\" cellspacing=\"0\" cellpadding=\"1\"><tr><td></td></tr></table>");
cell.children("table").bind("click dblclick contextmenu",function(e){
e.stopPropagation();
});
$.data(cell[0],"datagrid.editor",{actions:_78d,target:_78d.init(cell.find("td"),$.extend({height:opts.editorHeight},_78c)),field:_78a,type:_78b,oldHtml:_78e});
}
}
});
_670(_788,_789,true);
};
function _77f(_790,_791){
var opts=$.data(_790,"datagrid").options;
var tr=opts.finder.getTr(_790,_791);
tr.children("td").each(function(){
var cell=$(this).find("div.datagrid-editable");
if(cell.length){
var ed=$.data(cell[0],"datagrid.editor");
if(ed.actions.destroy){
ed.actions.destroy(ed.target);
}
cell.html(ed.oldHtml);
$.removeData(cell[0],"datagrid.editor");
cell.removeClass("datagrid-editable");
cell.css("width","");
}
});
};
function _772(_792,_793){
var tr=$.data(_792,"datagrid").options.finder.getTr(_792,_793);
if(!tr.hasClass("datagrid-row-editing")){
return true;
}
var vbox=tr.find(".validatebox-text");
vbox.validatebox("validate");
vbox.trigger("mouseleave");
var _794=tr.find(".validatebox-invalid");
return _794.length==0;
};
function _795(_796,_797){
var _798=$.data(_796,"datagrid").insertedRows;
var _799=$.data(_796,"datagrid").deletedRows;
var _79a=$.data(_796,"datagrid").updatedRows;
if(!_797){
var rows=[];
rows=rows.concat(_798);
rows=rows.concat(_799);
rows=rows.concat(_79a);
return rows;
}else{
if(_797=="inserted"){
return _798;
}else{
if(_797=="deleted"){
return _799;
}else{
if(_797=="updated"){
return _79a;
}
}
}
}
return [];
};
function _79b(_79c,_79d){
var _79e=$.data(_79c,"datagrid");
var opts=_79e.options;
var data=_79e.data;
var _79f=_79e.insertedRows;
var _7a0=_79e.deletedRows;
$(_79c).datagrid("cancelEdit",_79d);
var row=opts.finder.getRow(_79c,_79d);
if(_646(_79f,row)>=0){
_647(_79f,row);
}else{
_7a0.push(row);
}
_647(_79e.selectedRows,opts.idField,row[opts.idField]);
_647(_79e.checkedRows,opts.idField,row[opts.idField]);
opts.view.deleteRow.call(opts.view,_79c,_79d);
if(opts.height=="auto"){
_670(_79c);
}
$(_79c).datagrid("getPager").pagination("refresh",{total:data.total});
};
function _7a1(_7a2,_7a3){
var data=$.data(_7a2,"datagrid").data;
var view=$.data(_7a2,"datagrid").options.view;
var _7a4=$.data(_7a2,"datagrid").insertedRows;
view.insertRow.call(view,_7a2,_7a3.index,_7a3.row);
_7a4.push(_7a3.row);
$(_7a2).datagrid("getPager").pagination("refresh",{total:data.total});
};
function _7a5(_7a6,row){
var data=$.data(_7a6,"datagrid").data;
var view=$.data(_7a6,"datagrid").options.view;
var _7a7=$.data(_7a6,"datagrid").insertedRows;
view.insertRow.call(view,_7a6,null,row);
_7a7.push(row);
$(_7a6).datagrid("getPager").pagination("refresh",{total:data.total});
};
function _7a8(_7a9,_7aa){
var _7ab=$.data(_7a9,"datagrid");
var opts=_7ab.options;
var row=opts.finder.getRow(_7a9,_7aa.index);
var _7ac=false;
_7aa.row=_7aa.row||{};
for(var _7ad in _7aa.row){
if(row[_7ad]!==_7aa.row[_7ad]){
_7ac=true;
break;
}
}
if(_7ac){
if(_646(_7ab.insertedRows,row)==-1){
if(_646(_7ab.updatedRows,row)==-1){
_7ab.updatedRows.push(row);
}
}
opts.view.updateRow.call(opts.view,_7a9,_7aa.index,_7aa.row);
}
};
function _7ae(_7af){
var _7b0=$.data(_7af,"datagrid");
var data=_7b0.data;
var rows=data.rows;
var _7b1=[];
for(var i=0;i<rows.length;i++){
_7b1.push($.extend({},rows[i]));
}
_7b0.originalRows=_7b1;
_7b0.updatedRows=[];
_7b0.insertedRows=[];
_7b0.deletedRows=[];
};
function _7b2(_7b3){
var data=$.data(_7b3,"datagrid").data;
var ok=true;
for(var i=0,len=data.rows.length;i<len;i++){
if(_772(_7b3,i)){
$(_7b3).datagrid("endEdit",i);
}else{
ok=false;
}
}
if(ok){
_7ae(_7b3);
}
};
function _7b4(_7b5){
var _7b6=$.data(_7b5,"datagrid");
var opts=_7b6.options;
var _7b7=_7b6.originalRows;
var _7b8=_7b6.insertedRows;
var _7b9=_7b6.deletedRows;
var _7ba=_7b6.selectedRows;
var _7bb=_7b6.checkedRows;
var data=_7b6.data;
function _7bc(a){
var ids=[];
for(var i=0;i<a.length;i++){
ids.push(a[i][opts.idField]);
}
return ids;
};
function _7bd(ids,_7be){
for(var i=0;i<ids.length;i++){
var _7bf=_735(_7b5,ids[i]);
if(_7bf>=0){
(_7be=="s"?_6c9:_6c6)(_7b5,_7bf,true);
}
}
};
for(var i=0;i<data.rows.length;i++){
$(_7b5).datagrid("cancelEdit",i);
}
var _7c0=_7bc(_7ba);
var _7c1=_7bc(_7bb);
_7ba.splice(0,_7ba.length);
_7bb.splice(0,_7bb.length);
data.total+=_7b9.length-_7b8.length;
data.rows=_7b7;
_6e0(_7b5,data);
_7bd(_7c0,"s");
_7bd(_7c1,"c");
_7ae(_7b5);
};
function _6df(_7c2,_7c3,cb){
var opts=$.data(_7c2,"datagrid").options;
if(_7c3){
opts.queryParams=_7c3;
}
var _7c4=$.extend({},opts.queryParams);
if(opts.pagination){
$.extend(_7c4,{page:opts.pageNumber||1,rows:opts.pageSize});
}
if(opts.sortName){
$.extend(_7c4,{sort:opts.sortName,order:opts.sortOrder});
}
if(opts.onBeforeLoad.call(_7c2,_7c4)==false){
return;
}
$(_7c2).datagrid("loading");
var _7c5=opts.loader.call(_7c2,_7c4,function(data){
$(_7c2).datagrid("loaded");
$(_7c2).datagrid("loadData",data);
if(cb){
cb();
}
},function(){
$(_7c2).datagrid("loaded");
opts.onLoadError.apply(_7c2,arguments);
});
if(_7c5==false){
$(_7c2).datagrid("loaded");
}
};
function _7c6(_7c7,_7c8){
var opts=$.data(_7c7,"datagrid").options;
_7c8.type=_7c8.type||"body";
_7c8.rowspan=_7c8.rowspan||1;
_7c8.colspan=_7c8.colspan||1;
if(_7c8.rowspan==1&&_7c8.colspan==1){
return;
}
var tr=opts.finder.getTr(_7c7,(_7c8.index!=undefined?_7c8.index:_7c8.id),_7c8.type);
if(!tr.length){
return;
}
var td=tr.find("td[field=\""+_7c8.field+"\"]");
td.attr("rowspan",_7c8.rowspan).attr("colspan",_7c8.colspan);
td.addClass("datagrid-td-merged");
_7c9(td.next(),_7c8.colspan-1);
for(var i=1;i<_7c8.rowspan;i++){
tr=tr.next();
if(!tr.length){
break;
}
_7c9(tr.find("td[field=\""+_7c8.field+"\"]"),_7c8.colspan);
}
_70f(_7c7,td);
function _7c9(td,_7ca){
for(var i=0;i<_7ca;i++){
td.hide();
td=td.next();
}
};
};
$.fn.datagrid=function(_7cb,_7cc){
if(typeof _7cb=="string"){
return $.fn.datagrid.methods[_7cb](this,_7cc);
}
_7cb=_7cb||{};
return this.each(function(){
var _7cd=$.data(this,"datagrid");
var opts;
if(_7cd){
opts=$.extend(_7cd.options,_7cb);
_7cd.options=opts;
}else{
opts=$.extend({},$.extend({},$.fn.datagrid.defaults,{queryParams:{}}),$.fn.datagrid.parseOptions(this),_7cb);
$(this).css("width","").css("height","");
var _7ce=_684(this,opts.rownumbers);
if(!opts.columns){
opts.columns=_7ce.columns;
}
if(!opts.frozenColumns){
opts.frozenColumns=_7ce.frozenColumns;
}
opts.columns=$.extend(true,[],opts.columns);
opts.frozenColumns=$.extend(true,[],opts.frozenColumns);
opts.view=$.extend({},opts.view);
$.data(this,"datagrid",{options:opts,panel:_7ce.panel,dc:_7ce.dc,ss:null,selectedRows:[],checkedRows:[],data:{total:0,rows:[]},originalRows:[],updatedRows:[],insertedRows:[],deletedRows:[]});
}
_68d(this);
_6a4(this);
_65a(this);
if(opts.data){
$(this).datagrid("loadData",opts.data);
}else{
var data=$.fn.datagrid.parseData(this);
if(data.total>0){
$(this).datagrid("loadData",data);
}else{
opts.view.setEmptyMsg(this);
$(this).datagrid("autoSizeColumn");
}
}
_6df(this);
});
};
function _7cf(_7d0){
var _7d1={};
$.map(_7d0,function(name){
_7d1[name]=_7d2(name);
});
return _7d1;
function _7d2(name){
function isA(_7d3){
return $.data($(_7d3)[0],name)!=undefined;
};
return {init:function(_7d4,_7d5){
var _7d6=$("<input type=\"text\" class=\"datagrid-editable-input\">").appendTo(_7d4);
if(_7d6[name]&&name!="text"){
return _7d6[name](_7d5);
}else{
return _7d6;
}
},destroy:function(_7d7){
if(isA(_7d7,name)){
$(_7d7)[name]("destroy");
}
},getValue:function(_7d8){
if(isA(_7d8,name)){
var opts=$(_7d8)[name]("options");
if(opts.multiple){
return $(_7d8)[name]("getValues").join(opts.separator);
}else{
return $(_7d8)[name]("getValue");
}
}else{
return $(_7d8).val();
}
},setValue:function(_7d9,_7da){
if(isA(_7d9,name)){
var opts=$(_7d9)[name]("options");
if(opts.multiple){
if(_7da){
$(_7d9)[name]("setValues",_7da.split(opts.separator));
}else{
$(_7d9)[name]("clear");
}
}else{
$(_7d9)[name]("setValue",_7da);
}
}else{
$(_7d9).val(_7da);
}
},resize:function(_7db,_7dc){
if(isA(_7db,name)){
$(_7db)[name]("resize",_7dc);
}else{
$(_7db)._size({width:_7dc,height:$.fn.datagrid.defaults.editorHeight});
}
}};
};
};
var _7dd=$.extend({},_7cf(["text","textbox","passwordbox","filebox","numberbox","numberspinner","combobox","combotree","combogrid","combotreegrid","datebox","datetimebox","timespinner","datetimespinner"]),{textarea:{init:function(_7de,_7df){
var _7e0=$("<textarea class=\"datagrid-editable-input\"></textarea>").appendTo(_7de);
_7e0.css("vertical-align","middle")._outerHeight(_7df.height);
return _7e0;
},getValue:function(_7e1){
return $(_7e1).val();
},setValue:function(_7e2,_7e3){
$(_7e2).val(_7e3);
},resize:function(_7e4,_7e5){
$(_7e4)._outerWidth(_7e5);
}},checkbox:{init:function(_7e6,_7e7){
var _7e8=$("<input type=\"checkbox\">").appendTo(_7e6);
_7e8.val(_7e7.on);
_7e8.attr("offval",_7e7.off);
return _7e8;
},getValue:function(_7e9){
if($(_7e9).is(":checked")){
return $(_7e9).val();
}else{
return $(_7e9).attr("offval");
}
},setValue:function(_7ea,_7eb){
var _7ec=false;
if($(_7ea).val()==_7eb){
_7ec=true;
}
$(_7ea)._propAttr("checked",_7ec);
}},validatebox:{init:function(_7ed,_7ee){
var _7ef=$("<input type=\"text\" class=\"datagrid-editable-input\">").appendTo(_7ed);
_7ef.validatebox(_7ee);
return _7ef;
},destroy:function(_7f0){
$(_7f0).validatebox("destroy");
},getValue:function(_7f1){
return $(_7f1).val();
},setValue:function(_7f2,_7f3){
$(_7f2).val(_7f3);
},resize:function(_7f4,_7f5){
$(_7f4)._outerWidth(_7f5)._outerHeight($.fn.datagrid.defaults.editorHeight);
}}});
$.fn.datagrid.methods={options:function(jq){
var _7f6=$.data(jq[0],"datagrid").options;
var _7f7=$.data(jq[0],"datagrid").panel.panel("options");
var opts=$.extend(_7f6,{width:_7f7.width,height:_7f7.height,closed:_7f7.closed,collapsed:_7f7.collapsed,minimized:_7f7.minimized,maximized:_7f7.maximized});
return opts;
},setSelectionState:function(jq){
return jq.each(function(){
_72d(this);
});
},createStyleSheet:function(jq){
return _64b(jq[0]);
},getPanel:function(jq){
return $.data(jq[0],"datagrid").panel;
},getPager:function(jq){
return $.data(jq[0],"datagrid").panel.children("div.datagrid-pager");
},getColumnFields:function(jq,_7f8){
return _6a2(jq[0],_7f8);
},getColumnOption:function(jq,_7f9){
return _6a3(jq[0],_7f9);
},resize:function(jq,_7fa){
return jq.each(function(){
_65a(this,_7fa);
});
},load:function(jq,_7fb){
return jq.each(function(){
var opts=$(this).datagrid("options");
if(typeof _7fb=="string"){
opts.url=_7fb;
_7fb=null;
}
opts.pageNumber=1;
var _7fc=$(this).datagrid("getPager");
_7fc.pagination("refresh",{pageNumber:1});
_6df(this,_7fb);
});
},reload:function(jq,_7fd){
return jq.each(function(){
var opts=$(this).datagrid("options");
if(typeof _7fd=="string"){
opts.url=_7fd;
_7fd=null;
}
_6df(this,_7fd);
});
},reloadFooter:function(jq,_7fe){
return jq.each(function(){
var opts=$.data(this,"datagrid").options;
var dc=$.data(this,"datagrid").dc;
if(_7fe){
$.data(this,"datagrid").footer=_7fe;
}
if(opts.showFooter){
opts.view.renderFooter.call(opts.view,this,dc.footer2,false);
opts.view.renderFooter.call(opts.view,this,dc.footer1,true);
if(opts.view.onAfterRender){
opts.view.onAfterRender.call(opts.view,this);
}
$(this).datagrid("fixRowHeight");
}
});
},loading:function(jq){
return jq.each(function(){
var opts=$.data(this,"datagrid").options;
$(this).datagrid("getPager").pagination("loading");
if(opts.loadMsg){
var _7ff=$(this).datagrid("getPanel");
if(!_7ff.children("div.datagrid-mask").length){
$("<div class=\"datagrid-mask\" style=\"display:block\"></div>").appendTo(_7ff);
var msg=$("<div class=\"datagrid-mask-msg\" style=\"display:block;left:50%\"></div>").html(opts.loadMsg).appendTo(_7ff);
msg._outerHeight(40);
msg.css({marginLeft:(-msg.outerWidth()/2),lineHeight:(msg.height()+"px")});
}
}
});
},loaded:function(jq){
return jq.each(function(){
$(this).datagrid("getPager").pagination("loaded");
var _800=$(this).datagrid("getPanel");
_800.children("div.datagrid-mask-msg").remove();
_800.children("div.datagrid-mask").remove();
});
},fitColumns:function(jq){
return jq.each(function(){
_6ec(this);
});
},fixColumnSize:function(jq,_801){
return jq.each(function(){
_70a(this,_801);
});
},fixRowHeight:function(jq,_802){
return jq.each(function(){
_670(this,_802);
});
},freezeRow:function(jq,_803){
return jq.each(function(){
_67d(this,_803);
});
},autoSizeColumn:function(jq,_804){
return jq.each(function(){
_6fe(this,_804);
});
},loadData:function(jq,data){
return jq.each(function(){
_6e0(this,data);
_7ae(this);
});
},getData:function(jq){
return $.data(jq[0],"datagrid").data;
},getRows:function(jq){
return $.data(jq[0],"datagrid").data.rows;
},getFooterRows:function(jq){
return $.data(jq[0],"datagrid").footer;
},getRowIndex:function(jq,id){
return _735(jq[0],id);
},getChecked:function(jq){
return _73b(jq[0]);
},getSelected:function(jq){
var rows=_738(jq[0]);
return rows.length>0?rows[0]:null;
},getSelections:function(jq){
return _738(jq[0]);
},clearSelections:function(jq){
return jq.each(function(){
var _805=$.data(this,"datagrid");
var _806=_805.selectedRows;
var _807=_805.checkedRows;
_806.splice(0,_806.length);
_74e(this);
if(_805.options.checkOnSelect){
_807.splice(0,_807.length);
}
});
},clearChecked:function(jq){
return jq.each(function(){
var _808=$.data(this,"datagrid");
var _809=_808.selectedRows;
var _80a=_808.checkedRows;
_80a.splice(0,_80a.length);
_6b5(this);
if(_808.options.selectOnCheck){
_809.splice(0,_809.length);
}
});
},scrollTo:function(jq,_80b){
return jq.each(function(){
_73e(this,_80b);
});
},highlightRow:function(jq,_80c){
return jq.each(function(){
_6c2(this,_80c);
_73e(this,_80c);
});
},selectAll:function(jq){
return jq.each(function(){
_753(this);
});
},unselectAll:function(jq){
return jq.each(function(){
_74e(this);
});
},selectRow:function(jq,_80d){
return jq.each(function(){
_6c9(this,_80d);
});
},selectRecord:function(jq,id){
return jq.each(function(){
var opts=$.data(this,"datagrid").options;
if(opts.idField){
var _80e=_735(this,id);
if(_80e>=0){
$(this).datagrid("selectRow",_80e);
}
}
});
},unselectRow:function(jq,_80f){
return jq.each(function(){
_6ca(this,_80f);
});
},checkRow:function(jq,_810){
return jq.each(function(){
_6c6(this,_810);
});
},uncheckRow:function(jq,_811){
return jq.each(function(){
_6c7(this,_811);
});
},checkAll:function(jq){
return jq.each(function(){
_6b4(this);
});
},uncheckAll:function(jq){
return jq.each(function(){
_6b5(this);
});
},beginEdit:function(jq,_812){
return jq.each(function(){
_76d(this,_812);
});
},endEdit:function(jq,_813){
return jq.each(function(){
_773(this,_813,false);
});
},cancelEdit:function(jq,_814){
return jq.each(function(){
_773(this,_814,true);
});
},getEditors:function(jq,_815){
return _780(jq[0],_815);
},getEditor:function(jq,_816){
return _784(jq[0],_816);
},refreshRow:function(jq,_817){
return jq.each(function(){
var opts=$.data(this,"datagrid").options;
opts.view.refreshRow.call(opts.view,this,_817);
});
},validateRow:function(jq,_818){
return _772(jq[0],_818);
},updateRow:function(jq,_819){
return jq.each(function(){
_7a8(this,_819);
});
},appendRow:function(jq,row){
return jq.each(function(){
_7a5(this,row);
});
},insertRow:function(jq,_81a){
return jq.each(function(){
_7a1(this,_81a);
});
},deleteRow:function(jq,_81b){
return jq.each(function(){
_79b(this,_81b);
});
},getChanges:function(jq,_81c){
return _795(jq[0],_81c);
},acceptChanges:function(jq){
return jq.each(function(){
_7b2(this);
});
},rejectChanges:function(jq){
return jq.each(function(){
_7b4(this);
});
},mergeCells:function(jq,_81d){
return jq.each(function(){
_7c6(this,_81d);
});
},showColumn:function(jq,_81e){
return jq.each(function(){
var col=$(this).datagrid("getColumnOption",_81e);
if(col.hidden){
col.hidden=false;
$(this).datagrid("getPanel").find("td[field=\""+_81e+"\"]").show();
_6e1(this,_81e,1);
$(this).datagrid("fitColumns");
}
});
},hideColumn:function(jq,_81f){
return jq.each(function(){
var col=$(this).datagrid("getColumnOption",_81f);
if(!col.hidden){
col.hidden=true;
$(this).datagrid("getPanel").find("td[field=\""+_81f+"\"]").hide();
_6e1(this,_81f,-1);
$(this).datagrid("fitColumns");
}
});
},sort:function(jq,_820){
return jq.each(function(){
_6b6(this,_820);
});
},gotoPage:function(jq,_821){
return jq.each(function(){
var _822=this;
var page,cb;
if(typeof _821=="object"){
page=_821.page;
cb=_821.callback;
}else{
page=_821;
}
$(_822).datagrid("options").pageNumber=page;
$(_822).datagrid("getPager").pagination("refresh",{pageNumber:page});
_6df(_822,null,function(){
if(cb){
cb.call(_822,page);
}
});
});
}};
$.fn.datagrid.parseOptions=function(_823){
var t=$(_823);
return $.extend({},$.fn.panel.parseOptions(_823),$.parser.parseOptions(_823,["url","toolbar","idField","sortName","sortOrder","pagePosition","resizeHandle",{sharedStyleSheet:"boolean",fitColumns:"boolean",autoRowHeight:"boolean",striped:"boolean",nowrap:"boolean"},{rownumbers:"boolean",singleSelect:"boolean",ctrlSelect:"boolean",checkOnSelect:"boolean",selectOnCheck:"boolean"},{pagination:"boolean",pageSize:"number",pageNumber:"number"},{multiSort:"boolean",remoteSort:"boolean",showHeader:"boolean",showFooter:"boolean"},{scrollbarSize:"number",scrollOnSelect:"boolean"}]),{pageList:(t.attr("pageList")?eval(t.attr("pageList")):undefined),loadMsg:(t.attr("loadMsg")!=undefined?t.attr("loadMsg"):undefined),rowStyler:(t.attr("rowStyler")?eval(t.attr("rowStyler")):undefined)});
};
$.fn.datagrid.parseData=function(_824){
var t=$(_824);
var data={total:0,rows:[]};
var _825=t.datagrid("getColumnFields",true).concat(t.datagrid("getColumnFields",false));
t.find("tbody tr").each(function(){
data.total++;
var row={};
$.extend(row,$.parser.parseOptions(this,["iconCls","state"]));
for(var i=0;i<_825.length;i++){
row[_825[i]]=$(this).find("td:eq("+i+")").html();
}
data.rows.push(row);
});
return data;
};
var _826={render:function(_827,_828,_829){
var rows=$(_827).datagrid("getRows");
$(_828).html(this.renderTable(_827,0,rows,_829));
},renderFooter:function(_82a,_82b,_82c){
var opts=$.data(_82a,"datagrid").options;
var rows=$.data(_82a,"datagrid").footer||[];
var _82d=$(_82a).datagrid("getColumnFields",_82c);
var _82e=["<table class=\"datagrid-ftable\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>"];
for(var i=0;i<rows.length;i++){
_82e.push("<tr class=\"datagrid-row\" datagrid-row-index=\""+i+"\">");
_82e.push(this.renderRow.call(this,_82a,_82d,_82c,i,rows[i]));
_82e.push("</tr>");
}
_82e.push("</tbody></table>");
$(_82b).html(_82e.join(""));
},renderTable:function(_82f,_830,rows,_831){
var _832=$.data(_82f,"datagrid");
var opts=_832.options;
if(_831){
if(!(opts.rownumbers||(opts.frozenColumns&&opts.frozenColumns.length))){
return "";
}
}
var _833=$(_82f).datagrid("getColumnFields",_831);
var _834=["<table class=\"datagrid-btable\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>"];
for(var i=0;i<rows.length;i++){
var row=rows[i];
var css=opts.rowStyler?opts.rowStyler.call(_82f,_830,row):"";
var cs=this.getStyleValue(css);
var cls="class=\"datagrid-row "+(_830%2&&opts.striped?"datagrid-row-alt ":" ")+cs.c+"\"";
var _835=cs.s?"style=\""+cs.s+"\"":"";
var _836=_832.rowIdPrefix+"-"+(_831?1:2)+"-"+_830;
_834.push("<tr id=\""+_836+"\" datagrid-row-index=\""+_830+"\" "+cls+" "+_835+">");
_834.push(this.renderRow.call(this,_82f,_833,_831,_830,row));
_834.push("</tr>");
_830++;
}
_834.push("</tbody></table>");
return _834.join("");
},renderRow:function(_837,_838,_839,_83a,_83b){
var opts=$.data(_837,"datagrid").options;
var cc=[];
if(_839&&opts.rownumbers){
var _83c=_83a+1;
if(opts.pagination){
_83c+=(opts.pageNumber-1)*opts.pageSize;
}
cc.push("<td class=\"datagrid-td-rownumber\"><div class=\"datagrid-cell-rownumber\">"+_83c+"</div></td>");
}
for(var i=0;i<_838.length;i++){
var _83d=_838[i];
var col=$(_837).datagrid("getColumnOption",_83d);
if(col){
var _83e=_83b[_83d];
var css=col.styler?(col.styler.call(_837,_83e,_83b,_83a)||""):"";
var cs=this.getStyleValue(css);
var cls=cs.c?"class=\""+cs.c+"\"":"";
var _83f=col.hidden?"style=\"display:none;"+cs.s+"\"":(cs.s?"style=\""+cs.s+"\"":"");
cc.push("<td field=\""+_83d+"\" "+cls+" "+_83f+">");
var _83f="";
if(!col.checkbox){
if(col.align){
_83f+="text-align:"+col.align+";";
}
if(!opts.nowrap){
_83f+="white-space:normal;height:auto;";
}else{
if(opts.autoRowHeight){
_83f+="height:auto;";
}
}
}
cc.push("<div style=\""+_83f+"\" ");
cc.push(col.checkbox?"class=\"datagrid-cell-check\"":"class=\"datagrid-cell "+col.cellClass+"\"");
cc.push(">");
if(col.checkbox){
cc.push("<input type=\"checkbox\" "+(_83b.checked?"checked=\"checked\"":""));
cc.push(" name=\""+_83d+"\" value=\""+(_83e!=undefined?_83e:"")+"\">");
}else{
if(col.formatter){
cc.push(col.formatter(_83e,_83b,_83a));
}else{
cc.push(_83e);
}
}
cc.push("</div>");
cc.push("</td>");
}
}
return cc.join("");
},getStyleValue:function(css){
var _840="";
var _841="";
if(typeof css=="string"){
_841=css;
}else{
if(css){
_840=css["class"]||"";
_841=css["style"]||"";
}
}
return {c:_840,s:_841};
},refreshRow:function(_842,_843){
this.updateRow.call(this,_842,_843,{});
},updateRow:function(_844,_845,row){
var opts=$.data(_844,"datagrid").options;
var _846=opts.finder.getRow(_844,_845);
$.extend(_846,row);
var cs=_847.call(this,_845);
var _848=cs.s;
var cls="datagrid-row "+(_845%2&&opts.striped?"datagrid-row-alt ":" ")+cs.c;
function _847(_849){
var css=opts.rowStyler?opts.rowStyler.call(_844,_849,_846):"";
return this.getStyleValue(css);
};
function _84a(_84b){
var tr=opts.finder.getTr(_844,_845,"body",(_84b?1:2));
if(!tr.length){
return;
}
var _84c=$(_844).datagrid("getColumnFields",_84b);
var _84d=tr.find("div.datagrid-cell-check input[type=checkbox]").is(":checked");
tr.html(this.renderRow.call(this,_844,_84c,_84b,_845,_846));
var _84e=(tr.hasClass("datagrid-row-checked")?" datagrid-row-checked":"")+(tr.hasClass("datagrid-row-selected")?" datagrid-row-selected":"");
tr.attr("style",_848).attr("class",cls+_84e);
if(_84d){
tr.find("div.datagrid-cell-check input[type=checkbox]")._propAttr("checked",true);
}
};
_84a.call(this,true);
_84a.call(this,false);
$(_844).datagrid("fixRowHeight",_845);
},insertRow:function(_84f,_850,row){
var _851=$.data(_84f,"datagrid");
var opts=_851.options;
var dc=_851.dc;
var data=_851.data;
if(_850==undefined||_850==null){
_850=data.rows.length;
}
if(_850>data.rows.length){
_850=data.rows.length;
}
function _852(_853){
var _854=_853?1:2;
for(var i=data.rows.length-1;i>=_850;i--){
var tr=opts.finder.getTr(_84f,i,"body",_854);
tr.attr("datagrid-row-index",i+1);
tr.attr("id",_851.rowIdPrefix+"-"+_854+"-"+(i+1));
if(_853&&opts.rownumbers){
var _855=i+2;
if(opts.pagination){
_855+=(opts.pageNumber-1)*opts.pageSize;
}
tr.find("div.datagrid-cell-rownumber").html(_855);
}
if(opts.striped){
tr.removeClass("datagrid-row-alt").addClass((i+1)%2?"datagrid-row-alt":"");
}
}
};
function _856(_857){
var _858=_857?1:2;
var _859=$(_84f).datagrid("getColumnFields",_857);
var _85a=_851.rowIdPrefix+"-"+_858+"-"+_850;
var tr="<tr id=\""+_85a+"\" class=\"datagrid-row\" datagrid-row-index=\""+_850+"\"></tr>";
if(_850>=data.rows.length){
if(data.rows.length){
opts.finder.getTr(_84f,"","last",_858).after(tr);
}else{
var cc=_857?dc.body1:dc.body2;
cc.html("<table class=\"datagrid-btable\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>"+tr+"</tbody></table>");
}
}else{
opts.finder.getTr(_84f,_850+1,"body",_858).before(tr);
}
};
_852.call(this,true);
_852.call(this,false);
_856.call(this,true);
_856.call(this,false);
data.total+=1;
data.rows.splice(_850,0,row);
this.setEmptyMsg(_84f);
this.refreshRow.call(this,_84f,_850);
},deleteRow:function(_85b,_85c){
var _85d=$.data(_85b,"datagrid");
var opts=_85d.options;
var data=_85d.data;
function _85e(_85f){
var _860=_85f?1:2;
for(var i=_85c+1;i<data.rows.length;i++){
var tr=opts.finder.getTr(_85b,i,"body",_860);
tr.attr("datagrid-row-index",i-1);
tr.attr("id",_85d.rowIdPrefix+"-"+_860+"-"+(i-1));
if(_85f&&opts.rownumbers){
var _861=i;
if(opts.pagination){
_861+=(opts.pageNumber-1)*opts.pageSize;
}
tr.find("div.datagrid-cell-rownumber").html(_861);
}
if(opts.striped){
tr.removeClass("datagrid-row-alt").addClass((i-1)%2?"datagrid-row-alt":"");
}
}
};
opts.finder.getTr(_85b,_85c).remove();
_85e.call(this,true);
_85e.call(this,false);
data.total-=1;
data.rows.splice(_85c,1);
this.setEmptyMsg(_85b);
},onBeforeRender:function(_862,rows){
},onAfterRender:function(_863){
var _864=$.data(_863,"datagrid");
var opts=_864.options;
if(opts.showFooter){
var _865=$(_863).datagrid("getPanel").find("div.datagrid-footer");
_865.find("div.datagrid-cell-rownumber,div.datagrid-cell-check").css("visibility","hidden");
}
this.setEmptyMsg(_863);
},setEmptyMsg:function(_866){
var _867=$.data(_866,"datagrid");
var opts=_867.options;
var _868=opts.finder.getRows(_866).length==0;
if(_868){
this.renderEmptyRow(_866);
}
if(opts.emptyMsg){
_867.dc.view.children(".datagrid-empty").remove();
if(_868){
var h=_867.dc.header2.parent().outerHeight();
var d=$("<div class=\"datagrid-empty\"></div>").appendTo(_867.dc.view);
d.html(opts.emptyMsg).css("top",h+"px");
}
}
},renderEmptyRow:function(_869){
var cols=$.map($(_869).datagrid("getColumnFields"),function(_86a){
return $(_869).datagrid("getColumnOption",_86a);
});
$.map(cols,function(col){
col.formatter1=col.formatter;
col.styler1=col.styler;
col.formatter=col.styler=undefined;
});
var _86b=$.data(_869,"datagrid").dc.body2;
_86b.html(this.renderTable(_869,0,[{}],false));
_86b.find("tbody *").css({height:1,borderColor:"transparent",background:"transparent"});
var tr=_86b.find(".datagrid-row");
tr.removeClass("datagrid-row").removeAttr("datagrid-row-index");
tr.find(".datagrid-cell,.datagrid-cell-check").empty();
$.map(cols,function(col){
col.formatter=col.formatter1;
col.styler=col.styler1;
col.formatter1=col.styler1=undefined;
});
}};
$.fn.datagrid.defaults=$.extend({},$.fn.panel.defaults,{sharedStyleSheet:false,frozenColumns:undefined,columns:undefined,fitColumns:false,resizeHandle:"right",autoRowHeight:true,toolbar:null,striped:false,method:"post",nowrap:true,idField:null,url:null,data:null,loadMsg:"Processing, please wait ...",emptyMsg:"",rownumbers:false,singleSelect:false,ctrlSelect:false,selectOnCheck:true,checkOnSelect:true,pagination:false,pagePosition:"bottom",pageNumber:1,pageSize:10,pageList:[10,20,30,40,50],queryParams:{},sortName:null,sortOrder:"asc",multiSort:false,remoteSort:true,showHeader:true,showFooter:false,scrollOnSelect:true,scrollbarSize:18,rownumberWidth:30,editorHeight:24,headerEvents:{mouseover:_6ae(true),mouseout:_6ae(false),click:_6b2,dblclick:_6b7,contextmenu:_6ba},rowEvents:{mouseover:_6bc(true),mouseout:_6bc(false),click:_6c3,dblclick:_6cd,contextmenu:_6d1},rowStyler:function(_86c,_86d){
},loader:function(_86e,_86f,_870){
var opts=$(this).datagrid("options");
if(!opts.url){
return false;
}
$.ajax({type:opts.method,url:opts.url,data:_86e,dataType:"json",success:function(data){
_86f(data);
},error:function(){
_870.apply(this,arguments);
}});
},loadFilter:function(data){
return data;
},editors:_7dd,finder:{getTr:function(_871,_872,type,_873){
type=type||"body";
_873=_873||0;
var _874=$.data(_871,"datagrid");
var dc=_874.dc;
var opts=_874.options;
if(_873==0){
var tr1=opts.finder.getTr(_871,_872,type,1);
var tr2=opts.finder.getTr(_871,_872,type,2);
return tr1.add(tr2);
}else{
if(type=="body"){
var tr=$("#"+_874.rowIdPrefix+"-"+_873+"-"+_872);
if(!tr.length){
tr=(_873==1?dc.body1:dc.body2).find(">table>tbody>tr[datagrid-row-index="+_872+"]");
}
return tr;
}else{
if(type=="footer"){
return (_873==1?dc.footer1:dc.footer2).find(">table>tbody>tr[datagrid-row-index="+_872+"]");
}else{
if(type=="selected"){
return (_873==1?dc.body1:dc.body2).find(">table>tbody>tr.datagrid-row-selected");
}else{
if(type=="highlight"){
return (_873==1?dc.body1:dc.body2).find(">table>tbody>tr.datagrid-row-over");
}else{
if(type=="checked"){
return (_873==1?dc.body1:dc.body2).find(">table>tbody>tr.datagrid-row-checked");
}else{
if(type=="editing"){
return (_873==1?dc.body1:dc.body2).find(">table>tbody>tr.datagrid-row-editing");
}else{
if(type=="last"){
return (_873==1?dc.body1:dc.body2).find(">table>tbody>tr[datagrid-row-index]:last");
}else{
if(type=="allbody"){
return (_873==1?dc.body1:dc.body2).find(">table>tbody>tr[datagrid-row-index]");
}else{
if(type=="allfooter"){
return (_873==1?dc.footer1:dc.footer2).find(">table>tbody>tr[datagrid-row-index]");
}
}
}
}
}
}
}
}
}
}
},getRow:function(_875,p){
var _876=(typeof p=="object")?p.attr("datagrid-row-index"):p;
return $.data(_875,"datagrid").data.rows[parseInt(_876)];
},getRows:function(_877){
return $(_877).datagrid("getRows");
}},view:_826,onBeforeLoad:function(_878){
},onLoadSuccess:function(){
},onLoadError:function(){
},onClickRow:function(_879,_87a){
},onDblClickRow:function(_87b,_87c){
},onClickCell:function(_87d,_87e,_87f){
},onDblClickCell:function(_880,_881,_882){
},onBeforeSortColumn:function(sort,_883){
},onSortColumn:function(sort,_884){
},onResizeColumn:function(_885,_886){
},onBeforeSelect:function(_887,_888){
},onSelect:function(_889,_88a){
},onBeforeUnselect:function(_88b,_88c){
},onUnselect:function(_88d,_88e){
},onSelectAll:function(rows){
},onUnselectAll:function(rows){
},onBeforeCheck:function(_88f,_890){
},onCheck:function(_891,_892){
},onBeforeUncheck:function(_893,_894){
},onUncheck:function(_895,_896){
},onCheckAll:function(rows){
},onUncheckAll:function(rows){
},onBeforeEdit:function(_897,_898){
},onBeginEdit:function(_899,_89a){
},onEndEdit:function(_89b,_89c,_89d){
},onAfterEdit:function(_89e,_89f,_8a0){
},onCancelEdit:function(_8a1,_8a2){
},onHeaderContextMenu:function(e,_8a3){
},onRowContextMenu:function(e,_8a4,_8a5){
}});
})(jQuery);
(function($){
var _8a6;
$(document).unbind(".propertygrid").bind("mousedown.propertygrid",function(e){
var p=$(e.target).closest("div.datagrid-view,div.combo-panel");
if(p.length){
return;
}
_8a7(_8a6);
_8a6=undefined;
});
function _8a8(_8a9){
var _8aa=$.data(_8a9,"propertygrid");
var opts=$.data(_8a9,"propertygrid").options;
$(_8a9).datagrid($.extend({},opts,{cls:"propertygrid",view:(opts.showGroup?opts.groupView:opts.view),onBeforeEdit:function(_8ab,row){
if(opts.onBeforeEdit.call(_8a9,_8ab,row)==false){
return false;
}
var dg=$(this);
var row=dg.datagrid("getRows")[_8ab];
var col=dg.datagrid("getColumnOption","value");
col.editor=row.editor;
},onClickCell:function(_8ac,_8ad,_8ae){
if(_8a6!=this){
_8a7(_8a6);
_8a6=this;
}
if(opts.editIndex!=_8ac){
_8a7(_8a6);
$(this).datagrid("beginEdit",_8ac);
var ed=$(this).datagrid("getEditor",{index:_8ac,field:_8ad});
if(!ed){
ed=$(this).datagrid("getEditor",{index:_8ac,field:"value"});
}
if(ed){
var t=$(ed.target);
var _8af=t.data("textbox")?t.textbox("textbox"):t;
_8af.focus();
opts.editIndex=_8ac;
}
}
opts.onClickCell.call(_8a9,_8ac,_8ad,_8ae);
},loadFilter:function(data){
_8a7(this);
return opts.loadFilter.call(this,data);
}}));
};
function _8a7(_8b0){
var t=$(_8b0);
if(!t.length){
return;
}
var opts=$.data(_8b0,"propertygrid").options;
opts.finder.getTr(_8b0,null,"editing").each(function(){
var _8b1=parseInt($(this).attr("datagrid-row-index"));
if(t.datagrid("validateRow",_8b1)){
t.datagrid("endEdit",_8b1);
}else{
t.datagrid("cancelEdit",_8b1);
}
});
opts.editIndex=undefined;
};
$.fn.propertygrid=function(_8b2,_8b3){
if(typeof _8b2=="string"){
var _8b4=$.fn.propertygrid.methods[_8b2];
if(_8b4){
return _8b4(this,_8b3);
}else{
return this.datagrid(_8b2,_8b3);
}
}
_8b2=_8b2||{};
return this.each(function(){
var _8b5=$.data(this,"propertygrid");
if(_8b5){
$.extend(_8b5.options,_8b2);
}else{
var opts=$.extend({},$.fn.propertygrid.defaults,$.fn.propertygrid.parseOptions(this),_8b2);
opts.frozenColumns=$.extend(true,[],opts.frozenColumns);
opts.columns=$.extend(true,[],opts.columns);
$.data(this,"propertygrid",{options:opts});
}
_8a8(this);
});
};
$.fn.propertygrid.methods={options:function(jq){
return $.data(jq[0],"propertygrid").options;
}};
$.fn.propertygrid.parseOptions=function(_8b6){
return $.extend({},$.fn.datagrid.parseOptions(_8b6),$.parser.parseOptions(_8b6,[{showGroup:"boolean"}]));
};
var _8b7=$.extend({},$.fn.datagrid.defaults.view,{render:function(_8b8,_8b9,_8ba){
var _8bb=[];
var _8bc=this.groups;
for(var i=0;i<_8bc.length;i++){
_8bb.push(this.renderGroup.call(this,_8b8,i,_8bc[i],_8ba));
}
$(_8b9).html(_8bb.join(""));
},renderGroup:function(_8bd,_8be,_8bf,_8c0){
var _8c1=$.data(_8bd,"datagrid");
var opts=_8c1.options;
var _8c2=$(_8bd).datagrid("getColumnFields",_8c0);
var _8c3=[];
_8c3.push("<div class=\"datagrid-group\" group-index="+_8be+">");
if((_8c0&&(opts.rownumbers||opts.frozenColumns.length))||(!_8c0&&!(opts.rownumbers||opts.frozenColumns.length))){
_8c3.push("<span class=\"datagrid-group-expander\">");
_8c3.push("<span class=\"datagrid-row-expander datagrid-row-collapse\">&nbsp;</span>");
_8c3.push("</span>");
}
if(!_8c0){
_8c3.push("<span class=\"datagrid-group-title\">");
_8c3.push(opts.groupFormatter.call(_8bd,_8bf.value,_8bf.rows));
_8c3.push("</span>");
}
_8c3.push("</div>");
_8c3.push("<table class=\"datagrid-btable\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>");
var _8c4=_8bf.startIndex;
for(var j=0;j<_8bf.rows.length;j++){
var css=opts.rowStyler?opts.rowStyler.call(_8bd,_8c4,_8bf.rows[j]):"";
var _8c5="";
var _8c6="";
if(typeof css=="string"){
_8c6=css;
}else{
if(css){
_8c5=css["class"]||"";
_8c6=css["style"]||"";
}
}
var cls="class=\"datagrid-row "+(_8c4%2&&opts.striped?"datagrid-row-alt ":" ")+_8c5+"\"";
var _8c7=_8c6?"style=\""+_8c6+"\"":"";
var _8c8=_8c1.rowIdPrefix+"-"+(_8c0?1:2)+"-"+_8c4;
_8c3.push("<tr id=\""+_8c8+"\" datagrid-row-index=\""+_8c4+"\" "+cls+" "+_8c7+">");
_8c3.push(this.renderRow.call(this,_8bd,_8c2,_8c0,_8c4,_8bf.rows[j]));
_8c3.push("</tr>");
_8c4++;
}
_8c3.push("</tbody></table>");
return _8c3.join("");
},bindEvents:function(_8c9){
var _8ca=$.data(_8c9,"datagrid");
var dc=_8ca.dc;
var body=dc.body1.add(dc.body2);
var _8cb=($.data(body[0],"events")||$._data(body[0],"events")).click[0].handler;
body.unbind("click").bind("click",function(e){
var tt=$(e.target);
var _8cc=tt.closest("span.datagrid-row-expander");
if(_8cc.length){
var _8cd=_8cc.closest("div.datagrid-group").attr("group-index");
if(_8cc.hasClass("datagrid-row-collapse")){
$(_8c9).datagrid("collapseGroup",_8cd);
}else{
$(_8c9).datagrid("expandGroup",_8cd);
}
}else{
_8cb(e);
}
e.stopPropagation();
});
},onBeforeRender:function(_8ce,rows){
var _8cf=$.data(_8ce,"datagrid");
var opts=_8cf.options;
_8d0();
var _8d1=[];
for(var i=0;i<rows.length;i++){
var row=rows[i];
var _8d2=_8d3(row[opts.groupField]);
if(!_8d2){
_8d2={value:row[opts.groupField],rows:[row]};
_8d1.push(_8d2);
}else{
_8d2.rows.push(row);
}
}
var _8d4=0;
var _8d5=[];
for(var i=0;i<_8d1.length;i++){
var _8d2=_8d1[i];
_8d2.startIndex=_8d4;
_8d4+=_8d2.rows.length;
_8d5=_8d5.concat(_8d2.rows);
}
_8cf.data.rows=_8d5;
this.groups=_8d1;
var that=this;
setTimeout(function(){
that.bindEvents(_8ce);
},0);
function _8d3(_8d6){
for(var i=0;i<_8d1.length;i++){
var _8d7=_8d1[i];
if(_8d7.value==_8d6){
return _8d7;
}
}
return null;
};
function _8d0(){
if(!$("#datagrid-group-style").length){
$("head").append("<style id=\"datagrid-group-style\">"+".datagrid-group{height:"+opts.groupHeight+"px;overflow:hidden;font-weight:bold;border-bottom:1px solid #ccc;}"+".datagrid-group-title,.datagrid-group-expander{display:inline-block;vertical-align:bottom;height:100%;line-height:"+opts.groupHeight+"px;padding:0 4px;}"+".datagrid-group-expander{width:"+opts.expanderWidth+"px;text-align:center;padding:0}"+".datagrid-row-expander{margin:"+Math.floor((opts.groupHeight-16)/2)+"px 0;display:inline-block;width:16px;height:16px;cursor:pointer}"+"</style>");
}
};
}});
$.extend($.fn.datagrid.methods,{groups:function(jq){
return jq.datagrid("options").view.groups;
},expandGroup:function(jq,_8d8){
return jq.each(function(){
var view=$.data(this,"datagrid").dc.view;
var _8d9=view.find(_8d8!=undefined?"div.datagrid-group[group-index=\""+_8d8+"\"]":"div.datagrid-group");
var _8da=_8d9.find("span.datagrid-row-expander");
if(_8da.hasClass("datagrid-row-expand")){
_8da.removeClass("datagrid-row-expand").addClass("datagrid-row-collapse");
_8d9.next("table").show();
}
$(this).datagrid("fixRowHeight");
});
},collapseGroup:function(jq,_8db){
return jq.each(function(){
var view=$.data(this,"datagrid").dc.view;
var _8dc=view.find(_8db!=undefined?"div.datagrid-group[group-index=\""+_8db+"\"]":"div.datagrid-group");
var _8dd=_8dc.find("span.datagrid-row-expander");
if(_8dd.hasClass("datagrid-row-collapse")){
_8dd.removeClass("datagrid-row-collapse").addClass("datagrid-row-expand");
_8dc.next("table").hide();
}
$(this).datagrid("fixRowHeight");
});
}});
$.extend(_8b7,{refreshGroupTitle:function(_8de,_8df){
var _8e0=$.data(_8de,"datagrid");
var opts=_8e0.options;
var dc=_8e0.dc;
var _8e1=this.groups[_8df];
var span=dc.body2.children("div.datagrid-group[group-index="+_8df+"]").find("span.datagrid-group-title");
span.html(opts.groupFormatter.call(_8de,_8e1.value,_8e1.rows));
},insertRow:function(_8e2,_8e3,row){
var _8e4=$.data(_8e2,"datagrid");
var opts=_8e4.options;
var dc=_8e4.dc;
var _8e5=null;
var _8e6;
if(!_8e4.data.rows.length){
$(_8e2).datagrid("loadData",[row]);
return;
}
for(var i=0;i<this.groups.length;i++){
if(this.groups[i].value==row[opts.groupField]){
_8e5=this.groups[i];
_8e6=i;
break;
}
}
if(_8e5){
if(_8e3==undefined||_8e3==null){
_8e3=_8e4.data.rows.length;
}
if(_8e3<_8e5.startIndex){
_8e3=_8e5.startIndex;
}else{
if(_8e3>_8e5.startIndex+_8e5.rows.length){
_8e3=_8e5.startIndex+_8e5.rows.length;
}
}
$.fn.datagrid.defaults.view.insertRow.call(this,_8e2,_8e3,row);
if(_8e3>=_8e5.startIndex+_8e5.rows.length){
_8e7(_8e3,true);
_8e7(_8e3,false);
}
_8e5.rows.splice(_8e3-_8e5.startIndex,0,row);
}else{
_8e5={value:row[opts.groupField],rows:[row],startIndex:_8e4.data.rows.length};
_8e6=this.groups.length;
dc.body1.append(this.renderGroup.call(this,_8e2,_8e6,_8e5,true));
dc.body2.append(this.renderGroup.call(this,_8e2,_8e6,_8e5,false));
this.groups.push(_8e5);
_8e4.data.rows.push(row);
}
this.refreshGroupTitle(_8e2,_8e6);
function _8e7(_8e8,_8e9){
var _8ea=_8e9?1:2;
var _8eb=opts.finder.getTr(_8e2,_8e8-1,"body",_8ea);
var tr=opts.finder.getTr(_8e2,_8e8,"body",_8ea);
tr.insertAfter(_8eb);
};
},updateRow:function(_8ec,_8ed,row){
var opts=$.data(_8ec,"datagrid").options;
$.fn.datagrid.defaults.view.updateRow.call(this,_8ec,_8ed,row);
var tb=opts.finder.getTr(_8ec,_8ed,"body",2).closest("table.datagrid-btable");
var _8ee=parseInt(tb.prev().attr("group-index"));
this.refreshGroupTitle(_8ec,_8ee);
},deleteRow:function(_8ef,_8f0){
var _8f1=$.data(_8ef,"datagrid");
var opts=_8f1.options;
var dc=_8f1.dc;
var body=dc.body1.add(dc.body2);
var tb=opts.finder.getTr(_8ef,_8f0,"body",2).closest("table.datagrid-btable");
var _8f2=parseInt(tb.prev().attr("group-index"));
$.fn.datagrid.defaults.view.deleteRow.call(this,_8ef,_8f0);
var _8f3=this.groups[_8f2];
if(_8f3.rows.length>1){
_8f3.rows.splice(_8f0-_8f3.startIndex,1);
this.refreshGroupTitle(_8ef,_8f2);
}else{
body.children("div.datagrid-group[group-index="+_8f2+"]").remove();
for(var i=_8f2+1;i<this.groups.length;i++){
body.children("div.datagrid-group[group-index="+i+"]").attr("group-index",i-1);
}
this.groups.splice(_8f2,1);
}
var _8f0=0;
for(var i=0;i<this.groups.length;i++){
var _8f3=this.groups[i];
_8f3.startIndex=_8f0;
_8f0+=_8f3.rows.length;
}
}});
$.fn.propertygrid.defaults=$.extend({},$.fn.datagrid.defaults,{groupHeight:21,expanderWidth:16,singleSelect:true,remoteSort:false,fitColumns:true,loadMsg:"",frozenColumns:[[{field:"f",width:16,resizable:false}]],columns:[[{field:"name",title:"Name",width:100,sortable:true},{field:"value",title:"Value",width:100,resizable:false}]],showGroup:false,groupView:_8b7,groupField:"group",groupFormatter:function(_8f4,rows){
return _8f4;
}});
})(jQuery);
(function($){
function _8f5(_8f6){
var _8f7=$.data(_8f6,"treegrid");
var opts=_8f7.options;
$(_8f6).datagrid($.extend({},opts,{url:null,data:null,loader:function(){
return false;
},onBeforeLoad:function(){
return false;
},onLoadSuccess:function(){
},onResizeColumn:function(_8f8,_8f9){
_906(_8f6);
opts.onResizeColumn.call(_8f6,_8f8,_8f9);
},onBeforeSortColumn:function(sort,_8fa){
if(opts.onBeforeSortColumn.call(_8f6,sort,_8fa)==false){
return false;
}
},onSortColumn:function(sort,_8fb){
opts.sortName=sort;
opts.sortOrder=_8fb;
if(opts.remoteSort){
_905(_8f6);
}else{
var data=$(_8f6).treegrid("getData");
_934(_8f6,null,data);
}
opts.onSortColumn.call(_8f6,sort,_8fb);
},onClickCell:function(_8fc,_8fd){
opts.onClickCell.call(_8f6,_8fd,find(_8f6,_8fc));
},onDblClickCell:function(_8fe,_8ff){
opts.onDblClickCell.call(_8f6,_8ff,find(_8f6,_8fe));
},onRowContextMenu:function(e,_900){
opts.onContextMenu.call(_8f6,e,find(_8f6,_900));
}}));
var _901=$.data(_8f6,"datagrid").options;
opts.columns=_901.columns;
opts.frozenColumns=_901.frozenColumns;
_8f7.dc=$.data(_8f6,"datagrid").dc;
if(opts.pagination){
var _902=$(_8f6).datagrid("getPager");
_902.pagination({pageNumber:opts.pageNumber,pageSize:opts.pageSize,pageList:opts.pageList,onSelectPage:function(_903,_904){
opts.pageNumber=_903;
opts.pageSize=_904;
_905(_8f6);
}});
opts.pageSize=_902.pagination("options").pageSize;
}
};
function _906(_907,_908){
var opts=$.data(_907,"datagrid").options;
var dc=$.data(_907,"datagrid").dc;
if(!dc.body1.is(":empty")&&(!opts.nowrap||opts.autoRowHeight)){
if(_908!=undefined){
var _909=_90a(_907,_908);
for(var i=0;i<_909.length;i++){
_90b(_909[i][opts.idField]);
}
}
}
$(_907).datagrid("fixRowHeight",_908);
function _90b(_90c){
var tr1=opts.finder.getTr(_907,_90c,"body",1);
var tr2=opts.finder.getTr(_907,_90c,"body",2);
tr1.css("height","");
tr2.css("height","");
var _90d=Math.max(tr1.height(),tr2.height());
tr1.css("height",_90d);
tr2.css("height",_90d);
};
};
function _90e(_90f){
var dc=$.data(_90f,"datagrid").dc;
var opts=$.data(_90f,"treegrid").options;
if(!opts.rownumbers){
return;
}
dc.body1.find("div.datagrid-cell-rownumber").each(function(i){
$(this).html(i+1);
});
};
function _910(_911){
return function(e){
$.fn.datagrid.defaults.rowEvents[_911?"mouseover":"mouseout"](e);
var tt=$(e.target);
var fn=_911?"addClass":"removeClass";
if(tt.hasClass("tree-hit")){
tt.hasClass("tree-expanded")?tt[fn]("tree-expanded-hover"):tt[fn]("tree-collapsed-hover");
}
};
};
function _912(e){
var tt=$(e.target);
var tr=tt.closest("tr.datagrid-row");
if(!tr.length||!tr.parent().length){
return;
}
var _913=tr.attr("node-id");
var _914=_915(tr);
if(tt.hasClass("tree-hit")){
_916(_914,_913);
}else{
if(tt.hasClass("tree-checkbox")){
_917(_914,_913);
}else{
var opts=$(_914).datagrid("options");
if(!tt.parent().hasClass("datagrid-cell-check")&&!opts.singleSelect&&e.shiftKey){
var rows=$(_914).treegrid("getChildren");
var idx1=$.easyui.indexOfArray(rows,opts.idField,opts.lastSelectedIndex);
var idx2=$.easyui.indexOfArray(rows,opts.idField,_913);
var from=Math.min(Math.max(idx1,0),idx2);
var to=Math.max(idx1,idx2);
var row=rows[idx2];
var td=tt.closest("td[field]",tr);
if(td.length){
var _918=td.attr("field");
opts.onClickCell.call(_914,_913,_918,row[_918]);
}
$(_914).treegrid("clearSelections");
for(var i=from;i<=to;i++){
$(_914).treegrid("selectRow",rows[i][opts.idField]);
}
opts.onClickRow.call(_914,row);
}else{
$.fn.datagrid.defaults.rowEvents.click(e);
}
}
}
};
function _915(t){
return $(t).closest("div.datagrid-view").children(".datagrid-f")[0];
};
function _917(_919,_91a,_91b,_91c){
var _91d=$.data(_919,"treegrid");
var _91e=_91d.checkedRows;
var opts=_91d.options;
if(!opts.checkbox){
return;
}
var row=find(_919,_91a);
if(!row.checkState){
return;
}
var tr=opts.finder.getTr(_919,_91a);
var ck=tr.find(".tree-checkbox");
if(_91b==undefined){
if(ck.hasClass("tree-checkbox1")){
_91b=false;
}else{
if(ck.hasClass("tree-checkbox0")){
_91b=true;
}else{
if(row._checked==undefined){
row._checked=ck.hasClass("tree-checkbox1");
}
_91b=!row._checked;
}
}
}
row._checked=_91b;
if(_91b){
if(ck.hasClass("tree-checkbox1")){
return;
}
}else{
if(ck.hasClass("tree-checkbox0")){
return;
}
}
if(!_91c){
if(opts.onBeforeCheckNode.call(_919,row,_91b)==false){
return;
}
}
if(opts.cascadeCheck){
_91f(_919,row,_91b);
_920(_919,row);
}else{
_921(_919,row,_91b?"1":"0");
}
if(!_91c){
opts.onCheckNode.call(_919,row,_91b);
}
};
function _921(_922,row,flag){
var _923=$.data(_922,"treegrid");
var _924=_923.checkedRows;
var opts=_923.options;
if(!row.checkState||flag==undefined){
return;
}
var tr=opts.finder.getTr(_922,row[opts.idField]);
var ck=tr.find(".tree-checkbox");
if(!ck.length){
return;
}
row.checkState=["unchecked","checked","indeterminate"][flag];
row.checked=(row.checkState=="checked");
ck.removeClass("tree-checkbox0 tree-checkbox1 tree-checkbox2");
ck.addClass("tree-checkbox"+flag);
if(flag==0){
$.easyui.removeArrayItem(_924,opts.idField,row[opts.idField]);
}else{
$.easyui.addArrayItem(_924,opts.idField,row);
}
};
function _91f(_925,row,_926){
var flag=_926?1:0;
_921(_925,row,flag);
$.easyui.forEach(row.children||[],true,function(r){
_921(_925,r,flag);
});
};
function _920(_927,row){
var opts=$.data(_927,"treegrid").options;
var prow=_928(_927,row[opts.idField]);
if(prow){
_921(_927,prow,_929(prow));
_920(_927,prow);
}
};
function _929(row){
var len=0;
var c0=0;
var c1=0;
$.easyui.forEach(row.children||[],false,function(r){
if(r.checkState){
len++;
if(r.checkState=="checked"){
c1++;
}else{
if(r.checkState=="unchecked"){
c0++;
}
}
}
});
if(len==0){
return undefined;
}
var flag=0;
if(c0==len){
flag=0;
}else{
if(c1==len){
flag=1;
}else{
flag=2;
}
}
return flag;
};
function _92a(_92b,_92c){
var opts=$.data(_92b,"treegrid").options;
if(!opts.checkbox){
return;
}
var row=find(_92b,_92c);
var tr=opts.finder.getTr(_92b,_92c);
var ck=tr.find(".tree-checkbox");
if(opts.view.hasCheckbox(_92b,row)){
if(!ck.length){
row.checkState=row.checkState||"unchecked";
$("<span class=\"tree-checkbox\"></span>").insertBefore(tr.find(".tree-title"));
}
if(row.checkState=="checked"){
_917(_92b,_92c,true,true);
}else{
if(row.checkState=="unchecked"){
_917(_92b,_92c,false,true);
}else{
var flag=_929(row);
if(flag===0){
_917(_92b,_92c,false,true);
}else{
if(flag===1){
_917(_92b,_92c,true,true);
}
}
}
}
}else{
ck.remove();
row.checkState=undefined;
row.checked=undefined;
_920(_92b,row);
}
};
function _92d(_92e,_92f){
var opts=$.data(_92e,"treegrid").options;
var tr1=opts.finder.getTr(_92e,_92f,"body",1);
var tr2=opts.finder.getTr(_92e,_92f,"body",2);
var _930=$(_92e).datagrid("getColumnFields",true).length+(opts.rownumbers?1:0);
var _931=$(_92e).datagrid("getColumnFields",false).length;
_932(tr1,_930);
_932(tr2,_931);
function _932(tr,_933){
$("<tr class=\"treegrid-tr-tree\">"+"<td style=\"border:0px\" colspan=\""+_933+"\">"+"<div></div>"+"</td>"+"</tr>").insertAfter(tr);
};
};
function _934(_935,_936,data,_937,_938){
var _939=$.data(_935,"treegrid");
var opts=_939.options;
var dc=_939.dc;
data=opts.loadFilter.call(_935,data,_936);
var node=find(_935,_936);
if(node){
var _93a=opts.finder.getTr(_935,_936,"body",1);
var _93b=opts.finder.getTr(_935,_936,"body",2);
var cc1=_93a.next("tr.treegrid-tr-tree").children("td").children("div");
var cc2=_93b.next("tr.treegrid-tr-tree").children("td").children("div");
if(!_937){
node.children=[];
}
}else{
var cc1=dc.body1;
var cc2=dc.body2;
if(!_937){
_939.data=[];
}
}
if(!_937){
cc1.empty();
cc2.empty();
}
if(opts.view.onBeforeRender){
opts.view.onBeforeRender.call(opts.view,_935,_936,data);
}
opts.view.render.call(opts.view,_935,cc1,true);
opts.view.render.call(opts.view,_935,cc2,false);
if(opts.showFooter){
opts.view.renderFooter.call(opts.view,_935,dc.footer1,true);
opts.view.renderFooter.call(opts.view,_935,dc.footer2,false);
}
if(opts.view.onAfterRender){
opts.view.onAfterRender.call(opts.view,_935);
}
if(!_936&&opts.pagination){
var _93c=$.data(_935,"treegrid").total;
var _93d=$(_935).datagrid("getPager");
if(_93d.pagination("options").total!=_93c){
_93d.pagination({total:_93c});
}
}
_906(_935);
_90e(_935);
$(_935).treegrid("showLines");
$(_935).treegrid("setSelectionState");
$(_935).treegrid("autoSizeColumn");
if(!_938){
opts.onLoadSuccess.call(_935,node,data);
}
};
function _905(_93e,_93f,_940,_941,_942){
var opts=$.data(_93e,"treegrid").options;
var body=$(_93e).datagrid("getPanel").find("div.datagrid-body");
if(_93f==undefined&&opts.queryParams){
opts.queryParams.id=undefined;
}
if(_940){
opts.queryParams=_940;
}
var _943=$.extend({},opts.queryParams);
if(opts.pagination){
$.extend(_943,{page:opts.pageNumber,rows:opts.pageSize});
}
if(opts.sortName){
$.extend(_943,{sort:opts.sortName,order:opts.sortOrder});
}
var row=find(_93e,_93f);
if(opts.onBeforeLoad.call(_93e,row,_943)==false){
return;
}
var _944=body.find("tr[node-id=\""+_93f+"\"] span.tree-folder");
_944.addClass("tree-loading");
$(_93e).treegrid("loading");
var _945=opts.loader.call(_93e,_943,function(data){
_944.removeClass("tree-loading");
$(_93e).treegrid("loaded");
_934(_93e,_93f,data,_941);
if(_942){
_942();
}
},function(){
_944.removeClass("tree-loading");
$(_93e).treegrid("loaded");
opts.onLoadError.apply(_93e,arguments);
if(_942){
_942();
}
});
if(_945==false){
_944.removeClass("tree-loading");
$(_93e).treegrid("loaded");
}
};
function _946(_947){
var _948=_949(_947);
return _948.length?_948[0]:null;
};
function _949(_94a){
return $.data(_94a,"treegrid").data;
};
function _928(_94b,_94c){
var row=find(_94b,_94c);
if(row._parentId){
return find(_94b,row._parentId);
}else{
return null;
}
};
function _90a(_94d,_94e){
var data=$.data(_94d,"treegrid").data;
if(_94e){
var _94f=find(_94d,_94e);
data=_94f?(_94f.children||[]):[];
}
var _950=[];
$.easyui.forEach(data,true,function(node){
_950.push(node);
});
return _950;
};
function _951(_952,_953){
var opts=$.data(_952,"treegrid").options;
var tr=opts.finder.getTr(_952,_953);
var node=tr.children("td[field=\""+opts.treeField+"\"]");
return node.find("span.tree-indent,span.tree-hit").length;
};
function find(_954,_955){
var _956=$.data(_954,"treegrid");
var opts=_956.options;
var _957=null;
$.easyui.forEach(_956.data,true,function(node){
if(node[opts.idField]==_955){
_957=node;
return false;
}
});
return _957;
};
function _958(_959,_95a){
var opts=$.data(_959,"treegrid").options;
var row=find(_959,_95a);
var tr=opts.finder.getTr(_959,_95a);
var hit=tr.find("span.tree-hit");
if(hit.length==0){
return;
}
if(hit.hasClass("tree-collapsed")){
return;
}
if(opts.onBeforeCollapse.call(_959,row)==false){
return;
}
hit.removeClass("tree-expanded tree-expanded-hover").addClass("tree-collapsed");
hit.next().removeClass("tree-folder-open");
row.state="closed";
tr=tr.next("tr.treegrid-tr-tree");
var cc=tr.children("td").children("div");
if(opts.animate){
cc.slideUp("normal",function(){
$(_959).treegrid("autoSizeColumn");
_906(_959,_95a);
opts.onCollapse.call(_959,row);
});
}else{
cc.hide();
$(_959).treegrid("autoSizeColumn");
_906(_959,_95a);
opts.onCollapse.call(_959,row);
}
};
function _95b(_95c,_95d){
var opts=$.data(_95c,"treegrid").options;
var tr=opts.finder.getTr(_95c,_95d);
var hit=tr.find("span.tree-hit");
var row=find(_95c,_95d);
if(hit.length==0){
return;
}
if(hit.hasClass("tree-expanded")){
return;
}
if(opts.onBeforeExpand.call(_95c,row)==false){
return;
}
hit.removeClass("tree-collapsed tree-collapsed-hover").addClass("tree-expanded");
hit.next().addClass("tree-folder-open");
var _95e=tr.next("tr.treegrid-tr-tree");
if(_95e.length){
var cc=_95e.children("td").children("div");
_95f(cc);
}else{
_92d(_95c,row[opts.idField]);
var _95e=tr.next("tr.treegrid-tr-tree");
var cc=_95e.children("td").children("div");
cc.hide();
var _960=$.extend({},opts.queryParams||{});
_960.id=row[opts.idField];
_905(_95c,row[opts.idField],_960,true,function(){
if(cc.is(":empty")){
_95e.remove();
}else{
_95f(cc);
}
});
}
function _95f(cc){
row.state="open";
if(opts.animate){
cc.slideDown("normal",function(){
$(_95c).treegrid("autoSizeColumn");
_906(_95c,_95d);
opts.onExpand.call(_95c,row);
});
}else{
cc.show();
$(_95c).treegrid("autoSizeColumn");
_906(_95c,_95d);
opts.onExpand.call(_95c,row);
}
};
};
function _916(_961,_962){
var opts=$.data(_961,"treegrid").options;
var tr=opts.finder.getTr(_961,_962);
var hit=tr.find("span.tree-hit");
if(hit.hasClass("tree-expanded")){
_958(_961,_962);
}else{
_95b(_961,_962);
}
};
function _963(_964,_965){
var opts=$.data(_964,"treegrid").options;
var _966=_90a(_964,_965);
if(_965){
_966.unshift(find(_964,_965));
}
for(var i=0;i<_966.length;i++){
_958(_964,_966[i][opts.idField]);
}
};
function _967(_968,_969){
var opts=$.data(_968,"treegrid").options;
var _96a=_90a(_968,_969);
if(_969){
_96a.unshift(find(_968,_969));
}
for(var i=0;i<_96a.length;i++){
_95b(_968,_96a[i][opts.idField]);
}
};
function _96b(_96c,_96d){
var opts=$.data(_96c,"treegrid").options;
var ids=[];
var p=_928(_96c,_96d);
while(p){
var id=p[opts.idField];
ids.unshift(id);
p=_928(_96c,id);
}
for(var i=0;i<ids.length;i++){
_95b(_96c,ids[i]);
}
};
function _96e(_96f,_970){
var _971=$.data(_96f,"treegrid");
var opts=_971.options;
if(_970.parent){
var tr=opts.finder.getTr(_96f,_970.parent);
if(tr.next("tr.treegrid-tr-tree").length==0){
_92d(_96f,_970.parent);
}
var cell=tr.children("td[field=\""+opts.treeField+"\"]").children("div.datagrid-cell");
var _972=cell.children("span.tree-icon");
if(_972.hasClass("tree-file")){
_972.removeClass("tree-file").addClass("tree-folder tree-folder-open");
var hit=$("<span class=\"tree-hit tree-expanded\"></span>").insertBefore(_972);
if(hit.prev().length){
hit.prev().remove();
}
}
}
_934(_96f,_970.parent,_970.data,_971.data.length>0,true);
};
function _973(_974,_975){
var ref=_975.before||_975.after;
var opts=$.data(_974,"treegrid").options;
var _976=_928(_974,ref);
_96e(_974,{parent:(_976?_976[opts.idField]:null),data:[_975.data]});
var _977=_976?_976.children:$(_974).treegrid("getRoots");
for(var i=0;i<_977.length;i++){
if(_977[i][opts.idField]==ref){
var _978=_977[_977.length-1];
_977.splice(_975.before?i:(i+1),0,_978);
_977.splice(_977.length-1,1);
break;
}
}
_979(true);
_979(false);
_90e(_974);
$(_974).treegrid("showLines");
function _979(_97a){
var _97b=_97a?1:2;
var tr=opts.finder.getTr(_974,_975.data[opts.idField],"body",_97b);
var _97c=tr.closest("table.datagrid-btable");
tr=tr.parent().children();
var dest=opts.finder.getTr(_974,ref,"body",_97b);
if(_975.before){
tr.insertBefore(dest);
}else{
var sub=dest.next("tr.treegrid-tr-tree");
tr.insertAfter(sub.length?sub:dest);
}
_97c.remove();
};
};
function _97d(_97e,_97f){
var _980=$.data(_97e,"treegrid");
var opts=_980.options;
var prow=_928(_97e,_97f);
$(_97e).datagrid("deleteRow",_97f);
$.easyui.removeArrayItem(_980.checkedRows,opts.idField,_97f);
_90e(_97e);
if(prow){
_92a(_97e,prow[opts.idField]);
}
_980.total-=1;
$(_97e).datagrid("getPager").pagination("refresh",{total:_980.total});
$(_97e).treegrid("showLines");
};
function _981(_982){
var t=$(_982);
var opts=t.treegrid("options");
if(opts.lines){
t.treegrid("getPanel").addClass("tree-lines");
}else{
t.treegrid("getPanel").removeClass("tree-lines");
return;
}
t.treegrid("getPanel").find("span.tree-indent").removeClass("tree-line tree-join tree-joinbottom");
t.treegrid("getPanel").find("div.datagrid-cell").removeClass("tree-node-last tree-root-first tree-root-one");
var _983=t.treegrid("getRoots");
if(_983.length>1){
_984(_983[0]).addClass("tree-root-first");
}else{
if(_983.length==1){
_984(_983[0]).addClass("tree-root-one");
}
}
_985(_983);
_986(_983);
function _985(_987){
$.map(_987,function(node){
if(node.children&&node.children.length){
_985(node.children);
}else{
var cell=_984(node);
cell.find(".tree-icon").prev().addClass("tree-join");
}
});
if(_987.length){
var cell=_984(_987[_987.length-1]);
cell.addClass("tree-node-last");
cell.find(".tree-join").removeClass("tree-join").addClass("tree-joinbottom");
}
};
function _986(_988){
$.map(_988,function(node){
if(node.children&&node.children.length){
_986(node.children);
}
});
for(var i=0;i<_988.length-1;i++){
var node=_988[i];
var _989=t.treegrid("getLevel",node[opts.idField]);
var tr=opts.finder.getTr(_982,node[opts.idField]);
var cc=tr.next().find("tr.datagrid-row td[field=\""+opts.treeField+"\"] div.datagrid-cell");
cc.find("span:eq("+(_989-1)+")").addClass("tree-line");
}
};
function _984(node){
var tr=opts.finder.getTr(_982,node[opts.idField]);
var cell=tr.find("td[field=\""+opts.treeField+"\"] div.datagrid-cell");
return cell;
};
};
$.fn.treegrid=function(_98a,_98b){
if(typeof _98a=="string"){
var _98c=$.fn.treegrid.methods[_98a];
if(_98c){
return _98c(this,_98b);
}else{
return this.datagrid(_98a,_98b);
}
}
_98a=_98a||{};
return this.each(function(){
var _98d=$.data(this,"treegrid");
if(_98d){
$.extend(_98d.options,_98a);
}else{
_98d=$.data(this,"treegrid",{options:$.extend({},$.fn.treegrid.defaults,$.fn.treegrid.parseOptions(this),_98a),data:[],checkedRows:[],tmpIds:[]});
}
_8f5(this);
if(_98d.options.data){
$(this).treegrid("loadData",_98d.options.data);
}
_905(this);
});
};
$.fn.treegrid.methods={options:function(jq){
return $.data(jq[0],"treegrid").options;
},resize:function(jq,_98e){
return jq.each(function(){
$(this).datagrid("resize",_98e);
});
},fixRowHeight:function(jq,_98f){
return jq.each(function(){
_906(this,_98f);
});
},loadData:function(jq,data){
return jq.each(function(){
_934(this,data.parent,data);
});
},load:function(jq,_990){
return jq.each(function(){
$(this).treegrid("options").pageNumber=1;
$(this).treegrid("getPager").pagination({pageNumber:1});
$(this).treegrid("reload",_990);
});
},reload:function(jq,id){
return jq.each(function(){
var opts=$(this).treegrid("options");
var _991={};
if(typeof id=="object"){
_991=id;
}else{
_991=$.extend({},opts.queryParams);
_991.id=id;
}
if(_991.id){
var node=$(this).treegrid("find",_991.id);
if(node.children){
node.children.splice(0,node.children.length);
}
opts.queryParams=_991;
var tr=opts.finder.getTr(this,_991.id);
tr.next("tr.treegrid-tr-tree").remove();
tr.find("span.tree-hit").removeClass("tree-expanded tree-expanded-hover").addClass("tree-collapsed");
_95b(this,_991.id);
}else{
_905(this,null,_991);
}
});
},reloadFooter:function(jq,_992){
return jq.each(function(){
var opts=$.data(this,"treegrid").options;
var dc=$.data(this,"datagrid").dc;
if(_992){
$.data(this,"treegrid").footer=_992;
}
if(opts.showFooter){
opts.view.renderFooter.call(opts.view,this,dc.footer1,true);
opts.view.renderFooter.call(opts.view,this,dc.footer2,false);
if(opts.view.onAfterRender){
opts.view.onAfterRender.call(opts.view,this);
}
$(this).treegrid("fixRowHeight");
}
});
},getData:function(jq){
return $.data(jq[0],"treegrid").data;
},getFooterRows:function(jq){
return $.data(jq[0],"treegrid").footer;
},getRoot:function(jq){
return _946(jq[0]);
},getRoots:function(jq){
return _949(jq[0]);
},getParent:function(jq,id){
return _928(jq[0],id);
},getChildren:function(jq,id){
return _90a(jq[0],id);
},getLevel:function(jq,id){
return _951(jq[0],id);
},find:function(jq,id){
return find(jq[0],id);
},isLeaf:function(jq,id){
var opts=$.data(jq[0],"treegrid").options;
var tr=opts.finder.getTr(jq[0],id);
var hit=tr.find("span.tree-hit");
return hit.length==0;
},select:function(jq,id){
return jq.each(function(){
$(this).datagrid("selectRow",id);
});
},unselect:function(jq,id){
return jq.each(function(){
$(this).datagrid("unselectRow",id);
});
},collapse:function(jq,id){
return jq.each(function(){
_958(this,id);
});
},expand:function(jq,id){
return jq.each(function(){
_95b(this,id);
});
},toggle:function(jq,id){
return jq.each(function(){
_916(this,id);
});
},collapseAll:function(jq,id){
return jq.each(function(){
_963(this,id);
});
},expandAll:function(jq,id){
return jq.each(function(){
_967(this,id);
});
},expandTo:function(jq,id){
return jq.each(function(){
_96b(this,id);
});
},append:function(jq,_993){
return jq.each(function(){
_96e(this,_993);
});
},insert:function(jq,_994){
return jq.each(function(){
_973(this,_994);
});
},remove:function(jq,id){
return jq.each(function(){
_97d(this,id);
});
},pop:function(jq,id){
var row=jq.treegrid("find",id);
jq.treegrid("remove",id);
return row;
},refresh:function(jq,id){
return jq.each(function(){
var opts=$.data(this,"treegrid").options;
opts.view.refreshRow.call(opts.view,this,id);
});
},update:function(jq,_995){
return jq.each(function(){
var opts=$.data(this,"treegrid").options;
var row=_995.row;
opts.view.updateRow.call(opts.view,this,_995.id,row);
if(row.checked!=undefined){
row=find(this,_995.id);
$.extend(row,{checkState:row.checked?"checked":(row.checked===false?"unchecked":undefined)});
_92a(this,_995.id);
}
});
},beginEdit:function(jq,id){
return jq.each(function(){
$(this).datagrid("beginEdit",id);
$(this).treegrid("fixRowHeight",id);
});
},endEdit:function(jq,id){
return jq.each(function(){
$(this).datagrid("endEdit",id);
});
},cancelEdit:function(jq,id){
return jq.each(function(){
$(this).datagrid("cancelEdit",id);
});
},showLines:function(jq){
return jq.each(function(){
_981(this);
});
},setSelectionState:function(jq){
return jq.each(function(){
$(this).datagrid("setSelectionState");
var _996=$(this).data("treegrid");
for(var i=0;i<_996.tmpIds.length;i++){
_917(this,_996.tmpIds[i],true,true);
}
_996.tmpIds=[];
});
},getCheckedNodes:function(jq,_997){
_997=_997||"checked";
var rows=[];
$.easyui.forEach(jq.data("treegrid").checkedRows,false,function(row){
if(row.checkState==_997){
rows.push(row);
}
});
return rows;
},checkNode:function(jq,id){
return jq.each(function(){
_917(this,id,true);
});
},uncheckNode:function(jq,id){
return jq.each(function(){
_917(this,id,false);
});
},clearChecked:function(jq){
return jq.each(function(){
var _998=this;
var opts=$(_998).treegrid("options");
$(_998).datagrid("clearChecked");
$.map($(_998).treegrid("getCheckedNodes"),function(row){
_917(_998,row[opts.idField],false,true);
});
});
}};
$.fn.treegrid.parseOptions=function(_999){
return $.extend({},$.fn.datagrid.parseOptions(_999),$.parser.parseOptions(_999,["treeField",{checkbox:"boolean",cascadeCheck:"boolean",onlyLeafCheck:"boolean"},{animate:"boolean"}]));
};
var _99a=$.extend({},$.fn.datagrid.defaults.view,{render:function(_99b,_99c,_99d){
var opts=$.data(_99b,"treegrid").options;
var _99e=$(_99b).datagrid("getColumnFields",_99d);
var _99f=$.data(_99b,"datagrid").rowIdPrefix;
if(_99d){
if(!(opts.rownumbers||(opts.frozenColumns&&opts.frozenColumns.length))){
return;
}
}
var view=this;
if(this.treeNodes&&this.treeNodes.length){
var _9a0=_9a1.call(this,_99d,this.treeLevel,this.treeNodes);
$(_99c).append(_9a0.join(""));
}
function _9a1(_9a2,_9a3,_9a4){
var _9a5=$(_99b).treegrid("getParent",_9a4[0][opts.idField]);
var _9a6=(_9a5?_9a5.children.length:$(_99b).treegrid("getRoots").length)-_9a4.length;
var _9a7=["<table class=\"datagrid-btable\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>"];
for(var i=0;i<_9a4.length;i++){
var row=_9a4[i];
if(row.state!="open"&&row.state!="closed"){
row.state="open";
}
var css=opts.rowStyler?opts.rowStyler.call(_99b,row):"";
var cs=this.getStyleValue(css);
var cls="class=\"datagrid-row "+(_9a6++%2&&opts.striped?"datagrid-row-alt ":" ")+cs.c+"\"";
var _9a8=cs.s?"style=\""+cs.s+"\"":"";
var _9a9=_99f+"-"+(_9a2?1:2)+"-"+row[opts.idField];
_9a7.push("<tr id=\""+_9a9+"\" node-id=\""+row[opts.idField]+"\" "+cls+" "+_9a8+">");
_9a7=_9a7.concat(view.renderRow.call(view,_99b,_99e,_9a2,_9a3,row));
_9a7.push("</tr>");
if(row.children&&row.children.length){
var tt=_9a1.call(this,_9a2,_9a3+1,row.children);
var v=row.state=="closed"?"none":"block";
_9a7.push("<tr class=\"treegrid-tr-tree\"><td style=\"border:0px\" colspan="+(_99e.length+(opts.rownumbers?1:0))+"><div style=\"display:"+v+"\">");
_9a7=_9a7.concat(tt);
_9a7.push("</div></td></tr>");
}
}
_9a7.push("</tbody></table>");
return _9a7;
};
},renderFooter:function(_9aa,_9ab,_9ac){
var opts=$.data(_9aa,"treegrid").options;
var rows=$.data(_9aa,"treegrid").footer||[];
var _9ad=$(_9aa).datagrid("getColumnFields",_9ac);
var _9ae=["<table class=\"datagrid-ftable\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>"];
for(var i=0;i<rows.length;i++){
var row=rows[i];
row[opts.idField]=row[opts.idField]||("foot-row-id"+i);
_9ae.push("<tr class=\"datagrid-row\" node-id=\""+row[opts.idField]+"\">");
_9ae.push(this.renderRow.call(this,_9aa,_9ad,_9ac,0,row));
_9ae.push("</tr>");
}
_9ae.push("</tbody></table>");
$(_9ab).html(_9ae.join(""));
},renderRow:function(_9af,_9b0,_9b1,_9b2,row){
var _9b3=$.data(_9af,"treegrid");
var opts=_9b3.options;
var cc=[];
if(_9b1&&opts.rownumbers){
cc.push("<td class=\"datagrid-td-rownumber\"><div class=\"datagrid-cell-rownumber\">0</div></td>");
}
for(var i=0;i<_9b0.length;i++){
var _9b4=_9b0[i];
var col=$(_9af).datagrid("getColumnOption",_9b4);
if(col){
var css=col.styler?(col.styler(row[_9b4],row)||""):"";
var cs=this.getStyleValue(css);
var cls=cs.c?"class=\""+cs.c+"\"":"";
var _9b5=col.hidden?"style=\"display:none;"+cs.s+"\"":(cs.s?"style=\""+cs.s+"\"":"");
cc.push("<td field=\""+_9b4+"\" "+cls+" "+_9b5+">");
var _9b5="";
if(!col.checkbox){
if(col.align){
_9b5+="text-align:"+col.align+";";
}
if(!opts.nowrap){
_9b5+="white-space:normal;height:auto;";
}else{
if(opts.autoRowHeight){
_9b5+="height:auto;";
}
}
}
cc.push("<div style=\""+_9b5+"\" ");
if(col.checkbox){
cc.push("class=\"datagrid-cell-check ");
}else{
cc.push("class=\"datagrid-cell "+col.cellClass);
}
cc.push("\">");
if(col.checkbox){
if(row.checked){
cc.push("<input type=\"checkbox\" checked=\"checked\"");
}else{
cc.push("<input type=\"checkbox\"");
}
cc.push(" name=\""+_9b4+"\" value=\""+(row[_9b4]!=undefined?row[_9b4]:"")+"\">");
}else{
var val=null;
if(col.formatter){
val=col.formatter(row[_9b4],row);
}else{
val=row[_9b4];
}
if(_9b4==opts.treeField){
for(var j=0;j<_9b2;j++){
cc.push("<span class=\"tree-indent\"></span>");
}
if(row.state=="closed"){
cc.push("<span class=\"tree-hit tree-collapsed\"></span>");
cc.push("<span class=\"tree-icon tree-folder "+(row.iconCls?row.iconCls:"")+"\"></span>");
}else{
if(row.children&&row.children.length){
cc.push("<span class=\"tree-hit tree-expanded\"></span>");
cc.push("<span class=\"tree-icon tree-folder tree-folder-open "+(row.iconCls?row.iconCls:"")+"\"></span>");
}else{
cc.push("<span class=\"tree-indent\"></span>");
cc.push("<span class=\"tree-icon tree-file "+(row.iconCls?row.iconCls:"")+"\"></span>");
}
}
if(this.hasCheckbox(_9af,row)){
var flag=0;
var crow=$.easyui.getArrayItem(_9b3.checkedRows,opts.idField,row[opts.idField]);
if(crow){
flag=crow.checkState=="checked"?1:2;
row.checkState=crow.checkState;
row.checked=crow.checked;
$.easyui.addArrayItem(_9b3.checkedRows,opts.idField,row);
}else{
var prow=$.easyui.getArrayItem(_9b3.checkedRows,opts.idField,row._parentId);
if(prow&&prow.checkState=="checked"&&opts.cascadeCheck){
flag=1;
row.checked=true;
$.easyui.addArrayItem(_9b3.checkedRows,opts.idField,row);
}else{
if(row.checked){
$.easyui.addArrayItem(_9b3.tmpIds,row[opts.idField]);
}
}
row.checkState=flag?"checked":"unchecked";
}
cc.push("<span class=\"tree-checkbox tree-checkbox"+flag+"\"></span>");
}else{
row.checkState=undefined;
row.checked=undefined;
}
cc.push("<span class=\"tree-title\">"+val+"</span>");
}else{
cc.push(val);
}
}
cc.push("</div>");
cc.push("</td>");
}
}
return cc.join("");
},hasCheckbox:function(_9b6,row){
var opts=$.data(_9b6,"treegrid").options;
if(opts.checkbox){
if($.isFunction(opts.checkbox)){
if(opts.checkbox.call(_9b6,row)){
return true;
}else{
return false;
}
}else{
if(opts.onlyLeafCheck){
if(row.state=="open"&&!(row.children&&row.children.length)){
return true;
}
}else{
return true;
}
}
}
return false;
},refreshRow:function(_9b7,id){
this.updateRow.call(this,_9b7,id,{});
},updateRow:function(_9b8,id,row){
var opts=$.data(_9b8,"treegrid").options;
var _9b9=$(_9b8).treegrid("find",id);
$.extend(_9b9,row);
var _9ba=$(_9b8).treegrid("getLevel",id)-1;
var _9bb=opts.rowStyler?opts.rowStyler.call(_9b8,_9b9):"";
var _9bc=$.data(_9b8,"datagrid").rowIdPrefix;
var _9bd=_9b9[opts.idField];
function _9be(_9bf){
var _9c0=$(_9b8).treegrid("getColumnFields",_9bf);
var tr=opts.finder.getTr(_9b8,id,"body",(_9bf?1:2));
var _9c1=tr.find("div.datagrid-cell-rownumber").html();
var _9c2=tr.find("div.datagrid-cell-check input[type=checkbox]").is(":checked");
tr.html(this.renderRow(_9b8,_9c0,_9bf,_9ba,_9b9));
tr.attr("style",_9bb||"");
tr.find("div.datagrid-cell-rownumber").html(_9c1);
if(_9c2){
tr.find("div.datagrid-cell-check input[type=checkbox]")._propAttr("checked",true);
}
if(_9bd!=id){
tr.attr("id",_9bc+"-"+(_9bf?1:2)+"-"+_9bd);
tr.attr("node-id",_9bd);
}
};
_9be.call(this,true);
_9be.call(this,false);
$(_9b8).treegrid("fixRowHeight",id);
},deleteRow:function(_9c3,id){
var opts=$.data(_9c3,"treegrid").options;
var tr=opts.finder.getTr(_9c3,id);
tr.next("tr.treegrid-tr-tree").remove();
tr.remove();
var _9c4=del(id);
if(_9c4){
if(_9c4.children.length==0){
tr=opts.finder.getTr(_9c3,_9c4[opts.idField]);
tr.next("tr.treegrid-tr-tree").remove();
var cell=tr.children("td[field=\""+opts.treeField+"\"]").children("div.datagrid-cell");
cell.find(".tree-icon").removeClass("tree-folder").addClass("tree-file");
cell.find(".tree-hit").remove();
$("<span class=\"tree-indent\"></span>").prependTo(cell);
}
}
this.setEmptyMsg(_9c3);
function del(id){
var cc;
var _9c5=$(_9c3).treegrid("getParent",id);
if(_9c5){
cc=_9c5.children;
}else{
cc=$(_9c3).treegrid("getData");
}
for(var i=0;i<cc.length;i++){
if(cc[i][opts.idField]==id){
cc.splice(i,1);
break;
}
}
return _9c5;
};
},onBeforeRender:function(_9c6,_9c7,data){
if($.isArray(_9c7)){
data={total:_9c7.length,rows:_9c7};
_9c7=null;
}
if(!data){
return false;
}
var _9c8=$.data(_9c6,"treegrid");
var opts=_9c8.options;
if(data.length==undefined){
if(data.footer){
_9c8.footer=data.footer;
}
if(data.total){
_9c8.total=data.total;
}
data=this.transfer(_9c6,_9c7,data.rows);
}else{
function _9c9(_9ca,_9cb){
for(var i=0;i<_9ca.length;i++){
var row=_9ca[i];
row._parentId=_9cb;
if(row.children&&row.children.length){
_9c9(row.children,row[opts.idField]);
}
}
};
_9c9(data,_9c7);
}
this.sort(_9c6,data);
this.treeNodes=data;
this.treeLevel=$(_9c6).treegrid("getLevel",_9c7);
var node=find(_9c6,_9c7);
if(node){
if(node.children){
node.children=node.children.concat(data);
}else{
node.children=data;
}
}else{
_9c8.data=_9c8.data.concat(data);
}
},sort:function(_9cc,data){
var opts=$.data(_9cc,"treegrid").options;
if(!opts.remoteSort&&opts.sortName){
var _9cd=opts.sortName.split(",");
var _9ce=opts.sortOrder.split(",");
_9cf(data);
}
function _9cf(rows){
rows.sort(function(r1,r2){
var r=0;
for(var i=0;i<_9cd.length;i++){
var sn=_9cd[i];
var so=_9ce[i];
var col=$(_9cc).treegrid("getColumnOption",sn);
var _9d0=col.sorter||function(a,b){
return a==b?0:(a>b?1:-1);
};
r=_9d0(r1[sn],r2[sn])*(so=="asc"?1:-1);
if(r!=0){
return r;
}
}
return r;
});
for(var i=0;i<rows.length;i++){
var _9d1=rows[i].children;
if(_9d1&&_9d1.length){
_9cf(_9d1);
}
}
};
},transfer:function(_9d2,_9d3,data){
var opts=$.data(_9d2,"treegrid").options;
var rows=$.extend([],data);
var _9d4=_9d5(_9d3,rows);
var toDo=$.extend([],_9d4);
while(toDo.length){
var node=toDo.shift();
var _9d6=_9d5(node[opts.idField],rows);
if(_9d6.length){
if(node.children){
node.children=node.children.concat(_9d6);
}else{
node.children=_9d6;
}
toDo=toDo.concat(_9d6);
}
}
return _9d4;
function _9d5(_9d7,rows){
var rr=[];
for(var i=0;i<rows.length;i++){
var row=rows[i];
if(row._parentId==_9d7){
rr.push(row);
rows.splice(i,1);
i--;
}
}
return rr;
};
}});
$.fn.treegrid.defaults=$.extend({},$.fn.datagrid.defaults,{treeField:null,checkbox:false,cascadeCheck:true,onlyLeafCheck:false,lines:false,animate:false,singleSelect:true,view:_99a,rowEvents:$.extend({},$.fn.datagrid.defaults.rowEvents,{mouseover:_910(true),mouseout:_910(false),click:_912}),loader:function(_9d8,_9d9,_9da){
var opts=$(this).treegrid("options");
if(!opts.url){
return false;
}
$.ajax({type:opts.method,url:opts.url,data:_9d8,dataType:"json",success:function(data){
_9d9(data);
},error:function(){
_9da.apply(this,arguments);
}});
},loadFilter:function(data,_9db){
return data;
},finder:{getTr:function(_9dc,id,type,_9dd){
type=type||"body";
_9dd=_9dd||0;
var dc=$.data(_9dc,"datagrid").dc;
if(_9dd==0){
var opts=$.data(_9dc,"treegrid").options;
var tr1=opts.finder.getTr(_9dc,id,type,1);
var tr2=opts.finder.getTr(_9dc,id,type,2);
return tr1.add(tr2);
}else{
if(type=="body"){
var tr=$("#"+$.data(_9dc,"datagrid").rowIdPrefix+"-"+_9dd+"-"+id);
if(!tr.length){
tr=(_9dd==1?dc.body1:dc.body2).find("tr[node-id=\""+id+"\"]");
}
return tr;
}else{
if(type=="footer"){
return (_9dd==1?dc.footer1:dc.footer2).find("tr[node-id=\""+id+"\"]");
}else{
if(type=="selected"){
return (_9dd==1?dc.body1:dc.body2).find("tr.datagrid-row-selected");
}else{
if(type=="highlight"){
return (_9dd==1?dc.body1:dc.body2).find("tr.datagrid-row-over");
}else{
if(type=="checked"){
return (_9dd==1?dc.body1:dc.body2).find("tr.datagrid-row-checked");
}else{
if(type=="last"){
return (_9dd==1?dc.body1:dc.body2).find("tr:last[node-id]");
}else{
if(type=="allbody"){
return (_9dd==1?dc.body1:dc.body2).find("tr[node-id]");
}else{
if(type=="allfooter"){
return (_9dd==1?dc.footer1:dc.footer2).find("tr[node-id]");
}
}
}
}
}
}
}
}
}
},getRow:function(_9de,p){
var id=(typeof p=="object")?p.attr("node-id"):p;
return $(_9de).treegrid("find",id);
},getRows:function(_9df){
return $(_9df).treegrid("getChildren");
}},onBeforeLoad:function(row,_9e0){
},onLoadSuccess:function(row,data){
},onLoadError:function(){
},onBeforeCollapse:function(row){
},onCollapse:function(row){
},onBeforeExpand:function(row){
},onExpand:function(row){
},onClickRow:function(row){
},onDblClickRow:function(row){
},onClickCell:function(_9e1,row){
},onDblClickCell:function(_9e2,row){
},onContextMenu:function(e,row){
},onBeforeEdit:function(row){
},onAfterEdit:function(row,_9e3){
},onCancelEdit:function(row){
},onBeforeCheckNode:function(row,_9e4){
},onCheckNode:function(row,_9e5){
}});
})(jQuery);
(function($){
function _9e6(_9e7){
var opts=$.data(_9e7,"datalist").options;
$(_9e7).datagrid($.extend({},opts,{cls:"datalist"+(opts.lines?" datalist-lines":""),frozenColumns:(opts.frozenColumns&&opts.frozenColumns.length)?opts.frozenColumns:(opts.checkbox?[[{field:"_ck",checkbox:true}]]:undefined),columns:(opts.columns&&opts.columns.length)?opts.columns:[[{field:opts.textField,width:"100%",formatter:function(_9e8,row,_9e9){
return opts.textFormatter?opts.textFormatter(_9e8,row,_9e9):_9e8;
}}]]}));
};
var _9ea=$.extend({},$.fn.datagrid.defaults.view,{render:function(_9eb,_9ec,_9ed){
var _9ee=$.data(_9eb,"datagrid");
var opts=_9ee.options;
if(opts.groupField){
var g=this.groupRows(_9eb,_9ee.data.rows);
this.groups=g.groups;
_9ee.data.rows=g.rows;
var _9ef=[];
for(var i=0;i<g.groups.length;i++){
_9ef.push(this.renderGroup.call(this,_9eb,i,g.groups[i],_9ed));
}
$(_9ec).html(_9ef.join(""));
}else{
$(_9ec).html(this.renderTable(_9eb,0,_9ee.data.rows,_9ed));
}
},renderGroup:function(_9f0,_9f1,_9f2,_9f3){
var _9f4=$.data(_9f0,"datagrid");
var opts=_9f4.options;
var _9f5=$(_9f0).datagrid("getColumnFields",_9f3);
var _9f6=[];
_9f6.push("<div class=\"datagrid-group\" group-index="+_9f1+">");
if(!_9f3){
_9f6.push("<span class=\"datagrid-group-title\">");
_9f6.push(opts.groupFormatter.call(_9f0,_9f2.value,_9f2.rows));
_9f6.push("</span>");
}
_9f6.push("</div>");
_9f6.push(this.renderTable(_9f0,_9f2.startIndex,_9f2.rows,_9f3));
return _9f6.join("");
},groupRows:function(_9f7,rows){
var _9f8=$.data(_9f7,"datagrid");
var opts=_9f8.options;
var _9f9=[];
for(var i=0;i<rows.length;i++){
var row=rows[i];
var _9fa=_9fb(row[opts.groupField]);
if(!_9fa){
_9fa={value:row[opts.groupField],rows:[row]};
_9f9.push(_9fa);
}else{
_9fa.rows.push(row);
}
}
var _9fc=0;
var rows=[];
for(var i=0;i<_9f9.length;i++){
var _9fa=_9f9[i];
_9fa.startIndex=_9fc;
_9fc+=_9fa.rows.length;
rows=rows.concat(_9fa.rows);
}
return {groups:_9f9,rows:rows};
function _9fb(_9fd){
for(var i=0;i<_9f9.length;i++){
var _9fe=_9f9[i];
if(_9fe.value==_9fd){
return _9fe;
}
}
return null;
};
}});
$.fn.datalist=function(_9ff,_a00){
if(typeof _9ff=="string"){
var _a01=$.fn.datalist.methods[_9ff];
if(_a01){
return _a01(this,_a00);
}else{
return this.datagrid(_9ff,_a00);
}
}
_9ff=_9ff||{};
return this.each(function(){
var _a02=$.data(this,"datalist");
if(_a02){
$.extend(_a02.options,_9ff);
}else{
var opts=$.extend({},$.fn.datalist.defaults,$.fn.datalist.parseOptions(this),_9ff);
opts.columns=$.extend(true,[],opts.columns);
_a02=$.data(this,"datalist",{options:opts});
}
_9e6(this);
if(!_a02.options.data){
var data=$.fn.datalist.parseData(this);
if(data.total){
$(this).datalist("loadData",data);
}
}
});
};
$.fn.datalist.methods={options:function(jq){
return $.data(jq[0],"datalist").options;
}};
$.fn.datalist.parseOptions=function(_a03){
return $.extend({},$.fn.datagrid.parseOptions(_a03),$.parser.parseOptions(_a03,["valueField","textField","groupField",{checkbox:"boolean",lines:"boolean"}]));
};
$.fn.datalist.parseData=function(_a04){
var opts=$.data(_a04,"datalist").options;
var data={total:0,rows:[]};
$(_a04).children().each(function(){
var _a05=$.parser.parseOptions(this,["value","group"]);
var row={};
var html=$(this).html();
row[opts.valueField]=_a05.value!=undefined?_a05.value:html;
row[opts.textField]=html;
if(opts.groupField){
row[opts.groupField]=_a05.group;
}
data.total++;
data.rows.push(row);
});
return data;
};
$.fn.datalist.defaults=$.extend({},$.fn.datagrid.defaults,{fitColumns:true,singleSelect:true,showHeader:false,checkbox:false,lines:false,valueField:"value",textField:"text",groupField:"",view:_9ea,textFormatter:function(_a06,row){
return _a06;
},groupFormatter:function(_a07,rows){
return _a07;
}});
})(jQuery);
(function($){
$(function(){
$(document).unbind(".combo").bind("mousedown.combo mousewheel.combo",function(e){
var p=$(e.target).closest("span.combo,div.combo-p,div.menu");
if(p.length){
_a08(p);
return;
}
$("body>div.combo-p>div.combo-panel:visible").panel("close");
});
});
function _a09(_a0a){
var _a0b=$.data(_a0a,"combo");
var opts=_a0b.options;
if(!_a0b.panel){
_a0b.panel=$("<div class=\"combo-panel\"></div>").appendTo("body");
_a0b.panel.panel({minWidth:opts.panelMinWidth,maxWidth:opts.panelMaxWidth,minHeight:opts.panelMinHeight,maxHeight:opts.panelMaxHeight,doSize:false,closed:true,cls:"combo-p",style:{position:"absolute",zIndex:10},onOpen:function(){
var _a0c=$(this).panel("options").comboTarget;
var _a0d=$.data(_a0c,"combo");
if(_a0d){
_a0d.options.onShowPanel.call(_a0c);
}
},onBeforeClose:function(){
_a08($(this).parent());
},onClose:function(){
var _a0e=$(this).panel("options").comboTarget;
var _a0f=$(_a0e).data("combo");
if(_a0f){
_a0f.options.onHidePanel.call(_a0e);
}
}});
}
var _a10=$.extend(true,[],opts.icons);
if(opts.hasDownArrow){
_a10.push({iconCls:"combo-arrow",handler:function(e){
_a14(e.data.target);
}});
}
$(_a0a).addClass("combo-f").textbox($.extend({},opts,{icons:_a10,onChange:function(){
}}));
$(_a0a).attr("comboName",$(_a0a).attr("textboxName"));
_a0b.combo=$(_a0a).next();
_a0b.combo.addClass("combo");
};
function _a11(_a12){
var _a13=$.data(_a12,"combo");
var opts=_a13.options;
var p=_a13.panel;
if(p.is(":visible")){
p.panel("close");
}
if(!opts.cloned){
p.panel("destroy");
}
$(_a12).textbox("destroy");
};
function _a14(_a15){
var _a16=$.data(_a15,"combo").panel;
if(_a16.is(":visible")){
var _a17=_a16.combo("combo");
_a18(_a17);
if(_a17!=_a15){
$(_a15).combo("showPanel");
}
}else{
var p=$(_a15).closest("div.combo-p").children(".combo-panel");
$("div.combo-panel:visible").not(_a16).not(p).panel("close");
$(_a15).combo("showPanel");
}
$(_a15).combo("textbox").focus();
};
function _a08(_a19){
$(_a19).find(".combo-f").each(function(){
var p=$(this).combo("panel");
if(p.is(":visible")){
p.panel("close");
}
});
};
function _a1a(e){
var _a1b=e.data.target;
var _a1c=$.data(_a1b,"combo");
var opts=_a1c.options;
if(!opts.editable){
_a14(_a1b);
}else{
var p=$(_a1b).closest("div.combo-p").children(".combo-panel");
$("div.combo-panel:visible").not(p).each(function(){
var _a1d=$(this).combo("combo");
if(_a1d!=_a1b){
_a18(_a1d);
}
});
}
};
function _a1e(e){
var _a1f=e.data.target;
var t=$(_a1f);
var _a20=t.data("combo");
var opts=t.combo("options");
_a20.panel.panel("options").comboTarget=_a1f;
switch(e.keyCode){
case 38:
opts.keyHandler.up.call(_a1f,e);
break;
case 40:
opts.keyHandler.down.call(_a1f,e);
break;
case 37:
opts.keyHandler.left.call(_a1f,e);
break;
case 39:
opts.keyHandler.right.call(_a1f,e);
break;
case 13:
e.preventDefault();
opts.keyHandler.enter.call(_a1f,e);
return false;
case 9:
case 27:
_a18(_a1f);
break;
default:
if(opts.editable){
if(_a20.timer){
clearTimeout(_a20.timer);
}
_a20.timer=setTimeout(function(){
var q=t.combo("getText");
if(_a20.previousText!=q){
_a20.previousText=q;
t.combo("showPanel");
opts.keyHandler.query.call(_a1f,q,e);
t.combo("validate");
}
},opts.delay);
}
}
};
function _a21(_a22){
var _a23=$.data(_a22,"combo");
var _a24=_a23.combo;
var _a25=_a23.panel;
var opts=$(_a22).combo("options");
var _a26=_a25.panel("options");
_a26.comboTarget=_a22;
if(_a26.closed){
_a25.panel("panel").show().css({zIndex:($.fn.menu?$.fn.menu.defaults.zIndex++:($.fn.window?$.fn.window.defaults.zIndex++:99)),left:-999999});
_a25.panel("resize",{width:(opts.panelWidth?opts.panelWidth:_a24._outerWidth()),height:opts.panelHeight});
_a25.panel("panel").hide();
_a25.panel("open");
}
(function(){
if(_a26.comboTarget==_a22&&_a25.is(":visible")){
_a25.panel("move",{left:_a27(),top:_a28()});
setTimeout(arguments.callee,200);
}
})();
function _a27(){
var left=_a24.offset().left;
if(opts.panelAlign=="right"){
left+=_a24._outerWidth()-_a25._outerWidth();
}
if(left+_a25._outerWidth()>$(window)._outerWidth()+$(document).scrollLeft()){
left=$(window)._outerWidth()+$(document).scrollLeft()-_a25._outerWidth();
}
if(left<0){
left=0;
}
return left;
};
function _a28(){
var top=_a24.offset().top+_a24._outerHeight();
if(top+_a25._outerHeight()>$(window)._outerHeight()+$(document).scrollTop()){
top=_a24.offset().top-_a25._outerHeight();
}
if(top<$(document).scrollTop()){
top=_a24.offset().top+_a24._outerHeight();
}
return top;
};
};
function _a18(_a29){
var _a2a=$.data(_a29,"combo").panel;
_a2a.panel("close");
};
function _a2b(_a2c,text){
var _a2d=$.data(_a2c,"combo");
var _a2e=$(_a2c).textbox("getText");
if(_a2e!=text){
$(_a2c).textbox("setText",text);
}
_a2d.previousText=text;
};
function _a2f(_a30){
var _a31=$.data(_a30,"combo");
var opts=_a31.options;
var _a32=$(_a30).next();
var _a33=[];
_a32.find(".textbox-value").each(function(){
_a33.push($(this).val());
});
if(opts.multivalue){
return _a33;
}else{
return _a33.length?_a33[0].split(opts.separator):_a33;
}
};
function _a34(_a35,_a36){
var _a37=$.data(_a35,"combo");
var _a38=_a37.combo;
var opts=$(_a35).combo("options");
if(!$.isArray(_a36)){
_a36=_a36.split(opts.separator);
}
var _a39=_a2f(_a35);
_a38.find(".textbox-value").remove();
if(_a36.length){
if(opts.multivalue){
for(var i=0;i<_a36.length;i++){
_a3a(_a36[i]);
}
}else{
_a3a(_a36.join(opts.separator));
}
}
function _a3a(_a3b){
var name=$(_a35).attr("textboxName")||"";
var _a3c=$("<input type=\"hidden\" class=\"textbox-value\">").appendTo(_a38);
_a3c.attr("name",name);
if(opts.disabled){
_a3c.attr("disabled","disabled");
}
_a3c.val(_a3b);
};
var _a3d=(function(){
if(_a39.length!=_a36.length){
return true;
}
for(var i=0;i<_a36.length;i++){
if(_a36[i]!=_a39[i]){
return true;
}
}
return false;
})();
if(_a3d){
$(_a35).val(_a36.join(opts.separator));
if(opts.multiple){
opts.onChange.call(_a35,_a36,_a39);
}else{
opts.onChange.call(_a35,_a36[0],_a39[0]);
}
$(_a35).closest("form").trigger("_change",[_a35]);
}
};
function _a3e(_a3f){
var _a40=_a2f(_a3f);
return _a40[0];
};
function _a41(_a42,_a43){
_a34(_a42,[_a43]);
};
function _a44(_a45){
var opts=$.data(_a45,"combo").options;
var _a46=opts.onChange;
opts.onChange=function(){
};
if(opts.multiple){
_a34(_a45,opts.value?opts.value:[]);
}else{
_a41(_a45,opts.value);
}
opts.onChange=_a46;
};
$.fn.combo=function(_a47,_a48){
if(typeof _a47=="string"){
var _a49=$.fn.combo.methods[_a47];
if(_a49){
return _a49(this,_a48);
}else{
return this.textbox(_a47,_a48);
}
}
_a47=_a47||{};
return this.each(function(){
var _a4a=$.data(this,"combo");
if(_a4a){
$.extend(_a4a.options,_a47);
if(_a47.value!=undefined){
_a4a.options.originalValue=_a47.value;
}
}else{
_a4a=$.data(this,"combo",{options:$.extend({},$.fn.combo.defaults,$.fn.combo.parseOptions(this),_a47),previousText:""});
_a4a.options.originalValue=_a4a.options.value;
}
_a09(this);
_a44(this);
});
};
$.fn.combo.methods={options:function(jq){
var opts=jq.textbox("options");
return $.extend($.data(jq[0],"combo").options,{width:opts.width,height:opts.height,disabled:opts.disabled,readonly:opts.readonly});
},cloneFrom:function(jq,from){
return jq.each(function(){
$(this).textbox("cloneFrom",from);
$.data(this,"combo",{options:$.extend(true,{cloned:true},$(from).combo("options")),combo:$(this).next(),panel:$(from).combo("panel")});
$(this).addClass("combo-f").attr("comboName",$(this).attr("textboxName"));
});
},combo:function(jq){
return jq.closest(".combo-panel").panel("options").comboTarget;
},panel:function(jq){
return $.data(jq[0],"combo").panel;
},destroy:function(jq){
return jq.each(function(){
_a11(this);
});
},showPanel:function(jq){
return jq.each(function(){
_a21(this);
});
},hidePanel:function(jq){
return jq.each(function(){
_a18(this);
});
},clear:function(jq){
return jq.each(function(){
$(this).textbox("setText","");
var opts=$.data(this,"combo").options;
if(opts.multiple){
$(this).combo("setValues",[]);
}else{
$(this).combo("setValue","");
}
});
},reset:function(jq){
return jq.each(function(){
var opts=$.data(this,"combo").options;
if(opts.multiple){
$(this).combo("setValues",opts.originalValue);
}else{
$(this).combo("setValue",opts.originalValue);
}
});
},setText:function(jq,text){
return jq.each(function(){
_a2b(this,text);
});
},getValues:function(jq){
return _a2f(jq[0]);
},setValues:function(jq,_a4b){
return jq.each(function(){
_a34(this,_a4b);
});
},getValue:function(jq){
return _a3e(jq[0]);
},setValue:function(jq,_a4c){
return jq.each(function(){
_a41(this,_a4c);
});
}};
$.fn.combo.parseOptions=function(_a4d){
var t=$(_a4d);
return $.extend({},$.fn.textbox.parseOptions(_a4d),$.parser.parseOptions(_a4d,["separator","panelAlign",{panelWidth:"number",hasDownArrow:"boolean",delay:"number",reversed:"boolean",multivalue:"boolean",selectOnNavigation:"boolean"},{panelMinWidth:"number",panelMaxWidth:"number",panelMinHeight:"number",panelMaxHeight:"number"}]),{panelHeight:(t.attr("panelHeight")=="auto"?"auto":parseInt(t.attr("panelHeight"))||undefined),multiple:(t.attr("multiple")?true:undefined)});
};
$.fn.combo.defaults=$.extend({},$.fn.textbox.defaults,{inputEvents:{click:_a1a,keydown:_a1e,paste:_a1e,drop:_a1e},panelWidth:null,panelHeight:200,panelMinWidth:null,panelMaxWidth:null,panelMinHeight:null,panelMaxHeight:null,panelAlign:"left",reversed:false,multiple:false,multivalue:true,selectOnNavigation:true,separator:",",hasDownArrow:true,delay:200,keyHandler:{up:function(e){
},down:function(e){
},left:function(e){
},right:function(e){
},enter:function(e){
},query:function(q,e){
}},onShowPanel:function(){
},onHidePanel:function(){
},onChange:function(_a4e,_a4f){
}});
})(jQuery);
(function($){
function _a50(_a51,_a52){
var _a53=$.data(_a51,"combobox");
return $.easyui.indexOfArray(_a53.data,_a53.options.valueField,_a52);
};
function _a54(_a55,_a56){
var opts=$.data(_a55,"combobox").options;
var _a57=$(_a55).combo("panel");
var item=opts.finder.getEl(_a55,_a56);
if(item.length){
if(item.position().top<=0){
var h=_a57.scrollTop()+item.position().top;
_a57.scrollTop(h);
}else{
if(item.position().top+item.outerHeight()>_a57.height()){
var h=_a57.scrollTop()+item.position().top+item.outerHeight()-_a57.height();
_a57.scrollTop(h);
}
}
}
_a57.triggerHandler("scroll");
};
function nav(_a58,dir){
var opts=$.data(_a58,"combobox").options;
var _a59=$(_a58).combobox("panel");
var item=_a59.children("div.combobox-item-hover");
if(!item.length){
item=_a59.children("div.combobox-item-selected");
}
item.removeClass("combobox-item-hover");
var _a5a="div.combobox-item:visible:not(.combobox-item-disabled):first";
var _a5b="div.combobox-item:visible:not(.combobox-item-disabled):last";
if(!item.length){
item=_a59.children(dir=="next"?_a5a:_a5b);
}else{
if(dir=="next"){
item=item.nextAll(_a5a);
if(!item.length){
item=_a59.children(_a5a);
}
}else{
item=item.prevAll(_a5a);
if(!item.length){
item=_a59.children(_a5b);
}
}
}
if(item.length){
item.addClass("combobox-item-hover");
var row=opts.finder.getRow(_a58,item);
if(row){
$(_a58).combobox("scrollTo",row[opts.valueField]);
if(opts.selectOnNavigation){
_a5c(_a58,row[opts.valueField]);
}
}
}
};
function _a5c(_a5d,_a5e,_a5f){
var opts=$.data(_a5d,"combobox").options;
var _a60=$(_a5d).combo("getValues");
if($.inArray(_a5e+"",_a60)==-1){
if(opts.multiple){
_a60.push(_a5e);
}else{
_a60=[_a5e];
}
_a61(_a5d,_a60,_a5f);
}
};
function _a62(_a63,_a64){
var opts=$.data(_a63,"combobox").options;
var _a65=$(_a63).combo("getValues");
var _a66=$.inArray(_a64+"",_a65);
if(_a66>=0){
_a65.splice(_a66,1);
_a61(_a63,_a65);
}
};
function _a61(_a67,_a68,_a69){
var opts=$.data(_a67,"combobox").options;
var _a6a=$(_a67).combo("panel");
if(!$.isArray(_a68)){
_a68=_a68.split(opts.separator);
}
if(!opts.multiple){
_a68=_a68.length?[_a68[0]]:[""];
}
var _a6b=$(_a67).combo("getValues");
if(_a6a.is(":visible")){
_a6a.find(".combobox-item-selected").each(function(){
var row=opts.finder.getRow(_a67,$(this));
if(row){
if($.easyui.indexOfArray(_a6b,row[opts.valueField])==-1){
$(this).removeClass("combobox-item-selected");
}
}
});
}
$.map(_a6b,function(v){
if($.easyui.indexOfArray(_a68,v)==-1){
var el=opts.finder.getEl(_a67,v);
if(el.hasClass("combobox-item-selected")){
el.removeClass("combobox-item-selected");
opts.onUnselect.call(_a67,opts.finder.getRow(_a67,v));
}
}
});
var _a6c=null;
var vv=[],ss=[];
for(var i=0;i<_a68.length;i++){
var v=_a68[i];
var s=v;
var row=opts.finder.getRow(_a67,v);
if(row){
s=row[opts.textField];
_a6c=row;
var el=opts.finder.getEl(_a67,v);
if(!el.hasClass("combobox-item-selected")){
el.addClass("combobox-item-selected");
opts.onSelect.call(_a67,row);
}
}
vv.push(v);
ss.push(s);
}
if(!_a69){
$(_a67).combo("setText",ss.join(opts.separator));
}
if(opts.showItemIcon){
var tb=$(_a67).combobox("textbox");
tb.removeClass("textbox-bgicon "+opts.textboxIconCls);
if(_a6c&&_a6c.iconCls){
tb.addClass("textbox-bgicon "+_a6c.iconCls);
opts.textboxIconCls=_a6c.iconCls;
}
}
$(_a67).combo("setValues",vv);
_a6a.triggerHandler("scroll");
};
function _a6d(_a6e,data,_a6f){
var _a70=$.data(_a6e,"combobox");
var opts=_a70.options;
_a70.data=opts.loadFilter.call(_a6e,data);
opts.view.render.call(opts.view,_a6e,$(_a6e).combo("panel"),_a70.data);
var vv=$(_a6e).combobox("getValues");
$.easyui.forEach(_a70.data,false,function(row){
if(row["selected"]){
$.easyui.addArrayItem(vv,row[opts.valueField]+"");
}
});
if(opts.multiple){
_a61(_a6e,vv,_a6f);
}else{
_a61(_a6e,vv.length?[vv[vv.length-1]]:[],_a6f);
}
opts.onLoadSuccess.call(_a6e,data);
};
function _a71(_a72,url,_a73,_a74){
var opts=$.data(_a72,"combobox").options;
if(url){
opts.url=url;
}
_a73=$.extend({},opts.queryParams,_a73||{});
if(opts.onBeforeLoad.call(_a72,_a73)==false){
return;
}
opts.loader.call(_a72,_a73,function(data){
_a6d(_a72,data,_a74);
},function(){
opts.onLoadError.apply(this,arguments);
});
};
function _a75(_a76,q){
var _a77=$.data(_a76,"combobox");
var opts=_a77.options;
var _a78=$();
var qq=opts.multiple?q.split(opts.separator):[q];
if(opts.mode=="remote"){
_a79(qq);
_a71(_a76,null,{q:q},true);
}else{
var _a7a=$(_a76).combo("panel");
_a7a.find(".combobox-item-hover").removeClass("combobox-item-hover");
_a7a.find(".combobox-item,.combobox-group").hide();
var data=_a77.data;
var vv=[];
$.map(qq,function(q){
q=$.trim(q);
var _a7b=q;
var _a7c=undefined;
_a78=$();
for(var i=0;i<data.length;i++){
var row=data[i];
if(opts.filter.call(_a76,q,row)){
var v=row[opts.valueField];
var s=row[opts.textField];
var g=row[opts.groupField];
var item=opts.finder.getEl(_a76,v).show();
if(s.toLowerCase()==q.toLowerCase()){
_a7b=v;
if(opts.reversed){
_a78=item;
}else{
_a5c(_a76,v,true);
}
}
if(opts.groupField&&_a7c!=g){
opts.finder.getGroupEl(_a76,g).show();
_a7c=g;
}
}
}
vv.push(_a7b);
});
_a79(vv);
}
function _a79(vv){
if(opts.reversed){
_a78.addClass("combobox-item-hover");
}else{
_a61(_a76,opts.multiple?(q?vv:[]):vv,true);
}
};
};
function _a7d(_a7e){
var t=$(_a7e);
var opts=t.combobox("options");
var _a7f=t.combobox("panel");
var item=_a7f.children("div.combobox-item-hover");
if(item.length){
item.removeClass("combobox-item-hover");
var row=opts.finder.getRow(_a7e,item);
var _a80=row[opts.valueField];
if(opts.multiple){
if(item.hasClass("combobox-item-selected")){
t.combobox("unselect",_a80);
}else{
t.combobox("select",_a80);
}
}else{
t.combobox("select",_a80);
}
}
var vv=[];
$.map(t.combobox("getValues"),function(v){
if(_a50(_a7e,v)>=0){
vv.push(v);
}
});
t.combobox("setValues",vv);
if(!opts.multiple){
t.combobox("hidePanel");
}
};
function _a81(_a82){
var _a83=$.data(_a82,"combobox");
var opts=_a83.options;
$(_a82).addClass("combobox-f");
$(_a82).combo($.extend({},opts,{onShowPanel:function(){
$(this).combo("panel").find("div.combobox-item:hidden,div.combobox-group:hidden").show();
_a61(this,$(this).combobox("getValues"),true);
$(this).combobox("scrollTo",$(this).combobox("getValue"));
opts.onShowPanel.call(this);
}}));
var p=$(_a82).combo("panel");
p.unbind(".combobox");
for(var _a84 in opts.panelEvents){
p.bind(_a84+".combobox",{target:_a82},opts.panelEvents[_a84]);
}
};
function _a85(e){
$(this).children("div.combobox-item-hover").removeClass("combobox-item-hover");
var item=$(e.target).closest("div.combobox-item");
if(!item.hasClass("combobox-item-disabled")){
item.addClass("combobox-item-hover");
}
e.stopPropagation();
};
function _a86(e){
$(e.target).closest("div.combobox-item").removeClass("combobox-item-hover");
e.stopPropagation();
};
function _a87(e){
var _a88=$(this).panel("options").comboTarget;
if(!_a88){
return;
}
var opts=$(_a88).combobox("options");
var item=$(e.target).closest("div.combobox-item");
if(!item.length||item.hasClass("combobox-item-disabled")){
return;
}
var row=opts.finder.getRow(_a88,item);
if(!row){
return;
}
if(opts.blurTimer){
clearTimeout(opts.blurTimer);
opts.blurTimer=null;
}
opts.onClick.call(_a88,row);
var _a89=row[opts.valueField];
if(opts.multiple){
if(item.hasClass("combobox-item-selected")){
_a62(_a88,_a89);
}else{
_a5c(_a88,_a89);
}
}else{
$(_a88).combobox("setValue",_a89).combobox("hidePanel");
}
e.stopPropagation();
};
function _a8a(e){
var _a8b=$(this).panel("options").comboTarget;
if(!_a8b){
return;
}
var opts=$(_a8b).combobox("options");
if(opts.groupPosition=="sticky"){
var _a8c=$(this).children(".combobox-stick");
if(!_a8c.length){
_a8c=$("<div class=\"combobox-stick\"></div>").appendTo(this);
}
_a8c.hide();
var _a8d=$(_a8b).data("combobox");
$(this).children(".combobox-group:visible").each(function(){
var g=$(this);
var _a8e=opts.finder.getGroup(_a8b,g);
var _a8f=_a8d.data[_a8e.startIndex+_a8e.count-1];
var last=opts.finder.getEl(_a8b,_a8f[opts.valueField]);
if(g.position().top<0&&last.position().top>0){
_a8c.show().html(g.html());
return false;
}
});
}
};
$.fn.combobox=function(_a90,_a91){
if(typeof _a90=="string"){
var _a92=$.fn.combobox.methods[_a90];
if(_a92){
return _a92(this,_a91);
}else{
return this.combo(_a90,_a91);
}
}
_a90=_a90||{};
return this.each(function(){
var _a93=$.data(this,"combobox");
if(_a93){
$.extend(_a93.options,_a90);
}else{
_a93=$.data(this,"combobox",{options:$.extend({},$.fn.combobox.defaults,$.fn.combobox.parseOptions(this),_a90),data:[]});
}
_a81(this);
if(_a93.options.data){
_a6d(this,_a93.options.data);
}else{
var data=$.fn.combobox.parseData(this);
if(data.length){
_a6d(this,data);
}
}
_a71(this);
});
};
$.fn.combobox.methods={options:function(jq){
var _a94=jq.combo("options");
return $.extend($.data(jq[0],"combobox").options,{width:_a94.width,height:_a94.height,originalValue:_a94.originalValue,disabled:_a94.disabled,readonly:_a94.readonly});
},cloneFrom:function(jq,from){
return jq.each(function(){
$(this).combo("cloneFrom",from);
$.data(this,"combobox",$(from).data("combobox"));
$(this).addClass("combobox-f").attr("comboboxName",$(this).attr("textboxName"));
});
},getData:function(jq){
return $.data(jq[0],"combobox").data;
},setValues:function(jq,_a95){
return jq.each(function(){
_a61(this,_a95);
});
},setValue:function(jq,_a96){
return jq.each(function(){
_a61(this,$.isArray(_a96)?_a96:[_a96]);
});
},clear:function(jq){
return jq.each(function(){
_a61(this,[]);
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).combobox("options");
if(opts.multiple){
$(this).combobox("setValues",opts.originalValue);
}else{
$(this).combobox("setValue",opts.originalValue);
}
});
},loadData:function(jq,data){
return jq.each(function(){
_a6d(this,data);
});
},reload:function(jq,url){
return jq.each(function(){
if(typeof url=="string"){
_a71(this,url);
}else{
if(url){
var opts=$(this).combobox("options");
opts.queryParams=url;
}
_a71(this);
}
});
},select:function(jq,_a97){
return jq.each(function(){
_a5c(this,_a97);
});
},unselect:function(jq,_a98){
return jq.each(function(){
_a62(this,_a98);
});
},scrollTo:function(jq,_a99){
return jq.each(function(){
_a54(this,_a99);
});
}};
$.fn.combobox.parseOptions=function(_a9a){
var t=$(_a9a);
return $.extend({},$.fn.combo.parseOptions(_a9a),$.parser.parseOptions(_a9a,["valueField","textField","groupField","groupPosition","mode","method","url",{showItemIcon:"boolean",limitToList:"boolean"}]));
};
$.fn.combobox.parseData=function(_a9b){
var data=[];
var opts=$(_a9b).combobox("options");
$(_a9b).children().each(function(){
if(this.tagName.toLowerCase()=="optgroup"){
var _a9c=$(this).attr("label");
$(this).children().each(function(){
_a9d(this,_a9c);
});
}else{
_a9d(this);
}
});
return data;
function _a9d(el,_a9e){
var t=$(el);
var row={};
row[opts.valueField]=t.attr("value")!=undefined?t.attr("value"):t.text();
row[opts.textField]=t.text();
row["selected"]=t.is(":selected");
row["disabled"]=t.is(":disabled");
if(_a9e){
opts.groupField=opts.groupField||"group";
row[opts.groupField]=_a9e;
}
data.push(row);
};
};
var _a9f=0;
var _aa0={render:function(_aa1,_aa2,data){
var _aa3=$.data(_aa1,"combobox");
var opts=_aa3.options;
_a9f++;
_aa3.itemIdPrefix="_easyui_combobox_i"+_a9f;
_aa3.groupIdPrefix="_easyui_combobox_g"+_a9f;
_aa3.groups=[];
var dd=[];
var _aa4=undefined;
for(var i=0;i<data.length;i++){
var row=data[i];
var v=row[opts.valueField]+"";
var s=row[opts.textField];
var g=row[opts.groupField];
if(g){
if(_aa4!=g){
_aa4=g;
_aa3.groups.push({value:g,startIndex:i,count:1});
dd.push("<div id=\""+(_aa3.groupIdPrefix+"_"+(_aa3.groups.length-1))+"\" class=\"combobox-group\">");
dd.push(opts.groupFormatter?opts.groupFormatter.call(_aa1,g):g);
dd.push("</div>");
}else{
_aa3.groups[_aa3.groups.length-1].count++;
}
}else{
_aa4=undefined;
}
var cls="combobox-item"+(row.disabled?" combobox-item-disabled":"")+(g?" combobox-gitem":"");
dd.push("<div id=\""+(_aa3.itemIdPrefix+"_"+i)+"\" class=\""+cls+"\">");
if(opts.showItemIcon&&row.iconCls){
dd.push("<span class=\"combobox-icon "+row.iconCls+"\"></span>");
}
dd.push(opts.formatter?opts.formatter.call(_aa1,row):s);
dd.push("</div>");
}
$(_aa2).html(dd.join(""));
}};
$.fn.combobox.defaults=$.extend({},$.fn.combo.defaults,{valueField:"value",textField:"text",groupPosition:"static",groupField:null,groupFormatter:function(_aa5){
return _aa5;
},mode:"local",method:"post",url:null,data:null,queryParams:{},showItemIcon:false,limitToList:false,view:_aa0,keyHandler:{up:function(e){
nav(this,"prev");
e.preventDefault();
},down:function(e){
nav(this,"next");
e.preventDefault();
},left:function(e){
},right:function(e){
},enter:function(e){
_a7d(this);
},query:function(q,e){
_a75(this,q);
}},inputEvents:$.extend({},$.fn.combo.defaults.inputEvents,{blur:function(e){
var _aa6=e.data.target;
var opts=$(_aa6).combobox("options");
if(opts.reversed||opts.limitToList){
if(opts.blurTimer){
clearTimeout(opts.blurTimer);
}
opts.blurTimer=setTimeout(function(){
var _aa7=$(_aa6).parent().length;
if(_aa7){
if(opts.reversed){
$(_aa6).combobox("setValues",$(_aa6).combobox("getValues"));
}else{
if(opts.limitToList){
_a7d(_aa6);
}
}
opts.blurTimer=null;
}
},50);
}
}}),panelEvents:{mouseover:_a85,mouseout:_a86,click:_a87,scroll:_a8a},filter:function(q,row){
var opts=$(this).combobox("options");
return row[opts.textField].toLowerCase().indexOf(q.toLowerCase())>=0;
},formatter:function(row){
var opts=$(this).combobox("options");
return row[opts.textField];
},loader:function(_aa8,_aa9,_aaa){
var opts=$(this).combobox("options");
if(!opts.url){
return false;
}
$.ajax({type:opts.method,url:opts.url,data:_aa8,dataType:"json",success:function(data){
_aa9(data);
},error:function(){
_aaa.apply(this,arguments);
}});
},loadFilter:function(data){
return data;
},finder:{getEl:function(_aab,_aac){
var _aad=_a50(_aab,_aac);
var id=$.data(_aab,"combobox").itemIdPrefix+"_"+_aad;
return $("#"+id);
},getGroupEl:function(_aae,_aaf){
var _ab0=$.data(_aae,"combobox");
var _ab1=$.easyui.indexOfArray(_ab0.groups,"value",_aaf);
var id=_ab0.groupIdPrefix+"_"+_ab1;
return $("#"+id);
},getGroup:function(_ab2,p){
var _ab3=$.data(_ab2,"combobox");
var _ab4=p.attr("id").substr(_ab3.groupIdPrefix.length+1);
return _ab3.groups[parseInt(_ab4)];
},getRow:function(_ab5,p){
var _ab6=$.data(_ab5,"combobox");
var _ab7=(p instanceof $)?p.attr("id").substr(_ab6.itemIdPrefix.length+1):_a50(_ab5,p);
return _ab6.data[parseInt(_ab7)];
}},onBeforeLoad:function(_ab8){
},onLoadSuccess:function(data){
},onLoadError:function(){
},onSelect:function(_ab9){
},onUnselect:function(_aba){
},onClick:function(_abb){
}});
})(jQuery);
(function($){
function _abc(_abd){
var _abe=$.data(_abd,"combotree");
var opts=_abe.options;
var tree=_abe.tree;
$(_abd).addClass("combotree-f");
$(_abd).combo($.extend({},opts,{onShowPanel:function(){
if(opts.editable){
tree.tree("doFilter","");
}
opts.onShowPanel.call(this);
}}));
var _abf=$(_abd).combo("panel");
if(!tree){
tree=$("<ul></ul>").appendTo(_abf);
_abe.tree=tree;
}
tree.tree($.extend({},opts,{checkbox:opts.multiple,onLoadSuccess:function(node,data){
var _ac0=$(_abd).combotree("getValues");
if(opts.multiple){
$.map(tree.tree("getChecked"),function(node){
$.easyui.addArrayItem(_ac0,node.id);
});
}
_ac5(_abd,_ac0,_abe.remainText);
opts.onLoadSuccess.call(this,node,data);
},onClick:function(node){
if(opts.multiple){
$(this).tree(node.checked?"uncheck":"check",node.target);
}else{
$(_abd).combo("hidePanel");
}
_abe.remainText=false;
_ac2(_abd);
opts.onClick.call(this,node);
},onCheck:function(node,_ac1){
_abe.remainText=false;
_ac2(_abd);
opts.onCheck.call(this,node,_ac1);
}}));
};
function _ac2(_ac3){
var _ac4=$.data(_ac3,"combotree");
var opts=_ac4.options;
var tree=_ac4.tree;
var vv=[];
if(opts.multiple){
vv=$.map(tree.tree("getChecked"),function(node){
return node.id;
});
}else{
var node=tree.tree("getSelected");
if(node){
vv.push(node.id);
}
}
vv=vv.concat(opts.unselectedValues);
_ac5(_ac3,vv,_ac4.remainText);
};
function _ac5(_ac6,_ac7,_ac8){
var _ac9=$.data(_ac6,"combotree");
var opts=_ac9.options;
var tree=_ac9.tree;
var _aca=tree.tree("options");
var _acb=_aca.onBeforeCheck;
var _acc=_aca.onCheck;
var _acd=_aca.onSelect;
_aca.onBeforeCheck=_aca.onCheck=_aca.onSelect=function(){
};
if(!$.isArray(_ac7)){
_ac7=_ac7.split(opts.separator);
}
if(!opts.multiple){
_ac7=_ac7.length?[_ac7[0]]:[""];
}
var vv=$.map(_ac7,function(_ace){
return String(_ace);
});
tree.find("div.tree-node-selected").removeClass("tree-node-selected");
$.map(tree.tree("getChecked"),function(node){
if($.inArray(String(node.id),vv)==-1){
tree.tree("uncheck",node.target);
}
});
var ss=[];
opts.unselectedValues=[];
$.map(vv,function(v){
var node=tree.tree("find",v);
if(node){
tree.tree("check",node.target).tree("select",node.target);
ss.push(_acf(node));
}else{
ss.push(_ad0(v,opts.mappingRows)||v);
opts.unselectedValues.push(v);
}
});
if(opts.multiple){
$.map(tree.tree("getChecked"),function(node){
var id=String(node.id);
if($.inArray(id,vv)==-1){
vv.push(id);
ss.push(_acf(node));
}
});
}
_aca.onBeforeCheck=_acb;
_aca.onCheck=_acc;
_aca.onSelect=_acd;
if(!_ac8){
var s=ss.join(opts.separator);
if($(_ac6).combo("getText")!=s){
$(_ac6).combo("setText",s);
}
}
$(_ac6).combo("setValues",vv);
function _ad0(_ad1,a){
var item=$.easyui.getArrayItem(a,"id",_ad1);
return item?_acf(item):undefined;
};
function _acf(node){
return node[opts.textField||""]||node.text;
};
};
function _ad2(_ad3,q){
var _ad4=$.data(_ad3,"combotree");
var opts=_ad4.options;
var tree=_ad4.tree;
_ad4.remainText=true;
tree.tree("doFilter",opts.multiple?q.split(opts.separator):q);
};
function _ad5(_ad6){
var _ad7=$.data(_ad6,"combotree");
_ad7.remainText=false;
$(_ad6).combotree("setValues",$(_ad6).combotree("getValues"));
$(_ad6).combotree("hidePanel");
};
$.fn.combotree=function(_ad8,_ad9){
if(typeof _ad8=="string"){
var _ada=$.fn.combotree.methods[_ad8];
if(_ada){
return _ada(this,_ad9);
}else{
return this.combo(_ad8,_ad9);
}
}
_ad8=_ad8||{};
return this.each(function(){
var _adb=$.data(this,"combotree");
if(_adb){
$.extend(_adb.options,_ad8);
}else{
$.data(this,"combotree",{options:$.extend({},$.fn.combotree.defaults,$.fn.combotree.parseOptions(this),_ad8)});
}
_abc(this);
});
};
$.fn.combotree.methods={options:function(jq){
var _adc=jq.combo("options");
return $.extend($.data(jq[0],"combotree").options,{width:_adc.width,height:_adc.height,originalValue:_adc.originalValue,disabled:_adc.disabled,readonly:_adc.readonly});
},clone:function(jq,_add){
var t=jq.combo("clone",_add);
t.data("combotree",{options:$.extend(true,{},jq.combotree("options")),tree:jq.combotree("tree")});
return t;
},tree:function(jq){
return $.data(jq[0],"combotree").tree;
},loadData:function(jq,data){
return jq.each(function(){
var opts=$.data(this,"combotree").options;
opts.data=data;
var tree=$.data(this,"combotree").tree;
tree.tree("loadData",data);
});
},reload:function(jq,url){
return jq.each(function(){
var opts=$.data(this,"combotree").options;
var tree=$.data(this,"combotree").tree;
if(url){
opts.url=url;
}
tree.tree({url:opts.url});
});
},setValues:function(jq,_ade){
return jq.each(function(){
var opts=$(this).combotree("options");
if($.isArray(_ade)){
_ade=$.map(_ade,function(_adf){
if(_adf&&typeof _adf=="object"){
$.easyui.addArrayItem(opts.mappingRows,"id",_adf);
return _adf.id;
}else{
return _adf;
}
});
}
_ac5(this,_ade);
});
},setValue:function(jq,_ae0){
return jq.each(function(){
$(this).combotree("setValues",$.isArray(_ae0)?_ae0:[_ae0]);
});
},clear:function(jq){
return jq.each(function(){
$(this).combotree("setValues",[]);
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).combotree("options");
if(opts.multiple){
$(this).combotree("setValues",opts.originalValue);
}else{
$(this).combotree("setValue",opts.originalValue);
}
});
}};
$.fn.combotree.parseOptions=function(_ae1){
return $.extend({},$.fn.combo.parseOptions(_ae1),$.fn.tree.parseOptions(_ae1));
};
$.fn.combotree.defaults=$.extend({},$.fn.combo.defaults,$.fn.tree.defaults,{editable:false,textField:null,unselectedValues:[],mappingRows:[],keyHandler:{up:function(e){
},down:function(e){
},left:function(e){
},right:function(e){
},enter:function(e){
_ad5(this);
},query:function(q,e){
_ad2(this,q);
}}});
})(jQuery);
(function($){
function _ae2(_ae3){
var _ae4=$.data(_ae3,"combogrid");
var opts=_ae4.options;
var grid=_ae4.grid;
$(_ae3).addClass("combogrid-f").combo($.extend({},opts,{onShowPanel:function(){
_af9(this,$(this).combogrid("getValues"),true);
var p=$(this).combogrid("panel");
var _ae5=p.outerHeight()-p.height();
var _ae6=p._size("minHeight");
var _ae7=p._size("maxHeight");
var dg=$(this).combogrid("grid");
dg.datagrid("resize",{width:"100%",height:(isNaN(parseInt(opts.panelHeight))?"auto":"100%"),minHeight:(_ae6?_ae6-_ae5:""),maxHeight:(_ae7?_ae7-_ae5:"")});
var row=dg.datagrid("getSelected");
if(row){
dg.datagrid("scrollTo",dg.datagrid("getRowIndex",row));
}
opts.onShowPanel.call(this);
}}));
var _ae8=$(_ae3).combo("panel");
if(!grid){
grid=$("<table></table>").appendTo(_ae8);
_ae4.grid=grid;
}
grid.datagrid($.extend({},opts,{border:false,singleSelect:(!opts.multiple),onLoadSuccess:_ae9,onClickRow:_aea,onSelect:_aeb("onSelect"),onUnselect:_aeb("onUnselect"),onSelectAll:_aeb("onSelectAll"),onUnselectAll:_aeb("onUnselectAll")}));
function _aec(dg){
return $(dg).closest(".combo-panel").panel("options").comboTarget||_ae3;
};
function _ae9(data){
var _aed=_aec(this);
var _aee=$(_aed).data("combogrid");
var opts=_aee.options;
var _aef=$(_aed).combo("getValues");
_af9(_aed,_aef,_aee.remainText);
opts.onLoadSuccess.call(this,data);
};
function _aea(_af0,row){
var _af1=_aec(this);
var _af2=$(_af1).data("combogrid");
var opts=_af2.options;
_af2.remainText=false;
_af3.call(this);
if(!opts.multiple){
$(_af1).combo("hidePanel");
}
opts.onClickRow.call(this,_af0,row);
};
function _aeb(_af4){
return function(_af5,row){
var _af6=_aec(this);
var opts=$(_af6).combogrid("options");
if(_af4=="onUnselectAll"){
if(opts.multiple){
_af3.call(this);
}
}else{
_af3.call(this);
}
opts[_af4].call(this,_af5,row);
};
};
function _af3(){
var dg=$(this);
var _af7=_aec(dg);
var _af8=$(_af7).data("combogrid");
var opts=_af8.options;
var vv=$.map(dg.datagrid("getSelections"),function(row){
return row[opts.idField];
});
vv=vv.concat(opts.unselectedValues);
_af9(_af7,vv,_af8.remainText);
};
};
function nav(_afa,dir){
var _afb=$.data(_afa,"combogrid");
var opts=_afb.options;
var grid=_afb.grid;
var _afc=grid.datagrid("getRows").length;
if(!_afc){
return;
}
var tr=opts.finder.getTr(grid[0],null,"highlight");
if(!tr.length){
tr=opts.finder.getTr(grid[0],null,"selected");
}
var _afd;
if(!tr.length){
_afd=(dir=="next"?0:_afc-1);
}else{
var _afd=parseInt(tr.attr("datagrid-row-index"));
_afd+=(dir=="next"?1:-1);
if(_afd<0){
_afd=_afc-1;
}
if(_afd>=_afc){
_afd=0;
}
}
grid.datagrid("highlightRow",_afd);
if(opts.selectOnNavigation){
_afb.remainText=false;
grid.datagrid("selectRow",_afd);
}
};
function _af9(_afe,_aff,_b00){
var _b01=$.data(_afe,"combogrid");
var opts=_b01.options;
var grid=_b01.grid;
var _b02=$(_afe).combo("getValues");
var _b03=$(_afe).combo("options");
var _b04=_b03.onChange;
_b03.onChange=function(){
};
var _b05=grid.datagrid("options");
var _b06=_b05.onSelect;
var _b07=_b05.onUnselectAll;
_b05.onSelect=_b05.onUnselectAll=function(){
};
if(!$.isArray(_aff)){
_aff=_aff.split(opts.separator);
}
if(!opts.multiple){
_aff=_aff.length?[_aff[0]]:[""];
}
var vv=$.map(_aff,function(_b08){
return String(_b08);
});
vv=$.grep(vv,function(v,_b09){
return _b09===$.inArray(v,vv);
});
var _b0a=$.grep(grid.datagrid("getSelections"),function(row,_b0b){
return $.inArray(String(row[opts.idField]),vv)>=0;
});
grid.datagrid("clearSelections");
grid.data("datagrid").selectedRows=_b0a;
var ss=[];
opts.unselectedValues=[];
$.map(vv,function(v){
var _b0c=grid.datagrid("getRowIndex",v);
if(_b0c>=0){
grid.datagrid("selectRow",_b0c);
}else{
opts.unselectedValues.push(v);
}
ss.push(_b0d(v,grid.datagrid("getRows"))||_b0d(v,_b0a)||_b0d(v,opts.mappingRows)||v);
});
$(_afe).combo("setValues",_b02);
_b03.onChange=_b04;
_b05.onSelect=_b06;
_b05.onUnselectAll=_b07;
if(!_b00){
var s=ss.join(opts.separator);
if($(_afe).combo("getText")!=s){
$(_afe).combo("setText",s);
}
}
$(_afe).combo("setValues",_aff);
function _b0d(_b0e,a){
var item=$.easyui.getArrayItem(a,opts.idField,_b0e);
return item?item[opts.textField]:undefined;
};
};
function _b0f(_b10,q){
var _b11=$.data(_b10,"combogrid");
var opts=_b11.options;
var grid=_b11.grid;
_b11.remainText=true;
var qq=opts.multiple?q.split(opts.separator):[q];
qq=$.grep(qq,function(q){
return $.trim(q)!="";
});
if(opts.mode=="remote"){
_b12(qq);
grid.datagrid("load",$.extend({},opts.queryParams,{q:q}));
}else{
grid.datagrid("highlightRow",-1);
var rows=grid.datagrid("getRows");
var vv=[];
$.map(qq,function(q){
q=$.trim(q);
var _b13=q;
_b14(opts.mappingRows,q);
_b14(grid.datagrid("getSelections"),q);
var _b15=_b14(rows,q);
if(_b15>=0){
if(opts.reversed){
grid.datagrid("highlightRow",_b15);
}
}else{
$.map(rows,function(row,i){
if(opts.filter.call(_b10,q,row)){
grid.datagrid("highlightRow",i);
}
});
}
});
_b12(vv);
}
function _b14(rows,q){
for(var i=0;i<rows.length;i++){
var row=rows[i];
if((row[opts.textField]||"").toLowerCase()==q.toLowerCase()){
vv.push(row[opts.idField]);
return i;
}
}
return -1;
};
function _b12(vv){
if(!opts.reversed){
_af9(_b10,vv,true);
}
};
};
function _b16(_b17){
var _b18=$.data(_b17,"combogrid");
var opts=_b18.options;
var grid=_b18.grid;
var tr=opts.finder.getTr(grid[0],null,"highlight");
_b18.remainText=false;
if(tr.length){
var _b19=parseInt(tr.attr("datagrid-row-index"));
if(opts.multiple){
if(tr.hasClass("datagrid-row-selected")){
grid.datagrid("unselectRow",_b19);
}else{
grid.datagrid("selectRow",_b19);
}
}else{
grid.datagrid("selectRow",_b19);
}
}
var vv=[];
$.map(grid.datagrid("getSelections"),function(row){
vv.push(row[opts.idField]);
});
$.map(opts.unselectedValues,function(v){
if($.easyui.indexOfArray(opts.mappingRows,opts.idField,v)>=0){
$.easyui.addArrayItem(vv,v);
}
});
$(_b17).combogrid("setValues",vv);
if(!opts.multiple){
$(_b17).combogrid("hidePanel");
}
};
$.fn.combogrid=function(_b1a,_b1b){
if(typeof _b1a=="string"){
var _b1c=$.fn.combogrid.methods[_b1a];
if(_b1c){
return _b1c(this,_b1b);
}else{
return this.combo(_b1a,_b1b);
}
}
_b1a=_b1a||{};
return this.each(function(){
var _b1d=$.data(this,"combogrid");
if(_b1d){
$.extend(_b1d.options,_b1a);
}else{
_b1d=$.data(this,"combogrid",{options:$.extend({},$.fn.combogrid.defaults,$.fn.combogrid.parseOptions(this),_b1a)});
}
_ae2(this);
});
};
$.fn.combogrid.methods={options:function(jq){
var _b1e=jq.combo("options");
return $.extend($.data(jq[0],"combogrid").options,{width:_b1e.width,height:_b1e.height,originalValue:_b1e.originalValue,disabled:_b1e.disabled,readonly:_b1e.readonly});
},cloneFrom:function(jq,from){
return jq.each(function(){
$(this).combo("cloneFrom",from);
$.data(this,"combogrid",{options:$.extend(true,{cloned:true},$(from).combogrid("options")),combo:$(this).next(),panel:$(from).combo("panel"),grid:$(from).combogrid("grid")});
});
},grid:function(jq){
return $.data(jq[0],"combogrid").grid;
},setValues:function(jq,_b1f){
return jq.each(function(){
var opts=$(this).combogrid("options");
if($.isArray(_b1f)){
_b1f=$.map(_b1f,function(_b20){
if(_b20&&typeof _b20=="object"){
$.easyui.addArrayItem(opts.mappingRows,opts.idField,_b20);
return _b20[opts.idField];
}else{
return _b20;
}
});
}
_af9(this,_b1f);
});
},setValue:function(jq,_b21){
return jq.each(function(){
$(this).combogrid("setValues",$.isArray(_b21)?_b21:[_b21]);
});
},clear:function(jq){
return jq.each(function(){
$(this).combogrid("setValues",[]);
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).combogrid("options");
if(opts.multiple){
$(this).combogrid("setValues",opts.originalValue);
}else{
$(this).combogrid("setValue",opts.originalValue);
}
});
}};
$.fn.combogrid.parseOptions=function(_b22){
var t=$(_b22);
return $.extend({},$.fn.combo.parseOptions(_b22),$.fn.datagrid.parseOptions(_b22),$.parser.parseOptions(_b22,["idField","textField","mode"]));
};
$.fn.combogrid.defaults=$.extend({},$.fn.combo.defaults,$.fn.datagrid.defaults,{loadMsg:null,idField:null,textField:null,unselectedValues:[],mappingRows:[],mode:"local",keyHandler:{up:function(e){
nav(this,"prev");
e.preventDefault();
},down:function(e){
nav(this,"next");
e.preventDefault();
},left:function(e){
},right:function(e){
},enter:function(e){
_b16(this);
},query:function(q,e){
_b0f(this,q);
}},inputEvents:$.extend({},$.fn.combo.defaults.inputEvents,{blur:function(e){
var _b23=e.data.target;
var opts=$(_b23).combogrid("options");
if(opts.reversed){
$(_b23).combogrid("setValues",$(_b23).combogrid("getValues"));
}
}}),filter:function(q,row){
var opts=$(this).combogrid("options");
return (row[opts.textField]||"").toLowerCase().indexOf(q.toLowerCase())>=0;
}});
})(jQuery);
(function($){
function _b24(_b25){
var _b26=$.data(_b25,"combotreegrid");
var opts=_b26.options;
$(_b25).addClass("combotreegrid-f").combo($.extend({},opts,{onShowPanel:function(){
var p=$(this).combotreegrid("panel");
var _b27=p.outerHeight()-p.height();
var _b28=p._size("minHeight");
var _b29=p._size("maxHeight");
var dg=$(this).combotreegrid("grid");
dg.treegrid("resize",{width:"100%",height:(isNaN(parseInt(opts.panelHeight))?"auto":"100%"),minHeight:(_b28?_b28-_b27:""),maxHeight:(_b29?_b29-_b27:"")});
var row=dg.treegrid("getSelected");
if(row){
dg.treegrid("scrollTo",row[opts.idField]);
}
opts.onShowPanel.call(this);
}}));
if(!_b26.grid){
var _b2a=$(_b25).combo("panel");
_b26.grid=$("<table></table>").appendTo(_b2a);
}
_b26.grid.treegrid($.extend({},opts,{border:false,checkbox:opts.multiple,onLoadSuccess:function(row,data){
var _b2b=$(_b25).combotreegrid("getValues");
if(opts.multiple){
$.map($(this).treegrid("getCheckedNodes"),function(row){
$.easyui.addArrayItem(_b2b,row[opts.idField]);
});
}
_b30(_b25,_b2b);
opts.onLoadSuccess.call(this,row,data);
_b26.remainText=false;
},onClickRow:function(row){
if(opts.multiple){
$(this).treegrid(row.checked?"uncheckNode":"checkNode",row[opts.idField]);
$(this).treegrid("unselect",row[opts.idField]);
}else{
$(_b25).combo("hidePanel");
}
_b2d(_b25);
opts.onClickRow.call(this,row);
},onCheckNode:function(row,_b2c){
_b2d(_b25);
opts.onCheckNode.call(this,row,_b2c);
}}));
};
function _b2d(_b2e){
var _b2f=$.data(_b2e,"combotreegrid");
var opts=_b2f.options;
var grid=_b2f.grid;
var vv=[];
if(opts.multiple){
vv=$.map(grid.treegrid("getCheckedNodes"),function(row){
return row[opts.idField];
});
}else{
var row=grid.treegrid("getSelected");
if(row){
vv.push(row[opts.idField]);
}
}
vv=vv.concat(opts.unselectedValues);
_b30(_b2e,vv);
};
function _b30(_b31,_b32){
var _b33=$.data(_b31,"combotreegrid");
var opts=_b33.options;
var grid=_b33.grid;
if(!$.isArray(_b32)){
_b32=_b32.split(opts.separator);
}
if(!opts.multiple){
_b32=_b32.length?[_b32[0]]:[""];
}
var vv=$.map(_b32,function(_b34){
return String(_b34);
});
vv=$.grep(vv,function(v,_b35){
return _b35===$.inArray(v,vv);
});
var _b36=grid.treegrid("getSelected");
if(_b36){
grid.treegrid("unselect",_b36[opts.idField]);
}
$.map(grid.treegrid("getCheckedNodes"),function(row){
if($.inArray(String(row[opts.idField]),vv)==-1){
grid.treegrid("uncheckNode",row[opts.idField]);
}
});
var ss=[];
opts.unselectedValues=[];
$.map(vv,function(v){
var row=grid.treegrid("find",v);
if(row){
if(opts.multiple){
grid.treegrid("checkNode",v);
}else{
grid.treegrid("select",v);
}
ss.push(_b37(row));
}else{
ss.push(_b38(v,opts.mappingRows)||v);
opts.unselectedValues.push(v);
}
});
if(opts.multiple){
$.map(grid.treegrid("getCheckedNodes"),function(row){
var id=String(row[opts.idField]);
if($.inArray(id,vv)==-1){
vv.push(id);
ss.push(_b37(row));
}
});
}
if(!_b33.remainText){
var s=ss.join(opts.separator);
if($(_b31).combo("getText")!=s){
$(_b31).combo("setText",s);
}
}
$(_b31).combo("setValues",vv);
function _b38(_b39,a){
var item=$.easyui.getArrayItem(a,opts.idField,_b39);
return item?_b37(item):undefined;
};
function _b37(row){
return row[opts.textField||""]||row[opts.treeField];
};
};
function _b3a(_b3b,q){
var _b3c=$.data(_b3b,"combotreegrid");
var opts=_b3c.options;
var grid=_b3c.grid;
_b3c.remainText=true;
grid.treegrid("clearSelections").treegrid("clearChecked").treegrid("highlightRow",-1);
if(opts.mode=="remote"){
$(_b3b).combotreegrid("clear");
grid.treegrid("load",$.extend({},opts.queryParams,{q:q}));
}else{
if(q){
var data=grid.treegrid("getData");
var vv=[];
var qq=opts.multiple?q.split(opts.separator):[q];
$.map(qq,function(q){
q=$.trim(q);
if(q){
var v=undefined;
$.easyui.forEach(data,true,function(row){
if(q.toLowerCase()==String(row[opts.treeField]).toLowerCase()){
v=row[opts.idField];
return false;
}else{
if(opts.filter.call(_b3b,q,row)){
grid.treegrid("expandTo",row[opts.idField]);
grid.treegrid("highlightRow",row[opts.idField]);
return false;
}
}
});
if(v==undefined){
$.easyui.forEach(opts.mappingRows,false,function(row){
if(q.toLowerCase()==String(row[opts.treeField])){
v=row[opts.idField];
return false;
}
});
}
if(v!=undefined){
vv.push(v);
}
}
});
_b30(_b3b,vv);
_b3c.remainText=false;
}
}
};
function _b3d(_b3e){
_b2d(_b3e);
};
$.fn.combotreegrid=function(_b3f,_b40){
if(typeof _b3f=="string"){
var _b41=$.fn.combotreegrid.methods[_b3f];
if(_b41){
return _b41(this,_b40);
}else{
return this.combo(_b3f,_b40);
}
}
_b3f=_b3f||{};
return this.each(function(){
var _b42=$.data(this,"combotreegrid");
if(_b42){
$.extend(_b42.options,_b3f);
}else{
_b42=$.data(this,"combotreegrid",{options:$.extend({},$.fn.combotreegrid.defaults,$.fn.combotreegrid.parseOptions(this),_b3f)});
}
_b24(this);
});
};
$.fn.combotreegrid.methods={options:function(jq){
var _b43=jq.combo("options");
return $.extend($.data(jq[0],"combotreegrid").options,{width:_b43.width,height:_b43.height,originalValue:_b43.originalValue,disabled:_b43.disabled,readonly:_b43.readonly});
},grid:function(jq){
return $.data(jq[0],"combotreegrid").grid;
},setValues:function(jq,_b44){
return jq.each(function(){
var opts=$(this).combotreegrid("options");
if($.isArray(_b44)){
_b44=$.map(_b44,function(_b45){
if(_b45&&typeof _b45=="object"){
$.easyui.addArrayItem(opts.mappingRows,opts.idField,_b45);
return _b45[opts.idField];
}else{
return _b45;
}
});
}
_b30(this,_b44);
});
},setValue:function(jq,_b46){
return jq.each(function(){
$(this).combotreegrid("setValues",$.isArray(_b46)?_b46:[_b46]);
});
},clear:function(jq){
return jq.each(function(){
$(this).combotreegrid("setValues",[]);
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).combotreegrid("options");
if(opts.multiple){
$(this).combotreegrid("setValues",opts.originalValue);
}else{
$(this).combotreegrid("setValue",opts.originalValue);
}
});
}};
$.fn.combotreegrid.parseOptions=function(_b47){
var t=$(_b47);
return $.extend({},$.fn.combo.parseOptions(_b47),$.fn.treegrid.parseOptions(_b47),$.parser.parseOptions(_b47,["mode",{limitToGrid:"boolean"}]));
};
$.fn.combotreegrid.defaults=$.extend({},$.fn.combo.defaults,$.fn.treegrid.defaults,{editable:false,singleSelect:true,limitToGrid:false,unselectedValues:[],mappingRows:[],mode:"local",textField:null,keyHandler:{up:function(e){
},down:function(e){
},left:function(e){
},right:function(e){
},enter:function(e){
_b3d(this);
},query:function(q,e){
_b3a(this,q);
}},inputEvents:$.extend({},$.fn.combo.defaults.inputEvents,{blur:function(e){
var _b48=e.data.target;
var opts=$(_b48).combotreegrid("options");
if(opts.limitToGrid){
_b3d(_b48);
}
}}),filter:function(q,row){
var opts=$(this).combotreegrid("options");
return (row[opts.treeField]||"").toLowerCase().indexOf(q.toLowerCase())>=0;
}});
})(jQuery);
(function($){
function _b49(_b4a){
var _b4b=$.data(_b4a,"tagbox");
var opts=_b4b.options;
$(_b4a).addClass("tagbox-f").combobox($.extend({},opts,{cls:"tagbox",reversed:true,onChange:function(_b4c,_b4d){
_b4e();
$(this).combobox("hidePanel");
opts.onChange.call(_b4a,_b4c,_b4d);
},onResizing:function(_b4f,_b50){
var _b51=$(this).combobox("textbox");
var tb=$(this).data("textbox").textbox;
tb.css({height:"",paddingLeft:_b51.css("marginLeft"),paddingRight:_b51.css("marginRight")});
_b51.css("margin",0);
tb._size({width:opts.width},$(this).parent());
_b64(_b4a);
_b56(this);
opts.onResizing.call(_b4a,_b4f,_b50);
},onLoadSuccess:function(data){
_b4e();
opts.onLoadSuccess.call(_b4a,data);
}}));
_b4e();
_b64(_b4a);
function _b4e(){
$(_b4a).next().find(".tagbox-label").remove();
var _b52=$(_b4a).tagbox("textbox");
var ss=[];
$.map($(_b4a).tagbox("getValues"),function(_b53,_b54){
var row=opts.finder.getRow(_b4a,_b53);
var text=opts.tagFormatter.call(_b4a,_b53,row);
var cs={};
var css=opts.tagStyler.call(_b4a,_b53,row)||"";
if(typeof css=="string"){
cs={s:css};
}else{
cs={c:css["class"]||"",s:css["style"]||""};
}
var _b55=$("<span class=\"tagbox-label\"></span>").insertBefore(_b52).html(text);
_b55.attr("tagbox-index",_b54);
_b55.attr("style",cs.s).addClass(cs.c);
$("<a href=\"javascript:;\" class=\"tagbox-remove\"></a>").appendTo(_b55);
});
_b56(_b4a);
$(_b4a).combobox("setText","");
};
};
function _b56(_b57,_b58){
var span=$(_b57).next();
var _b59=_b58?$(_b58):span.find(".tagbox-label");
if(_b59.length){
var _b5a=$(_b57).tagbox("textbox");
var _b5b=$(_b59[0]);
var _b5c=_b5b.outerHeight(true)-_b5b.outerHeight();
var _b5d=_b5a.outerHeight()-_b5c*2;
_b59.css({height:_b5d+"px",lineHeight:_b5d+"px"});
var _b5e=span.find(".textbox-addon").css("height","100%");
_b5e.find(".textbox-icon").css("height","100%");
span.find(".textbox-button").linkbutton("resize",{height:"100%"});
}
};
function _b5f(_b60){
var span=$(_b60).next();
span.unbind(".tagbox").bind("click.tagbox",function(e){
var opts=$(_b60).tagbox("options");
if(opts.disabled||opts.readonly){
return;
}
if($(e.target).hasClass("tagbox-remove")){
var _b61=parseInt($(e.target).parent().attr("tagbox-index"));
var _b62=$(_b60).tagbox("getValues");
if(opts.onBeforeRemoveTag.call(_b60,_b62[_b61])==false){
return;
}
opts.onRemoveTag.call(_b60,_b62[_b61]);
_b62.splice(_b61,1);
$(_b60).tagbox("setValues",_b62);
}else{
var _b63=$(e.target).closest(".tagbox-label");
if(_b63.length){
var _b61=parseInt(_b63.attr("tagbox-index"));
var _b62=$(_b60).tagbox("getValues");
opts.onClickTag.call(_b60,_b62[_b61]);
}
}
$(this).find(".textbox-text").focus();
}).bind("keyup.tagbox",function(e){
_b64(_b60);
}).bind("mouseover.tagbox",function(e){
if($(e.target).closest(".textbox-button,.textbox-addon,.tagbox-label").length){
$(this).triggerHandler("mouseleave");
}else{
$(this).find(".textbox-text").triggerHandler("mouseenter");
}
}).bind("mouseleave.tagbox",function(e){
$(this).find(".textbox-text").triggerHandler("mouseleave");
});
};
function _b64(_b65){
var opts=$(_b65).tagbox("options");
var _b66=$(_b65).tagbox("textbox");
var span=$(_b65).next();
var tmp=$("<span></span>").appendTo("body");
tmp.attr("style",_b66.attr("style"));
tmp.css({position:"absolute",top:-9999,left:-9999,width:"auto",fontFamily:_b66.css("fontFamily"),fontSize:_b66.css("fontSize"),fontWeight:_b66.css("fontWeight"),whiteSpace:"nowrap"});
var _b67=_b68(_b66.val());
var _b69=_b68(opts.prompt||"");
tmp.remove();
var _b6a=Math.min(Math.max(_b67,_b69)+20,span.width());
_b66._outerWidth(_b6a);
span.find(".textbox-button").linkbutton("resize",{height:"100%"});
function _b68(val){
var s=val.replace(/&/g,"&amp;").replace(/\s/g," ").replace(/</g,"&lt;").replace(/>/g,"&gt;");
tmp.html(s);
return tmp.outerWidth();
};
};
function _b6b(_b6c){
var t=$(_b6c);
var opts=t.tagbox("options");
if(opts.limitToList){
var _b6d=t.tagbox("panel");
var item=_b6d.children("div.combobox-item-hover");
if(item.length){
item.removeClass("combobox-item-hover");
var row=opts.finder.getRow(_b6c,item);
var _b6e=row[opts.valueField];
$(_b6c).tagbox(item.hasClass("combobox-item-selected")?"unselect":"select",_b6e);
}
$(_b6c).tagbox("hidePanel");
}else{
var v=$.trim($(_b6c).tagbox("getText"));
if(v!==""){
var _b6f=$(_b6c).tagbox("getValues");
_b6f.push(v);
$(_b6c).tagbox("setValues",_b6f);
}
}
};
function _b70(_b71,_b72){
$(_b71).combobox("setText","");
_b64(_b71);
$(_b71).combobox("setValues",_b72);
$(_b71).combobox("setText","");
$(_b71).tagbox("validate");
};
$.fn.tagbox=function(_b73,_b74){
if(typeof _b73=="string"){
var _b75=$.fn.tagbox.methods[_b73];
if(_b75){
return _b75(this,_b74);
}else{
return this.combobox(_b73,_b74);
}
}
_b73=_b73||{};
return this.each(function(){
var _b76=$.data(this,"tagbox");
if(_b76){
$.extend(_b76.options,_b73);
}else{
$.data(this,"tagbox",{options:$.extend({},$.fn.tagbox.defaults,$.fn.tagbox.parseOptions(this),_b73)});
}
_b49(this);
_b5f(this);
});
};
$.fn.tagbox.methods={options:function(jq){
var _b77=jq.combobox("options");
return $.extend($.data(jq[0],"tagbox").options,{width:_b77.width,height:_b77.height,originalValue:_b77.originalValue,disabled:_b77.disabled,readonly:_b77.readonly});
},setValues:function(jq,_b78){
return jq.each(function(){
_b70(this,_b78);
});
}};
$.fn.tagbox.parseOptions=function(_b79){
return $.extend({},$.fn.combobox.parseOptions(_b79),$.parser.parseOptions(_b79,[]));
};
$.fn.tagbox.defaults=$.extend({},$.fn.combobox.defaults,{hasDownArrow:false,multiple:true,reversed:true,selectOnNavigation:false,tipOptions:$.extend({},$.fn.textbox.defaults.tipOptions,{showDelay:200}),val:function(_b7a){
var vv=$(_b7a).parent().prev().tagbox("getValues");
if($(_b7a).is(":focus")){
vv.push($(_b7a).val());
}
return vv.join(",");
},inputEvents:$.extend({},$.fn.combo.defaults.inputEvents,{blur:function(e){
var _b7b=e.data.target;
var opts=$(_b7b).tagbox("options");
if(opts.limitToList){
_b6b(_b7b);
}
}}),keyHandler:$.extend({},$.fn.combobox.defaults.keyHandler,{enter:function(e){
_b6b(this);
},query:function(q,e){
var opts=$(this).tagbox("options");
if(opts.limitToList){
$.fn.combobox.defaults.keyHandler.query.call(this,q,e);
}else{
$(this).combobox("hidePanel");
}
}}),tagFormatter:function(_b7c,row){
var opts=$(this).tagbox("options");
return row?row[opts.textField]:_b7c;
},tagStyler:function(_b7d,row){
return "";
},onClickTag:function(_b7e){
},onBeforeRemoveTag:function(_b7f){
},onRemoveTag:function(_b80){
}});
})(jQuery);
(function($){
function _b81(_b82){
var _b83=$.data(_b82,"datebox");
var opts=_b83.options;
$(_b82).addClass("datebox-f").combo($.extend({},opts,{onShowPanel:function(){
_b84(this);
_b85(this);
_b86(this);
_b94(this,$(this).datebox("getText"),true);
opts.onShowPanel.call(this);
}}));
if(!_b83.calendar){
var _b87=$(_b82).combo("panel").css("overflow","hidden");
_b87.panel("options").onBeforeDestroy=function(){
var c=$(this).find(".calendar-shared");
if(c.length){
c.insertBefore(c[0].pholder);
}
};
var cc=$("<div class=\"datebox-calendar-inner\"></div>").prependTo(_b87);
if(opts.sharedCalendar){
var c=$(opts.sharedCalendar);
if(!c[0].pholder){
c[0].pholder=$("<div class=\"calendar-pholder\" style=\"display:none\"></div>").insertAfter(c);
}
c.addClass("calendar-shared").appendTo(cc);
if(!c.hasClass("calendar")){
c.calendar();
}
_b83.calendar=c;
}else{
_b83.calendar=$("<div></div>").appendTo(cc).calendar();
}
$.extend(_b83.calendar.calendar("options"),{fit:true,border:false,onSelect:function(date){
var _b88=this.target;
var opts=$(_b88).datebox("options");
_b94(_b88,opts.formatter.call(_b88,date));
$(_b88).combo("hidePanel");
opts.onSelect.call(_b88,date);
}});
}
$(_b82).combo("textbox").parent().addClass("datebox");
$(_b82).datebox("initValue",opts.value);
function _b84(_b89){
var opts=$(_b89).datebox("options");
var _b8a=$(_b89).combo("panel");
_b8a.unbind(".datebox").bind("click.datebox",function(e){
if($(e.target).hasClass("datebox-button-a")){
var _b8b=parseInt($(e.target).attr("datebox-button-index"));
opts.buttons[_b8b].handler.call(e.target,_b89);
}
});
};
function _b85(_b8c){
var _b8d=$(_b8c).combo("panel");
if(_b8d.children("div.datebox-button").length){
return;
}
var _b8e=$("<div class=\"datebox-button\"><table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%\"><tr></tr></table></div>").appendTo(_b8d);
var tr=_b8e.find("tr");
for(var i=0;i<opts.buttons.length;i++){
var td=$("<td></td>").appendTo(tr);
var btn=opts.buttons[i];
var t=$("<a class=\"datebox-button-a\" href=\"javascript:;\"></a>").html($.isFunction(btn.text)?btn.text(_b8c):btn.text).appendTo(td);
t.attr("datebox-button-index",i);
}
tr.find("td").css("width",(100/opts.buttons.length)+"%");
};
function _b86(_b8f){
var _b90=$(_b8f).combo("panel");
var cc=_b90.children("div.datebox-calendar-inner");
_b90.children()._outerWidth(_b90.width());
_b83.calendar.appendTo(cc);
_b83.calendar[0].target=_b8f;
if(opts.panelHeight!="auto"){
var _b91=_b90.height();
_b90.children().not(cc).each(function(){
_b91-=$(this).outerHeight();
});
cc._outerHeight(_b91);
}
_b83.calendar.calendar("resize");
};
};
function _b92(_b93,q){
_b94(_b93,q,true);
};
function _b95(_b96){
var _b97=$.data(_b96,"datebox");
var opts=_b97.options;
var _b98=_b97.calendar.calendar("options").current;
if(_b98){
_b94(_b96,opts.formatter.call(_b96,_b98));
$(_b96).combo("hidePanel");
}
};
function _b94(_b99,_b9a,_b9b){
var _b9c=$.data(_b99,"datebox");
var opts=_b9c.options;
var _b9d=_b9c.calendar;
_b9d.calendar("moveTo",opts.parser.call(_b99,_b9a));
if(_b9b){
$(_b99).combo("setValue",_b9a);
}else{
if(_b9a){
_b9a=opts.formatter.call(_b99,_b9d.calendar("options").current);
}
$(_b99).combo("setText",_b9a).combo("setValue",_b9a);
}
};
$.fn.datebox=function(_b9e,_b9f){
if(typeof _b9e=="string"){
var _ba0=$.fn.datebox.methods[_b9e];
if(_ba0){
return _ba0(this,_b9f);
}else{
return this.combo(_b9e,_b9f);
}
}
_b9e=_b9e||{};
return this.each(function(){
var _ba1=$.data(this,"datebox");
if(_ba1){
$.extend(_ba1.options,_b9e);
}else{
$.data(this,"datebox",{options:$.extend({},$.fn.datebox.defaults,$.fn.datebox.parseOptions(this),_b9e)});
}
_b81(this);
});
};
$.fn.datebox.methods={options:function(jq){
var _ba2=jq.combo("options");
return $.extend($.data(jq[0],"datebox").options,{width:_ba2.width,height:_ba2.height,originalValue:_ba2.originalValue,disabled:_ba2.disabled,readonly:_ba2.readonly});
},cloneFrom:function(jq,from){
return jq.each(function(){
$(this).combo("cloneFrom",from);
$.data(this,"datebox",{options:$.extend(true,{},$(from).datebox("options")),calendar:$(from).datebox("calendar")});
$(this).addClass("datebox-f");
});
},calendar:function(jq){
return $.data(jq[0],"datebox").calendar;
},initValue:function(jq,_ba3){
return jq.each(function(){
var opts=$(this).datebox("options");
var _ba4=opts.value;
if(_ba4){
_ba4=opts.formatter.call(this,opts.parser.call(this,_ba4));
}
$(this).combo("initValue",_ba4).combo("setText",_ba4);
});
},setValue:function(jq,_ba5){
return jq.each(function(){
_b94(this,_ba5);
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).datebox("options");
$(this).datebox("setValue",opts.originalValue);
});
}};
$.fn.datebox.parseOptions=function(_ba6){
return $.extend({},$.fn.combo.parseOptions(_ba6),$.parser.parseOptions(_ba6,["sharedCalendar"]));
};
$.fn.datebox.defaults=$.extend({},$.fn.combo.defaults,{panelWidth:180,panelHeight:"auto",sharedCalendar:null,keyHandler:{up:function(e){
},down:function(e){
},left:function(e){
},right:function(e){
},enter:function(e){
_b95(this);
},query:function(q,e){
_b92(this,q);
}},currentText:"Today",closeText:"Close",okText:"Ok",buttons:[{text:function(_ba7){
return $(_ba7).datebox("options").currentText;
},handler:function(_ba8){
var now=new Date();
$(_ba8).datebox("calendar").calendar({year:now.getFullYear(),month:now.getMonth()+1,current:new Date(now.getFullYear(),now.getMonth(),now.getDate())});
_b95(_ba8);
}},{text:function(_ba9){
return $(_ba9).datebox("options").closeText;
},handler:function(_baa){
$(this).closest("div.combo-panel").panel("close");
}}],formatter:function(date){
var y=date.getFullYear();
var m=date.getMonth()+1;
var d=date.getDate();
return (m<10?("0"+m):m)+"/"+(d<10?("0"+d):d)+"/"+y;
},parser:function(s){
if(!s){
return new Date();
}
var ss=s.split("/");
var m=parseInt(ss[0],10);
var d=parseInt(ss[1],10);
var y=parseInt(ss[2],10);
if(!isNaN(y)&&!isNaN(m)&&!isNaN(d)){
return new Date(y,m-1,d);
}else{
return new Date();
}
},onSelect:function(date){
}});
})(jQuery);
(function($){
function _bab(_bac){
var _bad=$.data(_bac,"datetimebox");
var opts=_bad.options;
$(_bac).datebox($.extend({},opts,{onShowPanel:function(){
var _bae=$(this).datetimebox("getValue");
_bb4(this,_bae,true);
opts.onShowPanel.call(this);
},formatter:$.fn.datebox.defaults.formatter,parser:$.fn.datebox.defaults.parser}));
$(_bac).removeClass("datebox-f").addClass("datetimebox-f");
$(_bac).datebox("calendar").calendar({onSelect:function(date){
opts.onSelect.call(this.target,date);
}});
if(!_bad.spinner){
var _baf=$(_bac).datebox("panel");
var p=$("<div style=\"padding:2px\"><input></div>").insertAfter(_baf.children("div.datebox-calendar-inner"));
_bad.spinner=p.children("input");
}
_bad.spinner.timespinner({width:opts.spinnerWidth,showSeconds:opts.showSeconds,separator:opts.timeSeparator});
$(_bac).datetimebox("initValue",opts.value);
};
function _bb0(_bb1){
var c=$(_bb1).datetimebox("calendar");
var t=$(_bb1).datetimebox("spinner");
var date=c.calendar("options").current;
return new Date(date.getFullYear(),date.getMonth(),date.getDate(),t.timespinner("getHours"),t.timespinner("getMinutes"),t.timespinner("getSeconds"));
};
function _bb2(_bb3,q){
_bb4(_bb3,q,true);
};
function _bb5(_bb6){
var opts=$.data(_bb6,"datetimebox").options;
var date=_bb0(_bb6);
_bb4(_bb6,opts.formatter.call(_bb6,date));
$(_bb6).combo("hidePanel");
};
function _bb4(_bb7,_bb8,_bb9){
var opts=$.data(_bb7,"datetimebox").options;
$(_bb7).combo("setValue",_bb8);
if(!_bb9){
if(_bb8){
var date=opts.parser.call(_bb7,_bb8);
$(_bb7).combo("setText",opts.formatter.call(_bb7,date));
$(_bb7).combo("setValue",opts.formatter.call(_bb7,date));
}else{
$(_bb7).combo("setText",_bb8);
}
}
var date=opts.parser.call(_bb7,_bb8);
$(_bb7).datetimebox("calendar").calendar("moveTo",date);
$(_bb7).datetimebox("spinner").timespinner("setValue",_bba(date));
function _bba(date){
function _bbb(_bbc){
return (_bbc<10?"0":"")+_bbc;
};
var tt=[_bbb(date.getHours()),_bbb(date.getMinutes())];
if(opts.showSeconds){
tt.push(_bbb(date.getSeconds()));
}
return tt.join($(_bb7).datetimebox("spinner").timespinner("options").separator);
};
};
$.fn.datetimebox=function(_bbd,_bbe){
if(typeof _bbd=="string"){
var _bbf=$.fn.datetimebox.methods[_bbd];
if(_bbf){
return _bbf(this,_bbe);
}else{
return this.datebox(_bbd,_bbe);
}
}
_bbd=_bbd||{};
return this.each(function(){
var _bc0=$.data(this,"datetimebox");
if(_bc0){
$.extend(_bc0.options,_bbd);
}else{
$.data(this,"datetimebox",{options:$.extend({},$.fn.datetimebox.defaults,$.fn.datetimebox.parseOptions(this),_bbd)});
}
_bab(this);
});
};
$.fn.datetimebox.methods={options:function(jq){
var _bc1=jq.datebox("options");
return $.extend($.data(jq[0],"datetimebox").options,{originalValue:_bc1.originalValue,disabled:_bc1.disabled,readonly:_bc1.readonly});
},cloneFrom:function(jq,from){
return jq.each(function(){
$(this).datebox("cloneFrom",from);
$.data(this,"datetimebox",{options:$.extend(true,{},$(from).datetimebox("options")),spinner:$(from).datetimebox("spinner")});
$(this).removeClass("datebox-f").addClass("datetimebox-f");
});
},spinner:function(jq){
return $.data(jq[0],"datetimebox").spinner;
},initValue:function(jq,_bc2){
return jq.each(function(){
var opts=$(this).datetimebox("options");
var _bc3=opts.value;
if(_bc3){
_bc3=opts.formatter.call(this,opts.parser.call(this,_bc3));
}
$(this).combo("initValue",_bc3).combo("setText",_bc3);
});
},setValue:function(jq,_bc4){
return jq.each(function(){
_bb4(this,_bc4);
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).datetimebox("options");
$(this).datetimebox("setValue",opts.originalValue);
});
}};
$.fn.datetimebox.parseOptions=function(_bc5){
var t=$(_bc5);
return $.extend({},$.fn.datebox.parseOptions(_bc5),$.parser.parseOptions(_bc5,["timeSeparator","spinnerWidth",{showSeconds:"boolean"}]));
};
$.fn.datetimebox.defaults=$.extend({},$.fn.datebox.defaults,{spinnerWidth:"100%",showSeconds:true,timeSeparator:":",keyHandler:{up:function(e){
},down:function(e){
},left:function(e){
},right:function(e){
},enter:function(e){
_bb5(this);
},query:function(q,e){
_bb2(this,q);
}},buttons:[{text:function(_bc6){
return $(_bc6).datetimebox("options").currentText;
},handler:function(_bc7){
var opts=$(_bc7).datetimebox("options");
_bb4(_bc7,opts.formatter.call(_bc7,new Date()));
$(_bc7).datetimebox("hidePanel");
}},{text:function(_bc8){
return $(_bc8).datetimebox("options").okText;
},handler:function(_bc9){
_bb5(_bc9);
}},{text:function(_bca){
return $(_bca).datetimebox("options").closeText;
},handler:function(_bcb){
$(_bcb).datetimebox("hidePanel");
}}],formatter:function(date){
var h=date.getHours();
var M=date.getMinutes();
var s=date.getSeconds();
function _bcc(_bcd){
return (_bcd<10?"0":"")+_bcd;
};
var _bce=$(this).datetimebox("spinner").timespinner("options").separator;
var r=$.fn.datebox.defaults.formatter(date)+" "+_bcc(h)+_bce+_bcc(M);
if($(this).datetimebox("options").showSeconds){
r+=_bce+_bcc(s);
}
return r;
},parser:function(s){
if($.trim(s)==""){
return new Date();
}
var dt=s.split(" ");
var d=$.fn.datebox.defaults.parser(dt[0]);
if(dt.length<2){
return d;
}
var _bcf=$(this).datetimebox("spinner").timespinner("options").separator;
var tt=dt[1].split(_bcf);
var hour=parseInt(tt[0],10)||0;
var _bd0=parseInt(tt[1],10)||0;
var _bd1=parseInt(tt[2],10)||0;
return new Date(d.getFullYear(),d.getMonth(),d.getDate(),hour,_bd0,_bd1);
}});
})(jQuery);
(function($){
function init(_bd2){
var _bd3=$("<div class=\"slider\">"+"<div class=\"slider-inner\">"+"<a href=\"javascript:;\" class=\"slider-handle\"></a>"+"<span class=\"slider-tip\"></span>"+"</div>"+"<div class=\"slider-rule\"></div>"+"<div class=\"slider-rulelabel\"></div>"+"<div style=\"clear:both\"></div>"+"<input type=\"hidden\" class=\"slider-value\">"+"</div>").insertAfter(_bd2);
var t=$(_bd2);
t.addClass("slider-f").hide();
var name=t.attr("name");
if(name){
_bd3.find("input.slider-value").attr("name",name);
t.removeAttr("name").attr("sliderName",name);
}
_bd3.bind("_resize",function(e,_bd4){
if($(this).hasClass("easyui-fluid")||_bd4){
_bd5(_bd2);
}
return false;
});
return _bd3;
};
function _bd5(_bd6,_bd7){
var _bd8=$.data(_bd6,"slider");
var opts=_bd8.options;
var _bd9=_bd8.slider;
if(_bd7){
if(_bd7.width){
opts.width=_bd7.width;
}
if(_bd7.height){
opts.height=_bd7.height;
}
}
_bd9._size(opts);
if(opts.mode=="h"){
_bd9.css("height","");
_bd9.children("div").css("height","");
}else{
_bd9.css("width","");
_bd9.children("div").css("width","");
_bd9.children("div.slider-rule,div.slider-rulelabel,div.slider-inner")._outerHeight(_bd9._outerHeight());
}
_bda(_bd6);
};
function _bdb(_bdc){
var _bdd=$.data(_bdc,"slider");
var opts=_bdd.options;
var _bde=_bdd.slider;
var aa=opts.mode=="h"?opts.rule:opts.rule.slice(0).reverse();
if(opts.reversed){
aa=aa.slice(0).reverse();
}
_bdf(aa);
function _bdf(aa){
var rule=_bde.find("div.slider-rule");
var _be0=_bde.find("div.slider-rulelabel");
rule.empty();
_be0.empty();
for(var i=0;i<aa.length;i++){
var _be1=i*100/(aa.length-1)+"%";
var span=$("<span></span>").appendTo(rule);
span.css((opts.mode=="h"?"left":"top"),_be1);
if(aa[i]!="|"){
span=$("<span></span>").appendTo(_be0);
span.html(aa[i]);
if(opts.mode=="h"){
span.css({left:_be1,marginLeft:-Math.round(span.outerWidth()/2)});
}else{
span.css({top:_be1,marginTop:-Math.round(span.outerHeight()/2)});
}
}
}
};
};
function _be2(_be3){
var _be4=$.data(_be3,"slider");
var opts=_be4.options;
var _be5=_be4.slider;
_be5.removeClass("slider-h slider-v slider-disabled");
_be5.addClass(opts.mode=="h"?"slider-h":"slider-v");
_be5.addClass(opts.disabled?"slider-disabled":"");
var _be6=_be5.find(".slider-inner");
_be6.html("<a href=\"javascript:;\" class=\"slider-handle\"></a>"+"<span class=\"slider-tip\"></span>");
if(opts.range){
_be6.append("<a href=\"javascript:;\" class=\"slider-handle\"></a>"+"<span class=\"slider-tip\"></span>");
}
_be5.find("a.slider-handle").draggable({axis:opts.mode,cursor:"pointer",disabled:opts.disabled,onDrag:function(e){
var left=e.data.left;
var _be7=_be5.width();
if(opts.mode!="h"){
left=e.data.top;
_be7=_be5.height();
}
if(left<0||left>_be7){
return false;
}else{
_be8(left,this);
return false;
}
},onStartDrag:function(){
_be4.isDragging=true;
opts.onSlideStart.call(_be3,opts.value);
},onStopDrag:function(e){
_be8(opts.mode=="h"?e.data.left:e.data.top,this);
opts.onSlideEnd.call(_be3,opts.value);
opts.onComplete.call(_be3,opts.value);
_be4.isDragging=false;
}});
_be5.find("div.slider-inner").unbind(".slider").bind("mousedown.slider",function(e){
if(_be4.isDragging||opts.disabled){
return;
}
var pos=$(this).offset();
_be8(opts.mode=="h"?(e.pageX-pos.left):(e.pageY-pos.top));
opts.onComplete.call(_be3,opts.value);
});
function _be8(pos,_be9){
var _bea=_beb(_be3,pos);
var s=Math.abs(_bea%opts.step);
if(s<opts.step/2){
_bea-=s;
}else{
_bea=_bea-s+opts.step;
}
if(opts.range){
var v1=opts.value[0];
var v2=opts.value[1];
var m=parseFloat((v1+v2)/2);
if(_be9){
var _bec=$(_be9).nextAll(".slider-handle").length>0;
if(_bea<=v2&&_bec){
v1=_bea;
}else{
if(_bea>=v1&&(!_bec)){
v2=_bea;
}
}
}else{
if(_bea<v1){
v1=_bea;
}else{
if(_bea>v2){
v2=_bea;
}else{
_bea<m?v1=_bea:v2=_bea;
}
}
}
$(_be3).slider("setValues",[v1,v2]);
}else{
$(_be3).slider("setValue",_bea);
}
};
};
function _bed(_bee,_bef){
var _bf0=$.data(_bee,"slider");
var opts=_bf0.options;
var _bf1=_bf0.slider;
var _bf2=$.isArray(opts.value)?opts.value:[opts.value];
var _bf3=[];
if(!$.isArray(_bef)){
_bef=$.map(String(_bef).split(opts.separator),function(v){
return parseFloat(v);
});
}
_bf1.find(".slider-value").remove();
var name=$(_bee).attr("sliderName")||"";
for(var i=0;i<_bef.length;i++){
var _bf4=_bef[i];
if(_bf4<opts.min){
_bf4=opts.min;
}
if(_bf4>opts.max){
_bf4=opts.max;
}
var _bf5=$("<input type=\"hidden\" class=\"slider-value\">").appendTo(_bf1);
_bf5.attr("name",name);
_bf5.val(_bf4);
_bf3.push(_bf4);
var _bf6=_bf1.find(".slider-handle:eq("+i+")");
var tip=_bf6.next();
var pos=_bf7(_bee,_bf4);
if(opts.showTip){
tip.show();
tip.html(opts.tipFormatter.call(_bee,_bf4));
}else{
tip.hide();
}
if(opts.mode=="h"){
var _bf8="left:"+pos+"px;";
_bf6.attr("style",_bf8);
tip.attr("style",_bf8+"margin-left:"+(-Math.round(tip.outerWidth()/2))+"px");
}else{
var _bf8="top:"+pos+"px;";
_bf6.attr("style",_bf8);
tip.attr("style",_bf8+"margin-left:"+(-Math.round(tip.outerWidth()))+"px");
}
}
opts.value=opts.range?_bf3:_bf3[0];
$(_bee).val(opts.range?_bf3.join(opts.separator):_bf3[0]);
if(_bf2.join(",")!=_bf3.join(",")){
opts.onChange.call(_bee,opts.value,(opts.range?_bf2:_bf2[0]));
}
};
function _bda(_bf9){
var opts=$.data(_bf9,"slider").options;
var fn=opts.onChange;
opts.onChange=function(){
};
_bed(_bf9,opts.value);
opts.onChange=fn;
};
function _bf7(_bfa,_bfb){
var _bfc=$.data(_bfa,"slider");
var opts=_bfc.options;
var _bfd=_bfc.slider;
var size=opts.mode=="h"?_bfd.width():_bfd.height();
var pos=opts.converter.toPosition.call(_bfa,_bfb,size);
if(opts.mode=="v"){
pos=_bfd.height()-pos;
}
if(opts.reversed){
pos=size-pos;
}
return pos.toFixed(0);
};
function _beb(_bfe,pos){
var _bff=$.data(_bfe,"slider");
var opts=_bff.options;
var _c00=_bff.slider;
var size=opts.mode=="h"?_c00.width():_c00.height();
var pos=opts.mode=="h"?(opts.reversed?(size-pos):pos):(opts.reversed?pos:(size-pos));
var _c01=opts.converter.toValue.call(_bfe,pos,size);
return _c01.toFixed(0);
};
$.fn.slider=function(_c02,_c03){
if(typeof _c02=="string"){
return $.fn.slider.methods[_c02](this,_c03);
}
_c02=_c02||{};
return this.each(function(){
var _c04=$.data(this,"slider");
if(_c04){
$.extend(_c04.options,_c02);
}else{
_c04=$.data(this,"slider",{options:$.extend({},$.fn.slider.defaults,$.fn.slider.parseOptions(this),_c02),slider:init(this)});
$(this).removeAttr("disabled");
}
var opts=_c04.options;
opts.min=parseFloat(opts.min);
opts.max=parseFloat(opts.max);
if(opts.range){
if(!$.isArray(opts.value)){
opts.value=$.map(String(opts.value).split(opts.separator),function(v){
return parseFloat(v);
});
}
if(opts.value.length<2){
opts.value.push(opts.max);
}
}else{
opts.value=parseFloat(opts.value);
}
opts.step=parseFloat(opts.step);
opts.originalValue=opts.value;
_be2(this);
_bdb(this);
_bd5(this);
});
};
$.fn.slider.methods={options:function(jq){
return $.data(jq[0],"slider").options;
},destroy:function(jq){
return jq.each(function(){
$.data(this,"slider").slider.remove();
$(this).remove();
});
},resize:function(jq,_c05){
return jq.each(function(){
_bd5(this,_c05);
});
},getValue:function(jq){
return jq.slider("options").value;
},getValues:function(jq){
return jq.slider("options").value;
},setValue:function(jq,_c06){
return jq.each(function(){
_bed(this,[_c06]);
});
},setValues:function(jq,_c07){
return jq.each(function(){
_bed(this,_c07);
});
},clear:function(jq){
return jq.each(function(){
var opts=$(this).slider("options");
_bed(this,opts.range?[opts.min,opts.max]:[opts.min]);
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).slider("options");
$(this).slider(opts.range?"setValues":"setValue",opts.originalValue);
});
},enable:function(jq){
return jq.each(function(){
$.data(this,"slider").options.disabled=false;
_be2(this);
});
},disable:function(jq){
return jq.each(function(){
$.data(this,"slider").options.disabled=true;
_be2(this);
});
}};
$.fn.slider.parseOptions=function(_c08){
var t=$(_c08);
return $.extend({},$.parser.parseOptions(_c08,["width","height","mode",{reversed:"boolean",showTip:"boolean",range:"boolean",min:"number",max:"number",step:"number"}]),{value:(t.val()||undefined),disabled:(t.attr("disabled")?true:undefined),rule:(t.attr("rule")?eval(t.attr("rule")):undefined)});
};
$.fn.slider.defaults={width:"auto",height:"auto",mode:"h",reversed:false,showTip:false,disabled:false,range:false,value:0,separator:",",min:0,max:100,step:1,rule:[],tipFormatter:function(_c09){
return _c09;
},converter:{toPosition:function(_c0a,size){
var opts=$(this).slider("options");
return (_c0a-opts.min)/(opts.max-opts.min)*size;
},toValue:function(pos,size){
var opts=$(this).slider("options");
return opts.min+(opts.max-opts.min)*(pos/size);
}},onChange:function(_c0b,_c0c){
},onSlideStart:function(_c0d){
},onSlideEnd:function(_c0e){
},onComplete:function(_c0f){
}};
})(jQuery);


(function($){
  function getPluginName(target){
    if ($(target).data('treegrid')){
      return 'treegrid';
    } else {
      return 'datagrid';
    }
  }
  
  var autoSizeColumn1 = $.fn.datagrid.methods.autoSizeColumn;
  var loadDataMethod1 = $.fn.datagrid.methods.loadData;
  var appendMethod1 = $.fn.datagrid.methods.appendRow;
  var deleteMethod1 = $.fn.datagrid.methods.deleteRow;
  $.extend($.fn.datagrid.methods, {
    autoSizeColumn: function(jq, field){
      return jq.each(function(){
        var fc = $(this).datagrid('getPanel').find('.datagrid-header .datagrid-filter-c');
        fc.hide();
        autoSizeColumn1.call($.fn.datagrid.methods, $(this), field);
        fc.show();
        resizeFilter(this, field);
      });
    },
    loadData: function(jq, data){
      jq.each(function(){
        $.data(this, 'datagrid').filterSource = null;
      });
      return loadDataMethod1.call($.fn.datagrid.methods, jq, data);
    },
    appendRow: function(jq, row){
      var result = appendMethod1.call($.fn.datagrid.methods, jq, row);
      jq.each(function(){
        var state = $(this).data('datagrid');
        if (state.filterSource){
          state.filterSource.total++;
          if (state.filterSource.rows != state.data.rows){
            state.filterSource.rows.push(row);
          }
        }
      });
      return result;
    },
    deleteRow: function(jq, index){
      jq.each(function(){
        var state = $(this).data('datagrid');
        var opts = state.options;
        if (state.filterSource && opts.idField){
          if (state.filterSource.rows == state.data.rows){
            state.filterSource.total--;
          } else {
            for(var i=0; i<state.filterSource.rows.length; i++){
              var row = state.filterSource.rows[i];
              if (row[opts.idField] == state.data.rows[index][opts.idField]){
                state.filterSource.rows.splice(i,1);
                state.filterSource.total--;
                break;
              }
            }
          }
        }
      });
      return deleteMethod1.call($.fn.datagrid.methods, jq, index);
    }
  });
  
  var loadDataMethod2 = $.fn.treegrid.methods.loadData;
  var appendMethod2 = $.fn.treegrid.methods.append;
  var insertMethod2 = $.fn.treegrid.methods.insert;
  var removeMethod2 = $.fn.treegrid.methods.remove;
  $.extend($.fn.treegrid.methods, {
    loadData: function(jq, data){
      jq.each(function(){
        $.data(this, 'treegrid').filterSource = null;
      });
      return loadDataMethod2.call($.fn.treegrid.methods, jq, data);
    },
    append: function(jq, param){
      return jq.each(function(){
        var state = $(this).data('treegrid');
        var opts = state.options;
        if (opts.oldLoadFilter){
          var rows = translateTreeData(this, param.data, param.parent);
          state.filterSource.total += rows.length;
          state.filterSource.rows = state.filterSource.rows.concat(rows);
          $(this).treegrid('loadData', state.filterSource)
        } else {
          appendMethod2($(this), param);
        }
      });
    },
    insert: function(jq, param){
      return jq.each(function(){
        var state = $(this).data('treegrid');
        var opts = state.options;
        if (opts.oldLoadFilter){
          var ref = param.before || param.after;
          var index = getNodeIndex(param.before || param.after);
          var pid = index>=0 ? state.filterSource.rows[index]._parentId : null;
          var rows = translateTreeData(this, [param.data], pid);
          var newRows = state.filterSource.rows.splice(0, index>=0 ? (param.before ? index : index+1) : (state.filterSource.rows.length));
          newRows = newRows.concat(rows);
          newRows = newRows.concat(state.filterSource.rows);
          state.filterSource.total += rows.length;
          state.filterSource.rows = newRows;
          $(this).treegrid('loadData', state.filterSource);
          
          function getNodeIndex(id){
            var rows = state.filterSource.rows;
            for(var i=0; i<rows.length; i++){
              if (rows[i][opts.idField] == id){
                return i;
              }
            }
            return -1;
          }
        } else {
          insertMethod2($(this), param);
        }
      });
    },
    remove: function(jq, id){
      jq.each(function(){
        var state = $(this).data('treegrid');
        if (state.filterSource){
          var opts = state.options;
          var rows = state.filterSource.rows;
          for(var i=0; i<rows.length; i++){
            if (rows[i][opts.idField] == id){
              rows.splice(i, 1);
              state.filterSource.total--;
              break;
            }
          }
        }
      });
      return removeMethod2(jq, id);
    }
  });
  
  var extendedOptions = {
    filterMenuIconCls: 'icon-ok',
    filterBtnIconCls: 'icon-filter',
    filterBtnPosition: 'right',
    filterPosition: 'bottom',
    remoteFilter: false,
    showFilterBar: true,
    filterDelay: 400,
    filterRules: [],
    // specify whether the filtered records need to match ALL or ANY of the applied filters
    filterMatchingType: 'all',	// possible values: 'all','any'
    // filterCache: {},
    filterMatcher: function(data){
      var name = getPluginName(this);
      var dg = $(this);
      var state = $.data(this, name);
      var opts = state.options;
      if (opts.filterRules.length){
        var rows = [];
        if (name == 'treegrid'){
          var rr = {};
          $.map(data.rows, function(row){
            if (isMatch(row, row[opts.idField])){
              rr[row[opts.idField]] = row;
              row = getRow(data.rows, row._parentId);
              while(row){
                rr[row[opts.idField]] = row;
                row = getRow(data.rows, row._parentId);
              }
            }
          });
          for(var id in rr){
            rows.push(rr[id]);
          }
        } else {
          for(var i=0; i<data.rows.length; i++){
            var row = data.rows[i];
            if (isMatch(row, i)){
              rows.push(row);
            }
          }
        }
        data = {
          total: data.total - (data.rows.length - rows.length),
          rows: rows
        };
      }
      return data;
      
      function isMatch(row, index){
        var rules = opts.filterRules;
        if (!rules.length){return true;}
        for(var i=0; i<rules.length; i++){
          var rule = rules[i];
          var source = row[rule.field];
          var col = dg.datagrid('getColumnOption', rule.field);
          if (col && col.formatter){
            source = col.formatter(row[rule.field], row, index);
          }
          if (source == undefined){
            source = '';
          }
          var op = opts.operators[rule.op];
          // if (!op.isMatch(source, rule.value)){return false}
          var matched = op.isMatch(source, rule.value);
          if (opts.filterMatchingType == 'any'){
            if (matched){return true;}
          } else {
            if (!matched){return false;}
          }
        }
        return opts.filterMatchingType == 'all';
      }
      function getRow(rows, id){
        for(var i=0; i<rows.length; i++){
          var row = rows[i];
          if (row[opts.idField] == id){
            return row;
          }
        }
        return null;
      }
    },
    defaultFilterType: 'text',
    defaultFilterOperator: 'contains',
    defaultFilterOptions: {
      onInit: function(target){
        var name = getPluginName(target);
        var opts = $(target)[name]('options');
        var field = $(this).attr('name');
        var input = $(this);
        if (input.data('textbox')){
          input = input.textbox('textbox');
        }
        input.unbind('.filter').bind('keydown.filter', function(e){
          var t = $(this);
          if (this.timer){
            clearTimeout(this.timer);
          }
          if (e.keyCode == 13){
            _doFilter();
          } else {
            this.timer = setTimeout(function(){
              _doFilter();
            }, opts.filterDelay);
          }
        });
        function _doFilter(){
          var rule = $(target)[name]('getFilterRule', field);
          var value = input.val();
          if (value != ''){
            if ((rule && rule.value!=value) || !rule){
              $(target)[name]('addFilterRule', {
                field: field,
                op: opts.defaultFilterOperator,
                value: value
              });
              $(target)[name]('doFilter');
            }
          } else {
            if (rule){
              $(target)[name]('removeFilterRule', field);
              $(target)[name]('doFilter');
            }
          }
        }
      }
    },
    filterStringify: function(data){
      return JSON.stringify(data);
    },
    onClickMenu: function(item,button){}
  };
  $.extend($.fn.datagrid.defaults, extendedOptions);
  $.extend($.fn.treegrid.defaults, extendedOptions);
  
  // filter types
  $.fn.datagrid.defaults.filters = $.extend({}, $.fn.datagrid.defaults.editors, {
    label: {
      init: function(container, options){
        return $('<span></span>').appendTo(container);
      },
      getValue: function(target){
        return $(target).html();
      },
      setValue: function(target, value){
        $(target).html(value);
      },
      resize: function(target, width){
        $(target)._outerWidth(width)._outerHeight(22);
      }
    }
  });
  $.fn.treegrid.defaults.filters = $.fn.datagrid.defaults.filters;
  
  // filter operators
  $.fn.datagrid.defaults.operators = {
    nofilter: {
      text: 'No Filter'
    },
    contains: {
      text: 'Contains',
      isMatch: function(source, value){
        source = String(source);
        value = String(value);
        return source.toLowerCase().indexOf(value.toLowerCase()) >= 0;
      }
    },
    equal: {
      text: 'Equal',
      isMatch: function(source, value){
        return source == value;
      }
    },
    notequal: {
      text: 'Not Equal',
      isMatch: function(source, value){
        return source != value;
      }
    },
    beginwith: {
      text: 'Begin With',
      isMatch: function(source, value){
        source = String(source);
        value = String(value);
        return source.toLowerCase().indexOf(value.toLowerCase()) == 0;
      }
    },
    endwith: {
      text: 'End With',
      isMatch: function(source, value){
        source = String(source);
        value = String(value);
        return source.toLowerCase().indexOf(value.toLowerCase(), source.length - value.length) !== -1;
      }
    },
    less: {
      text: 'Less',
      isMatch: function(source, value){
        return source < value;
      }
    },
    lessorequal: {
      text: 'Less Or Equal',
      isMatch: function(source, value){
        return source <= value;
      }
    },
    greater: {
      text: 'Greater',
      isMatch: function(source, value){
        return source > value;
      }
    },
    greaterorequal: {
      text: 'Greater Or Equal',
      isMatch: function(source, value){
        return source >= value;
      }
    }
  };
  $.fn.treegrid.defaults.operators = $.fn.datagrid.defaults.operators;
  
  function resizeFilter(target, field){
    var toFixColumnSize = false;
    var dg = $(target);
    var header = dg.datagrid('getPanel').find('div.datagrid-header');
    var tr = header.find('.datagrid-header-row:not(.datagrid-filter-row)');
    var ff = field ? header.find('.datagrid-filter[name="'+field+'"]') : header.find('.datagrid-filter');
    ff.each(function(){
      var name = $(this).attr('name');
      var col = dg.datagrid('getColumnOption', name);
      var cc = $(this).closest('div.datagrid-filter-c');
      var btn = cc.find('a.datagrid-filter-btn');
      var cell = tr.find('td[field="'+name+'"] .datagrid-cell');
      var cellWidth = cell._outerWidth();
      if (cellWidth != _getContentWidth(cc)){
        this.filter.resize(this, cellWidth - btn._outerWidth());
      }
      if (cc.width() > col.boxWidth+col.deltaWidth-1){
        col.boxWidth = cc.width() - col.deltaWidth + 1;
        col.width = col.boxWidth + col.deltaWidth;
        toFixColumnSize = true;
      }
    });
    if (toFixColumnSize){
      $(target).datagrid('fixColumnSize');
    }
    
    function _getContentWidth(cc){
      var w = 0;
      $(cc).children(':visible').each(function(){
        w += $(this)._outerWidth();
      });
      return w;
    }
  }
  
  function getFilterComponent(target, field){
    var header = $(target).datagrid('getPanel').find('div.datagrid-header');
    return header.find('tr.datagrid-filter-row td[field="'+field+'"] .datagrid-filter');
  }
  
  /**
   * get filter rule index, return -1 if not found.
   */
  function getRuleIndex(target, field){
    var name = getPluginName(target);
    var rules = $(target)[name]('options').filterRules;
    for(var i=0; i<rules.length; i++){
      if (rules[i].field == field){
        return i;
      }
    }
    return -1;
  }
  
  function getFilterRule(target, field){
    var name = getPluginName(target);
    var rules = $(target)[name]('options').filterRules;
    var index = getRuleIndex(target, field);
    if (index >= 0){
      return rules[index];
    } else {
      return null;
    }
  }
  
  function addFilterRule(target, param){
    var name = getPluginName(target);
    var opts = $(target)[name]('options');
    var rules = opts.filterRules;
    
    if (param.op == 'nofilter'){
      removeFilterRule(target, param.field);
    } else {
      var index = getRuleIndex(target, param.field);
      if (index >= 0){
        $.extend(rules[index], param);
      } else {
        rules.push(param);
      }
    }
    
    var input = getFilterComponent(target, param.field);
    if (input.length){
      if (param.op != 'nofilter'){
        input[0].filter.setValue(input, param.value);
      }
      var menu = input[0].menu;
      if (menu){
        menu.find('.'+opts.filterMenuIconCls).removeClass(opts.filterMenuIconCls);
        var item = menu.menu('findItem', opts.operators[param.op]['text']);
        menu.menu('setIcon', {
          target: item.target,
          iconCls: opts.filterMenuIconCls
        });
      }
    }
  }
  
  function removeFilterRule(target, field){
    var name = getPluginName(target);
    var dg = $(target);
    var opts = dg[name]('options');
    if (field){
      var index = getRuleIndex(target, field);
      if (index >= 0){
        opts.filterRules.splice(index, 1);
      }
      _clear([field]);
    } else {
      opts.filterRules = [];
      var fields = dg.datagrid('getColumnFields',true).concat(dg.datagrid('getColumnFields'));
      _clear(fields);
    }
    
    function _clear(fields){
      for(var i=0; i<fields.length; i++){
        var input = getFilterComponent(target, fields[i]);
        if (input.length){
          input[0].filter.setValue(input, '');
          var menu = input[0].menu;
          if (menu){
            menu.find('.'+opts.filterMenuIconCls).removeClass(opts.filterMenuIconCls);
          }
        }
      }
    }
  }
  
  function doFilter(target){
    var name = getPluginName(target);
    var state = $.data(target, name);
    var opts = state.options;
    if (opts.remoteFilter){
      $(target)[name]('load');
    } else {
      if (opts.view.type == 'scrollview' && state.data.firstRows && state.data.firstRows.length){
        state.data.rows = state.data.firstRows;
      }
      $(target)[name]('getPager').pagination('refresh', {pageNumber:1});
      $(target)[name]('options').pageNumber = 1;
      $(target)[name]('loadData', state.filterSource || state.data);
    }
  }
  
  function translateTreeData(target, children, pid){
    var opts = $(target).treegrid('options');
    if (!children || !children.length){return []}
    var rows = [];
    $.map(children, function(item){
      item._parentId = pid;
      rows.push(item);
      rows = rows.concat(translateTreeData(target, item.children, item[opts.idField]));
    });
    $.map(rows, function(row){
      row.children = undefined;
    });
    return rows;
  }
  
  function myLoadFilter(data, parentId){
    var target = this;
    var name = getPluginName(target);
    var state = $.data(target, name);
    var opts = state.options;
    
    if (name == 'datagrid' && $.isArray(data)){
      data = {
        total: data.length,
        rows: data
      };
    } else if (name == 'treegrid' && $.isArray(data)){
      var rows = translateTreeData(target, data, parentId);
      data = {
        total: rows.length,
        rows: rows
      }
    }
    if (!opts.remoteFilter){
      if (!state.filterSource){
        state.filterSource = data;
      } else {
        if (!opts.isSorting) {
          if (name == 'datagrid'){
            state.filterSource = data;
          } else {
            state.filterSource.total += data.length;
            state.filterSource.rows = state.filterSource.rows.concat(data.rows);
            if (parentId){
              return opts.filterMatcher.call(target, data);
            }
          }
        } else {
          opts.isSorting = undefined;
        }
      }
      if (!opts.remoteSort && opts.sortName){
        var names = opts.sortName.split(',');
        var orders = opts.sortOrder.split(',');
        var dg = $(target);
        state.filterSource.rows.sort(function(r1,r2){
          var r = 0;
          for(var i=0; i<names.length; i++){
            var sn = names[i];
            var so = orders[i];
            var col = dg.datagrid('getColumnOption', sn);
            var sortFunc = col.sorter || function(a,b){
                    return a==b ? 0 : (a>b?1:-1);
                  };
            r = sortFunc(r1[sn], r2[sn]) * (so=='asc'?1:-1);
            if (r != 0){
              return r;
            }
          }
          return r;
        });
      }
      data = opts.filterMatcher.call(target, {
        total: state.filterSource.total,
        rows: state.filterSource.rows
      });
      
      if (opts.pagination){
        var dg = $(target);
        var pager = dg[name]('getPager');
        pager.pagination({
          onSelectPage:function(pageNum, pageSize){
            opts.pageNumber = pageNum;
            opts.pageSize = pageSize;
            pager.pagination('refresh',{
              pageNumber:pageNum,
              pageSize:pageSize
            });
            //dg.datagrid('loadData', state.filterSource);
            dg[name]('loadData', state.filterSource);
          },
          onBeforeRefresh:function(){
            dg[name]('reload');
            return false;
          }
        });
        if (name == 'datagrid'){
          var start = (opts.pageNumber-1)*parseInt(opts.pageSize);
          var end = start + parseInt(opts.pageSize);
          data.rows = data.rows.slice(start, end);
        } else {
          var topRows = [];
          var childRows = [];
          $.map(data.rows, function(row){
            row._parentId ? childRows.push(row) : topRows.push(row);
          });
          data.total = topRows.length;
          var start = (opts.pageNumber-1)*parseInt(opts.pageSize);
          var end = start + parseInt(opts.pageSize);
          data.rows = topRows.slice(start, end).concat(childRows);
        }
      }
      $.map(data.rows, function(row){
        row.children = undefined;
      });
    }
    return data;
  }
  
  function init(target, filters){
    filters = filters || [];
    var name = getPluginName(target);
    var state = $.data(target, name);
    var opts = state.options;
    if (!opts.filterRules.length){
      opts.filterRules = [];
    }
    opts.filterCache = opts.filterCache || {};
    var dgOpts = $.data(target, 'datagrid').options;
    
    var onResize = dgOpts.onResize;
    dgOpts.onResize = function(width,height){
      resizeFilter(target);
      onResize.call(this, width, height);
    }
    var onBeforeSortColumn = dgOpts.onBeforeSortColumn;
    dgOpts.onBeforeSortColumn = function(sort, order){
      var result = onBeforeSortColumn.call(this, sort, order);
      if (result != false){
        opts.isSorting = true;
      }
      return result;
    };
    
    var onResizeColumn = opts.onResizeColumn;
    opts.onResizeColumn = function(field,width){
      var fc = $(this).datagrid('getPanel').find('.datagrid-header .datagrid-filter-c');
      fc.hide();
      $(target).datagrid('fitColumns');
      if (opts.fitColumns){
        resizeFilter(target);
      } else {
        resizeFilter(target, field);
      }
      fc.show();
      onResizeColumn.call(target, field, width);
    };
    var onBeforeLoad = opts.onBeforeLoad;
    opts.onBeforeLoad = function(param1, param2){
      if (param1){
        param1.filterRules = opts.filterStringify(opts.filterRules);
      }
      if (param2){
        param2.filterRules = opts.filterStringify(opts.filterRules);
      }
      var result = onBeforeLoad.call(this, param1, param2);
      if (result != false && opts.url){
        if (name == 'datagrid'){
          state.filterSource = null;
        } else if (name == 'treegrid' && state.filterSource){
          if (param1){
            var id = param1[opts.idField];	// the id of the expanding row
            var rows = state.filterSource.rows || [];
            for(var i=0; i<rows.length; i++){
              if (id == rows[i]._parentId){	// the expanding row has children
                return false;
              }
            }
          } else {
            state.filterSource = null;
          }
        }
      }
      return result;
    };
    
    // opts.loadFilter = myLoadFilter;
    opts.loadFilter = function(data, parentId){
      var d = opts.oldLoadFilter.call(this, data, parentId);
      return myLoadFilter.call(this, d, parentId);
    };
    
    initCss();
    createFilter(true);
    createFilter();
    if (opts.fitColumns){
      setTimeout(function(){
        resizeFilter(target);
      }, 0);
    }
    
    $.map(opts.filterRules, function(rule){
      addFilterRule(target, rule);
    });
    
    function initCss(){
      if (!$('#datagrid-filter-style').length){
        $('head').append(
              '<style id="datagrid-filter-style">' +
              'a.datagrid-filter-btn{display:inline-block;width:22px;height:22px;margin:0;vertical-align:top;cursor:pointer;opacity:0.6;filter:alpha(opacity=60);}' +
              'a:hover.datagrid-filter-btn{opacity:1;filter:alpha(opacity=100);}' +
              '.datagrid-filter-row .textbox,.datagrid-filter-row .textbox .textbox-text{-moz-border-radius:0;-webkit-border-radius:0;border-radius:0;}' +
              '.datagrid-filter-row input{margin:0;-moz-border-radius:0;-webkit-border-radius:0;border-radius:0;}' +
              '.datagrid-filter-cache{position:absolute;width:10px;height:10px;left:-99999px;}' +
              '</style>'
        );
      }
    }
    
    /**
     * create filter component
     */
    function createFilter(frozen){
      var dc = state.dc;
      var fields = $(target).datagrid('getColumnFields', frozen);
      if (frozen && opts.rownumbers){
        fields.unshift('_');
      }
      var table = (frozen?dc.header1:dc.header2).find('table.datagrid-htable');
      
      // clear the old filter component
      table.find('.datagrid-filter').each(function(){
        if (this.filter.destroy){
          this.filter.destroy(this);
        }
        if (this.menu){
          $(this.menu).menu('destroy');
        }
      });
      table.find('tr.datagrid-filter-row').remove();
      
      var tr = $('<tr class="datagrid-header-row datagrid-filter-row"></tr>');
      if (opts.filterPosition == 'bottom'){
        tr.appendTo(table.find('tbody'));
      } else {
        tr.prependTo(table.find('tbody'));
      }
      if (!opts.showFilterBar){
        tr.hide();
      }
      
      for(var i=0; i<fields.length; i++){
        var field = fields[i];
        var col = $(target).datagrid('getColumnOption', field);
        var td = $('<td></td>').attr('field', field).appendTo(tr);
        if (col && col.hidden){
          td.hide();
        }
        if (field == '_'){
          continue;
        }
        if (col && (col.checkbox || col.expander)){
          continue;
        }
        
        var fopts = getFilter(field);
        if (fopts){
          $(target)[name]('destroyFilter', field);	// destroy the old filter component
        } else {
          fopts = $.extend({}, {
            field: field,
            type: opts.defaultFilterType,
            options: opts.defaultFilterOptions
          });
        }
        
        var div = opts.filterCache[field];
        if (!div){
          div = $('<div class="datagrid-filter-c"></div>').appendTo(td);
          var filter = opts.filters[fopts.type];
          var input = filter.init(div, fopts.options||{});
          input.addClass('datagrid-filter').attr('name', field);
          input[0].filter = filter;
          input[0].menu = createFilterButton(div, fopts.op);
          if (fopts.options){
            if (fopts.options.onInit){
              fopts.options.onInit.call(input[0], target);
            }
          } else {
            opts.defaultFilterOptions.onInit.call(input[0], target);
          }
          opts.filterCache[field] = div;
          resizeFilter(target, field);
        } else {
          div.appendTo(td);
        }
      }
    }
    
    function createFilterButton(container, operators){
      if (!operators){return null;}
      
      var btn = $('<a class="datagrid-filter-btn">&nbsp;</a>').addClass(opts.filterBtnIconCls);
      if (opts.filterBtnPosition == 'right'){
        btn.appendTo(container);
      } else {
        btn.prependTo(container);
      }
      
      var menu = $('<div></div>').appendTo('body');
      $.map(['nofilter'].concat(operators), function(item){
        var op = opts.operators[item];
        if (op){
          $('<div></div>').attr('name', item).html(op.text).appendTo(menu);
        }
      });
      menu.menu({
        alignTo:btn,
        onClick:function(item){
          var btn = $(this).menu('options').alignTo;
          var td = btn.closest('td[field]');
          var field = td.attr('field');
          var input = td.find('.datagrid-filter');
          var value = input[0].filter.getValue(input);
          
          if (opts.onClickMenu.call(target, item, btn, field) == false){
            return;
          }
          
          addFilterRule(target, {
            field: field,
            op: item.name,
            value: value
          });
          
          doFilter(target);
        }
      });
      
      btn[0].menu = menu;
      btn.bind('click', {menu:menu}, function(e){
        $(this.menu).menu('show');
        return false;
      });
      return menu;
    }
    
    function getFilter(field){
      for(var i=0; i<filters.length; i++){
        var filter = filters[i];
        if (filter.field == field){
          return filter;
        }
      }
      return null;
    }
  }
  
  $.extend($.fn.datagrid.methods, {
    enableFilter: function(jq, filters){
      return jq.each(function(){
        var name = getPluginName(this);
        var opts = $.data(this, name).options;
        if (opts.oldLoadFilter){
          if (filters){
            $(this)[name]('disableFilter');
          } else {
            return;
          }
        }
        opts.oldLoadFilter = opts.loadFilter;
        init(this, filters);
        $(this)[name]('resize');
        if (opts.filterRules.length){
          if (opts.remoteFilter){
            doFilter(this);
          } else if (opts.data){
            doFilter(this);
          }
        }
      });
    },
    disableFilter: function(jq){
      return jq.each(function(){
        var name = getPluginName(this);
        var state = $.data(this, name);
        var opts = state.options;
        var dc = $(this).data('datagrid').dc;
        var div = dc.view.children('.datagrid-filter-cache');
        if (!div.length){
          div = $('<div class="datagrid-filter-cache"></div>').appendTo(dc.view);
        }
        for(var field in opts.filterCache){
          $(opts.filterCache[field]).appendTo(div);
        }
        var data = state.data;
        if (state.filterSource){
          data = state.filterSource;
          $.map(data.rows, function(row){
            row.children = undefined;
          });
        }
        $(this)[name]({
          data: data,
          loadFilter: (opts.oldLoadFilter||undefined),
          oldLoadFilter: null
        });
      });
    },
    destroyFilter: function(jq, field){
      return jq.each(function(){
        var name = getPluginName(this);
        var state = $.data(this, name);
        var opts = state.options;
        if (field){
          _destroy(field);
        } else {
          for(var f in opts.filterCache){
            _destroy(f);
          }
          $(this).datagrid('getPanel').find('.datagrid-header .datagrid-filter-row').remove();
          $(this).data('datagrid').dc.view.children('.datagrid-filter-cache').remove();
          opts.filterCache = {};
          $(this)[name]('resize');
          $(this)[name]('disableFilter');
        }
        
        function _destroy(field){
          var c = $(opts.filterCache[field]);
          var input = c.find('.datagrid-filter');
          if (input.length){
            var filter = input[0].filter;
            if (filter.destroy){
              filter.destroy(input[0]);
            }
          }
          c.find('.datagrid-filter-btn').each(function(){
            $(this.menu).menu('destroy');
          });
          c.remove();
          opts.filterCache[field] = undefined;
        }
      });
    },
    getFilterRule: function(jq, field){
      return getFilterRule(jq[0], field);
    },
    addFilterRule: function(jq, param){
      return jq.each(function(){
        addFilterRule(this, param);
      });
    },
    removeFilterRule: function(jq, field){
      return jq.each(function(){
        removeFilterRule(this, field);
      });
    },
    doFilter: function(jq){
      return jq.each(function(){
        doFilter(this);
      });
    },
    getFilterComponent: function(jq, field){
      return getFilterComponent(jq[0], field);
    },
    resizeFilter: function(jq, field){
      return jq.each(function(){
        resizeFilter(this, field);
      });
    }
  });
})(jQuery);

(function($){
	$.extend($.fn.treegrid.defaults, {
		dropAccept:'tr[node-id]',
		onBeforeDrag: function(row){},	// return false to deny drag
		onStartDrag: function(row){},
		onStopDrag: function(row){},
		onDragEnter: function(targetRow, sourceRow){},	// return false to deny drop
		onDragOver: function(targetRow, sourceRow){},	// return false to deny drop
		onDragLeave: function(targetRow, sourceRow){},
		onBeforeDrop: function(targetRow, sourceRow, point){},
		onDrop: function(targetRow, sourceRow, point){},	// point:'append','top','bottom'
	});
	
	$.extend($.fn.treegrid.methods, {
		resetDnd: function(jq){
			return jq.each(function(){
				var state = $.data(this, 'treegrid');
				var opts = state.options;
				var row = $(this).treegrid('find', state.draggingNodeId);
				if (row){
					var tr = opts.finder.getTr(this, row[opts.idField]);
					tr.each(function(){
						var target = this;
						$(target).data('draggable').droppables = $('.droppable:visible').filter(function(){
							return target != this;
						}).filter(function(){
							var accept = $.data(this, 'droppable').options.accept;
							if (accept){
								return $(accept).filter(function(){
									return this == target;
								}).length > 0;
							} else {
								return true;
							}
						});
					});
				}
			});
		},
		enableDnd: function(jq, id){
			if (!$('#treegrid-dnd-style').length){
				$('head').append(
						'<style id="treegrid-dnd-style">' +
						'.treegrid-row-top td{border-top:1px solid red}' +
						'.treegrid-row-bottom td{border-bottom:1px solid red}' +
						'.treegrid-row-append .tree-title{border:1px solid red}' +
						'</style>'
				);
			}
			return jq.each(function(){
				var target = this;
				var state = $.data(this, 'treegrid');
				if (!state.disabledNodes){
					state.disabledNodes = [];					
				}
				var t = $(this);
				var opts = state.options;
				if (id){
					var nodes = opts.finder.getTr(target, id);
					var rows = t.treegrid('getChildren', id);
					for(var i=0; i<rows.length; i++){
						nodes = nodes.add(opts.finder.getTr(target, rows[i][opts.idField]));
					}
				} else {
					var nodes = t.treegrid('getPanel').find('tr[node-id]');
				}
				nodes.draggable({
					disabled:false,
					revert:true,
					cursor:'pointer',
					proxy: function(source){
						var row = t.treegrid('find', $(source).attr('node-id'));
						var p = $('<div class="tree-node-proxy"></div>').appendTo('body');
						p.html('<span class="tree-dnd-icon tree-dnd-no">&nbsp;</span>'+row[opts.treeField]);
						p.hide();
						return p;
					},
					deltaX: 15,
					deltaY: 15,
					onBeforeDrag:function(e){
						if (opts.onBeforeDrag.call(target, getRow(this)) == false){return false}
						if ($(e.target).hasClass('tree-hit') || $(e.target).parent().hasClass('datagrid-cell-check')){return false;}
						if (e.which != 1){return false;}
					},
					onStartDrag:function(){
						$(this).draggable('proxy').css({
							left:-10000,
							top:-10000
						});
						var row = getRow(this);
						state.draggingNodeId = row[opts.idField];
						setValid(state.draggingNodeId, false);
						opts.onStartDrag.call(target, row);
					},
					onDrag:function(e){
						var x1=e.pageX,y1=e.pageY,x2=e.data.startX,y2=e.data.startY;
						var d = Math.sqrt((x1-x2)*(x1-x2)+(y1-y2)*(y1-y2));
						if (d>3){	// when drag a little distance, show the proxy object
							$(this).draggable('proxy').show();
							var tr = opts.finder.getTr(target, $(this).attr('node-id'));
							var treeTitle = tr.find('span.tree-title');
							e.data.startX = treeTitle.offset().left;
							e.data.startY = treeTitle.offset().top;
							e.data.offsetWidth = 0;
							e.data.offsetHeight = 0;
						}
						this.pageY = e.pageY;
					},
					onStopDrag:function(){
						setValid(state.draggingNodeId, true);
						for(var i=0; i<state.disabledNodes.length; i++){
							var tr = opts.finder.getTr(target, state.disabledNodes[i]);
							tr.droppable('enable');
						}
						state.disabledNodes = [];
						var row = t.treegrid('find', state.draggingNodeId);
						state.draggingNodeId = undefined;
						opts.onStopDrag.call(target, row);
					}
				});
				var view = $(target).data('datagrid').dc.view;
				view.add(nodes).droppable({
					accept:opts.dropAccept,
					onDragEnter: function(e, source){
						var nodeId = $(this).attr('node-id');
						var dTarget = getGridTarget(this);
						var dOpts = $(dTarget).treegrid('options');
						var tr = dOpts.finder.getTr(dTarget, null, 'highlight');
						var sRow = getRow(source);
						var dRow = getRow(this);
						if (tr.length && dRow){
							cb();
						}

						function cb(){
							if (opts.onDragEnter.call(target, dRow, sRow) == false){
								allowDrop(source, false);
								tr.removeClass('treegrid-row-append treegrid-row-top treegrid-row-bottom');
								tr.droppable('disable');
								state.disabledNodes.push(nodeId);
							}
						}
					},
					onDragOver:function(e,source){
						var nodeId = $(this).attr('node-id');
						if ($.inArray(nodeId, state.disabledNodes) >= 0){return;}
						var dTarget = getGridTarget(this);
						var dOpts = $(dTarget).treegrid('options');
						var tr = dOpts.finder.getTr(dTarget, null, 'highlight');
						if (tr.length){
							if (!isValid(tr)){
								allowDrop(source, false);
								return;
							}
						}
						allowDrop(source, true);
						var sRow = getRow(source);
						var dRow = getRow(this);
						if (tr.length){
							var pageY = source.pageY;
							var top = tr.offset().top;
							var bottom = top + tr.outerHeight();
							tr.removeClass('treegrid-row-append treegrid-row-top treegrid-row-bottom');
							if (pageY > top + (bottom - top) / 2){
								if (bottom - pageY < 5){
									tr.addClass('treegrid-row-bottom');
								} else {
									tr.addClass('treegrid-row-append');
								}
							} else {
								if (pageY - top < 5){
									tr.addClass('treegrid-row-top');
								} else {
									tr.addClass('treegrid-row-append');
								}
							}
							if (dRow){
								cb();
							}
						}

						function cb(){
							if (opts.onDragOver.call(target, dRow, sRow) == false){
								allowDrop(source, false);
								tr.removeClass('treegrid-row-append treegrid-row-top treegrid-row-bottom');
								tr.droppable('disable');
								state.disabledNodes.push(nodeId);
							}
						}
					},
					onDragLeave:function(e,source){
						allowDrop(source, false);
						var dTarget = getGridTarget(this);
						var dOpts = $(dTarget).treegrid('options');
						var sRow = getRow(source);
						var dRow = getRow(this);
						var tr = dOpts.finder.getTr(dTarget, $(this).attr('node-id'));
						tr.removeClass('treegrid-row-append treegrid-row-top treegrid-row-bottom');
						if (dRow){
							opts.onDragLeave.call(target, dRow, sRow);
						}
					},
					onDrop:function(e,source){
						var point = 'append';
						var dRow = null;
						var sRow = getRow(source);
						var sTarget = getGridTarget(source);
						var dTarget = getGridTarget(this);
						var dOpts = $(dTarget).treegrid('options');
						var tr = dOpts.finder.getTr(dTarget, null, 'highlight');
						if (tr.length){
							if (!isValid(tr)){
								return;
							}
							dRow = getRow(tr);
							if (tr.hasClass('treegrid-row-append')){
								point = 'append';
							} else {
								point = tr.hasClass('treegrid-row-top') ? 'top' : 'bottom';
							}
							tr.removeClass('treegrid-row-append treegrid-row-top treegrid-row-bottom');
						}
						if (opts.onBeforeDrop.call(target, dRow, sRow, point) == false){
							return;
						}
						insert.call(this);
						opts.onDrop.call(target, dRow, sRow, point);

						function insert(){
							var data = $(sTarget).treegrid('pop', sRow[opts.idField]);
							if (point == 'append'){
								if (dRow){
									$(dTarget).treegrid('append', {
										parent: dRow[opts.idField],
										data: [data]
									});
									if (dRow.state == 'closed'){
										$(dTarget).treegrid('expand', dRow[opts.idField]);
									}
								} else {
									$(dTarget).treegrid('append', {parent:null, data:[data]});
								}
								$(dTarget).treegrid('enableDnd', sRow[opts.idField]);
							} else {
								var param = {data:data};
								if (point == 'top'){
									param.before = dRow[opts.idField];
								} else {
									param.after = dRow[opts.idField];
								}
								$(dTarget).treegrid('insert', param);
								$(dTarget).treegrid('enableDnd', sRow[opts.idField]);
							}
						}
					}
				});
				
				function allowDrop(source, allowed){
					var icon = $(source).draggable('proxy').find('span.tree-dnd-icon');
					icon.removeClass('tree-dnd-yes tree-dnd-no').addClass(allowed ? 'tree-dnd-yes' : 'tree-dnd-no');
				}
				function getRow(tr){
					var target = getGridTarget(tr);
					var nodeId = $(tr).attr('node-id');
					return $(target).treegrid('find', nodeId);
				}

				function getGridTarget(el){
					return $(el).closest('div.datagrid-view').children('table')[0];
				}
				function isValid(tr){
					var opts = $(tr).droppable('options');
					if (opts.disabled || opts.accept == 'no-accept'){
						return false;
					} else {
						return true;
					}
				}
				function setValid(id, valid){
					var accept = valid ? opts.dropAccept : 'no-accept';
					var tr = opts.finder.getTr(target, id);
					tr.droppable({accept:accept});
					tr.next('tr.treegrid-tr-tree').find('tr[node-id]').droppable({accept:accept});
				}
			});
		}
	});
})(jQuery);

/**
 * bootbox.js v4.4.0
 *
 * http://bootboxjs.com/license.txt
 */
!function(a,b){"use strict";"function"==typeof define&&define.amd?define(["jquery"],b):"object"==typeof exports?module.exports=b(require("jquery")):a.bootbox=b(a.jQuery)}(this,function a(b,c){"use strict";function d(a){var b=q[o.locale];return b?b[a]:q.en[a]}function e(a,c,d){a.stopPropagation(),a.preventDefault();var e=b.isFunction(d)&&d.call(c,a)===!1;e||c.modal("hide")}function f(a){var b,c=0;for(b in a)c++;return c}function g(a,c){var d=0;b.each(a,function(a,b){c(a,b,d++)})}function h(a){var c,d;if("object"!=typeof a)throw new Error("Please supply an object of options");if(!a.message)throw new Error("Please specify a message");return a=b.extend({},o,a),a.buttons||(a.buttons={}),c=a.buttons,d=f(c),g(c,function(a,e,f){if(b.isFunction(e)&&(e=c[a]={callback:e}),"object"!==b.type(e))throw new Error("button with key "+a+" must be an object");e.label||(e.label=a),e.className||(e.className=2>=d&&f===d-1?"btn-primary":"btn-default")}),a}function i(a,b){var c=a.length,d={};if(1>c||c>2)throw new Error("Invalid argument length");return 2===c||"string"==typeof a[0]?(d[b[0]]=a[0],d[b[1]]=a[1]):d=a[0],d}function j(a,c,d){return b.extend(!0,{},a,i(c,d))}function k(a,b,c,d){var e={className:"bootbox-"+a,buttons:l.apply(null,b)};return m(j(e,d,c),b)}function l(){for(var a={},b=0,c=arguments.length;c>b;b++){var e=arguments[b],f=e.toLowerCase(),g=e.toUpperCase();a[f]={label:d(g)}}return a}function m(a,b){var d={};return g(b,function(a,b){d[b]=!0}),g(a.buttons,function(a){if(d[a]===c)throw new Error("button key "+a+" is not allowed (options are "+b.join("\n")+")")}),a}var n={dialog:"<div class='bootbox modal' tabindex='-1' role='dialog'><div class='modal-dialog'><div class='modal-content'><div class='modal-body'><div class='bootbox-body'></div></div></div></div></div>",header:"<div class='modal-header'><h4 class='modal-title'></h4></div>",footer:"<div class='modal-footer'></div>",closeButton:"<button type='button' class='bootbox-close-button close' data-dismiss='modal' aria-hidden='true'>&times;</button>",form:"<form class='bootbox-form'></form>",inputs:{text:"<input class='bootbox-input bootbox-input-text form-control' autocomplete=off type=text />",textarea:"<textarea class='bootbox-input bootbox-input-textarea form-control'></textarea>",email:"<input class='bootbox-input bootbox-input-email form-control' autocomplete='off' type='email' />",select:"<select class='bootbox-input bootbox-input-select form-control'></select>",checkbox:"<div class='checkbox'><label><input class='bootbox-input bootbox-input-checkbox' type='checkbox' /></label></div>",date:"<input class='bootbox-input bootbox-input-date form-control' autocomplete=off type='date' />",time:"<input class='bootbox-input bootbox-input-time form-control' autocomplete=off type='time' />",number:"<input class='bootbox-input bootbox-input-number form-control' autocomplete=off type='number' />",password:"<input class='bootbox-input bootbox-input-password form-control' autocomplete='off' type='password' />"}},o={locale:"en",backdrop:"static",animate:!0,className:null,closeButton:!0,show:!0,container:"body"},p={};p.alert=function(){var a;if(a=k("alert",["ok"],["message","callback"],arguments),a.callback&&!b.isFunction(a.callback))throw new Error("alert requires callback property to be a function when provided");return a.buttons.ok.callback=a.onEscape=function(){return b.isFunction(a.callback)?a.callback.call(this):!0},p.dialog(a)},p.confirm=function(){var a;if(a=k("confirm",["cancel","confirm"],["message","callback"],arguments),a.buttons.cancel.callback=a.onEscape=function(){return a.callback.call(this,!1)},a.buttons.confirm.callback=function(){return a.callback.call(this,!0)},!b.isFunction(a.callback))throw new Error("confirm requires a callback");return p.dialog(a)},p.prompt=function(){var a,d,e,f,h,i,k;if(f=b(n.form),d={className:"bootbox-prompt",buttons:l("cancel","confirm"),value:"",inputType:"text"},a=m(j(d,arguments,["title","callback"]),["cancel","confirm"]),i=a.show===c?!0:a.show,a.message=f,a.buttons.cancel.callback=a.onEscape=function(){return a.callback.call(this,null)},a.buttons.confirm.callback=function(){var c;switch(a.inputType){case"text":case"textarea":case"email":case"select":case"date":case"time":case"number":case"password":c=h.val();break;case"checkbox":var d=h.find("input:checked");c=[],g(d,function(a,d){c.push(b(d).val())})}return a.callback.call(this,c)},a.show=!1,!a.title)throw new Error("prompt requires a title");if(!b.isFunction(a.callback))throw new Error("prompt requires a callback");if(!n.inputs[a.inputType])throw new Error("invalid prompt type");switch(h=b(n.inputs[a.inputType]),a.inputType){case"text":case"textarea":case"email":case"date":case"time":case"number":case"password":h.val(a.value);break;case"select":var o={};if(k=a.inputOptions||[],!b.isArray(k))throw new Error("Please pass an array of input options");if(!k.length)throw new Error("prompt with select requires options");g(k,function(a,d){var e=h;if(d.value===c||d.text===c)throw new Error("given options in wrong format");d.group&&(o[d.group]||(o[d.group]=b("<optgroup/>").attr("label",d.group)),e=o[d.group]),e.append("<option value='"+d.value+"'>"+d.text+"</option>")}),g(o,function(a,b){h.append(b)}),h.val(a.value);break;case"checkbox":var q=b.isArray(a.value)?a.value:[a.value];if(k=a.inputOptions||[],!k.length)throw new Error("prompt with checkbox requires options");if(!k[0].value||!k[0].text)throw new Error("given options in wrong format");h=b("<div/>"),g(k,function(c,d){var e=b(n.inputs[a.inputType]);e.find("input").attr("value",d.value),e.find("label").append(d.text),g(q,function(a,b){b===d.value&&e.find("input").prop("checked",!0)}),h.append(e)})}return a.placeholder&&h.attr("placeholder",a.placeholder),a.pattern&&h.attr("pattern",a.pattern),a.maxlength&&h.attr("maxlength",a.maxlength),f.append(h),f.on("submit",function(a){a.preventDefault(),a.stopPropagation(),e.find(".btn-primary").click()}),e=p.dialog(a),e.off("shown.bs.modal"),e.on("shown.bs.modal",function(){h.focus()}),i===!0&&e.modal("show"),e},p.dialog=function(a){a=h(a);var d=b(n.dialog),f=d.find(".modal-dialog"),i=d.find(".modal-body"),j=a.buttons,k="",l={onEscape:a.onEscape};if(b.fn.modal===c)throw new Error("$.fn.modal is not defined; please double check you have included the Bootstrap JavaScript library. See http://getbootstrap.com/javascript/ for more details.");if(g(j,function(a,b){k+="<button data-bb-handler='"+a+"' type='button' class='btn "+b.className+"'>"+b.label+"</button>",l[a]=b.callback}),i.find(".bootbox-body").html(a.message),a.animate===!0&&d.addClass("fade"),a.className&&d.addClass(a.className),"large"===a.size?f.addClass("modal-lg"):"small"===a.size&&f.addClass("modal-sm"),a.title&&i.before(n.header),a.closeButton){var m=b(n.closeButton);a.title?d.find(".modal-header").prepend(m):m.css("margin-top","-10px").prependTo(i)}return a.title&&d.find(".modal-title").html(a.title),k.length&&(i.after(n.footer),d.find(".modal-footer").html(k)),d.on("hidden.bs.modal",function(a){a.target===this&&d.remove()}),d.on("shown.bs.modal",function(){d.find(".btn-primary:first").focus()}),"static"!==a.backdrop&&d.on("click.dismiss.bs.modal",function(a){d.children(".modal-backdrop").length&&(a.currentTarget=d.children(".modal-backdrop").get(0)),a.target===a.currentTarget&&d.trigger("escape.close.bb")}),d.on("escape.close.bb",function(a){l.onEscape&&e(a,d,l.onEscape)}),d.on("click",".modal-footer button",function(a){var c=b(this).data("bb-handler");e(a,d,l[c])}),d.on("click",".bootbox-close-button",function(a){e(a,d,l.onEscape)}),d.on("keyup",function(a){27===a.which&&d.trigger("escape.close.bb")}),b(a.container).append(d),d.modal({backdrop:a.backdrop?"static":!1,keyboard:!1,show:!1}),a.show&&d.modal("show"),d},p.setDefaults=function(){var a={};2===arguments.length?a[arguments[0]]=arguments[1]:a=arguments[0],b.extend(o,a)},p.hideAll=function(){return b(".bootbox").modal("hide"),p};var q={bg_BG:{OK:"Ок",CANCEL:"Отказ",CONFIRM:"Потвърждавам"},br:{OK:"OK",CANCEL:"Cancelar",CONFIRM:"Sim"},cs:{OK:"OK",CANCEL:"Zrušit",CONFIRM:"Potvrdit"},da:{OK:"OK",CANCEL:"Annuller",CONFIRM:"Accepter"},de:{OK:"OK",CANCEL:"Abbrechen",CONFIRM:"Akzeptieren"},el:{OK:"Εντάξει",CANCEL:"Ακύρωση",CONFIRM:"Επιβεβαίωση"},en:{OK:"OK",CANCEL:"Cancel",CONFIRM:"OK"},es:{OK:"OK",CANCEL:"Cancelar",CONFIRM:"Aceptar"},et:{OK:"OK",CANCEL:"Katkesta",CONFIRM:"OK"},fa:{OK:"قبول",CANCEL:"لغو",CONFIRM:"تایید"},fi:{OK:"OK",CANCEL:"Peruuta",CONFIRM:"OK"},fr:{OK:"OK",CANCEL:"Annuler",CONFIRM:"D'accord"},he:{OK:"אישור",CANCEL:"ביטול",CONFIRM:"אישור"},hu:{OK:"OK",CANCEL:"Mégsem",CONFIRM:"Megerősít"},hr:{OK:"OK",CANCEL:"Odustani",CONFIRM:"Potvrdi"},id:{OK:"OK",CANCEL:"Batal",CONFIRM:"OK"},it:{OK:"OK",CANCEL:"Annulla",CONFIRM:"Conferma"},ja:{OK:"OK",CANCEL:"キャンセル",CONFIRM:"確認"},lt:{OK:"Gerai",CANCEL:"Atšaukti",CONFIRM:"Patvirtinti"},lv:{OK:"Labi",CANCEL:"Atcelt",CONFIRM:"Apstiprināt"},nl:{OK:"OK",CANCEL:"Annuleren",CONFIRM:"Accepteren"},no:{OK:"OK",CANCEL:"Avbryt",CONFIRM:"OK"},pl:{OK:"OK",CANCEL:"Anuluj",CONFIRM:"Potwierdź"},pt:{OK:"OK",CANCEL:"Cancelar",CONFIRM:"Confirmar"},ru:{OK:"OK",CANCEL:"Отмена",CONFIRM:"Применить"},sq:{OK:"OK",CANCEL:"Anulo",CONFIRM:"Prano"},sv:{OK:"OK",CANCEL:"Avbryt",CONFIRM:"OK"},th:{OK:"ตกลง",CANCEL:"ยกเลิก",CONFIRM:"ยืนยัน"},tr:{OK:"Tamam",CANCEL:"İptal",CONFIRM:"Onayla"},zh_CN:{OK:"OK",CANCEL:"取消",CONFIRM:"确认"},zh_TW:{OK:"OK",CANCEL:"取消",CONFIRM:"確認"}};return p.addLocale=function(a,c){return b.each(["OK","CANCEL","CONFIRM"],function(a,b){if(!c[b])throw new Error("Please supply a translation for '"+b+"'")}),q[a]={OK:c.OK,CANCEL:c.CANCEL,CONFIRM:c.CONFIRM},p},p.removeLocale=function(a){return delete q[a],p},p.setLocale=function(a){return p.setDefaults("locale",a)},p.init=function(c){return a(c||b)},p});
/*!

 handlebars v4.0.3

Copyright (C) 2011-2015 by Yehuda Katz

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

@license
*/
(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define(factory);
	else if(typeof exports === 'object')
		exports["Handlebars"] = factory();
	else
		root["Handlebars"] = factory();
})(this, function() {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(8)['default'];

	exports.__esModule = true;

	var _handlebarsRuntime = __webpack_require__(1);

	// Compiler imports

	var _handlebarsRuntime2 = _interopRequireDefault(_handlebarsRuntime);

	var _handlebarsCompilerAst = __webpack_require__(2);

	var _handlebarsCompilerAst2 = _interopRequireDefault(_handlebarsCompilerAst);

	var _handlebarsCompilerBase = __webpack_require__(3);

	var _handlebarsCompilerCompiler = __webpack_require__(4);

	var _handlebarsCompilerJavascriptCompiler = __webpack_require__(5);

	var _handlebarsCompilerJavascriptCompiler2 = _interopRequireDefault(_handlebarsCompilerJavascriptCompiler);

	var _handlebarsCompilerVisitor = __webpack_require__(6);

	var _handlebarsCompilerVisitor2 = _interopRequireDefault(_handlebarsCompilerVisitor);

	var _handlebarsNoConflict = __webpack_require__(7);

	var _handlebarsNoConflict2 = _interopRequireDefault(_handlebarsNoConflict);

	var _create = _handlebarsRuntime2['default'].create;
	function create() {
	  var hb = _create();

	  hb.compile = function (input, options) {
	    return _handlebarsCompilerCompiler.compile(input, options, hb);
	  };
	  hb.precompile = function (input, options) {
	    return _handlebarsCompilerCompiler.precompile(input, options, hb);
	  };

	  hb.AST = _handlebarsCompilerAst2['default'];
	  hb.Compiler = _handlebarsCompilerCompiler.Compiler;
	  hb.JavaScriptCompiler = _handlebarsCompilerJavascriptCompiler2['default'];
	  hb.Parser = _handlebarsCompilerBase.parser;
	  hb.parse = _handlebarsCompilerBase.parse;

	  return hb;
	}

	var inst = create();
	inst.create = create;

	_handlebarsNoConflict2['default'](inst);

	inst.Visitor = _handlebarsCompilerVisitor2['default'];

	inst['default'] = inst;

	exports['default'] = inst;
	module.exports = exports['default'];

/***/ },
/* 1 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireWildcard = __webpack_require__(9)['default'];

	var _interopRequireDefault = __webpack_require__(8)['default'];

	exports.__esModule = true;

	var _handlebarsBase = __webpack_require__(10);

	// Each of these augment the Handlebars object. No need to setup here.
	// (This is done to easily share code between commonjs and browse envs)

	var base = _interopRequireWildcard(_handlebarsBase);

	var _handlebarsSafeString = __webpack_require__(11);

	var _handlebarsSafeString2 = _interopRequireDefault(_handlebarsSafeString);

	var _handlebarsException = __webpack_require__(12);

	var _handlebarsException2 = _interopRequireDefault(_handlebarsException);

	var _handlebarsUtils = __webpack_require__(13);

	var Utils = _interopRequireWildcard(_handlebarsUtils);

	var _handlebarsRuntime = __webpack_require__(14);

	var runtime = _interopRequireWildcard(_handlebarsRuntime);

	var _handlebarsNoConflict = __webpack_require__(7);

	// For compatibility and usage outside of module systems, make the Handlebars object a namespace

	var _handlebarsNoConflict2 = _interopRequireDefault(_handlebarsNoConflict);

	function create() {
	  var hb = new base.HandlebarsEnvironment();

	  Utils.extend(hb, base);
	  hb.SafeString = _handlebarsSafeString2['default'];
	  hb.Exception = _handlebarsException2['default'];
	  hb.Utils = Utils;
	  hb.escapeExpression = Utils.escapeExpression;

	  hb.VM = runtime;
	  hb.template = function (spec) {
	    return runtime.template(spec, hb);
	  };

	  return hb;
	}

	var inst = create();
	inst.create = create;

	_handlebarsNoConflict2['default'](inst);

	inst['default'] = inst;

	exports['default'] = inst;
	module.exports = exports['default'];

/***/ },
/* 2 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;
	var AST = {
	  // Public API used to evaluate derived attributes regarding AST nodes
	  helpers: {
	    // a mustache is definitely a helper if:
	    // * it is an eligible helper, and
	    // * it has at least one parameter or hash segment
	    helperExpression: function helperExpression(node) {
	      return node.type === 'SubExpression' || (node.type === 'MustacheStatement' || node.type === 'BlockStatement') && !!(node.params && node.params.length || node.hash);
	    },

	    scopedId: function scopedId(path) {
	      return (/^\.|this\b/.test(path.original)
	      );
	    },

	    // an ID is simple if it only has one part, and that part is not
	    // `..` or `this`.
	    simpleId: function simpleId(path) {
	      return path.parts.length === 1 && !AST.helpers.scopedId(path) && !path.depth;
	    }
	  }
	};

	// Must be exported as an object rather than the root of the module as the jison lexer
	// must modify the object to operate properly.
	exports['default'] = AST;
	module.exports = exports['default'];

/***/ },
/* 3 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(8)['default'];

	var _interopRequireWildcard = __webpack_require__(9)['default'];

	exports.__esModule = true;
	exports.parse = parse;

	var _parser = __webpack_require__(15);

	var _parser2 = _interopRequireDefault(_parser);

	var _whitespaceControl = __webpack_require__(16);

	var _whitespaceControl2 = _interopRequireDefault(_whitespaceControl);

	var _helpers = __webpack_require__(17);

	var Helpers = _interopRequireWildcard(_helpers);

	var _utils = __webpack_require__(13);

	exports.parser = _parser2['default'];

	var yy = {};
	_utils.extend(yy, Helpers);

	function parse(input, options) {
	  // Just return if an already-compiled AST was passed in.
	  if (input.type === 'Program') {
	    return input;
	  }

	  _parser2['default'].yy = yy;

	  // Altering the shared object here, but this is ok as parser is a sync operation
	  yy.locInfo = function (locInfo) {
	    return new yy.SourceLocation(options && options.srcName, locInfo);
	  };

	  var strip = new _whitespaceControl2['default'](options);
	  return strip.accept(_parser2['default'].parse(input));
	}

/***/ },
/* 4 */
/***/ function(module, exports, __webpack_require__) {

	/* eslint-disable new-cap */

	'use strict';

	var _interopRequireDefault = __webpack_require__(8)['default'];

	exports.__esModule = true;
	exports.Compiler = Compiler;
	exports.precompile = precompile;
	exports.compile = compile;

	var _exception = __webpack_require__(12);

	var _exception2 = _interopRequireDefault(_exception);

	var _utils = __webpack_require__(13);

	var _ast = __webpack_require__(2);

	var _ast2 = _interopRequireDefault(_ast);

	var slice = [].slice;

	function Compiler() {}

	// the foundHelper register will disambiguate helper lookup from finding a
	// function in a context. This is necessary for mustache compatibility, which
	// requires that context functions in blocks are evaluated by blockHelperMissing,
	// and then proceed as if the resulting value was provided to blockHelperMissing.

	Compiler.prototype = {
	  compiler: Compiler,

	  equals: function equals(other) {
	    var len = this.opcodes.length;
	    if (other.opcodes.length !== len) {
	      return false;
	    }

	    for (var i = 0; i < len; i++) {
	      var opcode = this.opcodes[i],
	          otherOpcode = other.opcodes[i];
	      if (opcode.opcode !== otherOpcode.opcode || !argEquals(opcode.args, otherOpcode.args)) {
	        return false;
	      }
	    }

	    // We know that length is the same between the two arrays because they are directly tied
	    // to the opcode behavior above.
	    len = this.children.length;
	    for (var i = 0; i < len; i++) {
	      if (!this.children[i].equals(other.children[i])) {
	        return false;
	      }
	    }

	    return true;
	  },

	  guid: 0,

	  compile: function compile(program, options) {
	    this.sourceNode = [];
	    this.opcodes = [];
	    this.children = [];
	    this.options = options;
	    this.stringParams = options.stringParams;
	    this.trackIds = options.trackIds;

	    options.blockParams = options.blockParams || [];

	    // These changes will propagate to the other compiler components
	    var knownHelpers = options.knownHelpers;
	    options.knownHelpers = {
	      'helperMissing': true,
	      'blockHelperMissing': true,
	      'each': true,
	      'if': true,
	      'unless': true,
	      'with': true,
	      'log': true,
	      'lookup': true
	    };
	    if (knownHelpers) {
	      for (var _name in knownHelpers) {
	        /* istanbul ignore else */
	        if (_name in knownHelpers) {
	          options.knownHelpers[_name] = knownHelpers[_name];
	        }
	      }
	    }

	    return this.accept(program);
	  },

	  compileProgram: function compileProgram(program) {
	    var childCompiler = new this.compiler(),
	        // eslint-disable-line new-cap
	    result = childCompiler.compile(program, this.options),
	        guid = this.guid++;

	    this.usePartial = this.usePartial || result.usePartial;

	    this.children[guid] = result;
	    this.useDepths = this.useDepths || result.useDepths;

	    return guid;
	  },

	  accept: function accept(node) {
	    /* istanbul ignore next: Sanity code */
	    if (!this[node.type]) {
	      throw new _exception2['default']('Unknown type: ' + node.type, node);
	    }

	    this.sourceNode.unshift(node);
	    var ret = this[node.type](node);
	    this.sourceNode.shift();
	    return ret;
	  },

	  Program: function Program(program) {
	    this.options.blockParams.unshift(program.blockParams);

	    var body = program.body,
	        bodyLength = body.length;
	    for (var i = 0; i < bodyLength; i++) {
	      this.accept(body[i]);
	    }

	    this.options.blockParams.shift();

	    this.isSimple = bodyLength === 1;
	    this.blockParams = program.blockParams ? program.blockParams.length : 0;

	    return this;
	  },

	  BlockStatement: function BlockStatement(block) {
	    transformLiteralToPath(block);

	    var program = block.program,
	        inverse = block.inverse;

	    program = program && this.compileProgram(program);
	    inverse = inverse && this.compileProgram(inverse);

	    var type = this.classifySexpr(block);

	    if (type === 'helper') {
	      this.helperSexpr(block, program, inverse);
	    } else if (type === 'simple') {
	      this.simpleSexpr(block);

	      // now that the simple mustache is resolved, we need to
	      // evaluate it by executing `blockHelperMissing`
	      this.opcode('pushProgram', program);
	      this.opcode('pushProgram', inverse);
	      this.opcode('emptyHash');
	      this.opcode('blockValue', block.path.original);
	    } else {
	      this.ambiguousSexpr(block, program, inverse);

	      // now that the simple mustache is resolved, we need to
	      // evaluate it by executing `blockHelperMissing`
	      this.opcode('pushProgram', program);
	      this.opcode('pushProgram', inverse);
	      this.opcode('emptyHash');
	      this.opcode('ambiguousBlockValue');
	    }

	    this.opcode('append');
	  },

	  DecoratorBlock: function DecoratorBlock(decorator) {
	    var program = decorator.program && this.compileProgram(decorator.program);
	    var params = this.setupFullMustacheParams(decorator, program, undefined),
	        path = decorator.path;

	    this.useDecorators = true;
	    this.opcode('registerDecorator', params.length, path.original);
	  },

	  PartialStatement: function PartialStatement(partial) {
	    this.usePartial = true;

	    var program = partial.program;
	    if (program) {
	      program = this.compileProgram(partial.program);
	    }

	    var params = partial.params;
	    if (params.length > 1) {
	      throw new _exception2['default']('Unsupported number of partial arguments: ' + params.length, partial);
	    } else if (!params.length) {
	      if (this.options.explicitPartialContext) {
	        this.opcode('pushLiteral', 'undefined');
	      } else {
	        params.push({ type: 'PathExpression', parts: [], depth: 0 });
	      }
	    }

	    var partialName = partial.name.original,
	        isDynamic = partial.name.type === 'SubExpression';
	    if (isDynamic) {
	      this.accept(partial.name);
	    }

	    this.setupFullMustacheParams(partial, program, undefined, true);

	    var indent = partial.indent || '';
	    if (this.options.preventIndent && indent) {
	      this.opcode('appendContent', indent);
	      indent = '';
	    }

	    this.opcode('invokePartial', isDynamic, partialName, indent);
	    this.opcode('append');
	  },
	  PartialBlockStatement: function PartialBlockStatement(partialBlock) {
	    this.PartialStatement(partialBlock);
	  },

	  MustacheStatement: function MustacheStatement(mustache) {
	    this.SubExpression(mustache);

	    if (mustache.escaped && !this.options.noEscape) {
	      this.opcode('appendEscaped');
	    } else {
	      this.opcode('append');
	    }
	  },
	  Decorator: function Decorator(decorator) {
	    this.DecoratorBlock(decorator);
	  },

	  ContentStatement: function ContentStatement(content) {
	    if (content.value) {
	      this.opcode('appendContent', content.value);
	    }
	  },

	  CommentStatement: function CommentStatement() {},

	  SubExpression: function SubExpression(sexpr) {
	    transformLiteralToPath(sexpr);
	    var type = this.classifySexpr(sexpr);

	    if (type === 'simple') {
	      this.simpleSexpr(sexpr);
	    } else if (type === 'helper') {
	      this.helperSexpr(sexpr);
	    } else {
	      this.ambiguousSexpr(sexpr);
	    }
	  },
	  ambiguousSexpr: function ambiguousSexpr(sexpr, program, inverse) {
	    var path = sexpr.path,
	        name = path.parts[0],
	        isBlock = program != null || inverse != null;

	    this.opcode('getContext', path.depth);

	    this.opcode('pushProgram', program);
	    this.opcode('pushProgram', inverse);

	    path.strict = true;
	    this.accept(path);

	    this.opcode('invokeAmbiguous', name, isBlock);
	  },

	  simpleSexpr: function simpleSexpr(sexpr) {
	    var path = sexpr.path;
	    path.strict = true;
	    this.accept(path);
	    this.opcode('resolvePossibleLambda');
	  },

	  helperSexpr: function helperSexpr(sexpr, program, inverse) {
	    var params = this.setupFullMustacheParams(sexpr, program, inverse),
	        path = sexpr.path,
	        name = path.parts[0];

	    if (this.options.knownHelpers[name]) {
	      this.opcode('invokeKnownHelper', params.length, name);
	    } else if (this.options.knownHelpersOnly) {
	      throw new _exception2['default']('You specified knownHelpersOnly, but used the unknown helper ' + name, sexpr);
	    } else {
	      path.strict = true;
	      path.falsy = true;

	      this.accept(path);
	      this.opcode('invokeHelper', params.length, path.original, _ast2['default'].helpers.simpleId(path));
	    }
	  },

	  PathExpression: function PathExpression(path) {
	    this.addDepth(path.depth);
	    this.opcode('getContext', path.depth);

	    var name = path.parts[0],
	        scoped = _ast2['default'].helpers.scopedId(path),
	        blockParamId = !path.depth && !scoped && this.blockParamIndex(name);

	    if (blockParamId) {
	      this.opcode('lookupBlockParam', blockParamId, path.parts);
	    } else if (!name) {
	      // Context reference, i.e. `{{foo .}}` or `{{foo ..}}`
	      this.opcode('pushContext');
	    } else if (path.data) {
	      this.options.data = true;
	      this.opcode('lookupData', path.depth, path.parts, path.strict);
	    } else {
	      this.opcode('lookupOnContext', path.parts, path.falsy, path.strict, scoped);
	    }
	  },

	  StringLiteral: function StringLiteral(string) {
	    this.opcode('pushString', string.value);
	  },

	  NumberLiteral: function NumberLiteral(number) {
	    this.opcode('pushLiteral', number.value);
	  },

	  BooleanLiteral: function BooleanLiteral(bool) {
	    this.opcode('pushLiteral', bool.value);
	  },

	  UndefinedLiteral: function UndefinedLiteral() {
	    this.opcode('pushLiteral', 'undefined');
	  },

	  NullLiteral: function NullLiteral() {
	    this.opcode('pushLiteral', 'null');
	  },

	  Hash: function Hash(hash) {
	    var pairs = hash.pairs,
	        i = 0,
	        l = pairs.length;

	    this.opcode('pushHash');

	    for (; i < l; i++) {
	      this.pushParam(pairs[i].value);
	    }
	    while (i--) {
	      this.opcode('assignToHash', pairs[i].key);
	    }
	    this.opcode('popHash');
	  },

	  // HELPERS
	  opcode: function opcode(name) {
	    this.opcodes.push({ opcode: name, args: slice.call(arguments, 1), loc: this.sourceNode[0].loc });
	  },

	  addDepth: function addDepth(depth) {
	    if (!depth) {
	      return;
	    }

	    this.useDepths = true;
	  },

	  classifySexpr: function classifySexpr(sexpr) {
	    var isSimple = _ast2['default'].helpers.simpleId(sexpr.path);

	    var isBlockParam = isSimple && !!this.blockParamIndex(sexpr.path.parts[0]);

	    // a mustache is an eligible helper if:
	    // * its id is simple (a single part, not `this` or `..`)
	    var isHelper = !isBlockParam && _ast2['default'].helpers.helperExpression(sexpr);

	    // if a mustache is an eligible helper but not a definite
	    // helper, it is ambiguous, and will be resolved in a later
	    // pass or at runtime.
	    var isEligible = !isBlockParam && (isHelper || isSimple);

	    // if ambiguous, we can possibly resolve the ambiguity now
	    // An eligible helper is one that does not have a complex path, i.e. `this.foo`, `../foo` etc.
	    if (isEligible && !isHelper) {
	      var _name2 = sexpr.path.parts[0],
	          options = this.options;

	      if (options.knownHelpers[_name2]) {
	        isHelper = true;
	      } else if (options.knownHelpersOnly) {
	        isEligible = false;
	      }
	    }

	    if (isHelper) {
	      return 'helper';
	    } else if (isEligible) {
	      return 'ambiguous';
	    } else {
	      return 'simple';
	    }
	  },

	  pushParams: function pushParams(params) {
	    for (var i = 0, l = params.length; i < l; i++) {
	      this.pushParam(params[i]);
	    }
	  },

	  pushParam: function pushParam(val) {
	    var value = val.value != null ? val.value : val.original || '';

	    if (this.stringParams) {
	      if (value.replace) {
	        value = value.replace(/^(\.?\.\/)*/g, '').replace(/\//g, '.');
	      }

	      if (val.depth) {
	        this.addDepth(val.depth);
	      }
	      this.opcode('getContext', val.depth || 0);
	      this.opcode('pushStringParam', value, val.type);

	      if (val.type === 'SubExpression') {
	        // SubExpressions get evaluated and passed in
	        // in string params mode.
	        this.accept(val);
	      }
	    } else {
	      if (this.trackIds) {
	        var blockParamIndex = undefined;
	        if (val.parts && !_ast2['default'].helpers.scopedId(val) && !val.depth) {
	          blockParamIndex = this.blockParamIndex(val.parts[0]);
	        }
	        if (blockParamIndex) {
	          var blockParamChild = val.parts.slice(1).join('.');
	          this.opcode('pushId', 'BlockParam', blockParamIndex, blockParamChild);
	        } else {
	          value = val.original || value;
	          if (value.replace) {
	            value = value.replace(/^this(?:\.|$)/, '').replace(/^\.\//, '').replace(/^\.$/, '');
	          }

	          this.opcode('pushId', val.type, value);
	        }
	      }
	      this.accept(val);
	    }
	  },

	  setupFullMustacheParams: function setupFullMustacheParams(sexpr, program, inverse, omitEmpty) {
	    var params = sexpr.params;
	    this.pushParams(params);

	    this.opcode('pushProgram', program);
	    this.opcode('pushProgram', inverse);

	    if (sexpr.hash) {
	      this.accept(sexpr.hash);
	    } else {
	      this.opcode('emptyHash', omitEmpty);
	    }

	    return params;
	  },

	  blockParamIndex: function blockParamIndex(name) {
	    for (var depth = 0, len = this.options.blockParams.length; depth < len; depth++) {
	      var blockParams = this.options.blockParams[depth],
	          param = blockParams && _utils.indexOf(blockParams, name);
	      if (blockParams && param >= 0) {
	        return [depth, param];
	      }
	    }
	  }
	};

	function precompile(input, options, env) {
	  if (input == null || typeof input !== 'string' && input.type !== 'Program') {
	    throw new _exception2['default']('You must pass a string or Handlebars AST to Handlebars.precompile. You passed ' + input);
	  }

	  options = options || {};
	  if (!('data' in options)) {
	    options.data = true;
	  }
	  if (options.compat) {
	    options.useDepths = true;
	  }

	  var ast = env.parse(input, options),
	      environment = new env.Compiler().compile(ast, options);
	  return new env.JavaScriptCompiler().compile(environment, options);
	}

	function compile(input, options, env) {
	  if (options === undefined) options = {};

	  if (input == null || typeof input !== 'string' && input.type !== 'Program') {
	    throw new _exception2['default']('You must pass a string or Handlebars AST to Handlebars.compile. You passed ' + input);
	  }

	  if (!('data' in options)) {
	    options.data = true;
	  }
	  if (options.compat) {
	    options.useDepths = true;
	  }

	  var compiled = undefined;

	  function compileInput() {
	    var ast = env.parse(input, options),
	        environment = new env.Compiler().compile(ast, options),
	        templateSpec = new env.JavaScriptCompiler().compile(environment, options, undefined, true);
	    return env.template(templateSpec);
	  }

	  // Template is only compiled on first use and cached after that point.
	  function ret(context, execOptions) {
	    if (!compiled) {
	      compiled = compileInput();
	    }
	    return compiled.call(this, context, execOptions);
	  }
	  ret._setup = function (setupOptions) {
	    if (!compiled) {
	      compiled = compileInput();
	    }
	    return compiled._setup(setupOptions);
	  };
	  ret._child = function (i, data, blockParams, depths) {
	    if (!compiled) {
	      compiled = compileInput();
	    }
	    return compiled._child(i, data, blockParams, depths);
	  };
	  return ret;
	}

	function argEquals(a, b) {
	  if (a === b) {
	    return true;
	  }

	  if (_utils.isArray(a) && _utils.isArray(b) && a.length === b.length) {
	    for (var i = 0; i < a.length; i++) {
	      if (!argEquals(a[i], b[i])) {
	        return false;
	      }
	    }
	    return true;
	  }
	}

	function transformLiteralToPath(sexpr) {
	  if (!sexpr.path.parts) {
	    var literal = sexpr.path;
	    // Casting to string here to make false and 0 literal values play nicely with the rest
	    // of the system.
	    sexpr.path = {
	      type: 'PathExpression',
	      data: false,
	      depth: 0,
	      parts: [literal.original + ''],
	      original: literal.original + '',
	      loc: literal.loc
	    };
	  }
	}

/***/ },
/* 5 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(8)['default'];

	exports.__esModule = true;

	var _base = __webpack_require__(10);

	var _exception = __webpack_require__(12);

	var _exception2 = _interopRequireDefault(_exception);

	var _utils = __webpack_require__(13);

	var _codeGen = __webpack_require__(18);

	var _codeGen2 = _interopRequireDefault(_codeGen);

	function Literal(value) {
	  this.value = value;
	}

	function JavaScriptCompiler() {}

	JavaScriptCompiler.prototype = {
	  // PUBLIC API: You can override these methods in a subclass to provide
	  // alternative compiled forms for name lookup and buffering semantics
	  nameLookup: function nameLookup(parent, name /* , type*/) {
	    if (JavaScriptCompiler.isValidJavaScriptVariableName(name)) {
	      return [parent, '.', name];
	    } else {
	      return [parent, '[', JSON.stringify(name), ']'];
	    }
	  },
	  depthedLookup: function depthedLookup(name) {
	    return [this.aliasable('container.lookup'), '(depths, "', name, '")'];
	  },

	  compilerInfo: function compilerInfo() {
	    var revision = _base.COMPILER_REVISION,
	        versions = _base.REVISION_CHANGES[revision];
	    return [revision, versions];
	  },

	  appendToBuffer: function appendToBuffer(source, location, explicit) {
	    // Force a source as this simplifies the merge logic.
	    if (!_utils.isArray(source)) {
	      source = [source];
	    }
	    source = this.source.wrap(source, location);

	    if (this.environment.isSimple) {
	      return ['return ', source, ';'];
	    } else if (explicit) {
	      // This is a case where the buffer operation occurs as a child of another
	      // construct, generally braces. We have to explicitly output these buffer
	      // operations to ensure that the emitted code goes in the correct location.
	      return ['buffer += ', source, ';'];
	    } else {
	      source.appendToBuffer = true;
	      return source;
	    }
	  },

	  initializeBuffer: function initializeBuffer() {
	    return this.quotedString('');
	  },
	  // END PUBLIC API

	  compile: function compile(environment, options, context, asObject) {
	    this.environment = environment;
	    this.options = options;
	    this.stringParams = this.options.stringParams;
	    this.trackIds = this.options.trackIds;
	    this.precompile = !asObject;

	    this.name = this.environment.name;
	    this.isChild = !!context;
	    this.context = context || {
	      decorators: [],
	      programs: [],
	      environments: []
	    };

	    this.preamble();

	    this.stackSlot = 0;
	    this.stackVars = [];
	    this.aliases = {};
	    this.registers = { list: [] };
	    this.hashes = [];
	    this.compileStack = [];
	    this.inlineStack = [];
	    this.blockParams = [];

	    this.compileChildren(environment, options);

	    this.useDepths = this.useDepths || environment.useDepths || environment.useDecorators || this.options.compat;
	    this.useBlockParams = this.useBlockParams || environment.useBlockParams;

	    var opcodes = environment.opcodes,
	        opcode = undefined,
	        firstLoc = undefined,
	        i = undefined,
	        l = undefined;

	    for (i = 0, l = opcodes.length; i < l; i++) {
	      opcode = opcodes[i];

	      this.source.currentLocation = opcode.loc;
	      firstLoc = firstLoc || opcode.loc;
	      this[opcode.opcode].apply(this, opcode.args);
	    }

	    // Flush any trailing content that might be pending.
	    this.source.currentLocation = firstLoc;
	    this.pushSource('');

	    /* istanbul ignore next */
	    if (this.stackSlot || this.inlineStack.length || this.compileStack.length) {
	      throw new _exception2['default']('Compile completed with content left on stack');
	    }

	    if (!this.decorators.isEmpty()) {
	      this.useDecorators = true;

	      this.decorators.prepend('var decorators = container.decorators;\n');
	      this.decorators.push('return fn;');

	      if (asObject) {
	        this.decorators = Function.apply(this, ['fn', 'props', 'container', 'depth0', 'data', 'blockParams', 'depths', this.decorators.merge()]);
	      } else {
	        this.decorators.prepend('function(fn, props, container, depth0, data, blockParams, depths) {\n');
	        this.decorators.push('}\n');
	        this.decorators = this.decorators.merge();
	      }
	    } else {
	      this.decorators = undefined;
	    }

	    var fn = this.createFunctionContext(asObject);
	    if (!this.isChild) {
	      var ret = {
	        compiler: this.compilerInfo(),
	        main: fn
	      };

	      if (this.decorators) {
	        ret.main_d = this.decorators; // eslint-disable-line camelcase
	        ret.useDecorators = true;
	      }

	      var _context = this.context;
	      var programs = _context.programs;
	      var decorators = _context.decorators;

	      for (i = 0, l = programs.length; i < l; i++) {
	        if (programs[i]) {
	          ret[i] = programs[i];
	          if (decorators[i]) {
	            ret[i + '_d'] = decorators[i];
	            ret.useDecorators = true;
	          }
	        }
	      }

	      if (this.environment.usePartial) {
	        ret.usePartial = true;
	      }
	      if (this.options.data) {
	        ret.useData = true;
	      }
	      if (this.useDepths) {
	        ret.useDepths = true;
	      }
	      if (this.useBlockParams) {
	        ret.useBlockParams = true;
	      }
	      if (this.options.compat) {
	        ret.compat = true;
	      }

	      if (!asObject) {
	        ret.compiler = JSON.stringify(ret.compiler);

	        this.source.currentLocation = { start: { line: 1, column: 0 } };
	        ret = this.objectLiteral(ret);

	        if (options.srcName) {
	          ret = ret.toStringWithSourceMap({ file: options.destName });
	          ret.map = ret.map && ret.map.toString();
	        } else {
	          ret = ret.toString();
	        }
	      } else {
	        ret.compilerOptions = this.options;
	      }

	      return ret;
	    } else {
	      return fn;
	    }
	  },

	  preamble: function preamble() {
	    // track the last context pushed into place to allow skipping the
	    // getContext opcode when it would be a noop
	    this.lastContext = 0;
	    this.source = new _codeGen2['default'](this.options.srcName);
	    this.decorators = new _codeGen2['default'](this.options.srcName);
	  },

	  createFunctionContext: function createFunctionContext(asObject) {
	    var varDeclarations = '';

	    var locals = this.stackVars.concat(this.registers.list);
	    if (locals.length > 0) {
	      varDeclarations += ', ' + locals.join(', ');
	    }

	    // Generate minimizer alias mappings
	    //
	    // When using true SourceNodes, this will update all references to the given alias
	    // as the source nodes are reused in situ. For the non-source node compilation mode,
	    // aliases will not be used, but this case is already being run on the client and
	    // we aren't concern about minimizing the template size.
	    var aliasCount = 0;
	    for (var alias in this.aliases) {
	      // eslint-disable-line guard-for-in
	      var node = this.aliases[alias];

	      if (this.aliases.hasOwnProperty(alias) && node.children && node.referenceCount > 1) {
	        varDeclarations += ', alias' + ++aliasCount + '=' + alias;
	        node.children[0] = 'alias' + aliasCount;
	      }
	    }

	    var params = ['container', 'depth0', 'helpers', 'partials', 'data'];

	    if (this.useBlockParams || this.useDepths) {
	      params.push('blockParams');
	    }
	    if (this.useDepths) {
	      params.push('depths');
	    }

	    // Perform a second pass over the output to merge content when possible
	    var source = this.mergeSource(varDeclarations);

	    if (asObject) {
	      params.push(source);

	      return Function.apply(this, params);
	    } else {
	      return this.source.wrap(['function(', params.join(','), ') {\n  ', source, '}']);
	    }
	  },
	  mergeSource: function mergeSource(varDeclarations) {
	    var isSimple = this.environment.isSimple,
	        appendOnly = !this.forceBuffer,
	        appendFirst = undefined,
	        sourceSeen = undefined,
	        bufferStart = undefined,
	        bufferEnd = undefined;
	    this.source.each(function (line) {
	      if (line.appendToBuffer) {
	        if (bufferStart) {
	          line.prepend('  + ');
	        } else {
	          bufferStart = line;
	        }
	        bufferEnd = line;
	      } else {
	        if (bufferStart) {
	          if (!sourceSeen) {
	            appendFirst = true;
	          } else {
	            bufferStart.prepend('buffer += ');
	          }
	          bufferEnd.add(';');
	          bufferStart = bufferEnd = undefined;
	        }

	        sourceSeen = true;
	        if (!isSimple) {
	          appendOnly = false;
	        }
	      }
	    });

	    if (appendOnly) {
	      if (bufferStart) {
	        bufferStart.prepend('return ');
	        bufferEnd.add(';');
	      } else if (!sourceSeen) {
	        this.source.push('return "";');
	      }
	    } else {
	      varDeclarations += ', buffer = ' + (appendFirst ? '' : this.initializeBuffer());

	      if (bufferStart) {
	        bufferStart.prepend('return buffer + ');
	        bufferEnd.add(';');
	      } else {
	        this.source.push('return buffer;');
	      }
	    }

	    if (varDeclarations) {
	      this.source.prepend('var ' + varDeclarations.substring(2) + (appendFirst ? '' : ';\n'));
	    }

	    return this.source.merge();
	  },

	  // [blockValue]
	  //
	  // On stack, before: hash, inverse, program, value
	  // On stack, after: return value of blockHelperMissing
	  //
	  // The purpose of this opcode is to take a block of the form
	  // `{{#this.foo}}...{{/this.foo}}`, resolve the value of `foo`, and
	  // replace it on the stack with the result of properly
	  // invoking blockHelperMissing.
	  blockValue: function blockValue(name) {
	    var blockHelperMissing = this.aliasable('helpers.blockHelperMissing'),
	        params = [this.contextName(0)];
	    this.setupHelperArgs(name, 0, params);

	    var blockName = this.popStack();
	    params.splice(1, 0, blockName);

	    this.push(this.source.functionCall(blockHelperMissing, 'call', params));
	  },

	  // [ambiguousBlockValue]
	  //
	  // On stack, before: hash, inverse, program, value
	  // Compiler value, before: lastHelper=value of last found helper, if any
	  // On stack, after, if no lastHelper: same as [blockValue]
	  // On stack, after, if lastHelper: value
	  ambiguousBlockValue: function ambiguousBlockValue() {
	    // We're being a bit cheeky and reusing the options value from the prior exec
	    var blockHelperMissing = this.aliasable('helpers.blockHelperMissing'),
	        params = [this.contextName(0)];
	    this.setupHelperArgs('', 0, params, true);

	    this.flushInline();

	    var current = this.topStack();
	    params.splice(1, 0, current);

	    this.pushSource(['if (!', this.lastHelper, ') { ', current, ' = ', this.source.functionCall(blockHelperMissing, 'call', params), '}']);
	  },

	  // [appendContent]
	  //
	  // On stack, before: ...
	  // On stack, after: ...
	  //
	  // Appends the string value of `content` to the current buffer
	  appendContent: function appendContent(content) {
	    if (this.pendingContent) {
	      content = this.pendingContent + content;
	    } else {
	      this.pendingLocation = this.source.currentLocation;
	    }

	    this.pendingContent = content;
	  },

	  // [append]
	  //
	  // On stack, before: value, ...
	  // On stack, after: ...
	  //
	  // Coerces `value` to a String and appends it to the current buffer.
	  //
	  // If `value` is truthy, or 0, it is coerced into a string and appended
	  // Otherwise, the empty string is appended
	  append: function append() {
	    if (this.isInline()) {
	      this.replaceStack(function (current) {
	        return [' != null ? ', current, ' : ""'];
	      });

	      this.pushSource(this.appendToBuffer(this.popStack()));
	    } else {
	      var local = this.popStack();
	      this.pushSource(['if (', local, ' != null) { ', this.appendToBuffer(local, undefined, true), ' }']);
	      if (this.environment.isSimple) {
	        this.pushSource(['else { ', this.appendToBuffer("''", undefined, true), ' }']);
	      }
	    }
	  },

	  // [appendEscaped]
	  //
	  // On stack, before: value, ...
	  // On stack, after: ...
	  //
	  // Escape `value` and append it to the buffer
	  appendEscaped: function appendEscaped() {
	    this.pushSource(this.appendToBuffer([this.aliasable('container.escapeExpression'), '(', this.popStack(), ')']));
	  },

	  // [getContext]
	  //
	  // On stack, before: ...
	  // On stack, after: ...
	  // Compiler value, after: lastContext=depth
	  //
	  // Set the value of the `lastContext` compiler value to the depth
	  getContext: function getContext(depth) {
	    this.lastContext = depth;
	  },

	  // [pushContext]
	  //
	  // On stack, before: ...
	  // On stack, after: currentContext, ...
	  //
	  // Pushes the value of the current context onto the stack.
	  pushContext: function pushContext() {
	    this.pushStackLiteral(this.contextName(this.lastContext));
	  },

	  // [lookupOnContext]
	  //
	  // On stack, before: ...
	  // On stack, after: currentContext[name], ...
	  //
	  // Looks up the value of `name` on the current context and pushes
	  // it onto the stack.
	  lookupOnContext: function lookupOnContext(parts, falsy, strict, scoped) {
	    var i = 0;

	    if (!scoped && this.options.compat && !this.lastContext) {
	      // The depthed query is expected to handle the undefined logic for the root level that
	      // is implemented below, so we evaluate that directly in compat mode
	      this.push(this.depthedLookup(parts[i++]));
	    } else {
	      this.pushContext();
	    }

	    this.resolvePath('context', parts, i, falsy, strict);
	  },

	  // [lookupBlockParam]
	  //
	  // On stack, before: ...
	  // On stack, after: blockParam[name], ...
	  //
	  // Looks up the value of `parts` on the given block param and pushes
	  // it onto the stack.
	  lookupBlockParam: function lookupBlockParam(blockParamId, parts) {
	    this.useBlockParams = true;

	    this.push(['blockParams[', blockParamId[0], '][', blockParamId[1], ']']);
	    this.resolvePath('context', parts, 1);
	  },

	  // [lookupData]
	  //
	  // On stack, before: ...
	  // On stack, after: data, ...
	  //
	  // Push the data lookup operator
	  lookupData: function lookupData(depth, parts, strict) {
	    if (!depth) {
	      this.pushStackLiteral('data');
	    } else {
	      this.pushStackLiteral('container.data(data, ' + depth + ')');
	    }

	    this.resolvePath('data', parts, 0, true, strict);
	  },

	  resolvePath: function resolvePath(type, parts, i, falsy, strict) {
	    // istanbul ignore next

	    var _this = this;

	    if (this.options.strict || this.options.assumeObjects) {
	      this.push(strictLookup(this.options.strict && strict, this, parts, type));
	      return;
	    }

	    var len = parts.length;
	    for (; i < len; i++) {
	      /* eslint-disable no-loop-func */
	      this.replaceStack(function (current) {
	        var lookup = _this.nameLookup(current, parts[i], type);
	        // We want to ensure that zero and false are handled properly if the context (falsy flag)
	        // needs to have the special handling for these values.
	        if (!falsy) {
	          return [' != null ? ', lookup, ' : ', current];
	        } else {
	          // Otherwise we can use generic falsy handling
	          return [' && ', lookup];
	        }
	      });
	      /* eslint-enable no-loop-func */
	    }
	  },

	  // [resolvePossibleLambda]
	  //
	  // On stack, before: value, ...
	  // On stack, after: resolved value, ...
	  //
	  // If the `value` is a lambda, replace it on the stack by
	  // the return value of the lambda
	  resolvePossibleLambda: function resolvePossibleLambda() {
	    this.push([this.aliasable('container.lambda'), '(', this.popStack(), ', ', this.contextName(0), ')']);
	  },

	  // [pushStringParam]
	  //
	  // On stack, before: ...
	  // On stack, after: string, currentContext, ...
	  //
	  // This opcode is designed for use in string mode, which
	  // provides the string value of a parameter along with its
	  // depth rather than resolving it immediately.
	  pushStringParam: function pushStringParam(string, type) {
	    this.pushContext();
	    this.pushString(type);

	    // If it's a subexpression, the string result
	    // will be pushed after this opcode.
	    if (type !== 'SubExpression') {
	      if (typeof string === 'string') {
	        this.pushString(string);
	      } else {
	        this.pushStackLiteral(string);
	      }
	    }
	  },

	  emptyHash: function emptyHash(omitEmpty) {
	    if (this.trackIds) {
	      this.push('{}'); // hashIds
	    }
	    if (this.stringParams) {
	      this.push('{}'); // hashContexts
	      this.push('{}'); // hashTypes
	    }
	    this.pushStackLiteral(omitEmpty ? 'undefined' : '{}');
	  },
	  pushHash: function pushHash() {
	    if (this.hash) {
	      this.hashes.push(this.hash);
	    }
	    this.hash = { values: [], types: [], contexts: [], ids: [] };
	  },
	  popHash: function popHash() {
	    var hash = this.hash;
	    this.hash = this.hashes.pop();

	    if (this.trackIds) {
	      this.push(this.objectLiteral(hash.ids));
	    }
	    if (this.stringParams) {
	      this.push(this.objectLiteral(hash.contexts));
	      this.push(this.objectLiteral(hash.types));
	    }

	    this.push(this.objectLiteral(hash.values));
	  },

	  // [pushString]
	  //
	  // On stack, before: ...
	  // On stack, after: quotedString(string), ...
	  //
	  // Push a quoted version of `string` onto the stack
	  pushString: function pushString(string) {
	    this.pushStackLiteral(this.quotedString(string));
	  },

	  // [pushLiteral]
	  //
	  // On stack, before: ...
	  // On stack, after: value, ...
	  //
	  // Pushes a value onto the stack. This operation prevents
	  // the compiler from creating a temporary variable to hold
	  // it.
	  pushLiteral: function pushLiteral(value) {
	    this.pushStackLiteral(value);
	  },

	  // [pushProgram]
	  //
	  // On stack, before: ...
	  // On stack, after: program(guid), ...
	  //
	  // Push a program expression onto the stack. This takes
	  // a compile-time guid and converts it into a runtime-accessible
	  // expression.
	  pushProgram: function pushProgram(guid) {
	    if (guid != null) {
	      this.pushStackLiteral(this.programExpression(guid));
	    } else {
	      this.pushStackLiteral(null);
	    }
	  },

	  // [registerDecorator]
	  //
	  // On stack, before: hash, program, params..., ...
	  // On stack, after: ...
	  //
	  // Pops off the decorator's parameters, invokes the decorator,
	  // and inserts the decorator into the decorators list.
	  registerDecorator: function registerDecorator(paramSize, name) {
	    var foundDecorator = this.nameLookup('decorators', name, 'decorator'),
	        options = this.setupHelperArgs(name, paramSize);

	    this.decorators.push(['fn = ', this.decorators.functionCall(foundDecorator, '', ['fn', 'props', 'container', options]), ' || fn;']);
	  },

	  // [invokeHelper]
	  //
	  // On stack, before: hash, inverse, program, params..., ...
	  // On stack, after: result of helper invocation
	  //
	  // Pops off the helper's parameters, invokes the helper,
	  // and pushes the helper's return value onto the stack.
	  //
	  // If the helper is not found, `helperMissing` is called.
	  invokeHelper: function invokeHelper(paramSize, name, isSimple) {
	    var nonHelper = this.popStack(),
	        helper = this.setupHelper(paramSize, name),
	        simple = isSimple ? [helper.name, ' || '] : '';

	    var lookup = ['('].concat(simple, nonHelper);
	    if (!this.options.strict) {
	      lookup.push(' || ', this.aliasable('helpers.helperMissing'));
	    }
	    lookup.push(')');

	    this.push(this.source.functionCall(lookup, 'call', helper.callParams));
	  },

	  // [invokeKnownHelper]
	  //
	  // On stack, before: hash, inverse, program, params..., ...
	  // On stack, after: result of helper invocation
	  //
	  // This operation is used when the helper is known to exist,
	  // so a `helperMissing` fallback is not required.
	  invokeKnownHelper: function invokeKnownHelper(paramSize, name) {
	    var helper = this.setupHelper(paramSize, name);
	    this.push(this.source.functionCall(helper.name, 'call', helper.callParams));
	  },

	  // [invokeAmbiguous]
	  //
	  // On stack, before: hash, inverse, program, params..., ...
	  // On stack, after: result of disambiguation
	  //
	  // This operation is used when an expression like `{{foo}}`
	  // is provided, but we don't know at compile-time whether it
	  // is a helper or a path.
	  //
	  // This operation emits more code than the other options,
	  // and can be avoided by passing the `knownHelpers` and
	  // `knownHelpersOnly` flags at compile-time.
	  invokeAmbiguous: function invokeAmbiguous(name, helperCall) {
	    this.useRegister('helper');

	    var nonHelper = this.popStack();

	    this.emptyHash();
	    var helper = this.setupHelper(0, name, helperCall);

	    var helperName = this.lastHelper = this.nameLookup('helpers', name, 'helper');

	    var lookup = ['(', '(helper = ', helperName, ' || ', nonHelper, ')'];
	    if (!this.options.strict) {
	      lookup[0] = '(helper = ';
	      lookup.push(' != null ? helper : ', this.aliasable('helpers.helperMissing'));
	    }

	    this.push(['(', lookup, helper.paramsInit ? ['),(', helper.paramsInit] : [], '),', '(typeof helper === ', this.aliasable('"function"'), ' ? ', this.source.functionCall('helper', 'call', helper.callParams), ' : helper))']);
	  },

	  // [invokePartial]
	  //
	  // On stack, before: context, ...
	  // On stack after: result of partial invocation
	  //
	  // This operation pops off a context, invokes a partial with that context,
	  // and pushes the result of the invocation back.
	  invokePartial: function invokePartial(isDynamic, name, indent) {
	    var params = [],
	        options = this.setupParams(name, 1, params);

	    if (isDynamic) {
	      name = this.popStack();
	      delete options.name;
	    }

	    if (indent) {
	      options.indent = JSON.stringify(indent);
	    }
	    options.helpers = 'helpers';
	    options.partials = 'partials';
	    options.decorators = 'container.decorators';

	    if (!isDynamic) {
	      params.unshift(this.nameLookup('partials', name, 'partial'));
	    } else {
	      params.unshift(name);
	    }

	    if (this.options.compat) {
	      options.depths = 'depths';
	    }
	    options = this.objectLiteral(options);
	    params.push(options);

	    this.push(this.source.functionCall('container.invokePartial', '', params));
	  },

	  // [assignToHash]
	  //
	  // On stack, before: value, ..., hash, ...
	  // On stack, after: ..., hash, ...
	  //
	  // Pops a value off the stack and assigns it to the current hash
	  assignToHash: function assignToHash(key) {
	    var value = this.popStack(),
	        context = undefined,
	        type = undefined,
	        id = undefined;

	    if (this.trackIds) {
	      id = this.popStack();
	    }
	    if (this.stringParams) {
	      type = this.popStack();
	      context = this.popStack();
	    }

	    var hash = this.hash;
	    if (context) {
	      hash.contexts[key] = context;
	    }
	    if (type) {
	      hash.types[key] = type;
	    }
	    if (id) {
	      hash.ids[key] = id;
	    }
	    hash.values[key] = value;
	  },

	  pushId: function pushId(type, name, child) {
	    if (type === 'BlockParam') {
	      this.pushStackLiteral('blockParams[' + name[0] + '].path[' + name[1] + ']' + (child ? ' + ' + JSON.stringify('.' + child) : ''));
	    } else if (type === 'PathExpression') {
	      this.pushString(name);
	    } else if (type === 'SubExpression') {
	      this.pushStackLiteral('true');
	    } else {
	      this.pushStackLiteral('null');
	    }
	  },

	  // HELPERS

	  compiler: JavaScriptCompiler,

	  compileChildren: function compileChildren(environment, options) {
	    var children = environment.children,
	        child = undefined,
	        compiler = undefined;

	    for (var i = 0, l = children.length; i < l; i++) {
	      child = children[i];
	      compiler = new this.compiler(); // eslint-disable-line new-cap

	      var index = this.matchExistingProgram(child);

	      if (index == null) {
	        this.context.programs.push(''); // Placeholder to prevent name conflicts for nested children
	        index = this.context.programs.length;
	        child.index = index;
	        child.name = 'program' + index;
	        this.context.programs[index] = compiler.compile(child, options, this.context, !this.precompile);
	        this.context.decorators[index] = compiler.decorators;
	        this.context.environments[index] = child;

	        this.useDepths = this.useDepths || compiler.useDepths;
	        this.useBlockParams = this.useBlockParams || compiler.useBlockParams;
	      } else {
	        child.index = index;
	        child.name = 'program' + index;

	        this.useDepths = this.useDepths || child.useDepths;
	        this.useBlockParams = this.useBlockParams || child.useBlockParams;
	      }
	    }
	  },
	  matchExistingProgram: function matchExistingProgram(child) {
	    for (var i = 0, len = this.context.environments.length; i < len; i++) {
	      var environment = this.context.environments[i];
	      if (environment && environment.equals(child)) {
	        return i;
	      }
	    }
	  },

	  programExpression: function programExpression(guid) {
	    var child = this.environment.children[guid],
	        programParams = [child.index, 'data', child.blockParams];

	    if (this.useBlockParams || this.useDepths) {
	      programParams.push('blockParams');
	    }
	    if (this.useDepths) {
	      programParams.push('depths');
	    }

	    return 'container.program(' + programParams.join(', ') + ')';
	  },

	  useRegister: function useRegister(name) {
	    if (!this.registers[name]) {
	      this.registers[name] = true;
	      this.registers.list.push(name);
	    }
	  },

	  push: function push(expr) {
	    if (!(expr instanceof Literal)) {
	      expr = this.source.wrap(expr);
	    }

	    this.inlineStack.push(expr);
	    return expr;
	  },

	  pushStackLiteral: function pushStackLiteral(item) {
	    this.push(new Literal(item));
	  },

	  pushSource: function pushSource(source) {
	    if (this.pendingContent) {
	      this.source.push(this.appendToBuffer(this.source.quotedString(this.pendingContent), this.pendingLocation));
	      this.pendingContent = undefined;
	    }

	    if (source) {
	      this.source.push(source);
	    }
	  },

	  replaceStack: function replaceStack(callback) {
	    var prefix = ['('],
	        stack = undefined,
	        createdStack = undefined,
	        usedLiteral = undefined;

	    /* istanbul ignore next */
	    if (!this.isInline()) {
	      throw new _exception2['default']('replaceStack on non-inline');
	    }

	    // We want to merge the inline statement into the replacement statement via ','
	    var top = this.popStack(true);

	    if (top instanceof Literal) {
	      // Literals do not need to be inlined
	      stack = [top.value];
	      prefix = ['(', stack];
	      usedLiteral = true;
	    } else {
	      // Get or create the current stack name for use by the inline
	      createdStack = true;
	      var _name = this.incrStack();

	      prefix = ['((', this.push(_name), ' = ', top, ')'];
	      stack = this.topStack();
	    }

	    var item = callback.call(this, stack);

	    if (!usedLiteral) {
	      this.popStack();
	    }
	    if (createdStack) {
	      this.stackSlot--;
	    }
	    this.push(prefix.concat(item, ')'));
	  },

	  incrStack: function incrStack() {
	    this.stackSlot++;
	    if (this.stackSlot > this.stackVars.length) {
	      this.stackVars.push('stack' + this.stackSlot);
	    }
	    return this.topStackName();
	  },
	  topStackName: function topStackName() {
	    return 'stack' + this.stackSlot;
	  },
	  flushInline: function flushInline() {
	    var inlineStack = this.inlineStack;
	    this.inlineStack = [];
	    for (var i = 0, len = inlineStack.length; i < len; i++) {
	      var entry = inlineStack[i];
	      /* istanbul ignore if */
	      if (entry instanceof Literal) {
	        this.compileStack.push(entry);
	      } else {
	        var stack = this.incrStack();
	        this.pushSource([stack, ' = ', entry, ';']);
	        this.compileStack.push(stack);
	      }
	    }
	  },
	  isInline: function isInline() {
	    return this.inlineStack.length;
	  },

	  popStack: function popStack(wrapped) {
	    var inline = this.isInline(),
	        item = (inline ? this.inlineStack : this.compileStack).pop();

	    if (!wrapped && item instanceof Literal) {
	      return item.value;
	    } else {
	      if (!inline) {
	        /* istanbul ignore next */
	        if (!this.stackSlot) {
	          throw new _exception2['default']('Invalid stack pop');
	        }
	        this.stackSlot--;
	      }
	      return item;
	    }
	  },

	  topStack: function topStack() {
	    var stack = this.isInline() ? this.inlineStack : this.compileStack,
	        item = stack[stack.length - 1];

	    /* istanbul ignore if */
	    if (item instanceof Literal) {
	      return item.value;
	    } else {
	      return item;
	    }
	  },

	  contextName: function contextName(context) {
	    if (this.useDepths && context) {
	      return 'depths[' + context + ']';
	    } else {
	      return 'depth' + context;
	    }
	  },

	  quotedString: function quotedString(str) {
	    return this.source.quotedString(str);
	  },

	  objectLiteral: function objectLiteral(obj) {
	    return this.source.objectLiteral(obj);
	  },

	  aliasable: function aliasable(name) {
	    var ret = this.aliases[name];
	    if (ret) {
	      ret.referenceCount++;
	      return ret;
	    }

	    ret = this.aliases[name] = this.source.wrap(name);
	    ret.aliasable = true;
	    ret.referenceCount = 1;

	    return ret;
	  },

	  setupHelper: function setupHelper(paramSize, name, blockHelper) {
	    var params = [],
	        paramsInit = this.setupHelperArgs(name, paramSize, params, blockHelper);
	    var foundHelper = this.nameLookup('helpers', name, 'helper'),
	        callContext = this.aliasable(this.contextName(0) + ' != null ? ' + this.contextName(0) + ' : {}');

	    return {
	      params: params,
	      paramsInit: paramsInit,
	      name: foundHelper,
	      callParams: [callContext].concat(params)
	    };
	  },

	  setupParams: function setupParams(helper, paramSize, params) {
	    var options = {},
	        contexts = [],
	        types = [],
	        ids = [],
	        objectArgs = !params,
	        param = undefined;

	    if (objectArgs) {
	      params = [];
	    }

	    options.name = this.quotedString(helper);
	    options.hash = this.popStack();

	    if (this.trackIds) {
	      options.hashIds = this.popStack();
	    }
	    if (this.stringParams) {
	      options.hashTypes = this.popStack();
	      options.hashContexts = this.popStack();
	    }

	    var inverse = this.popStack(),
	        program = this.popStack();

	    // Avoid setting fn and inverse if neither are set. This allows
	    // helpers to do a check for `if (options.fn)`
	    if (program || inverse) {
	      options.fn = program || 'container.noop';
	      options.inverse = inverse || 'container.noop';
	    }

	    // The parameters go on to the stack in order (making sure that they are evaluated in order)
	    // so we need to pop them off the stack in reverse order
	    var i = paramSize;
	    while (i--) {
	      param = this.popStack();
	      params[i] = param;

	      if (this.trackIds) {
	        ids[i] = this.popStack();
	      }
	      if (this.stringParams) {
	        types[i] = this.popStack();
	        contexts[i] = this.popStack();
	      }
	    }

	    if (objectArgs) {
	      options.args = this.source.generateArray(params);
	    }

	    if (this.trackIds) {
	      options.ids = this.source.generateArray(ids);
	    }
	    if (this.stringParams) {
	      options.types = this.source.generateArray(types);
	      options.contexts = this.source.generateArray(contexts);
	    }

	    if (this.options.data) {
	      options.data = 'data';
	    }
	    if (this.useBlockParams) {
	      options.blockParams = 'blockParams';
	    }
	    return options;
	  },

	  setupHelperArgs: function setupHelperArgs(helper, paramSize, params, useRegister) {
	    var options = this.setupParams(helper, paramSize, params);
	    options = this.objectLiteral(options);
	    if (useRegister) {
	      this.useRegister('options');
	      params.push('options');
	      return ['options=', options];
	    } else if (params) {
	      params.push(options);
	      return '';
	    } else {
	      return options;
	    }
	  }
	};

	(function () {
	  var reservedWords = ('break else new var' + ' case finally return void' + ' catch for switch while' + ' continue function this with' + ' default if throw' + ' delete in try' + ' do instanceof typeof' + ' abstract enum int short' + ' boolean export interface static' + ' byte extends long super' + ' char final native synchronized' + ' class float package throws' + ' const goto private transient' + ' debugger implements protected volatile' + ' double import public let yield await' + ' null true false').split(' ');

	  var compilerWords = JavaScriptCompiler.RESERVED_WORDS = {};

	  for (var i = 0, l = reservedWords.length; i < l; i++) {
	    compilerWords[reservedWords[i]] = true;
	  }
	})();

	JavaScriptCompiler.isValidJavaScriptVariableName = function (name) {
	  return !JavaScriptCompiler.RESERVED_WORDS[name] && /^[a-zA-Z_$][0-9a-zA-Z_$]*$/.test(name);
	};

	function strictLookup(requireTerminal, compiler, parts, type) {
	  var stack = compiler.popStack(),
	      i = 0,
	      len = parts.length;
	  if (requireTerminal) {
	    len--;
	  }

	  for (; i < len; i++) {
	    stack = compiler.nameLookup(stack, parts[i], type);
	  }

	  if (requireTerminal) {
	    return [compiler.aliasable('container.strict'), '(', stack, ', ', compiler.quotedString(parts[i]), ')'];
	  } else {
	    return stack;
	  }
	}

	exports['default'] = JavaScriptCompiler;
	module.exports = exports['default'];

/***/ },
/* 6 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(8)['default'];

	exports.__esModule = true;

	var _exception = __webpack_require__(12);

	var _exception2 = _interopRequireDefault(_exception);

	function Visitor() {
	  this.parents = [];
	}

	Visitor.prototype = {
	  constructor: Visitor,
	  mutating: false,

	  // Visits a given value. If mutating, will replace the value if necessary.
	  acceptKey: function acceptKey(node, name) {
	    var value = this.accept(node[name]);
	    if (this.mutating) {
	      // Hacky sanity check: This may have a few false positives for type for the helper
	      // methods but will generally do the right thing without a lot of overhead.
	      if (value && !Visitor.prototype[value.type]) {
	        throw new _exception2['default']('Unexpected node type "' + value.type + '" found when accepting ' + name + ' on ' + node.type);
	      }
	      node[name] = value;
	    }
	  },

	  // Performs an accept operation with added sanity check to ensure
	  // required keys are not removed.
	  acceptRequired: function acceptRequired(node, name) {
	    this.acceptKey(node, name);

	    if (!node[name]) {
	      throw new _exception2['default'](node.type + ' requires ' + name);
	    }
	  },

	  // Traverses a given array. If mutating, empty respnses will be removed
	  // for child elements.
	  acceptArray: function acceptArray(array) {
	    for (var i = 0, l = array.length; i < l; i++) {
	      this.acceptKey(array, i);

	      if (!array[i]) {
	        array.splice(i, 1);
	        i--;
	        l--;
	      }
	    }
	  },

	  accept: function accept(object) {
	    if (!object) {
	      return;
	    }

	    /* istanbul ignore next: Sanity code */
	    if (!this[object.type]) {
	      throw new _exception2['default']('Unknown type: ' + object.type, object);
	    }

	    if (this.current) {
	      this.parents.unshift(this.current);
	    }
	    this.current = object;

	    var ret = this[object.type](object);

	    this.current = this.parents.shift();

	    if (!this.mutating || ret) {
	      return ret;
	    } else if (ret !== false) {
	      return object;
	    }
	  },

	  Program: function Program(program) {
	    this.acceptArray(program.body);
	  },

	  MustacheStatement: visitSubExpression,
	  Decorator: visitSubExpression,

	  BlockStatement: visitBlock,
	  DecoratorBlock: visitBlock,

	  PartialStatement: visitPartial,
	  PartialBlockStatement: function PartialBlockStatement(partial) {
	    visitPartial.call(this, partial);

	    this.acceptKey(partial, 'program');
	  },

	  ContentStatement: function ContentStatement() /* content */{},
	  CommentStatement: function CommentStatement() /* comment */{},

	  SubExpression: visitSubExpression,

	  PathExpression: function PathExpression() /* path */{},

	  StringLiteral: function StringLiteral() /* string */{},
	  NumberLiteral: function NumberLiteral() /* number */{},
	  BooleanLiteral: function BooleanLiteral() /* bool */{},
	  UndefinedLiteral: function UndefinedLiteral() /* literal */{},
	  NullLiteral: function NullLiteral() /* literal */{},

	  Hash: function Hash(hash) {
	    this.acceptArray(hash.pairs);
	  },
	  HashPair: function HashPair(pair) {
	    this.acceptRequired(pair, 'value');
	  }
	};

	function visitSubExpression(mustache) {
	  this.acceptRequired(mustache, 'path');
	  this.acceptArray(mustache.params);
	  this.acceptKey(mustache, 'hash');
	}
	function visitBlock(block) {
	  visitSubExpression.call(this, block);

	  this.acceptKey(block, 'program');
	  this.acceptKey(block, 'inverse');
	}
	function visitPartial(partial) {
	  this.acceptRequired(partial, 'name');
	  this.acceptArray(partial.params);
	  this.acceptKey(partial, 'hash');
	}

	exports['default'] = Visitor;
	module.exports = exports['default'];

/***/ },
/* 7 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(global) {/* global window */
	'use strict';

	exports.__esModule = true;

	exports['default'] = function (Handlebars) {
	  /* istanbul ignore next */
	  var root = typeof global !== 'undefined' ? global : window,
	      $Handlebars = root.Handlebars;
	  /* istanbul ignore next */
	  Handlebars.noConflict = function () {
	    if (root.Handlebars === Handlebars) {
	      root.Handlebars = $Handlebars;
	    }
	  };
	};

	module.exports = exports['default'];
	/* WEBPACK VAR INJECTION */}.call(exports, (function() { return this; }())))

/***/ },
/* 8 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";

	exports["default"] = function (obj) {
	  return obj && obj.__esModule ? obj : {
	    "default": obj
	  };
	};

	exports.__esModule = true;

/***/ },
/* 9 */
/***/ function(module, exports, __webpack_require__) {

	"use strict";

	exports["default"] = function (obj) {
	  if (obj && obj.__esModule) {
	    return obj;
	  } else {
	    var newObj = {};

	    if (obj != null) {
	      for (var key in obj) {
	        if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key];
	      }
	    }

	    newObj["default"] = obj;
	    return newObj;
	  }
	};

	exports.__esModule = true;

/***/ },
/* 10 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(8)['default'];

	exports.__esModule = true;
	exports.HandlebarsEnvironment = HandlebarsEnvironment;

	var _utils = __webpack_require__(13);

	var _exception = __webpack_require__(12);

	var _exception2 = _interopRequireDefault(_exception);

	var _helpers = __webpack_require__(19);

	var _decorators = __webpack_require__(20);

	var _logger = __webpack_require__(21);

	var _logger2 = _interopRequireDefault(_logger);

	var VERSION = '4.0.3';
	exports.VERSION = VERSION;
	var COMPILER_REVISION = 7;

	exports.COMPILER_REVISION = COMPILER_REVISION;
	var REVISION_CHANGES = {
	  1: '<= 1.0.rc.2', // 1.0.rc.2 is actually rev2 but doesn't report it
	  2: '== 1.0.0-rc.3',
	  3: '== 1.0.0-rc.4',
	  4: '== 1.x.x',
	  5: '== 2.0.0-alpha.x',
	  6: '>= 2.0.0-beta.1',
	  7: '>= 4.0.0'
	};

	exports.REVISION_CHANGES = REVISION_CHANGES;
	var objectType = '[object Object]';

	function HandlebarsEnvironment(helpers, partials, decorators) {
	  this.helpers = helpers || {};
	  this.partials = partials || {};
	  this.decorators = decorators || {};

	  _helpers.registerDefaultHelpers(this);
	  _decorators.registerDefaultDecorators(this);
	}

	HandlebarsEnvironment.prototype = {
	  constructor: HandlebarsEnvironment,

	  logger: _logger2['default'],
	  log: _logger2['default'].log,

	  registerHelper: function registerHelper(name, fn) {
	    if (_utils.toString.call(name) === objectType) {
	      if (fn) {
	        throw new _exception2['default']('Arg not supported with multiple helpers');
	      }
	      _utils.extend(this.helpers, name);
	    } else {
	      this.helpers[name] = fn;
	    }
	  },
	  unregisterHelper: function unregisterHelper(name) {
	    delete this.helpers[name];
	  },

	  registerPartial: function registerPartial(name, partial) {
	    if (_utils.toString.call(name) === objectType) {
	      _utils.extend(this.partials, name);
	    } else {
	      if (typeof partial === 'undefined') {
	        throw new _exception2['default']('Attempting to register a partial as undefined');
	      }
	      this.partials[name] = partial;
	    }
	  },
	  unregisterPartial: function unregisterPartial(name) {
	    delete this.partials[name];
	  },

	  registerDecorator: function registerDecorator(name, fn) {
	    if (_utils.toString.call(name) === objectType) {
	      if (fn) {
	        throw new _exception2['default']('Arg not supported with multiple decorators');
	      }
	      _utils.extend(this.decorators, name);
	    } else {
	      this.decorators[name] = fn;
	    }
	  },
	  unregisterDecorator: function unregisterDecorator(name) {
	    delete this.decorators[name];
	  }
	};

	var log = _logger2['default'].log;

	exports.log = log;
	exports.createFrame = _utils.createFrame;
	exports.logger = _logger2['default'];

/***/ },
/* 11 */
/***/ function(module, exports, __webpack_require__) {

	// Build out our basic SafeString type
	'use strict';

	exports.__esModule = true;
	function SafeString(string) {
	  this.string = string;
	}

	SafeString.prototype.toString = SafeString.prototype.toHTML = function () {
	  return '' + this.string;
	};

	exports['default'] = SafeString;
	module.exports = exports['default'];

/***/ },
/* 12 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var errorProps = ['description', 'fileName', 'lineNumber', 'message', 'name', 'number', 'stack'];

	function Exception(message, node) {
	  var loc = node && node.loc,
	      line = undefined,
	      column = undefined;
	  if (loc) {
	    line = loc.start.line;
	    column = loc.start.column;

	    message += ' - ' + line + ':' + column;
	  }

	  var tmp = Error.prototype.constructor.call(this, message);

	  // Unfortunately errors are not enumerable in Chrome (at least), so `for prop in tmp` doesn't work.
	  for (var idx = 0; idx < errorProps.length; idx++) {
	    this[errorProps[idx]] = tmp[errorProps[idx]];
	  }

	  /* istanbul ignore else */
	  if (Error.captureStackTrace) {
	    Error.captureStackTrace(this, Exception);
	  }

	  if (loc) {
	    this.lineNumber = line;
	    this.column = column;
	  }
	}

	Exception.prototype = new Error();

	exports['default'] = Exception;
	module.exports = exports['default'];

/***/ },
/* 13 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;
	exports.extend = extend;
	exports.indexOf = indexOf;
	exports.escapeExpression = escapeExpression;
	exports.isEmpty = isEmpty;
	exports.createFrame = createFrame;
	exports.blockParams = blockParams;
	exports.appendContextPath = appendContextPath;
	var escape = {
	  '&': '&amp;',
	  '<': '&lt;',
	  '>': '&gt;',
	  '"': '&quot;',
	  "'": '&#x27;',
	  '`': '&#x60;',
	  '=': '&#x3D;'
	};

	var badChars = /[&<>"'`=]/g,
	    possible = /[&<>"'`=]/;

	function escapeChar(chr) {
	  return escape[chr];
	}

	function extend(obj /* , ...source */) {
	  for (var i = 1; i < arguments.length; i++) {
	    for (var key in arguments[i]) {
	      if (Object.prototype.hasOwnProperty.call(arguments[i], key)) {
	        obj[key] = arguments[i][key];
	      }
	    }
	  }

	  return obj;
	}

	var toString = Object.prototype.toString;

	// Sourced from lodash
	// https://github.com/bestiejs/lodash/blob/master/LICENSE.txt
	/* eslint-disable func-style */
	exports.toString = toString;
	var isFunction = function isFunction(value) {
	  return typeof value === 'function';
	};
	// fallback for older versions of Chrome and Safari
	/* istanbul ignore next */
	if (isFunction(/x/)) {
	  exports.isFunction = isFunction = function (value) {
	    return typeof value === 'function' && toString.call(value) === '[object Function]';
	  };
	}
	exports.isFunction = isFunction;

	/* eslint-enable func-style */

	/* istanbul ignore next */
	var isArray = Array.isArray || function (value) {
	  return value && typeof value === 'object' ? toString.call(value) === '[object Array]' : false;
	};

	// Older IE versions do not directly support indexOf so we must implement our own, sadly.
	exports.isArray = isArray;

	function indexOf(array, value) {
	  for (var i = 0, len = array.length; i < len; i++) {
	    if (array[i] === value) {
	      return i;
	    }
	  }
	  return -1;
	}

	function escapeExpression(string) {
	  if (typeof string !== 'string') {
	    // don't escape SafeStrings, since they're already safe
	    if (string && string.toHTML) {
	      return string.toHTML();
	    } else if (string == null) {
	      return '';
	    } else if (!string) {
	      return string + '';
	    }

	    // Force a string conversion as this will be done by the append regardless and
	    // the regex test will do this transparently behind the scenes, causing issues if
	    // an object's to string has escaped characters in it.
	    string = '' + string;
	  }

	  if (!possible.test(string)) {
	    return string;
	  }
	  return string.replace(badChars, escapeChar);
	}

	function isEmpty(value) {
	  if (!value && value !== 0) {
	    return true;
	  } else if (isArray(value) && value.length === 0) {
	    return true;
	  } else {
	    return false;
	  }
	}

	function createFrame(object) {
	  var frame = extend({}, object);
	  frame._parent = object;
	  return frame;
	}

	function blockParams(params, ids) {
	  params.path = ids;
	  return params;
	}

	function appendContextPath(contextPath, id) {
	  return (contextPath ? contextPath + '.' : '') + id;
	}

/***/ },
/* 14 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireWildcard = __webpack_require__(9)['default'];

	var _interopRequireDefault = __webpack_require__(8)['default'];

	exports.__esModule = true;
	exports.checkRevision = checkRevision;
	exports.template = template;
	exports.wrapProgram = wrapProgram;
	exports.resolvePartial = resolvePartial;
	exports.invokePartial = invokePartial;
	exports.noop = noop;

	var _utils = __webpack_require__(13);

	var Utils = _interopRequireWildcard(_utils);

	var _exception = __webpack_require__(12);

	var _exception2 = _interopRequireDefault(_exception);

	var _base = __webpack_require__(10);

	function checkRevision(compilerInfo) {
	  var compilerRevision = compilerInfo && compilerInfo[0] || 1,
	      currentRevision = _base.COMPILER_REVISION;

	  if (compilerRevision !== currentRevision) {
	    if (compilerRevision < currentRevision) {
	      var runtimeVersions = _base.REVISION_CHANGES[currentRevision],
	          compilerVersions = _base.REVISION_CHANGES[compilerRevision];
	      throw new _exception2['default']('Template was precompiled with an older version of Handlebars than the current runtime. ' + 'Please update your precompiler to a newer version (' + runtimeVersions + ') or downgrade your runtime to an older version (' + compilerVersions + ').');
	    } else {
	      // Use the embedded version info since the runtime doesn't know about this revision yet
	      throw new _exception2['default']('Template was precompiled with a newer version of Handlebars than the current runtime. ' + 'Please update your runtime to a newer version (' + compilerInfo[1] + ').');
	    }
	  }
	}

	function template(templateSpec, env) {
	  /* istanbul ignore next */
	  if (!env) {
	    throw new _exception2['default']('No environment passed to template');
	  }
	  if (!templateSpec || !templateSpec.main) {
	    throw new _exception2['default']('Unknown template object: ' + typeof templateSpec);
	  }

	  templateSpec.main.decorator = templateSpec.main_d;

	  // Note: Using env.VM references rather than local var references throughout this section to allow
	  // for external users to override these as psuedo-supported APIs.
	  env.VM.checkRevision(templateSpec.compiler);

	  function invokePartialWrapper(partial, context, options) {
	    if (options.hash) {
	      context = Utils.extend({}, context, options.hash);
	      if (options.ids) {
	        options.ids[0] = true;
	      }
	    }

	    partial = env.VM.resolvePartial.call(this, partial, context, options);
	    var result = env.VM.invokePartial.call(this, partial, context, options);

	    if (result == null && env.compile) {
	      options.partials[options.name] = env.compile(partial, templateSpec.compilerOptions, env);
	      result = options.partials[options.name](context, options);
	    }
	    if (result != null) {
	      if (options.indent) {
	        var lines = result.split('\n');
	        for (var i = 0, l = lines.length; i < l; i++) {
	          if (!lines[i] && i + 1 === l) {
	            break;
	          }

	          lines[i] = options.indent + lines[i];
	        }
	        result = lines.join('\n');
	      }
	      return result;
	    } else {
	      throw new _exception2['default']('The partial ' + options.name + ' could not be compiled when running in runtime-only mode');
	    }
	  }

	  // Just add water
	  var container = {
	    strict: function strict(obj, name) {
	      if (!(name in obj)) {
	        throw new _exception2['default']('"' + name + '" not defined in ' + obj);
	      }
	      return obj[name];
	    },
	    lookup: function lookup(depths, name) {
	      var len = depths.length;
	      for (var i = 0; i < len; i++) {
	        if (depths[i] && depths[i][name] != null) {
	          return depths[i][name];
	        }
	      }
	    },
	    lambda: function lambda(current, context) {
	      return typeof current === 'function' ? current.call(context) : current;
	    },

	    escapeExpression: Utils.escapeExpression,
	    invokePartial: invokePartialWrapper,

	    fn: function fn(i) {
	      var ret = templateSpec[i];
	      ret.decorator = templateSpec[i + '_d'];
	      return ret;
	    },

	    programs: [],
	    program: function program(i, data, declaredBlockParams, blockParams, depths) {
	      var programWrapper = this.programs[i],
	          fn = this.fn(i);
	      if (data || depths || blockParams || declaredBlockParams) {
	        programWrapper = wrapProgram(this, i, fn, data, declaredBlockParams, blockParams, depths);
	      } else if (!programWrapper) {
	        programWrapper = this.programs[i] = wrapProgram(this, i, fn);
	      }
	      return programWrapper;
	    },

	    data: function data(value, depth) {
	      while (value && depth--) {
	        value = value._parent;
	      }
	      return value;
	    },
	    merge: function merge(param, common) {
	      var obj = param || common;

	      if (param && common && param !== common) {
	        obj = Utils.extend({}, common, param);
	      }

	      return obj;
	    },

	    noop: env.VM.noop,
	    compilerInfo: templateSpec.compiler
	  };

	  function ret(context) {
	    var options = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];

	    var data = options.data;

	    ret._setup(options);
	    if (!options.partial && templateSpec.useData) {
	      data = initData(context, data);
	    }
	    var depths = undefined,
	        blockParams = templateSpec.useBlockParams ? [] : undefined;
	    if (templateSpec.useDepths) {
	      if (options.depths) {
	        depths = context !== options.depths[0] ? [context].concat(options.depths) : options.depths;
	      } else {
	        depths = [context];
	      }
	    }

	    function main(context /*, options*/) {
	      return '' + templateSpec.main(container, context, container.helpers, container.partials, data, blockParams, depths);
	    }
	    main = executeDecorators(templateSpec.main, main, container, options.depths || [], data, blockParams);
	    return main(context, options);
	  }
	  ret.isTop = true;

	  ret._setup = function (options) {
	    if (!options.partial) {
	      container.helpers = container.merge(options.helpers, env.helpers);

	      if (templateSpec.usePartial) {
	        container.partials = container.merge(options.partials, env.partials);
	      }
	      if (templateSpec.usePartial || templateSpec.useDecorators) {
	        container.decorators = container.merge(options.decorators, env.decorators);
	      }
	    } else {
	      container.helpers = options.helpers;
	      container.partials = options.partials;
	      container.decorators = options.decorators;
	    }
	  };

	  ret._child = function (i, data, blockParams, depths) {
	    if (templateSpec.useBlockParams && !blockParams) {
	      throw new _exception2['default']('must pass block params');
	    }
	    if (templateSpec.useDepths && !depths) {
	      throw new _exception2['default']('must pass parent depths');
	    }

	    return wrapProgram(container, i, templateSpec[i], data, 0, blockParams, depths);
	  };
	  return ret;
	}

	function wrapProgram(container, i, fn, data, declaredBlockParams, blockParams, depths) {
	  function prog(context) {
	    var options = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];

	    var currentDepths = depths;
	    if (depths && context !== depths[0]) {
	      currentDepths = [context].concat(depths);
	    }

	    return fn(container, context, container.helpers, container.partials, options.data || data, blockParams && [options.blockParams].concat(blockParams), currentDepths);
	  }

	  prog = executeDecorators(fn, prog, container, depths, data, blockParams);

	  prog.program = i;
	  prog.depth = depths ? depths.length : 0;
	  prog.blockParams = declaredBlockParams || 0;
	  return prog;
	}

	function resolvePartial(partial, context, options) {
	  if (!partial) {
	    if (options.name === '@partial-block') {
	      partial = options.data['partial-block'];
	    } else {
	      partial = options.partials[options.name];
	    }
	  } else if (!partial.call && !options.name) {
	    // This is a dynamic partial that returned a string
	    options.name = partial;
	    partial = options.partials[partial];
	  }
	  return partial;
	}

	function invokePartial(partial, context, options) {
	  options.partial = true;
	  if (options.ids) {
	    options.data.contextPath = options.ids[0] || options.data.contextPath;
	  }

	  var partialBlock = undefined;
	  if (options.fn && options.fn !== noop) {
	    options.data = _base.createFrame(options.data);
	    partialBlock = options.data['partial-block'] = options.fn;

	    if (partialBlock.partials) {
	      options.partials = Utils.extend({}, options.partials, partialBlock.partials);
	    }
	  }

	  if (partial === undefined && partialBlock) {
	    partial = partialBlock;
	  }

	  if (partial === undefined) {
	    throw new _exception2['default']('The partial ' + options.name + ' could not be found');
	  } else if (partial instanceof Function) {
	    return partial(context, options);
	  }
	}

	function noop() {
	  return '';
	}

	function initData(context, data) {
	  if (!data || !('root' in data)) {
	    data = data ? _base.createFrame(data) : {};
	    data.root = context;
	  }
	  return data;
	}

	function executeDecorators(fn, prog, container, depths, data, blockParams) {
	  if (fn.decorator) {
	    var props = {};
	    prog = fn.decorator(prog, props, container, depths && depths[0], data, blockParams, depths);
	    Utils.extend(prog, props);
	  }
	  return prog;
	}

/***/ },
/* 15 */
/***/ function(module, exports, __webpack_require__) {

	/* istanbul ignore next */
	/* Jison generated parser */
	"use strict";

	var handlebars = (function () {
	    var parser = { trace: function trace() {},
	        yy: {},
	        symbols_: { "error": 2, "root": 3, "program": 4, "EOF": 5, "program_repetition0": 6, "statement": 7, "mustache": 8, "block": 9, "rawBlock": 10, "partial": 11, "partialBlock": 12, "content": 13, "COMMENT": 14, "CONTENT": 15, "openRawBlock": 16, "rawBlock_repetition_plus0": 17, "END_RAW_BLOCK": 18, "OPEN_RAW_BLOCK": 19, "helperName": 20, "openRawBlock_repetition0": 21, "openRawBlock_option0": 22, "CLOSE_RAW_BLOCK": 23, "openBlock": 24, "block_option0": 25, "closeBlock": 26, "openInverse": 27, "block_option1": 28, "OPEN_BLOCK": 29, "openBlock_repetition0": 30, "openBlock_option0": 31, "openBlock_option1": 32, "CLOSE": 33, "OPEN_INVERSE": 34, "openInverse_repetition0": 35, "openInverse_option0": 36, "openInverse_option1": 37, "openInverseChain": 38, "OPEN_INVERSE_CHAIN": 39, "openInverseChain_repetition0": 40, "openInverseChain_option0": 41, "openInverseChain_option1": 42, "inverseAndProgram": 43, "INVERSE": 44, "inverseChain": 45, "inverseChain_option0": 46, "OPEN_ENDBLOCK": 47, "OPEN": 48, "mustache_repetition0": 49, "mustache_option0": 50, "OPEN_UNESCAPED": 51, "mustache_repetition1": 52, "mustache_option1": 53, "CLOSE_UNESCAPED": 54, "OPEN_PARTIAL": 55, "partialName": 56, "partial_repetition0": 57, "partial_option0": 58, "openPartialBlock": 59, "OPEN_PARTIAL_BLOCK": 60, "openPartialBlock_repetition0": 61, "openPartialBlock_option0": 62, "param": 63, "sexpr": 64, "OPEN_SEXPR": 65, "sexpr_repetition0": 66, "sexpr_option0": 67, "CLOSE_SEXPR": 68, "hash": 69, "hash_repetition_plus0": 70, "hashSegment": 71, "ID": 72, "EQUALS": 73, "blockParams": 74, "OPEN_BLOCK_PARAMS": 75, "blockParams_repetition_plus0": 76, "CLOSE_BLOCK_PARAMS": 77, "path": 78, "dataName": 79, "STRING": 80, "NUMBER": 81, "BOOLEAN": 82, "UNDEFINED": 83, "NULL": 84, "DATA": 85, "pathSegments": 86, "SEP": 87, "$accept": 0, "$end": 1 },
	        terminals_: { 2: "error", 5: "EOF", 14: "COMMENT", 15: "CONTENT", 18: "END_RAW_BLOCK", 19: "OPEN_RAW_BLOCK", 23: "CLOSE_RAW_BLOCK", 29: "OPEN_BLOCK", 33: "CLOSE", 34: "OPEN_INVERSE", 39: "OPEN_INVERSE_CHAIN", 44: "INVERSE", 47: "OPEN_ENDBLOCK", 48: "OPEN", 51: "OPEN_UNESCAPED", 54: "CLOSE_UNESCAPED", 55: "OPEN_PARTIAL", 60: "OPEN_PARTIAL_BLOCK", 65: "OPEN_SEXPR", 68: "CLOSE_SEXPR", 72: "ID", 73: "EQUALS", 75: "OPEN_BLOCK_PARAMS", 77: "CLOSE_BLOCK_PARAMS", 80: "STRING", 81: "NUMBER", 82: "BOOLEAN", 83: "UNDEFINED", 84: "NULL", 85: "DATA", 87: "SEP" },
	        productions_: [0, [3, 2], [4, 1], [7, 1], [7, 1], [7, 1], [7, 1], [7, 1], [7, 1], [7, 1], [13, 1], [10, 3], [16, 5], [9, 4], [9, 4], [24, 6], [27, 6], [38, 6], [43, 2], [45, 3], [45, 1], [26, 3], [8, 5], [8, 5], [11, 5], [12, 3], [59, 5], [63, 1], [63, 1], [64, 5], [69, 1], [71, 3], [74, 3], [20, 1], [20, 1], [20, 1], [20, 1], [20, 1], [20, 1], [20, 1], [56, 1], [56, 1], [79, 2], [78, 1], [86, 3], [86, 1], [6, 0], [6, 2], [17, 1], [17, 2], [21, 0], [21, 2], [22, 0], [22, 1], [25, 0], [25, 1], [28, 0], [28, 1], [30, 0], [30, 2], [31, 0], [31, 1], [32, 0], [32, 1], [35, 0], [35, 2], [36, 0], [36, 1], [37, 0], [37, 1], [40, 0], [40, 2], [41, 0], [41, 1], [42, 0], [42, 1], [46, 0], [46, 1], [49, 0], [49, 2], [50, 0], [50, 1], [52, 0], [52, 2], [53, 0], [53, 1], [57, 0], [57, 2], [58, 0], [58, 1], [61, 0], [61, 2], [62, 0], [62, 1], [66, 0], [66, 2], [67, 0], [67, 1], [70, 1], [70, 2], [76, 1], [76, 2]],
	        performAction: function anonymous(yytext, yyleng, yylineno, yy, yystate, $$, _$
	        /**/) {

	            var $0 = $$.length - 1;
	            switch (yystate) {
	                case 1:
	                    return $$[$0 - 1];
	                    break;
	                case 2:
	                    this.$ = yy.prepareProgram($$[$0]);
	                    break;
	                case 3:
	                    this.$ = $$[$0];
	                    break;
	                case 4:
	                    this.$ = $$[$0];
	                    break;
	                case 5:
	                    this.$ = $$[$0];
	                    break;
	                case 6:
	                    this.$ = $$[$0];
	                    break;
	                case 7:
	                    this.$ = $$[$0];
	                    break;
	                case 8:
	                    this.$ = $$[$0];
	                    break;
	                case 9:
	                    this.$ = {
	                        type: 'CommentStatement',
	                        value: yy.stripComment($$[$0]),
	                        strip: yy.stripFlags($$[$0], $$[$0]),
	                        loc: yy.locInfo(this._$)
	                    };

	                    break;
	                case 10:
	                    this.$ = {
	                        type: 'ContentStatement',
	                        original: $$[$0],
	                        value: $$[$0],
	                        loc: yy.locInfo(this._$)
	                    };

	                    break;
	                case 11:
	                    this.$ = yy.prepareRawBlock($$[$0 - 2], $$[$0 - 1], $$[$0], this._$);
	                    break;
	                case 12:
	                    this.$ = { path: $$[$0 - 3], params: $$[$0 - 2], hash: $$[$0 - 1] };
	                    break;
	                case 13:
	                    this.$ = yy.prepareBlock($$[$0 - 3], $$[$0 - 2], $$[$0 - 1], $$[$0], false, this._$);
	                    break;
	                case 14:
	                    this.$ = yy.prepareBlock($$[$0 - 3], $$[$0 - 2], $$[$0 - 1], $$[$0], true, this._$);
	                    break;
	                case 15:
	                    this.$ = { open: $$[$0 - 5], path: $$[$0 - 4], params: $$[$0 - 3], hash: $$[$0 - 2], blockParams: $$[$0 - 1], strip: yy.stripFlags($$[$0 - 5], $$[$0]) };
	                    break;
	                case 16:
	                    this.$ = { path: $$[$0 - 4], params: $$[$0 - 3], hash: $$[$0 - 2], blockParams: $$[$0 - 1], strip: yy.stripFlags($$[$0 - 5], $$[$0]) };
	                    break;
	                case 17:
	                    this.$ = { path: $$[$0 - 4], params: $$[$0 - 3], hash: $$[$0 - 2], blockParams: $$[$0 - 1], strip: yy.stripFlags($$[$0 - 5], $$[$0]) };
	                    break;
	                case 18:
	                    this.$ = { strip: yy.stripFlags($$[$0 - 1], $$[$0 - 1]), program: $$[$0] };
	                    break;
	                case 19:
	                    var inverse = yy.prepareBlock($$[$0 - 2], $$[$0 - 1], $$[$0], $$[$0], false, this._$),
	                        program = yy.prepareProgram([inverse], $$[$0 - 1].loc);
	                    program.chained = true;

	                    this.$ = { strip: $$[$0 - 2].strip, program: program, chain: true };

	                    break;
	                case 20:
	                    this.$ = $$[$0];
	                    break;
	                case 21:
	                    this.$ = { path: $$[$0 - 1], strip: yy.stripFlags($$[$0 - 2], $$[$0]) };
	                    break;
	                case 22:
	                    this.$ = yy.prepareMustache($$[$0 - 3], $$[$0 - 2], $$[$0 - 1], $$[$0 - 4], yy.stripFlags($$[$0 - 4], $$[$0]), this._$);
	                    break;
	                case 23:
	                    this.$ = yy.prepareMustache($$[$0 - 3], $$[$0 - 2], $$[$0 - 1], $$[$0 - 4], yy.stripFlags($$[$0 - 4], $$[$0]), this._$);
	                    break;
	                case 24:
	                    this.$ = {
	                        type: 'PartialStatement',
	                        name: $$[$0 - 3],
	                        params: $$[$0 - 2],
	                        hash: $$[$0 - 1],
	                        indent: '',
	                        strip: yy.stripFlags($$[$0 - 4], $$[$0]),
	                        loc: yy.locInfo(this._$)
	                    };

	                    break;
	                case 25:
	                    this.$ = yy.preparePartialBlock($$[$0 - 2], $$[$0 - 1], $$[$0], this._$);
	                    break;
	                case 26:
	                    this.$ = { path: $$[$0 - 3], params: $$[$0 - 2], hash: $$[$0 - 1], strip: yy.stripFlags($$[$0 - 4], $$[$0]) };
	                    break;
	                case 27:
	                    this.$ = $$[$0];
	                    break;
	                case 28:
	                    this.$ = $$[$0];
	                    break;
	                case 29:
	                    this.$ = {
	                        type: 'SubExpression',
	                        path: $$[$0 - 3],
	                        params: $$[$0 - 2],
	                        hash: $$[$0 - 1],
	                        loc: yy.locInfo(this._$)
	                    };

	                    break;
	                case 30:
	                    this.$ = { type: 'Hash', pairs: $$[$0], loc: yy.locInfo(this._$) };
	                    break;
	                case 31:
	                    this.$ = { type: 'HashPair', key: yy.id($$[$0 - 2]), value: $$[$0], loc: yy.locInfo(this._$) };
	                    break;
	                case 32:
	                    this.$ = yy.id($$[$0 - 1]);
	                    break;
	                case 33:
	                    this.$ = $$[$0];
	                    break;
	                case 34:
	                    this.$ = $$[$0];
	                    break;
	                case 35:
	                    this.$ = { type: 'StringLiteral', value: $$[$0], original: $$[$0], loc: yy.locInfo(this._$) };
	                    break;
	                case 36:
	                    this.$ = { type: 'NumberLiteral', value: Number($$[$0]), original: Number($$[$0]), loc: yy.locInfo(this._$) };
	                    break;
	                case 37:
	                    this.$ = { type: 'BooleanLiteral', value: $$[$0] === 'true', original: $$[$0] === 'true', loc: yy.locInfo(this._$) };
	                    break;
	                case 38:
	                    this.$ = { type: 'UndefinedLiteral', original: undefined, value: undefined, loc: yy.locInfo(this._$) };
	                    break;
	                case 39:
	                    this.$ = { type: 'NullLiteral', original: null, value: null, loc: yy.locInfo(this._$) };
	                    break;
	                case 40:
	                    this.$ = $$[$0];
	                    break;
	                case 41:
	                    this.$ = $$[$0];
	                    break;
	                case 42:
	                    this.$ = yy.preparePath(true, $$[$0], this._$);
	                    break;
	                case 43:
	                    this.$ = yy.preparePath(false, $$[$0], this._$);
	                    break;
	                case 44:
	                    $$[$0 - 2].push({ part: yy.id($$[$0]), original: $$[$0], separator: $$[$0 - 1] });this.$ = $$[$0 - 2];
	                    break;
	                case 45:
	                    this.$ = [{ part: yy.id($$[$0]), original: $$[$0] }];
	                    break;
	                case 46:
	                    this.$ = [];
	                    break;
	                case 47:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 48:
	                    this.$ = [$$[$0]];
	                    break;
	                case 49:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 50:
	                    this.$ = [];
	                    break;
	                case 51:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 58:
	                    this.$ = [];
	                    break;
	                case 59:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 64:
	                    this.$ = [];
	                    break;
	                case 65:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 70:
	                    this.$ = [];
	                    break;
	                case 71:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 78:
	                    this.$ = [];
	                    break;
	                case 79:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 82:
	                    this.$ = [];
	                    break;
	                case 83:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 86:
	                    this.$ = [];
	                    break;
	                case 87:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 90:
	                    this.$ = [];
	                    break;
	                case 91:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 94:
	                    this.$ = [];
	                    break;
	                case 95:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 98:
	                    this.$ = [$$[$0]];
	                    break;
	                case 99:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	                case 100:
	                    this.$ = [$$[$0]];
	                    break;
	                case 101:
	                    $$[$0 - 1].push($$[$0]);
	                    break;
	            }
	        },
	        table: [{ 3: 1, 4: 2, 5: [2, 46], 6: 3, 14: [2, 46], 15: [2, 46], 19: [2, 46], 29: [2, 46], 34: [2, 46], 48: [2, 46], 51: [2, 46], 55: [2, 46], 60: [2, 46] }, { 1: [3] }, { 5: [1, 4] }, { 5: [2, 2], 7: 5, 8: 6, 9: 7, 10: 8, 11: 9, 12: 10, 13: 11, 14: [1, 12], 15: [1, 20], 16: 17, 19: [1, 23], 24: 15, 27: 16, 29: [1, 21], 34: [1, 22], 39: [2, 2], 44: [2, 2], 47: [2, 2], 48: [1, 13], 51: [1, 14], 55: [1, 18], 59: 19, 60: [1, 24] }, { 1: [2, 1] }, { 5: [2, 47], 14: [2, 47], 15: [2, 47], 19: [2, 47], 29: [2, 47], 34: [2, 47], 39: [2, 47], 44: [2, 47], 47: [2, 47], 48: [2, 47], 51: [2, 47], 55: [2, 47], 60: [2, 47] }, { 5: [2, 3], 14: [2, 3], 15: [2, 3], 19: [2, 3], 29: [2, 3], 34: [2, 3], 39: [2, 3], 44: [2, 3], 47: [2, 3], 48: [2, 3], 51: [2, 3], 55: [2, 3], 60: [2, 3] }, { 5: [2, 4], 14: [2, 4], 15: [2, 4], 19: [2, 4], 29: [2, 4], 34: [2, 4], 39: [2, 4], 44: [2, 4], 47: [2, 4], 48: [2, 4], 51: [2, 4], 55: [2, 4], 60: [2, 4] }, { 5: [2, 5], 14: [2, 5], 15: [2, 5], 19: [2, 5], 29: [2, 5], 34: [2, 5], 39: [2, 5], 44: [2, 5], 47: [2, 5], 48: [2, 5], 51: [2, 5], 55: [2, 5], 60: [2, 5] }, { 5: [2, 6], 14: [2, 6], 15: [2, 6], 19: [2, 6], 29: [2, 6], 34: [2, 6], 39: [2, 6], 44: [2, 6], 47: [2, 6], 48: [2, 6], 51: [2, 6], 55: [2, 6], 60: [2, 6] }, { 5: [2, 7], 14: [2, 7], 15: [2, 7], 19: [2, 7], 29: [2, 7], 34: [2, 7], 39: [2, 7], 44: [2, 7], 47: [2, 7], 48: [2, 7], 51: [2, 7], 55: [2, 7], 60: [2, 7] }, { 5: [2, 8], 14: [2, 8], 15: [2, 8], 19: [2, 8], 29: [2, 8], 34: [2, 8], 39: [2, 8], 44: [2, 8], 47: [2, 8], 48: [2, 8], 51: [2, 8], 55: [2, 8], 60: [2, 8] }, { 5: [2, 9], 14: [2, 9], 15: [2, 9], 19: [2, 9], 29: [2, 9], 34: [2, 9], 39: [2, 9], 44: [2, 9], 47: [2, 9], 48: [2, 9], 51: [2, 9], 55: [2, 9], 60: [2, 9] }, { 20: 25, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 36, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 4: 37, 6: 3, 14: [2, 46], 15: [2, 46], 19: [2, 46], 29: [2, 46], 34: [2, 46], 39: [2, 46], 44: [2, 46], 47: [2, 46], 48: [2, 46], 51: [2, 46], 55: [2, 46], 60: [2, 46] }, { 4: 38, 6: 3, 14: [2, 46], 15: [2, 46], 19: [2, 46], 29: [2, 46], 34: [2, 46], 44: [2, 46], 47: [2, 46], 48: [2, 46], 51: [2, 46], 55: [2, 46], 60: [2, 46] }, { 13: 40, 15: [1, 20], 17: 39 }, { 20: 42, 56: 41, 64: 43, 65: [1, 44], 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 4: 45, 6: 3, 14: [2, 46], 15: [2, 46], 19: [2, 46], 29: [2, 46], 34: [2, 46], 47: [2, 46], 48: [2, 46], 51: [2, 46], 55: [2, 46], 60: [2, 46] }, { 5: [2, 10], 14: [2, 10], 15: [2, 10], 18: [2, 10], 19: [2, 10], 29: [2, 10], 34: [2, 10], 39: [2, 10], 44: [2, 10], 47: [2, 10], 48: [2, 10], 51: [2, 10], 55: [2, 10], 60: [2, 10] }, { 20: 46, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 47, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 48, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 42, 56: 49, 64: 43, 65: [1, 44], 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 33: [2, 78], 49: 50, 65: [2, 78], 72: [2, 78], 80: [2, 78], 81: [2, 78], 82: [2, 78], 83: [2, 78], 84: [2, 78], 85: [2, 78] }, { 23: [2, 33], 33: [2, 33], 54: [2, 33], 65: [2, 33], 68: [2, 33], 72: [2, 33], 75: [2, 33], 80: [2, 33], 81: [2, 33], 82: [2, 33], 83: [2, 33], 84: [2, 33], 85: [2, 33] }, { 23: [2, 34], 33: [2, 34], 54: [2, 34], 65: [2, 34], 68: [2, 34], 72: [2, 34], 75: [2, 34], 80: [2, 34], 81: [2, 34], 82: [2, 34], 83: [2, 34], 84: [2, 34], 85: [2, 34] }, { 23: [2, 35], 33: [2, 35], 54: [2, 35], 65: [2, 35], 68: [2, 35], 72: [2, 35], 75: [2, 35], 80: [2, 35], 81: [2, 35], 82: [2, 35], 83: [2, 35], 84: [2, 35], 85: [2, 35] }, { 23: [2, 36], 33: [2, 36], 54: [2, 36], 65: [2, 36], 68: [2, 36], 72: [2, 36], 75: [2, 36], 80: [2, 36], 81: [2, 36], 82: [2, 36], 83: [2, 36], 84: [2, 36], 85: [2, 36] }, { 23: [2, 37], 33: [2, 37], 54: [2, 37], 65: [2, 37], 68: [2, 37], 72: [2, 37], 75: [2, 37], 80: [2, 37], 81: [2, 37], 82: [2, 37], 83: [2, 37], 84: [2, 37], 85: [2, 37] }, { 23: [2, 38], 33: [2, 38], 54: [2, 38], 65: [2, 38], 68: [2, 38], 72: [2, 38], 75: [2, 38], 80: [2, 38], 81: [2, 38], 82: [2, 38], 83: [2, 38], 84: [2, 38], 85: [2, 38] }, { 23: [2, 39], 33: [2, 39], 54: [2, 39], 65: [2, 39], 68: [2, 39], 72: [2, 39], 75: [2, 39], 80: [2, 39], 81: [2, 39], 82: [2, 39], 83: [2, 39], 84: [2, 39], 85: [2, 39] }, { 23: [2, 43], 33: [2, 43], 54: [2, 43], 65: [2, 43], 68: [2, 43], 72: [2, 43], 75: [2, 43], 80: [2, 43], 81: [2, 43], 82: [2, 43], 83: [2, 43], 84: [2, 43], 85: [2, 43], 87: [1, 51] }, { 72: [1, 35], 86: 52 }, { 23: [2, 45], 33: [2, 45], 54: [2, 45], 65: [2, 45], 68: [2, 45], 72: [2, 45], 75: [2, 45], 80: [2, 45], 81: [2, 45], 82: [2, 45], 83: [2, 45], 84: [2, 45], 85: [2, 45], 87: [2, 45] }, { 52: 53, 54: [2, 82], 65: [2, 82], 72: [2, 82], 80: [2, 82], 81: [2, 82], 82: [2, 82], 83: [2, 82], 84: [2, 82], 85: [2, 82] }, { 25: 54, 38: 56, 39: [1, 58], 43: 57, 44: [1, 59], 45: 55, 47: [2, 54] }, { 28: 60, 43: 61, 44: [1, 59], 47: [2, 56] }, { 13: 63, 15: [1, 20], 18: [1, 62] }, { 15: [2, 48], 18: [2, 48] }, { 33: [2, 86], 57: 64, 65: [2, 86], 72: [2, 86], 80: [2, 86], 81: [2, 86], 82: [2, 86], 83: [2, 86], 84: [2, 86], 85: [2, 86] }, { 33: [2, 40], 65: [2, 40], 72: [2, 40], 80: [2, 40], 81: [2, 40], 82: [2, 40], 83: [2, 40], 84: [2, 40], 85: [2, 40] }, { 33: [2, 41], 65: [2, 41], 72: [2, 41], 80: [2, 41], 81: [2, 41], 82: [2, 41], 83: [2, 41], 84: [2, 41], 85: [2, 41] }, { 20: 65, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 26: 66, 47: [1, 67] }, { 30: 68, 33: [2, 58], 65: [2, 58], 72: [2, 58], 75: [2, 58], 80: [2, 58], 81: [2, 58], 82: [2, 58], 83: [2, 58], 84: [2, 58], 85: [2, 58] }, { 33: [2, 64], 35: 69, 65: [2, 64], 72: [2, 64], 75: [2, 64], 80: [2, 64], 81: [2, 64], 82: [2, 64], 83: [2, 64], 84: [2, 64], 85: [2, 64] }, { 21: 70, 23: [2, 50], 65: [2, 50], 72: [2, 50], 80: [2, 50], 81: [2, 50], 82: [2, 50], 83: [2, 50], 84: [2, 50], 85: [2, 50] }, { 33: [2, 90], 61: 71, 65: [2, 90], 72: [2, 90], 80: [2, 90], 81: [2, 90], 82: [2, 90], 83: [2, 90], 84: [2, 90], 85: [2, 90] }, { 20: 75, 33: [2, 80], 50: 72, 63: 73, 64: 76, 65: [1, 44], 69: 74, 70: 77, 71: 78, 72: [1, 79], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 72: [1, 80] }, { 23: [2, 42], 33: [2, 42], 54: [2, 42], 65: [2, 42], 68: [2, 42], 72: [2, 42], 75: [2, 42], 80: [2, 42], 81: [2, 42], 82: [2, 42], 83: [2, 42], 84: [2, 42], 85: [2, 42], 87: [1, 51] }, { 20: 75, 53: 81, 54: [2, 84], 63: 82, 64: 76, 65: [1, 44], 69: 83, 70: 77, 71: 78, 72: [1, 79], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 26: 84, 47: [1, 67] }, { 47: [2, 55] }, { 4: 85, 6: 3, 14: [2, 46], 15: [2, 46], 19: [2, 46], 29: [2, 46], 34: [2, 46], 39: [2, 46], 44: [2, 46], 47: [2, 46], 48: [2, 46], 51: [2, 46], 55: [2, 46], 60: [2, 46] }, { 47: [2, 20] }, { 20: 86, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 4: 87, 6: 3, 14: [2, 46], 15: [2, 46], 19: [2, 46], 29: [2, 46], 34: [2, 46], 47: [2, 46], 48: [2, 46], 51: [2, 46], 55: [2, 46], 60: [2, 46] }, { 26: 88, 47: [1, 67] }, { 47: [2, 57] }, { 5: [2, 11], 14: [2, 11], 15: [2, 11], 19: [2, 11], 29: [2, 11], 34: [2, 11], 39: [2, 11], 44: [2, 11], 47: [2, 11], 48: [2, 11], 51: [2, 11], 55: [2, 11], 60: [2, 11] }, { 15: [2, 49], 18: [2, 49] }, { 20: 75, 33: [2, 88], 58: 89, 63: 90, 64: 76, 65: [1, 44], 69: 91, 70: 77, 71: 78, 72: [1, 79], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 65: [2, 94], 66: 92, 68: [2, 94], 72: [2, 94], 80: [2, 94], 81: [2, 94], 82: [2, 94], 83: [2, 94], 84: [2, 94], 85: [2, 94] }, { 5: [2, 25], 14: [2, 25], 15: [2, 25], 19: [2, 25], 29: [2, 25], 34: [2, 25], 39: [2, 25], 44: [2, 25], 47: [2, 25], 48: [2, 25], 51: [2, 25], 55: [2, 25], 60: [2, 25] }, { 20: 93, 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 75, 31: 94, 33: [2, 60], 63: 95, 64: 76, 65: [1, 44], 69: 96, 70: 77, 71: 78, 72: [1, 79], 75: [2, 60], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 75, 33: [2, 66], 36: 97, 63: 98, 64: 76, 65: [1, 44], 69: 99, 70: 77, 71: 78, 72: [1, 79], 75: [2, 66], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 75, 22: 100, 23: [2, 52], 63: 101, 64: 76, 65: [1, 44], 69: 102, 70: 77, 71: 78, 72: [1, 79], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 20: 75, 33: [2, 92], 62: 103, 63: 104, 64: 76, 65: [1, 44], 69: 105, 70: 77, 71: 78, 72: [1, 79], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 33: [1, 106] }, { 33: [2, 79], 65: [2, 79], 72: [2, 79], 80: [2, 79], 81: [2, 79], 82: [2, 79], 83: [2, 79], 84: [2, 79], 85: [2, 79] }, { 33: [2, 81] }, { 23: [2, 27], 33: [2, 27], 54: [2, 27], 65: [2, 27], 68: [2, 27], 72: [2, 27], 75: [2, 27], 80: [2, 27], 81: [2, 27], 82: [2, 27], 83: [2, 27], 84: [2, 27], 85: [2, 27] }, { 23: [2, 28], 33: [2, 28], 54: [2, 28], 65: [2, 28], 68: [2, 28], 72: [2, 28], 75: [2, 28], 80: [2, 28], 81: [2, 28], 82: [2, 28], 83: [2, 28], 84: [2, 28], 85: [2, 28] }, { 23: [2, 30], 33: [2, 30], 54: [2, 30], 68: [2, 30], 71: 107, 72: [1, 108], 75: [2, 30] }, { 23: [2, 98], 33: [2, 98], 54: [2, 98], 68: [2, 98], 72: [2, 98], 75: [2, 98] }, { 23: [2, 45], 33: [2, 45], 54: [2, 45], 65: [2, 45], 68: [2, 45], 72: [2, 45], 73: [1, 109], 75: [2, 45], 80: [2, 45], 81: [2, 45], 82: [2, 45], 83: [2, 45], 84: [2, 45], 85: [2, 45], 87: [2, 45] }, { 23: [2, 44], 33: [2, 44], 54: [2, 44], 65: [2, 44], 68: [2, 44], 72: [2, 44], 75: [2, 44], 80: [2, 44], 81: [2, 44], 82: [2, 44], 83: [2, 44], 84: [2, 44], 85: [2, 44], 87: [2, 44] }, { 54: [1, 110] }, { 54: [2, 83], 65: [2, 83], 72: [2, 83], 80: [2, 83], 81: [2, 83], 82: [2, 83], 83: [2, 83], 84: [2, 83], 85: [2, 83] }, { 54: [2, 85] }, { 5: [2, 13], 14: [2, 13], 15: [2, 13], 19: [2, 13], 29: [2, 13], 34: [2, 13], 39: [2, 13], 44: [2, 13], 47: [2, 13], 48: [2, 13], 51: [2, 13], 55: [2, 13], 60: [2, 13] }, { 38: 56, 39: [1, 58], 43: 57, 44: [1, 59], 45: 112, 46: 111, 47: [2, 76] }, { 33: [2, 70], 40: 113, 65: [2, 70], 72: [2, 70], 75: [2, 70], 80: [2, 70], 81: [2, 70], 82: [2, 70], 83: [2, 70], 84: [2, 70], 85: [2, 70] }, { 47: [2, 18] }, { 5: [2, 14], 14: [2, 14], 15: [2, 14], 19: [2, 14], 29: [2, 14], 34: [2, 14], 39: [2, 14], 44: [2, 14], 47: [2, 14], 48: [2, 14], 51: [2, 14], 55: [2, 14], 60: [2, 14] }, { 33: [1, 114] }, { 33: [2, 87], 65: [2, 87], 72: [2, 87], 80: [2, 87], 81: [2, 87], 82: [2, 87], 83: [2, 87], 84: [2, 87], 85: [2, 87] }, { 33: [2, 89] }, { 20: 75, 63: 116, 64: 76, 65: [1, 44], 67: 115, 68: [2, 96], 69: 117, 70: 77, 71: 78, 72: [1, 79], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 33: [1, 118] }, { 32: 119, 33: [2, 62], 74: 120, 75: [1, 121] }, { 33: [2, 59], 65: [2, 59], 72: [2, 59], 75: [2, 59], 80: [2, 59], 81: [2, 59], 82: [2, 59], 83: [2, 59], 84: [2, 59], 85: [2, 59] }, { 33: [2, 61], 75: [2, 61] }, { 33: [2, 68], 37: 122, 74: 123, 75: [1, 121] }, { 33: [2, 65], 65: [2, 65], 72: [2, 65], 75: [2, 65], 80: [2, 65], 81: [2, 65], 82: [2, 65], 83: [2, 65], 84: [2, 65], 85: [2, 65] }, { 33: [2, 67], 75: [2, 67] }, { 23: [1, 124] }, { 23: [2, 51], 65: [2, 51], 72: [2, 51], 80: [2, 51], 81: [2, 51], 82: [2, 51], 83: [2, 51], 84: [2, 51], 85: [2, 51] }, { 23: [2, 53] }, { 33: [1, 125] }, { 33: [2, 91], 65: [2, 91], 72: [2, 91], 80: [2, 91], 81: [2, 91], 82: [2, 91], 83: [2, 91], 84: [2, 91], 85: [2, 91] }, { 33: [2, 93] }, { 5: [2, 22], 14: [2, 22], 15: [2, 22], 19: [2, 22], 29: [2, 22], 34: [2, 22], 39: [2, 22], 44: [2, 22], 47: [2, 22], 48: [2, 22], 51: [2, 22], 55: [2, 22], 60: [2, 22] }, { 23: [2, 99], 33: [2, 99], 54: [2, 99], 68: [2, 99], 72: [2, 99], 75: [2, 99] }, { 73: [1, 109] }, { 20: 75, 63: 126, 64: 76, 65: [1, 44], 72: [1, 35], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 5: [2, 23], 14: [2, 23], 15: [2, 23], 19: [2, 23], 29: [2, 23], 34: [2, 23], 39: [2, 23], 44: [2, 23], 47: [2, 23], 48: [2, 23], 51: [2, 23], 55: [2, 23], 60: [2, 23] }, { 47: [2, 19] }, { 47: [2, 77] }, { 20: 75, 33: [2, 72], 41: 127, 63: 128, 64: 76, 65: [1, 44], 69: 129, 70: 77, 71: 78, 72: [1, 79], 75: [2, 72], 78: 26, 79: 27, 80: [1, 28], 81: [1, 29], 82: [1, 30], 83: [1, 31], 84: [1, 32], 85: [1, 34], 86: 33 }, { 5: [2, 24], 14: [2, 24], 15: [2, 24], 19: [2, 24], 29: [2, 24], 34: [2, 24], 39: [2, 24], 44: [2, 24], 47: [2, 24], 48: [2, 24], 51: [2, 24], 55: [2, 24], 60: [2, 24] }, { 68: [1, 130] }, { 65: [2, 95], 68: [2, 95], 72: [2, 95], 80: [2, 95], 81: [2, 95], 82: [2, 95], 83: [2, 95], 84: [2, 95], 85: [2, 95] }, { 68: [2, 97] }, { 5: [2, 21], 14: [2, 21], 15: [2, 21], 19: [2, 21], 29: [2, 21], 34: [2, 21], 39: [2, 21], 44: [2, 21], 47: [2, 21], 48: [2, 21], 51: [2, 21], 55: [2, 21], 60: [2, 21] }, { 33: [1, 131] }, { 33: [2, 63] }, { 72: [1, 133], 76: 132 }, { 33: [1, 134] }, { 33: [2, 69] }, { 15: [2, 12] }, { 14: [2, 26], 15: [2, 26], 19: [2, 26], 29: [2, 26], 34: [2, 26], 47: [2, 26], 48: [2, 26], 51: [2, 26], 55: [2, 26], 60: [2, 26] }, { 23: [2, 31], 33: [2, 31], 54: [2, 31], 68: [2, 31], 72: [2, 31], 75: [2, 31] }, { 33: [2, 74], 42: 135, 74: 136, 75: [1, 121] }, { 33: [2, 71], 65: [2, 71], 72: [2, 71], 75: [2, 71], 80: [2, 71], 81: [2, 71], 82: [2, 71], 83: [2, 71], 84: [2, 71], 85: [2, 71] }, { 33: [2, 73], 75: [2, 73] }, { 23: [2, 29], 33: [2, 29], 54: [2, 29], 65: [2, 29], 68: [2, 29], 72: [2, 29], 75: [2, 29], 80: [2, 29], 81: [2, 29], 82: [2, 29], 83: [2, 29], 84: [2, 29], 85: [2, 29] }, { 14: [2, 15], 15: [2, 15], 19: [2, 15], 29: [2, 15], 34: [2, 15], 39: [2, 15], 44: [2, 15], 47: [2, 15], 48: [2, 15], 51: [2, 15], 55: [2, 15], 60: [2, 15] }, { 72: [1, 138], 77: [1, 137] }, { 72: [2, 100], 77: [2, 100] }, { 14: [2, 16], 15: [2, 16], 19: [2, 16], 29: [2, 16], 34: [2, 16], 44: [2, 16], 47: [2, 16], 48: [2, 16], 51: [2, 16], 55: [2, 16], 60: [2, 16] }, { 33: [1, 139] }, { 33: [2, 75] }, { 33: [2, 32] }, { 72: [2, 101], 77: [2, 101] }, { 14: [2, 17], 15: [2, 17], 19: [2, 17], 29: [2, 17], 34: [2, 17], 39: [2, 17], 44: [2, 17], 47: [2, 17], 48: [2, 17], 51: [2, 17], 55: [2, 17], 60: [2, 17] }],
	        defaultActions: { 4: [2, 1], 55: [2, 55], 57: [2, 20], 61: [2, 57], 74: [2, 81], 83: [2, 85], 87: [2, 18], 91: [2, 89], 102: [2, 53], 105: [2, 93], 111: [2, 19], 112: [2, 77], 117: [2, 97], 120: [2, 63], 123: [2, 69], 124: [2, 12], 136: [2, 75], 137: [2, 32] },
	        parseError: function parseError(str, hash) {
	            throw new Error(str);
	        },
	        parse: function parse(input) {
	            var self = this,
	                stack = [0],
	                vstack = [null],
	                lstack = [],
	                table = this.table,
	                yytext = "",
	                yylineno = 0,
	                yyleng = 0,
	                recovering = 0,
	                TERROR = 2,
	                EOF = 1;
	            this.lexer.setInput(input);
	            this.lexer.yy = this.yy;
	            this.yy.lexer = this.lexer;
	            this.yy.parser = this;
	            if (typeof this.lexer.yylloc == "undefined") this.lexer.yylloc = {};
	            var yyloc = this.lexer.yylloc;
	            lstack.push(yyloc);
	            var ranges = this.lexer.options && this.lexer.options.ranges;
	            if (typeof this.yy.parseError === "function") this.parseError = this.yy.parseError;
	            function popStack(n) {
	                stack.length = stack.length - 2 * n;
	                vstack.length = vstack.length - n;
	                lstack.length = lstack.length - n;
	            }
	            function lex() {
	                var token;
	                token = self.lexer.lex() || 1;
	                if (typeof token !== "number") {
	                    token = self.symbols_[token] || token;
	                }
	                return token;
	            }
	            var symbol,
	                preErrorSymbol,
	                state,
	                action,
	                a,
	                r,
	                yyval = {},
	                p,
	                len,
	                newState,
	                expected;
	            while (true) {
	                state = stack[stack.length - 1];
	                if (this.defaultActions[state]) {
	                    action = this.defaultActions[state];
	                } else {
	                    if (symbol === null || typeof symbol == "undefined") {
	                        symbol = lex();
	                    }
	                    action = table[state] && table[state][symbol];
	                }
	                if (typeof action === "undefined" || !action.length || !action[0]) {
	                    var errStr = "";
	                    if (!recovering) {
	                        expected = [];
	                        for (p in table[state]) if (this.terminals_[p] && p > 2) {
	                            expected.push("'" + this.terminals_[p] + "'");
	                        }
	                        if (this.lexer.showPosition) {
	                            errStr = "Parse error on line " + (yylineno + 1) + ":\n" + this.lexer.showPosition() + "\nExpecting " + expected.join(", ") + ", got '" + (this.terminals_[symbol] || symbol) + "'";
	                        } else {
	                            errStr = "Parse error on line " + (yylineno + 1) + ": Unexpected " + (symbol == 1 ? "end of input" : "'" + (this.terminals_[symbol] || symbol) + "'");
	                        }
	                        this.parseError(errStr, { text: this.lexer.match, token: this.terminals_[symbol] || symbol, line: this.lexer.yylineno, loc: yyloc, expected: expected });
	                    }
	                }
	                if (action[0] instanceof Array && action.length > 1) {
	                    throw new Error("Parse Error: multiple actions possible at state: " + state + ", token: " + symbol);
	                }
	                switch (action[0]) {
	                    case 1:
	                        stack.push(symbol);
	                        vstack.push(this.lexer.yytext);
	                        lstack.push(this.lexer.yylloc);
	                        stack.push(action[1]);
	                        symbol = null;
	                        if (!preErrorSymbol) {
	                            yyleng = this.lexer.yyleng;
	                            yytext = this.lexer.yytext;
	                            yylineno = this.lexer.yylineno;
	                            yyloc = this.lexer.yylloc;
	                            if (recovering > 0) recovering--;
	                        } else {
	                            symbol = preErrorSymbol;
	                            preErrorSymbol = null;
	                        }
	                        break;
	                    case 2:
	                        len = this.productions_[action[1]][1];
	                        yyval.$ = vstack[vstack.length - len];
	                        yyval._$ = { first_line: lstack[lstack.length - (len || 1)].first_line, last_line: lstack[lstack.length - 1].last_line, first_column: lstack[lstack.length - (len || 1)].first_column, last_column: lstack[lstack.length - 1].last_column };
	                        if (ranges) {
	                            yyval._$.range = [lstack[lstack.length - (len || 1)].range[0], lstack[lstack.length - 1].range[1]];
	                        }
	                        r = this.performAction.call(yyval, yytext, yyleng, yylineno, this.yy, action[1], vstack, lstack);
	                        if (typeof r !== "undefined") {
	                            return r;
	                        }
	                        if (len) {
	                            stack = stack.slice(0, -1 * len * 2);
	                            vstack = vstack.slice(0, -1 * len);
	                            lstack = lstack.slice(0, -1 * len);
	                        }
	                        stack.push(this.productions_[action[1]][0]);
	                        vstack.push(yyval.$);
	                        lstack.push(yyval._$);
	                        newState = table[stack[stack.length - 2]][stack[stack.length - 1]];
	                        stack.push(newState);
	                        break;
	                    case 3:
	                        return true;
	                }
	            }
	            return true;
	        }
	    };
	    /* Jison generated lexer */
	    var lexer = (function () {
	        var lexer = { EOF: 1,
	            parseError: function parseError(str, hash) {
	                if (this.yy.parser) {
	                    this.yy.parser.parseError(str, hash);
	                } else {
	                    throw new Error(str);
	                }
	            },
	            setInput: function setInput(input) {
	                this._input = input;
	                this._more = this._less = this.done = false;
	                this.yylineno = this.yyleng = 0;
	                this.yytext = this.matched = this.match = '';
	                this.conditionStack = ['INITIAL'];
	                this.yylloc = { first_line: 1, first_column: 0, last_line: 1, last_column: 0 };
	                if (this.options.ranges) this.yylloc.range = [0, 0];
	                this.offset = 0;
	                return this;
	            },
	            input: function input() {
	                var ch = this._input[0];
	                this.yytext += ch;
	                this.yyleng++;
	                this.offset++;
	                this.match += ch;
	                this.matched += ch;
	                var lines = ch.match(/(?:\r\n?|\n).*/g);
	                if (lines) {
	                    this.yylineno++;
	                    this.yylloc.last_line++;
	                } else {
	                    this.yylloc.last_column++;
	                }
	                if (this.options.ranges) this.yylloc.range[1]++;

	                this._input = this._input.slice(1);
	                return ch;
	            },
	            unput: function unput(ch) {
	                var len = ch.length;
	                var lines = ch.split(/(?:\r\n?|\n)/g);

	                this._input = ch + this._input;
	                this.yytext = this.yytext.substr(0, this.yytext.length - len - 1);
	                //this.yyleng -= len;
	                this.offset -= len;
	                var oldLines = this.match.split(/(?:\r\n?|\n)/g);
	                this.match = this.match.substr(0, this.match.length - 1);
	                this.matched = this.matched.substr(0, this.matched.length - 1);

	                if (lines.length - 1) this.yylineno -= lines.length - 1;
	                var r = this.yylloc.range;

	                this.yylloc = { first_line: this.yylloc.first_line,
	                    last_line: this.yylineno + 1,
	                    first_column: this.yylloc.first_column,
	                    last_column: lines ? (lines.length === oldLines.length ? this.yylloc.first_column : 0) + oldLines[oldLines.length - lines.length].length - lines[0].length : this.yylloc.first_column - len
	                };

	                if (this.options.ranges) {
	                    this.yylloc.range = [r[0], r[0] + this.yyleng - len];
	                }
	                return this;
	            },
	            more: function more() {
	                this._more = true;
	                return this;
	            },
	            less: function less(n) {
	                this.unput(this.match.slice(n));
	            },
	            pastInput: function pastInput() {
	                var past = this.matched.substr(0, this.matched.length - this.match.length);
	                return (past.length > 20 ? '...' : '') + past.substr(-20).replace(/\n/g, "");
	            },
	            upcomingInput: function upcomingInput() {
	                var next = this.match;
	                if (next.length < 20) {
	                    next += this._input.substr(0, 20 - next.length);
	                }
	                return (next.substr(0, 20) + (next.length > 20 ? '...' : '')).replace(/\n/g, "");
	            },
	            showPosition: function showPosition() {
	                var pre = this.pastInput();
	                var c = new Array(pre.length + 1).join("-");
	                return pre + this.upcomingInput() + "\n" + c + "^";
	            },
	            next: function next() {
	                if (this.done) {
	                    return this.EOF;
	                }
	                if (!this._input) this.done = true;

	                var token, match, tempMatch, index, col, lines;
	                if (!this._more) {
	                    this.yytext = '';
	                    this.match = '';
	                }
	                var rules = this._currentRules();
	                for (var i = 0; i < rules.length; i++) {
	                    tempMatch = this._input.match(this.rules[rules[i]]);
	                    if (tempMatch && (!match || tempMatch[0].length > match[0].length)) {
	                        match = tempMatch;
	                        index = i;
	                        if (!this.options.flex) break;
	                    }
	                }
	                if (match) {
	                    lines = match[0].match(/(?:\r\n?|\n).*/g);
	                    if (lines) this.yylineno += lines.length;
	                    this.yylloc = { first_line: this.yylloc.last_line,
	                        last_line: this.yylineno + 1,
	                        first_column: this.yylloc.last_column,
	                        last_column: lines ? lines[lines.length - 1].length - lines[lines.length - 1].match(/\r?\n?/)[0].length : this.yylloc.last_column + match[0].length };
	                    this.yytext += match[0];
	                    this.match += match[0];
	                    this.matches = match;
	                    this.yyleng = this.yytext.length;
	                    if (this.options.ranges) {
	                        this.yylloc.range = [this.offset, this.offset += this.yyleng];
	                    }
	                    this._more = false;
	                    this._input = this._input.slice(match[0].length);
	                    this.matched += match[0];
	                    token = this.performAction.call(this, this.yy, this, rules[index], this.conditionStack[this.conditionStack.length - 1]);
	                    if (this.done && this._input) this.done = false;
	                    if (token) return token;else return;
	                }
	                if (this._input === "") {
	                    return this.EOF;
	                } else {
	                    return this.parseError('Lexical error on line ' + (this.yylineno + 1) + '. Unrecognized text.\n' + this.showPosition(), { text: "", token: null, line: this.yylineno });
	                }
	            },
	            lex: function lex() {
	                var r = this.next();
	                if (typeof r !== 'undefined') {
	                    return r;
	                } else {
	                    return this.lex();
	                }
	            },
	            begin: function begin(condition) {
	                this.conditionStack.push(condition);
	            },
	            popState: function popState() {
	                return this.conditionStack.pop();
	            },
	            _currentRules: function _currentRules() {
	                return this.conditions[this.conditionStack[this.conditionStack.length - 1]].rules;
	            },
	            topState: function topState() {
	                return this.conditionStack[this.conditionStack.length - 2];
	            },
	            pushState: function begin(condition) {
	                this.begin(condition);
	            } };
	        lexer.options = {};
	        lexer.performAction = function anonymous(yy, yy_, $avoiding_name_collisions, YY_START
	        /**/) {

	            function strip(start, end) {
	                return yy_.yytext = yy_.yytext.substr(start, yy_.yyleng - end);
	            }

	            var YYSTATE = YY_START;
	            switch ($avoiding_name_collisions) {
	                case 0:
	                    if (yy_.yytext.slice(-2) === "\\\\") {
	                        strip(0, 1);
	                        this.begin("mu");
	                    } else if (yy_.yytext.slice(-1) === "\\") {
	                        strip(0, 1);
	                        this.begin("emu");
	                    } else {
	                        this.begin("mu");
	                    }
	                    if (yy_.yytext) return 15;

	                    break;
	                case 1:
	                    return 15;
	                    break;
	                case 2:
	                    this.popState();
	                    return 15;

	                    break;
	                case 3:
	                    this.begin('raw');return 15;
	                    break;
	                case 4:
	                    this.popState();
	                    // Should be using `this.topState()` below, but it currently
	                    // returns the second top instead of the first top. Opened an
	                    // issue about it at https://github.com/zaach/jison/issues/291
	                    if (this.conditionStack[this.conditionStack.length - 1] === 'raw') {
	                        return 15;
	                    } else {
	                        yy_.yytext = yy_.yytext.substr(5, yy_.yyleng - 9);
	                        return 'END_RAW_BLOCK';
	                    }

	                    break;
	                case 5:
	                    return 15;
	                    break;
	                case 6:
	                    this.popState();
	                    return 14;

	                    break;
	                case 7:
	                    return 65;
	                    break;
	                case 8:
	                    return 68;
	                    break;
	                case 9:
	                    return 19;
	                    break;
	                case 10:
	                    this.popState();
	                    this.begin('raw');
	                    return 23;

	                    break;
	                case 11:
	                    return 55;
	                    break;
	                case 12:
	                    return 60;
	                    break;
	                case 13:
	                    return 29;
	                    break;
	                case 14:
	                    return 47;
	                    break;
	                case 15:
	                    this.popState();return 44;
	                    break;
	                case 16:
	                    this.popState();return 44;
	                    break;
	                case 17:
	                    return 34;
	                    break;
	                case 18:
	                    return 39;
	                    break;
	                case 19:
	                    return 51;
	                    break;
	                case 20:
	                    return 48;
	                    break;
	                case 21:
	                    this.unput(yy_.yytext);
	                    this.popState();
	                    this.begin('com');

	                    break;
	                case 22:
	                    this.popState();
	                    return 14;

	                    break;
	                case 23:
	                    return 48;
	                    break;
	                case 24:
	                    return 73;
	                    break;
	                case 25:
	                    return 72;
	                    break;
	                case 26:
	                    return 72;
	                    break;
	                case 27:
	                    return 87;
	                    break;
	                case 28:
	                    // ignore whitespace
	                    break;
	                case 29:
	                    this.popState();return 54;
	                    break;
	                case 30:
	                    this.popState();return 33;
	                    break;
	                case 31:
	                    yy_.yytext = strip(1, 2).replace(/\\"/g, '"');return 80;
	                    break;
	                case 32:
	                    yy_.yytext = strip(1, 2).replace(/\\'/g, "'");return 80;
	                    break;
	                case 33:
	                    return 85;
	                    break;
	                case 34:
	                    return 82;
	                    break;
	                case 35:
	                    return 82;
	                    break;
	                case 36:
	                    return 83;
	                    break;
	                case 37:
	                    return 84;
	                    break;
	                case 38:
	                    return 81;
	                    break;
	                case 39:
	                    return 75;
	                    break;
	                case 40:
	                    return 77;
	                    break;
	                case 41:
	                    return 72;
	                    break;
	                case 42:
	                    yy_.yytext = yy_.yytext.replace(/\\([\\\]])/g, '$1');return 72;
	                    break;
	                case 43:
	                    return 'INVALID';
	                    break;
	                case 44:
	                    return 5;
	                    break;
	            }
	        };
	        lexer.rules = [/^(?:[^\x00]*?(?=(\{\{)))/, /^(?:[^\x00]+)/, /^(?:[^\x00]{2,}?(?=(\{\{|\\\{\{|\\\\\{\{|$)))/, /^(?:\{\{\{\{(?=[^/]))/, /^(?:\{\{\{\{\/[^\s!"#%-,\.\/;->@\[-\^`\{-~]+(?=[=}\s\/.])\}\}\}\})/, /^(?:[^\x00]*?(?=(\{\{\{\{)))/, /^(?:[\s\S]*?--(~)?\}\})/, /^(?:\()/, /^(?:\))/, /^(?:\{\{\{\{)/, /^(?:\}\}\}\})/, /^(?:\{\{(~)?>)/, /^(?:\{\{(~)?#>)/, /^(?:\{\{(~)?#\*?)/, /^(?:\{\{(~)?\/)/, /^(?:\{\{(~)?\^\s*(~)?\}\})/, /^(?:\{\{(~)?\s*else\s*(~)?\}\})/, /^(?:\{\{(~)?\^)/, /^(?:\{\{(~)?\s*else\b)/, /^(?:\{\{(~)?\{)/, /^(?:\{\{(~)?&)/, /^(?:\{\{(~)?!--)/, /^(?:\{\{(~)?![\s\S]*?\}\})/, /^(?:\{\{(~)?\*?)/, /^(?:=)/, /^(?:\.\.)/, /^(?:\.(?=([=~}\s\/.)|])))/, /^(?:[\/.])/, /^(?:\s+)/, /^(?:\}(~)?\}\})/, /^(?:(~)?\}\})/, /^(?:"(\\["]|[^"])*")/, /^(?:'(\\[']|[^'])*')/, /^(?:@)/, /^(?:true(?=([~}\s)])))/, /^(?:false(?=([~}\s)])))/, /^(?:undefined(?=([~}\s)])))/, /^(?:null(?=([~}\s)])))/, /^(?:-?[0-9]+(?:\.[0-9]+)?(?=([~}\s)])))/, /^(?:as\s+\|)/, /^(?:\|)/, /^(?:([^\s!"#%-,\.\/;->@\[-\^`\{-~]+(?=([=~}\s\/.)|]))))/, /^(?:\[(\\\]|[^\]])*\])/, /^(?:.)/, /^(?:$)/];
	        lexer.conditions = { "mu": { "rules": [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44], "inclusive": false }, "emu": { "rules": [2], "inclusive": false }, "com": { "rules": [6], "inclusive": false }, "raw": { "rules": [3, 4, 5], "inclusive": false }, "INITIAL": { "rules": [0, 1, 44], "inclusive": true } };
	        return lexer;
	    })();
	    parser.lexer = lexer;
	    function Parser() {
	        this.yy = {};
	    }Parser.prototype = parser;parser.Parser = Parser;
	    return new Parser();
	})();exports.__esModule = true;
	exports['default'] = handlebars;

/***/ },
/* 16 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(8)['default'];

	exports.__esModule = true;

	var _visitor = __webpack_require__(6);

	var _visitor2 = _interopRequireDefault(_visitor);

	function WhitespaceControl() {
	  var options = arguments.length <= 0 || arguments[0] === undefined ? {} : arguments[0];

	  this.options = options;
	}
	WhitespaceControl.prototype = new _visitor2['default']();

	WhitespaceControl.prototype.Program = function (program) {
	  var doStandalone = !this.options.ignoreStandalone;

	  var isRoot = !this.isRootSeen;
	  this.isRootSeen = true;

	  var body = program.body;
	  for (var i = 0, l = body.length; i < l; i++) {
	    var current = body[i],
	        strip = this.accept(current);

	    if (!strip) {
	      continue;
	    }

	    var _isPrevWhitespace = isPrevWhitespace(body, i, isRoot),
	        _isNextWhitespace = isNextWhitespace(body, i, isRoot),
	        openStandalone = strip.openStandalone && _isPrevWhitespace,
	        closeStandalone = strip.closeStandalone && _isNextWhitespace,
	        inlineStandalone = strip.inlineStandalone && _isPrevWhitespace && _isNextWhitespace;

	    if (strip.close) {
	      omitRight(body, i, true);
	    }
	    if (strip.open) {
	      omitLeft(body, i, true);
	    }

	    if (doStandalone && inlineStandalone) {
	      omitRight(body, i);

	      if (omitLeft(body, i)) {
	        // If we are on a standalone node, save the indent info for partials
	        if (current.type === 'PartialStatement') {
	          // Pull out the whitespace from the final line
	          current.indent = /([ \t]+$)/.exec(body[i - 1].original)[1];
	        }
	      }
	    }
	    if (doStandalone && openStandalone) {
	      omitRight((current.program || current.inverse).body);

	      // Strip out the previous content node if it's whitespace only
	      omitLeft(body, i);
	    }
	    if (doStandalone && closeStandalone) {
	      // Always strip the next node
	      omitRight(body, i);

	      omitLeft((current.inverse || current.program).body);
	    }
	  }

	  return program;
	};

	WhitespaceControl.prototype.BlockStatement = WhitespaceControl.prototype.DecoratorBlock = WhitespaceControl.prototype.PartialBlockStatement = function (block) {
	  this.accept(block.program);
	  this.accept(block.inverse);

	  // Find the inverse program that is involed with whitespace stripping.
	  var program = block.program || block.inverse,
	      inverse = block.program && block.inverse,
	      firstInverse = inverse,
	      lastInverse = inverse;

	  if (inverse && inverse.chained) {
	    firstInverse = inverse.body[0].program;

	    // Walk the inverse chain to find the last inverse that is actually in the chain.
	    while (lastInverse.chained) {
	      lastInverse = lastInverse.body[lastInverse.body.length - 1].program;
	    }
	  }

	  var strip = {
	    open: block.openStrip.open,
	    close: block.closeStrip.close,

	    // Determine the standalone candiacy. Basically flag our content as being possibly standalone
	    // so our parent can determine if we actually are standalone
	    openStandalone: isNextWhitespace(program.body),
	    closeStandalone: isPrevWhitespace((firstInverse || program).body)
	  };

	  if (block.openStrip.close) {
	    omitRight(program.body, null, true);
	  }

	  if (inverse) {
	    var inverseStrip = block.inverseStrip;

	    if (inverseStrip.open) {
	      omitLeft(program.body, null, true);
	    }

	    if (inverseStrip.close) {
	      omitRight(firstInverse.body, null, true);
	    }
	    if (block.closeStrip.open) {
	      omitLeft(lastInverse.body, null, true);
	    }

	    // Find standalone else statments
	    if (!this.options.ignoreStandalone && isPrevWhitespace(program.body) && isNextWhitespace(firstInverse.body)) {
	      omitLeft(program.body);
	      omitRight(firstInverse.body);
	    }
	  } else if (block.closeStrip.open) {
	    omitLeft(program.body, null, true);
	  }

	  return strip;
	};

	WhitespaceControl.prototype.Decorator = WhitespaceControl.prototype.MustacheStatement = function (mustache) {
	  return mustache.strip;
	};

	WhitespaceControl.prototype.PartialStatement = WhitespaceControl.prototype.CommentStatement = function (node) {
	  /* istanbul ignore next */
	  var strip = node.strip || {};
	  return {
	    inlineStandalone: true,
	    open: strip.open,
	    close: strip.close
	  };
	};

	function isPrevWhitespace(body, i, isRoot) {
	  if (i === undefined) {
	    i = body.length;
	  }

	  // Nodes that end with newlines are considered whitespace (but are special
	  // cased for strip operations)
	  var prev = body[i - 1],
	      sibling = body[i - 2];
	  if (!prev) {
	    return isRoot;
	  }

	  if (prev.type === 'ContentStatement') {
	    return (sibling || !isRoot ? /\r?\n\s*?$/ : /(^|\r?\n)\s*?$/).test(prev.original);
	  }
	}
	function isNextWhitespace(body, i, isRoot) {
	  if (i === undefined) {
	    i = -1;
	  }

	  var next = body[i + 1],
	      sibling = body[i + 2];
	  if (!next) {
	    return isRoot;
	  }

	  if (next.type === 'ContentStatement') {
	    return (sibling || !isRoot ? /^\s*?\r?\n/ : /^\s*?(\r?\n|$)/).test(next.original);
	  }
	}

	// Marks the node to the right of the position as omitted.
	// I.e. {{foo}}' ' will mark the ' ' node as omitted.
	//
	// If i is undefined, then the first child will be marked as such.
	//
	// If mulitple is truthy then all whitespace will be stripped out until non-whitespace
	// content is met.
	function omitRight(body, i, multiple) {
	  var current = body[i == null ? 0 : i + 1];
	  if (!current || current.type !== 'ContentStatement' || !multiple && current.rightStripped) {
	    return;
	  }

	  var original = current.value;
	  current.value = current.value.replace(multiple ? /^\s+/ : /^[ \t]*\r?\n?/, '');
	  current.rightStripped = current.value !== original;
	}

	// Marks the node to the left of the position as omitted.
	// I.e. ' '{{foo}} will mark the ' ' node as omitted.
	//
	// If i is undefined then the last child will be marked as such.
	//
	// If mulitple is truthy then all whitespace will be stripped out until non-whitespace
	// content is met.
	function omitLeft(body, i, multiple) {
	  var current = body[i == null ? body.length - 1 : i - 1];
	  if (!current || current.type !== 'ContentStatement' || !multiple && current.leftStripped) {
	    return;
	  }

	  // We omit the last node if it's whitespace only and not preceeded by a non-content node.
	  var original = current.value;
	  current.value = current.value.replace(multiple ? /\s+$/ : /[ \t]+$/, '');
	  current.leftStripped = current.value !== original;
	  return current.leftStripped;
	}

	exports['default'] = WhitespaceControl;
	module.exports = exports['default'];

/***/ },
/* 17 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(8)['default'];

	exports.__esModule = true;
	exports.SourceLocation = SourceLocation;
	exports.id = id;
	exports.stripFlags = stripFlags;
	exports.stripComment = stripComment;
	exports.preparePath = preparePath;
	exports.prepareMustache = prepareMustache;
	exports.prepareRawBlock = prepareRawBlock;
	exports.prepareBlock = prepareBlock;
	exports.prepareProgram = prepareProgram;
	exports.preparePartialBlock = preparePartialBlock;

	var _exception = __webpack_require__(12);

	var _exception2 = _interopRequireDefault(_exception);

	function validateClose(open, close) {
	  close = close.path ? close.path.original : close;

	  if (open.path.original !== close) {
	    var errorNode = { loc: open.path.loc };

	    throw new _exception2['default'](open.path.original + " doesn't match " + close, errorNode);
	  }
	}

	function SourceLocation(source, locInfo) {
	  this.source = source;
	  this.start = {
	    line: locInfo.first_line,
	    column: locInfo.first_column
	  };
	  this.end = {
	    line: locInfo.last_line,
	    column: locInfo.last_column
	  };
	}

	function id(token) {
	  if (/^\[.*\]$/.test(token)) {
	    return token.substr(1, token.length - 2);
	  } else {
	    return token;
	  }
	}

	function stripFlags(open, close) {
	  return {
	    open: open.charAt(2) === '~',
	    close: close.charAt(close.length - 3) === '~'
	  };
	}

	function stripComment(comment) {
	  return comment.replace(/^\{\{~?\!-?-?/, '').replace(/-?-?~?\}\}$/, '');
	}

	function preparePath(data, parts, loc) {
	  loc = this.locInfo(loc);

	  var original = data ? '@' : '',
	      dig = [],
	      depth = 0,
	      depthString = '';

	  for (var i = 0, l = parts.length; i < l; i++) {
	    var part = parts[i].part,

	    // If we have [] syntax then we do not treat path references as operators,
	    // i.e. foo.[this] resolves to approximately context.foo['this']
	    isLiteral = parts[i].original !== part;
	    original += (parts[i].separator || '') + part;

	    if (!isLiteral && (part === '..' || part === '.' || part === 'this')) {
	      if (dig.length > 0) {
	        throw new _exception2['default']('Invalid path: ' + original, { loc: loc });
	      } else if (part === '..') {
	        depth++;
	        depthString += '../';
	      }
	    } else {
	      dig.push(part);
	    }
	  }

	  return {
	    type: 'PathExpression',
	    data: data,
	    depth: depth,
	    parts: dig,
	    original: original,
	    loc: loc
	  };
	}

	function prepareMustache(path, params, hash, open, strip, locInfo) {
	  // Must use charAt to support IE pre-10
	  var escapeFlag = open.charAt(3) || open.charAt(2),
	      escaped = escapeFlag !== '{' && escapeFlag !== '&';

	  var decorator = /\*/.test(open);
	  return {
	    type: decorator ? 'Decorator' : 'MustacheStatement',
	    path: path,
	    params: params,
	    hash: hash,
	    escaped: escaped,
	    strip: strip,
	    loc: this.locInfo(locInfo)
	  };
	}

	function prepareRawBlock(openRawBlock, contents, close, locInfo) {
	  validateClose(openRawBlock, close);

	  locInfo = this.locInfo(locInfo);
	  var program = {
	    type: 'Program',
	    body: contents,
	    strip: {},
	    loc: locInfo
	  };

	  return {
	    type: 'BlockStatement',
	    path: openRawBlock.path,
	    params: openRawBlock.params,
	    hash: openRawBlock.hash,
	    program: program,
	    openStrip: {},
	    inverseStrip: {},
	    closeStrip: {},
	    loc: locInfo
	  };
	}

	function prepareBlock(openBlock, program, inverseAndProgram, close, inverted, locInfo) {
	  if (close && close.path) {
	    validateClose(openBlock, close);
	  }

	  var decorator = /\*/.test(openBlock.open);

	  program.blockParams = openBlock.blockParams;

	  var inverse = undefined,
	      inverseStrip = undefined;

	  if (inverseAndProgram) {
	    if (decorator) {
	      throw new _exception2['default']('Unexpected inverse block on decorator', inverseAndProgram);
	    }

	    if (inverseAndProgram.chain) {
	      inverseAndProgram.program.body[0].closeStrip = close.strip;
	    }

	    inverseStrip = inverseAndProgram.strip;
	    inverse = inverseAndProgram.program;
	  }

	  if (inverted) {
	    inverted = inverse;
	    inverse = program;
	    program = inverted;
	  }

	  return {
	    type: decorator ? 'DecoratorBlock' : 'BlockStatement',
	    path: openBlock.path,
	    params: openBlock.params,
	    hash: openBlock.hash,
	    program: program,
	    inverse: inverse,
	    openStrip: openBlock.strip,
	    inverseStrip: inverseStrip,
	    closeStrip: close && close.strip,
	    loc: this.locInfo(locInfo)
	  };
	}

	function prepareProgram(statements, loc) {
	  if (!loc && statements.length) {
	    var firstLoc = statements[0].loc,
	        lastLoc = statements[statements.length - 1].loc;

	    /* istanbul ignore else */
	    if (firstLoc && lastLoc) {
	      loc = {
	        source: firstLoc.source,
	        start: {
	          line: firstLoc.start.line,
	          column: firstLoc.start.column
	        },
	        end: {
	          line: lastLoc.end.line,
	          column: lastLoc.end.column
	        }
	      };
	    }
	  }

	  return {
	    type: 'Program',
	    body: statements,
	    strip: {},
	    loc: loc
	  };
	}

	function preparePartialBlock(open, program, close, locInfo) {
	  validateClose(open, close);

	  return {
	    type: 'PartialBlockStatement',
	    name: open.path,
	    params: open.params,
	    hash: open.hash,
	    program: program,
	    openStrip: open.strip,
	    closeStrip: close && close.strip,
	    loc: this.locInfo(locInfo)
	  };
	}

/***/ },
/* 18 */
/***/ function(module, exports, __webpack_require__) {

	/* global define */
	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(13);

	var SourceNode = undefined;

	try {
	  /* istanbul ignore next */
	  if (false) {
	    // We don't support this in AMD environments. For these environments, we asusme that
	    // they are running on the browser and thus have no need for the source-map library.
	    var SourceMap = require('source-map');
	    SourceNode = SourceMap.SourceNode;
	  }
	} catch (err) {}
	/* NOP */

	/* istanbul ignore if: tested but not covered in istanbul due to dist build  */
	if (!SourceNode) {
	  SourceNode = function (line, column, srcFile, chunks) {
	    this.src = '';
	    if (chunks) {
	      this.add(chunks);
	    }
	  };
	  /* istanbul ignore next */
	  SourceNode.prototype = {
	    add: function add(chunks) {
	      if (_utils.isArray(chunks)) {
	        chunks = chunks.join('');
	      }
	      this.src += chunks;
	    },
	    prepend: function prepend(chunks) {
	      if (_utils.isArray(chunks)) {
	        chunks = chunks.join('');
	      }
	      this.src = chunks + this.src;
	    },
	    toStringWithSourceMap: function toStringWithSourceMap() {
	      return { code: this.toString() };
	    },
	    toString: function toString() {
	      return this.src;
	    }
	  };
	}

	function castChunk(chunk, codeGen, loc) {
	  if (_utils.isArray(chunk)) {
	    var ret = [];

	    for (var i = 0, len = chunk.length; i < len; i++) {
	      ret.push(codeGen.wrap(chunk[i], loc));
	    }
	    return ret;
	  } else if (typeof chunk === 'boolean' || typeof chunk === 'number') {
	    // Handle primitives that the SourceNode will throw up on
	    return chunk + '';
	  }
	  return chunk;
	}

	function CodeGen(srcFile) {
	  this.srcFile = srcFile;
	  this.source = [];
	}

	CodeGen.prototype = {
	  isEmpty: function isEmpty() {
	    return !this.source.length;
	  },
	  prepend: function prepend(source, loc) {
	    this.source.unshift(this.wrap(source, loc));
	  },
	  push: function push(source, loc) {
	    this.source.push(this.wrap(source, loc));
	  },

	  merge: function merge() {
	    var source = this.empty();
	    this.each(function (line) {
	      source.add(['  ', line, '\n']);
	    });
	    return source;
	  },

	  each: function each(iter) {
	    for (var i = 0, len = this.source.length; i < len; i++) {
	      iter(this.source[i]);
	    }
	  },

	  empty: function empty() {
	    var loc = this.currentLocation || { start: {} };
	    return new SourceNode(loc.start.line, loc.start.column, this.srcFile);
	  },
	  wrap: function wrap(chunk) {
	    var loc = arguments.length <= 1 || arguments[1] === undefined ? this.currentLocation || { start: {} } : arguments[1];

	    if (chunk instanceof SourceNode) {
	      return chunk;
	    }

	    chunk = castChunk(chunk, this, loc);

	    return new SourceNode(loc.start.line, loc.start.column, this.srcFile, chunk);
	  },

	  functionCall: function functionCall(fn, type, params) {
	    params = this.generateList(params);
	    return this.wrap([fn, type ? '.' + type + '(' : '(', params, ')']);
	  },

	  quotedString: function quotedString(str) {
	    return '"' + (str + '').replace(/\\/g, '\\\\').replace(/"/g, '\\"').replace(/\n/g, '\\n').replace(/\r/g, '\\r').replace(/\u2028/g, '\\u2028') // Per Ecma-262 7.3 + 7.8.4
	    .replace(/\u2029/g, '\\u2029') + '"';
	  },

	  objectLiteral: function objectLiteral(obj) {
	    var pairs = [];

	    for (var key in obj) {
	      if (obj.hasOwnProperty(key)) {
	        var value = castChunk(obj[key], this);
	        if (value !== 'undefined') {
	          pairs.push([this.quotedString(key), ':', value]);
	        }
	      }
	    }

	    var ret = this.generateList(pairs);
	    ret.prepend('{');
	    ret.add('}');
	    return ret;
	  },

	  generateList: function generateList(entries) {
	    var ret = this.empty();

	    for (var i = 0, len = entries.length; i < len; i++) {
	      if (i) {
	        ret.add(',');
	      }

	      ret.add(castChunk(entries[i], this));
	    }

	    return ret;
	  },

	  generateArray: function generateArray(entries) {
	    var ret = this.generateList(entries);
	    ret.prepend('[');
	    ret.add(']');

	    return ret;
	  }
	};

	exports['default'] = CodeGen;
	module.exports = exports['default'];

/***/ },
/* 19 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(8)['default'];

	exports.__esModule = true;
	exports.registerDefaultHelpers = registerDefaultHelpers;

	var _helpersBlockHelperMissing = __webpack_require__(22);

	var _helpersBlockHelperMissing2 = _interopRequireDefault(_helpersBlockHelperMissing);

	var _helpersEach = __webpack_require__(23);

	var _helpersEach2 = _interopRequireDefault(_helpersEach);

	var _helpersHelperMissing = __webpack_require__(24);

	var _helpersHelperMissing2 = _interopRequireDefault(_helpersHelperMissing);

	var _helpersIf = __webpack_require__(25);

	var _helpersIf2 = _interopRequireDefault(_helpersIf);

	var _helpersLog = __webpack_require__(26);

	var _helpersLog2 = _interopRequireDefault(_helpersLog);

	var _helpersLookup = __webpack_require__(27);

	var _helpersLookup2 = _interopRequireDefault(_helpersLookup);

	var _helpersWith = __webpack_require__(28);

	var _helpersWith2 = _interopRequireDefault(_helpersWith);

	function registerDefaultHelpers(instance) {
	  _helpersBlockHelperMissing2['default'](instance);
	  _helpersEach2['default'](instance);
	  _helpersHelperMissing2['default'](instance);
	  _helpersIf2['default'](instance);
	  _helpersLog2['default'](instance);
	  _helpersLookup2['default'](instance);
	  _helpersWith2['default'](instance);
	}

/***/ },
/* 20 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(8)['default'];

	exports.__esModule = true;
	exports.registerDefaultDecorators = registerDefaultDecorators;

	var _decoratorsInline = __webpack_require__(29);

	var _decoratorsInline2 = _interopRequireDefault(_decoratorsInline);

	function registerDefaultDecorators(instance) {
	  _decoratorsInline2['default'](instance);
	}

/***/ },
/* 21 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(13);

	var logger = {
	  methodMap: ['debug', 'info', 'warn', 'error'],
	  level: 'info',

	  // Maps a given level value to the `methodMap` indexes above.
	  lookupLevel: function lookupLevel(level) {
	    if (typeof level === 'string') {
	      var levelMap = _utils.indexOf(logger.methodMap, level.toLowerCase());
	      if (levelMap >= 0) {
	        level = levelMap;
	      } else {
	        level = parseInt(level, 10);
	      }
	    }

	    return level;
	  },

	  // Can be overridden in the host environment
	  log: function log(level) {
	    level = logger.lookupLevel(level);

	    if (typeof console !== 'undefined' && logger.lookupLevel(logger.level) <= level) {
	      var method = logger.methodMap[level];
	      if (!console[method]) {
	        // eslint-disable-line no-console
	        method = 'log';
	      }

	      for (var _len = arguments.length, message = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
	        message[_key - 1] = arguments[_key];
	      }

	      console[method].apply(console, message); // eslint-disable-line no-console
	    }
	  }
	};

	exports['default'] = logger;
	module.exports = exports['default'];

/***/ },
/* 22 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(13);

	exports['default'] = function (instance) {
	  instance.registerHelper('blockHelperMissing', function (context, options) {
	    var inverse = options.inverse,
	        fn = options.fn;

	    if (context === true) {
	      return fn(this);
	    } else if (context === false || context == null) {
	      return inverse(this);
	    } else if (_utils.isArray(context)) {
	      if (context.length > 0) {
	        if (options.ids) {
	          options.ids = [options.name];
	        }

	        return instance.helpers.each(context, options);
	      } else {
	        return inverse(this);
	      }
	    } else {
	      if (options.data && options.ids) {
	        var data = _utils.createFrame(options.data);
	        data.contextPath = _utils.appendContextPath(options.data.contextPath, options.name);
	        options = { data: data };
	      }

	      return fn(context, options);
	    }
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 23 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(8)['default'];

	exports.__esModule = true;

	var _utils = __webpack_require__(13);

	var _exception = __webpack_require__(12);

	var _exception2 = _interopRequireDefault(_exception);

	exports['default'] = function (instance) {
	  instance.registerHelper('each', function (context, options) {
	    if (!options) {
	      throw new _exception2['default']('Must pass iterator to #each');
	    }

	    var fn = options.fn,
	        inverse = options.inverse,
	        i = 0,
	        ret = '',
	        data = undefined,
	        contextPath = undefined;

	    if (options.data && options.ids) {
	      contextPath = _utils.appendContextPath(options.data.contextPath, options.ids[0]) + '.';
	    }

	    if (_utils.isFunction(context)) {
	      context = context.call(this);
	    }

	    if (options.data) {
	      data = _utils.createFrame(options.data);
	    }

	    function execIteration(field, index, last) {
	      if (data) {
	        data.key = field;
	        data.index = index;
	        data.first = index === 0;
	        data.last = !!last;

	        if (contextPath) {
	          data.contextPath = contextPath + field;
	        }
	      }

	      ret = ret + fn(context[field], {
	        data: data,
	        blockParams: _utils.blockParams([context[field], field], [contextPath + field, null])
	      });
	    }

	    if (context && typeof context === 'object') {
	      if (_utils.isArray(context)) {
	        for (var j = context.length; i < j; i++) {
	          if (i in context) {
	            execIteration(i, i, i === context.length - 1);
	          }
	        }
	      } else {
	        var priorKey = undefined;

	        for (var key in context) {
	          if (context.hasOwnProperty(key)) {
	            // We're running the iterations one step out of sync so we can detect
	            // the last iteration without have to scan the object twice and create
	            // an itermediate keys array.
	            if (priorKey !== undefined) {
	              execIteration(priorKey, i - 1);
	            }
	            priorKey = key;
	            i++;
	          }
	        }
	        if (priorKey !== undefined) {
	          execIteration(priorKey, i - 1, true);
	        }
	      }
	    }

	    if (i === 0) {
	      ret = inverse(this);
	    }

	    return ret;
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 24 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(8)['default'];

	exports.__esModule = true;

	var _exception = __webpack_require__(12);

	var _exception2 = _interopRequireDefault(_exception);

	exports['default'] = function (instance) {
	  instance.registerHelper('helperMissing', function () /* [args, ]options */{
	    if (arguments.length === 1) {
	      // A missing field in a {{foo}} construct.
	      return undefined;
	    } else {
	      // Someone is actually trying to call something, blow up.
	      throw new _exception2['default']('Missing helper: "' + arguments[arguments.length - 1].name + '"');
	    }
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 25 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(13);

	exports['default'] = function (instance) {
	  instance.registerHelper('if', function (conditional, options) {
	    if (_utils.isFunction(conditional)) {
	      conditional = conditional.call(this);
	    }

	    // Default behavior is to render the positive path if the value is truthy and not empty.
	    // The `includeZero` option may be set to treat the condtional as purely not empty based on the
	    // behavior of isEmpty. Effectively this determines if 0 is handled by the positive path or negative.
	    if (!options.hash.includeZero && !conditional || _utils.isEmpty(conditional)) {
	      return options.inverse(this);
	    } else {
	      return options.fn(this);
	    }
	  });

	  instance.registerHelper('unless', function (conditional, options) {
	    return instance.helpers['if'].call(this, conditional, { fn: options.inverse, inverse: options.fn, hash: options.hash });
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 26 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	exports['default'] = function (instance) {
	  instance.registerHelper('log', function () /* message, options */{
	    var args = [undefined],
	        options = arguments[arguments.length - 1];
	    for (var i = 0; i < arguments.length - 1; i++) {
	      args.push(arguments[i]);
	    }

	    var level = 1;
	    if (options.hash.level != null) {
	      level = options.hash.level;
	    } else if (options.data && options.data.level != null) {
	      level = options.data.level;
	    }
	    args[0] = level;

	    instance.log.apply(instance, args);
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 27 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	exports['default'] = function (instance) {
	  instance.registerHelper('lookup', function (obj, field) {
	    return obj && obj[field];
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 28 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(13);

	exports['default'] = function (instance) {
	  instance.registerHelper('with', function (context, options) {
	    if (_utils.isFunction(context)) {
	      context = context.call(this);
	    }

	    var fn = options.fn;

	    if (!_utils.isEmpty(context)) {
	      var data = options.data;
	      if (options.data && options.ids) {
	        data = _utils.createFrame(options.data);
	        data.contextPath = _utils.appendContextPath(options.data.contextPath, options.ids[0]);
	      }

	      return fn(context, {
	        data: data,
	        blockParams: _utils.blockParams([context], [data && data.contextPath])
	      });
	    } else {
	      return options.inverse(this);
	    }
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 29 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(13);

	exports['default'] = function (instance) {
	  instance.registerDecorator('inline', function (fn, props, container, options) {
	    var ret = fn;
	    if (!props.partials) {
	      props.partials = {};
	      ret = function (context, options) {
	        // Create a new partials stack frame prior to exec.
	        var original = container.partials;
	        container.partials = _utils.extend({}, original, props.partials);
	        var ret = fn(context, options);
	        container.partials = original;
	        return ret;
	      };
	    }

	    props.partials[options.args[0]] = options.fn;

	    return ret;
	  });
	};

	module.exports = exports['default'];

/***/ }
/******/ ])
});
;
(function ($, undefined) {
    //Template cache
    var templates = {};
    $.templateload = function (obj, url) {
        if (url === undefined) {
            //Declaring template(s)
            if (typeof obj === "object") {
                if (obj.length) {
                    //Array of declaration objects
                    for (var i = 0; i < obj.length; i++) {
                        templates[obj[i].name] = obj[i].url;
                    }
                } else {
                    //A single declaration object
                    templates[obj.name] = obj.url;
                }
            }
            //Loading the template
            else if (typeof obj === "string") {
                if (typeof templates[obj] === "string") {
                    //The template hasn't been loaded yet
                    return templates[obj] = $.Deferred(function (dfd) {
                        $.get(templates[obj]).done(function (d) {
                            dfd.resolve({ html: function () { return d} });
                        }).fail(function (d) {
                            dfd.reject(d);
                        });
                    }).promise();
                } else {
                    //The template has already been cached
                    return templates[obj];
                }
            }
            //Declaring a single template
        } else {
            templates[obj] = url;
        }
    };

    Handlebars.registerHelper('url', function (path,param) {
        if(Common.base_url){
            return new Handlebars.SafeString(Common.base_url(path+param));
        }else{
            return new Handlebars.SafeString(path+param);
        }
    });

    Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {
        switch (operator) {
            case '==':
                return (v1 == v2) ? options.fn(this) : options.inverse(this);
            case '!=':
                return (v1 != v2) ? options.fn(this) : options.inverse(this);
            case '===':
                return (v1 === v2) ? options.fn(this) : options.inverse(this);
            case '<':
                return (v1 < v2) ? options.fn(this) : options.inverse(this);
            case '<=':
                return (v1 <= v2) ? options.fn(this) : options.inverse(this);
            case '>':
                return (v1 > v2) ? options.fn(this) : options.inverse(this);
            case '>=':
                return (v1 >= v2) ? options.fn(this) : options.inverse(this);
            case '&&':
                return (v1 && v2) ? options.fn(this) : options.inverse(this);
            case '||':
                return (v1 || v2) ? options.fn(this) : options.inverse(this);
            default:
                return options.inverse(this);
        }
    });


})(jQuery);

/**
 * Created by sanitkeawtawan on 10/6/2015 AD.
 */

/**
 * jQuery serializeObject
 * @copyright 2014, macek <paulmacek@gmail.com>
 * @link https://github.com/macek/jquery-serialize-object
 * @license BSD
 * @version 2.4.5
 */
(function(root, factory) {

    // AMD
    if (typeof define === "function" && define.amd) {
        define(["exports", "jquery"], function(exports, $) {
            return factory(exports, $);
        });
    }

    // CommonJS
    else if (typeof exports !== "undefined") {
        var $ = require("jquery");
        factory(exports, $);
    }

    // Browser
    else {
        factory(root, (root.jQuery || root.Zepto || root.ender || root.$));
    }

}(this, function(exports, $) {

    var patterns = {
        validate: /^[a-z_][a-z0-9_]*(?:\[(?:\d*|[a-z0-9_]+)\])*$/i,
        key:      /[a-z0-9_]+|(?=\[\])/gi,
        push:     /^$/,
        fixed:    /^\d+$/,
        named:    /^[a-z0-9_]+$/i
    };

    function FormSerializer(helper, $form) {

        // private variables
        var data     = {},
            pushes   = {};

        // private API
        function build(base, key, value) {
            base[key] = value;
            return base;
        }

        function makeObject(root, value) {

            var keys = root.match(patterns.key), k;

            // nest, nest, ..., nest
            while ((k = keys.pop()) !== undefined) {
                // foo[]
                if (patterns.push.test(k)) {
                    var idx = incrementPush(root.replace(/\[\]$/, ''));
                    value = build([], idx, value);
                }

                // foo[n]
                else if (patterns.fixed.test(k)) {
                    value = build([], k, value);
                }

                // foo; foo[bar]
                else if (patterns.named.test(k)) {
                    value = build({}, k, value);
                }
            }

            return value;
        }

        function incrementPush(key) {
            if (pushes[key] === undefined) {
                pushes[key] = 0;
            }
            return pushes[key]++;
        }

        function encode(pair) {
            switch ($('[name="' + pair.name + '"]', $form).attr("type")) {
                case "checkbox":
                    return pair.value === "on" ? true : pair.value;
                default:
                    return pair.value;
            }
        }

        function addPair(pair) {
            if (!patterns.validate.test(pair.name)) return this;
            var obj = makeObject(pair.name, encode(pair));
            data = helper.extend(true, data, obj);
            return this;
        }

        function addPairs(pairs) {
            if (!helper.isArray(pairs)) {
                throw new Error("formSerializer.addPairs expects an Array");
            }
            for (var i=0, len=pairs.length; i<len; i++) {
                this.addPair(pairs[i]);
            }
            return this;
        }

        function serialize() {
            return data;
        }

        function serializeJSON() {
            return JSON.stringify(serialize());
        }

        // public API
        this.addPair = addPair;
        this.addPairs = addPairs;
        this.serialize = serialize;
        this.serializeJSON = serializeJSON;
    }

    FormSerializer.patterns = patterns;

    FormSerializer.serializeObject = function serializeObject() {
        if (this.length > 1) {
            return new Error("jquery-serialize-object can only serialize one form at a time");
        }
        return new FormSerializer($, this).
            addPairs(this.serializeArray()).
            serialize();
    };

    FormSerializer.serializeJSON = function serializeJSON() {
        if (this.length > 1) {
            return new Error("jquery-serialize-object can only serialize one form at a time");
        }
        return new FormSerializer($, this).
            addPairs(this.serializeArray()).
            serializeJSON();
    };

    if (typeof $.fn !== "undefined") {
        $.fn.serializeObject = FormSerializer.serializeObject;
        $.fn.serializeJSON   = FormSerializer.serializeJSON;
    }

    exports.FormSerializer = FormSerializer;

    return FormSerializer;
}));


var waitingDialog = waitingDialog || (function ($) {
        'use strict';

        // Creating modal dialog's DOM
        var $dialog = $(
            '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
            '<div class="modal-dialog  modal-md">' +
            '<div class="modal-content">' +
            '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
            '<div class="modal-body"><div class="body-content"></div>' +
            '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
            '</div>' +
            '</div></div></div>');

        return {
            /**
             * Opens our dialog
             * @param message Custom message
             * @param options Custom options:
             * 				  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
             * 				  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
             */
            show: function (message, options) {
                // Assigning defaults
                if (typeof options === 'undefined') {
                    options = {};
                }
                if (typeof message === 'undefined') {
                    message = 'Loading';
                }
                var settings = $.extend({
                    dialogSize: 'm',
                    progressType: '',
                    onHide: null // This callback runs after the dialog was hidden
                }, options);

                // Configuring dialog
                $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
                $dialog.find('.progress-bar').attr('class', 'progress-bar');
                if (settings.progressType) {
                    $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
                }
                $dialog.find('h3').text(message);
                if(typeof options.content !="undefined"){
                    $dialog.find('.body-content').html(options.content);
                }

                // Adding callbacks
                if (typeof settings.onHide === 'function') {
                    $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
                        settings.onHide.call($dialog);
                    });
                }
                // Opening dialog
                $dialog.modal();
            },
            /**
             * Closes dialog
             */
            hide: function () {
                $dialog.modal('hide');
            }
        };

    })(jQuery);




var Common = function () {
    return {
        init: function () {
        
        },
        waitingDialog: {
            show: function (message, option) {
                option = $.extend({
                    dialogSize: 'sm', progressType: 'warning'
                }, option);
                waitingDialog.show(message, option);
            },
            hide: function () {
                waitingDialog.hide();
            }
        },
        base_url: function (path) {
            //Common.base_url('')
            if(typeof path==="undefined"){path="";}
            var url = location.href;  // entire url including querystring - also: window.location.href;
            var host=location.origin;
            var baseURL = host;

            if (baseURL.indexOf('http://localhost') != -1) {
                // Base Url for localhost
                url = location.href;  // window.location.href;
                var pathname = location.pathname;  // window.location.pathname;
                var index1 = url.indexOf(pathname);
                var index2 = url.indexOf("/", index1 + 1);
                var baseLocalUrl = url.substr(0, index2);
                return baseLocalUrl + "/" + path;
            }
            else {
                // Root Url for domain name
              // return baseURL + "/project/hrdi/" + path;
                return baseURL + "/" + path;
            }
        },
    }
}();
$(document).ready(function () {
    Common.init();
});
/**
 * sifter.js
 * Copyright (c) 2013 Brian Reavis & contributors
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this
 * file except in compliance with the License. You may obtain a copy of the License at:
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under
 * the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF
 * ANY KIND, either express or implied. See the License for the specific language
 * governing permissions and limitations under the License.
 *
 * @author Brian Reavis <brian@thirdroute.com>
 */

(function(root, factory) {
	if (typeof define === 'function' && define.amd) {
		define('sifter', factory);
	} else if (typeof exports === 'object') {
		module.exports = factory();
	} else {
		root.Sifter = factory();
	}
}(this, function() {

	/**
	 * Textually searches arrays and hashes of objects
	 * by property (or multiple properties). Designed
	 * specifically for autocomplete.
	 *
	 * @constructor
	 * @param {array|object} items
	 * @param {object} items
	 */
	var Sifter = function(items, settings) {
		this.items = items;
		this.settings = settings || {diacritics: true};
	};

	/**
	 * Splits a search string into an array of individual
	 * regexps to be used to match results.
	 *
	 * @param {string} query
	 * @returns {array}
	 */
	Sifter.prototype.tokenize = function(query) {
		query = trim(String(query || '').toLowerCase());
		if (!query || !query.length) return [];

		var i, n, regex, letter;
		var tokens = [];
		var words = query.split(/ +/);

		for (i = 0, n = words.length; i < n; i++) {
			regex = escape_regex(words[i]);
			if (this.settings.diacritics) {
				for (letter in DIACRITICS) {
					if (DIACRITICS.hasOwnProperty(letter)) {
						regex = regex.replace(new RegExp(letter, 'g'), DIACRITICS[letter]);
					}
				}
			}
			tokens.push({
				string : words[i],
				regex  : new RegExp(regex, 'i')
			});
		}

		return tokens;
	};

	/**
	 * Iterates over arrays and hashes.
	 *
	 * ```
	 * this.iterator(this.items, function(item, id) {
	 *    // invoked for each item
	 * });
	 * ```
	 *
	 * @param {array|object} object
	 */
	Sifter.prototype.iterator = function(object, callback) {
		var iterator;
		if (is_array(object)) {
			iterator = Array.prototype.forEach || function(callback) {
				for (var i = 0, n = this.length; i < n; i++) {
					callback(this[i], i, this);
				}
			};
		} else {
			iterator = function(callback) {
				for (var key in this) {
					if (this.hasOwnProperty(key)) {
						callback(this[key], key, this);
					}
				}
			};
		}

		iterator.apply(object, [callback]);
	};

	/**
	 * Returns a function to be used to score individual results.
	 *
	 * Good matches will have a higher score than poor matches.
	 * If an item is not a match, 0 will be returned by the function.
	 *
	 * @param {object|string} search
	 * @param {object} options (optional)
	 * @returns {function}
	 */
	Sifter.prototype.getScoreFunction = function(search, options) {
		var self, fields, tokens, token_count, nesting;

		self        = this;
		search      = self.prepareSearch(search, options);
		tokens      = search.tokens;
		fields      = search.options.fields;
		token_count = tokens.length;
		nesting     = search.options.nesting;

		/**
		 * Calculates how close of a match the
		 * given value is against a search token.
		 *
		 * @param {mixed} value
		 * @param {object} token
		 * @return {number}
		 */
		var scoreValue = function(value, token) {
			var score, pos;

			if (!value) return 0;
			value = String(value || '');
			pos = value.search(token.regex);
			if (pos === -1) return 0;
			score = token.string.length / value.length;
			if (pos === 0) score += 0.5;
			return score;
		};

		/**
		 * Calculates the score of an object
		 * against the search query.
		 *
		 * @param {object} token
		 * @param {object} data
		 * @return {number}
		 */
		var scoreObject = (function() {
			var field_count = fields.length;
			if (!field_count) {
				return function() { return 0; };
			}
			if (field_count === 1) {
				return function(token, data) {
					return scoreValue(getattr(data, fields[0], nesting), token);
				};
			}
			return function(token, data) {
				for (var i = 0, sum = 0; i < field_count; i++) {
					sum += scoreValue(getattr(data, fields[i], nesting), token);
				}
				return sum / field_count;
			};
		})();

		if (!token_count) {
			return function() { return 0; };
		}
		if (token_count === 1) {
			return function(data) {
				return scoreObject(tokens[0], data);
			};
		}

		if (search.options.conjunction === 'and') {
			return function(data) {
				var score;
				for (var i = 0, sum = 0; i < token_count; i++) {
					score = scoreObject(tokens[i], data);
					if (score <= 0) return 0;
					sum += score;
				}
				return sum / token_count;
			};
		} else {
			return function(data) {
				for (var i = 0, sum = 0; i < token_count; i++) {
					sum += scoreObject(tokens[i], data);
				}
				return sum / token_count;
			};
		}
	};

	/**
	 * Returns a function that can be used to compare two
	 * results, for sorting purposes. If no sorting should
	 * be performed, `null` will be returned.
	 *
	 * @param {string|object} search
	 * @param {object} options
	 * @return function(a,b)
	 */
	Sifter.prototype.getSortFunction = function(search, options) {
		var i, n, self, field, fields, fields_count, multiplier, multipliers, get_field, implicit_score, sort;

		self   = this;
		search = self.prepareSearch(search, options);
		sort   = (!search.query && options.sort_empty) || options.sort;

		/**
		 * Fetches the specified sort field value
		 * from a search result item.
		 *
		 * @param  {string} name
		 * @param  {object} result
		 * @return {mixed}
		 */
		get_field = function(name, result) {
			if (name === '$score') return result.score;
			return getattr(self.items[result.id], name, options.nesting);
		};

		// parse options
		fields = [];
		if (sort) {
			for (i = 0, n = sort.length; i < n; i++) {
				if (search.query || sort[i].field !== '$score') {
					fields.push(sort[i]);
				}
			}
		}

		// the "$score" field is implied to be the primary
		// sort field, unless it's manually specified
		if (search.query) {
			implicit_score = true;
			for (i = 0, n = fields.length; i < n; i++) {
				if (fields[i].field === '$score') {
					implicit_score = false;
					break;
				}
			}
			if (implicit_score) {
				fields.unshift({field: '$score', direction: 'desc'});
			}
		} else {
			for (i = 0, n = fields.length; i < n; i++) {
				if (fields[i].field === '$score') {
					fields.splice(i, 1);
					break;
				}
			}
		}

		multipliers = [];
		for (i = 0, n = fields.length; i < n; i++) {
			multipliers.push(fields[i].direction === 'desc' ? -1 : 1);
		}

		// build function
		fields_count = fields.length;
		if (!fields_count) {
			return null;
		} else if (fields_count === 1) {
			field = fields[0].field;
			multiplier = multipliers[0];
			return function(a, b) {
				return multiplier * cmp(
					get_field(field, a),
					get_field(field, b)
				);
			};
		} else {
			return function(a, b) {
				var i, result, a_value, b_value, field;
				for (i = 0; i < fields_count; i++) {
					field = fields[i].field;
					result = multipliers[i] * cmp(
						get_field(field, a),
						get_field(field, b)
					);
					if (result) return result;
				}
				return 0;
			};
		}
	};

	/**
	 * Parses a search query and returns an object
	 * with tokens and fields ready to be populated
	 * with results.
	 *
	 * @param {string} query
	 * @param {object} options
	 * @returns {object}
	 */
	Sifter.prototype.prepareSearch = function(query, options) {
		if (typeof query === 'object') return query;

		options = extend({}, options);

		var option_fields     = options.fields;
		var option_sort       = options.sort;
		var option_sort_empty = options.sort_empty;

		if (option_fields && !is_array(option_fields)) options.fields = [option_fields];
		if (option_sort && !is_array(option_sort)) options.sort = [option_sort];
		if (option_sort_empty && !is_array(option_sort_empty)) options.sort_empty = [option_sort_empty];

		return {
			options : options,
			query   : String(query || '').toLowerCase(),
			tokens  : this.tokenize(query),
			total   : 0,
			items   : []
		};
	};

	/**
	 * Searches through all items and returns a sorted array of matches.
	 *
	 * The `options` parameter can contain:
	 *
	 *   - fields {string|array}
	 *   - sort {array}
	 *   - score {function}
	 *   - filter {bool}
	 *   - limit {integer}
	 *
	 * Returns an object containing:
	 *
	 *   - options {object}
	 *   - query {string}
	 *   - tokens {array}
	 *   - total {int}
	 *   - items {array}
	 *
	 * @param {string} query
	 * @param {object} options
	 * @returns {object}
	 */
	Sifter.prototype.search = function(query, options) {
		var self = this, value, score, search, calculateScore;
		var fn_sort;
		var fn_score;

		search  = this.prepareSearch(query, options);
		options = search.options;
		query   = search.query;

		// generate result scoring function
		fn_score = options.score || self.getScoreFunction(search);

		// perform search and sort
		if (query.length) {
			self.iterator(self.items, function(item, id) {
				score = fn_score(item);
				if (options.filter === false || score > 0) {
					search.items.push({'score': score, 'id': id});
				}
			});
		} else {
			self.iterator(self.items, function(item, id) {
				search.items.push({'score': 1, 'id': id});
			});
		}

		fn_sort = self.getSortFunction(search, options);
		if (fn_sort) search.items.sort(fn_sort);

		// apply limits
		search.total = search.items.length;
		if (typeof options.limit === 'number') {
			search.items = search.items.slice(0, options.limit);
		}

		return search;
	};

	// utilities
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	var cmp = function(a, b) {
		if (typeof a === 'number' && typeof b === 'number') {
			return a > b ? 1 : (a < b ? -1 : 0);
		}
		a = asciifold(String(a || ''));
		b = asciifold(String(b || ''));
		if (a > b) return 1;
		if (b > a) return -1;
		return 0;
	};

	var extend = function(a, b) {
		var i, n, k, object;
		for (i = 1, n = arguments.length; i < n; i++) {
			object = arguments[i];
			if (!object) continue;
			for (k in object) {
				if (object.hasOwnProperty(k)) {
					a[k] = object[k];
				}
			}
		}
		return a;
	};

	/**
	 * A property getter resolving dot-notation
	 * @param  {Object}  obj     The root object to fetch property on
	 * @param  {String}  name    The optionally dotted property name to fetch
	 * @param  {Boolean} nesting Handle nesting or not
	 * @return {Object}          The resolved property value
	 */
	var getattr = function(obj, name, nesting) {
	    if (!obj || !name) return;
	    if (!nesting) return obj[name];
	    var names = name.split(".");
	    while(names.length && (obj = obj[names.shift()]));
	    return obj;
	};

	var trim = function(str) {
		return (str + '').replace(/^\s+|\s+$|/g, '');
	};

	var escape_regex = function(str) {
		return (str + '').replace(/([.?*+^$[\]\\(){}|-])/g, '\\$1');
	};

	var is_array = Array.isArray || (typeof $ !== 'undefined' && $.isArray) || function(object) {
		return Object.prototype.toString.call(object) === '[object Array]';
	};

	var DIACRITICS = {
		'a': '[aḀḁĂăÂâǍǎȺⱥȦȧẠạÄäÀàÁáĀāÃãÅåąĄÃąĄ]',
		'b': '[b␢βΒB฿𐌁ᛒ]',
		'c': '[cĆćĈĉČčĊċC̄c̄ÇçḈḉȻȼƇƈɕᴄＣｃ]',
		'd': '[dĎďḊḋḐḑḌḍḒḓḎḏĐđD̦d̦ƉɖƊɗƋƌᵭᶁᶑȡᴅＤｄð]',
		'e': '[eÉéÈèÊêḘḙĚěĔĕẼẽḚḛẺẻĖėËëĒēȨȩĘęᶒɆɇȄȅẾếỀềỄễỂểḜḝḖḗḔḕȆȇẸẹỆệⱸᴇＥｅɘǝƏƐε]',
		'f': '[fƑƒḞḟ]',
		'g': '[gɢ₲ǤǥĜĝĞğĢģƓɠĠġ]',
		'h': '[hĤĥĦħḨḩẖẖḤḥḢḣɦʰǶƕ]',
		'i': '[iÍíÌìĬĭÎîǏǐÏïḮḯĨĩĮįĪīỈỉȈȉȊȋỊịḬḭƗɨɨ̆ᵻᶖİiIıɪＩｉ]',
		'j': '[jȷĴĵɈɉʝɟʲ]',
		'k': '[kƘƙꝀꝁḰḱǨǩḲḳḴḵκϰ₭]',
		'l': '[lŁłĽľĻļĹĺḶḷḸḹḼḽḺḻĿŀȽƚⱠⱡⱢɫɬᶅɭȴʟＬｌ]',
		'n': '[nŃńǸǹŇňÑñṄṅŅņṆṇṊṋṈṉN̈n̈ƝɲȠƞᵰᶇɳȵɴＮｎŊŋ]',
		'o': '[oØøÖöÓóÒòÔôǑǒŐőŎŏȮȯỌọƟɵƠơỎỏŌōÕõǪǫȌȍՕօ]',
		'p': '[pṔṕṖṗⱣᵽƤƥᵱ]',
		'q': '[qꝖꝗʠɊɋꝘꝙq̃]',
		'r': '[rŔŕɌɍŘřŖŗṘṙȐȑȒȓṚṛⱤɽ]',
		's': '[sŚśṠṡṢṣꞨꞩŜŝŠšŞşȘșS̈s̈]',
		't': '[tŤťṪṫŢţṬṭƮʈȚțṰṱṮṯƬƭ]',
		'u': '[uŬŭɄʉỤụÜüÚúÙùÛûǓǔŰűŬŭƯưỦủŪūŨũŲųȔȕ∪]',
		'v': '[vṼṽṾṿƲʋꝞꝟⱱʋ]',
		'w': '[wẂẃẀẁŴŵẄẅẆẇẈẉ]',
		'x': '[xẌẍẊẋχ]',
		'y': '[yÝýỲỳŶŷŸÿỸỹẎẏỴỵɎɏƳƴ]',
		'z': '[zŹźẐẑŽžŻżẒẓẔẕƵƶ]'
	};

	var asciifold = (function() {
		var i, n, k, chunk;
		var foreignletters = '';
		var lookup = {};
		for (k in DIACRITICS) {
			if (DIACRITICS.hasOwnProperty(k)) {
				chunk = DIACRITICS[k].substring(2, DIACRITICS[k].length - 1);
				foreignletters += chunk;
				for (i = 0, n = chunk.length; i < n; i++) {
					lookup[chunk.charAt(i)] = k;
				}
			}
		}
		var regexp = new RegExp('[' +  foreignletters + ']', 'g');
		return function(str) {
			return str.replace(regexp, function(foreignletter) {
				return lookup[foreignletter];
			}).toLowerCase();
		};
	})();


	// export
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	return Sifter;
}));



/**
 * microplugin.js
 * Copyright (c) 2013 Brian Reavis & contributors
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this
 * file except in compliance with the License. You may obtain a copy of the License at:
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under
 * the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF
 * ANY KIND, either express or implied. See the License for the specific language
 * governing permissions and limitations under the License.
 *
 * @author Brian Reavis <brian@thirdroute.com>
 */

(function(root, factory) {
	if (typeof define === 'function' && define.amd) {
		define('microplugin', factory);
	} else if (typeof exports === 'object') {
		module.exports = factory();
	} else {
		root.MicroPlugin = factory();
	}
}(this, function() {
	var MicroPlugin = {};

	MicroPlugin.mixin = function(Interface) {
		Interface.plugins = {};

		/**
		 * Initializes the listed plugins (with options).
		 * Acceptable formats:
		 *
		 * List (without options):
		 *   ['a', 'b', 'c']
		 *
		 * List (with options):
		 *   [{'name': 'a', options: {}}, {'name': 'b', options: {}}]
		 *
		 * Hash (with options):
		 *   {'a': { ... }, 'b': { ... }, 'c': { ... }}
		 *
		 * @param {mixed} plugins
		 */
		Interface.prototype.initializePlugins = function(plugins) {
			var i, n, key;
			var self  = this;
			var queue = [];

			self.plugins = {
				names     : [],
				settings  : {},
				requested : {},
				loaded    : {}
			};

			if (utils.isArray(plugins)) {
				for (i = 0, n = plugins.length; i < n; i++) {
					if (typeof plugins[i] === 'string') {
						queue.push(plugins[i]);
					} else {
						self.plugins.settings[plugins[i].name] = plugins[i].options;
						queue.push(plugins[i].name);
					}
				}
			} else if (plugins) {
				for (key in plugins) {
					if (plugins.hasOwnProperty(key)) {
						self.plugins.settings[key] = plugins[key];
						queue.push(key);
					}
				}
			}

			while (queue.length) {
				self.require(queue.shift());
			}
		};

		Interface.prototype.loadPlugin = function(name) {
			var self    = this;
			var plugins = self.plugins;
			var plugin  = Interface.plugins[name];

			if (!Interface.plugins.hasOwnProperty(name)) {
				throw new Error('Unable to find "' +  name + '" plugin');
			}

			plugins.requested[name] = true;
			plugins.loaded[name] = plugin.fn.apply(self, [self.plugins.settings[name] || {}]);
			plugins.names.push(name);
		};

		/**
		 * Initializes a plugin.
		 *
		 * @param {string} name
		 */
		Interface.prototype.require = function(name) {
			var self = this;
			var plugins = self.plugins;

			if (!self.plugins.loaded.hasOwnProperty(name)) {
				if (plugins.requested[name]) {
					throw new Error('Plugin has circular dependency ("' + name + '")');
				}
				self.loadPlugin(name);
			}

			return plugins.loaded[name];
		};

		/**
		 * Registers a plugin.
		 *
		 * @param {string} name
		 * @param {function} fn
		 */
		Interface.define = function(name, fn) {
			Interface.plugins[name] = {
				'name' : name,
				'fn'   : fn
			};
		};
	};

	var utils = {
		isArray: Array.isArray || function(vArg) {
			return Object.prototype.toString.call(vArg) === '[object Array]';
		}
	};

	return MicroPlugin;
}));

/**
 * selectize.js (v0.12.4)
 * Copyright (c) 2013–2015 Brian Reavis & contributors
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this
 * file except in compliance with the License. You may obtain a copy of the License at:
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under
 * the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF
 * ANY KIND, either express or implied. See the License for the specific language
 * governing permissions and limitations under the License.
 *
 * @author Brian Reavis <brian@thirdroute.com>
 */

/*jshint curly:false */
/*jshint browser:true */

(function(root, factory) {
	if (typeof define === 'function' && define.amd) {
		define('selectize', ['jquery','sifter','microplugin'], factory);
	} else if (typeof exports === 'object') {
		module.exports = factory(require('jquery'), require('sifter'), require('microplugin'));
	} else {
		root.Selectize = factory(root.jQuery, root.Sifter, root.MicroPlugin);
	}
}(this, function($, Sifter, MicroPlugin) {
	'use strict';

	var highlight = function($element, pattern) {
		if (typeof pattern === 'string' && !pattern.length) return;
		var regex = (typeof pattern === 'string') ? new RegExp(pattern, 'i') : pattern;
	
		var highlight = function(node) {
			var skip = 0;
			if (node.nodeType === 3) {
				var pos = node.data.search(regex);
				if (pos >= 0 && node.data.length > 0) {
					var match = node.data.match(regex);
					var spannode = document.createElement('span');
					spannode.className = 'highlight';
					var middlebit = node.splitText(pos);
					var endbit = middlebit.splitText(match[0].length);
					var middleclone = middlebit.cloneNode(true);
					spannode.appendChild(middleclone);
					middlebit.parentNode.replaceChild(spannode, middlebit);
					skip = 1;
				}
			} else if (node.nodeType === 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
				for (var i = 0; i < node.childNodes.length; ++i) {
					i += highlight(node.childNodes[i]);
				}
			}
			return skip;
		};
	
		return $element.each(function() {
			highlight(this);
		});
	};
	
	/**
	 * removeHighlight fn copied from highlight v5 and
	 * edited to remove with() and pass js strict mode
	 */
	$.fn.removeHighlight = function() {
		return this.find("span.highlight").each(function() {
			this.parentNode.firstChild.nodeName;
			var parent = this.parentNode;
			parent.replaceChild(this.firstChild, this);
			parent.normalize();
		}).end();
	};
	
	
	var MicroEvent = function() {};
	MicroEvent.prototype = {
		on: function(event, fct){
			this._events = this._events || {};
			this._events[event] = this._events[event] || [];
			this._events[event].push(fct);
		},
		off: function(event, fct){
			var n = arguments.length;
			if (n === 0) return delete this._events;
			if (n === 1) return delete this._events[event];
	
			this._events = this._events || {};
			if (event in this._events === false) return;
			this._events[event].splice(this._events[event].indexOf(fct), 1);
		},
		trigger: function(event /* , args... */){
			this._events = this._events || {};
			if (event in this._events === false) return;
			for (var i = 0; i < this._events[event].length; i++){
				this._events[event][i].apply(this, Array.prototype.slice.call(arguments, 1));
			}
		}
	};
	
	/**
	 * Mixin will delegate all MicroEvent.js function in the destination object.
	 *
	 * - MicroEvent.mixin(Foobar) will make Foobar able to use MicroEvent
	 *
	 * @param {object} the object which will support MicroEvent
	 */
	MicroEvent.mixin = function(destObject){
		var props = ['on', 'off', 'trigger'];
		for (var i = 0; i < props.length; i++){
			destObject.prototype[props[i]] = MicroEvent.prototype[props[i]];
		}
	};
	
	var IS_MAC        = /Mac/.test(navigator.userAgent);
	
	var KEY_A         = 65;
	var KEY_COMMA     = 188;
	var KEY_RETURN    = 13;
	var KEY_ESC       = 27;
	var KEY_LEFT      = 37;
	var KEY_UP        = 38;
	var KEY_P         = 80;
	var KEY_RIGHT     = 39;
	var KEY_DOWN      = 40;
	var KEY_N         = 78;
	var KEY_BACKSPACE = 8;
	var KEY_DELETE    = 46;
	var KEY_SHIFT     = 16;
	var KEY_CMD       = IS_MAC ? 91 : 17;
	var KEY_CTRL      = IS_MAC ? 18 : 17;
	var KEY_TAB       = 9;
	
	var TAG_SELECT    = 1;
	var TAG_INPUT     = 2;
	
	// for now, android support in general is too spotty to support validity
	var SUPPORTS_VALIDITY_API = !/android/i.test(window.navigator.userAgent) && !!document.createElement('input').validity;
	
	
	var isset = function(object) {
		return typeof object !== 'undefined';
	};
	
	/**
	 * Converts a scalar to its best string representation
	 * for hash keys and HTML attribute values.
	 *
	 * Transformations:
	 *   'str'     -> 'str'
	 *   null      -> ''
	 *   undefined -> ''
	 *   true      -> '1'
	 *   false     -> '0'
	 *   0         -> '0'
	 *   1         -> '1'
	 *
	 * @param {string} value
	 * @returns {string|null}
	 */
	var hash_key = function(value) {
		if (typeof value === 'undefined' || value === null) return null;
		if (typeof value === 'boolean') return value ? '1' : '0';
		return value + '';
	};
	
	/**
	 * Escapes a string for use within HTML.
	 *
	 * @param {string} str
	 * @returns {string}
	 */
	var escape_html = function(str) {
		return (str + '')
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;');
	};
	
	/**
	 * Escapes "$" characters in replacement strings.
	 *
	 * @param {string} str
	 * @returns {string}
	 */
	var escape_replace = function(str) {
		return (str + '').replace(/\$/g, '$$$$');
	};
	
	var hook = {};
	
	/**
	 * Wraps `method` on `self` so that `fn`
	 * is invoked before the original method.
	 *
	 * @param {object} self
	 * @param {string} method
	 * @param {function} fn
	 */
	hook.before = function(self, method, fn) {
		var original = self[method];
		self[method] = function() {
			fn.apply(self, arguments);
			return original.apply(self, arguments);
		};
	};
	
	/**
	 * Wraps `method` on `self` so that `fn`
	 * is invoked after the original method.
	 *
	 * @param {object} self
	 * @param {string} method
	 * @param {function} fn
	 */
	hook.after = function(self, method, fn) {
		var original = self[method];
		self[method] = function() {
			var result = original.apply(self, arguments);
			fn.apply(self, arguments);
			return result;
		};
	};
	
	/**
	 * Wraps `fn` so that it can only be invoked once.
	 *
	 * @param {function} fn
	 * @returns {function}
	 */
	var once = function(fn) {
		var called = false;
		return function() {
			if (called) return;
			called = true;
			fn.apply(this, arguments);
		};
	};
	
	/**
	 * Wraps `fn` so that it can only be called once
	 * every `delay` milliseconds (invoked on the falling edge).
	 *
	 * @param {function} fn
	 * @param {int} delay
	 * @returns {function}
	 */
	var debounce = function(fn, delay) {
		var timeout;
		return function() {
			var self = this;
			var args = arguments;
			window.clearTimeout(timeout);
			timeout = window.setTimeout(function() {
				fn.apply(self, args);
			}, delay);
		};
	};
	
	/**
	 * Debounce all fired events types listed in `types`
	 * while executing the provided `fn`.
	 *
	 * @param {object} self
	 * @param {array} types
	 * @param {function} fn
	 */
	var debounce_events = function(self, types, fn) {
		var type;
		var trigger = self.trigger;
		var event_args = {};
	
		// override trigger method
		self.trigger = function() {
			var type = arguments[0];
			if (types.indexOf(type) !== -1) {
				event_args[type] = arguments;
			} else {
				return trigger.apply(self, arguments);
			}
		};
	
		// invoke provided function
		fn.apply(self, []);
		self.trigger = trigger;
	
		// trigger queued events
		for (type in event_args) {
			if (event_args.hasOwnProperty(type)) {
				trigger.apply(self, event_args[type]);
			}
		}
	};
	
	/**
	 * A workaround for http://bugs.jquery.com/ticket/6696
	 *
	 * @param {object} $parent - Parent element to listen on.
	 * @param {string} event - Event name.
	 * @param {string} selector - Descendant selector to filter by.
	 * @param {function} fn - Event handler.
	 */
	var watchChildEvent = function($parent, event, selector, fn) {
		$parent.on(event, selector, function(e) {
			var child = e.target;
			while (child && child.parentNode !== $parent[0]) {
				child = child.parentNode;
			}
			e.currentTarget = child;
			return fn.apply(this, [e]);
		});
	};
	
	/**
	 * Determines the current selection within a text input control.
	 * Returns an object containing:
	 *   - start
	 *   - length
	 *
	 * @param {object} input
	 * @returns {object}
	 */
	var getSelection = function(input) {
		var result = {};
		if ('selectionStart' in input) {
			result.start = input.selectionStart;
			result.length = input.selectionEnd - result.start;
		} else if (document.selection) {
			input.focus();
			var sel = document.selection.createRange();
			var selLen = document.selection.createRange().text.length;
			sel.moveStart('character', -input.value.length);
			result.start = sel.text.length - selLen;
			result.length = selLen;
		}
		return result;
	};
	
	/**
	 * Copies CSS properties from one element to another.
	 *
	 * @param {object} $from
	 * @param {object} $to
	 * @param {array} properties
	 */
	var transferStyles = function($from, $to, properties) {
		var i, n, styles = {};
		if (properties) {
			for (i = 0, n = properties.length; i < n; i++) {
				styles[properties[i]] = $from.css(properties[i]);
			}
		} else {
			styles = $from.css();
		}
		$to.css(styles);
	};
	
	/**
	 * Measures the width of a string within a
	 * parent element (in pixels).
	 *
	 * @param {string} str
	 * @param {object} $parent
	 * @returns {int}
	 */
	var measureString = function(str, $parent) {
		if (!str) {
			return 0;
		}
	
		var $test = $('<test>').css({
			position: 'absolute',
			top: -99999,
			left: -99999,
			width: 'auto',
			padding: 0,
			whiteSpace: 'pre'
		}).text(str).appendTo('body');
	
		transferStyles($parent, $test, [
			'letterSpacing',
			'fontSize',
			'fontFamily',
			'fontWeight',
			'textTransform'
		]);
	
		var width = $test.width();
		$test.remove();
	
		return width;
	};
	
	/**
	 * Sets up an input to grow horizontally as the user
	 * types. If the value is changed manually, you can
	 * trigger the "update" handler to resize:
	 *
	 * $input.trigger('update');
	 *
	 * @param {object} $input
	 */
	var autoGrow = function($input) {
		var currentWidth = null;
	
		var update = function(e, options) {
			var value, keyCode, printable, placeholder, width;
			var shift, character, selection;
			e = e || window.event || {};
			options = options || {};
	
			if (e.metaKey || e.altKey) return;
			if (!options.force && $input.data('grow') === false) return;
	
			value = $input.val();
			if (e.type && e.type.toLowerCase() === 'keydown') {
				keyCode = e.keyCode;
				printable = (
					(keyCode >= 97 && keyCode <= 122) || // a-z
					(keyCode >= 65 && keyCode <= 90)  || // A-Z
					(keyCode >= 48 && keyCode <= 57)  || // 0-9
					keyCode === 32 // space
				);
	
				if (keyCode === KEY_DELETE || keyCode === KEY_BACKSPACE) {
					selection = getSelection($input[0]);
					if (selection.length) {
						value = value.substring(0, selection.start) + value.substring(selection.start + selection.length);
					} else if (keyCode === KEY_BACKSPACE && selection.start) {
						value = value.substring(0, selection.start - 1) + value.substring(selection.start + 1);
					} else if (keyCode === KEY_DELETE && typeof selection.start !== 'undefined') {
						value = value.substring(0, selection.start) + value.substring(selection.start + 1);
					}
				} else if (printable) {
					shift = e.shiftKey;
					character = String.fromCharCode(e.keyCode);
					if (shift) character = character.toUpperCase();
					else character = character.toLowerCase();
					value += character;
				}
			}
	
			placeholder = $input.attr('placeholder');
			if (!value && placeholder) {
				value = placeholder;
			}
	
			width = measureString(value, $input) + 4;
			if (width !== currentWidth) {
				currentWidth = width;
				$input.width(width);
				$input.triggerHandler('resize');
			}
		};
	
		$input.on('keydown keyup update blur', update);
		update();
	};
	
	var domToString = function(d) {
		var tmp = document.createElement('div');
	
		tmp.appendChild(d.cloneNode(true));
	
		return tmp.innerHTML;
	};
	
	var logError = function(message, options){
		if(!options) options = {};
		var component = "Selectize";
	
		console.error(component + ": " + message)
	
		if(options.explanation){
			// console.group is undefined in <IE11
			if(console.group) console.group();
			console.error(options.explanation);
			if(console.group) console.groupEnd();
		}
	}
	
	
	var Selectize = function($input, settings) {
		var key, i, n, dir, input, self = this;
		input = $input[0];
		input.selectize = self;
	
		// detect rtl environment
		var computedStyle = window.getComputedStyle && window.getComputedStyle(input, null);
		dir = computedStyle ? computedStyle.getPropertyValue('direction') : input.currentStyle && input.currentStyle.direction;
		dir = dir || $input.parents('[dir]:first').attr('dir') || '';
	
		// setup default state
		$.extend(self, {
			order            : 0,
			settings         : settings,
			$input           : $input,
			tabIndex         : $input.attr('tabindex') || '',
			tagType          : input.tagName.toLowerCase() === 'select' ? TAG_SELECT : TAG_INPUT,
			rtl              : /rtl/i.test(dir),
	
			eventNS          : '.selectize' + (++Selectize.count),
			highlightedValue : null,
			isOpen           : false,
			isDisabled       : false,
			isRequired       : $input.is('[required]'),
			isInvalid        : false,
			isLocked         : false,
			isFocused        : false,
			isInputHidden    : false,
			isSetup          : false,
			isShiftDown      : false,
			isCmdDown        : false,
			isCtrlDown       : false,
			ignoreFocus      : false,
			ignoreBlur       : false,
			ignoreHover      : false,
			hasOptions       : false,
			currentResults   : null,
			lastValue        : '',
			caretPos         : 0,
			loading          : 0,
			loadedSearches   : {},
	
			$activeOption    : null,
			$activeItems     : [],
	
			optgroups        : {},
			options          : {},
			userOptions      : {},
			items            : [],
			renderCache      : {},
			onSearchChange   : settings.loadThrottle === null ? self.onSearchChange : debounce(self.onSearchChange, settings.loadThrottle)
		});
	
		// search system
		self.sifter = new Sifter(this.options, {diacritics: settings.diacritics});
	
		// build options table
		if (self.settings.options) {
			for (i = 0, n = self.settings.options.length; i < n; i++) {
				self.registerOption(self.settings.options[i]);
			}
			delete self.settings.options;
		}
	
		// build optgroup table
		if (self.settings.optgroups) {
			for (i = 0, n = self.settings.optgroups.length; i < n; i++) {
				self.registerOptionGroup(self.settings.optgroups[i]);
			}
			delete self.settings.optgroups;
		}
	
		// option-dependent defaults
		self.settings.mode = self.settings.mode || (self.settings.maxItems === 1 ? 'single' : 'multi');
		if (typeof self.settings.hideSelected !== 'boolean') {
			self.settings.hideSelected = self.settings.mode === 'multi';
		}
	
		self.initializePlugins(self.settings.plugins);
		self.setupCallbacks();
		self.setupTemplates();
		self.setup();
	};
	
	// mixins
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	MicroEvent.mixin(Selectize);
	
	if(typeof MicroPlugin !== "undefined"){
		MicroPlugin.mixin(Selectize);
	}else{
		logError("Dependency MicroPlugin is missing",
			{explanation:
				"Make sure you either: (1) are using the \"standalone\" "+
				"version of Selectize, or (2) require MicroPlugin before you "+
				"load Selectize."}
		);
	}
	
	
	// methods
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	$.extend(Selectize.prototype, {
	
		/**
		 * Creates all elements and sets up event bindings.
		 */
		setup: function() {
			var self      = this;
			var settings  = self.settings;
			var eventNS   = self.eventNS;
			var $window   = $(window);
			var $document = $(document);
			var $input    = self.$input;
	
			var $wrapper;
			var $control;
			var $control_input;
			var $dropdown;
			var $dropdown_content;
			var $dropdown_parent;
			var inputMode;
			var timeout_blur;
			var timeout_focus;
			var classes;
			var classes_plugins;
			var inputId;
	
			inputMode         = self.settings.mode;
			classes           = $input.attr('class') || '';
	
			$wrapper          = $('<div>').addClass(settings.wrapperClass).addClass(classes).addClass(inputMode);
			$control          = $('<div>').addClass(settings.inputClass).addClass('items').appendTo($wrapper);
			$control_input    = $('<input type="text" autocomplete="off" />').appendTo($control).attr('tabindex', $input.is(':disabled') ? '-1' : self.tabIndex);
			$dropdown_parent  = $(settings.dropdownParent || $wrapper);
			$dropdown         = $('<div>').addClass(settings.dropdownClass).addClass(inputMode).hide().appendTo($dropdown_parent);
			$dropdown_content = $('<div>').addClass(settings.dropdownContentClass).appendTo($dropdown);
	
			if(inputId = $input.attr('id')) {
				$control_input.attr('id', inputId + '-selectized');
				$("label[for='"+inputId+"']").attr('for', inputId + '-selectized');
			}
	
			if(self.settings.copyClassesToDropdown) {
				$dropdown.addClass(classes);
			}
	
			$wrapper.css({
				width: $input[0].style.width
			});
	
			if (self.plugins.names.length) {
				classes_plugins = 'plugin-' + self.plugins.names.join(' plugin-');
				$wrapper.addClass(classes_plugins);
				$dropdown.addClass(classes_plugins);
			}
	
			if ((settings.maxItems === null || settings.maxItems > 1) && self.tagType === TAG_SELECT) {
				$input.attr('multiple', 'multiple');
			}
	
			if (self.settings.placeholder) {
				$control_input.attr('placeholder', settings.placeholder);
			}
	
			// if splitOn was not passed in, construct it from the delimiter to allow pasting universally
			if (!self.settings.splitOn && self.settings.delimiter) {
				var delimiterEscaped = self.settings.delimiter.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
				self.settings.splitOn = new RegExp('\\s*' + delimiterEscaped + '+\\s*');
			}
	
			if ($input.attr('autocorrect')) {
				$control_input.attr('autocorrect', $input.attr('autocorrect'));
			}
	
			if ($input.attr('autocapitalize')) {
				$control_input.attr('autocapitalize', $input.attr('autocapitalize'));
			}
	
			self.$wrapper          = $wrapper;
			self.$control          = $control;
			self.$control_input    = $control_input;
			self.$dropdown         = $dropdown;
			self.$dropdown_content = $dropdown_content;
	
			$dropdown.on('mouseenter', '[data-selectable]', function() { return self.onOptionHover.apply(self, arguments); });
			$dropdown.on('mousedown click', '[data-selectable]', function() { return self.onOptionSelect.apply(self, arguments); });
			watchChildEvent($control, 'mousedown', '*:not(input)', function() { return self.onItemSelect.apply(self, arguments); });
			autoGrow($control_input);
	
			$control.on({
				mousedown : function() { return self.onMouseDown.apply(self, arguments); },
				click     : function() { return self.onClick.apply(self, arguments); }
			});
	
			$control_input.on({
				mousedown : function(e) { e.stopPropagation(); },
				keydown   : function() { return self.onKeyDown.apply(self, arguments); },
				keyup     : function() { return self.onKeyUp.apply(self, arguments); },
				keypress  : function() { return self.onKeyPress.apply(self, arguments); },
				resize    : function() { self.positionDropdown.apply(self, []); },
				blur      : function() { return self.onBlur.apply(self, arguments); },
				focus     : function() { self.ignoreBlur = false; return self.onFocus.apply(self, arguments); },
				paste     : function() { return self.onPaste.apply(self, arguments); }
			});
	
			$document.on('keydown' + eventNS, function(e) {
				self.isCmdDown = e[IS_MAC ? 'metaKey' : 'ctrlKey'];
				self.isCtrlDown = e[IS_MAC ? 'altKey' : 'ctrlKey'];
				self.isShiftDown = e.shiftKey;
			});
	
			$document.on('keyup' + eventNS, function(e) {
				if (e.keyCode === KEY_CTRL) self.isCtrlDown = false;
				if (e.keyCode === KEY_SHIFT) self.isShiftDown = false;
				if (e.keyCode === KEY_CMD) self.isCmdDown = false;
			});
	
			$document.on('mousedown' + eventNS, function(e) {
				if (self.isFocused) {
					// prevent events on the dropdown scrollbar from causing the control to blur
					if (e.target === self.$dropdown[0] || e.target.parentNode === self.$dropdown[0]) {
						return false;
					}
					// blur on click outside
					if (!self.$control.has(e.target).length && e.target !== self.$control[0]) {
						self.blur(e.target);
					}
				}
			});
	
			$window.on(['scroll' + eventNS, 'resize' + eventNS].join(' '), function() {
				if (self.isOpen) {
					self.positionDropdown.apply(self, arguments);
				}
			});
			$window.on('mousemove' + eventNS, function() {
				self.ignoreHover = false;
			});
	
			// store original children and tab index so that they can be
			// restored when the destroy() method is called.
			this.revertSettings = {
				$children : $input.children().detach(),
				tabindex  : $input.attr('tabindex')
			};
	
			$input.attr('tabindex', -1).hide().after(self.$wrapper);
	
			if ($.isArray(settings.items)) {
				self.setValue(settings.items);
				delete settings.items;
			}
	
			// feature detect for the validation API
			if (SUPPORTS_VALIDITY_API) {
				$input.on('invalid' + eventNS, function(e) {
					e.preventDefault();
					self.isInvalid = true;
					self.refreshState();
				});
			}
	
			self.updateOriginalInput();
			self.refreshItems();
			self.refreshState();
			self.updatePlaceholder();
			self.isSetup = true;
	
			if ($input.is(':disabled')) {
				self.disable();
			}
	
			self.on('change', this.onChange);
	
			$input.data('selectize', self);
			$input.addClass('selectized');
			self.trigger('initialize');
	
			// preload options
			if (settings.preload === true) {
				self.onSearchChange('');
			}
	
		},
	
		/**
		 * Sets up default rendering functions.
		 */
		setupTemplates: function() {
			var self = this;
			var field_label = self.settings.labelField;
			var field_optgroup = self.settings.optgroupLabelField;
	
			var templates = {
				'optgroup': function(data) {
					return '<div class="optgroup">' + data.html + '</div>';
				},
				'optgroup_header': function(data, escape) {
					return '<div class="optgroup-header">' + escape(data[field_optgroup]) + '</div>';
				},
				'option': function(data, escape) {
					return '<div class="option">' + escape(data[field_label]) + '</div>';
				},
				'item': function(data, escape) {
					return '<div class="item">' + escape(data[field_label]) + '</div>';
				},
				'option_create': function(data, escape) {
					return '<div class="create">Add <strong>' + escape(data.input) + '</strong>&hellip;</div>';
				}
			};
	
			self.settings.render = $.extend({}, templates, self.settings.render);
		},
	
		/**
		 * Maps fired events to callbacks provided
		 * in the settings used when creating the control.
		 */
		setupCallbacks: function() {
			var key, fn, callbacks = {
				'initialize'      : 'onInitialize',
				'change'          : 'onChange',
				'item_add'        : 'onItemAdd',
				'item_remove'     : 'onItemRemove',
				'clear'           : 'onClear',
				'option_add'      : 'onOptionAdd',
				'option_remove'   : 'onOptionRemove',
				'option_clear'    : 'onOptionClear',
				'optgroup_add'    : 'onOptionGroupAdd',
				'optgroup_remove' : 'onOptionGroupRemove',
				'optgroup_clear'  : 'onOptionGroupClear',
				'dropdown_open'   : 'onDropdownOpen',
				'dropdown_close'  : 'onDropdownClose',
				'type'            : 'onType',
				'load'            : 'onLoad',
				'focus'           : 'onFocus',
				'blur'            : 'onBlur'
			};
	
			for (key in callbacks) {
				if (callbacks.hasOwnProperty(key)) {
					fn = this.settings[callbacks[key]];
					if (fn) this.on(key, fn);
				}
			}
		},
	
		/**
		 * Triggered when the main control element
		 * has a click event.
		 *
		 * @param {object} e
		 * @return {boolean}
		 */
		onClick: function(e) {
			var self = this;
	
			// necessary for mobile webkit devices (manual focus triggering
			// is ignored unless invoked within a click event)
			if (!self.isFocused) {
				self.focus();
				e.preventDefault();
			}
		},
	
		/**
		 * Triggered when the main control element
		 * has a mouse down event.
		 *
		 * @param {object} e
		 * @return {boolean}
		 */
		onMouseDown: function(e) {
			var self = this;
			var defaultPrevented = e.isDefaultPrevented();
			var $target = $(e.target);
	
			if (self.isFocused) {
				// retain focus by preventing native handling. if the
				// event target is the input it should not be modified.
				// otherwise, text selection within the input won't work.
				if (e.target !== self.$control_input[0]) {
					if (self.settings.mode === 'single') {
						// toggle dropdown
						self.isOpen ? self.close() : self.open();
					} else if (!defaultPrevented) {
						self.setActiveItem(null);
					}
					return false;
				}
			} else {
				// give control focus
				if (!defaultPrevented) {
					window.setTimeout(function() {
						self.focus();
					}, 0);
				}
			}
		},
	
		/**
		 * Triggered when the value of the control has been changed.
		 * This should propagate the event to the original DOM
		 * input / select element.
		 */
		onChange: function() {
			this.$input.trigger('change');
		},
	
		/**
		 * Triggered on <input> paste.
		 *
		 * @param {object} e
		 * @returns {boolean}
		 */
		onPaste: function(e) {
			var self = this;
	
			if (self.isFull() || self.isInputHidden || self.isLocked) {
				e.preventDefault();
				return;
			}
	
			// If a regex or string is included, this will split the pasted
			// input and create Items for each separate value
			if (self.settings.splitOn) {
	
				// Wait for pasted text to be recognized in value
				setTimeout(function() {
					var pastedText = self.$control_input.val();
					if(!pastedText.match(self.settings.splitOn)){ return }
	
					var splitInput = $.trim(pastedText).split(self.settings.splitOn);
					for (var i = 0, n = splitInput.length; i < n; i++) {
						self.createItem(splitInput[i]);
					}
				}, 0);
			}
		},
	
		/**
		 * Triggered on <input> keypress.
		 *
		 * @param {object} e
		 * @returns {boolean}
		 */
		onKeyPress: function(e) {
			if (this.isLocked) return e && e.preventDefault();
			var character = String.fromCharCode(e.keyCode || e.which);
			if (this.settings.create && this.settings.mode === 'multi' && character === this.settings.delimiter) {
				this.createItem();
				e.preventDefault();
				return false;
			}
		},
	
		/**
		 * Triggered on <input> keydown.
		 *
		 * @param {object} e
		 * @returns {boolean}
		 */
		onKeyDown: function(e) {
			var isInput = e.target === this.$control_input[0];
			var self = this;
	
			if (self.isLocked) {
				if (e.keyCode !== KEY_TAB) {
					e.preventDefault();
				}
				return;
			}
	
			switch (e.keyCode) {
				case KEY_A:
					if (self.isCmdDown) {
						self.selectAll();
						return;
					}
					break;
				case KEY_ESC:
					if (self.isOpen) {
						e.preventDefault();
						e.stopPropagation();
						self.close();
					}
					return;
				case KEY_N:
					if (!e.ctrlKey || e.altKey) break;
				case KEY_DOWN:
					if (!self.isOpen && self.hasOptions) {
						self.open();
					} else if (self.$activeOption) {
						self.ignoreHover = true;
						var $next = self.getAdjacentOption(self.$activeOption, 1);
						if ($next.length) self.setActiveOption($next, true, true);
					}
					e.preventDefault();
					return;
				case KEY_P:
					if (!e.ctrlKey || e.altKey) break;
				case KEY_UP:
					if (self.$activeOption) {
						self.ignoreHover = true;
						var $prev = self.getAdjacentOption(self.$activeOption, -1);
						if ($prev.length) self.setActiveOption($prev, true, true);
					}
					e.preventDefault();
					return;
				case KEY_RETURN:
					if (self.isOpen && self.$activeOption) {
						self.onOptionSelect({currentTarget: self.$activeOption});
						e.preventDefault();
					}
					return;
				case KEY_LEFT:
					self.advanceSelection(-1, e);
					return;
				case KEY_RIGHT:
					self.advanceSelection(1, e);
					return;
				case KEY_TAB:
					if (self.settings.selectOnTab && self.isOpen && self.$activeOption) {
						self.onOptionSelect({currentTarget: self.$activeOption});
	
						// Default behaviour is to jump to the next field, we only want this
						// if the current field doesn't accept any more entries
						if (!self.isFull()) {
							e.preventDefault();
						}
					}
					if (self.settings.create && self.createItem()) {
						e.preventDefault();
					}
					return;
				case KEY_BACKSPACE:
				case KEY_DELETE:
					self.deleteSelection(e);
					return;
			}
	
			if ((self.isFull() || self.isInputHidden) && !(IS_MAC ? e.metaKey : e.ctrlKey)) {
				e.preventDefault();
				return;
			}
		},
	
		/**
		 * Triggered on <input> keyup.
		 *
		 * @param {object} e
		 * @returns {boolean}
		 */
		onKeyUp: function(e) {
			var self = this;
	
			if (self.isLocked) return e && e.preventDefault();
			var value = self.$control_input.val() || '';
			if (self.lastValue !== value) {
				self.lastValue = value;
				self.onSearchChange(value);
				self.refreshOptions();
				self.trigger('type', value);
			}
		},
	
		/**
		 * Invokes the user-provide option provider / loader.
		 *
		 * Note: this function is debounced in the Selectize
		 * constructor (by `settings.loadThrottle` milliseconds)
		 *
		 * @param {string} value
		 */
		onSearchChange: function(value) {
			var self = this;
			var fn = self.settings.load;
			if (!fn) return;
			if (self.loadedSearches.hasOwnProperty(value)) return;
			self.loadedSearches[value] = true;
			self.load(function(callback) {
				fn.apply(self, [value, callback]);
			});
		},
	
		/**
		 * Triggered on <input> focus.
		 *
		 * @param {object} e (optional)
		 * @returns {boolean}
		 */
		onFocus: function(e) {
			var self = this;
			var wasFocused = self.isFocused;
	
			if (self.isDisabled) {
				self.blur();
				e && e.preventDefault();
				return false;
			}
	
			if (self.ignoreFocus) return;
			self.isFocused = true;
			if (self.settings.preload === 'focus') self.onSearchChange('');
	
			if (!wasFocused) self.trigger('focus');
	
			if (!self.$activeItems.length) {
				self.showInput();
				self.setActiveItem(null);
				self.refreshOptions(!!self.settings.openOnFocus);
			}
	
			self.refreshState();
		},
	
		/**
		 * Triggered on <input> blur.
		 *
		 * @param {object} e
		 * @param {Element} dest
		 */
		onBlur: function(e, dest) {
			var self = this;
			if (!self.isFocused) return;
			self.isFocused = false;
	
			if (self.ignoreFocus) {
				return;
			} else if (!self.ignoreBlur && document.activeElement === self.$dropdown_content[0]) {
				// necessary to prevent IE closing the dropdown when the scrollbar is clicked
				self.ignoreBlur = true;
				self.onFocus(e);
				return;
			}
	
			var deactivate = function() {
				self.close();
				self.setTextboxValue('');
				self.setActiveItem(null);
				self.setActiveOption(null);
				self.setCaret(self.items.length);
				self.refreshState();
	
				// IE11 bug: element still marked as active
				dest && dest.focus && dest.focus();
	
				self.ignoreFocus = false;
				self.trigger('blur');
			};
	
			self.ignoreFocus = true;
			if (self.settings.create && self.settings.createOnBlur) {
				self.createItem(null, false, deactivate);
			} else {
				deactivate();
			}
		},
	
		/**
		 * Triggered when the user rolls over
		 * an option in the autocomplete dropdown menu.
		 *
		 * @param {object} e
		 * @returns {boolean}
		 */
		onOptionHover: function(e) {
			if (this.ignoreHover) return;
			this.setActiveOption(e.currentTarget, false);
		},
	
		/**
		 * Triggered when the user clicks on an option
		 * in the autocomplete dropdown menu.
		 *
		 * @param {object} e
		 * @returns {boolean}
		 */
		onOptionSelect: function(e) {
			var value, $target, $option, self = this;
	
			if (e.preventDefault) {
				e.preventDefault();
				e.stopPropagation();
			}
	
			$target = $(e.currentTarget);
			if ($target.hasClass('create')) {
				self.createItem(null, function() {
					if (self.settings.closeAfterSelect) {
						self.close();
					}
				});
			} else {
				value = $target.attr('data-value');
				if (typeof value !== 'undefined') {
					self.lastQuery = null;
					self.setTextboxValue('');
					self.addItem(value);
					if (self.settings.closeAfterSelect) {
						self.close();
					} else if (!self.settings.hideSelected && e.type && /mouse/.test(e.type)) {
						self.setActiveOption(self.getOption(value));
					}
				}
			}
		},
	
		/**
		 * Triggered when the user clicks on an item
		 * that has been selected.
		 *
		 * @param {object} e
		 * @returns {boolean}
		 */
		onItemSelect: function(e) {
			var self = this;
	
			if (self.isLocked) return;
			if (self.settings.mode === 'multi') {
				e.preventDefault();
				self.setActiveItem(e.currentTarget, e);
			}
		},
	
		/**
		 * Invokes the provided method that provides
		 * results to a callback---which are then added
		 * as options to the control.
		 *
		 * @param {function} fn
		 */
		load: function(fn) {
			var self = this;
			var $wrapper = self.$wrapper.addClass(self.settings.loadingClass);
	
			self.loading++;
			fn.apply(self, [function(results) {
				self.loading = Math.max(self.loading - 1, 0);
				if (results && results.length) {
					self.addOption(results);
					self.refreshOptions(self.isFocused && !self.isInputHidden);
				}
				if (!self.loading) {
					$wrapper.removeClass(self.settings.loadingClass);
				}
				self.trigger('load', results);
			}]);
		},
	
		/**
		 * Sets the input field of the control to the specified value.
		 *
		 * @param {string} value
		 */
		setTextboxValue: function(value) {
			var $input = this.$control_input;
			var changed = $input.val() !== value;
			if (changed) {
				$input.val(value).triggerHandler('update');
				this.lastValue = value;
			}
		},
	
		/**
		 * Returns the value of the control. If multiple items
		 * can be selected (e.g. <select multiple>), this returns
		 * an array. If only one item can be selected, this
		 * returns a string.
		 *
		 * @returns {mixed}
		 */
		getValue: function() {
			if (this.tagType === TAG_SELECT && this.$input.attr('multiple')) {
				return this.items;
			} else {
				return this.items.join(this.settings.delimiter);
			}
		},
	
		/**
		 * Resets the selected items to the given value.
		 *
		 * @param {mixed} value
		 */
		setValue: function(value, silent) {
			var events = silent ? [] : ['change'];
	
			debounce_events(this, events, function() {
				this.clear(silent);
				this.addItems(value, silent);
			});
		},
	
		/**
		 * Sets the selected item.
		 *
		 * @param {object} $item
		 * @param {object} e (optional)
		 */
		setActiveItem: function($item, e) {
			var self = this;
			var eventName;
			var i, idx, begin, end, item, swap;
			var $last;
	
			if (self.settings.mode === 'single') return;
			$item = $($item);
	
			// clear the active selection
			if (!$item.length) {
				$(self.$activeItems).removeClass('active');
				self.$activeItems = [];
				if (self.isFocused) {
					self.showInput();
				}
				return;
			}
	
			// modify selection
			eventName = e && e.type.toLowerCase();
	
			if (eventName === 'mousedown' && self.isShiftDown && self.$activeItems.length) {
				$last = self.$control.children('.active:last');
				begin = Array.prototype.indexOf.apply(self.$control[0].childNodes, [$last[0]]);
				end   = Array.prototype.indexOf.apply(self.$control[0].childNodes, [$item[0]]);
				if (begin > end) {
					swap  = begin;
					begin = end;
					end   = swap;
				}
				for (i = begin; i <= end; i++) {
					item = self.$control[0].childNodes[i];
					if (self.$activeItems.indexOf(item) === -1) {
						$(item).addClass('active');
						self.$activeItems.push(item);
					}
				}
				e.preventDefault();
			} else if ((eventName === 'mousedown' && self.isCtrlDown) || (eventName === 'keydown' && this.isShiftDown)) {
				if ($item.hasClass('active')) {
					idx = self.$activeItems.indexOf($item[0]);
					self.$activeItems.splice(idx, 1);
					$item.removeClass('active');
				} else {
					self.$activeItems.push($item.addClass('active')[0]);
				}
			} else {
				$(self.$activeItems).removeClass('active');
				self.$activeItems = [$item.addClass('active')[0]];
			}
	
			// ensure control has focus
			self.hideInput();
			if (!this.isFocused) {
				self.focus();
			}
		},
	
		/**
		 * Sets the selected item in the dropdown menu
		 * of available options.
		 *
		 * @param {object} $object
		 * @param {boolean} scroll
		 * @param {boolean} animate
		 */
		setActiveOption: function($option, scroll, animate) {
			var height_menu, height_item, y;
			var scroll_top, scroll_bottom;
			var self = this;
	
			if (self.$activeOption) self.$activeOption.removeClass('active');
			self.$activeOption = null;
	
			$option = $($option);
			if (!$option.length) return;
	
			self.$activeOption = $option.addClass('active');
	
			if (scroll || !isset(scroll)) {
	
				height_menu   = self.$dropdown_content.height();
				height_item   = self.$activeOption.outerHeight(true);
				scroll        = self.$dropdown_content.scrollTop() || 0;
				y             = self.$activeOption.offset().top - self.$dropdown_content.offset().top + scroll;
				scroll_top    = y;
				scroll_bottom = y - height_menu + height_item;
	
				if (y + height_item > height_menu + scroll) {
					self.$dropdown_content.stop().animate({scrollTop: scroll_bottom}, animate ? self.settings.scrollDuration : 0);
				} else if (y < scroll) {
					self.$dropdown_content.stop().animate({scrollTop: scroll_top}, animate ? self.settings.scrollDuration : 0);
				}
	
			}
		},
	
		/**
		 * Selects all items (CTRL + A).
		 */
		selectAll: function() {
			var self = this;
			if (self.settings.mode === 'single') return;
	
			self.$activeItems = Array.prototype.slice.apply(self.$control.children(':not(input)').addClass('active'));
			if (self.$activeItems.length) {
				self.hideInput();
				self.close();
			}
			self.focus();
		},
	
		/**
		 * Hides the input element out of view, while
		 * retaining its focus.
		 */
		hideInput: function() {
			var self = this;
	
			self.setTextboxValue('');
			self.$control_input.css({opacity: 0, position: 'absolute', left: self.rtl ? 10000 : -10000});
			self.isInputHidden = true;
		},
	
		/**
		 * Restores input visibility.
		 */
		showInput: function() {
			this.$control_input.css({opacity: 1, position: 'relative', left: 0});
			this.isInputHidden = false;
		},
	
		/**
		 * Gives the control focus.
		 */
		focus: function() {
			var self = this;
			if (self.isDisabled) return;
	
			self.ignoreFocus = true;
			self.$control_input[0].focus();
			window.setTimeout(function() {
				self.ignoreFocus = false;
				self.onFocus();
			}, 0);
		},
	
		/**
		 * Forces the control out of focus.
		 *
		 * @param {Element} dest
		 */
		blur: function(dest) {
			this.$control_input[0].blur();
			this.onBlur(null, dest);
		},
	
		/**
		 * Returns a function that scores an object
		 * to show how good of a match it is to the
		 * provided query.
		 *
		 * @param {string} query
		 * @param {object} options
		 * @return {function}
		 */
		getScoreFunction: function(query) {
			return this.sifter.getScoreFunction(query, this.getSearchOptions());
		},
	
		/**
		 * Returns search options for sifter (the system
		 * for scoring and sorting results).
		 *
		 * @see https://github.com/brianreavis/sifter.js
		 * @return {object}
		 */
		getSearchOptions: function() {
			var settings = this.settings;
			var sort = settings.sortField;
			if (typeof sort === 'string') {
				sort = [{field: sort}];
			}
	
			return {
				fields      : settings.searchField,
				conjunction : settings.searchConjunction,
				sort        : sort
			};
		},
	
		/**
		 * Searches through available options and returns
		 * a sorted array of matches.
		 *
		 * Returns an object containing:
		 *
		 *   - query {string}
		 *   - tokens {array}
		 *   - total {int}
		 *   - items {array}
		 *
		 * @param {string} query
		 * @returns {object}
		 */
		search: function(query) {
			var i, value, score, result, calculateScore;
			var self     = this;
			var settings = self.settings;
			var options  = this.getSearchOptions();
	
			// validate user-provided result scoring function
			if (settings.score) {
				calculateScore = self.settings.score.apply(this, [query]);
				if (typeof calculateScore !== 'function') {
					throw new Error('Selectize "score" setting must be a function that returns a function');
				}
			}
	
			// perform search
			if (query !== self.lastQuery) {
				self.lastQuery = query;
				result = self.sifter.search(query, $.extend(options, {score: calculateScore}));
				self.currentResults = result;
			} else {
				result = $.extend(true, {}, self.currentResults);
			}
	
			// filter out selected items
			if (settings.hideSelected) {
				for (i = result.items.length - 1; i >= 0; i--) {
					if (self.items.indexOf(hash_key(result.items[i].id)) !== -1) {
						result.items.splice(i, 1);
					}
				}
			}
	
			return result;
		},
	
		/**
		 * Refreshes the list of available options shown
		 * in the autocomplete dropdown menu.
		 *
		 * @param {boolean} triggerDropdown
		 */
		refreshOptions: function(triggerDropdown) {
			var i, j, k, n, groups, groups_order, option, option_html, optgroup, optgroups, html, html_children, has_create_option;
			var $active, $active_before, $create;
	
			if (typeof triggerDropdown === 'undefined') {
				triggerDropdown = true;
			}
	
			var self              = this;
			var query             = $.trim(self.$control_input.val());
			var results           = self.search(query);
			var $dropdown_content = self.$dropdown_content;
			var active_before     = self.$activeOption && hash_key(self.$activeOption.attr('data-value'));
	
			// build markup
			n = results.items.length;
			if (typeof self.settings.maxOptions === 'number') {
				n = Math.min(n, self.settings.maxOptions);
			}
	
			// render and group available options individually
			groups = {};
			groups_order = [];
	
			for (i = 0; i < n; i++) {
				option      = self.options[results.items[i].id];
				option_html = self.render('option', option);
				optgroup    = option[self.settings.optgroupField] || '';
				optgroups   = $.isArray(optgroup) ? optgroup : [optgroup];
	
				for (j = 0, k = optgroups && optgroups.length; j < k; j++) {
					optgroup = optgroups[j];
					if (!self.optgroups.hasOwnProperty(optgroup)) {
						optgroup = '';
					}
					if (!groups.hasOwnProperty(optgroup)) {
						groups[optgroup] = document.createDocumentFragment();
						groups_order.push(optgroup);
					}
					groups[optgroup].appendChild(option_html);
				}
			}
	
			// sort optgroups
			if (this.settings.lockOptgroupOrder) {
				groups_order.sort(function(a, b) {
					var a_order = self.optgroups[a].$order || 0;
					var b_order = self.optgroups[b].$order || 0;
					return a_order - b_order;
				});
			}
	
			// render optgroup headers & join groups
			html = document.createDocumentFragment();
			for (i = 0, n = groups_order.length; i < n; i++) {
				optgroup = groups_order[i];
				if (self.optgroups.hasOwnProperty(optgroup) && groups[optgroup].childNodes.length) {
					// render the optgroup header and options within it,
					// then pass it to the wrapper template
					html_children = document.createDocumentFragment();
					html_children.appendChild(self.render('optgroup_header', self.optgroups[optgroup]));
					html_children.appendChild(groups[optgroup]);
	
					html.appendChild(self.render('optgroup', $.extend({}, self.optgroups[optgroup], {
						html: domToString(html_children),
						dom:  html_children
					})));
				} else {
					html.appendChild(groups[optgroup]);
				}
			}
	
			$dropdown_content.html(html);
	
			// highlight matching terms inline
			if (self.settings.highlight && results.query.length && results.tokens.length) {
				$dropdown_content.removeHighlight();
				for (i = 0, n = results.tokens.length; i < n; i++) {
					highlight($dropdown_content, results.tokens[i].regex);
				}
			}
	
			// add "selected" class to selected options
			if (!self.settings.hideSelected) {
				for (i = 0, n = self.items.length; i < n; i++) {
					self.getOption(self.items[i]).addClass('selected');
				}
			}
	
			// add create option
			has_create_option = self.canCreate(query);
			if (has_create_option) {
				$dropdown_content.prepend(self.render('option_create', {input: query}));
				$create = $($dropdown_content[0].childNodes[0]);
			}
	
			// activate
			self.hasOptions = results.items.length > 0 || has_create_option;
			if (self.hasOptions) {
				if (results.items.length > 0) {
					$active_before = active_before && self.getOption(active_before);
					if ($active_before && $active_before.length) {
						$active = $active_before;
					} else if (self.settings.mode === 'single' && self.items.length) {
						$active = self.getOption(self.items[0]);
					}
					if (!$active || !$active.length) {
						if ($create && !self.settings.addPrecedence) {
							$active = self.getAdjacentOption($create, 1);
						} else {
							$active = $dropdown_content.find('[data-selectable]:first');
						}
					}
				} else {
					$active = $create;
				}
				self.setActiveOption($active);
				if (triggerDropdown && !self.isOpen) { self.open(); }
			} else {
				self.setActiveOption(null);
				if (triggerDropdown && self.isOpen) { self.close(); }
			}
		},
	
		/**
		 * Adds an available option. If it already exists,
		 * nothing will happen. Note: this does not refresh
		 * the options list dropdown (use `refreshOptions`
		 * for that).
		 *
		 * Usage:
		 *
		 *   this.addOption(data)
		 *
		 * @param {object|array} data
		 */
		addOption: function(data) {
			var i, n, value, self = this;
	
			if ($.isArray(data)) {
				for (i = 0, n = data.length; i < n; i++) {
					self.addOption(data[i]);
				}
				return;
			}
	
			if (value = self.registerOption(data)) {
				self.userOptions[value] = true;
				self.lastQuery = null;
				self.trigger('option_add', value, data);
			}
		},
	
		/**
		 * Registers an option to the pool of options.
		 *
		 * @param {object} data
		 * @return {boolean|string}
		 */
		registerOption: function(data) {
			var key = hash_key(data[this.settings.valueField]);
			if (typeof key === 'undefined' || key === null || this.options.hasOwnProperty(key)) return false;
			data.$order = data.$order || ++this.order;
			this.options[key] = data;
			return key;
		},
	
		/**
		 * Registers an option group to the pool of option groups.
		 *
		 * @param {object} data
		 * @return {boolean|string}
		 */
		registerOptionGroup: function(data) {
			var key = hash_key(data[this.settings.optgroupValueField]);
			if (!key) return false;
	
			data.$order = data.$order || ++this.order;
			this.optgroups[key] = data;
			return key;
		},
	
		/**
		 * Registers a new optgroup for options
		 * to be bucketed into.
		 *
		 * @param {string} id
		 * @param {object} data
		 */
		addOptionGroup: function(id, data) {
			data[this.settings.optgroupValueField] = id;
			if (id = this.registerOptionGroup(data)) {
				this.trigger('optgroup_add', id, data);
			}
		},
	
		/**
		 * Removes an existing option group.
		 *
		 * @param {string} id
		 */
		removeOptionGroup: function(id) {
			if (this.optgroups.hasOwnProperty(id)) {
				delete this.optgroups[id];
				this.renderCache = {};
				this.trigger('optgroup_remove', id);
			}
		},
	
		/**
		 * Clears all existing option groups.
		 */
		clearOptionGroups: function() {
			this.optgroups = {};
			this.renderCache = {};
			this.trigger('optgroup_clear');
		},
	
		/**
		 * Updates an option available for selection. If
		 * it is visible in the selected items or options
		 * dropdown, it will be re-rendered automatically.
		 *
		 * @param {string} value
		 * @param {object} data
		 */
		updateOption: function(value, data) {
			var self = this;
			var $item, $item_new;
			var value_new, index_item, cache_items, cache_options, order_old;
	
			value     = hash_key(value);
			value_new = hash_key(data[self.settings.valueField]);
	
			// sanity checks
			if (value === null) return;
			if (!self.options.hasOwnProperty(value)) return;
			if (typeof value_new !== 'string') throw new Error('Value must be set in option data');
	
			order_old = self.options[value].$order;
	
			// update references
			if (value_new !== value) {
				delete self.options[value];
				index_item = self.items.indexOf(value);
				if (index_item !== -1) {
					self.items.splice(index_item, 1, value_new);
				}
			}
			data.$order = data.$order || order_old;
			self.options[value_new] = data;
	
			// invalidate render cache
			cache_items = self.renderCache['item'];
			cache_options = self.renderCache['option'];
	
			if (cache_items) {
				delete cache_items[value];
				delete cache_items[value_new];
			}
			if (cache_options) {
				delete cache_options[value];
				delete cache_options[value_new];
			}
	
			// update the item if it's selected
			if (self.items.indexOf(value_new) !== -1) {
				$item = self.getItem(value);
				$item_new = $(self.render('item', data));
				if ($item.hasClass('active')) $item_new.addClass('active');
				$item.replaceWith($item_new);
			}
	
			// invalidate last query because we might have updated the sortField
			self.lastQuery = null;
	
			// update dropdown contents
			if (self.isOpen) {
				self.refreshOptions(false);
			}
		},
	
		/**
		 * Removes a single option.
		 *
		 * @param {string} value
		 * @param {boolean} silent
		 */
		removeOption: function(value, silent) {
			var self = this;
			value = hash_key(value);
	
			var cache_items = self.renderCache['item'];
			var cache_options = self.renderCache['option'];
			if (cache_items) delete cache_items[value];
			if (cache_options) delete cache_options[value];
	
			delete self.userOptions[value];
			delete self.options[value];
			self.lastQuery = null;
			self.trigger('option_remove', value);
			self.removeItem(value, silent);
		},
	
		/**
		 * Clears all options.
		 */
		clearOptions: function() {
			var self = this;
	
			self.loadedSearches = {};
			self.userOptions = {};
			self.renderCache = {};
			self.options = self.sifter.items = {};
			self.lastQuery = null;
			self.trigger('option_clear');
			self.clear();
		},
	
		/**
		 * Returns the jQuery element of the option
		 * matching the given value.
		 *
		 * @param {string} value
		 * @returns {object}
		 */
		getOption: function(value) {
			return this.getElementWithValue(value, this.$dropdown_content.find('[data-selectable]'));
		},
	
		/**
		 * Returns the jQuery element of the next or
		 * previous selectable option.
		 *
		 * @param {object} $option
		 * @param {int} direction  can be 1 for next or -1 for previous
		 * @return {object}
		 */
		getAdjacentOption: function($option, direction) {
			var $options = this.$dropdown.find('[data-selectable]');
			var index    = $options.index($option) + direction;
	
			return index >= 0 && index < $options.length ? $options.eq(index) : $();
		},
	
		/**
		 * Finds the first element with a "data-value" attribute
		 * that matches the given value.
		 *
		 * @param {mixed} value
		 * @param {object} $els
		 * @return {object}
		 */
		getElementWithValue: function(value, $els) {
			value = hash_key(value);
	
			if (typeof value !== 'undefined' && value !== null) {
				for (var i = 0, n = $els.length; i < n; i++) {
					if ($els[i].getAttribute('data-value') === value) {
						return $($els[i]);
					}
				}
			}
	
			return $();
		},
	
		/**
		 * Returns the jQuery element of the item
		 * matching the given value.
		 *
		 * @param {string} value
		 * @returns {object}
		 */
		getItem: function(value) {
			return this.getElementWithValue(value, this.$control.children());
		},
	
		/**
		 * "Selects" multiple items at once. Adds them to the list
		 * at the current caret position.
		 *
		 * @param {string} value
		 * @param {boolean} silent
		 */
		addItems: function(values, silent) {
			var items = $.isArray(values) ? values : [values];
			for (var i = 0, n = items.length; i < n; i++) {
				this.isPending = (i < n - 1);
				this.addItem(items[i], silent);
			}
		},
	
		/**
		 * "Selects" an item. Adds it to the list
		 * at the current caret position.
		 *
		 * @param {string} value
		 * @param {boolean} silent
		 */
		addItem: function(value, silent) {
			var events = silent ? [] : ['change'];
	
			debounce_events(this, events, function() {
				var $item, $option, $options;
				var self = this;
				var inputMode = self.settings.mode;
				var i, active, value_next, wasFull;
				value = hash_key(value);
	
				if (self.items.indexOf(value) !== -1) {
					if (inputMode === 'single') self.close();
					return;
				}
	
				if (!self.options.hasOwnProperty(value)) return;
				if (inputMode === 'single') self.clear(silent);
				if (inputMode === 'multi' && self.isFull()) return;
	
				$item = $(self.render('item', self.options[value]));
				wasFull = self.isFull();
				self.items.splice(self.caretPos, 0, value);
				self.insertAtCaret($item);
				if (!self.isPending || (!wasFull && self.isFull())) {
					self.refreshState();
				}
	
				if (self.isSetup) {
					$options = self.$dropdown_content.find('[data-selectable]');
	
					// update menu / remove the option (if this is not one item being added as part of series)
					if (!self.isPending) {
						$option = self.getOption(value);
						value_next = self.getAdjacentOption($option, 1).attr('data-value');
						self.refreshOptions(self.isFocused && inputMode !== 'single');
						if (value_next) {
							self.setActiveOption(self.getOption(value_next));
						}
					}
	
					// hide the menu if the maximum number of items have been selected or no options are left
					if (!$options.length || self.isFull()) {
						self.close();
					} else {
						self.positionDropdown();
					}
	
					self.updatePlaceholder();
					self.trigger('item_add', value, $item);
					self.updateOriginalInput({silent: silent});
				}
			});
		},
	
		/**
		 * Removes the selected item matching
		 * the provided value.
		 *
		 * @param {string} value
		 */
		removeItem: function(value, silent) {
			var self = this;
			var $item, i, idx;
	
			$item = (value instanceof $) ? value : self.getItem(value);
			value = hash_key($item.attr('data-value'));
			i = self.items.indexOf(value);
	
			if (i !== -1) {
				$item.remove();
				if ($item.hasClass('active')) {
					idx = self.$activeItems.indexOf($item[0]);
					self.$activeItems.splice(idx, 1);
				}
	
				self.items.splice(i, 1);
				self.lastQuery = null;
				if (!self.settings.persist && self.userOptions.hasOwnProperty(value)) {
					self.removeOption(value, silent);
				}
	
				if (i < self.caretPos) {
					self.setCaret(self.caretPos - 1);
				}
	
				self.refreshState();
				self.updatePlaceholder();
				self.updateOriginalInput({silent: silent});
				self.positionDropdown();
				self.trigger('item_remove', value, $item);
			}
		},
	
		/**
		 * Invokes the `create` method provided in the
		 * selectize options that should provide the data
		 * for the new item, given the user input.
		 *
		 * Once this completes, it will be added
		 * to the item list.
		 *
		 * @param {string} value
		 * @param {boolean} [triggerDropdown]
		 * @param {function} [callback]
		 * @return {boolean}
		 */
		createItem: function(input, triggerDropdown) {
			var self  = this;
			var caret = self.caretPos;
			input = input || $.trim(self.$control_input.val() || '');
	
			var callback = arguments[arguments.length - 1];
			if (typeof callback !== 'function') callback = function() {};
	
			if (typeof triggerDropdown !== 'boolean') {
				triggerDropdown = true;
			}
	
			if (!self.canCreate(input)) {
				callback();
				return false;
			}
	
			self.lock();
	
			var setup = (typeof self.settings.create === 'function') ? this.settings.create : function(input) {
				var data = {};
				data[self.settings.labelField] = input;
				data[self.settings.valueField] = input;
				return data;
			};
	
			var create = once(function(data) {
				self.unlock();
	
				if (!data || typeof data !== 'object') return callback();
				var value = hash_key(data[self.settings.valueField]);
				if (typeof value !== 'string') return callback();
	
				self.setTextboxValue('');
				self.addOption(data);
				self.setCaret(caret);
				self.addItem(value);
				self.refreshOptions(triggerDropdown && self.settings.mode !== 'single');
				callback(data);
			});
	
			var output = setup.apply(this, [input, create]);
			if (typeof output !== 'undefined') {
				create(output);
			}
	
			return true;
		},
	
		/**
		 * Re-renders the selected item lists.
		 */
		refreshItems: function() {
			this.lastQuery = null;
	
			if (this.isSetup) {
				this.addItem(this.items);
			}
	
			this.refreshState();
			this.updateOriginalInput();
		},
	
		/**
		 * Updates all state-dependent attributes
		 * and CSS classes.
		 */
		refreshState: function() {
			this.refreshValidityState();
			this.refreshClasses();
		},
	
		/**
		 * Update the `required` attribute of both input and control input.
		 *
		 * The `required` property needs to be activated on the control input
		 * for the error to be displayed at the right place. `required` also
		 * needs to be temporarily deactivated on the input since the input is
		 * hidden and can't show errors.
		 */
		refreshValidityState: function() {
			if (!this.isRequired) return false;
	
			var invalid = !this.items.length;
	
			this.isInvalid = invalid;
			this.$control_input.prop('required', invalid);
			this.$input.prop('required', !invalid);
		},
	
		/**
		 * Updates all state-dependent CSS classes.
		 */
		refreshClasses: function() {
			var self     = this;
			var isFull   = self.isFull();
			var isLocked = self.isLocked;
	
			self.$wrapper
				.toggleClass('rtl', self.rtl);
	
			self.$control
				.toggleClass('focus', self.isFocused)
				.toggleClass('disabled', self.isDisabled)
				.toggleClass('required', self.isRequired)
				.toggleClass('invalid', self.isInvalid)
				.toggleClass('locked', isLocked)
				.toggleClass('full', isFull).toggleClass('not-full', !isFull)
				.toggleClass('input-active', self.isFocused && !self.isInputHidden)
				.toggleClass('dropdown-active', self.isOpen)
				.toggleClass('has-options', !$.isEmptyObject(self.options))
				.toggleClass('has-items', self.items.length > 0);
	
			self.$control_input.data('grow', !isFull && !isLocked);
		},
	
		/**
		 * Determines whether or not more items can be added
		 * to the control without exceeding the user-defined maximum.
		 *
		 * @returns {boolean}
		 */
		isFull: function() {
			return this.settings.maxItems !== null && this.items.length >= this.settings.maxItems;
		},
	
		/**
		 * Refreshes the original <select> or <input>
		 * element to reflect the current state.
		 */
		updateOriginalInput: function(opts) {
			var i, n, options, label, self = this;
			opts = opts || {};
	
			if (self.tagType === TAG_SELECT) {
				options = [];
				for (i = 0, n = self.items.length; i < n; i++) {
					label = self.options[self.items[i]][self.settings.labelField] || '';
					options.push('<option value="' + escape_html(self.items[i]) + '" selected="selected">' + escape_html(label) + '</option>');
				}
				if (!options.length && !this.$input.attr('multiple')) {
					options.push('<option value="" selected="selected"></option>');
				}
				self.$input.html(options.join(''));
			} else {
				self.$input.val(self.getValue());
				self.$input.attr('value',self.$input.val());
			}
	
			if (self.isSetup) {
				if (!opts.silent) {
					self.trigger('change', self.$input.val());
				}
			}
		},
	
		/**
		 * Shows/hide the input placeholder depending
		 * on if there items in the list already.
		 */
		updatePlaceholder: function() {
			if (!this.settings.placeholder) return;
			var $input = this.$control_input;
	
			if (this.items.length) {
				$input.removeAttr('placeholder');
			} else {
				$input.attr('placeholder', this.settings.placeholder);
			}
			$input.triggerHandler('update', {force: true});
		},
	
		/**
		 * Shows the autocomplete dropdown containing
		 * the available options.
		 */
		open: function() {
			var self = this;
	
			if (self.isLocked || self.isOpen || (self.settings.mode === 'multi' && self.isFull())) return;
			self.focus();
			self.isOpen = true;
			self.refreshState();
			self.$dropdown.css({visibility: 'hidden', display: 'block'});
			self.positionDropdown();
			self.$dropdown.css({visibility: 'visible'});
			self.trigger('dropdown_open', self.$dropdown);
		},
	
		/**
		 * Closes the autocomplete dropdown menu.
		 */
		close: function() {
			var self = this;
			var trigger = self.isOpen;
	
			if (self.settings.mode === 'single' && self.items.length) {
				self.hideInput();
				self.$control_input.blur(); // close keyboard on iOS
			}
	
			self.isOpen = false;
			self.$dropdown.hide();
			self.setActiveOption(null);
			self.refreshState();
	
			if (trigger) self.trigger('dropdown_close', self.$dropdown);
		},
	
		/**
		 * Calculates and applies the appropriate
		 * position of the dropdown.
		 */
		positionDropdown: function() {
			var $control = this.$control;
			var offset = this.settings.dropdownParent === 'body' ? $control.offset() : $control.position();
			offset.top += $control.outerHeight(true);
	
			this.$dropdown.css({
				width : $control.outerWidth(),
				top   : offset.top,
				left  : offset.left
			});
		},
	
		/**
		 * Resets / clears all selected items
		 * from the control.
		 *
		 * @param {boolean} silent
		 */
		clear: function(silent) {
			var self = this;
	
			if (!self.items.length) return;
			self.$control.children(':not(input)').remove();
			self.items = [];
			self.lastQuery = null;
			self.setCaret(0);
			self.setActiveItem(null);
			self.updatePlaceholder();
			self.updateOriginalInput({silent: silent});
			self.refreshState();
			self.showInput();
			self.trigger('clear');
		},
	
		/**
		 * A helper method for inserting an element
		 * at the current caret position.
		 *
		 * @param {object} $el
		 */
		insertAtCaret: function($el) {
			var caret = Math.min(this.caretPos, this.items.length);
			if (caret === 0) {
				this.$control.prepend($el);
			} else {
				$(this.$control[0].childNodes[caret]).before($el);
			}
			this.setCaret(caret + 1);
		},
	
		/**
		 * Removes the current selected item(s).
		 *
		 * @param {object} e (optional)
		 * @returns {boolean}
		 */
		deleteSelection: function(e) {
			var i, n, direction, selection, values, caret, option_select, $option_select, $tail;
			var self = this;
	
			direction = (e && e.keyCode === KEY_BACKSPACE) ? -1 : 1;
			selection = getSelection(self.$control_input[0]);
	
			if (self.$activeOption && !self.settings.hideSelected) {
				option_select = self.getAdjacentOption(self.$activeOption, -1).attr('data-value');
			}
	
			// determine items that will be removed
			values = [];
	
			if (self.$activeItems.length) {
				$tail = self.$control.children('.active:' + (direction > 0 ? 'last' : 'first'));
				caret = self.$control.children(':not(input)').index($tail);
				if (direction > 0) { caret++; }
	
				for (i = 0, n = self.$activeItems.length; i < n; i++) {
					values.push($(self.$activeItems[i]).attr('data-value'));
				}
				if (e) {
					e.preventDefault();
					e.stopPropagation();
				}
			} else if ((self.isFocused || self.settings.mode === 'single') && self.items.length) {
				if (direction < 0 && selection.start === 0 && selection.length === 0) {
					values.push(self.items[self.caretPos - 1]);
				} else if (direction > 0 && selection.start === self.$control_input.val().length) {
					values.push(self.items[self.caretPos]);
				}
			}
	
			// allow the callback to abort
			if (!values.length || (typeof self.settings.onDelete === 'function' && self.settings.onDelete.apply(self, [values]) === false)) {
				return false;
			}
	
			// perform removal
			if (typeof caret !== 'undefined') {
				self.setCaret(caret);
			}
			while (values.length) {
				self.removeItem(values.pop());
			}
	
			self.showInput();
			self.positionDropdown();
			self.refreshOptions(true);
	
			// select previous option
			if (option_select) {
				$option_select = self.getOption(option_select);
				if ($option_select.length) {
					self.setActiveOption($option_select);
				}
			}
	
			return true;
		},
	
		/**
		 * Selects the previous / next item (depending
		 * on the `direction` argument).
		 *
		 * > 0 - right
		 * < 0 - left
		 *
		 * @param {int} direction
		 * @param {object} e (optional)
		 */
		advanceSelection: function(direction, e) {
			var tail, selection, idx, valueLength, cursorAtEdge, $tail;
			var self = this;
	
			if (direction === 0) return;
			if (self.rtl) direction *= -1;
	
			tail = direction > 0 ? 'last' : 'first';
			selection = getSelection(self.$control_input[0]);
	
			if (self.isFocused && !self.isInputHidden) {
				valueLength = self.$control_input.val().length;
				cursorAtEdge = direction < 0
					? selection.start === 0 && selection.length === 0
					: selection.start === valueLength;
	
				if (cursorAtEdge && !valueLength) {
					self.advanceCaret(direction, e);
				}
			} else {
				$tail = self.$control.children('.active:' + tail);
				if ($tail.length) {
					idx = self.$control.children(':not(input)').index($tail);
					self.setActiveItem(null);
					self.setCaret(direction > 0 ? idx + 1 : idx);
				}
			}
		},
	
		/**
		 * Moves the caret left / right.
		 *
		 * @param {int} direction
		 * @param {object} e (optional)
		 */
		advanceCaret: function(direction, e) {
			var self = this, fn, $adj;
	
			if (direction === 0) return;
	
			fn = direction > 0 ? 'next' : 'prev';
			if (self.isShiftDown) {
				$adj = self.$control_input[fn]();
				if ($adj.length) {
					self.hideInput();
					self.setActiveItem($adj);
					e && e.preventDefault();
				}
			} else {
				self.setCaret(self.caretPos + direction);
			}
		},
	
		/**
		 * Moves the caret to the specified index.
		 *
		 * @param {int} i
		 */
		setCaret: function(i) {
			var self = this;
	
			if (self.settings.mode === 'single') {
				i = self.items.length;
			} else {
				i = Math.max(0, Math.min(self.items.length, i));
			}
	
			if(!self.isPending) {
				// the input must be moved by leaving it in place and moving the
				// siblings, due to the fact that focus cannot be restored once lost
				// on mobile webkit devices
				var j, n, fn, $children, $child;
				$children = self.$control.children(':not(input)');
				for (j = 0, n = $children.length; j < n; j++) {
					$child = $($children[j]).detach();
					if (j <  i) {
						self.$control_input.before($child);
					} else {
						self.$control.append($child);
					}
				}
			}
	
			self.caretPos = i;
		},
	
		/**
		 * Disables user input on the control. Used while
		 * items are being asynchronously created.
		 */
		lock: function() {
			this.close();
			this.isLocked = true;
			this.refreshState();
		},
	
		/**
		 * Re-enables user input on the control.
		 */
		unlock: function() {
			this.isLocked = false;
			this.refreshState();
		},
	
		/**
		 * Disables user input on the control completely.
		 * While disabled, it cannot receive focus.
		 */
		disable: function() {
			var self = this;
			self.$input.prop('disabled', true);
			self.$control_input.prop('disabled', true).prop('tabindex', -1);
			self.isDisabled = true;
			self.lock();
		},
	
		/**
		 * Enables the control so that it can respond
		 * to focus and user input.
		 */
		enable: function() {
			var self = this;
			self.$input.prop('disabled', false);
			self.$control_input.prop('disabled', false).prop('tabindex', self.tabIndex);
			self.isDisabled = false;
			self.unlock();
		},
	
		/**
		 * Completely destroys the control and
		 * unbinds all event listeners so that it can
		 * be garbage collected.
		 */
		destroy: function() {
			var self = this;
			var eventNS = self.eventNS;
			var revertSettings = self.revertSettings;
	
			self.trigger('destroy');
			self.off();
			self.$wrapper.remove();
			self.$dropdown.remove();
	
			self.$input
				.html('')
				.append(revertSettings.$children)
				.removeAttr('tabindex')
				.removeClass('selectized')
				.attr({tabindex: revertSettings.tabindex})
				.show();
	
			self.$control_input.removeData('grow');
			self.$input.removeData('selectize');
	
			$(window).off(eventNS);
			$(document).off(eventNS);
			$(document.body).off(eventNS);
	
			delete self.$input[0].selectize;
		},
	
		/**
		 * A helper method for rendering "item" and
		 * "option" templates, given the data.
		 *
		 * @param {string} templateName
		 * @param {object} data
		 * @returns {string}
		 */
		render: function(templateName, data) {
			var value, id, label;
			var html = '';
			var cache = false;
			var self = this;
			var regex_tag = /^[\t \r\n]*<([a-z][a-z0-9\-_]*(?:\:[a-z][a-z0-9\-_]*)?)/i;
	
			if (templateName === 'option' || templateName === 'item') {
				value = hash_key(data[self.settings.valueField]);
				cache = !!value;
			}
	
			// pull markup from cache if it exists
			if (cache) {
				if (!isset(self.renderCache[templateName])) {
					self.renderCache[templateName] = {};
				}
				if (self.renderCache[templateName].hasOwnProperty(value)) {
					return self.renderCache[templateName][value];
				}
			}
	
			// render markup
			html = $(self.settings.render[templateName].apply(this, [data, escape_html]));
	
			// add mandatory attributes
			if (templateName === 'option' || templateName === 'option_create') {
				html.attr('data-selectable', '');
			}
			else if (templateName === 'optgroup') {
				id = data[self.settings.optgroupValueField] || '';
				html.attr('data-group', id);
			}
			if (templateName === 'option' || templateName === 'item') {
				html.attr('data-value', value || '');
			}
	
			// update cache
			if (cache) {
				self.renderCache[templateName][value] = html[0];
			}
	
			return html[0];
		},
	
		/**
		 * Clears the render cache for a template. If
		 * no template is given, clears all render
		 * caches.
		 *
		 * @param {string} templateName
		 */
		clearCache: function(templateName) {
			var self = this;
			if (typeof templateName === 'undefined') {
				self.renderCache = {};
			} else {
				delete self.renderCache[templateName];
			}
		},
	
		/**
		 * Determines whether or not to display the
		 * create item prompt, given a user input.
		 *
		 * @param {string} input
		 * @return {boolean}
		 */
		canCreate: function(input) {
			var self = this;
			if (!self.settings.create) return false;
			var filter = self.settings.createFilter;
			return input.length
				&& (typeof filter !== 'function' || filter.apply(self, [input]))
				&& (typeof filter !== 'string' || new RegExp(filter).test(input))
				&& (!(filter instanceof RegExp) || filter.test(input));
		}
	
	});
	
	
	Selectize.count = 0;
	Selectize.defaults = {
		options: [],
		optgroups: [],
	
		plugins: [],
		delimiter: ',',
		splitOn: null, // regexp or string for splitting up values from a paste command
		persist: true,
		diacritics: true,
		create: false,
		createOnBlur: false,
		createFilter: null,
		highlight: true,
		openOnFocus: true,
		maxOptions: 1000,
		maxItems: null,
		hideSelected: null,
		addPrecedence: false,
		selectOnTab: false,
		preload: false,
		allowEmptyOption: false,
		closeAfterSelect: false,
	
		scrollDuration: 60,
		loadThrottle: 300,
		loadingClass: 'loading',
	
		dataAttr: 'data-data',
		optgroupField: 'optgroup',
		valueField: 'value',
		labelField: 'text',
		optgroupLabelField: 'label',
		optgroupValueField: 'value',
		lockOptgroupOrder: false,
	
		sortField: '$order',
		searchField: ['text'],
		searchConjunction: 'and',
	
		mode: null,
		wrapperClass: 'selectize-control',
		inputClass: 'selectize-input',
		dropdownClass: 'selectize-dropdown',
		dropdownContentClass: 'selectize-dropdown-content',
	
		dropdownParent: null,
	
		copyClassesToDropdown: true,
	
		/*
		load                 : null, // function(query, callback) { ... }
		score                : null, // function(search) { ... }
		onInitialize         : null, // function() { ... }
		onChange             : null, // function(value) { ... }
		onItemAdd            : null, // function(value, $item) { ... }
		onItemRemove         : null, // function(value) { ... }
		onClear              : null, // function() { ... }
		onOptionAdd          : null, // function(value, data) { ... }
		onOptionRemove       : null, // function(value) { ... }
		onOptionClear        : null, // function() { ... }
		onOptionGroupAdd     : null, // function(id, data) { ... }
		onOptionGroupRemove  : null, // function(id) { ... }
		onOptionGroupClear   : null, // function() { ... }
		onDropdownOpen       : null, // function($dropdown) { ... }
		onDropdownClose      : null, // function($dropdown) { ... }
		onType               : null, // function(str) { ... }
		onDelete             : null, // function(values) { ... }
		*/
	
		render: {
			/*
			item: null,
			optgroup: null,
			optgroup_header: null,
			option: null,
			option_create: null
			*/
		}
	};
	
	
	$.fn.selectize = function(settings_user) {
		var defaults             = $.fn.selectize.defaults;
		var settings             = $.extend({}, defaults, settings_user);
		var attr_data            = settings.dataAttr;
		var field_label          = settings.labelField;
		var field_value          = settings.valueField;
		var field_optgroup       = settings.optgroupField;
		var field_optgroup_label = settings.optgroupLabelField;
		var field_optgroup_value = settings.optgroupValueField;
	
		/**
		 * Initializes selectize from a <input type="text"> element.
		 *
		 * @param {object} $input
		 * @param {object} settings_element
		 */
		var init_textbox = function($input, settings_element) {
			var i, n, values, option;
	
			var data_raw = $input.attr(attr_data);
	
			if (!data_raw) {
				var value = $.trim($input.val() || '');
				if (!settings.allowEmptyOption && !value.length) return;
				values = value.split(settings.delimiter);
				for (i = 0, n = values.length; i < n; i++) {
					option = {};
					option[field_label] = values[i];
					option[field_value] = values[i];
					settings_element.options.push(option);
				}
				settings_element.items = values;
			} else {
				settings_element.options = JSON.parse(data_raw);
				for (i = 0, n = settings_element.options.length; i < n; i++) {
					settings_element.items.push(settings_element.options[i][field_value]);
				}
			}
		};
	
		/**
		 * Initializes selectize from a <select> element.
		 *
		 * @param {object} $input
		 * @param {object} settings_element
		 */
		var init_select = function($input, settings_element) {
			var i, n, tagName, $children, order = 0;
			var options = settings_element.options;
			var optionsMap = {};
	
			var readData = function($el) {
				var data = attr_data && $el.attr(attr_data);
				if (typeof data === 'string' && data.length) {
					return JSON.parse(data);
				}
				return null;
			};
	
			var addOption = function($option, group) {
				$option = $($option);
	
				var value = hash_key($option.val());
				if (!value && !settings.allowEmptyOption) return;
	
				// if the option already exists, it's probably been
				// duplicated in another optgroup. in this case, push
				// the current group to the "optgroup" property on the
				// existing option so that it's rendered in both places.
				if (optionsMap.hasOwnProperty(value)) {
					if (group) {
						var arr = optionsMap[value][field_optgroup];
						if (!arr) {
							optionsMap[value][field_optgroup] = group;
						} else if (!$.isArray(arr)) {
							optionsMap[value][field_optgroup] = [arr, group];
						} else {
							arr.push(group);
						}
					}
					return;
				}
	
				var option             = readData($option) || {};
				option[field_label]    = option[field_label] || $option.text();
				option[field_value]    = option[field_value] || value;
				option[field_optgroup] = option[field_optgroup] || group;
	
				optionsMap[value] = option;
				options.push(option);
	
				if ($option.is(':selected')) {
					settings_element.items.push(value);
				}
			};
	
			var addGroup = function($optgroup) {
				var i, n, id, optgroup, $options;
	
				$optgroup = $($optgroup);
				id = $optgroup.attr('label');
	
				if (id) {
					optgroup = readData($optgroup) || {};
					optgroup[field_optgroup_label] = id;
					optgroup[field_optgroup_value] = id;
					settings_element.optgroups.push(optgroup);
				}
	
				$options = $('option', $optgroup);
				for (i = 0, n = $options.length; i < n; i++) {
					addOption($options[i], id);
				}
			};
	
			settings_element.maxItems = $input.attr('multiple') ? null : 1;
	
			$children = $input.children();
			for (i = 0, n = $children.length; i < n; i++) {
				tagName = $children[i].tagName.toLowerCase();
				if (tagName === 'optgroup') {
					addGroup($children[i]);
				} else if (tagName === 'option') {
					addOption($children[i]);
				}
			}
		};
	
		return this.each(function() {
			if (this.selectize) return;
	
			var instance;
			var $input = $(this);
			var tag_name = this.tagName.toLowerCase();
			var placeholder = $input.attr('placeholder') || $input.attr('data-placeholder');
			if (!placeholder && !settings.allowEmptyOption) {
				placeholder = $input.children('option[value=""]').text();
			}
	
			var settings_element = {
				'placeholder' : placeholder,
				'options'     : [],
				'optgroups'   : [],
				'items'       : []
			};
	
			if (tag_name === 'select') {
				init_select($input, settings_element);
			} else {
				init_textbox($input, settings_element);
			}
	
			instance = new Selectize($input, $.extend(true, {}, defaults, settings_element, settings_user));
		});
	};
	
	$.fn.selectize.defaults = Selectize.defaults;
	$.fn.selectize.support = {
		validity: SUPPORTS_VALIDITY_API
	};
	
	
	Selectize.define('drag_drop', function(options) {
		if (!$.fn.sortable) throw new Error('The "drag_drop" plugin requires jQuery UI "sortable".');
		if (this.settings.mode !== 'multi') return;
		var self = this;
	
		self.lock = (function() {
			var original = self.lock;
			return function() {
				var sortable = self.$control.data('sortable');
				if (sortable) sortable.disable();
				return original.apply(self, arguments);
			};
		})();
	
		self.unlock = (function() {
			var original = self.unlock;
			return function() {
				var sortable = self.$control.data('sortable');
				if (sortable) sortable.enable();
				return original.apply(self, arguments);
			};
		})();
	
		self.setup = (function() {
			var original = self.setup;
			return function() {
				original.apply(this, arguments);
	
				var $control = self.$control.sortable({
					items: '[data-value]',
					forcePlaceholderSize: true,
					disabled: self.isLocked,
					start: function(e, ui) {
						ui.placeholder.css('width', ui.helper.css('width'));
						$control.css({overflow: 'visible'});
					},
					stop: function() {
						$control.css({overflow: 'hidden'});
						var active = self.$activeItems ? self.$activeItems.slice() : null;
						var values = [];
						$control.children('[data-value]').each(function() {
							values.push($(this).attr('data-value'));
						});
						self.setValue(values);
						self.setActiveItem(active);
					}
				});
			};
		})();
	
	});
	
	Selectize.define('dropdown_header', function(options) {
		var self = this;
	
		options = $.extend({
			title         : 'Untitled',
			headerClass   : 'selectize-dropdown-header',
			titleRowClass : 'selectize-dropdown-header-title',
			labelClass    : 'selectize-dropdown-header-label',
			closeClass    : 'selectize-dropdown-header-close',
	
			html: function(data) {
				return (
					'<div class="' + data.headerClass + '">' +
						'<div class="' + data.titleRowClass + '">' +
							'<span class="' + data.labelClass + '">' + data.title + '</span>' +
							'<a href="javascript:void(0)" class="' + data.closeClass + '">&times;</a>' +
						'</div>' +
					'</div>'
				);
			}
		}, options);
	
		self.setup = (function() {
			var original = self.setup;
			return function() {
				original.apply(self, arguments);
				self.$dropdown_header = $(options.html(options));
				self.$dropdown.prepend(self.$dropdown_header);
			};
		})();
	
	});
	
	Selectize.define('optgroup_columns', function(options) {
		var self = this;
	
		options = $.extend({
			equalizeWidth  : true,
			equalizeHeight : true
		}, options);
	
		this.getAdjacentOption = function($option, direction) {
			var $options = $option.closest('[data-group]').find('[data-selectable]');
			var index    = $options.index($option) + direction;
	
			return index >= 0 && index < $options.length ? $options.eq(index) : $();
		};
	
		this.onKeyDown = (function() {
			var original = self.onKeyDown;
			return function(e) {
				var index, $option, $options, $optgroup;
	
				if (this.isOpen && (e.keyCode === KEY_LEFT || e.keyCode === KEY_RIGHT)) {
					self.ignoreHover = true;
					$optgroup = this.$activeOption.closest('[data-group]');
					index = $optgroup.find('[data-selectable]').index(this.$activeOption);
	
					if(e.keyCode === KEY_LEFT) {
						$optgroup = $optgroup.prev('[data-group]');
					} else {
						$optgroup = $optgroup.next('[data-group]');
					}
	
					$options = $optgroup.find('[data-selectable]');
					$option  = $options.eq(Math.min($options.length - 1, index));
					if ($option.length) {
						this.setActiveOption($option);
					}
					return;
				}
	
				return original.apply(this, arguments);
			};
		})();
	
		var getScrollbarWidth = function() {
			var div;
			var width = getScrollbarWidth.width;
			var doc = document;
	
			if (typeof width === 'undefined') {
				div = doc.createElement('div');
				div.innerHTML = '<div style="width:50px;height:50px;position:absolute;left:-50px;top:-50px;overflow:auto;"><div style="width:1px;height:100px;"></div></div>';
				div = div.firstChild;
				doc.body.appendChild(div);
				width = getScrollbarWidth.width = div.offsetWidth - div.clientWidth;
				doc.body.removeChild(div);
			}
			return width;
		};
	
		var equalizeSizes = function() {
			var i, n, height_max, width, width_last, width_parent, $optgroups;
	
			$optgroups = $('[data-group]', self.$dropdown_content);
			n = $optgroups.length;
			if (!n || !self.$dropdown_content.width()) return;
	
			if (options.equalizeHeight) {
				height_max = 0;
				for (i = 0; i < n; i++) {
					height_max = Math.max(height_max, $optgroups.eq(i).height());
				}
				$optgroups.css({height: height_max});
			}
	
			if (options.equalizeWidth) {
				width_parent = self.$dropdown_content.innerWidth() - getScrollbarWidth();
				width = Math.round(width_parent / n);
				$optgroups.css({width: width});
				if (n > 1) {
					width_last = width_parent - width * (n - 1);
					$optgroups.eq(n - 1).css({width: width_last});
				}
			}
		};
	
		if (options.equalizeHeight || options.equalizeWidth) {
			hook.after(this, 'positionDropdown', equalizeSizes);
			hook.after(this, 'refreshOptions', equalizeSizes);
		}
	
	
	});
	
	Selectize.define('remove_button', function(options) {
		options = $.extend({
				label     : '&times;',
				title     : 'Remove',
				className : 'remove',
				append    : true
			}, options);
	
			var singleClose = function(thisRef, options) {
	
				options.className = 'remove-single';
	
				var self = thisRef;
				var html = '<a href="javascript:void(0)" class="' + options.className + '" tabindex="-1" title="' + escape_html(options.title) + '">' + options.label + '</a>';
	
				/**
				 * Appends an element as a child (with raw HTML).
				 *
				 * @param {string} html_container
				 * @param {string} html_element
				 * @return {string}
				 */
				var append = function(html_container, html_element) {
					return html_container + html_element;
				};
	
				thisRef.setup = (function() {
					var original = self.setup;
					return function() {
						// override the item rendering method to add the button to each
						if (options.append) {
							var id = $(self.$input.context).attr('id');
							var selectizer = $('#'+id);
	
							var render_item = self.settings.render.item;
							self.settings.render.item = function(data) {
								return append(render_item.apply(thisRef, arguments), html);
							};
						}
	
						original.apply(thisRef, arguments);
	
						// add event listener
						thisRef.$control.on('click', '.' + options.className, function(e) {
							e.preventDefault();
							if (self.isLocked) return;
	
							self.clear();
						});
	
					};
				})();
			};
	
			var multiClose = function(thisRef, options) {
	
				var self = thisRef;
				var html = '<a href="javascript:void(0)" class="' + options.className + '" tabindex="-1" title="' + escape_html(options.title) + '">' + options.label + '</a>';
	
				/**
				 * Appends an element as a child (with raw HTML).
				 *
				 * @param {string} html_container
				 * @param {string} html_element
				 * @return {string}
				 */
				var append = function(html_container, html_element) {
					var pos = html_container.search(/(<\/[^>]+>\s*)$/);
					return html_container.substring(0, pos) + html_element + html_container.substring(pos);
				};
	
				thisRef.setup = (function() {
					var original = self.setup;
					return function() {
						// override the item rendering method to add the button to each
						if (options.append) {
							var render_item = self.settings.render.item;
							self.settings.render.item = function(data) {
								return append(render_item.apply(thisRef, arguments), html);
							};
						}
	
						original.apply(thisRef, arguments);
	
						// add event listener
						thisRef.$control.on('click', '.' + options.className, function(e) {
							e.preventDefault();
							if (self.isLocked) return;
	
							var $item = $(e.currentTarget).parent();
							self.setActiveItem($item);
							if (self.deleteSelection()) {
								self.setCaret(self.items.length);
							}
						});
	
					};
				})();
			};
	
			if (this.settings.mode === 'single') {
				singleClose(this, options);
				return;
			} else {
				multiClose(this, options);
			}
	});
	
	
	Selectize.define('restore_on_backspace', function(options) {
		var self = this;
	
		options.text = options.text || function(option) {
			return option[this.settings.labelField];
		};
	
		this.onKeyDown = (function() {
			var original = self.onKeyDown;
			return function(e) {
				var index, option;
				if (e.keyCode === KEY_BACKSPACE && this.$control_input.val() === '' && !this.$activeItems.length) {
					index = this.caretPos - 1;
					if (index >= 0 && index < this.items.length) {
						option = this.options[this.items[index]];
						if (this.deleteSelection(e)) {
							this.setTextboxValue(options.text.apply(this, [option]));
							this.refreshOptions(true);
						}
						e.preventDefault();
						return;
					}
				}
				return original.apply(this, arguments);
			};
		})();
	});
	

	return Selectize;
}));
/* =========================================================
 * bootstrap-datepicker.js
 * http://www.eyecon.ro/bootstrap-datepicker
 * =========================================================
 * Copyright 2012 Stefan Petre
 * Improvements by Andrew Rowls
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */

(function( $ ) {

	function UTCDate(){
		return new Date(Date.UTC.apply(Date, arguments));
	}
	function UTCToday(){
		var today = new Date();
		return UTCDate(today.getUTCFullYear(), today.getUTCMonth(), today.getUTCDate());
	}

	// Picker object

	var Datepicker = function(element, options) {
		var that = this;

		this._process_options(options);

		this.element = $(element);
		this.isInline = false;
		this.isInput = this.element.is('input');
		this.component = this.element.is('.date') ? this.element.find('.add-on, .btn') : false;
		this.hasInput = this.component && this.element.find('input').length;
		if(this.component && this.component.length === 0)
			this.component = false;

		this.picker = $(DPGlobal.template);
		this._buildEvents();
		this._attachEvents();

		if(this.isInline) {
			this.picker.addClass('datepicker-inline').appendTo(this.element);
		} else {
			this.picker.addClass('datepicker-dropdown dropdown-menu');
		}

		if (this.o.rtl){
			this.picker.addClass('datepicker-rtl');
			this.picker.find('.prev i, .next i')
						.toggleClass('glyphicon-chevron-left glyphicon-chevron-right');
		}


		this.viewMode = this.o.startView;

		if (this.o.calendarWeeks)
			this.picker.find('tfoot th.today')
						.attr('colspan', function(i, val){
							return parseInt(val) + 1;
						});

		this._allow_update = false;

		this.setStartDate(this.o.startDate);
		this.setEndDate(this.o.endDate);
		this.setDaysOfWeekDisabled(this.o.daysOfWeekDisabled);

		this.fillDow();
		this.fillMonths();

		this._allow_update = true;

		this.update();
		this.showMode();

		if(this.isInline) {
			this.show();
		}
	};

	Datepicker.prototype = {
		constructor: Datepicker,

		_process_options: function(opts){
			// Store raw options for reference
			this._o = $.extend({}, this._o, opts);
			// Processed options
			var o = this.o = $.extend({}, this._o);

			// Check if "de-DE" style date is available, if not language should
			// fallback to 2 letter code eg "de"
			var lang = o.language;
			if (!dates[lang]) {
				lang = lang.split('-')[0];
				if (!dates[lang])
					lang = defaults.language;
			}
			o.language = lang;

			switch(o.startView){
				case 2:
				case 'decade':
					o.startView = 2;
					break;
				case 1:
				case 'year':
					o.startView = 1;
					break;
				default:
					o.startView = 0;
			}

			switch (o.minViewMode) {
				case 1:
				case 'months':
					o.minViewMode = 1;
					break;
				case 2:
				case 'years':
					o.minViewMode = 2;
					break;
				default:
					o.minViewMode = 0;
			}

			o.startView = Math.max(o.startView, o.minViewMode);

			o.weekStart %= 7;
			o.weekEnd = ((o.weekStart + 6) % 7);

			var format = DPGlobal.parseFormat(o.format)
			if (o.startDate !== -Infinity) {
				o.startDate = DPGlobal.parseDate(o.startDate, format, o.language);
			}
			if (o.endDate !== Infinity) {
				o.endDate = DPGlobal.parseDate(o.endDate, format, o.language);
			}

			o.daysOfWeekDisabled = o.daysOfWeekDisabled||[];
			if (!$.isArray(o.daysOfWeekDisabled))
				o.daysOfWeekDisabled = o.daysOfWeekDisabled.split(/[,\s]*/);
			o.daysOfWeekDisabled = $.map(o.daysOfWeekDisabled, function (d) {
				return parseInt(d, 10);
			});
		},
		_events: [],
		_secondaryEvents: [],
		_applyEvents: function(evs){
			for (var i=0, el, ev; i<evs.length; i++){
				el = evs[i][0];
				ev = evs[i][1];
				el.on(ev);
			}
		},
		_unapplyEvents: function(evs){
			for (var i=0, el, ev; i<evs.length; i++){
				el = evs[i][0];
				ev = evs[i][1];
				el.off(ev);
			}
		},
		_buildEvents: function(){
			if (this.isInput) { // single input
				this._events = [
					[this.element, {
						focus: $.proxy(this.show, this),
						keyup: $.proxy(this.update, this),
						keydown: $.proxy(this.keydown, this)
					}]
				];
			}
			else if (this.component && this.hasInput){ // component: input + button
				this._events = [
					// For components that are not readonly, allow keyboard nav
					[this.element.find('input'), {
						focus: $.proxy(this.show, this),
						keyup: $.proxy(this.update, this),
						keydown: $.proxy(this.keydown, this)
					}],
					[this.component, {
						click: $.proxy(this.show, this)
					}]
				];
			}
			else if (this.element.is('div')) {  // inline datepicker
				this.isInline = true;
			}
			else {
				this._events = [
					[this.element, {
						click: $.proxy(this.show, this)
					}]
				];
			}

			this._secondaryEvents = [
				[this.picker, {
					click: $.proxy(this.click, this)
				}],
				[$(window), {
					resize: $.proxy(this.place, this)
				}],
				[$(document), {
					'mousedown touchstart': $.proxy(function (e) {
						// Clicked outside the datepicker, hide it
						if (!(
								this.element.is(e.target) ||
								this.element.find(e.target).length ||
								this.picker.is(e.target) ||
								this.picker.find(e.target).length
						)) {
							this.hide();
						}
					}, this)
				}]
			];
		},
		_attachEvents: function(){
			this._detachEvents();
			this._applyEvents(this._events);
		},
		_detachEvents: function(){
			this._unapplyEvents(this._events);
		},
		_attachSecondaryEvents: function(){
			this._detachSecondaryEvents();
			this._applyEvents(this._secondaryEvents);
		},
		_detachSecondaryEvents: function(){
			this._unapplyEvents(this._secondaryEvents);
		},
		_trigger: function(event, altdate){
			var date = altdate || this.date,
				local_date = new Date(date.getTime() + (date.getTimezoneOffset()*60000));

			this.element.trigger({
				type: event,
				date: local_date,
				format: $.proxy(function(altformat){
					var format = altformat || this.o.format;
					return DPGlobal.formatDate(date, format, this.o.language);
				}, this)
			});
		},

		show: function(e) {
			if (!this.isInline)
				this.picker.appendTo('body');
			this.picker.show();
			this.height = this.component ? this.component.outerHeight() : this.element.outerHeight();
			this.place();
			this._attachSecondaryEvents();
			if (e) {
				e.preventDefault();
			}
			this._trigger('show');
		},

		hide: function(e){
			if(this.isInline) return;
			if (!this.picker.is(':visible')) return;
			this.picker.hide().detach();
			this._detachSecondaryEvents();
			this.viewMode = this.o.startView;
			this.showMode();

			if (
				this.o.forceParse &&
				(
					this.isInput && this.element.val() ||
					this.hasInput && this.element.find('input').val()
				)
			)
				this.setValue();
			this._trigger('hide');
		},

		remove: function() {
			this.hide();
			this._detachEvents();
			this._detachSecondaryEvents();
			this.picker.remove();
			delete this.element.data().datepicker;
			if (!this.isInput) {
				delete this.element.data().date;
			}
		},

		getDate: function() {
			var d = this.getUTCDate();
			return new Date(d.getTime() + (d.getTimezoneOffset()*60000));
		},

		getUTCDate: function() {
			return this.date;
		},

		setDate: function(d) {
			this.setUTCDate(new Date(d.getTime() - (d.getTimezoneOffset()*60000)));
		},

		setUTCDate: function(d) {
			this.date = d;
			this.setValue();
		},

		setValue: function() {
			var formatted = this.getFormattedDate();
			if (!this.isInput) {
				if (this.component){
					this.element.find('input').val(formatted);
				}
			} else {
				this.element.val(formatted);
			}
		},

		getFormattedDate: function(format) {
			if (format === undefined)
				format = this.o.format;
			return DPGlobal.formatDate(this.date, format, this.o.language);
		},

		setStartDate: function(startDate){
			this._process_options({startDate: startDate});
			this.update();
			this.updateNavArrows();
		},

		setEndDate: function(endDate){
			this._process_options({endDate: endDate});
			this.update();
			this.updateNavArrows();
		},

		setDaysOfWeekDisabled: function(daysOfWeekDisabled){
			this._process_options({daysOfWeekDisabled: daysOfWeekDisabled});
			this.update();
			this.updateNavArrows();
		},

		place: function(){
						if(this.isInline) return;
			var zIndex = parseInt(this.element.parents().filter(function() {
							return $(this).css('z-index') != 'auto';
						}).first().css('z-index'))+10;
			var offset = this.component ? this.component.parent().offset() : this.element.offset();
			var height = this.component ? this.component.outerHeight(true) : this.element.outerHeight(true);
			this.picker.css({
				top: offset.top + height,
				left: offset.left,
				zIndex: zIndex
			});
		},

		_allow_update: true,
		update: function(){
			if (!this._allow_update) return;

			var date, fromArgs = false;
			if(arguments && arguments.length && (typeof arguments[0] === 'string' || arguments[0] instanceof Date)) {
				date = arguments[0];
				fromArgs = true;
			} else {
				date = this.isInput ? this.element.val() : this.element.data('date') || this.element.find('input').val();
				delete this.element.data().date;
			}

			this.date = DPGlobal.parseDate(date, this.o.format, this.o.language);

			if(fromArgs) this.setValue();

			if (this.date < this.o.startDate) {
				this.viewDate = new Date(this.o.startDate);
			} else if (this.date > this.o.endDate) {
				this.viewDate = new Date(this.o.endDate);
			} else {
				this.viewDate = new Date(this.date);
			}
			this.fill();
		},

		fillDow: function(){
			var dowCnt = this.o.weekStart,
			html = '<tr>';
			if(this.o.calendarWeeks){
				var cell = '<th class="cw">&nbsp;</th>';
				html += cell;
				this.picker.find('.datepicker-days thead tr:first-child').prepend(cell);
			}
			while (dowCnt < this.o.weekStart + 7) {
				html += '<th class="dow">'+dates[this.o.language].daysMin[(dowCnt++)%7]+'</th>';
			}
			html += '</tr>';
			this.picker.find('.datepicker-days thead').append(html);
		},

		fillMonths: function(){
			var html = '',
			i = 0;
			while (i < 12) {
				html += '<span class="month">'+dates[this.o.language].monthsShort[i++]+'</span>';
			}
			this.picker.find('.datepicker-months td').html(html);
		},

		setRange: function(range){
			if (!range || !range.length)
				delete this.range;
			else
				this.range = $.map(range, function(d){ return d.valueOf(); });
			this.fill();
		},

		getClassNames: function(date){
			var cls = [],
				year = this.viewDate.getUTCFullYear(),
				month = this.viewDate.getUTCMonth(),
				currentDate = this.date.valueOf(),
				today = new Date();
			if (date.getUTCFullYear() < year || (date.getUTCFullYear() == year && date.getUTCMonth() < month)) {
				cls.push('old');
			} else if (date.getUTCFullYear() > year || (date.getUTCFullYear() == year && date.getUTCMonth() > month)) {
				cls.push('new');
			}
			// Compare internal UTC date with local today, not UTC today
			if (this.o.todayHighlight &&
				date.getUTCFullYear() == today.getFullYear() &&
				date.getUTCMonth() == today.getMonth() &&
				date.getUTCDate() == today.getDate()) {
				cls.push('today');
			}
			if (currentDate && date.valueOf() == currentDate) {
				cls.push('active');
			}
			if (date.valueOf() < this.o.startDate || date.valueOf() > this.o.endDate ||
				$.inArray(date.getUTCDay(), this.o.daysOfWeekDisabled) !== -1) {
				cls.push('disabled');
			}
			if (this.range){
				if (date > this.range[0] && date < this.range[this.range.length-1]){
					cls.push('range');
				}
				if ($.inArray(date.valueOf(), this.range) != -1){
					cls.push('selected');
				}
			}
			return cls;
		},

		fill: function() {
			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth(),
				startYear = this.o.startDate !== -Infinity ? this.o.startDate.getUTCFullYear() : -Infinity,
				startMonth = this.o.startDate !== -Infinity ? this.o.startDate.getUTCMonth() : -Infinity,
				endYear = this.o.endDate !== Infinity ? this.o.endDate.getUTCFullYear() : Infinity,
				endMonth = this.o.endDate !== Infinity ? this.o.endDate.getUTCMonth() : Infinity,
				currentDate = this.date && this.date.valueOf(),
				tooltip;
			this.picker.find('.datepicker-days thead th.datepicker-switch')
						.text(dates[this.o.language].months[month]+' '+year);
			this.picker.find('tfoot th.today')
						.text(dates[this.o.language].today)
						.toggle(this.o.todayBtn !== false);
			this.picker.find('tfoot th.clear')
						.text(dates[this.o.language].clear)
						.toggle(this.o.clearBtn !== false);
			this.updateNavArrows();
			this.fillMonths();
			var prevMonth = UTCDate(year, month-1, 28,0,0,0,0),
				day = DPGlobal.getDaysInMonth(prevMonth.getUTCFullYear(), prevMonth.getUTCMonth());
			prevMonth.setUTCDate(day);
			prevMonth.setUTCDate(day - (prevMonth.getUTCDay() - this.o.weekStart + 7)%7);
			var nextMonth = new Date(prevMonth);
			nextMonth.setUTCDate(nextMonth.getUTCDate() + 42);
			nextMonth = nextMonth.valueOf();
			var html = [];
			var clsName;
			while(prevMonth.valueOf() < nextMonth) {
				if (prevMonth.getUTCDay() == this.o.weekStart) {
					html.push('<tr>');
					if(this.o.calendarWeeks){
						// ISO 8601: First week contains first thursday.
						// ISO also states week starts on Monday, but we can be more abstract here.
						var
							// Start of current week: based on weekstart/current date
							ws = new Date(+prevMonth + (this.o.weekStart - prevMonth.getUTCDay() - 7) % 7 * 864e5),
							// Thursday of this week
							th = new Date(+ws + (7 + 4 - ws.getUTCDay()) % 7 * 864e5),
							// First Thursday of year, year from thursday
							yth = new Date(+(yth = UTCDate(th.getUTCFullYear(), 0, 1)) + (7 + 4 - yth.getUTCDay())%7*864e5),
							// Calendar week: ms between thursdays, div ms per day, div 7 days
							calWeek =  (th - yth) / 864e5 / 7 + 1;
						html.push('<td class="cw">'+ calWeek +'</td>');

					}
				}
				clsName = this.getClassNames(prevMonth);
				clsName.push('day');

				var before = this.o.beforeShowDay(prevMonth);
				if (before === undefined)
					before = {};
				else if (typeof(before) === 'boolean')
					before = {enabled: before};
				else if (typeof(before) === 'string')
					before = {classes: before};
				if (before.enabled === false)
					clsName.push('disabled');
				if (before.classes)
					clsName = clsName.concat(before.classes.split(/\s+/));
				if (before.tooltip)
					tooltip = before.tooltip;

				clsName = $.unique(clsName);
				html.push('<td class="'+clsName.join(' ')+'"' + (tooltip ? ' title="'+tooltip+'"' : '') + '>'+prevMonth.getUTCDate() + '</td>');
				if (prevMonth.getUTCDay() == this.o.weekEnd) {
					html.push('</tr>');
				}
				prevMonth.setUTCDate(prevMonth.getUTCDate()+1);
			}
			this.picker.find('.datepicker-days tbody').empty().append(html.join(''));
			var currentYear = this.date && this.date.getUTCFullYear();

			var months = this.picker.find('.datepicker-months')
						.find('th:eq(1)')
							.text(year)
							.end()
						.find('span').removeClass('active');
			if (currentYear && currentYear == year) {
				months.eq(this.date.getUTCMonth()).addClass('active');
			}
			if (year < startYear || year > endYear) {
				months.addClass('disabled');
			}
			if (year == startYear) {
				months.slice(0, startMonth).addClass('disabled');
			}
			if (year == endYear) {
				months.slice(endMonth+1).addClass('disabled');
			}

			html = '';
			year = parseInt(year/10, 10) * 10;
			var yearCont = this.picker.find('.datepicker-years')
								.find('th:eq(1)')
									.text(year + '-' + (year + 9))
									.end()
								.find('td');
			year -= 1;
			for (var i = -1; i < 11; i++) {
				html += '<span class="year'+(i == -1 ? ' old' : i == 10 ? ' new' : '')+(currentYear == year ? ' active' : '')+(year < startYear || year > endYear ? ' disabled' : '')+'">'+year+'</span>';
				year += 1;
			}
			yearCont.html(html);
		},

		updateNavArrows: function() {
			if (!this._allow_update) return;

			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth();
			switch (this.viewMode) {
				case 0:
					if (this.o.startDate !== -Infinity && year <= this.o.startDate.getUTCFullYear() && month <= this.o.startDate.getUTCMonth()) {
						this.picker.find('.prev').css({visibility: 'hidden'});
					} else {
						this.picker.find('.prev').css({visibility: 'visible'});
					}
					if (this.o.endDate !== Infinity && year >= this.o.endDate.getUTCFullYear() && month >= this.o.endDate.getUTCMonth()) {
						this.picker.find('.next').css({visibility: 'hidden'});
					} else {
						this.picker.find('.next').css({visibility: 'visible'});
					}
					break;
				case 1:
				case 2:
					if (this.o.startDate !== -Infinity && year <= this.o.startDate.getUTCFullYear()) {
						this.picker.find('.prev').css({visibility: 'hidden'});
					} else {
						this.picker.find('.prev').css({visibility: 'visible'});
					}
					if (this.o.endDate !== Infinity && year >= this.o.endDate.getUTCFullYear()) {
						this.picker.find('.next').css({visibility: 'hidden'});
					} else {
						this.picker.find('.next').css({visibility: 'visible'});
					}
					break;
			}
		},

		click: function(e) {
			e.preventDefault();
			var target = $(e.target).closest('span, td, th');
			if (target.length == 1) {
				switch(target[0].nodeName.toLowerCase()) {
					case 'th':
						switch(target[0].className) {
							case 'datepicker-switch':
								this.showMode(1);
								break;
							case 'prev':
							case 'next':
								var dir = DPGlobal.modes[this.viewMode].navStep * (target[0].className == 'prev' ? -1 : 1);
								switch(this.viewMode){
									case 0:
										this.viewDate = this.moveMonth(this.viewDate, dir);
										break;
									case 1:
									case 2:
										this.viewDate = this.moveYear(this.viewDate, dir);
										break;
								}
								this.fill();
								break;
							case 'today':
								var date = new Date();
								date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);

								this.showMode(-2);
								var which = this.o.todayBtn == 'linked' ? null : 'view';
								this._setDate(date, which);
								break;
							case 'clear':
								var element;
								if (this.isInput)
									element = this.element;
								else if (this.component)
									element = this.element.find('input');
								if (element)
									element.val("").change();
								this._trigger('changeDate');
								this.update();
								if (this.o.autoclose)
									this.hide();
								break;
						}
						break;
					case 'span':
						if (!target.is('.disabled')) {
							this.viewDate.setUTCDate(1);
							if (target.is('.month')) {
								var day = 1;
								var month = target.parent().find('span').index(target);
								var year = this.viewDate.getUTCFullYear();
								this.viewDate.setUTCMonth(month);
								this._trigger('changeMonth', this.viewDate);
								if (this.o.minViewMode === 1) {
									this._setDate(UTCDate(year, month, day,0,0,0,0));
								}
							} else {
								var year = parseInt(target.text(), 10)||0;
								var day = 1;
								var month = 0;
								this.viewDate.setUTCFullYear(year);
								this._trigger('changeYear', this.viewDate);
								if (this.o.minViewMode === 2) {
									this._setDate(UTCDate(year, month, day,0,0,0,0));
								}
							}
							this.showMode(-1);
							this.fill();
						}
						break;
					case 'td':
						if (target.is('.day') && !target.is('.disabled')){
							var day = parseInt(target.text(), 10)||1;
							var year = this.viewDate.getUTCFullYear(),
								month = this.viewDate.getUTCMonth();
							if (target.is('.old')) {
								if (month === 0) {
									month = 11;
									year -= 1;
								} else {
									month -= 1;
								}
							} else if (target.is('.new')) {
								if (month == 11) {
									month = 0;
									year += 1;
								} else {
									month += 1;
								}
							}
							this._setDate(UTCDate(year, month, day,0,0,0,0));
						}
						break;
				}
			}
		},

		_setDate: function(date, which){
			if (!which || which == 'date')
				this.date = new Date(date);
			if (!which || which  == 'view')
				this.viewDate = new Date(date);
			this.fill();
			this.setValue();
			this._trigger('changeDate');
			var element;
			if (this.isInput) {
				element = this.element;
			} else if (this.component){
				element = this.element.find('input');
			}
			if (element) {
				element.change();
				if (this.o.autoclose && (!which || which == 'date')) {
					this.hide();
				}
			}
		},

		moveMonth: function(date, dir){
			if (!dir) return date;
			var new_date = new Date(date.valueOf()),
				day = new_date.getUTCDate(),
				month = new_date.getUTCMonth(),
				mag = Math.abs(dir),
				new_month, test;
			dir = dir > 0 ? 1 : -1;
			if (mag == 1){
				test = dir == -1
					// If going back one month, make sure month is not current month
					// (eg, Mar 31 -> Feb 31 == Feb 28, not Mar 02)
					? function(){ return new_date.getUTCMonth() == month; }
					// If going forward one month, make sure month is as expected
					// (eg, Jan 31 -> Feb 31 == Feb 28, not Mar 02)
					: function(){ return new_date.getUTCMonth() != new_month; };
				new_month = month + dir;
				new_date.setUTCMonth(new_month);
				// Dec -> Jan (12) or Jan -> Dec (-1) -- limit expected date to 0-11
				if (new_month < 0 || new_month > 11)
					new_month = (new_month + 12) % 12;
			} else {
				// For magnitudes >1, move one month at a time...
				for (var i=0; i<mag; i++)
					// ...which might decrease the day (eg, Jan 31 to Feb 28, etc)...
					new_date = this.moveMonth(new_date, dir);
				// ...then reset the day, keeping it in the new month
				new_month = new_date.getUTCMonth();
				new_date.setUTCDate(day);
				test = function(){ return new_month != new_date.getUTCMonth(); };
			}
			// Common date-resetting loop -- if date is beyond end of month, make it
			// end of month
			while (test()){
				new_date.setUTCDate(--day);
				new_date.setUTCMonth(new_month);
			}
			return new_date;
		},

		moveYear: function(date, dir){
			return this.moveMonth(date, dir*12);
		},

		dateWithinRange: function(date){
			return date >= this.o.startDate && date <= this.o.endDate;
		},

		keydown: function(e){
			if (this.picker.is(':not(:visible)')){
				if (e.keyCode == 27) // allow escape to hide and re-show picker
					this.show();
				return;
			}
			var dateChanged = false,
				dir, day, month,
				newDate, newViewDate;
			switch(e.keyCode){
				case 27: // escape
					this.hide();
					e.preventDefault();
					break;
				case 37: // left
				case 39: // right
					if (!this.o.keyboardNavigation) break;
					dir = e.keyCode == 37 ? -1 : 1;
					if (e.ctrlKey){
						newDate = this.moveYear(this.date, dir);
						newViewDate = this.moveYear(this.viewDate, dir);
					} else if (e.shiftKey){
						newDate = this.moveMonth(this.date, dir);
						newViewDate = this.moveMonth(this.viewDate, dir);
					} else {
						newDate = new Date(this.date);
						newDate.setUTCDate(this.date.getUTCDate() + dir);
						newViewDate = new Date(this.viewDate);
						newViewDate.setUTCDate(this.viewDate.getUTCDate() + dir);
					}
					if (this.dateWithinRange(newDate)){
						this.date = newDate;
						this.viewDate = newViewDate;
						this.setValue();
						this.update();
						e.preventDefault();
						dateChanged = true;
					}
					break;
				case 38: // up
				case 40: // down
					if (!this.o.keyboardNavigation) break;
					dir = e.keyCode == 38 ? -1 : 1;
					if (e.ctrlKey){
						newDate = this.moveYear(this.date, dir);
						newViewDate = this.moveYear(this.viewDate, dir);
					} else if (e.shiftKey){
						newDate = this.moveMonth(this.date, dir);
						newViewDate = this.moveMonth(this.viewDate, dir);
					} else {
						newDate = new Date(this.date);
						newDate.setUTCDate(this.date.getUTCDate() + dir * 7);
						newViewDate = new Date(this.viewDate);
						newViewDate.setUTCDate(this.viewDate.getUTCDate() + dir * 7);
					}
					if (this.dateWithinRange(newDate)){
						this.date = newDate;
						this.viewDate = newViewDate;
						this.setValue();
						this.update();
						e.preventDefault();
						dateChanged = true;
					}
					break;
				case 13: // enter
					this.hide();
					e.preventDefault();
					break;
				case 9: // tab
					this.hide();
					break;
			}
			if (dateChanged){
				this._trigger('changeDate');
				var element;
				if (this.isInput) {
					element = this.element;
				} else if (this.component){
					element = this.element.find('input');
				}
				if (element) {
					element.change();
				}
			}
		},

		showMode: function(dir) {
			if (dir) {
				this.viewMode = Math.max(this.o.minViewMode, Math.min(2, this.viewMode + dir));
			}
			/*
				vitalets: fixing bug of very special conditions:
				jquery 1.7.1 + webkit + show inline datepicker in bootstrap popover.
				Method show() does not set display css correctly and datepicker is not shown.
				Changed to .css('display', 'block') solve the problem.
				See https://github.com/vitalets/x-editable/issues/37

				In jquery 1.7.2+ everything works fine.
			*/
			//this.picker.find('>div').hide().filter('.datepicker-'+DPGlobal.modes[this.viewMode].clsName).show();
			this.picker.find('>div').hide().filter('.datepicker-'+DPGlobal.modes[this.viewMode].clsName).css('display', 'block');
			this.updateNavArrows();
		}
	};

	var DateRangePicker = function(element, options){
		this.element = $(element);
		this.inputs = $.map(options.inputs, function(i){ return i.jquery ? i[0] : i; });
		delete options.inputs;

		$(this.inputs)
			.datepicker(options)
			.bind('changeDate', $.proxy(this.dateUpdated, this));

		this.pickers = $.map(this.inputs, function(i){ return $(i).data('datepicker'); });
		this.updateDates();
	};
	DateRangePicker.prototype = {
		updateDates: function(){
			this.dates = $.map(this.pickers, function(i){ return i.date; });
			this.updateRanges();
		},
		updateRanges: function(){
			var range = $.map(this.dates, function(d){ return d.valueOf(); });
			$.each(this.pickers, function(i, p){
				p.setRange(range);
			});
		},
		dateUpdated: function(e){
			var dp = $(e.target).data('datepicker'),
				new_date = dp.getUTCDate(),
				i = $.inArray(e.target, this.inputs),
				l = this.inputs.length;
			if (i == -1) return;

			if (new_date < this.dates[i]){
				// Date being moved earlier/left
				while (i>=0 && new_date < this.dates[i]){
					this.pickers[i--].setUTCDate(new_date);
				}
			}
			else if (new_date > this.dates[i]){
				// Date being moved later/right
				while (i<l && new_date > this.dates[i]){
					this.pickers[i++].setUTCDate(new_date);
				}
			}
			this.updateDates();
		},
		remove: function(){
			$.map(this.pickers, function(p){ p.remove(); });
			delete this.element.data().datepicker;
		}
	};

	function opts_from_el(el, prefix){
		// Derive options from element data-attrs
		var data = $(el).data(),
			out = {}, inkey,
			replace = new RegExp('^' + prefix.toLowerCase() + '([A-Z])'),
			prefix = new RegExp('^' + prefix.toLowerCase());
		for (var key in data)
			if (prefix.test(key)){
				inkey = key.replace(replace, function(_,a){ return a.toLowerCase(); });
				out[inkey] = data[key];
			}
		return out;
	}

	function opts_from_locale(lang){
		// Derive options from locale plugins
		var out = {};
		// Check if "de-DE" style date is available, if not language should
		// fallback to 2 letter code eg "de"
		if (!dates[lang]) {
			lang = lang.split('-')[0]
			if (!dates[lang])
				return;
		}
		var d = dates[lang];
		$.each(locale_opts, function(i,k){
			if (k in d)
				out[k] = d[k];
		});
		return out;
	}

	var old = $.fn.datepicker;
	$.fn.datepicker = function ( option ) {
		var args = Array.apply(null, arguments);
		args.shift();
		var internal_return,
			this_return;
		this.each(function () {
			var $this = $(this),
				data = $this.data('datepicker'),
				options = typeof option == 'object' && option;
			if (!data) {
				var elopts = opts_from_el(this, 'date'),
					// Preliminary otions
					xopts = $.extend({}, defaults, elopts, options),
					locopts = opts_from_locale(xopts.language),
					// Options priority: js args, data-attrs, locales, defaults
					opts = $.extend({}, defaults, locopts, elopts, options);
				if ($this.is('.input-daterange') || opts.inputs){
					var ropts = {
						inputs: opts.inputs || $this.find('input').toArray()
					};
					$this.data('datepicker', (data = new DateRangePicker(this, $.extend(opts, ropts))));
				}
				else{
					$this.data('datepicker', (data = new Datepicker(this, opts)));
				}
			}
			if (typeof option == 'string' && typeof data[option] == 'function') {
				internal_return = data[option].apply(data, args);
				if (internal_return !== undefined)
					return false;
			}
		});
		if (internal_return !== undefined)
			return internal_return;
		else
			return this;
	};

	var defaults = $.fn.datepicker.defaults = {
		autoclose: false,
		beforeShowDay: $.noop,
		calendarWeeks: false,
		clearBtn: false,
		daysOfWeekDisabled: [],
		endDate: Infinity,
		forceParse: true,
		format: 'mm/dd/yyyy',
		keyboardNavigation: true,
		language: 'en',
		minViewMode: 0,
		rtl: false,
		startDate: -Infinity,
		startView: 0,
		todayBtn: false,
		todayHighlight: false,
		weekStart: 0
	};
	var locale_opts = $.fn.datepicker.locale_opts = [
		'format',
		'rtl',
		'weekStart'
	];
	$.fn.datepicker.Constructor = Datepicker;
	var dates = $.fn.datepicker.dates = {
		en: {
			days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
			daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
			daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
			months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
			monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			today: "Today",
			clear: "Clear"
		}
	};

	var DPGlobal = {
		modes: [
			{
				clsName: 'days',
				navFnc: 'Month',
				navStep: 1
			},
			{
				clsName: 'months',
				navFnc: 'FullYear',
				navStep: 1
			},
			{
				clsName: 'years',
				navFnc: 'FullYear',
				navStep: 10
		}],
		isLeapYear: function (year) {
			return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
		},
		getDaysInMonth: function (year, month) {
			return [31, (DPGlobal.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
		},
		validParts: /dd?|DD?|mm?|MM?|yy(?:yy)?/g,
		nonpunctuation: /[^ -\/:-@\[\u3400-\u9fff-`{-~\t\n\r]+/g,
		parseFormat: function(format){
			// IE treats \0 as a string end in inputs (truncating the value),
			// so it's a bad format delimiter, anyway
			var separators = format.replace(this.validParts, '\0').split('\0'),
				parts = format.match(this.validParts);
			if (!separators || !separators.length || !parts || parts.length === 0){
				throw new Error("Invalid date format.");
			}
			return {separators: separators, parts: parts};
		},
		parseDate: function(date, format, language) {
			if (date instanceof Date) return date;
			if (typeof format === 'string')
				format = DPGlobal.parseFormat(format);
			if (/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/.test(date)) {
				var part_re = /([\-+]\d+)([dmwy])/,
					parts = date.match(/([\-+]\d+)([dmwy])/g),
					part, dir;
				date = new Date();
				for (var i=0; i<parts.length; i++) {
					part = part_re.exec(parts[i]);
					dir = parseInt(part[1]);
					switch(part[2]){
						case 'd':
							date.setUTCDate(date.getUTCDate() + dir);
							break;
						case 'm':
							date = Datepicker.prototype.moveMonth.call(Datepicker.prototype, date, dir);
							break;
						case 'w':
							date.setUTCDate(date.getUTCDate() + dir * 7);
							break;
						case 'y':
							date = Datepicker.prototype.moveYear.call(Datepicker.prototype, date, dir);
							break;
					}
				}
				return UTCDate(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(), 0, 0, 0);
			}
			var parts = date && date.match(this.nonpunctuation) || [],
				date = new Date(),
				parsed = {},
				setters_order = ['yyyy', 'yy', 'M', 'MM', 'm', 'mm', 'd', 'dd'],
				setters_map = {
					yyyy: function(d,v){ return d.setUTCFullYear(v); },
					yy: function(d,v){ return d.setUTCFullYear(2000+v); },
					m: function(d,v){
						if (isNaN(d))
							return d;
						v -= 1;
						while (v<0) v += 12;
						v %= 12;
						d.setUTCMonth(v);
						while (d.getUTCMonth() != v)
							d.setUTCDate(d.getUTCDate()-1);
						return d;
					},
					d: function(d,v){ return d.setUTCDate(v); }
				},
				val, filtered, part;
			setters_map['M'] = setters_map['MM'] = setters_map['mm'] = setters_map['m'];
			setters_map['dd'] = setters_map['d'];
			date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);
			var fparts = format.parts.slice();
			// Remove noop parts
			if (parts.length != fparts.length) {
				fparts = $(fparts).filter(function(i,p){
					return $.inArray(p, setters_order) !== -1;
				}).toArray();
			}
			// Process remainder
			if (parts.length == fparts.length) {
				for (var i=0, cnt = fparts.length; i < cnt; i++) {
					val = parseInt(parts[i], 10);
					part = fparts[i];
					if (isNaN(val)) {
						switch(part) {
							case 'MM':
								filtered = $(dates[language].months).filter(function(){
									var m = this.slice(0, parts[i].length),
										p = parts[i].slice(0, m.length);
									return m == p;
								});
								val = $.inArray(filtered[0], dates[language].months) + 1;
								break;
							case 'M':
								filtered = $(dates[language].monthsShort).filter(function(){
									var m = this.slice(0, parts[i].length),
										p = parts[i].slice(0, m.length);
									return m == p;
								});
								val = $.inArray(filtered[0], dates[language].monthsShort) + 1;
								break;
						}
					}
					parsed[part] = val;
				}
				for (var i=0, _date, s; i<setters_order.length; i++){
					s = setters_order[i];
					if (s in parsed && !isNaN(parsed[s])){
						_date = new Date(date);
						setters_map[s](_date, parsed[s]);
						if (!isNaN(_date))
							date = _date;
					}
				}
			}
			return date;
		},
		formatDate: function(date, format, language){
			if (typeof format === 'string')
				format = DPGlobal.parseFormat(format);
			var val = {
				d: date.getUTCDate(),
				D: dates[language].daysShort[date.getUTCDay()],
				DD: dates[language].days[date.getUTCDay()],
				m: date.getUTCMonth() + 1,
				M: dates[language].monthsShort[date.getUTCMonth()],
				MM: dates[language].months[date.getUTCMonth()],
				yy: date.getUTCFullYear().toString().substring(2),
				yyyy: date.getUTCFullYear()
			};
			val.dd = (val.d < 10 ? '0' : '') + val.d;
			val.mm = (val.m < 10 ? '0' : '') + val.m;
			var date = [],
				seps = $.extend([], format.separators);
			for (var i=0, cnt = format.parts.length; i <= cnt; i++) {
				if (seps.length)
					date.push(seps.shift());
				date.push(val[format.parts[i]]);
			}
			return date.join('');
		},
		headTemplate: '<thead>'+
							'<tr>'+
								'<th class="prev"><i class="glyphicon glyphicon-chevron-left"/></th>'+
								'<th colspan="5" class="datepicker-switch"></th>'+
								'<th class="next"><i class="glyphicon glyphicon-chevron-right"/></th>'+
							'</tr>'+
						'</thead>',
		contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
		footTemplate: '<tfoot><tr><th colspan="7" class="today"></th></tr><tr><th colspan="7" class="clear"></th></tr></tfoot>'
	};
	DPGlobal.template = '<div class="datepicker">'+
							'<div class="datepicker-days">'+
								'<table class=" table-condensed">'+
									DPGlobal.headTemplate+
									'<tbody></tbody>'+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-months">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-years">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
						'</div>';

	$.fn.datepicker.DPGlobal = DPGlobal;


	/* DATEPICKER NO CONFLICT
	* =================== */

	$.fn.datepicker.noConflict = function(){
		$.fn.datepicker = old;
		return this;
	};


	/* DATEPICKER DATA-API
	* ================== */

	$(document).on(
		'focus.datepicker.data-api click.datepicker.data-api',
		'[data-provide="datepicker"]',
		function(e){
			var $this = $(this);
			if ($this.data('datepicker')) return;
			e.preventDefault();
			// component click requires us to explicitly show it
			$this.datepicker('show');
		}
	);
	$(function(){
		$('[data-provide="datepicker-inline"]').datepicker();
	});

}( window.jQuery ));

/**
 * Implement Thai-year handling inherit core datepicker and default bootstrap-datepicker backend.
 */

;(function($) {
  var dates   = $.fn.datepicker.dates
    , DPGlobal= $.fn.datepicker.DPGlobal
    , thai    = { 
                  adj     : 543
                , code    : 'th'
                , bound   : 2400  // full year value that detect as thai year 
                , shbound : 40  // short year value that detect as thai year 
                , shwrap  : 84  // short year value that wrap to previous century
                , shbase  : 2000  // default base for short year 20xx
                }
                
  function dspThaiYear(language) {
    return language.search('-'+thai.code)>=0
  }
  
  function smartThai(language){
    return language.search(thai.code)>=0
  }
  
  function smartFullYear(v,language){
    if (smartThai(language) && v>=thai.bound) 
      v -= thai.adj // thaiyear 24xx -
    
    if (dspThaiYear(language) && v < thai.bound - thai.adj) 
      v -= thai.adj
    
    return v;
  }
  
  function smartShortYear(v,language) {
    if (v<100){
      if (v>=thai.shwrap) 
        v -= 100; // 1970 - 1999
        
      if (smartThai(language) && v>=thai.shbound) 
        v -= (thai.adj%100) // thaiyear [2540..2569] -> [1997..2026]

      v += thai.shbase;
    }
    return v;
  }
  
  function smartYear(v,language) {
    return smartFullYear(smartShortYear(v,language),language)
  }
  
  function UTCDate() {
    return new Date(Date.UTC.apply(Date, arguments))
  }

  // inherit default backend
  
  if (DPGlobal.name && DPGlobal.name.search(/.th$/)>=0)
    return
    
  var  _basebackend_ = $.extend({},DPGlobal)
  
  $.extend(DPGlobal,{
      name:       (_basebackend_.name || '') + '.th'
    , parseDate:  
        function(date, format, language) {
          if (date=='') {
            date = new Date()
            date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0)
          }

          if (smartThai(language) 
          && !((date instanceof Date) || /^[-+].*/.test(date))) {
          
            var formats = format //this.parseFormat(format)
              , parts   = date && date.match(this.nonpunctuation) || []
            
            if (typeof formats === 'string')
              formats = DPGlobal.parseFormat(format);
            if (parts.length == formats.parts.length) {
              var seps  = $.extend([], formats.separators)
                , xdate = []
                
              for (var i=0, cnt = formats.parts.length; i < cnt; i++) {
                if (~['yyyy','yy'].indexOf(formats.parts[i]))
                  parts[i] = '' + smartYear(parseInt(parts[i], 10),language)
                  
                if (seps.length)
                  xdate.push(seps.shift())
                  
                xdate.push(parts[i])
              }
              
              date = xdate.join('')
            }
          }
          return _basebackend_.parseDate.call(this,date,format,language)
        }
    , formatDate: 
        function(date, format, language){
          var fmtdate = _basebackend_.formatDate.call(this,date,format,language)

          if (dspThaiYear(language)){
            var formats = format //this.parseFormat(format)
              , parts   = fmtdate && fmtdate.match(this.nonpunctuation) || []
              , trnfrm  = {
                  yy  : (thai.adj+date.getUTCFullYear()).toString().substring(2)
                , yyyy: (thai.adj+date.getUTCFullYear()).toString()
                }
                
            if (typeof formats === 'string')
              formats = DPGlobal.parseFormat(format);
              
            if (parts.length == formats.parts.length) {
              var seps  = $.extend([], formats.separators)
                , xdate = []
                
              for (var i=0, cnt = formats.parts.length; i < cnt; i++) {
                if (seps.length)
                  xdate.push(seps.shift())
                  
                xdate.push(trnfrm[formats.parts[i]] || parts[i])
              }
              fmtdate = xdate.join('')
            }
          
          }
          return fmtdate
        }
    })

  // inherit core datepicker
  var DatePicker = $.fn.datepicker.Constructor
  
  if (!DatePicker.prototype.fillThai){
    var _basemethod_ = $.extend({},DatePicker.prototype)
    
    $.extend(DatePicker.prototype,{
        fillThai: function(){
            var d         = new Date(this.viewDate)
              , year      = d.getUTCFullYear()
              , month     = d.getUTCMonth()
              , elem      = this.picker.find('.datepicker-days th:eq(1)')
              
            elem
              .text(elem.text()
              .replace(''+year,''+(year+thai.adj)))

            this.picker
              .find('.datepicker-months')
              .find('th:eq(1)')
              .text(''+(year+thai.adj))
              
            year = parseInt((year+thai.adj)/10, 10) * 10
            
            this.picker
              .find('.datepicker-years')
              .find('th:eq(1)')
              .text(year + '-' + (year + 9))
              .end()
              .find('td')
              .find('span.year')
              .each( 
                function() {
                  $(this)
                    .text(Number($(this).text()) + thai.adj)
                })
          }
      , fill: function(){
            _basemethod_.fill.call(this)
            
            if (dspThaiYear(this.o.language))
              this.fillThai()
          }
      , clickThai: function(e){
            var target  = $(e.target).closest('span')
            
            if (target.length === 1 && target.is('.year'))
              target.text(Number(target.text()) - thai.adj)
          }
      , click: function(e){
            if (dspThaiYear(this.o.language))
              this.clickThai(e)
              
            _basemethod_.click.call(this,e)
          }
      , keydown: function(e){
            // allow arrow-down to show picker
            if (this.picker.is(':not(:visible)')
            && e.keyCode == 40 // arrow-down
            && $(e.target).is('[autocomplete="off"]')) {
                  this.show()
                  return;
            }
            _basemethod_.keydown.call(this,e)
          }
      , hide: function(e){
            // fix redundant hide in orginal code
            if (this.picker.is(':visible'))
              _basemethod_.hide.call(this,e)
            //else console.log('redundant hide')
          }
      
    })
  }
}(jQuery));

/**
 * Thai translation for bootstrap-datepicker
 * Suchau Jiraprapot <seroz24@gmail.com>
 */
 
;(function($){
	// en-th - (rare use) english language with thai-year
	$.fn.datepicker.dates['en-th'] = 
	// en-en.th - english language with smart thai-year input (2540-2569) conversion 
	$.fn.datepicker.dates['en-en.th'] = 
							$.fn.datepicker.dates['en'];
	
	// th-th - thai language with thai-year
	$.fn.datepicker.dates['th-th'] =
	$.fn.datepicker.dates['th'] = {
		format: 'dd/mm/yyyy',
		days: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์", "อาทิตย์"],
		daysShort: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส", "อา"],
		daysMin: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส", "อา"],
		months: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
		monthsShort: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."],
		today: "วันนี้"
	};
}(jQuery));


/*
 *
 * More info at [www.dropzonejs.com](http://www.dropzonejs.com)
 *
 * Copyright (c) 2012, Matias Meno
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 */

(function() {
    var Dropzone, Emitter, camelize, contentLoaded, detectVerticalSquash, drawImageIOSFix, noop, without,
        __slice = [].slice,
        __hasProp = {}.hasOwnProperty,
        __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

    noop = function() {};

    Emitter = (function() {
        function Emitter() {}

        Emitter.prototype.addEventListener = Emitter.prototype.on;

        Emitter.prototype.on = function(event, fn) {
            this._callbacks = this._callbacks || {};
            if (!this._callbacks[event]) {
                this._callbacks[event] = [];
            }
            this._callbacks[event].push(fn);
            return this;
        };

        Emitter.prototype.emit = function() {
            var args, callback, callbacks, event, _i, _len;
            event = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
            this._callbacks = this._callbacks || {};
            callbacks = this._callbacks[event];
            if (callbacks) {
                for (_i = 0, _len = callbacks.length; _i < _len; _i++) {
                    callback = callbacks[_i];
                    callback.apply(this, args);
                }
            }
            return this;
        };

        Emitter.prototype.removeListener = Emitter.prototype.off;

        Emitter.prototype.removeAllListeners = Emitter.prototype.off;

        Emitter.prototype.removeEventListener = Emitter.prototype.off;

        Emitter.prototype.off = function(event, fn) {
            var callback, callbacks, i, _i, _len;
            if (!this._callbacks || arguments.length === 0) {
                this._callbacks = {};
                return this;
            }
            callbacks = this._callbacks[event];
            if (!callbacks) {
                return this;
            }
            if (arguments.length === 1) {
                delete this._callbacks[event];
                return this;
            }
            for (i = _i = 0, _len = callbacks.length; _i < _len; i = ++_i) {
                callback = callbacks[i];
                if (callback === fn) {
                    callbacks.splice(i, 1);
                    break;
                }
            }
            return this;
        };

        return Emitter;

    })();

    Dropzone = (function(_super) {
        var extend, resolveOption;

        __extends(Dropzone, _super);

        Dropzone.prototype.Emitter = Emitter;


        /*
         This is a list of all available events you can register on a dropzone object.

         You can register an event handler like this:

         dropzone.on("dragEnter", function() { });
         */

        Dropzone.prototype.events = ["drop", "dragstart", "dragend", "dragenter", "dragover", "dragleave", "addedfile", "addedfiles", "removedfile", "thumbnail", "error", "errormultiple", "processing", "processingmultiple", "uploadprogress", "totaluploadprogress", "sending", "sendingmultiple", "success", "successmultiple", "canceled", "canceledmultiple", "complete", "completemultiple", "reset", "maxfilesexceeded", "maxfilesreached", "queuecomplete"];

        Dropzone.prototype.defaultOptions = {
            url: null,
            method: "post",
            withCredentials: false,
            parallelUploads: 2,
            uploadMultiple: false,
            maxFilesize: 256,
            paramName: "file",
            createImageThumbnails: true,
            maxThumbnailFilesize: 10,
            thumbnailWidth: 120,
            thumbnailHeight: 120,
            filesizeBase: 1000,
            maxFiles: null,
            params: {},
            clickable: true,
            ignoreHiddenFiles: true,
            acceptedFiles: null,
            acceptedMimeTypes: null,
            autoProcessQueue: true,
            autoQueue: true,
            addRemoveLinks: false,
            previewsContainer: null,
            hiddenInputContainer: "body",
            capture: null,
            dictDefaultMessage: "Drop files here to upload",
            dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.",
            dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
            dictFileTooBig: "File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.",
            dictInvalidFileType: "You can't upload files of this type.",
            dictResponseError: "Server responded with {{statusCode}} code.",
            dictCancelUpload: "Cancel upload",
            dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?",
            dictRemoveFile: "Remove file",
            dictRemoveFileConfirmation: null,
            dictMaxFilesExceeded: "You can not upload any more files.",
            accept: function(file, done) {
                return done();
            },
            init: function() {
                return noop;
            },
            forceFallback: false,
            fallback: function() {
                var child, messageElement, span, _i, _len, _ref;
                this.element.className = "" + this.element.className + " dz-browser-not-supported";
                _ref = this.element.getElementsByTagName("div");
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    child = _ref[_i];
                    if (/(^| )dz-message($| )/.test(child.className)) {
                        messageElement = child;
                        child.className = "dz-message";
                        continue;
                    }
                }
                if (!messageElement) {
                    messageElement = Dropzone.createElement("<div class=\"dz-message\"><span></span></div>");
                    this.element.appendChild(messageElement);
                }
                span = messageElement.getElementsByTagName("span")[0];
                if (span) {
                    if (span.textContent != null) {
                        span.textContent = this.options.dictFallbackMessage;
                    } else if (span.innerText != null) {
                        span.innerText = this.options.dictFallbackMessage;
                    }
                }
                return this.element.appendChild(this.getFallbackForm());
            },
            resize: function(file) {
                var info, srcRatio, trgRatio;
                info = {
                    srcX: 0,
                    srcY: 0,
                    srcWidth: file.width,
                    srcHeight: file.height
                };
                srcRatio = file.width / file.height;
                info.optWidth = this.options.thumbnailWidth;
                info.optHeight = this.options.thumbnailHeight;
                if ((info.optWidth == null) && (info.optHeight == null)) {
                    info.optWidth = info.srcWidth;
                    info.optHeight = info.srcHeight;
                } else if (info.optWidth == null) {
                    info.optWidth = srcRatio * info.optHeight;
                } else if (info.optHeight == null) {
                    info.optHeight = (1 / srcRatio) * info.optWidth;
                }
                trgRatio = info.optWidth / info.optHeight;
                if (file.height < info.optHeight || file.width < info.optWidth) {
                    info.trgHeight = info.srcHeight;
                    info.trgWidth = info.srcWidth;
                } else {
                    if (srcRatio > trgRatio) {
                        info.srcHeight = file.height;
                        info.srcWidth = info.srcHeight * trgRatio;
                    } else {
                        info.srcWidth = file.width;
                        info.srcHeight = info.srcWidth / trgRatio;
                    }
                }
                info.srcX = (file.width - info.srcWidth) / 2;
                info.srcY = (file.height - info.srcHeight) / 2;
                return info;
            },

            /*
             Those functions register themselves to the events on init and handle all
             the user interface specific stuff. Overwriting them won't break the upload
             but can break the way it's displayed.
             You can overwrite them if you don't like the default behavior. If you just
             want to add an additional event handler, register it on the dropzone object
             and don't overwrite those options.
             */
            drop: function(e) {
                return this.element.classList.remove("dz-drag-hover");
            },
            dragstart: noop,
            dragend: function(e) {
                return this.element.classList.remove("dz-drag-hover");
            },
            dragenter: function(e) {
                return this.element.classList.add("dz-drag-hover");
            },
            dragover: function(e) {
                return this.element.classList.add("dz-drag-hover");
            },
            dragleave: function(e) {
                return this.element.classList.remove("dz-drag-hover");
            },
            paste: noop,
            reset: function() {
                return this.element.classList.remove("dz-started");
            },
            addedfile: function(file) {
                var node, removeFileEvent, removeLink, _i, _j, _k, _len, _len1, _len2, _ref, _ref1, _ref2, _results;
                if (this.element === this.previewsContainer) {
                    this.element.classList.add("dz-started");
                }
                if (this.previewsContainer) {
                    file.previewElement = Dropzone.createElement(this.options.previewTemplate.trim());
                    file.previewTemplate = file.previewElement;
                    this.previewsContainer.appendChild(file.previewElement);
                    _ref = file.previewElement.querySelectorAll("[data-dz-name]");
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i];
                        node.textContent = file.name;
                    }
                    _ref1 = file.previewElement.querySelectorAll("[data-dz-size]");
                    for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
                        node = _ref1[_j];
                        node.innerHTML = this.filesize(file.size);
                    }
                    if (this.options.addRemoveLinks) {
                        file._removeLink = Dropzone.createElement("<a class=\"dz-remove\" href=\"javascript:undefined;\" data-dz-remove>" + this.options.dictRemoveFile + "</a>");
                        file.previewElement.appendChild(file._removeLink);
                    }
                    removeFileEvent = (function(_this) {
                        return function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            if (file.status === Dropzone.UPLOADING) {
                                return Dropzone.confirm(_this.options.dictCancelUploadConfirmation, function() {
                                    return _this.removeFile(file);
                                });
                            } else {
                                if (_this.options.dictRemoveFileConfirmation) {
                                    return Dropzone.confirm(_this.options.dictRemoveFileConfirmation, function() {
                                        return _this.removeFile(file);
                                    });
                                } else {
                                    return _this.removeFile(file);
                                }
                            }
                        };
                    })(this);
                    _ref2 = file.previewElement.querySelectorAll("[data-dz-remove]");
                    _results = [];
                    for (_k = 0, _len2 = _ref2.length; _k < _len2; _k++) {
                        removeLink = _ref2[_k];
                        _results.push(removeLink.addEventListener("click", removeFileEvent));
                    }
                    _ref3 = file.previewElement.querySelectorAll("[data-dz-view]");
                    for (_k = 0, _len2 = _ref3.length; _k < _len2; _k++) {
                        removeLink = _ref3[_k];
                        if(file.file){
                            removeLink.href="/"+file.file;
                        }
                    }



                    return _results;
                }
            },
            removedfile: function(file) {
                var _ref;
                if (file.previewElement) {
                    if ((_ref = file.previewElement) != null) {
                        _ref.parentNode.removeChild(file.previewElement);
                    }
                }
                return this._updateMaxFilesReachedClass();
            },
            thumbnail: function(file, dataUrl) {
                var thumbnailElement, _i, _len, _ref;
                if (file.previewElement) {
                    file.previewElement.classList.remove("dz-file-preview");
                    _ref = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        thumbnailElement = _ref[_i];
                        thumbnailElement.alt = file.name;
                        thumbnailElement.src = dataUrl;
                    }
                    return setTimeout(((function(_this) {
                        return function() {
                            return file.previewElement.classList.add("dz-image-preview");
                        };
                    })(this)), 1);
                }
            },
            error: function(file, message) {
                var node, _i, _len, _ref, _results;
                if (file.previewElement) {
                    file.previewElement.classList.add("dz-error");
                    if (typeof message !== "String" && message.error) {
                        message = message.error;
                    }
                    _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                    _results = [];
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i];
                        _results.push(node.textContent = message);
                    }
                    return _results;
                }
            },
            errormultiple: noop,
            processing: function(file) {
                if (file.previewElement) {
                    file.previewElement.classList.add("dz-processing");
                    if (file._removeLink) {
                        return file._removeLink.textContent = this.options.dictCancelUpload;
                    }
                }
            },
            processingmultiple: noop,
            uploadprogress: function(file, progress, bytesSent) {
                var node, _i, _len, _ref, _results;
                if (file.previewElement) {
                    _ref = file.previewElement.querySelectorAll("[data-dz-uploadprogress]");
                    _results = [];
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i];
                        if (node.nodeName === 'PROGRESS') {
                            _results.push(node.value = progress);
                        } else {
                            _results.push(node.style.width = "" + progress + "%");
                        }
                    }
                    return _results;
                }
            },
            totaluploadprogress: noop,
            sending: noop,
            sendingmultiple: noop,
            success: function(file) {
                if (file.previewElement) {
                    return file.previewElement.classList.add("dz-success");
                }
            },
            successmultiple: noop,
            canceled: function(file) {
                return this.emit("error", file, "Upload canceled.");
            },
            canceledmultiple: noop,
            complete: function(file) {
                if(file){
                    if (file._removeLink) {
                        file._removeLink.textContent = this.options.dictRemoveFile;
                    }
                    if (file.previewElement) {
                        return file.previewElement.classList.add("dz-complete");
                    }
                }

            },
            completemultiple: noop,
            maxfilesexceeded: noop,
            maxfilesreached: noop,
            queuecomplete: noop,
            addedfiles: noop,
            previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-image\"><img data-dz-thumbnail /></div>\n  <div class=\"dz-details\">\n    <div class=\"dz-size\"><span data-dz-size></span></div>\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n  </div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n  <div class=\"dz-success-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Check</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <path d=\"M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" stroke-opacity=\"0.198794158\" stroke=\"#747474\" fill-opacity=\"0.816519475\" fill=\"#FFFFFF\" sketch:type=\"MSShapeGroup\"></path>\n      </g>\n    </svg>\n  </div>\n  <div class=\"dz-error-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Error</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <g id=\"Check-+-Oval-2\" sketch:type=\"MSLayerGroup\" stroke=\"#747474\" stroke-opacity=\"0.198794158\" fill=\"#FFFFFF\" fill-opacity=\"0.816519475\">\n          <path d=\"M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" sketch:type=\"MSShapeGroup\"></path>\n        </g>\n      </g>\n    </svg>\n  </div>\n</div>"
        };

        extend = function() {
            var key, object, objects, target, val, _i, _len;
            target = arguments[0], objects = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
            for (_i = 0, _len = objects.length; _i < _len; _i++) {
                object = objects[_i];
                for (key in object) {
                    val = object[key];
                    target[key] = val;
                }
            }
            return target;
        };

        function Dropzone(element, options) {
            var elementOptions, fallback, _ref;
            this.element = element;
            this.version = Dropzone.version;
            this.defaultOptions.previewTemplate = this.defaultOptions.previewTemplate.replace(/\n*/g, "");
            this.clickableElements = [];
            this.listeners = [];
            this.files = [];
            if (typeof this.element === "string") {
                this.element = document.querySelector(this.element);
            }
            if (!(this.element && (this.element.nodeType != null))) {
                throw new Error("Invalid dropzone element.");
            }
            if (this.element.dropzone) {
                throw new Error("Dropzone already attached.");
            }
            Dropzone.instances.push(this);
            this.element.dropzone = this;
            elementOptions = (_ref = Dropzone.optionsForElement(this.element)) != null ? _ref : {};
            this.options = extend({}, this.defaultOptions, elementOptions, options != null ? options : {});
            if (this.options.forceFallback || !Dropzone.isBrowserSupported()) {
                return this.options.fallback.call(this);
            }
            if (this.options.url == null) {
                this.options.url = this.element.getAttribute("action");
            }
            if (!this.options.url) {
                throw new Error("No URL provided.");
            }
            if (this.options.acceptedFiles && this.options.acceptedMimeTypes) {
                throw new Error("You can't provide both 'acceptedFiles' and 'acceptedMimeTypes'. 'acceptedMimeTypes' is deprecated.");
            }
            if (this.options.acceptedMimeTypes) {
                this.options.acceptedFiles = this.options.acceptedMimeTypes;
                delete this.options.acceptedMimeTypes;
            }
            this.options.method = this.options.method.toUpperCase();
            if ((fallback = this.getExistingFallback()) && fallback.parentNode) {
                fallback.parentNode.removeChild(fallback);
            }
            if (this.options.previewsContainer !== false) {
                if (this.options.previewsContainer) {
                    this.previewsContainer = Dropzone.getElement(this.options.previewsContainer, "previewsContainer");
                } else {
                    this.previewsContainer = this.element;
                }
            }
            if (this.options.clickable) {
                if (this.options.clickable === true) {
                    this.clickableElements = [this.element];
                } else {
                    this.clickableElements = Dropzone.getElements(this.options.clickable, "clickable");
                }
            }
            this.init();
        }

        Dropzone.prototype.getAcceptedFiles = function() {
            var file, _i, _len, _ref, _results;
            _ref = this.files;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                file = _ref[_i];
                if (file.accepted) {
                    _results.push(file);
                }
            }
            return _results;
        };

        Dropzone.prototype.getRejectedFiles = function() {
            var file, _i, _len, _ref, _results;
            _ref = this.files;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                file = _ref[_i];
                if (!file.accepted) {
                    _results.push(file);
                }
            }
            return _results;
        };

        Dropzone.prototype.getFilesWithStatus = function(status) {
            var file, _i, _len, _ref, _results;
            _ref = this.files;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                file = _ref[_i];
                if (file.status === status) {
                    _results.push(file);
                }
            }
            return _results;
        };

        Dropzone.prototype.getQueuedFiles = function() {
            return this.getFilesWithStatus(Dropzone.QUEUED);
        };

        Dropzone.prototype.getUploadingFiles = function() {
            return this.getFilesWithStatus(Dropzone.UPLOADING);
        };

        Dropzone.prototype.getAddedFiles = function() {
            return this.getFilesWithStatus(Dropzone.ADDED);
        };

        Dropzone.prototype.getActiveFiles = function() {
            var file, _i, _len, _ref, _results;
            _ref = this.files;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                file = _ref[_i];
                if (file.status === Dropzone.UPLOADING || file.status === Dropzone.QUEUED) {
                    _results.push(file);
                }
            }
            return _results;
        };

        Dropzone.prototype.init = function() {
            var eventName, noPropagation, setupHiddenFileInput, _i, _len, _ref, _ref1;
            if (this.element.tagName === "form") {
                this.element.setAttribute("enctype", "multipart/form-data");
            }
            if (this.element.classList.contains("dropzone") && !this.element.querySelector(".dz-message")) {
                this.element.appendChild(Dropzone.createElement("<div class=\"dz-default dz-message\"><span>" + this.options.dictDefaultMessage + "</span></div>"));
            }
            if (this.clickableElements.length) {
                setupHiddenFileInput = (function(_this) {
                    return function() {
                        if (_this.hiddenFileInput) {
                            _this.hiddenFileInput.parentNode.removeChild(_this.hiddenFileInput);
                        }
                        _this.hiddenFileInput = document.createElement("input");
                        _this.hiddenFileInput.setAttribute("type", "file");
                        if ((_this.options.maxFiles == null) || _this.options.maxFiles > 1) {
                            _this.hiddenFileInput.setAttribute("multiple", "multiple");
                        }
                        _this.hiddenFileInput.className = "dz-hidden-input";
                        if (_this.options.acceptedFiles != null) {
                            _this.hiddenFileInput.setAttribute("accept", _this.options.acceptedFiles);
                        }
                        if (_this.options.capture != null) {
                            _this.hiddenFileInput.setAttribute("capture", _this.options.capture);
                        }
                        _this.hiddenFileInput.style.visibility = "hidden";
                        _this.hiddenFileInput.style.position = "absolute";
                        _this.hiddenFileInput.style.top = "0";
                        _this.hiddenFileInput.style.left = "0";
                        _this.hiddenFileInput.style.height = "0";
                        _this.hiddenFileInput.style.width = "0";
                        document.querySelector(_this.options.hiddenInputContainer).appendChild(_this.hiddenFileInput);
                        return _this.hiddenFileInput.addEventListener("change", function() {
                            var file, files, _i, _len;
                            files = _this.hiddenFileInput.files;
                            if (files.length) {
                                for (_i = 0, _len = files.length; _i < _len; _i++) {
                                    file = files[_i];
                                    _this.addFile(file);
                                }
                            }
                            _this.emit("addedfiles", files);
                            return setupHiddenFileInput();
                        });
                    };
                })(this);
                setupHiddenFileInput();
            }
            this.URL = (_ref = window.URL) != null ? _ref : window.webkitURL;
            _ref1 = this.events;
            for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
                eventName = _ref1[_i];
                this.on(eventName, this.options[eventName]);
            }
            this.on("uploadprogress", (function(_this) {
                return function() {
                    return _this.updateTotalUploadProgress();
                };
            })(this));
            this.on("removedfile", (function(_this) {
                return function() {
                    return _this.updateTotalUploadProgress();
                };
            })(this));
            this.on("canceled", (function(_this) {
                return function(file) {
                    return _this.emit("complete", file);
                };
            })(this));
            this.on("complete", (function(_this) {
                return function(file) {
                    if (_this.getAddedFiles().length === 0 && _this.getUploadingFiles().length === 0 && _this.getQueuedFiles().length === 0) {
                        return setTimeout((function() {
                            return _this.emit("queuecomplete");
                        }), 0);
                    }
                };
            })(this));
            noPropagation = function(e) {
                e.stopPropagation();
                if (e.preventDefault) {
                    return e.preventDefault();
                } else {
                    return e.returnValue = false;
                }
            };
            this.listeners = [
                {
                    element: this.element,
                    events: {
                        "dragstart": (function(_this) {
                            return function(e) {
                                return _this.emit("dragstart", e);
                            };
                        })(this),
                        "dragenter": (function(_this) {
                            return function(e) {
                                noPropagation(e);
                                return _this.emit("dragenter", e);
                            };
                        })(this),
                        "dragover": (function(_this) {
                            return function(e) {
                                var efct;
                                try {
                                    efct = e.dataTransfer.effectAllowed;
                                } catch (_error) {}
                                e.dataTransfer.dropEffect = 'move' === efct || 'linkMove' === efct ? 'move' : 'copy';
                                noPropagation(e);
                                return _this.emit("dragover", e);
                            };
                        })(this),
                        "dragleave": (function(_this) {
                            return function(e) {
                                return _this.emit("dragleave", e);
                            };
                        })(this),
                        "drop": (function(_this) {
                            return function(e) {
                                noPropagation(e);
                                return _this.drop(e);
                            };
                        })(this),
                        "dragend": (function(_this) {
                            return function(e) {
                                return _this.emit("dragend", e);
                            };
                        })(this)
                    }
                }
            ];
            this.clickableElements.forEach((function(_this) {
                return function(clickableElement) {
                    return _this.listeners.push({
                        element: clickableElement,
                        events: {
                            "click": function(evt) {
                                if ((clickableElement !== _this.element) || (evt.target === _this.element || Dropzone.elementInside(evt.target, _this.element.querySelector(".dz-message")))) {
                                    _this.hiddenFileInput.click();
                                }
                                return true;
                            }
                        }
                    });
                };
            })(this));
            this.enable();
            return this.options.init.call(this);
        };

        Dropzone.prototype.destroy = function() {
            var _ref;
            this.disable();
            this.removeAllFiles(true);
            if ((_ref = this.hiddenFileInput) != null ? _ref.parentNode : void 0) {
                this.hiddenFileInput.parentNode.removeChild(this.hiddenFileInput);
                this.hiddenFileInput = null;
            }
            delete this.element.dropzone;
            return Dropzone.instances.splice(Dropzone.instances.indexOf(this), 1);
        };

        Dropzone.prototype.updateTotalUploadProgress = function() {
            var activeFiles, file, totalBytes, totalBytesSent, totalUploadProgress, _i, _len, _ref;
            totalBytesSent = 0;
            totalBytes = 0;
            activeFiles = this.getActiveFiles();
            if (activeFiles.length) {
                _ref = this.getActiveFiles();
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    file = _ref[_i];
                    totalBytesSent += file.upload.bytesSent;
                    totalBytes += file.upload.total;
                }
                totalUploadProgress = 100 * totalBytesSent / totalBytes;
            } else {
                totalUploadProgress = 100;
            }
            return this.emit("totaluploadprogress", totalUploadProgress, totalBytes, totalBytesSent);
        };

        Dropzone.prototype._getParamName = function(n) {
            if (typeof this.options.paramName === "function") {
                return this.options.paramName(n);
            } else {
                return "" + this.options.paramName + (this.options.uploadMultiple ? "[" + n + "]" : "");
            }
        };

        Dropzone.prototype.getFallbackForm = function() {
            var existingFallback, fields, fieldsString, form;
            if (existingFallback = this.getExistingFallback()) {
                return existingFallback;
            }
            fieldsString = "<div class=\"dz-fallback\">";
            if (this.options.dictFallbackText) {
                fieldsString += "<p>" + this.options.dictFallbackText + "</p>";
            }
            fieldsString += "<input type=\"file\" name=\"" + (this._getParamName(0)) + "\" " + (this.options.uploadMultiple ? 'multiple="multiple"' : void 0) + " /><input type=\"submit\" value=\"Upload!\"></div>";
            fields = Dropzone.createElement(fieldsString);
            if (this.element.tagName !== "FORM") {
                form = Dropzone.createElement("<form action=\"" + this.options.url + "\" enctype=\"multipart/form-data\" method=\"" + this.options.method + "\"></form>");
                form.appendChild(fields);
            } else {
                this.element.setAttribute("enctype", "multipart/form-data");
                this.element.setAttribute("method", this.options.method);
            }
            return form != null ? form : fields;
        };

        Dropzone.prototype.getExistingFallback = function() {
            var fallback, getFallback, tagName, _i, _len, _ref;
            getFallback = function(elements) {
                var el, _i, _len;
                for (_i = 0, _len = elements.length; _i < _len; _i++) {
                    el = elements[_i];
                    if (/(^| )fallback($| )/.test(el.className)) {
                        return el;
                    }
                }
            };
            _ref = ["div", "form"];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                tagName = _ref[_i];
                if (fallback = getFallback(this.element.getElementsByTagName(tagName))) {
                    return fallback;
                }
            }
        };

        Dropzone.prototype.setupEventListeners = function() {
            var elementListeners, event, listener, _i, _len, _ref, _results;
            _ref = this.listeners;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                elementListeners = _ref[_i];
                _results.push((function() {
                    var _ref1, _results1;
                    _ref1 = elementListeners.events;
                    _results1 = [];
                    for (event in _ref1) {
                        listener = _ref1[event];
                        _results1.push(elementListeners.element.addEventListener(event, listener, false));
                    }
                    return _results1;
                })());
            }
            return _results;
        };

        Dropzone.prototype.removeEventListeners = function() {
            var elementListeners, event, listener, _i, _len, _ref, _results;
            _ref = this.listeners;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                elementListeners = _ref[_i];
                _results.push((function() {
                    var _ref1, _results1;
                    _ref1 = elementListeners.events;
                    _results1 = [];
                    for (event in _ref1) {
                        listener = _ref1[event];
                        _results1.push(elementListeners.element.removeEventListener(event, listener, false));
                    }
                    return _results1;
                })());
            }
            return _results;
        };

        Dropzone.prototype.disable = function() {
            var file, _i, _len, _ref, _results;
            this.clickableElements.forEach(function(element) {
                return element.classList.remove("dz-clickable");
            });
            this.removeEventListeners();
            _ref = this.files;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                file = _ref[_i];
                _results.push(this.cancelUpload(file));
            }
            return _results;
        };

        Dropzone.prototype.enable = function() {
            this.clickableElements.forEach(function(element) {
                return element.classList.add("dz-clickable");
            });
            return this.setupEventListeners();
        };

        Dropzone.prototype.filesize = function(size) {
            var cutoff, i, selectedSize, selectedUnit, unit, units, _i, _len;
            selectedSize = 0;
            selectedUnit = "b";
            if (size > 0) {
                units = ['TB', 'GB', 'MB', 'KB', 'b'];
                for (i = _i = 0, _len = units.length; _i < _len; i = ++_i) {
                    unit = units[i];
                    cutoff = Math.pow(this.options.filesizeBase, 4 - i) / 10;
                    if (size >= cutoff) {
                        selectedSize = size / Math.pow(this.options.filesizeBase, 4 - i);
                        selectedUnit = unit;
                        break;
                    }
                }
                selectedSize = Math.round(10 * selectedSize) / 10;
            }
            return "<strong>" + selectedSize + "</strong> " + selectedUnit;
        };

        Dropzone.prototype._updateMaxFilesReachedClass = function() {
            if ((this.options.maxFiles != null) && this.getAcceptedFiles().length >= this.options.maxFiles) {
                if (this.getAcceptedFiles().length === this.options.maxFiles) {
                    this.emit('maxfilesreached', this.files);
                }
                return this.element.classList.add("dz-max-files-reached");
            } else {
                return this.element.classList.remove("dz-max-files-reached");
            }
        };

        Dropzone.prototype.drop = function(e) {
            var files, items;
            if (!e.dataTransfer) {
                return;
            }
            this.emit("drop", e);
            files = e.dataTransfer.files;
            this.emit("addedfiles", files);
            if (files.length) {
                items = e.dataTransfer.items;
                if (items && items.length && (items[0].webkitGetAsEntry != null)) {
                    this._addFilesFromItems(items);
                } else {
                    this.handleFiles(files);
                }
            }
        };

        Dropzone.prototype.paste = function(e) {
            var items, _ref;
            if ((e != null ? (_ref = e.clipboardData) != null ? _ref.items : void 0 : void 0) == null) {
                return;
            }
            this.emit("paste", e);
            items = e.clipboardData.items;
            if (items.length) {
                return this._addFilesFromItems(items);
            }
        };

        Dropzone.prototype.handleFiles = function(files) {
            var file, _i, _len, _results;
            _results = [];
            for (_i = 0, _len = files.length; _i < _len; _i++) {
                file = files[_i];
                _results.push(this.addFile(file));
            }
            return _results;
        };

        Dropzone.prototype._addFilesFromItems = function(items) {
            var entry, item, _i, _len, _results;
            _results = [];
            for (_i = 0, _len = items.length; _i < _len; _i++) {
                item = items[_i];
                if ((item.webkitGetAsEntry != null) && (entry = item.webkitGetAsEntry())) {
                    if (entry.isFile) {
                        _results.push(this.addFile(item.getAsFile()));
                    } else if (entry.isDirectory) {
                        _results.push(this._addFilesFromDirectory(entry, entry.name));
                    } else {
                        _results.push(void 0);
                    }
                } else if (item.getAsFile != null) {
                    if ((item.kind == null) || item.kind === "file") {
                        _results.push(this.addFile(item.getAsFile()));
                    } else {
                        _results.push(void 0);
                    }
                } else {
                    _results.push(void 0);
                }
            }
            return _results;
        };

        Dropzone.prototype._addFilesFromDirectory = function(directory, path) {
            var dirReader, entriesReader;
            dirReader = directory.createReader();
            entriesReader = (function(_this) {
                return function(entries) {
                    var entry, _i, _len;
                    for (_i = 0, _len = entries.length; _i < _len; _i++) {
                        entry = entries[_i];
                        if (entry.isFile) {
                            entry.file(function(file) {
                                if (_this.options.ignoreHiddenFiles && file.name.substring(0, 1) === '.') {
                                    return;
                                }
                                file.fullPath = "" + path + "/" + file.name;
                                return _this.addFile(file);
                            });
                        } else if (entry.isDirectory) {
                            _this._addFilesFromDirectory(entry, "" + path + "/" + entry.name);
                        }
                    }
                };
            })(this);
            return dirReader.readEntries(entriesReader, function(error) {
                return typeof console !== "undefined" && console !== null ? typeof console.log === "function" ? console.log(error) : void 0 : void 0;
            });
        };

        Dropzone.prototype.accept = function(file, done) {
            if (file.size > this.options.maxFilesize * 1024 * 1024) {
                return done(this.options.dictFileTooBig.replace("{{filesize}}", Math.round(file.size / 1024 / 10.24) / 100).replace("{{maxFilesize}}", this.options.maxFilesize));
            } else if (!Dropzone.isValidFile(file, this.options.acceptedFiles)) {
                return done(this.options.dictInvalidFileType);
            } else if ((this.options.maxFiles != null) && this.getAcceptedFiles().length >= this.options.maxFiles) {
                done(this.options.dictMaxFilesExceeded.replace("{{maxFiles}}", this.options.maxFiles));
                return this.emit("maxfilesexceeded", file);
            } else {
                return this.options.accept.call(this, file, done);
            }
        };

        Dropzone.prototype.addFile = function(file) {
            file.upload = {
                progress: 0,
                total: file.size,
                bytesSent: 0
            };
            this.files.push(file);
            file.status = Dropzone.ADDED;
            this.emit("addedfile", file);
            this._enqueueThumbnail(file);
            return this.accept(file, (function(_this) {
                return function(error) {
                    if (error) {
                        file.accepted = false;
                        _this._errorProcessing([file], error);
                    } else {
                        file.accepted = true;
                        if (_this.options.autoQueue) {
                            _this.enqueueFile(file);
                        }
                    }
                    return _this._updateMaxFilesReachedClass();
                };
            })(this));
        };

        Dropzone.prototype.enqueueFiles = function(files) {
            var file, _i, _len;
            for (_i = 0, _len = files.length; _i < _len; _i++) {
                file = files[_i];
                this.enqueueFile(file);
            }
            return null;
        };

        Dropzone.prototype.enqueueFile = function(file) {
            if (file.status === Dropzone.ADDED && file.accepted === true) {
                file.status = Dropzone.QUEUED;
                if (this.options.autoProcessQueue) {
                    return setTimeout(((function(_this) {
                        return function() {
                            return _this.processQueue();
                        };
                    })(this)), 0);
                }
            } else {
                throw new Error("This file can't be queued because it has already been processed or was rejected.");
            }
        };

        Dropzone.prototype._thumbnailQueue = [];

        Dropzone.prototype._processingThumbnail = false;

        Dropzone.prototype._enqueueThumbnail = function(file) {
            if (this.options.createImageThumbnails && file.type.match(/image.*/) && file.size <= this.options.maxThumbnailFilesize * 1024 * 1024) {
                this._thumbnailQueue.push(file);
                return setTimeout(((function(_this) {
                    return function() {
                        return _this._processThumbnailQueue();
                    };
                })(this)), 0);
            }
        };

        Dropzone.prototype._processThumbnailQueue = function() {
            if (this._processingThumbnail || this._thumbnailQueue.length === 0) {
                return;
            }
            this._processingThumbnail = true;
            return this.createThumbnail(this._thumbnailQueue.shift(), (function(_this) {
                return function() {
                    _this._processingThumbnail = false;
                    return _this._processThumbnailQueue();
                };
            })(this));
        };

        Dropzone.prototype.removeFile = function(file) {
            if (file.status === Dropzone.UPLOADING) {
                this.cancelUpload(file);
            }
            this.files = without(this.files, file);
            this.emit("removedfile", file);
            if (this.files.length === 0) {
                return this.emit("reset");
            }
        };

        Dropzone.prototype.removeAllFiles = function(cancelIfNecessary) {
            var file, _i, _len, _ref;
            if (cancelIfNecessary == null) {
                cancelIfNecessary = false;
            }
            _ref = this.files.slice();
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                file = _ref[_i];
                if (file.status !== Dropzone.UPLOADING || cancelIfNecessary) {
                    this.removeFile(file);
                }
            }
            return null;
        };

        Dropzone.prototype.createThumbnail = function(file, callback) {
            var fileReader;
            fileReader = new FileReader;
            fileReader.onload = (function(_this) {
                return function() {
                    if (file.type === "image/svg+xml") {
                        _this.emit("thumbnail", file, fileReader.result);
                        if (callback != null) {
                            callback();
                        }
                        return;
                    }
                    return _this.createThumbnailFromUrl(file, fileReader.result, callback);
                };
            })(this);
            return fileReader.readAsDataURL(file);
        };

        Dropzone.prototype.createThumbnailFromUrl = function(file, imageUrl, callback, crossOrigin) {
            var img;
            img = document.createElement("img");
            if (crossOrigin) {
                img.crossOrigin = crossOrigin;
            }
            img.onload = (function(_this) {
                return function() {
                    var canvas, ctx, resizeInfo, thumbnail, _ref, _ref1, _ref2, _ref3;
                    file.width = img.width;
                    file.height = img.height;
                    resizeInfo = _this.options.resize.call(_this, file);
                    if (resizeInfo.trgWidth == null) {
                        resizeInfo.trgWidth = resizeInfo.optWidth;
                    }
                    if (resizeInfo.trgHeight == null) {
                        resizeInfo.trgHeight = resizeInfo.optHeight;
                    }
                    canvas = document.createElement("canvas");
                    ctx = canvas.getContext("2d");
                    canvas.width = resizeInfo.trgWidth;
                    canvas.height = resizeInfo.trgHeight;
                    drawImageIOSFix(ctx, img, (_ref = resizeInfo.srcX) != null ? _ref : 0, (_ref1 = resizeInfo.srcY) != null ? _ref1 : 0, resizeInfo.srcWidth, resizeInfo.srcHeight, (_ref2 = resizeInfo.trgX) != null ? _ref2 : 0, (_ref3 = resizeInfo.trgY) != null ? _ref3 : 0, resizeInfo.trgWidth, resizeInfo.trgHeight);
                    thumbnail = canvas.toDataURL("image/png");
                    _this.emit("thumbnail", file, thumbnail);
                    if (callback != null) {
                        return callback();
                    }
                };
            })(this);
            if (callback != null) {
                img.onerror = callback;
            }
            return img.src = imageUrl;
        };

        Dropzone.prototype.processQueue = function() {
            var i, parallelUploads, processingLength, queuedFiles;
            parallelUploads = this.options.parallelUploads;
            processingLength = this.getUploadingFiles().length;
            i = processingLength;
            if (processingLength >= parallelUploads) {
                return;
            }
            queuedFiles = this.getQueuedFiles();
            if (!(queuedFiles.length > 0)) {
                return;
            }
            if (this.options.uploadMultiple) {
                return this.processFiles(queuedFiles.slice(0, parallelUploads - processingLength));
            } else {
                while (i < parallelUploads) {
                    if (!queuedFiles.length) {
                        return;
                    }
                    this.processFile(queuedFiles.shift());
                    i++;
                }
            }
        };

        Dropzone.prototype.processFile = function(file) {
            return this.processFiles([file]);
        };

        Dropzone.prototype.processFiles = function(files) {
            var file, _i, _len;
            for (_i = 0, _len = files.length; _i < _len; _i++) {
                file = files[_i];
                file.processing = true;
                file.status = Dropzone.UPLOADING;
                this.emit("processing", file);
            }
            if (this.options.uploadMultiple) {
                this.emit("processingmultiple", files);
            }
            return this.uploadFiles(files);
        };

        Dropzone.prototype._getFilesWithXhr = function(xhr) {
            var file, files;
            return files = (function() {
                var _i, _len, _ref, _results;
                _ref = this.files;
                _results = [];
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    file = _ref[_i];
                    if (file.xhr === xhr) {
                        _results.push(file);
                    }
                }
                return _results;
            }).call(this);
        };

        Dropzone.prototype.cancelUpload = function(file) {
            var groupedFile, groupedFiles, _i, _j, _len, _len1, _ref;
            if (file.status === Dropzone.UPLOADING) {
                groupedFiles = this._getFilesWithXhr(file.xhr);
                for (_i = 0, _len = groupedFiles.length; _i < _len; _i++) {
                    groupedFile = groupedFiles[_i];
                    groupedFile.status = Dropzone.CANCELED;
                }
                file.xhr.abort();
                for (_j = 0, _len1 = groupedFiles.length; _j < _len1; _j++) {
                    groupedFile = groupedFiles[_j];
                    this.emit("canceled", groupedFile);
                }
                if (this.options.uploadMultiple) {
                    this.emit("canceledmultiple", groupedFiles);
                }
            } else if ((_ref = file.status) === Dropzone.ADDED || _ref === Dropzone.QUEUED) {
                file.status = Dropzone.CANCELED;
                this.emit("canceled", file);
                if (this.options.uploadMultiple) {
                    this.emit("canceledmultiple", [file]);
                }
            }
            if (this.options.autoProcessQueue) {
                return this.processQueue();
            }
        };

        resolveOption = function() {
            var args, option;
            option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
            if (typeof option === 'function') {
                return option.apply(this, args);
            }
            return option;
        };

        Dropzone.prototype.uploadFile = function(file) {
            return this.uploadFiles([file]);
        };

        Dropzone.prototype.uploadFiles = function(files) {
            var file, formData, handleError, headerName, headerValue, headers, i, input, inputName, inputType, key, method, option, progressObj, response, updateProgress, url, value, xhr, _i, _j, _k, _l, _len, _len1, _len2, _len3, _m, _ref, _ref1, _ref2, _ref3, _ref4, _ref5;
            xhr = new XMLHttpRequest();
            for (_i = 0, _len = files.length; _i < _len; _i++) {
                file = files[_i];
                file.xhr = xhr;
            }
            method = resolveOption(this.options.method, files);
            url = resolveOption(this.options.url, files);
            xhr.open(method, url, true);
            xhr.withCredentials = !!this.options.withCredentials;
            response = null;
            handleError = (function(_this) {
                return function() {
                    var _j, _len1, _results;
                    _results = [];
                    for (_j = 0, _len1 = files.length; _j < _len1; _j++) {
                        file = files[_j];
                        _results.push(_this._errorProcessing(files, response || _this.options.dictResponseError.replace("{{statusCode}}", xhr.status), xhr));
                    }
                    return _results;
                };
            })(this);
            updateProgress = (function(_this) {
                return function(e) {
                    var allFilesFinished, progress, _j, _k, _l, _len1, _len2, _len3, _results;
                    if (e != null) {
                        progress = 100 * e.loaded / e.total;
                        for (_j = 0, _len1 = files.length; _j < _len1; _j++) {
                            file = files[_j];
                            file.upload = {
                                progress: progress,
                                total: e.total,
                                bytesSent: e.loaded
                            };
                        }
                    } else {
                        allFilesFinished = true;
                        progress = 100;
                        for (_k = 0, _len2 = files.length; _k < _len2; _k++) {
                            file = files[_k];
                            if (!(file.upload.progress === 100 && file.upload.bytesSent === file.upload.total)) {
                                allFilesFinished = false;
                            }
                            file.upload.progress = progress;
                            file.upload.bytesSent = file.upload.total;
                        }
                        if (allFilesFinished) {
                            return;
                        }
                    }
                    _results = [];
                    for (_l = 0, _len3 = files.length; _l < _len3; _l++) {
                        file = files[_l];
                        _results.push(_this.emit("uploadprogress", file, progress, file.upload.bytesSent));
                    }
                    return _results;
                };
            })(this);
            xhr.onload = (function(_this) {
                return function(e) {
                    var _ref;
                    if (files[0].status === Dropzone.CANCELED) {
                        return;
                    }
                    if (xhr.readyState !== 4) {
                        return;
                    }
                    response = xhr.responseText;
                    if (xhr.getResponseHeader("content-type") && ~xhr.getResponseHeader("content-type").indexOf("application/json")) {
                        try {
                            response = JSON.parse(response);
                        } catch (_error) {
                            e = _error;
                            response = "Invalid JSON response from server.";
                        }
                    }
                    updateProgress();
                    if (!((200 <= (_ref = xhr.status) && _ref < 300))) {
                        return handleError();
                    } else {
                        return _this._finished(files, response, e);
                    }
                };
            })(this);
            xhr.onerror = (function(_this) {
                return function() {
                    if (files[0].status === Dropzone.CANCELED) {
                        return;
                    }
                    return handleError();
                };
            })(this);
            progressObj = (_ref = xhr.upload) != null ? _ref : xhr;
            progressObj.onprogress = updateProgress;
            headers = {
                "Accept": "application/json",
                "Cache-Control": "no-cache",
                "X-Requested-With": "XMLHttpRequest"
            };
            if (this.options.headers) {
                extend(headers, this.options.headers);
            }
            for (headerName in headers) {
                headerValue = headers[headerName];
                if (headerValue) {
                    xhr.setRequestHeader(headerName, headerValue);
                }
            }
            formData = new FormData();
            if (this.options.params) {
                _ref1 = this.options.params;
                for (key in _ref1) {
                    value = _ref1[key];
                    formData.append(key, value);
                }
            }
            for (_j = 0, _len1 = files.length; _j < _len1; _j++) {
                file = files[_j];
                this.emit("sending", file, xhr, formData);
            }
            if (this.options.uploadMultiple) {
                this.emit("sendingmultiple", files, xhr, formData);
            }
            if (this.element.tagName === "FORM") {
                _ref2 = this.element.querySelectorAll("input, textarea, select, button");
                for (_k = 0, _len2 = _ref2.length; _k < _len2; _k++) {
                    input = _ref2[_k];
                    inputName = input.getAttribute("name");
                    inputType = input.getAttribute("type");
                    if (input.tagName === "SELECT" && input.hasAttribute("multiple")) {
                        _ref3 = input.options;
                        for (_l = 0, _len3 = _ref3.length; _l < _len3; _l++) {
                            option = _ref3[_l];
                            if (option.selected) {
                                formData.append(inputName, option.value);
                            }
                        }
                    } else if (!inputType || ((_ref4 = inputType.toLowerCase()) !== "checkbox" && _ref4 !== "radio") || input.checked) {
                        formData.append(inputName, input.value);
                    }
                }
            }
            for (i = _m = 0, _ref5 = files.length - 1; 0 <= _ref5 ? _m <= _ref5 : _m >= _ref5; i = 0 <= _ref5 ? ++_m : --_m) {
                formData.append(this._getParamName(i), files[i], files[i].name);
            }
            return this.submitRequest(xhr, formData, files);
        };

        Dropzone.prototype.submitRequest = function(xhr, formData, files) {
            return xhr.send(formData);
        };

        Dropzone.prototype._finished = function(files, responseText, e) {
            var file, _i, _len;
            for (_i = 0, _len = files.length; _i < _len; _i++) {
                file = files[_i];
                file.status = Dropzone.SUCCESS;
                this.emit("success", file, responseText, e);
                this.emit("complete", file);
            }
            if (this.options.uploadMultiple) {
                this.emit("successmultiple", files, responseText, e);
                this.emit("completemultiple", files);
            }
            if (this.options.autoProcessQueue) {
                return this.processQueue();
            }
        };

        Dropzone.prototype._errorProcessing = function(files, message, xhr) {
            var file, _i, _len;
            for (_i = 0, _len = files.length; _i < _len; _i++) {
                file = files[_i];
                file.status = Dropzone.ERROR;
                this.emit("error", file, message, xhr);
                this.emit("complete", file);
            }
            if (this.options.uploadMultiple) {
                this.emit("errormultiple", files, message, xhr);
                this.emit("completemultiple", files);
            }
            if (this.options.autoProcessQueue) {
                return this.processQueue();
            }
        };

        return Dropzone;

    })(Emitter);

    Dropzone.version = "4.2.0";

    Dropzone.options = {};

    Dropzone.optionsForElement = function(element) {
        if (element.getAttribute("id")) {
            return Dropzone.options[camelize(element.getAttribute("id"))];
        } else {
            return void 0;
        }
    };

    Dropzone.instances = [];

    Dropzone.forElement = function(element) {
        if (typeof element === "string") {
            element = document.querySelector(element);
        }
        if ((element != null ? element.dropzone : void 0) == null) {
            throw new Error("No Dropzone found for given element. This is probably because you're trying to access it before Dropzone had the time to initialize. Use the `init` option to setup any additional observers on your Dropzone.");
        }
        return element.dropzone;
    };

    Dropzone.autoDiscover = true;

    Dropzone.discover = function() {
        var checkElements, dropzone, dropzones, _i, _len, _results;
        if (document.querySelectorAll) {
            dropzones = document.querySelectorAll(".dropzone");
        } else {
            dropzones = [];
            checkElements = function(elements) {
                var el, _i, _len, _results;
                _results = [];
                for (_i = 0, _len = elements.length; _i < _len; _i++) {
                    el = elements[_i];
                    if (/(^| )dropzone($| )/.test(el.className)) {
                        _results.push(dropzones.push(el));
                    } else {
                        _results.push(void 0);
                    }
                }
                return _results;
            };
            checkElements(document.getElementsByTagName("div"));
            checkElements(document.getElementsByTagName("form"));
        }
        _results = [];
        for (_i = 0, _len = dropzones.length; _i < _len; _i++) {
            dropzone = dropzones[_i];
            if (Dropzone.optionsForElement(dropzone) !== false) {
                _results.push(new Dropzone(dropzone));
            } else {
                _results.push(void 0);
            }
        }
        return _results;
    };

    Dropzone.blacklistedBrowsers = [/opera.*Macintosh.*version\/12/i];

    Dropzone.isBrowserSupported = function() {
        var capableBrowser, regex, _i, _len, _ref;
        capableBrowser = true;
        if (window.File && window.FileReader && window.FileList && window.Blob && window.FormData && document.querySelector) {
            if (!("classList" in document.createElement("a"))) {
                capableBrowser = false;
            } else {
                _ref = Dropzone.blacklistedBrowsers;
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    regex = _ref[_i];
                    if (regex.test(navigator.userAgent)) {
                        capableBrowser = false;
                        continue;
                    }
                }
            }
        } else {
            capableBrowser = false;
        }
        return capableBrowser;
    };

    without = function(list, rejectedItem) {
        var item, _i, _len, _results;
        _results = [];
        for (_i = 0, _len = list.length; _i < _len; _i++) {
            item = list[_i];
            if (item !== rejectedItem) {
                _results.push(item);
            }
        }
        return _results;
    };

    camelize = function(str) {
        return str.replace(/[\-_](\w)/g, function(match) {
            return match.charAt(1).toUpperCase();
        });
    };

    Dropzone.createElement = function(string) {
        var div;
        div = document.createElement("div");
        div.innerHTML = string;
        return div.childNodes[0];
    };

    Dropzone.elementInside = function(element, container) {
        if (element === container) {
            return true;
        }
        while (element = element.parentNode) {
            if (element === container) {
                return true;
            }
        }
        return false;
    };

    Dropzone.getElement = function(el, name) {
        var element;
        if (typeof el === "string") {
            element = document.querySelector(el);
        } else if (el.nodeType != null) {
            element = el;
        }
        if (element == null) {
            throw new Error("Invalid `" + name + "` option provided. Please provide a CSS selector or a plain HTML element.");
        }
        return element;
    };

    Dropzone.getElements = function(els, name) {
        var e, el, elements, _i, _j, _len, _len1, _ref;
        if (els instanceof Array) {
            elements = [];
            try {
                for (_i = 0, _len = els.length; _i < _len; _i++) {
                    el = els[_i];
                    elements.push(this.getElement(el, name));
                }
            } catch (_error) {
                e = _error;
                elements = null;
            }
        } else if (typeof els === "string") {
            elements = [];
            _ref = document.querySelectorAll(els);
            for (_j = 0, _len1 = _ref.length; _j < _len1; _j++) {
                el = _ref[_j];
                elements.push(el);
            }
        } else if (els.nodeType != null) {
            elements = [els];
        }
        if (!((elements != null) && elements.length)) {
            throw new Error("Invalid `" + name + "` option provided. Please provide a CSS selector, a plain HTML element or a list of those.");
        }
        return elements;
    };

    Dropzone.confirm = function(question, accepted, rejected) {
        if (window.confirm(question)) {
            return accepted();
        } else if (rejected != null) {
            return rejected();
        }
    };

    Dropzone.isValidFile = function(file, acceptedFiles) {
        var baseMimeType, mimeType, validType, _i, _len;
        if (!acceptedFiles) {
            return true;
        }
        acceptedFiles = acceptedFiles.split(",");
        mimeType = file.type;
        baseMimeType = mimeType.replace(/\/.*$/, "");
        for (_i = 0, _len = acceptedFiles.length; _i < _len; _i++) {
            validType = acceptedFiles[_i];
            validType = validType.trim();
            if (validType.charAt(0) === ".") {
                if (file.name.toLowerCase().indexOf(validType.toLowerCase(), file.name.length - validType.length) !== -1) {
                    return true;
                }
            } else if (/\/\*$/.test(validType)) {
                if (baseMimeType === validType.replace(/\/.*$/, "")) {
                    return true;
                }
            } else {
                if (mimeType === validType) {
                    return true;
                }
            }
        }
        return false;
    };

    if (typeof jQuery !== "undefined" && jQuery !== null) {
        jQuery.fn.dropzone = function(options) {
            return this.each(function() {
                return new Dropzone(this, options);
            });
        };
    }

    if (typeof module !== "undefined" && module !== null) {
        module.exports = Dropzone;
    } else {
        window.Dropzone = Dropzone;
    }

    Dropzone.ADDED = "added";

    Dropzone.QUEUED = "queued";

    Dropzone.ACCEPTED = Dropzone.QUEUED;

    Dropzone.UPLOADING = "uploading";

    Dropzone.PROCESSING = Dropzone.UPLOADING;

    Dropzone.CANCELED = "canceled";

    Dropzone.ERROR = "error";

    Dropzone.SUCCESS = "success";


    /*

     Bugfix for iOS 6 and 7
     Source: http://stackoverflow.com/questions/11929099/html5-canvas-drawimage-ratio-bug-ios
     based on the work of https://github.com/stomita/ios-imagefile-megapixel
     */

    detectVerticalSquash = function(img) {
        var alpha, canvas, ctx, data, ey, ih, iw, py, ratio, sy;
        iw = img.naturalWidth;
        ih = img.naturalHeight;
        canvas = document.createElement("canvas");
        canvas.width = 1;
        canvas.height = ih;
        ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);
        data = ctx.getImageData(0, 0, 1, ih).data;
        sy = 0;
        ey = ih;
        py = ih;
        while (py > sy) {
            alpha = data[(py - 1) * 4 + 3];
            if (alpha === 0) {
                ey = py;
            } else {
                sy = py;
            }
            py = (ey + sy) >> 1;
        }
        ratio = py / ih;
        if (ratio === 0) {
            return 1;
        } else {
            return ratio;
        }
    };

    drawImageIOSFix = function(ctx, img, sx, sy, sw, sh, dx, dy, dw, dh) {
        var vertSquashRatio;
        vertSquashRatio = detectVerticalSquash(img);
        return ctx.drawImage(img, sx, sy, sw, sh, dx, dy, dw, dh / vertSquashRatio);
    };


    /*
     * contentloaded.js
     *
     * Author: Diego Perini (diego.perini at gmail.com)
     * Summary: cross-browser wrapper for DOMContentLoaded
     * Updated: 20101020
     * License: MIT
     * Version: 1.2
     *
     * URL:
     * http://javascript.nwbox.com/ContentLoaded/
     * http://javascript.nwbox.com/ContentLoaded/MIT-LICENSE
     */

    contentLoaded = function(win, fn) {
        var add, doc, done, init, poll, pre, rem, root, top;
        done = false;
        top = true;
        doc = win.document;
        root = doc.documentElement;
        add = (doc.addEventListener ? "addEventListener" : "attachEvent");
        rem = (doc.addEventListener ? "removeEventListener" : "detachEvent");
        pre = (doc.addEventListener ? "" : "on");
        init = function(e) {
            if (e.type === "readystatechange" && doc.readyState !== "complete") {
                return;
            }
            (e.type === "load" ? win : doc)[rem](pre + e.type, init, false);
            if (!done && (done = true)) {
                return fn.call(win, e.type || e);
            }
        };
        poll = function() {
            var e;
            try {
                root.doScroll("left");
            } catch (_error) {
                e = _error;
                setTimeout(poll, 50);
                return;
            }
            return init("poll");
        };
        if (doc.readyState !== "complete") {
            if (doc.createEventObject && root.doScroll) {
                try {
                    top = !win.frameElement;
                } catch (_error) {}
                if (top) {
                    poll();
                }
            }
            doc[add](pre + "DOMContentLoaded", init, false);
            doc[add](pre + "readystatechange", init, false);
            return win[add](pre + "load", init, false);
        }
    };

    Dropzone._autoDiscoverFunction = function() {
        if (Dropzone.autoDiscover) {
            return Dropzone.discover();
        }
    };

    contentLoaded(window, Dropzone._autoDiscoverFunction);

}).call(this);
/**
 * Created by sanitkeawtawan on 11/22/15 AD.
 */
var Upload=function(){

  var $element=null;
  var dropzone=null;
  var fileremove=[];
  var options;
  var method= {
    setup:function(_elem,_options){
      options= $.extend({},_options);
      fileremove=[];
      $element=$(_elem);
      //console.log(options);
      $element.dropzone(
            {
              previewTemplate:['<div class="dz-preview dz-file-preview">',
                '<div class="dz-view"><img data-dz-thumbnail /></div>',
                '<div class="dz-tools"><a class="dz-remove" href="javascript:undefined;" data-dz-remove=""><i class="glyphicon glyphicon-trash"></i> ลบ</a></div>',
                '<div class="dz-details2">',
                '<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>',
                '<div class="dz-success-mark"><span>?</span></div>',
                '<div class="dz-error-mark"><span>?</span></div>',
                '<div class="dz-error-message"><span data-dz-errormessage></span></div>',
                '</div>',
                '</div>'].join(''),
              
              url: path+'/usm/uploadfile',
              maxFilesize: 10, // MB
              dictDefaultMessage:'คลิกเพื่ออัพโหลดรูปภาพ',
              // addRemoveLinks:true,
              init: function () {
                var thisDropzone = this;
                dropzone = this;
                // this.on("addedfile", function(file) { alert("Added file."); });
                thisDropzone.on("sending", function(file, xhr, formData){
                  var name= $('meta[name="_token_name"]').attr('content');
                  formData.append(name,  $('meta[name="_token"]').attr('content'));
                });
                if(options.images){
                  $.each(options.images,function(i,image){
                    $.ajax({
                      url: path+'/usm/getFile',
                      type: 'POST',
                      dataType:'json',
                      data: {
                        file:image,
                        csrf_test_name: $('meta[name="_token"]').attr('content')
                      },
                      error: function(error) {
                       // console.log(error);
                      },
                      success: function(value) {
                        var mockFile = {name: value.name, size: value.size ,file:value.file,path:value.path};
                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                        thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.path);
                        thisDropzone.options.complete.call(thisDropzone,mockFile);
                        if(thisDropzone.options.maxFiles){
                          var existingFileCount = 1; // The number of files already uploaded
                          thisDropzone.options.maxFiles = thisDropzone.options.maxFiles - existingFileCount;
                        }
                      }
                    });
                  });
                  
                }
              },
              accept: function (file, done) {
                done();
              },
              success:function(file, response){
               // console.log(response);
                _ref3 = file.previewElement.querySelectorAll("[data-dz-view]");
                // console.log(file,_ref3);
                for (_k = 0, _len2 = _ref3.length; _k < _len2; _k++) {
                  removeLink = _ref3[_k];
                  if(response.data.file){
                    removeLink.href="/"+response.data.file;
                  }
                }
              },
              removedfile:function(file){
                if(file.file){
                  fileremove.push(file.file);
                }
                img="";
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
              }
            }
      );
      return method;
    },
    removeAllFiles:function(){
      dropzone.removeAllFiles();
    },
    getFile:function(){
      var files=[];
      
      $.each(dropzone.files ,function(i,file){
        var obj=JSON.parse(file.xhr.response);
        if(!obj.error){
          files.push(obj.data.file);
        }
      });
      
      if(options.images){
        $.each(options.images,function(i,image){
          if(fileremove.indexOf(image)<0){
            files.push(image);
          }
        });
      }
      return files;
    }
  };
  return method;
  
}();
/**
 * Created by sanitkeawtawan on 6/29/2017 AD.
 */
var $tg=null;
var $tgper=null;
var old=null;
var myUpload=null;
var path="";


var usm=function () {
  function getSelected(callback){
    setTimeout(function(){
      callback();
    },300);
  }
  function renderPermition($content,node){
    $tgper=$('#tgper',$content);
    $tgper.css( "height", function( index ) {
      return 310;
    }).tree({
      rownumbers: false,
      checkOnSelect: true,
      checkbox: true,
      animate: true,
      queryParams:{
        user_id:node.user_id,
        group_id:''
      },
      collapsible: true,
      url:path+'/usm/permission',
      method: 'get',
      
      onSelect:function(node){
        $(this).tree('update',{target:node.target,checked:!node.checked})
      },
      formatter:function(node){
        var str=node.text;
         if(node.checked){
           return "<span class='selected'>"+str+"</span>";
         }
        return str
      }
    });
  
    $.ajax({
      url: path+"/usm/template",
      method: "GET",
      dataType: "JSON",
      success: function(data) {
       var $select_apply =  $('#apply',$content).selectize({
          valueField: 'grp_id',
          labelField: 'grp_title',
          searchField: 'grp_title',
          options: data,
          create: false,
          render: {
            option: function(item, escape) {
              return '<div>' +
                    '<span class="title">' +
                    '<span class="name">' + escape(item.grp_title) + '</span>' +
                    '</span>' +
                    '</div>';
            }
          },
          onChange: function(value) {
            var option= $select_apply[0].selectize.options[value];
            $(option.permission).each(function(i,v){
              var node = $tgper.tree('find', v.app_id);
              if(v.perm_status=='Yes'){
                $tgper.tree('update',{target:node.target,checked:true});
              }else{
                $tgper.tree('update',{target:node.target,checked:false});
              }
            });
            old=value;
          }
        });
      }
    });
  }
  function openPopup(teplname,data,callback){
    $.when(
          $.templateload(teplname),
          data
    ).then(function($tmpl,data) {
      var tmpl = Handlebars.compile($tmpl.html());
      callback($(tmpl(data)));
    });
  }
  function getSelectize($elem,url,options,value,valueField,labelField){
    
        $elem.selectize({
          valueField: valueField,
          labelField: labelField,
          searchField: labelField,
          options: options,
          create: false,
          render: {
            option: function(item, escape) {
              return '<div>' +
                    '<span class="title">' +
                    '<span class="name">' + escape(item[labelField]) + '</span>' +
                    '</span>' +
                    '</div>';
            }
          },
          onInitialize: function() {
            this.setValue(value);
            if(!value)
              $('#user_prename-selectized').val('  ').trigger('keyup');
          },
          load: function(query, callback) {
            $.ajax({
              url: url,
              type: 'GET',
              dataType: 'json',
              data: {
                q: query,
                page_limit: 20,
              },
              error: function() {
                callback();
              },
              success: function(res) {
                callback(res);
              }
            });
          }
        });
      
  }
  function formOrg(title,data,callback){
    openPopup('org',data,function($content){
      var saveing=false;
      var dialog = bootbox.dialog({
        title: title,
        message: $content,
        buttons: {
          confirm: {
            label: 'บันทึก',
            className:'btn-primary',
            callback: function() {
              if(!saveing){
                saveing=true;
                var data=$('form',$content).serializeObject();
                if($.trim(data.org_title)==""){
                  alert('กรุณาระบุชื่อองค์กร');
                  return false;
                }
                var name= $('meta[name="_token_name"]').attr('content');
                data[name]=$('meta[name="_token"]').attr('content');
                
                $.ajax({
                  url: path+"/usm/update_org",
                  method: "POST",
                  data:data,
                  dataType: "JSON",
                  complete: function() {
                    saveing=false;
                  },
                  success: function(data) {
                    if(data.error){
                      alert(data.message);
                    }else{
                      if(typeof  callback==="function"){
                        callback(data.data);
                      }
                    }
                  }
                })
              }
            }
          },
          cancel: {
            label: 'ยกเลิก',
            className:'btn-default',
          }
        
        }
      });
      dialog.init(function(){
        setTimeout(function () {
          $('#org_title',$content).focus();
        },700);
      
      });
    });
  }
  function formUser(title,data,callback){
    openPopup('user',data,function($content){
      var saveing=false;
      var dialog = bootbox.dialog({
        title: title,
        message: $content,
        buttons: {
         
          confirm: {
            label: 'บันทึก',
            className:'btn-primary',
            callback: function() {
              if(!saveing){
                saveing=true;
                var permit=computedId($tgper.tree('getChecked'));
                var data=$('form',$content).serializeObject();
                var name= $('meta[name="_token_name"]').attr('content');
                data[name]=$('meta[name="_token"]').attr('content');
                data.permit=permit;
  
                if($.trim(data.pid)==""){
                  alert('กรุณาระบุเลขประจำตัวประชาชน');
                  return false;
                }else if($.trim(data.passcode)==""){
                  alert('กรุณาระบุรหัสบัญชีผู้ใช้งาน');
                  return false;
                }else if($.trim(data.user_prename)==""){
                  alert('กรุณาระบุคำนำหน้านาม');
                  return false;
                }else if($.trim(data.user_firstname)==""){
                  alert('กรุณาระบุชื่อตัว');
                  return false;
                }else if($.trim(data.user_lastname)==""){
                  alert('กรุณาระบุชื่อสกุล');
                  return false;
                }
                var files=myUpload.getFile();
               
                if(files.length){
                  data.user_photo_file=files[0];
                }
                $.ajax({
                  url: path+"/usm/update_user",
                  method: "POST",
                  data:data,
                  dataType: "JSON",
                  complete: function() {
                    saveing=false;
                  },
                  success: function(data) {
                    if(data.error){
                      alert(data.message);
                      return false;
                    }else{
                      if (typeof callback=='function'){
                        callback(data.data);
                      }
                    }
                  }
                })
              }
              return false;
            }
          },
          cancel: {
            label: 'ยกเลิก',
            className:'btn-default',
          }
        }
      });
      dialog.init(function(){
        getSelectize($('#user_prename',$content),'usm/prename',data.opt_prename,data.pren_code,'pren_code','prename_th');
        setTimeout(function () {
          $('#pid',$content).focus();
            },700);
    
       var files=(data.user_photo_file)?[data.user_photo_file]:[];
       myUpload= Upload.setup($('#formupload',$content),{images:files});
        $('.datepicker',$content).datepicker({language:'th-th',format:'dd/mm/yyyy'});
        renderPermition($content,{user_id:data.user_id});
      });
    });
  }
  function computedId(nodes){
    var permit=[];
    $(nodes).each(function(i,v){
      if(v.checked){
        permit.push(v.id);
       // computedId(v.children);
      }
    });
    return permit;
  }
  return {
    orgNew:function(){
      getSelected(function(){
        var node= $tg.treegrid('getSelected');
        var data={
          org_parent_id:node.org_id
        };
        formOrg('เพิ่มองค์กร',data,function(data){
          $tg.treegrid('append',{
            parent: node.id,
            data:[data]
          });
          bootbox.hideAll();
        });
      });
    },
    orgEdit:function(){
      getSelected(function(){
        var node= $tg.treegrid('getSelected');
        var data={
          org_id:node.org_id,
          org_parent_id:node.org_parent_id,
          org_title:node.org_title
        };
        formOrg('แก้ไขข้อมูลองค์กร',data,function(data){
          $tg.treegrid('update',{
            id: node.id,
            row:{
              org_title:data.org_title,
              title:data.org_title
            }
          });
          bootbox.hideAll();
        });
      });
    },
    orgDel:function(){
  
      bootbox.confirm({
        title: "ยืนยันการลบข้อมูล?",
        message: "ต้องการลบข้อมูล องค์กรนี้หรือไม่",
        buttons: {
          cancel: {
            label: '<i class="fa fa-times"></i> ยกเลิก'
          },
          confirm: {
            label: '<i class="fa fa-check"></i> ตกลง'
          }
        },
        callback: function (result) {
          if(result){
            getSelected(function(){
              var node= $tg.treegrid('getSelected');
              var data={
                org_id:node.org_id
              };
              var name= $('meta[name="_token_name"]').attr('content');
              data[name]=$('meta[name="_token"]').attr('content');
              $.ajax({
                url: path+"/usm/remove_org",
                method: "POST",
                data:data,
                dataType: "JSON",
                complete: function() {
                  saveing=false;
                },
                success: function(data) {
                  if(data.error){
                    alert(data.message);
                  }else{
                    $tg.treegrid('remove',node.id);
                  }
                }
              })
            });
          }
        }
      });
    },
    userNew:function(){
      old=null;
      getSelected(function(){
        var node= $tg.treegrid('getSelected');
        var data={
          org_id:node.org_id,
          org_title:node.org_title,
          user_id:'',
          opt_prename:[]
        };
        formUser('เพิ่มบุคลกร',data,function (data) {
          $tg.treegrid('append',{
            parent: node.id,
            data:[data]
          });
          bootbox.hideAll();
        });
      });
    },
    userEdit:function(){
      old=null;
      getSelected(function(){
        var node= $tg.treegrid('getSelected');
        var data=node;
        data.opt_prename=[{
              pren_code:data.pren_code,
              prename_th:data.prename_th
        }];
        formUser('แก้ไขบุคลกร',data,function (data) {
         
          $tg.treegrid('update',{
            id: node.id,
            row:$.extend(true,node,data)
          });
          bootbox.hideAll();
        });
        // openPopup(teplname,data,function($content){
        //   var saveing=false;
        //   var dialog = bootbox.dialog({
        //     title: 'เพิ่มบุคลกร',
        //     message: $content,
        //     buttons: {
        //       cancel: {
        //         label: '<i class="glyphicon glyphicon-remove"></i> ยกเลิก'
        //       },
        //       confirm: {
        //         label: '<i class="glyphicon glyphicon-ok"></i> บันทึก',
        //         callback: function() {
        //           if(!saveing){
        //             saveing=true;
        //             var data=$('form',$content).serializeObject();
        //             data.csrf_test_name= $('meta[name="_token"]').attr('content');
        //             $.ajax({
        //               url: "/usm/update_user",
        //               method: "POST",
        //               data:data,
        //               dataType: "JSON",
        //               complete: function() {
        //                 saveing=false;
        //               },
        //               success: function(data) {
        //                 if(data.error){
        //                   alert(data.message);
        //                 }else{
        //                   $tg.treegrid('update',{
        //                     id: node.id,
        //                     row: $.extend(true,node,data.data)
        //                   });
        //                 }
        //               }
        //             })
        //           }
        //         }
        //       }
        //     }
        //   });
        //   dialog.init(function(){
        //     getSelectize($('#user_prename',$content),'usm/prename',[{pren_code:node.pren_code,prename_th:node.prename_th}],node.pren_code,'pren_code','prename_th');
        //     setTimeout(function () {
        //       $('#pid',$content).focus();
        //     },700);
        //     renderPermition($content,node);
        //   });
        // });
      });
    },
    userDel:function(){
      bootbox.confirm({
        title: "ยืนยันการลบข้อมูล?",
        message: "ต้องการลบข้อมูล รายการนี้หรือไม่",
        buttons: {
          cancel: {
            label: '<i class="fa fa-times"></i> ยกเลิก'
          },
          confirm: {
            label: '<i class="fa fa-check"></i> ตกลง'
          }
        },
        callback: function (result) {
          if(result){
            getSelected(function(){
              var node= $tg.treegrid('getSelected');
              var data={
                user_id:node.user_id
              };
              var name= $('meta[name="_token_name"]').attr('content');
              data[name]=$('meta[name="_token"]').attr('content');
              $.ajax({
                url: path+"/usm/remove_user",
                method: "POST",
                data:data,
                dataType: "JSON",
                complete: function() {
                  saveing=false;
                },
                success: function(data) {
                  if(data.error){
                    alert(data.message);
                  }else{
                    //$tg.treegrid('remove',node.id);
                    $tg.treegrid('reload');
                  }
                }
              })
            });
          }
        }
      });
    },
  }
}();

$(document).ready(function(){
   $tg=$('#treegrid');
  $.templateload([
    {
      name: 'org',
      url: path+'/assets/modules/usm/tmpl/org.html'
    },
    {
      name: 'user',
      url: path+'/assets/modules/usm/tmpl/user.html'
    }
    ]);

  
    $tg.css( "height", function( index ) {
      return $(window).height()-160;
    }).treegrid({
      rownumbers: false,
      
      animate: true,
      collapsible: true,
      url:path+'/usm/get_org_all',
      method: 'get',
      idField: 'id',
      treeField: 'title',
      remoteFilter:false,
      onDragOver: function(targetRow, sourceRow){
        return (targetRow.org_parent_id);
      },
      onBeforeDrop: function(targetRow,sourceRow,point){
        return (targetRow.org_parent_id&&targetRow.type!='user'||point!='append');
      },
      onDrop: function(targetRow,sourceRow,point){
       if(targetRow.org_parent_id>0){
         var data={
           from_type:sourceRow.type,
           from_id:(sourceRow.type=='org')?sourceRow.org_id:sourceRow.user_id,
           from_parent:(sourceRow.type=='org')?sourceRow.org_parent_id:sourceRow.org_id,
           to_type:targetRow.type,
           to_id:(targetRow.type=='org')?targetRow.org_id:targetRow.user_id,
           to_parent:(targetRow.type=='org')?targetRow.org_parent_id:targetRow.org_id,
           action:point
         };
         var name= $('meta[name="_token_name"]').attr('content');
         data[name]=$('meta[name="_token"]').attr('content');
         
         $.ajax({
                 url: path+"/usm/move",
                 method: "POST",
                 dataType: "JSON",
                 data: data,
                 success: function(data) {
                   console.log(data);
                 }
         });
       
         
         
       }
      },
      onLoadSuccess: function(){
        $tg.treegrid('enableDnd',null);
      },
      columns: [[
        {title: 'หน่วยงาน', field: 'title', width: '80%',
          formatter: function (value, row) {
            var format=value;
            if (row.type == 'org') {
                if(row.children){
                    var x=0;
                    $(row.children).each(function(i,v){
                      if(v.type=='user')
                        x++;
                    });
                    if(x)
                      format+=" <span style='color: red'>("+x+"บัญชี)</span>"
                  }
            }
            return format;
          }
          },
        {title: 'จัดการ', field: 'action',   align: 'right', width: '20%',
          formatter: function (value, row) {
            var format = [];
            if (row.org_parent_id == 0) {
              format.push("<a class='btn btn-default' href='javascript:void(0)' title='เพิ่มองค์กร' onclick='usm.orgNew()'><i class='glyphicon glyphicon glyphicon-home'></i></a>");
            } else {
              if (row.type == 'org') {
                format.push("<a class='btn btn-default' href='javascript:void(0)' title='เพิ่มองค์กร' onclick='usm.orgNew()'><i class='glyphicon glyphicon glyphicon-home'></i></a>");
                if (row.last) {
                  format.push("<a class='btn btn-default' href='javascript:void(0)' title='เพิ่มบุคลกร' onclick='usm.userNew()'><i class='glyphicon  glyphicon-user'></i></a>");
                }else{
                  format.push("<a class='btn btn-default' href='javascript:void(0)'  disabled title='เพิ่มบุคลกร' onclick='usm.userNew()'><i class='glyphicon disabled  glyphicon-user'></i></a>");
                }
                format.push("<a class='btn btn-default' href='javascript:void(0)' title='แก้ไขข้อมูลองค์กร' onclick='usm.orgEdit()'><i class='glyphicon glyphicon-pencil'></i></a>");
                
                format.push("<a class='btn btn-default' href='javascript:void(0)' title='ลบองค์กร' onclick='usm.orgDel()'><i class='glyphicon glyphicon-trash'></i></a>");
              }else if(row.type == 'user'){
                format.push("<a class='btn btn-default' href='javascript:void(0)' title='แก้ไขบุคลกร' onclick='usm.userEdit()'><i class='glyphicon glyphicon-pencil'></i></a>");
                format.push("<a class='btn btn-default' href='javascript:void(0)'' title='ลบบุคลกร' onclick='usm.userDel()'><i class='glyphicon glyphicon-trash'></i></a>");
              }
            }
            return format.join('');
          }
        }
      ]]
    }).treegrid('enableFilter');
  $('#search').on('keyup',function(){

      $tg.treegrid('addFilterRule', {
        field: 'title',
        op: 'contains',
        value: this.value
      }).treegrid('doFilter');

  });
  
  
  
});
//# sourceMappingURL=script.js.map
