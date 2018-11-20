<?php
class Helado
{
    public $id;
    public $sabor;
    public $tipo;
    public $kilos;
    public $foto;
    
    public function GetSabor() {
        return $this->sabor;
    }
    public function GetTipo() {
        return $this->tipo;
    }
    public function GetKilos() {
        return $this->kilos;
    }
    public function GetFoto() {
        return $this->kilos;
    }

    public function SetSabor($value) {
        $this->sabor = $value;
    }
    public function SetTipo($value) {
        $this->tipo = $value;
    }
    public function SetKilos($value) {
        $this->kilos = $value;
    }
    public function SetFoto($value) {
        $this->kilos = $value;
    }
    
    public function BorrarHelado() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            delete
            from helado
            WHERE id=$this->id");
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function ModificarHelado() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            update helado 
            set sabor='$this->sabor',
            tipo='$this->tipo',
            kilos=$this->kilos,
            foto='$this->foto'
            WHERE id=$this->id;");
        return $consulta->execute();
    }

    public function InsertarHelado() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into helado (sabor,tipo,kilos,foto) values('$this->sabor','$this->tipo',$this->kilos,'$this->foto')");
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function GuardarHelado() {
        if ($this->id > 0) {
            $this->ModificarHelado();
        } else {
            $this->InsertarHelado();
        }
    }

    public static function TraerHelados() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta(
            "SELECT * FROM helado"
        );
        $consulta->execute();
        $helados = $consulta->fetchAll(PDO::FETCH_CLASS, "Helado");
        return $helados;
    }

    public static function TraerHelado($id) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from helado where id = $id");
        $consulta->execute();
        $heladoResultado= $consulta->fetchObject('Helado');
        return $heladoResultado;
    }
}