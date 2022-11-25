<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Sale;
use App\Models\Sucursal;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class ReporteMovimientoGeneral extends Component
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
                "c.nombre as nombre_cartera")
                ->where("cj.sucursal_id",$this->sucursal_id)
                ->whereBetween('sales.created_at',[ $this->dateFrom . ' 00:00:00',$this->dateTo . ' 23:59:59'])
                ->orderBy('sales.created_at', 'asc')
                ->get();




                $lista_servicios = "";
                $lista_ingresos = "";
                $lista_egresos = "";
            }
        }
        else
        {

        }

        
        


        return view('livewire.reportemovimientoresumen.reportemovimientogeneral', [
            'lista_ventas' => $lista_ventas,
            'lista_servicios' => $lista_servicios,
            'lista_ingresos' => $lista_ingresos,
            'lista_egresos' => $lista_egresos,

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
}
