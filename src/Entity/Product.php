<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[Groups(['product'])]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]

class Product
{
    #[Groups(['contract','productLinked','productLinkedId'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['productLinked'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]  
    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[Groups(['productLinked'])]
    #[Assert\NotBlank]
    // TODO check with the product owner the min max quantities
    #[ORM\Column]
    private ?int $quantity = null;

    #[Groups(['productLinked'])]
    #[Assert\NotBlank]
    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?float $price = null;

    #[Groups(['productLinked'])]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $delivery_at = null;

    #[Groups(['productLinked'])]
    #[Assert\NotBlank]
    #[Assert\Positive]
    // TODO check with the product owner the min max delays
    #[ORM\Column]
    private ?int $manufacturing_delay = null;

    #[Groups(['productLinked'])]
    #[Assert\NotBlank]
    // TODO check with the product owner the min max product_order
    #[ORM\Column()]
    private ?int $product_order = null;

    #[Groups(['productLinked'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[Groups(['productLinked'])]
    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Assert\type(Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $created_at = null;

    #[Groups(['productLinked'])]
    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'],nullable: true)]
    #[Assert\type(Types::DATE_MUTABLE ,nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[Groups(['contractLinkedId'])]
    // #[ORM\ManyToOne(inversedBy: 'products',cascade: [])]
    #[ORM\ManyToOne(inversedBy: 'products', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Contract $contract = null;

    // #[ORM\ManyToOne(inversedBy: 'products', cascade: ['persist'])]
    #[Groups(['textileLinkedId','contractTextile','productTextileLinkedId'])]
    #[ORM\ManyToOne(inversedBy: 'products',cascade: ['persist'],fetch : 'EAGER')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Textile $textile = null;

    // #[ORM\ManyToOne(inversedBy: 'products', cascade: ['persist'])]
    #[Groups(['productLinkedId','contractEmbroidery','productEmbroideryLinkedId'])]
    #[ORM\ManyToOne(inversedBy: 'products', cascade: ['persist'], fetch : 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Embroidery $embroidery = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDeliveryAt(): ?\DateTimeInterface
    {
        return $this->delivery_at;
    }

    public function setDeliveryAt(?\DateTimeInterface $delivery_at): static
    {
        $this->delivery_at = $delivery_at;

        return $this;
    }

    public function getManufacturingDelay(): ?int
    {
        return $this->manufacturing_delay;
    }

    public function setManufacturingDelay(int $manufacturing_delay): static
    {
        $this->manufacturing_delay = $manufacturing_delay;

        return $this;
    }

    public function getProductOrder(): ?int
    {
        return $this->product_order;
    }

    public function setProductOrder(int $product_order): static
    {
        $this->product_order = $product_order;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        $this->created_at = new \DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt(): static
    {
        $this->updated_at = new \DateTimeImmutable();

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): static
    {
        $this->contract = $contract;

        return $this;
    }

    public function getTextile(): ?Textile
    {
        return $this->textile;
    }

    public function setTextile(?Textile $textile): static
    {
        $this->textile = $textile;

        return $this;
    }

    public function getEmbroidery(): ?Embroidery
    {
        return $this->embroidery;
    }

    public function setEmbroidery(?Embroidery $embroidery): static
    {
        $this->embroidery = $embroidery;

        return $this;
    }
}
