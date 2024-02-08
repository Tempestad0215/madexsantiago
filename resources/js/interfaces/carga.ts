

export interface CargaI{
    bruto: number;
    cant_pacas: number | null;
    cedula: string | null;
    color: string | null;
    creacion: string;
    desc: number | null;
    desc_kg: number;
    estatus_tiket: string;
    fecha_pago_tiket: string | null;
    id: number;
    material: string;
    mes: string;
    pago_efectivo: number;
    placa: string | null;
    precio_kg: number;
    sub_total: number;
    suelto_paca: number;
    suplidor: string | null;
    tara: number;
    total_kg: number
    vehiculo: string
}

export interface paginationI{
    data: Array<CargaI>;
    links: linksI;
    meta: metaI;
}

interface linksI{
    first: string | null;
    last: string | null;
    next: string | null;
    prev: string | null;

}
interface metaI{
    current_page: number;
    from: number;
    path: string;
    per_page: number;
    to: number

}

