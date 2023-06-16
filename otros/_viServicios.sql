 SELECT s.id,
    s.servicio,
    s.habilitado,
    s.medida_id,
    s.subarea_id,
    sa.subarea,
    sa.abreviatura AS abreviatura_subarea,
    concat(u1.ap_paterno, ' ', u1.ap_materno, ' ', u1.nombre) AS jefe_subarea,
    sa.area_id,
    a.area,
    a.abreviatura AS abreviatura_area,
    concat(u2.ap_paterno, ' ', u2.ap_materno, ' ', u2.nombre) AS jefe_area,
    a.dependencia_id,
    d.dependencia,
    d.abreviatura AS abreviatura_dependencia,
    concat(u3.ap_paterno, ' ', u3.ap_materno, ' ', u3.nombre) AS jefe_dependencia,
    s.orden_impresion,
    s.estatus_cve,
    s.is_visible_mobile,
    s.nombre_mobile,
    s.orden_image_mobile
   FROM servicios s
     LEFT JOIN subareas sa ON s.subarea_id = sa.id
     LEFT JOIN users u1 ON sa.jefe_id = u1.id
     LEFT JOIN areas a ON sa.area_id = a.id
     LEFT JOIN users u2 ON a.jefe_id = u2.id
     LEFT JOIN dependencias d ON a.dependencia_id = d.id
     LEFT JOIN users u3 ON d.jefe_id = u3.id;
