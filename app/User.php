<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    // protected $fillable = [
    //     'name', 'email', 'password',
    //     //Mercadolibre data
    //     'token',
    //     'refresh_token',
    //     'ml_id',
    //     'ml_nickname',
    //     'ml_username',
    //     'ml_avatar',
    //     'expires_at',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    
    protected $attributes = 
    [
        'post_images' => '["",""]',
        'forbiden_brands_list' => '[["",""]]',
        'price_table'=> '[[0, 10, 100],[10, 20, 90],[20, 30, 50],[30, 40, 10]]',
        'weight_table'=> '[[0, 10, 5.8],[10, 50, 1.5]]',
        'taxes_table'=> '[[0, 200, 5],[200, 100000, 15]]',
        'post_description' => 'POLITICAS
        -----------------------------------------------------------------------------
        ---------------------- TIEMPOS DE ENVÍO ------------------------
        --------------------------- DE 4 A 8 DÍAS ---------------------------
        ---------- HÁBILES A CIUDADES PRINCIPALES -----------
        -----------------------------------------------------------------------------
        
        @titulo
        @peso
        @descripcion
        @sku
        @medidas
        @color
        @talla
        @marca
        @modelo
        @fabricante
        
        ----------------------
        Algunos municipios no tienen cobertura por nuestro proveedor logístico, ante la cual se entregan en un oficina o corresponsal asignada.
        * Productos, stock y tiempos de entrega sujetos a cambios
        * Envío Internacional
        Para confirmar cambios de tallas, o erroresde referencias, contáctate con nosotros entre las 24 horas siguientes, después de generar la orden. En caso de no realizar este proceso, enviaremos la referencia de la publicación.
        
        «=========================================================»
        •Somos facilitadores, traemos los productos desde el exterior para ti. El proceso se realiza con proveedores internacionales. Por ende, pueden existir variaciones de stock y/o precio, como resultado de la actualización automática realizada diariamente. Ante lo cual realizamos la devolución de dinero.•
        «=========================================================»
        
        «=========================================================»
        •Los repuestos electrónicos para vehículos no cuentan con Garantía del proveedor. Ante lo cual no nos hacemos responsables.•
        «=========================================================»
        
        ¿TIENEN ALGUNA GARANTÍA?
        Nuestros proveedores nos ofrecen una garantía de 30 días la cual extendemos a nuestros clientes, esta cubre daños por defectos del material o errores en la fabricación. NO cubre mala manipulación por parte del usuario.
        
        ¿QUÉ PUEDO HACER EN CASO DE RETRACTO?
        En caso de que ya no desee el producto recibido, puede realizar la devolución del mismo en un periodo no mayor a 5 días, a partir de su entrega. Para ello, deberá pagar el costo del retorno hacia USA, Este varía de acuerdo al tamaño y peso del producto.
        
        POR FAVOR PREGUNTE DISPONBIILIDAD ANTES DE COMPRAR
        Toda nuestra mercancia es importada por favor valide su disponibilidad
        
        NO HACEMOS ENTREGA INMEDIATA, TODOS NUESTROS PRODUCTOS SON IMPORTADOS.
        -----------------------------------------------------------------------------
        ---------------------- TIEMPOS DE ENVÍO ------------------------
        --------------------------- DE 4 A 8 DÍAS ---------------------------
        ---------- HÁBILES A CIUDADES PRINCIPALES -----------
        -----------------------------------------------------------------------------',
    ];
}
