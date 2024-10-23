            <table id="tblCat" class="table table-bordered table-striped dt-responsive dataTable nowrap" role="grid" aria-describedby="datatable-buttons_info"  width="100%" >
                <thead>
                    <tr role="row">
                        <th class="sorting_asc" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
                        <th class="sorting">Username</th>
                        <th class="sorting">Nombre Completo</th>
                        <th class="sorting">CURP</th>
                        <th class="sorting">Roles</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td >{{$item->id}}</td>
                        <td>{{$item->username}}</td>
                        <td>{{($item->FullName)}}</td>
                        <td>{{($item->curp)}}</td>
                        <td>
                            @foreach($item->roles as $role)
                                <span class="badge badge-primary">{{$role->name ?? 'none'}}</span>
                                @if($role->name=="ENLACE")
                                    <b class="{{ isset($item->dependencias->first()->abreviatura) ? '' : 'badge badge-danger' }}">
                                        {{$item->dependencias->first()->abreviatura ?? 'none'}}
                                    </b>
                                @endif
                            @endforeach
                        </td>
                        <td class="table-action w-100">
                            <div class="button-list w-100">
                                @include('shared.ui_kit.__edit_item')
                                @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                                    @include('shared.ui_kit.__remove_item')
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
