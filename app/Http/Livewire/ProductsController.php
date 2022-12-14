<?php

namespace App\Http\Livewire;

use App\Imports\ProductsImport;
use App\Imports\PruebaImport;
use App\Models\Category;
use App\Models\Marca;
use App\Models\Product;
use App\Models\Unidad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ProductsController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $nombre, $costo, $precio_venta,$cantidad_minima,$name,$descripcion,
    $codigo,$lote,$unidad,$industria,$caracteristicas,$status,$categoryid=null, $search,$estado,
     $image, $selected_id, $pageTitle, $componentName,$cate,$marca,$garantia,$stock,$stock_v
     ,$selected_categoria,$selected_sub,$nro=1,$sub,$change=[],$estados,$searchData=[],$data2;

    private $pagination = 100;
    public $selected_id2;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName ='Productos';
       
        $this->estados ='Activo';
   
        $this->cate='Elegir';
        
        
    }

    public function updatedSelectedCategoria()
    {
        
        array_push($this->change,$this->selected_categoria);
       
        if ($this->selected_sub!==null and count($this->change)>1) {
            $this->selected_sub=null;
           
        }
    }


    public function updatingSearch()
    {
        $this->resetPage();
        
    }

    public function updatingSelected_categoria()
    {
        $this->resetPage();
        $this->searchData=[];
        
    }
    public function updatingSelected_sub()
    {
        $this->resetPage();
        $this->searchData=[];
        
    }


    public function render()
    {
     /**sssssssss */
     
  
       if ($this->selected_categoria !== null ) {
          
        if ($this->selected_sub == null) {
            $prod = Product::join('categories as c', 'products.category_id','c.id')
            ->select('products.*', 'c.name as cate')
            ->where('products.status',$this->estados)
            ->where(function($query){
                $query->where('c.categoria_padre',$this->selected_categoria)
                      ->orWhere('c.id',$this->selected_categoria);
            })
            ->where(function($query){
                $query->where('products.nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('products.codigo', 'like', '%' . $this->search . '%')  
                        ->orWhere('products.marca', 'like', '%' . $this->search . '%')
                        ->orWhere('products.caracteristicas', 'like', '%' . $this->search . '%') 
                        ->orWhere('products.costo', 'like', '%' . $this->search . '%')
                        ->orWhere('products.precio_venta', 'like', '%' . $this->search . '%');
                          
            })
            ->orderBy('products.id', 'desc');
        }
        else{
           
            $prod = Product::join('categories as c', 'products.category_id','c.id')
            ->select('products.*', 'c.name as cate')
            ->where('products.status',$this->estados)
            ->where('c.id',$this->selected_sub)
            ->where(function($querys){
                $querys->where('products.nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('products.codigo', 'like', '%' . $this->search . '%')
                        ->orWhere('products.marca', 'like', '%' . $this->search . '%')
                        ->orWhere('products.caracteristicas', 'like', '%' . $this->search . '%') 
                        ->orWhere('products.costo', 'like', '%' . $this->search . '%')
                        ->orWhere('products.precio_venta', 'like', '%' . $this->search . '%');
            })
            
            ->orderBy('products.id', 'desc');
           
        }
        }
         elseif (strlen($this->search) > 0) {

        
        $prod = Product::join('categories as c', 'products.category_id','c.id')
        ->select('products.*', 'c.name as cate')
        ->where('products.status',$this->estados)
        ->where(function($querys){
            $querys->where('products.nombre', 'like', '%' . $this->search . '%')
            ->orWhere('products.codigo', 'like', '%' . $this->search . '%')
            ->orWhere('c.name', 'like', '%' . $this->search . '%')
            ->orWhere('products.marca', 'like', '%' . $this->search . '%')
            ->orWhere('products.caracteristicas', 'like', '%' . $this->search . '%') 
            ->orWhere('products.costo', 'like', '%' . $this->search . '%')
            ->orWhere('products.precio_venta', 'like', '%' . $this->search . '%');
        })
        
        
        ->orderBy('products.id', 'desc');
     }


        else {
          
                $prod = Product::join('categories as c', 'products.category_id','c.id')
                ->select('products.*', 'c.name as cate')
                ->where('products.status',$this->estados)
                ->orderBy('products.nombre', 'desc');}
            
        
        $this->sub= Category::select('categories.*')
        ->where('categories.categoria_padre',$this->selected_categoria)
        ->get();
        

        $ss = Category::select('categories.*')
        ->where('categories.categoria_padre',$this->selected_id2)->get();
     
        if (count($this->searchData)>0) {
            //dd($this->searchData);
            foreach ($this->searchData as $data) {
               $this->data2=$data;
                $prod =$prod->where(function($querys){
                    $querys->where('products.nombre', 'like', '%' . $this->data2 . '%')
                    ->orWhere('products.codigo', 'like', '%' . $this->data2 . '%')
                    ->orWhere('c.name', 'like', '%' . $this->data2 . '%')
                    ->orWhere('products.marca', 'like', '%' . $this->data2 . '%')
                    ->orWhere('products.caracteristicas', 'like', '%' . $this->data2 . '%') 
                    ->orWhere('products.costo', 'like', '%' . $this->data2 . '%')
                    ->orWhere('products.precio_venta', 'like', '%' . $this->data2 . '%');
                })
                
                
                ->orderBy('products.id', 'desc');;
            }
        }
      

        return view('livewire.products.component', [
            'data' => $prod->paginate($this->pagination),
            'categories'=>Category::where('categories.categoria_padre',0)->orderBy('name', 'asc')->get(),
            'unidades'=>Unidad::orderBy('nombre','asc')->get(),
            'marcas'=>Marca::select('nombre')->orderBy('nombre','asc')->get(),
            'subcat'=>$ss
        ])->extends('layouts.theme.app')->section('content');
    }
    public function Store()
    {
        if ($this->categoryid === null) 
        {
            $this->categoryid = $this->selected_id2;
        }
        $rules = [
            'nombre' => 'required|unique:products|min:5',
            'costo' => 'required',
            'codigo'=>'required|unique:products',
            'precio_venta' => 'required|gt:costo',
            'selected_id2' => 'required|not_in:Elegir'
        ];

        $messages = [
            'nombre.required' => 'Nombre del producto requerido',
            'nombre.unique' => 'Ya existe el nombre del producto',
            'nombre.min' => 'El nombre debe  contener al menos 5 caracteres',
            'costo.required' =>'El costo es requerido',
            'codigo.required' =>'El codigo es requerido',
            'precio_venta.required'=> 'El precio es requerido',
            'precio_venta.gt'=> 'El precio debe ser mayor o igual al costo',
            'selected_id2.required' => 'La categoria es requerida',
            'selected_id2.not_in' => 'Elegir un nombre de categoria diferente de Elegir'
        ];

        $this->validate($rules, $messages);

        $product = Product::create([
            'nombre' => $this->nombre,
            'costo' => $this->costo,
            'caracteristicas'=>$this->caracteristicas,
            'codigo'=>$this->codigo,
            'lote'=>$this->lote,
            'unidad'=>$this->unidad,
            'marca' => $this->marca,
            'garantia' => $this->garantia,
            'cantidad_minima' => $this->cantidad_minima,
            'industria' => $this->industria,
            'precio_venta' => $this->precio_venta,
            'category_id' => $this->categoryid
        ]);
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/images/productos/', $customFileName);
            $product->image = $customFileName;
            $product->save();
        }
        else{
            $product->image='noimage.jpg';
            $product->save();
        }
        
        $this->emit('product-added', 'Producto Registrado');
        $this->resetUI();
    }
    public function Edit(Product $product)
    {
        if($product->category->categoria_padre === 0)
        { $this->selected_id2 = $product->category_id;
          $this->categoryid = null;
        }
        else{
        $this->selected_id2 = $product->category->categoria_padre;
        $this->categoryid = $product->category_id;
        }
        $this->selected_id = $product->id;
        $this->costo = $product->costo;
        $this->nombre = $product->nombre;
        $this->precio_venta=$product->precio_venta;
        $this->caracteristicas=$product->caracteristicas;
        $this->barcode = $product->barcode;
        $this->lote = $product->lote;
        $this->unidad = $product->unidad;
        $this->marca = $product->marca;
        $this->garantia = $product->garantia;
        $this->industria = $product->industria;
        $this->cantidad_minima= $product->cantidad_minima;
        $this->codigo=$product->codigo;
        $this->estado=$product->status;
        $this->image = null;
        $this->emit('modal-show');
    }
    public function Update()
    {
        if ($this->categoryid === null) 
        {
            $this->categoryid = $this->selected_id2;
        }
        $rules = [
            'nombre' => "required|min:3|unique:products,nombre,{$this->selected_id}",
            'codigo'=>"required|min:6|unique:products,codigo,{$this->selected_id}",
            'costo' => 'required',
            'precio_venta' => 'required',
            'categoryid' => 'required|not_in:Elegir'
        ];
        $messages = [
            'nombre.required' => 'Nombre del producto requerido',
            'nombre.unique' => 'Ya existe el nombre del producto',
            'nombre.min' => 'El nombre debe  contener al menos 5 caracteres',
            'costo.required' =>'El costo es requerido',
            'precio_venta.required'=> 'El precio es requerido',
            'categoryid.required' => 'La categoria es requerida',
            'categoryid.not_in' => 'Elegir un nombre de categoria diferente de Elegir'
        ];
        $this->validate($rules, $messages);
        $product = Product::find($this->selected_id);
        $product->update([
            'nombre' => $this->nombre,
            'costo' => $this->costo,
            'caracteristicas'=>$this->caracteristicas,
            'codigo'=>$this->codigo,
            'lote'=>$this->lote,
            'unidad'=>$this->unidad,
            'marca' => $this->marca,
            'garantia' => $this->garantia,
            'cantidad_minima' => $this->cantidad_minima,
            'industria' => $this->industria,
            'precio_venta' => $this->precio_venta,
            'category_id' => $this->categoryid,
            'status'=>$this->estado
        ]);
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/productos', $customFileName);
            $imageTemp = $product->image;
            $product->image = $customFileName;
            $product->save();

            if ($imageTemp != null) {
                if (file_exists('storage/productos/' . $imageTemp)) {
                    unlink('storage/productos/' . $imageTemp);
                }
            }
        }
        $this->resetUI();
        $this->emit('product-updated', 'Producto Actualizado');
    }
    protected $listeners = ['deleteRow' => 'Destroy','deleteRowPermanently' => 'DestroyPermanently'];

    public function Destroy(Product $product)
    {
        $imageTemp = $product->image;
        $product->delete();

        if ($imageTemp != null) {
            if (file_exists('storage/productos/' . $imageTemp)) {
                unlink('storage/productos/' . $imageTemp);
            }
        }
        foreach ($product->destinos as $data) {
            $data->pivot->delete();
        }
        $this->resetUI();
        $this->emit('product-deleted', 'Producto Eliminado');
    }

    public function DestroyPermanently(Product $product)
    {
        $imageTemp = $product->image;
        $product->forceDelete();

        if ($imageTemp != null) {
            if (file_exists('storage/productos/' . $imageTemp)) {
                unlink('storage/productos/' . $imageTemp);
            }
        }
        $this->resetUI();
        $this->emit('product-deleted', 'Producto Eliminado');
    }

    public function resetUI()
    {
        $this->selected_id =null;
        $this->selected_id2 =null;
        $this->costo = '';
        $this->nombre = '';
        $this->precio_venta='';
        $this->caracteristicas='';
        $this->codigo ='';
        $this->estado ='Elegir';
        $this->lote = '';
        $this->unidad = 'Elegir';
        $this->marca = 'Elegir';
        $this->industria = '';
        $this->garantia = '';
        $this->cantidad_minima = '';
        $this->categoryid =null;
        $this->image = null;

        $this->resetValidation();//clear the error bag
    }

    public function overrideFilter(){
        array_push($this->searchData,$this->search);
    }

 

    public function GenerateCode(){
        
        $min=10000;
        $max= 99999;
        $this->codigo= Carbon::now()->format('ymd').mt_rand($min,$max);
    }

    public function StoreCategory(){

        $rules = ['name' => 'required|unique:categories|min:3'];
        $messages = [
            'name.required' => 'El nombre de la categor??a es requerido',
            'name.unique' => 'Ya existe el nombre de la categor??a',
            'name.min' => 'El nombre de la categor??a debe tener al menos 3 caracteres'
        ];
        $this->validate($rules, $messages);
            $category = Category::create([
                'name' => $this->name,
                'descripcion'=>$this->descripcion,
                'categoria_padre'=>0
            ]);
        
        $category->save();
        $this->resetCategory();
        $this->emit('cat-added', 'Categor??a Registrada');
    }

    public function resetCategory(){
            $this->name="";
            $this->descripcion="";
    }


    public function import(Request $request){
        
        $file = $request->file('import_file');

        Excel::import(new ProductsImport,$file);
       
        return redirect()->route('productos');
    }

}