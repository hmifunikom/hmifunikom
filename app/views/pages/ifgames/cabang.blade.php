@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.ifgames'))

@section('content')
    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Daftar Cabang</h2>
                </div>
            </div>

            {{
                Button::lg_link(URL::route('ifgames.pendaftaran'), '&laquo Kembali')
            }}

            @include('includes.alert')

            <div class="row cabang">
                <div style="background:#b71524;" class="col-xs-12">
                    <a href="{{ URL::route('ifgames.create', 'futsal') }}">
                        <span class="big-title">Futsal (Sisa {{ $cabang::where('slug', '=', 'futsal')->get()->first()->sisa_kuota() }})</span>
                        {{ Helper::fa('chevron-right') }}
                    </a>
                    <div class="clearfix"></div>
                </div>
                <div style="background:#721f6d;" class="col-xs-12">
                    <a href="{{ URL::route('ifgames.create', 'basket') }}">
                        <span class="big-title">Basket 3 on 3 (Sisa {{ $cabang::where('slug', '=', 'basket')->get()->first()->sisa_kuota() }})</span>
                        {{ Helper::fa('chevron-right') }}
                    </a>
                    <div class="clearfix"></div>
                </div>
                <div style="background:#c0bf05;" class="col-xs-12">
                    <a href="{{ URL::route('ifgames.create', 'bulu-tangkis-single') }}">
                        <span class="big-title">Bulu Tangkis Single (Sisa {{ $cabang::where('slug', '=', 'bulu-tangkis-single')->get()->first()->sisa_kuota() }})</span>
                        {{ Helper::fa('chevron-right') }}
                    </a>
                    <div class="clearfix"></div>
                </div>
                <div style="background:#c0bf05;" class="col-xs-12">
                    <a href="{{ URL::route('ifgames.create', 'bulu-tangkis-double') }}">
                        <span class="big-title">Bulu Tangkis Double (Sisa {{ $cabang::where('slug', '=', 'bulu-tangkis-double')->get()->first()->sisa_kuota() }})</span>
                        {{ Helper::fa('chevron-right') }}
                    </a>
                    <div class="clearfix"></div>
                </div>
                <div style="background:#055997;" class="col-xs-12">
                    <a href="{{ URL::route('ifgames.create', 'catur') }}">
                        <span class="big-title">Catur (Sisa {{ $cabang::where('slug', '=', 'catur')->get()->first()->sisa_kuota() }})</span>
                        {{ Helper::fa('chevron-right') }}
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>            
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop