

export interface CargaI{
    bruto: number;
    cant_pacas: number;
    cedula: string | null;
    color: number;
    creacion: string;
    desc: number;
    desc_kg: number;
    estatus_tiket: number;
    fecha_pago_tiket: string | null;
    id: number;
    material: number;
    pago_efectivo: number;
    placa: string | null;
    precio_kg: number;
    sub_total: number;
    suelto_paca: number;
    suplidor: string;
    tara: number;
    total_kg: number;
    vehiculo: number;
    tipo: number;
}


// Con resource
export interface cargaResourceI{
    data: cargaDefaultI
}
// por default
export interface cargaDefaultI{
    bruto: number;
    cant_pacas: number;
    cedula: string | null;
    color: string;
    creacion: string;
    desc: number;
    desc_kg: number;
    estatus_tiket: string;
    fecha_pago_tiket: string | null;
    id: number;
    material: string;
    pago_efectivo: number;
    placa: string | null;
    precio_kg: number;
    sub_total: number;
    suelto_paca: string;
    suplidor: string | null;
    tara: number;
    total_kg: number;
    vehiculo: string;
    tipo: boolean;
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


// Reporte
export interface reporteGeneralI{
    total_kg_mensual: number;
    total_kg_anual: number;
    total_desc_anual: number;
    total_efectivo: number;
    total_cant_pacas: number;

}

// Reporte fecha
export interface reporteFechaI{
    total_kg: number;
    desc_kg: number;
    pago_efectivo: number;
    cant_pacas: number;
    desde: string;
    hasta: string;
    isAvance: boolean;
}

