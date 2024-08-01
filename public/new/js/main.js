$(function(){

    "use strict";


    /* counter */
     $('.counter').counterUp({
        delay: 10,
        time: 1000
    });

    /* select2 */
    $(document).ready(function() {
        $('.select-p').select2();
    });


    /*
    side-menu
    *********************************/
    $('.side-menu-btn').on('click', function(){

        $('.side-menu').toggleClass('show');

        if ($('.side-menu').hasClass('show')) {
            $('.side-menu').animate({right: 0}, 500);
            $('body').animate({left: '-' + $('.side-menu').innerWidth()}, 500);
        } else {
            $('.collapse').removeClass('show');
            $('.collapse').slideUp();
            $('.link-header').removeClass('active');
            $('.side-menu .link .link-header button').removeClass('active');
            $('.side-menu .link .link-header button a').removeClass('active');
            $('.link-header span.chevron').children('i').removeClass('fa-times');
            $('.side-menu').animate({right: '-' + $('.side-menu').innerWidth()}, 500);
            $('body').animate({left: 0}, 500);
        }

    });



    $('.side-menu .link .link-header button').on('click', function(){

        $(this).parent().parent().parent('.link').toggleClass('show');

        if ($('.side-menu .link').hasClass('show')) {

            $('.side-menu .link').removeClass('show');
            $(this).parent().parent().parent('.link').addClass('show');

            $('.side-menu .link .link-header').removeClass('active');
            $(this).parent().parent('.link-header').addClass('active');

            $('.side-menu .link .link-header button').removeClass('active');
            $('.side-menu .link .link-header button a').removeClass('active');
            $(this).addClass('active');
            $(this).children('a').addClass('active');

            $('.side-menu .link .link-header span.chevron i').removeClass('fa-times');
            $(this).parent().next('span.chevron').children('i').addClass('fa-times');

        } else {

            $(this).parent().parent('.link-header').removeClass('active');
            $(this).removeClass('active');
            $(this).children('a').removeClass('active');
            $(this).parent().next('span.chevron').children('i').removeClass('fa-times');

        }

        $(this).parent().parent().next('.collapse').toggleClass('show');

        if ($(this).parent().parent().next('.collapse').hasClass('show')) {
            $('.collapse').removeClass('show');
            $('.collapse').slideUp();
            $(this).parent().parent().next('.collapse').addClass('show');
            $(this).parent().parent().next('.collapse').slideDown();
        } else {
            $(this).parent().parent().next('.collapse').removeClass('show');
            $(this).parent().parent().next('.collapse').slideUp();
        }

    });



    $('body').on('click', function(){
        $('.collapse').removeClass('show');
        $('.collapse').slideUp();
        $('.link-header').removeClass('active');
        $('.side-menu .link .link-header button').removeClass('active');
        $('.side-menu .link .link-header button a').removeClass('active');
        $('.link-header span.chevron').children('i').removeClass('fa-times');
        $('.side-menu').removeClass('show');
        $('.side-menu').animate({right: '-' + $('.side-menu').innerWidth()}, 500);
        $('body').animate({left: 0}, 500);
    });

    $('.side-menu-btn, .side-menu').click(function(e){
        e.stopPropagation();
    });



    /*
    top-bar
    *********************************/
    $('.top-bar ul li span.button').on('click', function(){

        $('.' + $(this).attr('id')).toggleClass('show');

        if ($('.' + $(this).attr('id')).hasClass('show')){
            $('.top-bar .messages, .top-bar .notifications, .top-bar .user-profile').fadeOut(200).removeClass('show');
            $('.' + $(this).attr('id')).addClass('show');
            $('.' + $(this).attr('id')).fadeIn(200);
        } else {
            $('.' + $(this).attr('id')).fadeOut(200);
        }

    });

    $('body').on('click', function(){

        $('.top-bar .messages, .top-bar .notifications, .top-bar .user-profile').removeClass('show');
        $('.top-bar .messages, .top-bar .notifications, .top-bar .user-profile').fadeOut(200);

    });

    $('.top-bar ul li span.button').click(function(e){
        e.stopPropagation();
    });



    /************************* report page *************************/
    $('.services .row div.service').on('click', function(){

        $('.services .row div.service').removeClass('active');
        $(this).addClass('active');

        $('div.numbers').hide();
        $($(this).attr("id")).fadeIn(500);

    });



    /************************* adding-educational-plan page *************************/
    $('.main-student-area .save-plan-cont span').on('click', function(){

        $('.main-student-area .save-plan-cont span:first-of-type').toggleClass('active');
        $('.main-student-area .save-plan-cont div.s-cont').toggleClass('d-none');

    });

    $('.main-student-area:first-of-type .revision-plan-cont span').on('click', function(){

        $('.main-student-area .revision-plan-cont span:first-of-type').toggleClass('active');
        $('.main-student-area .revision-plan-cont div.r-cont').toggleClass('d-none');

    });


    $('.student-area span.plus22').on('click', function(){

        $('.student-area').append('<div class="student-area-new position-relative mb-200px mt-100px"><div class="text-center mb-30px"><div><span class="d- inline-block ml-5px"><img src="images/studentname.png" alt=""></span><h3 class="d-inline-block mb-0px">اسم الطالب</h3></div><div class="student-name-input position-relative d-inline-block pr-sm-20px pl-sm-20px"><select class="select-p student-name width-sm-200px" ><option disabled selected>قم بكتابة الاسم</option><option class="blue-color">مصطفى</option><option class="blue-color">إبراهيم</option><option class="blue-color">أحمد</option></select></div></div><div class="row text-center mb-50px below-student-name"><div class="col-sm-2 offset-sm-4"><div><h5 class="fw-600 mb-50px">التكرار</h5><input class="width-sm-30" placeholder="10" type="text"></div></div><div class="col-sm-2"><div><h5 class="fw-600 mb-50px">الربط</h5><input class="width-sm-30" placeholder="10" type="text"</div></div></div><div class="row text-center width-100 margin-auto"><div class="col-md-6"><div class="mb-md-100px"><div class="main-title mb-50px text-center container"><div class="position-relative d-inline-block"><h1>خطة الحفظ</h1><span class="yellow-bar"></span></div></div><div class="row save-plan-cont position-relative"><span class="save-dot"></span><span class="save-dot-place"></span><div class="save-bg"></div><div class="s-cont col-md-6"><div class="start"><h4 class="d-inline-block fw-600 mb-30px blue-bgcolor fff-color pr-20px pl-20px pt-5px pb-5px br-15px">1-البداية</h4><h5 class="fw-600 mb-30px">السورة</h5><select class="select-p width-sm-30 width-lg-to-md-65"><option disabled selected>الفاتحة</option><option class="blue-color">الناس</option><option class="blue-color">الفلق</option><option class="blue-color">الأخلاص</option></select><h5 class="fw-600 mb-30px">الآية</h5><select class="select-p width-sm-30 width-lg-to-md-65"><option disabled selected>3</option><option class="blue-color">5</option><option class="blue-color">81</option><option class="blue-color">22</option></select></div></div><div class="s-cont col-md-6"><div class="end"><h4 class="d-inline-block fw-600 mb-30px blue-bgcolor fff-color pr-20px pl-20px pt-5px pb-5px br-15px">2-النهاية</h4><h5 class="fw-600 mb-30px">السورة</h5><select class="select-p width-sm-30 width-lg-to-md-65"><option disabled selected>الفاتحة</option><option class="blue-color">الناس</option><option class="blue-color">الفلق</option><option class="blue-color">الأخلاص</option></select><h5 class="fw-600 mb-30px">الآية</h5><select class="select-p width-sm-30 width-lg-to-md-65"><option disabled selected>3</option><option class="blue-color">5</option><option class="blue-color">81</option><option class="blue-color">22</option></select></div></div><div class="s-cont col-md-6 d-none"><div class="start"><h4 class="d-inline-block fw-600 mb-30px blue-bgcolor fff-color pr-20px pl-20px pt-5px pb-5px br-15px">1-البداية</h4></div></div><div class="s-cont col-md-6 d-none"><div class="end"><h4 class="d-inline-block fw-600 mb-30px blue-bgcolor fff-color pr-20px pl-20px pt-5px pb-5px br-15px">2-النهاية</h4></div></div><div class="s-cont col-md-12 d-none"><h5 class="fw-600 mb-30px margin-101px-10px">لا يوجد خطة مضافة</h5></div></div></div></div><div class="col-md-6"><div><div class="main-title mb-50px text-center container"><div class="position-relative d-inline-block"><h1>خطة المراجعة</h1><span class="yellow-bar"></span></div></div><div class="row revision-plan-cont position-relative"><span class="revision-dot"></span><span class="revision-dot-place"></span><div class="revision-bg"></div><div class="r-cont col-md-6"><div class="start"><h4 class="d-inline-block fw-600 mb-30px blue-bgcolor fff-color pr-20px pl-20px pt-5px pb-5px br-15px">1-البداية</h4><h5 class="fw-600 mb-30px">السورة</h5><select class="select-p width-sm-30 width-lg-to-md-65"><option disabled selected>الفاتحة</option><option class="blue-color">الناس</option><option class="blue-color">الفلق</option><option class="blue-color">الأخلاص</option></select><h5 class="fw-600 mb-30px">الآية</h5><select class="select-p width-sm-30 width-lg-to-md-65"><option disabled selected>3</option><option class="blue-color">5</option><option class="blue-color">81</option><option class="blue-color">22</option></select></div></div><div class="r-cont col-md-6"><div class="end"><h4 class="d-inline-block fw-600 mb-30px blue-bgcolor fff-color pr-20px pl-20px pt-5px pb-5px br-15px">2-النهاية</h4><h5 class="fw-600 mb-30px">السورة</h5><select class="select-p width-sm-30 width-lg-to-md-65"><option disabled selected>الفاتحة</option><option class="blue-color">الناس</option><option class="blue-color">الفلق</option><option class="blue-color">الأخلاص</option></select><h5 class="fw-600 mb-30px">الآية</h5><select class="select-p width-sm-30 width-lg-to-md-65"><option disabled selected>3</option><option class="blue-color">5</option><option class="blue-color">81</option><option class="blue-color">22</option></select></div></div><div class="r-cont col-md-6 d-none"><div class="start"><h4 class="d-inline-block fw-600 mb-30px blue-bgcolor fff-color pr-20px pl-20px pt-5px pb-5px br-15px">1-البداية</h4></div></div><div class="r-cont col-md-6 d-none"><div class="end"><h4 class="d-inline-block fw-600 mb-30px blue-bgcolor fff-color pr-20px pl-20px pt-5px pb-5px br-15px">2-النهاية</h4></div></div><div class="r-cont col-md-12 d-none"><h5 class="fw-600 mb-30px margin-101px-10px">لا يوجد خطة مضافة</h5></div></div></div></div></div></div>');


        /* select2 */
        $(document).ready(function() {
            $('.select-p').select2();
        });


        $('.student-area-new:last-of-type .save-plan-cont span').on('click', function(){

            $('.student-area-new:last-of-type .save-plan-cont span:first-of-type').toggleClass('active');
            $('.student-area-new:last-of-type .save-plan-cont div.s-cont').toggleClass('d-none');

        });


        $('.student-area-new:last-of-type .revision-plan-cont span').on('click', function(){

            $('.student-area-new:last-of-type .revision-plan-cont span:first-of-type').toggleClass('active');
            $('.student-area-new:last-of-type .revision-plan-cont div.r-cont').toggleClass('d-none');

        });

        $('.start select, .end select, .student-name-input select.student-name').change(function(){

            $(this).css({color: '#2d475b'});

        });

    });



    /************************* followup-educational-plan page *************************/
    $('.students h5').on('click', function(){

        $('.students h5').removeClass('active');
        $(this).addClass('active');

        $($(this).attr("id")).fadeIn(500).siblings().hide();

    });



    /************************* adding-leader-plan page *************************/
    $('.weeks-form .plus').on('click', function(){

        var form_row = $(this).closest('.weeks-form').find('.first-week').find('.row').clone();
        form_row.find('input').val('');
        var new_row = $("<div />").addClass('new-row mt-20px position-relative');
        new_row.append('<div class="plus-minus-new"><span class="minus d-inline-block cursor-pointer yellow-color"><i class="fas fa-minus"></i></span></div>');
        new_row.append(form_row);
        $(this).closest('.weeks-form').find('.content-bg').append(new_row);
        $('.new-row .minus').on('click', function(){
            swal({
                title: "هل انت متاكد من الحذف ؟",
                text: "سيتم حذف العنصر نهائيا من الخطة",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons : {
                    cancel: {
                        text: "تراجع",
                        value: null,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                    confirm: {
                        text: "حذف",
                        value: true,
                        visible: true,
                        className: "",
                        closeModal: true
                    }
                }
                })
                .then((willDelete) => {
                if (willDelete) {
                    $(this).parent().parent().remove();
                } else {
                    return;
                }
                });
        });

    });



    /************************* adding-student page *************************/
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

        reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function(){
        readURL(this);
    });

    $('form .pic-box .student-pic input').change(function(){
        $('form .pic-box span').remove();
    });



    /************************* log-in page *************************/
    $('.log-in-bg').css({

        'height': $(window).innerHeight()

    });



    /************************* followup-leader-plan page *************************/
    $('.selected-week h4').on('click', function(){

        $('.selected-week h4').removeClass('active');
        $(this).addClass('active');

        $('.selected-week-info div.form').hide();
        $($(this).attr('id')).fadeIn(500);

    });


    function imgToData(input) {
        if (input.files && input.files[0]) {

            var File = new FileReader();
            File.onload = function() {
                var Img = new Image();

                Img.onload = function() {
                    $('#' + input.id + '-val').val(Img.src);
                    $('#' + input.id + '-preview').attr('src', Img.src).css('visibility', 'visible').fadeIn();
                };
                Img.src = File.result;
            };

            File.readAsDataURL(input.files[0]);
        }
    }

    $("input[type='file']").each(function() {
        $(this).change(function() {
            if (parseInt($(this).get(0).files.length) > 3) {
                alert("You can only upload a maximum of 3 images");
            } else {
                imgToData(this);
            }
        });
    });


    $('.pic-box input').change(function(){

        $(this).parent().parent().children('span').hide();

    });



    /************************* control-panel page *************************/
    $('.tasks-notes-box').on('mouseenter', function(){

        $(this).addClass('active');
        $(this).children('span').fadeIn(300);

    });

    $('.tasks-notes-box').on('mouseleave', function(){

        $(this).removeClass('active');
        $(this).children('span').fadeOut(300);

    });



    /************************* project-details page *************************/
    $('.project-tabs .tab.active').addClass('active');

    $('.project-tabs .tab.active span.main').hide();

    $('.project-tabs .tab.active span.show').show();

    $('.project-tabs .tab').on('click', function(){

        $('.project-tabs .tab').removeClass('active');
        $(this).addClass('active');

        $('.project-tabs .tab span.main').show();
        $(this).children('span.main').hide();

        $('.project-tabs .tab span.show').hide();
        $(this).children('span.show').show();

        $($(this).attr('id')).fadeIn(300).siblings().hide();

    });

    $('.files .upload-file input[type="file"]').change(function(){

         $(this).prev('span').text($(this)[0].files[0].name);
    });


});

function showMessage(text) {
    resetMessage();
    $("#result")
    .addClass("alert alert-success")
    .text(text);
}
