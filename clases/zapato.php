<?php
class Zapato
{
    public $id;
    public $codigo;
    public $nombre;
    public $localVenta;
    public $genero;
    public $precioCosto;
    public $fechaIngreso;
    
    public function GetCodigo() {
        return $this->codigo;
    }
    public function GetNombre() {
        return $this->nombre;
    }
    public function GetLocalVenta() {
        return $this->localVenta;
    }
    public function GetGenero() {
        return $this->genero;
    }
    public function GetPrecioCosto() {
        return $this->fechaIngreso;
    }
    public function GetFecha() {
        return $this->fechaIngreso;
    }

    public function SetCodigo($value) {
        $this->codigo = $value;
    }
    public function SetNombre($value) {
        $this->nombre = $value;
    }
    public function SetLocalVenta($value) {
        $this->localVenta = $value;
    }
    public function SetGenero($value) {
        $this->genero = $value;
    }
    public function SetPrecioCosto($value) {
        $this->fechaIngreso = $value;
    }
    public function SetFecha($value) {
        $this->fechaIngreso = $value;
    }
    
    public function BorrarZapato() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            delete from zapatos WHERE id=$this->id");
        $consulta->execute();

        return $consulta->rowCount();
    }

    public function ModificarZapato() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            update zapatos 
            set codigo='$this->codigo',
            localVenta=$this->localVenta,
            genero='$this->genero',
            nombre='$this->nombre',
            precioCosto=$this->precioCosto,
            fechaIngreso='$this->fechaIngreso'
            WHERE id=$this->id");
        return $consulta->execute();
    }

    public function InsertarZapato() {
        $datetime_now = date("Y-m-d H:i:s");
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into zapatos
        (codigo,nombre,localVenta,genero,precioCosto,fechaIngreso)values
        ('$this->codigo','$this->nombre',$this->localVenta,'$this->genero',$this->precioCosto,'$datetime_now')"
        );
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function GuardarZapato() {
        if ($this->id > 0) {
            $this->ModificarZapato();
        } else {
            $this->InsertarZapato();
        }
    }

    public static function TraerZapatos() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta(
            "SELECT v.id, v.codigo, u.nombre as nombre, v.localVenta, v.genero, v.precioCosto, v.fechaIngreso 
            FROM zapatos v LEFT JOIN usuarios u on v.nombre = u.id ORDER BY v.fechaIngreso DESC");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Zapato");
    }

    public static function TraerZapato($id) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta(
            "SELECT v.id, v.codigo, u.nombre as nombre, v.localVenta, v.genero, v.precioCosto, v.fechaIngreso 
            FROM zapatos v LEFT JOIN usuarios u on v.nombre = u.id WHERE v.id = $id DESC");
        $consulta->execute();
        $zapatoResultado= $consulta->fetchObject('Zapato');
        return $zapatoResultado;
    }

    public function toString() {
        return "Metodo mostar:".$this->codigo."  ".$this->nombre."  ".$this->localVenta;
    }
}