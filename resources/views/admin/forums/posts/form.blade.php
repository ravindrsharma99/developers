<div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="firstname">First Name <span class="text-red">*</span></label>
    <div class="col-sm-5">
        {!! Form::text('firstname', null, ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
        @if ($errors->has('firstname'))
            <span class="help-block">
                <strong>{{ $errors->first('firstname') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="lastname">Last Name <span class="text-red">*</span></label>
    <div class="col-sm-5">
        {!! Form::text('lastname', null, ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
        @if ($errors->has('lastname'))
            <span class="help-block">
                <strong>{{ $errors->first('lastname') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="email">Email <span class="text-red">*</span></label>

    <div class="col-sm-5">
        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
</div>


<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="inputPassword3">Password @if (!isset($appuser)) <span class="text-red">*</span> @else <span class="text-red">&nbsp;&nbsp;</span> @endif</label>
    <div class="col-sm-5">
        <input type="password" placeholder="Password" id="password" name="password" class="form-control" >
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="inputPassword3">Confirm Password @if (!isset($appuser)) <span class="text-red">*</span> @else <span class="text-red">&nbsp;&nbsp;</span> @endif</label>

    <div class="col-sm-5">
        <input type="password" placeholder="Confirm password" id="password-confirm" name="password_confirmation" class="form-control" >
        @if ($errors->has('password_confirmation'))
            <span class="help-block">
             <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="phone">Phone <span class="text-red">*</span></label>
    <div class="col-sm-5">
        {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Phone number']) !!}
        @if ($errors->has('phone'))
            <span class="help-block">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="image">Image <span class="text-red">*</span></label>
    <div class="col-sm-5">
        <div class="">
            {!! Form::file('image', ['class' => '', 'id'=> 'image', 'onChange'=>'AjaxUploadImage(this)']) !!}
        </div>
        <?php
            if (!empty($appuser->image) && $appuser->image != "" && file_exists($appuser->image)) {
        ?>
        <br><img id="DisplayImage" src="{{ url($appuser->image) }}" name="img" id="img" width="150" style="padding-bottom:5px" >
        <?php
        }else{
            echo '<br><img id="DisplayImage" src="" width="150" style="display: none;"/>';
        } ?>

        @if ($errors->has('image'))
            <span class="help-block">
                    <strong>{{ $errors->first('image') }}</strong>
                </span>
        @endif
    </div>
</div>


<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="address">Address <span class="text-red">&nbsp;&nbsp;</span></label>

    <div class="col-sm-5">
        {!! Form::textarea('address', null, ['class' => 'form-control', 'placeholder' => 'Address','rows'=>'5']) !!}
        @if ($errors->has('address'))
            <span class="help-block">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="role">Status <span class="text-red">*</span></label>

    <div class="col-sm-5">

        @foreach (\App\AppUser::$status as $key => $value)
            <label>
                {!! Form::radio('status', $key, null, ['class' => 'flat-red']) !!} <span style="margin-right: 10px">{{ $value }}</span>
            </label>
        @endforeach
        @if ($errors->has('status'))
            <span class="help-block">
             <strong>{{ $errors->first('status') }}</strong>
            </span>
        @endif
    </div>
</div>


<script>

    function AjaxUploadImage(obj,id){

        var file = obj.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))
        {
            $('#previewing'+URL).attr('src', 'noimage.png');
            alert("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
            //$("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
            return false;
        } else{
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

</script>