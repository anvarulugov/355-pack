/**
 * Created by Dilshod on 27.01.2016.
 */
jQuery(document).ready(function ($) {

    /////////  Bootstap Style  /////////

    style = $('.search-button-blur').attr('data-id');

    ////////   Google Voice    /////////

    $(document).bind('mouseup','body', function(e){

        var selection;
        if (window.getSelection) {
            selection = window.getSelection();
        } else if (document.selection) {
            selection = document.selection.createRange();
        }
        if (selection.toString().length >= 3 && typeof selection.toString() === "string" || selection.toString() instanceof String) {
            $('#btn-voice').modal({
                show: 'show'
            });
            $("#btn-voice .modal-backdrop.in").css({
                'filter': 'alpha(opacity=50)',
                'opacity': '0'
            });

            $('#btn-voice .btn').css({
                'display':'inline-block',
                'position':'absolute',
                'z-index':'999999',
                'top': eval(e.pageY+'+'+15)+'px',
                'left': eval(e.pageX+'+'+15)+'px',
            });
        }
    });

    $('#btn-voice .btn').on('click', (function (e) {
        getVoice();
    }));


    /////////        End Google Voice  /////////

    /////////         Modal Search    /////////

    var r = '<div class="modal fade modal-search" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" style="display: none;" aria-hidden="true"> ' +
        '<div class="modal-dialog" role="document"> ' +
        '<div class="search-title "><h3>Qidiruv</h3></div> ' +
        '<form role="search" method="get" id="searchform" action="'+window.location.protocol+'//'+window.location.host+'?="> ' +
        '<div class="search-wrapper"> ' +
        '<input placeholder="Nimani qidiramiz..." autofocus=autofocus type="text" class="form-control search-input" size="15" value="" name="s" id="s"> ' +
        '<button type="submit" class="search-submit btn-'+style+'" ><i class="glyphicon glyphicon-search"></i></button> ' +
        '</div> ' +
        '</form> ' +
        '</div> ' +
        '</div>';
    $('body').after(r);

    $('.accessibility-search .search-button-blur').on('click', (function (e) {
        $('body').toggleClass('search-mode');
    }));

    $(document).on('keyup',function(evt) {
        if (evt.keyCode == 27) {
            $('body').removeClass('search-mode');
        }
    });

    /////////      End  Modal Search      /////////

    /////////       Animate Search       /////////

    $('.accessibility-search .search-button-simple').on('click', (function (e) {
        $('.accessibility-search #hidden-search').toggleClass('open-search');
    }));

    $(document).on('mouseup', function(e) {
		var container = $("#searchform input");
        if (!container.is(e.target)) {
            $('body').removeClass('search-mode');
        }
    });

    //////////////       End Animate Search       ///////////

    $(function () {
        $("[data-toggle='tooltip']").tooltip();
    });

    ///////////////          Blind mode           ////////////////

        $('.dropdown-menu-accessibility').click(function(event){
            event.stopPropagation();
        });
        $("#accessibility-zoom").on('change',function(){
            var zoom = $(this).val();
            $('#accessibility-zoom-value').text(zoom +'%');

            if (sessionStorage.clickcount) {
                sessionStorage.clickcount = Number(sessionStorage.clickcount)+1;
                $('body').attr('data-font',sessionStorage.fonsize);
                $('body').attr('data-line',sessionStorage.line_height);
            } else {
                sessionStorage.clickcount = 0;
            }
            if (sessionStorage.clickcount==0) {
                main_size = parseInt($('body').css('font-size'));
                line_height = parseInt($('body').css('line-height'));
                $('body').attr('data-font',main_size);
                $('body').attr('data-line',line_height);
                sessionStorage.fonsize = main_size;
                sessionStorage.line_height = line_height;
                sessionStorage.clickcount = 1;
            }
            if (zoom>=0 && zoom <20) { sessionStorage.nextsizepercent = zoom; zoom = 0; sessionStorage.clickcount = 0;}
            if (zoom>=20 && zoom <40) {sessionStorage.nextsizepercent = zoom;zoom = 3;}
            if (zoom>=40 && zoom <60) {sessionStorage.nextsizepercent = zoom;zoom = 6;}
            if (zoom>=60 && zoom <80) {sessionStorage.nextsizepercent = zoom;zoom = 9;}
            if (zoom>=80 && zoom <100) {sessionStorage.nextsizepercent = zoom;zoom = 12;}
            if (zoom==100) {sessionStorage.nextsizepercent = zoom;zoom = 15;}
            zoom = eval($('body').attr('data-font') + '+' + zoom);
            line_height = eval($('body').attr('data-line') + '+' + zoom);
            $('body').css("font-size", zoom);
            $('body').css("font-line", line_height);
            sessionStorage.nextsize = zoom;
            sessionStorage.line_height = line_height;

            return false;
        });
         $('body .dropdown-accessibility').on('click', (function (e) {
             $(this).parent().toggleClass('open');
         }));
        if(typeof(Storage) !== "undefined") {
            if (sessionStorage.nextsize) {
                $('body').css("font-size", sessionStorage.nextsize+'px');
                $('#accessibility-zoom-value').text(sessionStorage.nextsizepercent +'%');
                $('#accessibility-zoom').val(sessionStorage.nextsizepercent);
                if (sessionStorage.line_height) {
                    $('body').css("font-line", sessionStorage.line_height+'px');
                }
            }

            if (sessionStorage.dark==1) {
                sessionStorage.dark = 1;
                sessionStorage.grey = 0;
                $('*').filter(function() {
                    if (this.currentStyle)
                        return this.currentStyle['backgroundImage'] !== 'none';
                    else if (window.getComputedStyle)
                        return document.defaultView.getComputedStyle(this,null)
                                .getPropertyValue('background-image') !== 'none';
                }).addClass('has-background');
                $('html').addClass('dark-mode');
            }
            if (sessionStorage.grey==1) {
                sessionStorage.grey = 1;
                sessionStorage.dark = 0;
                $('html').addClass('grey-mode');
            }
        }
        $('#normal-mode').on('click', function () {
            $('html').removeClass('grey-mode');
            $('html').removeClass('dark-mode');
            $('*').filter(function() {
                if (this.currentStyle)
                    return this.currentStyle['backgroundImage'] !== 'none';
                else if (window.getComputedStyle)
                    return document.defaultView.getComputedStyle(this,null)
                            .getPropertyValue('background-image') !== 'none';
            }).removeClass('has-background');
            if(typeof(Storage) !== "undefined") {
                if (sessionStorage.dark==1) {
                    sessionStorage.dark = 0;
                }
                if (sessionStorage.grey==1) {
                    sessionStorage.grey = 0;
                }
            }
        });
        $('#white-black-mode').on('click', function () {
            $('html').removeClass('dark-mode');
            $('html').addClass('grey-mode');
            if(typeof(Storage) !== "undefined") {
                if (sessionStorage.dark==1) {
                    sessionStorage.dark = 0;
                }
                sessionStorage.grey = 1;
            }
        });
        $('#dark-mode').on('click', function () {
            $('html').removeClass('grey-mode');
            $('html').addClass('dark-mode');
            $('*').filter(function() {
                if (this.currentStyle)
                    return this.currentStyle['backgroundImage'] !== 'none';
                else if (window.getComputedStyle)
                    return document.defaultView.getComputedStyle(this,null)
                            .getPropertyValue('background-image') !== 'none';
            }).addClass('has-background');
            if(typeof(Storage) !== "undefined") {
                sessionStorage.dark = 1;
                if (sessionStorage.grey==1) {
                    sessionStorage.grey = 0;
                }
            }
        });

    ///////////////         End Blind mode           //////////////


});