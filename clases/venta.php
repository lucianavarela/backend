<?php
class Venta
{
    public $id;
    public $tipo;
    public $idUsuario;
    public $nombreServicio;
    public $mbServicio;
    public $importe;
    public $fecha;
    
    public function GetTipo() {
        return $this->tipo;
    }
    public function GetIdUsuario() {
        return $this->idUsuario;
    }
    public function GetNombreServicio() {
        return $this->nombreServicio;
    }
    public function GetMbServicio() {
        return $this->mbServicio;
    }
    public function GetImporte() {
        return $this->fecha;
    }
    public function GetFecha() {
        return $this->fecha;
    }

    public function SetTipo($value) {
        $this->tipo = $value;
    }
    public function SetIdUsuario($value) {
        $this->idUsuario = $value;
    }
    public function SetNombreServicio($value) {
        $this->nombreServicio = $value;
    }
    public function SetMbServicio($value) {
        $this->mbServicio = $value;
    }
    public function SetImporte($value) {
        $this->fecha = $value;
    }
    public function SetFecha($value) {
        $this->fecha = $value;
    }
    
    public function BorrarVenta() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            delete from ventas WHERE id=$this->id");
        $consulta->execute();

        return $consulta->rowCount();
    }

    public function ModificarVenta() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            update ventas 
            set tipo='$this->tipo',
            nombreServicio='$this->nombreServicio',
            mbServicio=$this->mbServicio,
            idUsuario=$idUsuario,
            importe=$this->importe,
            fecha='$this->fecha'
            WHERE id=$this->id");
        return $consulta->execute();
    }

    public function InsertarVenta() {
        $datetime_now = date("Y-m-d H:i:s");
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into ventas
        (tipo,idUsuario,nombreServicio,mbServicio,importe,fecha)values
        ('$this->tipo',$this->idUsuario,'$this->nombreServicio',$this->mbServicio,$this->importe,'$datetime_now')"
        );
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function GuardarVenta() {
        if ($this->id > 0) {
            $this->ModificarVenta();
        } else {
            $this->InsertarVenta();
        }
    }

    public static function TraerVentas() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta(
            "SELECT v.id, v.tipo, u.nombre as idUsuario, v.nombreServicio, v.mbServicio, v.importe, v.fecha 
            FROM ventas v LEFT JOIN usuarios u on v.idUsuario = u.id ORDER BY v.fecha DESC");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Venta");
    }

    public static function TraerVenta($id) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta(
            "SELECT v.id, v.tipo, u.nombre as idUsuario, v.nombreServicio, v.mbServicio, v.importe, v.fecha 
            FROM ventas v LEFT JOIN usuarios u on v.idUsuario = u.id WHERE v.id = $id DESC");
        $consulta->execute();
        $ventaResultado= $consulta->fetchObject('Venta');
        return $ventaResultado;
    }

    public function toString() {
        return "Metodo mostar:".$this->tipo."  ".$this->idUsuario."  ".$this->nombreServicio;
    }
}