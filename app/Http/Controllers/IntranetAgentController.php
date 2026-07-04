<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;
use Illuminate\Support\Facades\DB;

class IntranetAgentController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini) { $this->gemini = $gemini; }

    public function preguntar(Request $request)
    {
        $pregunta = mb_strtolower($request->input('pregunta', ''));
        
        // Inicializamos el contexto general
        $contexto = "BASE DE DATOS INTRANET A.C. ENTERPRISES:\n\n";

        // 1. Tabla Articulo (Inventario)
        $articulos = DB::table('Articulo')->get();
        if ($articulos->isNotEmpty()) {
            $contexto .= "--- INVENTARIO ---\n";
            $contexto .= $articulos->map(function($a) {
                return "Modelo: {$a->Modelo} | Desc: {$a->Descripcion} | Precio: S/.{$a->PrecioVenta} | Stock: {$a->Stock}";
            })->implode("\n") . "\n\n";
        }

        // 2. Tabla Personal (Empleados)
        $personal = DB::table('Personal')->get();
        if ($personal->isNotEmpty()) {
            $contexto .= "--- PERSONAL ---\n";
            $contexto .= $personal->map(function($p) {
                return "ID Personal: {$p->id} | Nombre: {$p->Nombre_1} {$p->Apellido_1} | Teléfono: {$p->telefono} | Documento: {$p->Codigo_Documento}";
            })->implode("\n") . "\n\n";
        }

        // 3. Tabla Ventas
        $ventas = DB::table('Ventas')->get();
        if ($ventas->isNotEmpty()) {
            $contexto .= "--- VENTAS ---\n";
            $contexto .= $ventas->map(function($v) {
                return "ID Venta: {$v->id} | Cliente: {$v->Nombre_Cliente} | Total: S/.{$v->Total} | Fecha Emisión: {$v->Fecha_Emision} | ID Vendedor: {$v->fk_personal_Vendedor}";
            })->implode("\n") . "\n\n";
        }

        // 4. Tabla Usuarios
        $usuariosConRoles = DB::table('Usuarios')
            ->leftJoin('Usuarios_Roles', 'Usuarios.id', '=', 'Usuarios_Roles.fk_id_usuario')
            ->leftJoin('Roles', 'Usuarios_Roles.fk_id_rol', '=', 'Roles.id')
            ->select(
                'Usuarios.Username',
                'Usuarios.Email',
                'Usuarios.fk_id_personal',
                'Usuarios.Habilitado',
                'Roles.Rol as Nombre_Rol'
            )
            ->get();

        if ($usuariosConRoles->isNotEmpty()) {
            $contexto .= "--- USUARIOS DEL SISTEMA Y SUS ROLES ---\n";
            
            // Agrupamos por usuario para manejar limpiamente si un usuario tiene más de un rol asignado
            $usuariosAgrupados = $usuariosConRoles->groupBy('Username');

            foreach ($usuariosAgrupados as $username => $registros) {
                $primerRegistro = $registros->first();
                $estado = $primerRegistro->Habilitado ? 'Activo' : 'Inactivo';
                
                // Extraemos todos los roles asociados a este usuario en una lista separada por comas
                $listaRoles = $registros->pluck('Nombre_Rol')->filter()->implode(', ') ?: 'Sin rol asignado';

                $contexto .= "Username: {$username} | Email: {$primerRegistro->Email} | Estado: {$estado} | Roles Asignados: [{$listaRoles}]\n";
            }
            $contexto .= "\n";
        }

        // 5. Tabla Roles
        $roles = DB::table('Roles')->get();
        if ($roles->isNotEmpty()) {
            $contexto .= "--- ROLES ---\n";
            $contexto .= $roles->map(function($r) {
                return "Rol: {$r->Rol} | Descripción: {$r->Descripcion}";
            })->implode("\n") . "\n\n";
        }

        // 6. Tabla Boleta (Ahora incluye el nombre del Personal mediante un join)
        $boletasConPersonal = DB::table('Boleta')
            ->join('Personal', 'Boleta.fk_id_personal', '=', 'Personal.id')
            ->select(
                'Boleta.id',
                'Boleta.Sueldo_Neto',
                'Boleta.Dias_Laborados',
                'Personal.Nombre_1',
                'Personal.Apellido_1'
            )
            ->get();

        if ($boletasConPersonal->isNotEmpty()) {
            $contexto .= "--- BOLETAS DE PAGO ---\n";
            $contexto .= $boletasConPersonal->map(function($b) {
                // Unimos el nombre y apellido para enviarlo limpio a la IA
                $nombreEmpleado = trim("{$b->Nombre_1} {$b->Apellido_1}");
                
                return "ID Boleta: {$b->id} | Empleado: {$nombreEmpleado} | Sueldo Neto: S/.{$b->Sueldo_Neto} | Días Laborados: {$b->Dias_Laborados}";
            })->implode("\n") . "\n\n";
        }

        // Si la base de datos está completamente vacía
        if ($contexto === "BASE DE DATOS INTRANET A.C. ENTERPRISES:\n\n") {
            $contexto = "ADVERTENCIA: La base de datos está completamente vacía.";
        }

        // Consultamos a la IA pasándole TODO el contexto
        $respuestaIa = trim($this->gemini->consultarAsistente($pregunta, $contexto));

        return response()->json(['status' => 'success', 'respuesta' => $respuestaIa]);
    }
}
