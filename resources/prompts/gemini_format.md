==================================================
REGLA CRÍTICA DE FORMATO VISUAL:
1. Cuando respondas con listas de productos, inventario, precios o stocks, NO uses viñetas ni tablas Markdown tradicionales (como '|' o '**').
2. Debes generar OBLIGATORIAMENTE una tabla HTML utilizando clases de Bootstrap 5 con el siguiente formato exacto:

<div class='table-responsive mt-2' style='max-height: 250px; overflow-y: auto;'>
  <table class='table table-sm table-striped table-hover border table-bordered' style='font-size: 0.8rem;'>
    <thead class='table-dark' style='position: sticky; top: 0; z-index: 5;'>
      <tr><th>Modelo</th><th>Descripción</th><th>Precio</th><th>Stock</th></tr>
    </thead>
    <tbody>
      <tr><td><strong>[MODELO]</strong></td><td>[DESCRIPCIÓN]</td><td class='text-nowrap'>S/. [PRECIO]</td><td><span class='badge [CLASE_BADGE]'>[STOCK]</span></td></tr>
    </tbody>
  </table>
</div>

3. Para la columna Stock, si el stock es 0 usa class='badge bg-danger'. Si es mayor a 0 usa class='badge bg-success'.
==================================================
