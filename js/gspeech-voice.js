/**
 * Created by Dilshod on 30.01.2016.
 */

function getVoice(){
    var selection;
    if (window.getSelection) {
        selection = window.getSelection();
    } else if (document.selection) {
        selection = document.selection.createRange();
    }
    if (selection.toString().length >= 3 && typeof selection.toString() === "string" || selection.toString() instanceof String) {
        query = selection.toString();
        current_lang = jQuery('html').attr('lang');
        if (current_lang=='en-US') {current_lang = 'ru';}
        if (current_lang=='ru-RU') {current_lang = 'ru';}
        if (current_lang=='uz') {current_lang = 'uz';}

        var url = "http://agro.uz/bitrix/components/pixelcraft/gspeech/streamer.php?q=" + encodeURI(query) +"&l="+current_lang+"&tr_tool=g";

        var div = document.getElementById("voice-section");
        div.innerHTML = '';
        div.innerHTML = '<video controls="" autoplay="" name="media"><source src="'+url+'" ' +
                            'type="audio/mpeg">' +
                        '</video>';





    }
}

