

export interface despachoTableI {
    dataShowProduct: Array<despachoI>
}

export interface despachoI{
    description: string,
    id: number,
    name: string,
    stock: number
}

// Los productos que seran agregado
export interface despachoProductI{
    id: number,
    name: string,
    quantity: number
}
