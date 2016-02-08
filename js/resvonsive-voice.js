/**
 * Created by Dilshod on 30.01.2016.
 */

    function getVoice(){
    responsiveVoice.cancel();
    function getSelectionText() {
        var text = "";
        if (window.getSelection) {
            text = window.getSelection().toString();
        } else if (document.selection && document.selection.type != "Control") { // for Internet Explorer 8 and below
            text = document.selection.createRange().text;
        }
        return text;
    }
    responsiveVoice.cancel(); // stop anything currently being spoken
    current_lang = jQuery('html').attr('lang');
    if (current_lang=='en-US') {
        alert(1);
        responsiveVoice.setDefaultVoice("UK English Female");
    }
    if(current_lang=='ru-RU'){
        alert(2);
        responsiveVoice.setDefaultVoice("Russian Female");
    }
    if (current_lang=='uz') {
        alert(3);
        responsiveVoice.setDefaultVoice("Turkish Female");
    }
    responsiveVoice.speak(getSelectionText()); //speak the text as returned by getSelectionText



}

