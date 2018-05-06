@extends('website.layouts.app')

@section('content')

    <style>
        .form-content .btn-search{padding: 14.5px 25px;}
        .footer .btn.subscribe{padding: 12px 12px;}
        .footer-follow li a{padding-top: 8px;}
        .s{height: 220px;margin: 10px;overflow: hidden;padding: 0;position: relative;width: 220px;}

    </style>

    <main class="site-main">
            <div class="container-inner">
                <div class="tab-shopping">
                    <div class="tab-shoppping-cart">
                        @include('website.sidemenu')
                        <div class="tab-container" style="padding-top: 0px;">
                            <div id="tab-1" class="tab-panel active">
                                <section class="ai06-cart-step">
                                    <ul>
                                        <li class="active"><a href="{{url('step1/'.$step3_app->id)}}"><span class="cp-img-04">UPLOAD APK FILE</span></a></li>
                                        <li class="active"><a href="{{url('step2/'.$step3_app->id)}}"><span class="cp-img-04">APP DETAILS</span></a></li>
                                        <li class="active"><a href="{{url('step3/'.$step3_app->id)}}"><span class="cp-img-04">APP SCREENSHOTS</span></a></li>

                                        @if($step3_app['step'] == '3' || $step3_app['step'] == '4')
                                            <li class="active"><a href="{{url('step4/'.$step3_app->id)}}"><span class="cp-img-04">APP CONFIRMED</span></a></li>
                                        @else
                                            <li class="active"><a href="javascript:;"><span class="cp-img-04">APP CONFIRMED</span></a></li>
                                        @endif


                                        <div class="clearfix"></div>
                                    </ul>
                                </section><!--ai06-cart-step-->

                                <div class="col-md-12">

                                    <form class="step3" id="step3" method="post" action="{{url('step3/'.$step3_app->id)}}" enctype="multipart/form-data">

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

                                        <label>Select Screenshots <span class="note-impor">*</span></label>

                                        <div class="fileUpload btn btn-warning">

                                            <span>Upload Screenshots</span>

                                            <input type="file" class="upload" name="image" id="image" onchange="preview_images(event)"/>

                                        </div>


                                        <input type="hidden" name="cnt" id="cnt">
                                        <input type="hidden" name="hiddid" id="hiddid" value="0">
                                        <input type="hidden" name="app_id" value="{{$step3_app->id}}">

                                        @if ($errors->has('image'))
                                            <span class="help-block" style="color: red">
                                                    <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                        @endif

                                        @if(isset($image))
                                            <br>
                                        @foreach($image as $multi)
                                                <div class='thumb-inner s col-md-2' style='background-image: url({{ url($multi['image']) }});background-color: rgba(103, 103, 103, 0.05);background-size: contain;background-repeat: no-repeat;background-position: center;'><a href="{{url('step3/'.$multi['id'].'/destroy')}}" style="color: red; font-size: 12px; margin: 0 5px; font-weight: bold;float: right !important;" data-toggle="tooltip" title="Remove" data-trigger="hover">X</a></div>
                                        @endforeach
                                        @endif

                                        <div class="row" id="image_preview"></div>
                                        <p class="form-row">
                                            <input type="submit" value="next" name="submit" class="button-submit" style="background-color: #ff9933;margin-top: 0px !important;" onclick="counter_zero()">
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


<script src="{{ URL::asset('assets/plugins/jQuery/jQuery-2.2.0.min.js')}}"></script>

<script>
    function counter_zero() {
        document.getElementById("cnt").value = 0;
    }

    function preview_images(event)
    {
//        if(document.getElementsByName('img123') != null){
//            $('#image_preview').empty();
//        }

        var total_file=document.getElementById("image").files.length;
        var token=document.getElementById("token").value;
        document.getElementById("cnt").value=total_file;
        var img_val = document.getElementById("image").value;


        var file = document.getElementById('image').value;
        var ext = file.substr(file.lastIndexOf('.') + 1);
        if (!((ext == "png" || ext == "jpg" || ext == "jpeg")))
        {
            return false;
        }
        else {
            for(var i=0;i<total_file;i++)
            {
                var getImagePath = URL.createObjectURL(event.target.files[i]);
                var hiid = document.getElementById('hiddid').value;
                $('#image_preview').append("<div class='thumb-inner s col-md-2' style='background-image: url("+getImagePath+");margin-left: 25px;background-size: contain;background-repeat: no-repeat;background-color: rgba(103, 103, 103, 0.05);background-position: center;'><a id='ss"+hiid+"' style='color: red; font-size: 12px; margin: 0 5px; font-weight: bold;float: right !important;' data-toggle='tooltip' title='Remove' data-trigger='hover'>X</a></div>");
            }
        }



    }

    function imageIsLoaded(e) {
            var total_file=document.getElementById("image").files.length;
            document.getElementById("cnt").value=total_file;
            var img_val = document.getElementById("image").value;

            for(var i=1;i<total_file+1;i++) {
                alert(e.target.result);
                $('#DisplayImage'+i).css("display", "block");
                $('#DisplayImage'+i).attr('src', URL.createObjectURL(event.target.files[i]));
                $('#DisplayImage'+i).attr('width', '150');
            }

    };


    jQuery(document).ready(function(){
        jQuery('input[type=file]').change(function () {
            var val = $(this).val().split(".").pop().toLowerCase();
            if(jQuery.inArray(val, ["png","jpg",'jpeg']) == -1) {
                jQuery(this).val('');
                jQuery(this).focus();
                alert("Upload png,jpg,jpef images only");
                return false;
            }
            else {
                var total_file=document.getElementById("image").files.length;
               if(total_file == 1){
                   jQuery('#step3').submit();
               }
                else {
                   return false;
               }
            }
        });

        /*Update Image From submit*/

        jQuery("form#step3").submit(function(){

            var total_file=document.getElementById("cnt").value;
            if(total_file == 1) {
                var formData = new FormData(this);

                jQuery.ajax({
                    url: '{{url('screenshot')}}',
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (data) {
                        var hiid = document.getElementById('hiddid').value;
                        $("#ss"+hiid).attr("href", data+'/destroy');
                        $('#hiddid').attr('value',data);
                      //  location.reload();
                    },
//                error: function () {
//                    alert("unable to change image");
//                },
                    cache: false,
                    contentType: false,
                    processData: false
                });

                return false;
            }
        });
    });

</script>