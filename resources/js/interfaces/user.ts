import { linksI, metaI } from "./share"


export interface userTableI {
    data: Array<userI>,
    links: linksI,
    meta: metaI
}


interface userI{
    deparment: string,
    email: string,
    id: number,
    image_name: string,
    name: string
}
