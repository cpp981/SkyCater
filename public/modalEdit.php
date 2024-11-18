<!-- Modal -->
<div class="modal fade shadow-lg" data-bs-backdrop="static" id="modalEdit" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para editar producto -->
                <form id="formularioEditProducto">
                    <!-- Nombre del producto -->
                    <div class="mb-3">
                        <label for="nombreP" class="form-label">Nombre del Producto <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control border border-secondary" id="nombreP" required>
                    </div>
                    <!-- Descripción del producto -->
                    <div class="mb-3">
                        <label for="descripcionP" class="form-label">Descripción del
                            Producto</label>
                        <textarea class="form-control border border-secondary" id="descripcionP" rows="2"
                            style="resize: none;"></textarea>
                    </div>
                    <!-- Categoría del producto -->
                    <div class="mb-3">
                        <label for="categoriaP" class="form-label">Categoría <span
                                class="text-danger">*</span></label>
                        <select class="form-select border border-secondary" id="categoriaP" required>
                            <option value="">Seleccione una categoría</option>
                            <option value="Bebida">Bebida</option>
                            <option value="Entrante">Entrante</option>
                            <option value="Primer Plato">Primer Plato</option>
                            <option value="Segundo Plato">Segundo Plato</option>
                            <option value="Postre">Postre</option>
                        </select>
                    </div>
                    <!-- Alérgenos -->
                    <div class="mb-3">
                        <label for="alergenosP" class="form-label">Alérgenos <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control border border-secondary" id="alergenosP" required>
                    </div>
                    <!-- Valor Nutricional -->
                    <div class="mb-3">
                        <label for="valorNutricionalP" class="form-label">Valor Nutricional</label>
                        <input type="number" class="form-control border border-secondary" id="valorNutricionalP" rows="2"
                            style="resize: none;"></input>
                    </div>
                    <!-- Id Proveedor -->
                    <div class="mb-3">
                        <label for="nombreProv" class="form-label">Proveedor</label>
                        <input type="text" class="form-control border border-secondary" id="nombreProv" disabled>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"></i>Cerrar</button>
                <button type="submit" id="guardarProducto" form="formularioProducto" class="btn btn-success"><i
                        class="fas fa-save me-1"></i>Grabar
                    Producto</button>
            </div>
            </form>
        </div>
    </div>
</div>