export interface rncI{
    actividad_economica: string;
    creacion : string;
    estatus: string;
    nombre_comercial: string;
    number: string;
    razon_social: string;
    tipo: string;
}

export interface responseRncI{
    estado: string;
    mensaje: string;
    datos: rncI
}
