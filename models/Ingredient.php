<?php 

    class Ingredient{
        public $id;
        public $nombre;
        public $precio_extra;
        public $activo;

        public function getId(): int { return (int) $this->id; }
        public function getName(): string { return (string) $this->nombre; }
        public function getPrice(): float { return (float) $this->precio_extra; }
        public function isActive(): bool { return (bool) $this->activo; }
        }