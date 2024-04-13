<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Builder\Enum_;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[Groups(['contract'])]
#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
{
    #[Groups(['contractLinked','contractLinkedId'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['contractLinked'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]  
    #[ORM\Column(length: 100)]
    #[Assert\ExpressionSyntax(
        allowedVariables: ['quotation', 'order','invoice'],
        message : 'You should provide a valid type of contract ! '
    )]
    // TODO : wait till it's ok to create in db
    private ?string $type = 'quotation';

    #[Groups(['contractLinked'])]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $ordered_at = null;

    #[Groups(['contractLinked'])]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $invoiced_at = null;

    #[Groups(['contractLinked'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 500)]  
    #[ORM\Column(length: 500)]
    private ?string $delivery_address = null;

    #[Groups(['contractLinked'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]  
    #[ORM\Column(length: 100)]
    #[Assert\ExpressionSyntax(
        allowedVariables: ['created','archived','obsolete','deleted'],
        message : 'You should provide a valid status for the contract ! '
    )]
    private ?string $status = 'created';

    #[Groups(['contractLinked'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[Groups(['contractLinked'])]
    #[Assert\NotBlank]
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $created_at = null;

    #[Groups(['contractLinked'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'contracts', cascade: ['persist'],fetch : 'EAGER')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'contracts', cascade: ['persist'],fetch : 'EAGER')]
    // #[ORM\ManyToOne(inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    // #[Groups(['contractproductLinked'])]
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'contract',  orphanRemoval: true, cascade: ['persist'])]
    // #[ORM\OneToMany(targetEntity: Product::class, mappedBy:  orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getOrderedAt(): ?\DateTimeInterface
    {
        return $this->ordered_at;
    }

    public function setOrderedAt(?\DateTimeInterface $ordered_at): static
    {
        $this->ordered_at = $ordered_at;

        return $this;
    }

    public function getInvoicedAt(): ?\DateTimeInterface
    {
        return $this->invoiced_at;
    }

    public function setInvoicedAt(?\DateTimeInterface $invoiced_at): static
    {
        $this->invoiced_at = $invoiced_at;

        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->delivery_address;
    }

    public function setDeliveryAddress(string $delivery_address): static
    {
        $this->delivery_address = $delivery_address;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setContract($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getContract() === $this) {
                $product->setContract(null);
            }
        }

        return $this;
    }
}
