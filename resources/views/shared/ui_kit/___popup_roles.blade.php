@if ( Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_ADMIN') && isset($roles) )
    <div class="app-search roles-position-pagination">
        <div class="btn-group">
            <button class="btn btn-xs btn-info ml-2 dropdown-toggle "
                    type="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
            >
                Roles
            </button>
            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-animated ">
                @foreach($roles as $role)
                    <li class="text-left w-30vh text-darkred">
                        <div class=" ml-1 w-100 ">
                            <div class="form-group w-75 float-left">
                                <div class="custom-control custom-checkbox">
                                    <input name="roles[]"
                                           type="checkbox"
                                           class="custom-control-input"
                                           id="role_{{ $role->id }}"
                                           value="{{ $role->id }}"
                                            {{ $checkedRoles->contains($role->id) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="role_{{ $role->id }}">{{ $role->name}}</label>
                                </div>
                            </div>
                            <div class="badge badge-light float-right mr-2">{{ $role->users()->count()>0?$role->users()->count():'' }}</div>
                        </div>
                    </li>
                @endforeach

            </ul>

        </div>
    </div>
@endif
