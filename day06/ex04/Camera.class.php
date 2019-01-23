<?php

require_once 'Camera.class.php';
class Camera
{
    public static $verbose = false;
    private $_origin;
    private $_orientation;
    private $_width;
    private $_height;
    private $_ratio;
    private $_fov;
    private $_near;
    private $_far;
    private $_proj;
    private $_tT;

    public static function doc() {
        return (file_get_contents('Camera.doc.txt'));
    }
    function __toString() {
        $temp = "Camera( \n";
        $temp .= "+ Origine: ".$this->_origin."\n";
        $temp .= "+ tT:\n".$this->_tT."\n";
        $temp .= "+ tR:\n".$this->_orientation."\n";
        $temp .= "+ tR->mult( tT ):\n".$this->_orientation->mult($this->_tT)."\n";
        $temp .= "+ Proj:\n".$this->_proj."\n)";
        return ($temp);
    }
    private function _transformation(Matrix $m) {
        $temp[0] = $m->matrix[0];
        $temp[1] = $m->matrix[4];
        $temp[2] = $m->matrix[8];
        $temp[3] = $m->matrix[12];
        $temp[4] = $m->matrix[1];
        $temp[5] = $m->matrix[5];
        $temp[6] = $m->matrix[9];
        $temp[7] = $m->matrix[13];
        $temp[8] = $m->matrix[2];
        $temp[9] = $m->matrix[6];
        $temp[10] = $m->matrix[10];
        $temp[11] = $m->matrix[14];
        $temp[12] = $m->matrix[3];
        $temp[13] = $m->matrix[7];
        $temp[14] = $m->matrix[11];
        $temp[15] = $m->matrix[15];
        $m->matrix = $temp;
        return ($m);
    }
    public function __construct($arr) {
        $this->_origin = $arr['origin'];
        $this->_tT = new Matrix(array('preset' => Matrix::TRANSLATION, 'vtc' => $this->_origin->opposite()));
        $this->_orientation = $this->_transformation($arr['orientation']);
        $this->_width = (float)$arr['width'] / 2;
        $this->_height = (float)$arr['height'] / 2;
        $this->_ratio = $this->_width / $this->_height;
        if (isset($arr['fov'])) {
            $this->_fov = $arr['fov'];
        }
        if (isset($arr['near'])) {
            $this->_near = $arr['near'];
        }
        if (isset($arr['far'])) {
            $this->_far = $arr['far'];
        }
        $this->_proj = new Matrix(array('preset' => Matrix::PROJECTION, 'fov' => $this->_fov, 'ratio' => $this->_ratio, 'near' => $this->_near, 'far' => $this->_far));
        if (self::$verbose == true) {
            echo "Camera instance constructed\n";
        }
    }
    function __destruct() {
        if (self::$verbose == true)
            echo "Camera instance destructed\n";
    }
    public function watchVertex(Vertex $worldVertex) {
        $vtx = $this->_proj->transformVertex($this->_orientation->transformVertex($worldVertex));
        $vtx->setX($vtx->getX() * $this->_ratio);
        $vtx->setY($vtx->getY());
        $vtx->setColor($worldVertex->getColor());
        return ($vtx);
    }
}

?>
