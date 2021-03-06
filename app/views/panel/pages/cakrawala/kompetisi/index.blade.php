@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Cakrawala Kompetisi</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    {{ Table::striped_open(array('class' => 'table-hover')) }}
    {{ Table::headers('#', 'Lomba', '') }}
    <tbody>
    <?php 
        $i = 1; 
        $listlomba = array('Debat', 'IT Contest', 'LKTI')
    ?>
    @foreach($listlomba as $lomba)
        <tr>
            <td>{{ $i++ }}</td>            
            <td>{{ $lomba }}</td>
            
            <td class="right">
                {{ Button::primary_link(action('panel.cakrawala.kompetisi.tim.index', $lomba), Helper::fa('eye')) }}
            </td>
        </tr>
    @endforeach
    </tbody>
    {{ Table::close() }}
@stop