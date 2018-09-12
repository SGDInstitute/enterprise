{{ csrf_field() }}
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-md-3 control-label">Name</label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="name" placeholder="Name"
               value="{{ $role->name ?? old('name') }}">

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('permissions') ? ' has-error' : '' }}">
    <label for="permissions" class="col-md-3 control-label">Permissions</label>
    <div class="col-md-8">
        <select name="permissions[]" id="permissions" class="form-control selectWoo"
                multiple="multiple">
            @foreach($permissions as $key => $name)
                <option value="{{ $key }}" {{ (isset($role) && $role->permissions->contains($key)) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>

        @if ($errors->has('permissions'))
            <span class="help-block">
                 <strong>{{ $errors->first('permissions') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-md-8 col-md-offset-3">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>