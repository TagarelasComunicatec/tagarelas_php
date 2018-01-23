<?php
// src/AppBundle/Openfire/Produto.php

namespace AppBundle\Openfire;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tg_produto")
 * @ORM\HasLifecycleCallbacks()
 */
class Produto
{
	/**
	 * @var int
	 * @ORM\Id
	 * @ORM\Column(name= "id_produto" ,type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="codigo_produto", type="string", nullable=false, length=10)
	 */
	private $codigo;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="descricao_produto", type="string", nullable=false, length=100)
	 */
	private $descricao;
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param string $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

   
	
	
}