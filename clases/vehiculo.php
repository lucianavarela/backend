<?php
class Vehiculo
{
    public $id;
    public $modelo;
    public $marca;
    public $cantidadPuertas;
    public $rutaDeFoto;
    
    public function GetModelo() {
        return $this->modelo;
    }
    public function GetMarca() {
        return $this->marca;
    }
    public function GetCantidadPuertas() {
        return $this->cantidadPuertas;
    }
    public function GetRutaDeFoto() {
        return $this->cantidadPuertas;
    }

    public function SetModelo($value) {
        $this->modelo = $value;
    }
    public function SetMarca($value) {
        $this->marca = $value;
    }
    public function SetCantidadPuertas($value) {
        $this->cantidadPuertas = $value;
    }
    public function SetRutaDeFoto($value) {
        $this->cantidadPuertas = $value;
    }
    
    public function BorrarVehiculo() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            delete
            from vehiculo
            WHERE id=$this->id");
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function ModificarVehiculo() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            update vehiculo 
            set modelo='$this->modelo',
            marca='$this->marca',
            cantidadPuertas=$this->cantidadPuertas,
            rutaDeFoto='$this->rutaDeFoto'
            WHERE id=$this->id;");
        return $consulta->execute();
    }

    public function InsertarVehiculo() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into vehiculo (modelo,marca,cantidadPuertas,rutaDeFoto) values('$this->modelo','$this->marca',$this->cantidadPuertas,'$this->rutaDeFoto')");
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function GuardarVehiculo() {
        if ($this->id > 0) {
            $this->ModificarVehiculo();
        } else {
            $this->InsertarVehiculo();
        }
    }

    public static function TraerVehiculos() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta(
            "SELECT * FROM vehiculo"
        );
        $consulta->execute();
        $vehiculos = $consulta->fetchAll(PDO::FETCH_CLASS, "Vehiculo");
        return $vehiculos;
    }

    public static function TraerVehiculo($id) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from vehiculo where id = $id");
        $consulta->execute();
        $vehiculoResultado= $consulta->fetchObject('Vehiculo');
        return $vehiculoResultado;
    }
}