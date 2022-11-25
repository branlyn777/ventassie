@section("css")
<style>
    	.table-1 {
		width: 100%;/* Anchura de ejemplo */
		overflow: auto;
		}
		.table-1 table {
			border-collapse: separate;
			border-spacing: 0;
			border-left: 0.1px solid #ee761c;
			border-bottom: 0.1px solid #ee761c;
			width: 100%;
		}
		.table-1 table thead {
			position: sticky;
			top: 0;
			z-index: 10;
		}
		.table-1 table thead tr {
		background: #ee761c;
		color: white;
		}
		.table-1 table tbody tr:hover {
			background-color: #ffe77ba4;
		}
		.table-1 table td {
			border-top: 0.1px solid #ee761c;
			padding-left: 8px;
			padding-right: 8px;
			border-right: 0.1px solid #ee761c;
		}
</style>
@endsection
<div>
    <div class="row">

        <div class="col-12 col-sm-12 col-md-2 text-center">

        </div>

        <div class="col-12 col-sm-12 col-md-8 text-center">
            <h2><b>REPORTES MOVIMIENTOS GENERALES</b></h2>
        </div>

        <div class="col-12 col-sm-12 col-md-2">
            
        </div>

    </div>


    <div class="row">

        <div class="col-12 col-sm-6 col-md-3 text-center">
            <b>Seleccionar Sucursal</b>
            <div class="form-group">
                <select wire:model="sucursal_id" class="form-control">
                    @foreach($this->lista_sucursales as $s)
                    <option value="{{$s->id}}">{{$s->name}}</option>
                    @endforeach
                    <option value="Todos">Todas las Sucursales</option>
                </select>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 text-center">
            <b>Seleccionar Caja</b>
            <div class="form-group">
                <select wire:model="caja_id" class="form-control">
                    @foreach($this->lista_cajas as $c)
                    <option value="{{$c->id}}">{{$c->nombre}}</option>
                    @endforeach
                    <option value="Todos">Todas las Cajas</option>
                </select>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3 text-center">
            <b>Fecha Inicio</b>
            <div class="form-group">
                <input type="date" wire:model="dateFrom" class="form-control" >
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3 text-center">
            <b>Fecha Fin</b>
            <div class="form-group">
                <input type="date" wire:model="dateTo" class="form-control" >
            </div>
        </div>

    </div>

    <div class="table-1">
        <table>
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>FECHA</th>
                    <th>CODIGO</th>
                    <th>DETALLE</th>
                    <th>INGRESO</th>
                    <th>EGRESO</th>
                    <th>UTILIDAD</th>
                </tr>
            </thead>
            <tbody>
                {{-- Listando las Ventas --}}
                @foreach($lista_ventas as $v)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($v->fecha_creacion)->format('d/m/Y H:i') }}
                    </td>
                    <td class="text-center">
                        {{$v->codigo_venta}}
                    </td>
                    <td class="text-center">
                        Venta {{ucwords($v->nombre_cartera)}}
                    </td>
                    <td class="text-right">
                        {{ number_format($v->total_venta, 2, ",", ".")}}
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
