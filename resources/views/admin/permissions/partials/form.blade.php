{{ csrf_field() }}
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-md-3 control-label">Name</label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="name" placeholder="Name"
               value="{{ $permission->name or old('name') }}">

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
    <label for="roles" class="col-md-3 control-label">Roles</label>
    <div class="col-md-8">
        <select name="roles[]" id="roles" class="form-control selectWoo"
                multiple="multiple">
            @foreach($roles as $key => $name)
                <option value="{{ $key }}" {{ (isset($permission) && $permission->roles->contains($key)) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>

        @if ($errors->has('roles'))
            <span class="help-block">
                 <strong>{{ $errors->first('roles') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-md-8 col-md-offset-3">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>