function generarFactura() {
    const nombre = document.getElementById('nombre').value;
    const direccion = document.getElementById('direccion').value;
    const fecha = document.getElementById('fecha').value;
    const cantidad = parseFloat(document.getElementById('cantidad').value);
    const precio = parseFloat(document.getElementById('precio').value);

    const subtotal = cantidad * precio;
    const iva = subtotal * 0.16;
    const total = subtotal + iva;

    const facturaHTML = `
        <div class="invoice-header">
            <h2>Factura</h2>
        </div>
        <div class="invoice-body">
            <div class="invoice-info">
                <p><strong>Nombre del Cliente:</strong> ${nombre}</p>
                <p><strong>Dirección:</strong> ${direccion}</p>
                <p><strong>Fecha:</strong> ${fecha}</p>
                <p><strong>Cantidad de Agua Consumida (m³):</strong> ${cantidad}</p>
                <p><strong>Precio por m³:</strong> ${precio.toFixed(2)}</p>
            </div>
        </div>
        <div class="invoice-footer">
            <div class="invoice-total">
                <p><strong>Subtotal:</strong> $${subtotal.toFixed(2)}</p>
                <p><strong>IVA (16%):</strong> $${iva.toFixed(2)}</p>
                <p><strong>Total:</strong> $${total.toFixed(2)}</p>
            </div>
        </div>
    `;

    document.getElementById('invoice-preview').innerHTML = facturaHTML;

    // Opción para imprimir automáticamente
    window.print();
}
 