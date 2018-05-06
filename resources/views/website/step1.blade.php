@extends('website.layouts.app')

@section('content')

    <style>

        #myProgress {

            width: 76%;

            background-color: #ddd;

        }



        #myBar {

            background-color: #ff7f00;

            text-align: center;

            line-height: 20px;

            color: white;

        }
        .form-content .btn-search{padding: 14.5px 25px;}
        .footer .btn.subscribe{padding: 12px 12px;}
        .footer-follow li a{padding-top: 8px;}

    </style>



    <main class="site-main">

            <div class="container-inner">

                <div class="tab-shopping">

                    <div class="tab-shoppping-cart">

                        @include('website.sidemenu')

                        <div class="tab-container" style="padding-top: 0px;">
                            <div id="tab-1" class="tab-panel active">
                                <section class="ai06-cart-step">

                                    <div class="">
                                        <ul>
                                            <li class="active"><a href="{{url('step1')}}"><span class="cp-img-04">UPLOAD APK FILE</span></a></li>

                                            <li><a href="{{url('step2')}}"><span class="cp-img-04">APP DETAILS</span></a></li>

                                            <li><a href="{{url('step3')}}"><span class="cp-img-04">APP SCREENSHOTS</span></a></li>

                                            <li><a href="{{url('step4')}}"><span class="cp-img-04">APP CONFIRMED</span></a></li>

                                            <div class="clearfix"></div>

                                        </ul>

                                    </div>

                                </section>

                                <div class="col-md-6">

                                    <form class="step1" method="post" action="{{url('step1_create')}}" enctype="multipart/form-data">

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">



                                        <p class="form-row form-row-wide">

                                            <label for="app_name">App Name <span class="note-impor">*</span></label>

                                            @if(isset($image))

                                            {!! Form::text('app_name', $image->app_name, ['class' => 'input-text']) !!}

                                            @else

                                                {!! Form::text('app_name', null, ['class' => 'input-text']) !!}

                                            @endif

                                            @if ($errors->has('app_name'))

                                                <span class="help-block" style="color: red">

                                                    <strong>

                                                        {{ $errors->first('app_name') }}

                                                    </strong>

                                                </span>

                                            @endif

                                        </p>



                                        <p class="form-row form-row-wide">

                                        <label for="upload_apk">Upload your first APK to Production <span class="note-impor">*</span></label>

                                        <div class="fileUpload btn btn-warning">

                                            <span>Upload Apk</span>

                                            <input type="file" class="upload" id="upload" name="upload_apk" onChange="AjaxUploadImage1(this)"/>

                                        </div>

                                        <span id="msg" style="color: red"></span><span id="msg_size" style="color: red"></span>

                                        <div id="myProgress">

                                            <div id="myBar"></div>

                                        </div>

                                        @if ($errors->has('upload_apk'))

                                            <span class="help-block" style="color: red">

                                                     <strong>

                                                         {{ $errors->first('upload_apk') }}

                                                     </strong>

                                                </span>

                                        @endif

                                        </p>



                                       <p class="form-row form-row-wide">

                                        <label for="upload_apk_icon">Upload App Icon <span class="note-impor">*</span></label>

                                        <div class="fileUpload btn btn-warning">

                                            <span>Upload App Icon</span>

                                            <input type="file" class="upload" id="upload_icon" name="upload_apk_icon" onChange="AjaxUploadImage(this)" />

                                        </div>

                                            {{--<span id="msg1" style="color: red"></span><span id="msg_size1" style="color: red"></span>--}}

                                            <?php

                                            if (!empty($image->apk_icon) && $image->apk_icon != "" && file_exists($image->apk_icon)) {

                                            ?>

                                            <br><img id="DisplayImage" src="{{ url($image->apk_icon) }}" name="img" id="img" width="150" style="padding-bottom:5px" >

                                            <?php

                                            }else{

                                                echo '<br><img id="DisplayImage" src="" width="150" style="display: none;"/>';

                                            } ?>







                                        @if ($errors->has('upload_apk_icon'))

                                            <span class="help-block" style="color: red">

                                                     <strong>

                                                         {{ $errors->first('upload_apk_icon') }}

                                                     </strong>

                                            </span>

                                        @endif

                                        </p>



                                        <p class="form-row">

                                            <input type="submit" value="next" name="submit" class="button-submit" style="background-color: #ff9933">

                                        </p>



                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        <div class="block-html-full-width" style=" border-top: none;

    display: inline-block;

    margin-top: 70px;

    padding: 0px 0;

    width: 100%;"></div>

    </main>

@endsection



<script>



    function AjaxUploadImage(obj,id){



        var file = obj.files[0];

        var imagefile = file.type;



//        var name = $("#upload_icon")[0].files[0];

//        var name1 = name.name;

//        var size = name.size;

        //alert(size);



        var match = ["image/jpeg", "image/png", "image/jpg"];

        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))

        {

            $('#previewing'+URL).attr('src', 'noimage.png');

            alert("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");

            //$("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");

            return false;

        } else{

//            document.getElementById('msg1').innerHTML = name1;

//            if(size < 1024){

//                var s = size + " Bytes";

//                document.getElementById('msg_size1').innerHTML = ' ('+s+') ';

//            }

//            else if(size < 1048576){

//                var s1 = (size / 1024).toFixed(3) + " KB";

//                document.getElementById('msg_size1').innerHTML = ' ('+s1+') ';

//            }

//            else if(size < 1073741824){

//                var s2 = (size / 1048576).toFixed(3) + " MB";

//                document.getElementById('msg_size1').innerHTML = ' ('+s2+') ';

//            }

//            else{

//                var s3 = (bytes / 1073741824).toFixed(3) + " GB";

//                document.getElementById('msg_size1').innerHTML = ' ('+s3+') ';

//            }



            var reader = new FileReader();

            reader.onload = imageIsLoaded;

            reader.readAsDataURL(obj.files[0]);

        }

    }

    function imageIsLoaded(e) {



        $('#DisplayImage').css("display", "block");

        $('#DisplayImage').attr('src', e.target.result);

        $('#DisplayImage').attr('width', '150');



    };



    $('#image').fileinput({

        showUpload: false,

        showCaption: false,

        showPreview: false,

        showRemove: false,

        browseClass: "btn btn-primary btn-lg btn_new",

    });



    function AjaxUploadImage1(obj,id){

        var file = document.getElementById('upload').value;

        var name = $("#upload")[0].files[0];

        var name1 = name.name;

        var size = name.size;



        var ext = file.substr(file.lastIndexOf('.') + 1);

        if (!((ext == "apk")))

        {

            document.getElementById('msg').innerHTML = "<br><strong>Please Select valid .apk file type</strong>";

            return false;

        }

        else{

            document.getElementById('msg').innerHTML = name1;

            if(size < 1024){

                var s = size + " Bytes";

                document.getElementById('msg_size').innerHTML = ' ('+s+') ';

            }

            else if(size < 1048576){

                var s1 = (size / 1024).toFixed(3) + " KB";

                document.getElementById('msg_size').innerHTML = ' ('+s1+') ';

            }

            else if(size < 1073741824){

                var s2 = (size / 1048576).toFixed(3) + " MB";
                var max_size = (size / 1048576).toFixed(3);
                var MAX_UPLOAD_SIZE = 512;

                if(max_size < MAX_UPLOAD_SIZE)
                {
                    document.getElementById('msg_size').innerHTML = ' ('+s2+') ';
                }
                else{
                    document.getElementById('msg_size').innerHTML = "";
                    document.getElementById('myBar').innerHTML = "";
                    document.getElementById('msg').innerHTML = "<br><strong>Please Select .apk files whose size is less than " + MAX_UPLOAD_SIZE + " MB</strong>";
                    return false;
                }

            }

            else{

                var s3 = (bytes / 1073741824).toFixed(3) + " GB";
                var max_size1 = (bytes / 1073741824).toFixed(3);

                if(max_size1 < 2)
                {
                    document.getElementById('msg_size').innerHTML = ' ('+s3+') ';
                }
                else{
                    document.getElementById('msg_size').innerHTML = "";
                    document.getElementById('myBar').innerHTML = "";
                    document.getElementById('msg').innerHTML = "<br><strong>Please Select .apk files whose size is less than 2 MB</strong>";
                    return false;
                }

            }



            var elem = document.getElementById("myBar");

            var width = 10;

            var id = setInterval(frame, 10);

            function frame() {

                if (width >= 100) {

                    clearInterval(id);

                } else {

                    width++;

                    elem.style.width = width + '%';

                    elem.innerHTML = width * 1  + '%';

                }

            }



        }

    }



</script>