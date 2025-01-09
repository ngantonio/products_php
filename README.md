<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


# Products API

Descripción:

Se presenta una sencilla API-REST construida bajo *Laravel*, utilizando como base de datos local a *SQLite*.

Se ha construido con un enfoque sencillo y exponiendo un C.R.U.D para los modelos "Product", "Prices", y "Currency".

Se exponen los siguientes Endpoints :


**PRODUCTOS**


* GET **http://localhost:8000/api/products/**: Obtiene todos los productos almacenados en base de datos.

* GET **http://localhost:8000/api/products/id/**: Obtiene el producto almacenado en base de datos que corresponda con el id enviado, si no existe, regresa un 404.

* POST **http://localhost:8000/api/products/**: Crea un producto con el siguiente body; debe existir una moneda registrada, de lo contrario regresa un error
```
{
    "name": "Arroz",
    "description": "Arroz blanco",
    "price": 28,
    "tax_cost": 10,
    "manufacturing_cost": 30,
    "currency_id": 1
}
```
* PUT **http://localhost:8000/api/products/id/**: Modifica el producto almacenado en base de datos que corresponda con el id enviado, si no existe el registro, regresa un 404.

```
{
    "name": "Arroz",
    "description": "Arroz Moreno",
    "price": 30,
    "tax_cost": 50,
    "manufacturing_cost": 30,
    "currency_id": 1
}
```
* DELETE **http://localhost:8000/api/products/id/**: Elimina el saludo almacenado en base de datos que corresponda con el id enviado, si no existe el registro, regresa un 404.


* GET **http://localhost:8000/api/products/id/prices/**: Obtiene la lista de los precios que ha tenido un producto.


* POST **http://localhost:8000/api/products/id/prices/**: Crea un nuevo precio para el producto solicitado con el siguiente body; debe existir el producto y la moneda ya registrados, de lo contrario regresa un error
```
{
    "id": 2,
    "price": 40,
    "currency_id": 1
}
```


**MONEDAS**

* GET **http://localhost:8000/api/currency/**: Obtiene todas las monedas almacenadas en base de datos.

* GET **http://localhost:8000/api/currency/id/**: Obtiene la moneda almacenada en base de datos que corresponda con el id enviado, si no existe, regresa un 404

* POST **http://localhost:8000/api/currency/**: Crea una moneda con el siguiente body:
```
{
    "name": "Dolar",
    "symbol": "$",
    "exchange_rate": 10
}
```
* PUT **http://localhost:8000/api/currency/id**: Modifica la moneda almacenada en base de datos que corresponda con el id enviado, si no existe el registro, regresa un 404.

```
{
    "name": "Dolar",
    "symbol": "$",
    "exchange_rate": 40
}
```
* DELETE **http://localhost:8000/api/currency/id**: Elimina una moneda almacenada en base de datos que corresponda con el id enviado, si no existe el registro, regresa un 404.


** Notas: 
1. Los atributos "tax_cost" y "manufacturing_cost" son opcionales al crear un producto.
2. La base de datos está en sqlite y se ha subido a este repositorio, de manera que, el proyecto puede iniciarse sin correr las migraciones.
3. Se generó un controlador y un modelo para cada entidad


## Corriendo la api

```bash
$ php artisan serve

```