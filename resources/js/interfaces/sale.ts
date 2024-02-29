import { linksI, metaI } from "./share";


export interface saleInfoI{
    product: string,
    price: string,
    quantity: string,
    subtotal: string
}

// Producto para facturar
export interface saleProductI{
    price: string;
    product: string;
    quantity: string;
    subtotal: string;
}

// Datos para mostrar la venta
export interface seeSaleI{
    data: seeSaleDataI

}
// Mostra las data para la tabla
export interface showAllSaleI{
    data: Array<seeSaleDataI>;
    meta: metaI;
    links: linksI;
}


interface seeSaleDataI{
    address: string;
    city: string;
    client_name: string;
    id: number;
    from: string,
    to: string,
    ncf: string;
    pending: number;
    phone: string;
    products: Array<saleInfoI>
    rnc: string | null;
    sub_total: number;
    total: number;
    type: string;
    is_maluhia: boolean;
}
