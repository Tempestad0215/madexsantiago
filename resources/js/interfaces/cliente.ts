import { linksI, metaI } from "./share"


export interface clientStore {
    id:number,
    name: string,
    enterprise: string,
    client_id: string,
    email: string,
    phone: string,
    city: string,
    address: string

}

// Editar cliente
export interface clientEditI{
    id:number;
    name: string;
    enterprise: string | null;
    rnc: string | null;
    client_id: string | null;
    email: string | null;
    phone: string | null;
    city: string | null;
    address: string | null;
}
export interface clientDataI{
    client_id: string | null,
    id: number,
    name: string,
    phone: string | null,
    rnc: string | null,
    address: string | null,
    city: string | null
}

// Datos a mostrar en la tabla
export interface clientShowI{
    data: Array<clientDataI>,
    links: linksI,
    meta: metaI
}
