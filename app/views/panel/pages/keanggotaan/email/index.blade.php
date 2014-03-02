@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ $anggota->nama }}</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.keanggotaan.email.create', $anggota->id_anggota), Helper::fa('plus').' Tambah E-Mail') }}
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Anggota' => action('panel.keanggotaan.index'), $anggota->nama))
    }}
    
    @include('panel.pages.keanggotaan.tabanggota', array('anggota' => $anggota))

    @include('includes.alert')

    @if($listemail->count())
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        {{ Table::headers('#', 'E-Mail', '') }}
        <tbody>
        <?php $i = 1; ?>
        @foreach($listemail as $email)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $email->email }}</td>
                <td class="right">
                    {{ Former::inline_open()->route('panel.keanggotaan.email.destroy', array($anggota->id_anggota, $email->kd_email))->class('confirm-delete')->data_confirm('email') }}
                        {{ Button::primary_link(action('panel.keanggotaan.email.edit', array($anggota->id_anggota, $email->kd_email)), Helper::fa('pencil')) }}
                        {{ Button::danger_submit(Helper::fa('trash-o'))}}
                    {{ Former::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
        {{ Table::close() }}
    @else
          <div class="big-title center">Tidak ada e-mail</div>
    @endif
@stop