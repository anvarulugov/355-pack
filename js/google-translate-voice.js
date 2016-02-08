/**
 * Created by Dilshod on 30.01.2016.
 */
//jQuery(document).ready(function ($) {
    function getVoice(){
        var selection;
        if (window.getSelection) {
            selection = window.getSelection();

        } else if (document.selection) {
            selection = document.selection.createRange();
        }
        var query = selection.toString();
        //var query = 'Hello';
        var cM = function(a) {
            return function() {
                return a
            }
        };
        var of = "=";
        var dM = function(a, b) {
            for (var c = 0; c < b.length - 2; c += 3) {
                var d = b.charAt(c + 2),
                    d = d >= t ? d.charCodeAt(0) - 87 : Number(d),
                    d = b.charAt(c + 1) == Tb ? a >>> d : a << d;
                a = b.charAt(c) == Tb ? a + d & 4294967295 : a ^ d
            }
            return a
        };

        var eM = null;
        var cb = 0;
        var k = "";
        var Vb = "+-a^+6";
        var Ub = "+-3^+b+-f";
        var t = "a";
        var Tb = "+";
        var dd = ".";
        var hoursBetween = Math.floor(Date.now() / 3600000);
        window.TKK = hoursBetween.toString();

        fM = function(a) {
            var b;
            if (null === eM) {
                var c = cM(String.fromCharCode(84)); // char 84 is T
                b = cM(String.fromCharCode(75)); // char 75 is K
                c = [c(), c()];
                c[1] = b();
                // So basically we're getting window.TKK
                eM = Number(window[c.join(b())]) || 0
            }
            b = eM;

            // This piece of code is used to convert d into the utf-8 encoding of a
            var d = cM(String.fromCharCode(116)),
                c = cM(String.fromCharCode(107)),
                d = [d(), d()];
            d[1] = c();
            for (var c = cb + d.join(k) +
                of, d = [], e = 0, f = 0; f < a.length; f++) {
                var g = a.charCodeAt(f);

                128 > g ? d[e++] = g : (2048 > g ? d[e++] = g >> 6 | 192 : (55296 == (g & 64512) && f + 1 < a.length && 56320 == (a.charCodeAt(f + 1) & 64512) ? (g = 65536 + ((g & 1023) << 10) + (a.charCodeAt(++f) & 1023), d[e++] = g >> 18 | 240, d[e++] = g >> 12 & 63 | 128) : d[e++] = g >> 12 | 224, d[e++] = g >> 6 & 63 | 128), d[e++] = g & 63 | 128)
            }

            a = b || 0;
            for (e = 0; e < d.length; e++) a += d[e], a = dM(a, Vb);
            a = dM(a, Ub);
            0 > a && (a = (a & 2147483647) + 2147483648);
            a %= 1E6;
            return a.toString() + dd + (a ^ b)
        };
        var token = fM(query);
        current_lang = jQuery('html').attr('lang');
        if (current_lang=='en-US') {current_lang = 'en';}
        if (current_lang=='ru-RU') {current_lang = 'ru';}
        if (current_lang=='uz') {current_lang = 'tr';}

        var url = "https://translate.google.com/translate_tts?ie=UTF-8&q="  + encodeURI(query) + "&tl="+current_lang+"&total=1&idx=0&textlen=12&tk=" + token + "&client=t";
        //url = 'https://translate.google.com/translate_tts?ie=UTF-8&q='  + encodeURI(query) + '&tl=en&client=tw-ob'   // it is not token

        var div = document.getElementById("voice-section");
        div.innerHTML = '';
        div.innerHTML = '<iframe src="'+url+'" ></iframe>';
    }
//});
