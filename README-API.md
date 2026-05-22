# API REST — Amoretti Pastelería

**Base URL:** `http://localhost:8000/api`

Las rutas marcadas * requieren:
```
Authorization: Bearer {token}
Accept: application/json
```

---

## Endpoints

### 1. `POST /api/login`
Obtiene un token de acceso.

**Body JSON:**
```json
{
  "email": "cliente@amoretti.com",
  "password": "password",
  "device_name": "mi-app"
}
```

**Respuesta `200`:**
```json
{
  "success": true,
  "token": "1|abc123...",
  "user": { "id": 2, "name": "María", "email": "...", "role": "cliente" }
}
```

**Error `401`:**
```json
{ "success": false, "message": "Credenciales incorrectas." }
```

**Error `422`:**
```json
{ "success": false, "message": "Datos inválidos.", "errors": { "email": ["..."] } }
```

---

### 2. `GET /api/productos` *(público)*
Devuelve el catálogo de pasteles disponibles con stock.

**Query param opcional:** `?categoria=Boda`

**Respuesta `200`:**
```json
{
  "success": true,
  "total": 8,
  "data": [
    {
      "id": 1,
      "nombre": "Terciopelo Rojo",
      "sabor": "Vainilla",
      "tamano": "Mediano - 10 personas",
      "categoria": "Cumpleaños",
      "precio": 850.00,
      "stock": 5,
      "imagen_url": "http://localhost:8000/storage/productos/foto.jpg"
    }
  ]
}
```

---

### 3. `GET /api/productos/{id}` *(público)*
Detalle de un pastel específico.

**Respuesta `200`:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nombre": "Terciopelo Rojo",
    "sabor": "Vainilla",
    "tamano": "Mediano - 10 personas",
    "categoria": "Cumpleaños",
    "precio": 850.00,
    "stock": 5,
    "disponible": true,
    "imagen_url": "http://localhost:8000/storage/productos/foto.jpg",
    "creado_en": "2025-01-10T12:00:00+00:00"
  }
}
```

**Error `404`:**
```json
{ "success": false, "message": "Producto no encontrado." }
```

---

### 4. `POST /api/pedidos` *
Agrega un producto al pedido en borrador del cliente.
Si no existe borrador, se crea automáticamente.

**Body JSON:**
```json
{ "producto_id": 1, "cantidad": 2 }
```

**Respuesta `201`:**
```json
{
  "success": true,
  "message": "Producto agregado al pedido.",
  "data": {
    "pedido_id": 5,
    "estado": "borrador",
    "total": 1700.00,
    "productos": [
      {
        "nombre": "Terciopelo Rojo",
        "cantidad": 2,
        "precio_unitario": 850.00,
        "subtotal": 1700.00
      }
    ]
  }
}
```

**Error `422` — stock insuficiente:**
```json
{
  "success": false,
  "message": "Datos inválidos.",
  "errors": { "cantidad": ["Stock insuficiente. Disponible: 1"] }
}
```

**Error `401` — sin token:**
```json
{ "message": "Unauthenticated." }
```

---


## Prueba con cURL

```bash
# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"cliente@amoretti.com","password":"password","device_name":"curl"}'

# Catálogo
curl http://localhost:8000/api/productos

# Detalle
curl http://localhost:8000/api/productos/1

# Agregar al pedido
curl -X POST http://localhost:8000/api/pedidos \
  -H "Authorization: Bearer TU_TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"producto_id": 1, "cantidad": 2}'
```