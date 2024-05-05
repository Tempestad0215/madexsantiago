import { linksI, metaI } from "./share"


export interface ordenStoreI{
    producto: string,
    beneficios: Array<string>,
    materia_prima: Array<string>,
    color: Array<string>,
    olor: Array<string>,
    textura: Array<string>,
    comentario: string,
}

// Datos para agregar a la orden
export interface ordenInputI{
    beneficios: string,
    materia_prima: string,
    color: string,
    olor: string,
    textura:string
}

// Preform del formuilario
export interface ordenPreFormI{
    cliente_id: number,
    cliente_name: string,
    type_orden: number,
    info: Array<ordenStoreI>,
}

// Ordeninfo
export interface ordenInfoI{
    producto: string,
    beneficios: Array<string>,
    materia_prima: Array<string>,
    color: Array<string>,
    olor: Array<string>,
    textura: Array<string>,
    comentario: string
}

// Mostrar la orden
export interface ordenSeeI{
    data: {
        cliente_id: number,
        cliente_name: string,
        id: number,
        info: Array<ordenInfoI>,
        orden_status: string,
        type_orden: string
    }
}

// Orden props see
export interface ordenSeePropsI{
    orden: ordenSeeI
}

// Interfaz de la tabla de orden
interface ordenTableInfoI{
    cliente_id:number,
    cliente_name:string,
    id: number,
    orden_status: string
}

export interface ordenTableI{
    data: Array<ordenTableInfoI>,
    links: linksI,
    meta: metaI
}
