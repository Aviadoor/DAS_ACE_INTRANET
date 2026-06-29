<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Articulo;
use App\Models\Personal;
use App\Models\Lista_Articulos;
use DateInterval;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::all();
        return view('Venta.index', compact('ventas'));
    }

    public function create()
    {
        $personas = Personal::all();
        $articulos = Articulo::all();
        return view('Venta.create', compact('articulos', 'personas'));
    }

    public function store(Request $request)
    {
        date_default_timezone_set('America/Lima');

        $fecha_actual = new DateTimeImmutable(date('d-m-Y'));

        $fecha_ayer = $fecha_actual -> sub(DateInterval::createFromDateString('1 day'));

        $tomorrow = $fecha_actual -> add(DateInterval::createFromDateString('1 days'));

        $fecha_cobro = $fecha_actual -> add(DateInterval::createFromDateString('15 days'));

        $request -> validate([
            'Nombre_Cliente' => ['required'],
            'fk_personal_Vendedor' => ['required', 'exists:Personal,id'],
            'Fecha_Emision' => ['required', 'date', 'before:' . $tomorrow -> format('Y-m-d'), 'after:' . $fecha_ayer -> format('Y-m-d')],
            'Fecha_Entrega' => ['required', 'date', 'after:' . $fecha_actual -> format('Y-m-d')],
            'Fecha_Cobro' => ['required', 'date', 'after:' . $fecha_cobro -> format('Y-m-d')],
            'Cuotas' => ['required', 'integer', 'min:1'],
            'MontoCancelado' => ['min:0'],
            'Subtotal' => ['required', 'numeric'],
            'Total' => ['required', 'numeric'],

            //Validacion de articulos
            'articulos_id' => ['required', 'array'],
            'articulos_id*' => ['required', 'integer', 'exists:Articulo,id'],
            'cantidades' => ['required', 'array'],
            'cantidades*' => ['required', 'integer', 'min:1'] 
        ],[
            'Nombre_Cliente.required' => 'Campo obligatorio',

            'fk_personal_Vendedor.required' => 'Campo obligatorio',
            'fk_personal_Vendedor.exists' => 'Vendedor debe existir',

            'Fecha_Emision.required' => 'Campo obligatorio',
            'Fecha_Emision.after' => 'Debe ser la fecha de hoy',
            'Fecha_Emision.before' => 'Debe ser la fecha de hoy',

            'Fecha_Entrega.required' => 'Campo obligatorio',
            'Fecha_Entrega.after' => 'Fecha debe ser desde mañana',

            'Fecha_Cobro.required' => 'Campo obligatorio',
            'Fecha_Cobro.after' => 'Debe cobrarse como minimo 15 dias despues',

            'cantidades*.min' => 'Cantidad minima: 1'
        ]);

        DB::beginTransaction();
        try
        {
            $venta = Venta::create([
                'Nombre_Cliente' => $request -> Nombre_Cliente,
                'fk_personal_Vendedor' => $request -> fk_personal_Vendedor,
                'Fecha_Emision' => $request -> Fecha_Emision,
                'Fecha_Entrega' => $request -> Fecha_Entrega,
                'Fecha_Cobro' => $request -> Fecha_Cobro,
                'Cuotas' => $request -> Cuotas,
                'MontoCancelado' => $request -> MontoCancelado,
                'Subtotal' => $request -> Subtotal,
                'Total' => $request -> Total
            ]);

            $articulos_id = $request -> articulos_id;

            foreach($articulos_id as $clave => $id){
                $articulo = Articulo::find($id);
                $stock_actual = $articulo -> Stock;
                $cantidad = $request -> cantidades[$clave];

                if (($stock_actual - $cantidad) >= 0){
                    
                    $articulo -> Stock = $stock_actual - $cantidad;
                    $articulo -> save();

                    Lista_Articulos::create([
                        'fk_id_articulo' => $id,
                        'fk_id_Ventas' => $venta -> id,
                        'cantidad' => $request -> cantidades[$clave]
                    ]);
                }
            }

            DB::commit();

            return redirect(route('venta.index'));
        } catch(\Exception $e){
            DB::rollBack();
            return $e -> getMessage();
        }

    }

    public function show(string $id)
    {
        $venta = Venta::with('articulos') -> find($id);
        $articulos = $venta -> articulos;
        $personas = Personal::all();

        return view('Venta.show', compact('venta', 'articulos', 'personas'));
    }

    public function edit(string $id)
    {
        $venta = Venta::find($id);
        $articulos = Articulo::all();
        $articulos_listados = $venta -> articulos;
        $personas = Personal::all();
        $id_vendedor = $venta -> personal -> id;
        return view('Venta.edit', compact('venta', 'articulos', 'articulos_listados', 'personas', 'id_vendedor'));
    }

    public function update(Request $request, string $id)
    {
        $request -> validate([
            'Nombre_Cliente' => ['required'],
            'fk_personal_Vendedor' => ['required', 'exists:Personal,id'],
            'Fecha_Emision' => ['required', 'date'],
            'Fecha_Entrega' => ['required', 'date'],
            'Fecha_Cobro' => ['required', 'date'],
            'Cuotas' => ['required', 'integer', 'min:1'],
            'MontoCancelado' => ['min:0'],
            'Subtotal' => ['required', 'numeric'],
            'Total' => ['required', 'numeric'],

            //Validacion de articulos
            'articulos_id' => ['required', 'array'],
            'articulos_id*' => ['required', 'integer', 'exists:Articulo,id'],
            'cantidades' => ['required', 'array'],
            'cantidades*' => ['required', 'integer', 'min:1'] 
        ],[
            'Nombre_Cliente.required' => 'Campo obligatorio',

            'fk_personal_Vendedor.required' => 'Campo obligatorio',
            'fk_personal_Vendedor.exists' => 'Vendedor debe existir',

            'Fecha_Emision.required' => 'Campo obligatorio',

            'Fecha_Entrega.required' => 'Campo obligatorio',

            'Fecha_Cobro.required' => 'Campo obligatorio',

            'cantidades*.min' => 'Cantidad minima: 1'
        ]);

        DB::beginTransaction();
        try {
            // 1. Actualizamos la cabecera de la venta
            $venta = Venta::find($id);
            $venta->update([
                'Nombre_Cliente' => $request->Nombre_Cliente,
                'fk_personal_Vendedor' => $request->fk_personal_Vendedor,
                'Fecha_Emision' => $request->Fecha_Emision,
                'Fecha_Entrega' => $request->Fecha_Entrega,
                'Fecha_Cobro' => $request->Fecha_Cobro,
                'Cuotas' => $request->Cuotas,
                'MontoCancelado' => $request->MontoCancelado,
                'Subtotal' => $request->Subtotal,
                'Total' => $request->Total
            ]);

            // 2. Mapeamos los artículos antiguos (BD) y los nuevos (Formulario)
            $articulos_viejos = [];
            foreach ($venta->articulos as $art) {
                $articulos_viejos[$art->id] = $art->pivot->cantidad;
            }

            $articulos_nuevos_ids = $request->articulos_id ?? [];
            $cantidades_nuevas = $request->cantidades ?? [];
            
            $articulos_formulario = [];
            foreach ($articulos_nuevos_ids as $clave => $id_art) {
                $articulos_formulario[$id_art] = $cantidades_nuevas[$clave];
            }

            // 3. Procesar los artículos que vienen del formulario (Nuevos o Modificados)
            foreach ($articulos_formulario as $id_art => $cant_nueva) {
                $articulo_db = Articulo::find($id_art);

                if (array_key_exists($id_art, $articulos_viejos)) {
                    // El artículo ya existía en la venta -> Calculamos la diferencia
                    $cant_vieja = $articulos_viejos[$id_art];
                    $diferencia = $cant_nueva - $cant_vieja;

                    if ($diferencia > 0) {
                        // Se aumentó la cantidad -> Quitamos del stock
                        if ($articulo_db->Stock >= $diferencia) {
                            $articulo_db->Stock -= $diferencia;
                            $articulo_db->save();
                        } else {
                            throw new \Exception("Stock insuficiente para el artículo: " . $articulo_db->Modelo);
                        }
                    } elseif ($diferencia < 0) {
                        // Se redujo la cantidad -> Devolvemos al stock
                        $articulo_db->Stock += abs($diferencia);
                        $articulo_db->save();
                    }

                    // Actualizamos la tabla pivote
                    Lista_Articulos::where('fk_id_Ventas', $id)
                        ->where('fk_id_articulo', $id_art)
                        ->update(['cantidad' => $cant_nueva]);

                } else {
                    // Es un artículo NUEVO agregado a esta venta
                    if ($articulo_db->Stock >= $cant_nueva) {
                        $articulo_db->Stock -= $cant_nueva;
                        $articulo_db->save();

                        Lista_Articulos::create([
                            'fk_id_Ventas' => $id,
                            'fk_id_articulo' => $id_art,
                            'cantidad' => $cant_nueva
                        ]);
                    } else {
                        throw new \Exception("Stock insuficiente para el artículo: " . $articulo_db->Modelo);
                    }
                }
            }

            // 4. Procesar artículos que fueron ELIMINADOS de la vista
            foreach ($articulos_viejos as $id_art_viejo => $cant_vieja) {
                if (!array_key_exists($id_art_viejo, $articulos_formulario)) {
                    // Si estaba en BD pero no en el formulario, se eliminó de la venta
                    $articulo_db = Articulo::find($id_art_viejo);
                    $articulo_db->Stock += $cant_vieja; // Devolvemos toda su cantidad al stock
                    $articulo_db->save();

                    // Lo borramos de la tabla pivote
                    Lista_Articulos::where('fk_id_Ventas', $id)
                        ->where('fk_id_articulo', $id_art_viejo)
                        ->delete();
                }
            }

            DB::commit();
            return redirect(route('venta.index'));

        } catch(\Exception $e) {
            DB::rollBack();
            // Sería ideal retornar a la vista con el error para que el usuario sepa qué falló
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(string $id)
    {     
        DB::beginTransaction();   
        try
        {
            $venta = Venta::find($id);
            $articulos = $venta -> articulos;
            
            foreach($articulos as $art){
                $art_bd = Articulo::find($art -> id);
                $art_bd -> Stock += $art -> pivot -> cantidad;
                $art_bd -> save();
            }
            $venta -> delete();
            DB::commit();
            return redirect(route('venta.index'));
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $e -> getMessage();
        }
    }
}
