<?php

require_once ('Color.class.php');

Class Matrix {
    public static $verbose = false;
    const IDENTITY = "IDENTITY";
    const SCALE = "SCALE";
    const RX = "Ox ROTATION";
    const RY = "Oy ROTATION";
    const RZ = "Oz ROTATION";
    const TRANSLATION = "TRANSLATION";
    const PROJECTION = "PROJECTION";
    public $matrix = array();
    private $_preset;
    private $_scale;
    private $_angle;
    private $_vtc;
    private $_fov;
    private $_ratio;
    private $_near;
    private $_far;

    public static function doc() {
        return (file_get_contents('Matrix.doc.txt'));
    }
    function __toString() {
        $temp = "M | vtcX | vtcY | vtcZ | vtxO\n";
        $temp .= "-----------------------------\n";
        $temp .= "x | %0.2f | %0.2f | %0.2f | %0.2f\n";
        $temp .= "y | %0.2f | %0.2f | %0.2f | %0.2f\n";
        $temp .= "z | %0.2f | %0.2f | %0.2f | %0.2f\n";
        $temp .= "w | %0.2f | %0.2f | %0.2f | %0.2f";
        return (vsprintf($temp, array($this->matrix[0], $this->matrix[1], $this->matrix[2], $this->matrix[3], $this->matrix[4], $this->matrix[5], $this->matrix[6], $this->matrix[7], $this->matrix[8], $this->matrix[9], $this->matrix[10], $this->matrix[11], $this->matrix[12], $this->matrix[13], $this->matrix[14], $this->matrix[15])));
    }
    private function is_valid() {
        if (empty($this->_preset))
            return "error";
        if ($this->_preset == self::SCALE && empty($this->_scale))
            return "error";
        if (($this->_preset == self::RX || $this->_preset == self::RY || $this->_preset == self::RZ) && empty($this->_angle))
            return "error";
        if ($this->_preset == self::TRANSLATION && empty($this->_vtc))
            return "error";
        if ($this->_preset == self::PROJECTION && (empty($this->_fov) || empty($this->_radio) || empty($this->_near) || empty($this->_far)))
            return "error";
    }
    private function get_matrix() {
        for ($i = 0; $i < 16; $i++) {
            $this->matrix[$i] = 0;
        }
    }
    private function get_att_matrix() {
        if ($this->_preset == self::IDENTITY) {
            $this->identity(1);
        }
        else if ($this->_preset == self::SCALE) {
            $this->identity($this->_scale);
        }
        else if ($this->_preset == self::RX) {
            $this->rotate_x();
        }
        else if ($this->_preset == self::RY) {
            $this->rotate_y();
        }
        else if ($this->_preset == self::RZ) {
            $this->rotate_z();
        }
        else if ($this->_preset == self::TRANSLATION) {
            $this->translation();
        }
        else if ($this->_preset == self::PROJECTION) {
            $this->projection();
        }
    }
    private function identity($scale) {
        $this->matrix[0] = $scale;
        $this->matrix[5] = $scale;
        $this->matrix[10] = $scale;
        $this->matrix[15] = 1;
    }
    private function rotate_x() {
        $this->identity(1);
        $this->matrix[0] = 1;
        $this->matrix[5] = cos($this->_angle);
        $this->matrix[6] = -sin($this->_angle);
        $this->matrix[9] = sin($this->_angle);
        $this->matrix[10] = cos($this->_angle);
    }
    private function rotate_y() {
        $this->identity(1);
        $this->matrix[0] = cos($this->_angle);
        $this->matrix[2] = sin($this->_angle);
        $this->matrix[5] = 1;
        $this->matrix[8] = -sin($this->_angle);
        $this->matrix[10] = cos($this->_angle);
    }
    private function rotate_z() {
        $this->identity(1);
        $this->matrix[0] = cos($this->_angle);
        $this->matrix[1] = -sin($this->_angle);
        $this->matrix[4] = sin($this->_angle);
        $this->matrix[5] = cos($this->_angle);
        $this->matrix[10] = 1;
    }
    private function translation() {
        $this->identity(1);
        $this->matrix[3] = $this->_vtc->getX();
        $this->matrix[7] = $this->_vtc->getY();
        $this->matrix[11] = $this->_vtc->getZ();
    }
    private function projection() {
        $this->identity(1);
        $this->matrix[5] = 1 / tan(0.5 * deg2rad($this->_fov));
        $this->matrix[0] = $this->matrix[5] / $this->_ratio;
        $this->matrix[10] = -1 * (-$this->_near - $this->_far) / ($this->_near - $this->_far);
        $this->matrix[14] = -1;
        $this->matrix[11] = (2 * $this->_near * $this->_far) / ($this->_near - $this->_far);
        $this->matrix[15] = 0;
    }
    public function __construct($arr = null) {
        if (isset($arr)) {
            if (isset($arr['preset'])) {
                $this->_preset = $arr['preset'];
            }
            if (isset($arr['scale'])) {
                $this->_scale = $arr['scale'];
            }
            if (isset($arr['angle'])) {
                $this->_angle = $arr['angle'];
            }
            if (isset($arr['vtc'])) {
                $this->_vtc = $arr['vtc'];
            }
            if (isset($arr['fov'])) {
                $this->_fov = $arr['fov'];
            }
            if (isset($arr['ratio'])) {
                $this->_ratio = $arr['ratio'];
            }
            if (isset($arr['near'])) {
                $this->_near = $arr['near'];
            }
            if (isset($arr['far'])) {
                $this->_far = $arr['far'];
            }
            $this->is_valid();
            $this->get_matrix();
            if (self::$verbose == true) {
                if ($this->_preset == self::IDENTITY) {
                    echo "Matrix ".$this->_preset." instance constructed\n";
                } else {
                    echo "Matrix ".$this->_preset." preset instance constructed\n";
                }
            }
            $this->get_att_matrix();
        }
    }
    function __destruct() {
        if (self::$verbose == true) {
            printf("Matrix instance destructed\n");
        }
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
    public function transformVertex(Vertex $vtx) {
        $temp = array();
        $temp['x'] = ($vtx->getX() * $this->matrix[0]) + ($vtx->getY() * $this->matrix[1]) + ($vtx->getZ() * $this->matrix[2]) + ($vtx->getW() * $this->matrix[3]);
        $temp['y'] = ($vtx->getX() * $this->matrix[4]) + ($vtx->getY() * $this->matrix[5]) + ($vtx->getZ() * $this->matrix[6]) + ($vtx->getW() * $this->matrix[7]);
        $temp['z'] = ($vtx->getX() * $this->matrix[8]) + ($vtx->getY() * $this->matrix[9]) + ($vtx->getZ() * $this->matrix[10]) + ($vtx->getW() * $this->matrix[11]);
        $temp['w'] = ($vtx->getX() * $this->matrix[11]) + ($vtx->getY() * $this->matrix[13]) + ($vtx->getZ() * $this->matrix[14]) + ($vtx->getW() * $this->matrix[15]);
        $temp['color'] = $vtx->getColor();
        $new_vertex = new Vertex($temp);
        return ($new_vertex);
    }
    public function opposite() {
        return (new Vector(array('dest' => new Vertex(array('x' => $this->_x * (-1), 'y' => $this->_y * (-1), 'z' => $this->_z * (-1))))));
    }
}

?>