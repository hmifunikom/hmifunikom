@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Daftar User</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.user.create'), Helper::fa('plus').' Tambah user') }}
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    @include('includes.alert')

    {{ Table::striped_open(array('class' => 'table-hover')) }}
    {{ Table::headers('#', 'Username', 'Email', '') }}
    <tbody>
    <?php $i = $listuser->getFrom(); ?>
    @foreach($listuser as $user)
        <tr>
            <td>{{ $i++ }}</td>            
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td class="right">
                {{ Former::inline_open()->route('panel.user.destroy', $user->id_user)->class('confirm-delete')->data_confirm('user') }}
                    {{ Button::primary_link(action('panel.user.show', $user->id_user), Helper::fa('eye')) }}
                    {{ Button::link(action('panel.user.edit', $user->id_user), Helper::fa('pencil')) }}
                    {{ Button::danger_submit(Helper::fa('trash-o'))}}
                {{ Former::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
    {{ Table::close() }}

    {{ $listuser->links() }}
@stop