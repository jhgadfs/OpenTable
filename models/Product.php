<?php

class Product
{
    public $id;
    public $categoria_id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $imagen;
    public $activo;
    public $categoria;

    public function getId(): int { return (int) $this->id; }
    public function getCategoryId(): int { return (int) $this->categoria_id; }
    public function getName(): string { return (string) $this->nombre; }
    public function getDescription(): string { return (string) ($this->descripcion ?? ''); }
    public function getPrice(): float { return (float) $this->precio; }
    public function getImage(): ?string { return $this->imagen; }
    public function getCategory(): string { return (string) $this->categoria; }
}
