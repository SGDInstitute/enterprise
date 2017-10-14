{{ csrf_field() }}

<div class="form-group{{ $errors->has('users') ? ' has-error' : '' }}">
    <label for="users" class="col-md-3 control-label">Users</label>
    <div class="col-md-8">
        @if(isset($user))
            <p class="form-control-static">{{ $user->name }} ({{ $user->email }})</p>
        @else
            <select name="users[]" id="users" class="form-control selectWoo" multiple="multiple">
                @foreach($users as $key => $u)
                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                @endforeach
            </select>
        @endif

        @if ($errors->has('users'))
            <span class="help-block">
                <strong>{{ $errors->first('users') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
    <label for="roles" class="col-md-3 control-label">Roles</label>
    <div class="col-md-8">
        <select name="roles[]" id="roles" class="form-control selectWoo" multiple="multiple">
            @foreach($roles as $key => $name)
                <option value="{{ $key }}" {{ (isset($user) && $user->roles->contains('name', $name)) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>

        @if ($errors->has('roles'))
            <span class="help-block">
                <strong>{{ $errors->first('roles') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('permissions') ? ' has-error' : '' }}">
    <label for="permissions" class="col-md-3 control-label">Permissions</label>
    <div class="col-md-8">
        <select name="permissions[]" id="permissions" class="form-control selectWoo" multiple="multiple">
            @foreach($permissions as $key => $name)
                <option value="{{ $key }}" {{ (isset($user) && $user->permissions->contains('name', $name)) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>

        @if ($errors->has('permissions'))
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
