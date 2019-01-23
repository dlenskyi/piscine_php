<?php

Class Targaryen {
    public function getBurned() {
        if (method_exists($this, 'resistsFire') &&
            ($this->resistsFire() == true)) {
            return ("emerges naked but unharmed");
        }
        return ("burns alive");
    }
}

?>