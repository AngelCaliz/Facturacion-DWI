<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\TipoArticulo; 
use App\Models\Proveedor; 
use Illuminate\Http\Request;
use Carbon\Carbon; 

class ArticuloController extends Controller
{
    /** LISTADO Y BÚSQUEDA (INDEX) */
    public function index(Request $request)
    {
        $busqueda = $request->input('busqueda');
        
        $query = Articulo::with(['tipoArticulo', 'proveedor']);

        if ($busqueda) {
            $query->where('id_articulo', 'LIKE', "%{$busqueda}%")
                  ->orWhere('descripcion', 'LIKE', "%{$busqueda}%");
        }

        $articulos = $query->paginate(10); 
        
        return view('articulos.index', compact('articulos', 'busqueda'));
    }

    /** FORMULARIO DE CREACIÓN (CREATE) - ¡CORREGIDO! */
    public function create()
    {
        // Se carga la variable como $tipos (para coincidir con el nombre que espera la vista)
        $tipos = TipoArticulo::all(); 
        $proveedores = Proveedor::all(); 
        
        return view('articulos.create', compact('tipos', 'proveedores'));
    }

    /** GUARDAR NUEVO (STORE) */
    public function store(Request $request)
    {
        $request->validate([
            'id_articulo' => 'required|integer|unique:articulos,id_articulo',
            'descripcion' => 'required|string|max:30',
            'precio_costo' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0|gt:precio_costo',
            'stock' => 'required|integer|min:0',
            'cod_tipo_articulo' => 'required|exists:tipo_articulos,id_tipoarticulo', 
            'cod_proveedor' => 'required|exists:proveedores,No_documento', 
        ]);
        
        $data = $request->all();
        $data['fecha_ingreso'] = Carbon::now()->format('Y-m-d'); 

        Articulo::create($data); 

        return redirect()->route('articulos.index')->with('success', 'Artículo registrado exitosamente.');
    }

    /** VER DETALLE (SHOW) */
    public function show(Articulo $articulo)
    {
        $articulo->load('tipoArticulo', 'proveedor');
        return view('articulos.show', compact('articulo'));
    }

    /** FORMULARIO DE EDICIÓN (EDIT) */
    public function edit(Articulo $articulo)
    {
        $tipos = TipoArticulo::all(); // Usar $tipos si se va a usar ese nombre en la vista
        $proveedores = Proveedor::all();
        return view('articulos.edit', compact('articulo', 'tipos', 'proveedores'));
    }

    /** ACTUALIZAR (UPDATE) */
    public function update(Request $request, Articulo $articulo)
    {
        $request->validate([
            'descripcion' => 'required|string|max:30',
            'precio_costo' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0|gt:precio_costo',
            'stock' => 'required|integer|min:0',
            'cod_tipo_articulo' => 'required|exists:tipo_articulos,id_tipoarticulo',
            'cod_proveedor' => 'required|exists:proveedores,No_documento',
        ]);

        $articulo->update($request->except(['id_articulo', 'fecha_ingreso'])); 
        
        return redirect()->route('articulos.index')->with('success', 'Artículo actualizado exitosamente.');
    }

    /** ELIMINAR (DESTROY) */
    public function destroy(Articulo $articulo)
    {
        try {
            $articulo->delete();
            return redirect()->route('articulos.index')->with('success', 'Artículo eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('articulos.index')->with('error', 'No se puede eliminar el artículo porque está asociado a otro registro.');
        }
    }
}