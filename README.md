<img src="public/images/logo_xonacatzy.png" width="400" alt="Laravel Logo">

## TRIGGER en Base de Datos

```bash
DELIMITER //
CREATE TRIGGER `cultivos_after_update` AFTER UPDATE ON `cultivos`
 FOR EACH ROW BEGIN
  INSERT INTO cultivos_historial
  SET
    cultivo_id = OLD.id,
    provedor_id = OLD.provedor_id,
    nombre = OLD.nombre,
    nombre_tecnico = OLD.nombre_tecnico,
    cantidad = OLD.cantidad,
    fecha_ingreso = OLD.fecha_ingreso,
    encargado = OLD.encargado;
 END //
DELIMITER ;
```
