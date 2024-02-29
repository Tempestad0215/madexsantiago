import { linksI, metaI } from "./share"


export interface formulaTableI{
    data: Array<formulaI>,
    links: linksI,
    meta: metaI
}

 export interface formulaI{
    cliente_id: number,
    cliente_name: string,
    comments: Object,
    id: number,
    orden_status: string
}
