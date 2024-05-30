/**
* @author Tarsicio Carrizales telecom.com.ve@gmail.com
*/
var indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;
dataBase = indexedDB.open("horus_venezuela", "1");
dataBase.onupgradeneeded = function (e) {
    active = dataBase.result;
    users = active.createObjectStore("users", { keyPath : 'id', autoIncrement : true });
    users.createIndex('idx_rols_id', 'rols_id', { unique : false });
    users.createIndex('idx_name', 'name', { unique : false });
    users.createIndex('idx_avatar', 'avatar', { unique : false });
    users.createIndex('idx_email', 'email', { unique : true });
    users.createIndex('idx_password', 'password', { unique : false });
    users.createIndex('idx_activo', 'activo', { unique : false });
    users.createIndex('idx_init_day', 'init_day', { unique : false });
    users.createIndex('idx_end_day', 'end_day', { unique : false });
            
    dataBase.onsuccess = function (e) {        
        swal('IndexdDB', 'Base de datos cargada correctamente.', 'success');
    };
        
    dataBase.onerror = function (e)  {        
        swal('IndexdDB', 'Error cargando la base de datos.', 'error');
    };
}
