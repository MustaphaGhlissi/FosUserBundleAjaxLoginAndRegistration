<?php
/**
 * Created by PhpStorm.
 * User: ODevS-Inc
 * Date: 9/22/2017
 * Time: 3:23 PM
 */

namespace AuthBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class FicheClient
 *
 * @ORM\Entity
 * @ORM\Table(name="fiche_client")
 * @ORM\Entity(repositoryClass="AuthBundle\Repository\FicheClientRepository")
 */
class FicheClient
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    protected $address;

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", nullable=true)
     */
    protected $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    protected $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    protected $country;

    //Résas

    //Factures

    //Paiements

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return FicheClient
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return FicheClient
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address2
     *
     * @param string $address2
     *
     * @return FicheClient
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set zip
     *
     * @param string $zip
     *
     * @return FicheClient
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return FicheClient
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return FicheClient
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
}
