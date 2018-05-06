<div class="form-group">
    <label class="col-sm-2 control-label" for="firstname">User</label>
    <div class="col-sm-5">
        <input class="form-control" type="text" readonly value="{{$comment->user->getTitle()}}">
    </div>
</div>

@if($comment->user && $comment->user->image)
<div class="form-group">
    <label class="col-sm-2 control-label">User</label>
    <div class="col-sm-5">
        <img style="with:64px;" src="{{$comment->user->getImage()}}" />
    </div>
</div>
@endif

<div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="comment">Comment <span class="text-red">*</span></label>

    <div class="col-sm-5">
        {!! Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => 'Comment','rows'=>'5']) !!}
        @if ($errors->has('comment'))
            <span class="help-block">
                <strong>{{ $errors->first('comment') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('rating') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="rating">Rating <span class="text-red">*</span></label>
    <div class="col-sm-5">
        {!! Form::text('rating', null, ['class' => 'form-control', 'placeholder' => 'Rating']) !!}
        @if ($errors->has('rating'))
            <span class="help-block">
                <strong>{{ $errors->first('rating') }}</strong>
            </span>
        @endif
    </div>
</div>