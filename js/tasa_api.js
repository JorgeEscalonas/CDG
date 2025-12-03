$(document).ready(function() {
    const apiUrl = 'https://ve.dolarapi.com/v1/dolares';
    const $inputPrecio = $('#precio');
    const $radioManual = $('input[name="tipo_tasa"][value="manual"]');
    const $radioApi = $('input[name="tipo_tasa"][value="api"]');

    // Función para obtener y actualizar el precio
    function fetchAndSetPrice() {
        $inputPrecio.prop('disabled', true).val('Cargando...');
        
        $.ajax({
            url: apiUrl,
            method: 'GET',
            success: function(response) {
                // La API retorna un array de monitores o un objeto único dependiendo del endpoint.
                // Basado en la descripción del usuario, podría ser una lista.
                // Buscamos la tasa oficial.
                let tasaOficial = null;

                if (Array.isArray(response)) {
                    // Buscar una fuente que parezca oficial
                    tasaOficial = response.find(item => 
                        item.nombre.toLowerCase().includes('oficial') || 
                        item.fuente.toLowerCase().includes('oficial') ||
                        item.nombre.toLowerCase().includes('bcv')
                    );
                } else if (typeof response === 'object') {
                    // Tal vez el endpoint retorna solo el objeto si es específico?
                    // Pero usualmente /dolares retorna una lista.
                    // Si la respuesta en sí es el objeto:
                    tasaOficial = response;
                }

                if (tasaOficial) {
                    $inputPrecio.val(tasaOficial.promedio);
                    // Opcional: Mostrar más información como "Fuente: BCV, Actualizado: ..."
                } else {
                    alert('No se pudo encontrar la tasa oficial en la respuesta de la API.');
                    $inputPrecio.val('');
                    $radioManual.prop('checked', true).trigger('change');
                }
            },
            error: function() {
                alert('Error al conectar con la API.');
                $inputPrecio.val('');
                $radioManual.prop('checked', true).trigger('change');
            },
            complete: function() {
                $inputPrecio.prop('disabled', false);
            }
        });
    }

    $('input[name="tipo_tasa"]').change(function() {
        if ($radioApi.is(':checked')) {
            fetchAndSetPrice();
            $inputPrecio.prop('readonly', true); // Prevenir edición manual si la API está seleccionada
            $inputPrecio.addClass('tasa-oficial'); // Cambiar color a #333
        } else {
            $inputPrecio.val('');
            $inputPrecio.prop('readonly', false);
            $inputPrecio.removeClass('tasa-oficial'); // Volver a color blanco
        }
    });
});
