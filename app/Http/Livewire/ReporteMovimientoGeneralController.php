<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Movimiento;
use App\Models\Sale;
use App\Models\Service;
use App\Models\Sucursal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReporteMovimientoGeneralController extends Component
{
    //Guarda el id de la sucursal, Caja
    public $sucursal_id, $caja_id;
    //Guarda la lista de sucursales y Cajas
    public $lista_sucursales, $lista_cajas;
    public $dateFrom, $dateTo;

    public function mount()
    {
        $this->lista_sucursales = Sucursal::all();
        $this->sucursal_id = $this->idsucursal();
        $this->caja_id = "Todos";
        $this->dateFrom = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
    }
    public function render()
    {
        //Cambiando la lista de cajas dependiendo de la variable $Sucursal_id
        if($this->sucursal_id != "Todos")
        {
            $this->lista_cajas = Caja::where("cajas.sucursal_id",$this->sucursal_id)->where("cajas.id","<>",1)->get();
        }
        else
        {
            $this->lista_cajas = Caja::where("cajas.id","<>",1)->get();
        }

        
        if($this->sucursal_id != "Todos")
        {
            if($this->caja_id == "Todos")
            {
                $lista_ventas = Sale::join("carteras as c","c.id","sales.cartera_id")
                ->join("cajas as cj","cj.id","c.caja_id")
                ->select("sales.id as codigo_venta","sales.created_at as fecha_creacion","sales.total as total_venta",
                "c.nombre as nombre_cartera", DB::raw('0 as utilidad_venta'))
                ->where("sales.status","PAID")
                ->where("cj.sucursal_id",$this->sucursal_id)
                ->whereBetween('sales.created_at',[ $this->dateFrom . ' 00:00:00',$this->dateTo . ' 23:59:59'])
                ->orderBy('sales.created_at', 'asc')
                ->get();

                $lista_servicios = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                ->join('movimientos as m', 'm.id', 'ms.movimiento_id')
                ->join('cartera_movs as cm', 'cm.movimiento_id', 'm.id')
                ->join('carteras as c', 'c.id', 'cm.cartera_id')
                ->join('cajas as cj', 'cj.id', 'c.caja_id')
                ->select("services.order_service_id as codigo_servicio","m.created_at as fecha_creacion","m.import as total_servicio",
                "c.nombre as nombre_cartera","services.costo as costo_servicio", DB::raw('0 as utilidad_servicio'))
                ->where('cm.type', 'INGRESO')
                ->where('cm.tipoDeMovimiento', 'SERVICIOS')
                ->where('m.status', 'ACTIVO')
                ->where('m.type', 'ENTREGADO')
                ->where('cj.sucursal_id', $this->sucursal_id)
                ->whereBetween('m.created_at',[ $this->dateFrom . ' 00:00:00',$this->dateTo . ' 23:59:59'])
                ->orderBy('m.created_at', 'asc')
                ->get();







                $lista_ingresos = Movimiento::join('cartera_movs as cm', 'cm.movimiento_id', 'movimientos.id')
                ->join('carteras as c', 'c.id', 'cm.cartera_id')
                ->join('cajas as cj', 'cj.id', 'c.caja_id')
                ->select("c.nombre as nombre_cartera","movimientos.created_at as fecha_creacion","movimientos.import as total_ingreso")
                ->where('movimientos.status', 'ACTIVO')
                ->where('cm.type', 'INGRESO')
                ->where('cm.comentario','<>', 'RECAUDO DEL DIA')
                ->where('cm.tipoDeMovimiento' , 'EGRESO/INGRESO')
                ->where('cj.sucursal_id', $this->sucursal_id)
                ->whereBetween('movimientos.created_at',[ $this->dateFrom . ' 00:00:00',$this->dateTo . ' 23:59:59'])
                ->orderBy('movimientos.created_at', 'asc')
                ->get();



                $lista_egresos = Movimiento::join('cartera_movs as cm', 'cm.movimiento_id', 'movimientos.id')
                ->join('carteras as c', 'c.id', 'cm.cartera_id')
                ->join('cajas as cj', 'cj.id', 'c.caja_id')
                ->select("c.nombre as nombre_cartera","movimientos.created_at as fecha_creacion","movimientos.import as total_egreso")
                ->where('movimientos.status', 'ACTIVO')
                ->where('cm.type', 'EGRESO')
                ->where('cm.comentario','<>', 'RECAUDO DEL DIA')
                ->where('cm.tipoDeMovimiento' , 'EGRESO/INGRESO')
                ->where('cj.sucursal_id', $this->sucursal_id)
                ->whereBetween('movimientos.created_at',[ $this->dateFrom . ' 00:00:00',$this->dateTo . ' 23:59:59'])
                ->orderBy('movimientos.created_at', 'asc')
                ->get();



            }
        }
        else
        {

        }

        $total_ingresos = 0;
        $total_egresos = 0;




        //Obteniendo la utilidad de Ventas y total ingresos
        foreach($lista_ventas as $v)
        {
            $v->utilidad_venta = $this->utilidadventa($v->codigo_venta);
            $total_ingresos = $total_ingresos + $v->total_venta;
        }
        //Obteniendo la utilidad de Servicios y total ingresos
        foreach($lista_servicios as $s)
        {
            $s->utilidad_servicio = $s->total_servicio - $s->costo_servicio;
            $total_ingresos = $total_ingresos + $s->total_servicio;
        }

        //Obteniendo la utilidad de Servicios y total ingresos
        foreach($lista_ingresos as $i)
        {
            $total_ingresos = $total_ingresos + $i->total_ingreso;
        }


        //Obteniendo el total egresos
        foreach($lista_egresos as $e)
        {
            $total_egresos = $total_egresos + $e->total_egreso;
        }



        
        


        return view('livewire.reportemovimientoresumen.reportemovimientogeneral', [
            'lista_ventas' => $lista_ventas,
            'lista_servicios' => $lista_servicios,
            'lista_ingresos' => $lista_ingresos,
            'lista_egresos' => $lista_egresos,
            'total_ingresos' => $total_ingresos,
            'total_egresos' => $total_egresos

        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    //Obtener el Id de la Sucursal donde esta el Usuario
    public function idsucursal()
    {
        $idsucursal = User::join("sucursal_users as su","su.user_id","users.id")
        ->select("su.sucursal_id as id","users.name as n")
        ->where("users.id",Auth()->user()->id)
        ->where("su.estado","ACTIVO")
        ->get()
        ->first();
        return $idsucursal->id;
    }
    //Recibe el id de la venta y devuelve su utilidad
    public function utilidadventa($idventa)
    {
        $utilidadventa = Sale::join('sale_details as sd', 'sd.sale_id', 'sales.id')
        ->join('products as p', 'p.id', 'sd.product_id')
        ->select('sd.quantity as cantidad','sd.price as precio','p.costo as costoproducto')
        ->where('sales.id', $idventa)
        ->get();

        $utilidad = 0;

        foreach ($utilidadventa as $item)
        {
            $utilidad = $utilidad + ($item->cantidad * $item->precio) - ($item->cantidad * $item->costoproducto);
        }


        return $utilidad;
    }
}
