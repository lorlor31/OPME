<?php

namespace App\DataFixtures;

use DateTime;

$now= new DateTime('now');


class AppProvider
{
// Embroideries properties
private $embroideryName = [
    'Tapisserie Royale',
    'Broderie Élégance',
    'Esquisse Enchantée',
    'Charme de la Broderie',
    'Couture Couronnée',
    'Fil de la Noblesse',
    'Broderie Impériale',
    'Délice Dentelle',
];

private $embroideryDesign = [
    'Chaton',
    'Chiot',
    'Souris',
    'Ballon',
    'Pokémon',
    'Star Wars',
    'Dr Who',
    'X-Men',
];

// Textile properties

    private $textileName = [
        'JO forever blue',
        'Just Married pink',
        'Free Hugs yellow',
        'USA NYC soccer team '
    ];

    private $textileType = [
        'casquette',
        'tee-shirt',
        'serviette',
        'torchon'
    ];

    private $textileSize = [
        'S',
        'M',
        'L',
        'XL'
    ];

    private $textileColor = [
        'blanc',
        'bleu',
        'noir',
        'rose'
    ];

    private $textileBrand = [
        'nike',
        'adidas',
        'damart',
        'pimkie'
    ];

    private $textileComment = [
        'Difficile à coudre',
        'Déteint à plus de 40]',
        'Rétrécit',
        'Ne pas repasser'
    ];

// Customer properties

    private $customerName = [
        'Eva Adroite',
        'Fayis Lavoile',
        'Laurent Outan',
        'Théophile Entrope',
        'Laure Dinateur'
    ] ;

    private $customerAddress = [
        '1 rue de la pique',
        '21 rue de la noix',
        '321 rue des lampions',
        '4514 rue Descars',
        '56455 allée Machine'
    ] ;

    private $customerEmail = [
        'eva@free.fr',
        'fayis@free.fr',
        'laurent@free.fr',
        'theophile@free.fr',
        'laure@free.fr'
    ] ;

    private $customerContact = [
        'Mrs Chen',
        'Mr Show',
        'Miss Lam',
        'Mr Fong',
        'Mrs Tam'
    ] ;

    private $customerPhoneNumber = [
        '0143567564',
        '0678956723',
        '0567453412',
        '0952345423',
        '0832123423'
    ] ;

// Contract properties

private $contractType = [
    'quotation',
    'order',
    'invoice',
] ;

private $contractDeliveryAddress = [
    '34 av du chiot',
    '2 rue de la fontaine',
    '67 av de la mairie',
    '89 route de la forêt',
    '65 chemin de ruine',
] ;

private $contractStatus = [
    'created',
    'archived',
    'obsolete',
    'deleted'
] ;

private $contractComment = [
    'Je veux un chiot dessiné sur la casquette',
    'Expédié en bateau',
    'Ne pas joindre la facture au colis',
    'Cadeau pour ma femme',
] ;

// User properties

// private $userPseudo = [
//     'kuro',
//     'lor'
// ] ;
// private $userPassword = [
//     '$2y$13$3FZqOJQ8VOtAvjNrg8FOY.wvEJgzsRta2niyi654KMWh2FcYMMSFy',
//     '$2y$13$GL.xtZfB1ana9rFittdBWerUEgspWwaiU7IYQaf5qi/swjG9MaAM.'
// ] ;
// private $userRole = [
//     'ROLE_ADMIN',
//     'ROLE_USER'
// ] ;

// Product properties

private $productName = [
    'casquette jo 2024',
    'tee shirt fleuri paillettes',
    'canard en plastique'
] ;
private $productComment = [
    'très fragile',
    'très moche',
    'interdit aux chiens'
] ;


//ne pas faire les dates, ne pas faire les codes (clé étrangère)


public function getEmbroideryName()
    {
        return $this->embroideryName;
    }

    public function getEmbroideryDesign()
    {
        return $this->embroideryDesign;
    }

    public function getTextileName()
    {
        return $this->textileName;
    }

    public function getTextileType()
    {
        return $this->textileType;
    }

    public function getTextileColor()
    {
        return $this->textileColor;
    }

    public function getTextileSize()
    {
        return $this->textileSize;
    }

    public function getTextileBrand()
    {
        return $this->textileBrand;
    }

    public function getTextileComment()
    {
        return $this->textileComment;
    }

    public function getCustomerName()
    {
        return $this->customerName;
    }

    public function getCustomerAddress()
    {
        return $this->customerAddress;
    }

    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    public function getCustomerContact()
    {
        return $this->customerContact;
    }

    public function getCustomerPhoneNumber()
    {
        return $this->customerPhoneNumber;
    }
    public function getContractType()
    {
        return $this->contractType;
    }

    public function getContractDeliveryAddress()
    {
        return $this->contractDeliveryAddress;
    }

    public function getContractStatus()
    {
        return $this->contractStatus;
    }

    public function getContractComment()
    {
        return $this->contractComment;
    }

    public function getUserPseudo()
    {
        return $this->userPseudo;
    }

    public function getUserPassword()
    {
        return $this->userPassword;
    }

    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * Get the value of productName
     */ 
    public function getProductName()
    {
    return $this->productName;
    }

    /**
     * Get the value of productComment
     */ 
    public function getProductComment()
    {
    return $this->productComment;
    }
    
}

   
    


// TODO fixture de la updated date
