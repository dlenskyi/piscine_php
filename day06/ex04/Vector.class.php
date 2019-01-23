<?php

require_once('Color.class.php');

Class Vector {
    public static $verbose = false;
    private $_x;
    private $_y;
    private $_z;
    private $_w = 0;
    public $matrix = array();

    public static function doc() {
        return (file_get_contents('Vector.doc.txt'));
    }
    function __toString() {
        return (vsprintf("Vector( x:%0.2f, y:%0.2f, z:%0.2f, w:%0.2f )", array($this->_x, $this->_y, $this->_z, $this->_w)));
    }
    public function getX() {
        return ($this->_x);
    }
    public function getY() {
        return ($this->_y);
    }
    public function getZ() {
        return ($this->_z);
    }
    public function getW() {
        return ($this->_w);
    }
    function __construct($arr)
    {
        if (isset($arr['dest']) && $arr['dest'] instanceof Vertex) {
            if (isset($arr['orig']) && $arr['orig'] instanceof Vertex) {
                $orig = new Vertex(array('x' => $arr['orig']->getX(), 'y' => $arr['orig']->getY(), 'z' => $arr['orig']->getZ()));
            } else {
                $orig = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0));
            }
            $this->_x = $arr['dest']->getX() - $orig->getX();
            $this->_y = $arr['dest']->getY() - $orig->getY();
            $this->_z = $arr['dest']->getZ() - $orig->getZ();
        }
        if (self::$verbose == true)
            printf("Vector( x:%0.2f, y:%0.2f, z:%0.2f, w:%0.2f ) constructed\n", $this->_x, $this->_y, $this->_z, $this->_w);
    }
    function __destruct() {
        if (self::$verbose == true) {
            printf("Vector( x:%0.2f, y:%0.2f, z:%0.2f, w:%0.2f ) destructed\n", $this->_x, $this->_y, $this->_z, $this->_w);
        }
    }
    public function magnitude() {
        return ((float)sqrt(($this->_x * $this->_x) + ($this->_y * $this->_y) + ($this->_z * $this->_z)));
    }
    public function normalize() {
        $normal = $this->magnitude();
        if ($normal == 1) {
            return (clone $this);
        }
        return (new Vector(array('dest' => new Vertex(array('x' => $this->_x / $normal, 'y' => $this->_y / $normal, 'z' => $this->_z / $normal)))));
    }
    public function add(Vector $rhs) {
        return (new Vector(array('dest' => new Vertex(array('x' => $this->_x + $rhs->_x, 'y' => $this->_y + $rhs->_y, 'z' => $this->_z + $rhs->_z)))));
    }
    public function sub(Vector $rhs) {
        return (new Vector(array('dest' => new Vertex(array('x' => $this->_x - $rhs->_x, 'y' => $this->_y - $rhs->_y, 'z' => $this->_z - $rhs->_z)))));
    }
    public function opposite() {
        return (new Vector(array('dest' => new Vertex(array('x' => $this->_x * (-1), 'y' => $this->_y * (-1), 'z' => $this->_z * (-1))))));
    }
    public function scalarProduct($k)
    {
        return new Vector(array('dest' => new Vertex(array('x' => $this->_x * $k, 'y' => $this->_y * $k, 'z' => $this->_z * $k))));
    }
    public function dotProduct(Vector $rhs) {
        return ((float)($this->_x * $rhs->_x) + ($this->_y * $rhs->_y) + ($this->_z * $rhs->_z));
    }
    public function cos(Vector $rhs) {
        return (((float)(($this->_x * $rhs->_x) + ($this->_y * $rhs->_y) + ($this->_z * $rhs->_z)) / sqrt((($this->_x * $this->_x) + ($this->_y * $this->_y) + ($this->_z * $this->_z)) * (($rhs->_x * $rhs->_x) + ($rhs->_y * $rhs->_y) + ($rhs->_z * $rhs->_z)))));
    }
    public function crossProduct(Vector $rhs) {
        return new Vector(array('dest' => new Vertex(array('x' => $this->_y * $rhs->getZ() - $this->_z * $rhs->getY(), 'y' => $this->_z * $rhs->getX() - $this->_x * $rhs->getZ(), 'z' => $this->_x * $rhs->getY() - $this->_y * $rhs->getX()))));
    }
    public function mult(Matrix $rhs) {
        $temp = array();
        for ($i = 0; $i < 16; $i += 4) {
            for ($j = 0; $j < 4; $j++) {
                $temp[$i + $j] = 0;
                $temp[$i + $j] += $this->matrix[$i + 0] * $rhs->matrix[$j + 0];
                $temp[$i + $j] += $this->matrix[$i + 1] * $rhs->matrix[$j + 4];
                $temp[$i + $j] += $this->matrix[$i + 2] * $rhs->matrix[$j + 8];
                $temp[$i + $j] += $this->matrix[$i + 3] * $rhs->matrix[$j + 12];
            }
        }
        $new_matrix = new Matrix();
        $new_matrix->matrix = $temp;
        return ($new_matrix);
    }
}

?>