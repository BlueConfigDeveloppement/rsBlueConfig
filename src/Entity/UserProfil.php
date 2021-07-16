<?php

namespace App\Entity;

use App\Repository\UserProfilRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // Gestion Slug et Timestamp
use Serializable;
use Symfony\Component\HttpFoundation\File\File; // Gestion téléchargement Fichiers
use Symfony\Component\HttpFoundation\File\UploadedFile; // Gestion téléchargement Fichiers
use Vich\UploaderBundle\Entity\File as EmbeddedFile; // Gestion téléchargement Fichiers
use Vich\UploaderBundle\Mapping\Annotation as Vich; // Gestion téléchargement Fichiers

/**
 * @ORM\Entity(repositoryClass=UserProfilRepository::class)
 * @Vich\Uploadable
 */
class UserProfil implements  Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="userProfil", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $firstname;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cellphone;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $naissanceAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @Vich\UploadableField(mapping="avatar_profil", fileNameProperty="avatar")
     * @var File
     */
    private $imageFile;



    /**
     * @var \DateTime $created_at
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime $updated_at
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;


    private $fullName;

    private $age;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = strtoupper($lastname);

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = ucfirst(strtolower($firstname));

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCellphone(): ?int
    {
        return $this->cellphone;
    }

    public function setCellphone(?int $cellphone): self
    {
        $this->cellphone = $cellphone;

        return $this;
    }

    public function getNaissanceAt(): ?\DateTimeInterface
    {
        return $this->naissanceAt;
    }

    public function setNaissanceAt(?\DateTimeInterface $naissanceAt): self
    {
        $this->naissanceAt = $naissanceAt;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(?int $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    // Dans les Getters/setters Avatar
    public function setImageFile(File $avatar = null)
    {
        $this->imageFile = $avatar;

        if ($avatar) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function serialize()
    {
        $this->avatar = base64_encode($this->imageFile);
    }

    public function unserialize($serialized)
    {
        $this->avatar = base64_decode($this->imageFile);
    }

    // getAge() outputs something like this: '1 years, 1 months, 8 days old.'
    public function getAge(): string
    {
        if($this->getNaissanceAt()) {
            $now = new DateTime('now');
            $age = $this->getNaissanceAt();
            $difference = $now->diff($age);
            $annee = $difference->format('%y');
            $mois =  $difference->format('%m');
            $jour = $difference->format('%m');
            $age = null;
            if($annee > 0){
                $age = $annee.' Ans, ';
            }
            if($mois > 0){
                $age .= $mois.' Mois, ';
            }
            if($jour > 0){
                $age .= $jour.' Jours';
            }
            return $age;
        }else{
            return 'Age non calculé';
        }
    }

    // FullName
    public function getFullName(){
        $str = $this->getGender().' '.$this->getLastname().' '.$this->getFirstname();
        return $str;
    }
}
