

export interface pagoFullI{
    orden_id: number,
    client_name: string,
    client_id: number,
    trans:{
        first: string,
        second: string,
        third: string
    },
    quantity: {
        first: string,
        first_pay: string,
        second: string,
        second_pay: string,
        third: string,
        third_pay: string,
    },
    pago_id: number,
    photo: File,
    orden_status: number,
    type_orden: string
}
// Datos para ver el pago
export interface pagoSeeI{
    data:{
        id: number,
        cliente_name: string,
        cantidad: {
            first: string,
            second: string | null,
            third: string | null,
            first_pay: string,
            second_pay: string,
            third_pay: string,
        },
        transaccion:{
            first:string,
            second:string | null,
            third:string | null,
        },
        urlImage: string,
        images: Array<string>
    }
}
