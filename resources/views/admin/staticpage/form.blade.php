<div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
    <div class="col-sm-12">
        {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Content','rows'=>'10','cols'=>'80','id'=>'editor1']) !!}
        @if ($errors->has('content'))
            <span class="help-block">
                <strong>{{ $errors->first('content') }}</strong>
            </span>
        @endif
    </div>
</div>


<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor1');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
</script>
