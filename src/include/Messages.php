<?php
class Messages{
    const USER_NOT_FOUND = 'Usuario no encontrado.';
    const USER_OR_PASS_EMPTY = 'Usuario o contraseña vacíos.';
    const INTERNAL_ERROR = 'Error interno. Inténtelo de nuevo pasados unos minutos.';
    const UNAUTHORIZED_ACCESS = 'Acceso no autorizado.';
    const INVALID_CREDENTIALS = 'Usuario o contraseña incorrectos.';
    const CONNECTION_FAILED = "La conexión con la Base de Datos falló";
    const LOAD_DATA_ERROR = 'Error al intentar cargar los datos.';
    const ERROR_MISSING_FIELDS = 'Faltan campos obligatorios.';
    const ERROR_INSERT_PRODUCT = 'Error al guardar el producto.';
    const ERROR_VALIDATION_FAILED = 'Por favor, complete todos los campos obligatorios.';
    const SUCCESS_PRODUCT_SAVED = 'Producto guardado correctamente.';
    const DELETE_DATA_ERROR = 'Error al borrar los datos.';
    const PRODUCT_NOT_FOUND = 'Producto no encontrado.';
    const DELETE_PRODUCT_FAILED = 'No se pudo borrar el producto.';
    const DELETE_PRODUCT_SUCCESS = 'Producto borrado correctamente.';
    const UPDATE_PRODUCT_SUCCESS = 'Producto actualizado correctamente';
    const UPDATE_PRODUCT_ERROR = 'Error al actualizar el producto';
    const MISSING_ARGUMENTS = 'Faltan parámetros.';
    const PASSENGER_LIST_LOAD_ERROR = 'Error al cargar la lista de pasajeros';
    const INVALID_PARAMS = 'Parámetros no válidos';
    const MENU_SUCCESS = 'Menú añadido correctamente al pasajero';
    const MENU_ERROR = 'Error al intentar asignar el menú al pasajero';
    const FLIGHT_MANAGEMENT_SUCCESS = 'El vuelo ha sido gestionado correctamente';
    const FLIGHT_MANAGEMENT_ERROR = 'El vuelo ya está gestionado';
    const FLIGHT_ID_REQUIRED = 'El id del vuelo es requerido';
    const NUM_ORDER_NOT_VALID = 'Número de pedido no válido';
    const DATE_ORDER_NOT_VALID = 'Fecha de entrega no válida';
    const NOT_VALID_QUANTITY = 'Cantidad no válida';
    const PRODUCT_PRICE_NOT_VALID = 'Precio del producto no válido';
    const ORDER_CREATED_SUCCESSFULLY = 'Pedido creado correctamente';
    const ORDER_CREATED_ERROR = 'Hubo un error al crear el pedido';
    const ORDER_CANCELLED = 'Pedido cancelado correctamente';
    const ORDER_CANCEL_FAILURE = 'El pedido no pudo ser cancelado debido a un error';
    const ACTION_NOT_FOUND = 'Orden no encontrada';
}