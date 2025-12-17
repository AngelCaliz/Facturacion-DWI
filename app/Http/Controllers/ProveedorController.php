<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\Ciudad;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /** LISTADO (INDEX) */
    public function index(Request $request) {
        $busqueda = $request->get('busqueda');
        
        $query = Proveedor::with(['tipoDocumento', 'ciudad']); 

        if ($busqueda) {
            $query->where('No_documento', 'like', "%{$busqueda}%")
                  ->orWhere('Nombre', 'like', "%{$busqueda}%")
                  ->orWhere('Nombre_comercial', 'like', "%{$busqueda}%");
        }

        $proveedores = $query->paginate(10); 
        
        return view('proveedores.index', compact('proveedores', 'busqueda'));
    }

    /** FORMULARIO DE CREACIÓN (CREATE) */
    public function create() {
        $ciudades = Ciudad::all();
        $tiposDoc = TipoDocumento::all();
        return view('proveedores.create', compact('ciudades', 'tiposDoc'));
    }

    /** GUARDAR NUEVO (STORE) */
    public function store(Request $request) {
        // VALIDACIONES CORREGIDAS: 'tipo_documentos' y 'ciudades'
        $request->validate([
            'No_documento' => 'required|string|unique:proveedores,No_documento|max:20',
            'cod_tipo_documento' => 'required|exists:tipo_documentos,id_tipo_documento', 
            'Nombre' => 'required|string|max:20',
            'Apellido' => 'nullable|string|max:20', 
            'Nombre_comercial' => 'required|string|max:20',
            'direccion' => 'required|string|max:20',
            'cod_ciudad' => 'required|exists:ciudades,Codigo_ciudad', 
            'Telefono' => 'required|string|max:15', 
        ]);

        Proveedor::create($request->all());
        
        return redirect()->route('proveedores.index')->with('success', 'Proveedor registrado exitosamente.');
    }

    /** VER DETALLE (SHOW) */
    public function show(Proveedor $proveedor)
    {
        $proveedor->load('tipoDocumento', 'ciudad');
        return view('proveedores.show', compact('proveedor'));
    }

    /** FORMULARIO DE EDICIÓN (EDIT) */
    public function edit(Proveedor $proveedor)
    {
        $ciudades = Ciudad::all();
        $tiposDoc = TipoDocumento::all();

        return view('proveedores.edit', compact('proveedor', 'ciudades', 'tiposDoc'));
    }

    /** ACTUALIZAR (UPDATE) */
    public function update(Request $request, Proveedor $proveedor)
    {
        // VALIDACIONES CORREGIDAS: 'tipo_documentos' y 'ciudades'
        $request->validate([
            'cod_tipo_documento' => 'required|exists:tipo_documentos,id_tipo_documento',
            'Nombre' => 'required|string|max:20',
            'Apellido' => 'nullable|string|max:20',
            'Nombre_comercial' => 'required|string|max:20',
            'direccion' => 'required|string|max:20',
            'cod_ciudad' => 'required|exists:ciudades,Codigo_ciudad', 
            'Telefono' => 'required|string|max:15',
        ]);

        $proveedor->update($request->except('No_documento')); 
        
        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    /** ELIMINAR (DESTROY) */
    public function destroy(Proveedor $proveedor)
    {
        try {
            $proveedor->delete();
            return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('proveedores.index')->with('error', 'No se puede eliminar el proveedor porque tiene artículos asociados.');
        }
    }
}