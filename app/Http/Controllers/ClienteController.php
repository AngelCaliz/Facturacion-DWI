<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ciudad;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /** LISTADO Y BÚSQUEDA (INDEX) */
    public function index(Request $request) {
        $busqueda = $request->input('busqueda');
        
        // Carga ambas relaciones (tipoDocumento y ciudad) para mostrarlas en la tabla
        $query = Cliente::with(['tipoDocumento', 'ciudad']); 

        if ($busqueda) {
            // Busca por documento, nombre o apellido
            $query->where('Documento', 'LIKE', "%{$busqueda}%")
                  ->orWhere('Nombres', 'LIKE', "%{$busqueda}%")
                  ->orWhere('Apellidos', 'LIKE', "%{$busqueda}%");
        }
        
        // Usamos paginate para manejar grandes volúmenes de datos
        $clientes = $query->paginate(10); 

        return view('clientes.index', compact('clientes', 'busqueda'));
    }

    /** FORMULARIO DE CREACIÓN (CREATE) */
    public function create() {
        $ciudades = Ciudad::all();
        $tiposDoc = TipoDocumento::all();
        return view('clientes.create', compact('ciudades', 'tiposDoc'));
    }

    /** GUARDAR NUEVO (STORE) */
    public function store(Request $request) {
        // VALIDACIONES
        $request->validate([
            'Documento' => 'required|string|unique:clientes,Documento|max:15',
            'cod_tipo_documento' => 'required|exists:tipo_documentos,id_tipo_documento', // Asegúrate que la tabla exista
            'Nombres' => 'required|string|max:30',
            'Apellidos' => 'required|string|max:30',
            'Direccion' => 'required|string|max:50',
            'cod_ciudad' => 'required|exists:ciudades,Codigo_ciudad', // Asegúrate que la tabla exista
            'Telefono' => 'required|string|max:20',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
    }

    /** MOSTRAR DETALLE (SHOW) */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /** FORMULARIO DE EDICIÓN (EDIT) */
    // Si la clave primaria del modelo es Documento, Laravel lo busca automáticamente aquí
    public function edit(Cliente $cliente)
    {
        $ciudades = Ciudad::all();
        $tiposDoc = TipoDocumento::all();
        return view('clientes.edit', compact('cliente', 'ciudades', 'tiposDoc'));
    }

    /** ACTUALIZAR (UPDATE) */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'cod_tipo_documento' => 'required|exists:tipo_documentos,id_tipo_documento',
            'Nombres' => 'required|string|max:30',
            'Apellidos' => 'required|string|max:30',
            'Direccion' => 'required|string|max:50',
            'cod_ciudad' => 'required|exists:ciudades,Codigo_ciudad',
            'Telefono' => 'required|string|max:20',
        ]);

        // Usamos except() para evitar actualizar la clave primaria (Documento)
        $cliente->update($request->except('Documento')); 
        
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    /** ELIMINAR (DESTROY) */
    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();
            return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
        } catch (\Exception $e) {
            // Manejo de error si existen facturas asociadas (Integridad Referencial)
            return redirect()->route('clientes.index')->with('error', 'No se puede eliminar el cliente porque tiene facturas asociadas.');
        }
    }
}