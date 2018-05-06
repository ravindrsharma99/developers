<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="firstname">Title <span class="text-red">*</span></label>
    <div class="col-sm-5">
        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
        @if ($errors->has('title'))
            <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('chatter_category_id') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="chatter_category_id">Category <span class="text-red">*</span></label>
    <div class="col-sm-5">
        {!! Form::select('chatter_category_id', $categories ,null, ['class' => 'form-control']) !!}
        @if ($errors->has('chatter_category_id'))
            <span class="help-block">
                <strong>{{ $errors->first('chatter_category_id') }}</strong>
            </span>
        @endif
    </div>
</div>
