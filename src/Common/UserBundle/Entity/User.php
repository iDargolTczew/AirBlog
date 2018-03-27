<?php

namespace Common\UserBundle\Entity;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass = "Common\UserBundle\Repository\UserRepository")
 * @ORM\Table(name = "users")
 */
class User implements AdvancedUserInterface, \Serializable {
    
    /**
     * @ORM\Column(type = "integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type = "string", length = 20, unique = true)
     */
    private $username;
    
    /**
     * @ORM\Column(type = "string", length = 120, unique = true)
     */
    private $email;
    
    /**
     * @ORM\Column(type = "string", length = 64)
     */
    private $password;
    
    private $plainPassword;
    
    /**
     * @ORM\Column(name = "account_not_expired", type = "boolean")
     */
    private $accountNotExpired = true;
    
    /**
     * @ORM\Column(name = "account_not_locked", type = "boolean")
     */
    private $accountNotLocked = true;
    
    /**
     * @ORM\Column(name = "credentials_non_expired", type = "boolean")
     */
    private $credentialsNonExpired = true;
    
    /**
     * @ORM\Column(type = "boolean")
     */
    private $enabled = false;
    
    /**
     * @ORM\Column(type = "array")
     */
    private $roles;
    
    /**
     * @ORM\Column(name = "action_token", type = "string", length = 20, nullable = true)
     */
    private $actionToken;
    
    /**
     * @ORM\Column(name = "register_date", type = "datetime")
     */
    private $registerDate;
    
    /**
     * @ORM\Column(type = "string", length = 100, nullable = true)
     */
    private $avatar;
    
    public function eraseCredentials() {
        $this->plainPassword = null;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getRoles() {
        return $this->roles;
    }

    public function getSalt() {
        return null;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function isAccountNonExpired(): bool {
        return $this->accountNotExpired;
    }

    public function isAccountNonLocked(): bool {
        return $this->accountNotLocked;
    }

    public function isCredentialsNonExpired(): bool {
        return $this->credentialsNonExpired;
    }

    public function isEnabled(): bool {
        return $this->enabled;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set accountNotExpired
     *
     * @param boolean $accountNotExpired
     *
     * @return User
     */
    public function setAccountNotExpired($accountNotExpired)
    {
        $this->accountNotExpired = $accountNotExpired;

        return $this;
    }

    /**
     * Get accountNotExpired
     *
     * @return boolean
     */
    public function getAccountNotExpired()
    {
        return $this->accountNotExpired;
    }

    /**
     * Set accountNotLocked
     *
     * @param boolean $accountNotLocked
     *
     * @return User
     */
    public function setAccountNotLocked($accountNotLocked)
    {
        $this->accountNotLocked = $accountNotLocked;

        return $this;
    }

    /**
     * Get accountNotLocked
     *
     * @return boolean
     */
    public function getAccountNotLocked()
    {
        return $this->accountNotLocked;
    }

    /**
     * Set credentialsNonExpired
     *
     * @param boolean $credentialsNonExpired
     *
     * @return User
     */
    public function setCredentialsNonExpired($credentialsNonExpired)
    {
        $this->credentialsNonExpired = $credentialsNonExpired;

        return $this;
    }

    /**
     * Get credentialsNonExpired
     *
     * @return boolean
     */
    public function getCredentialsNonExpired()
    {
        return $this->credentialsNonExpired;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Set actionToken
     *
     * @param string $actionToken
     *
     * @return User
     */
    public function setActionToken($actionToken)
    {
        $this->actionToken = $actionToken;

        return $this;
    }

    /**
     * Get actionToken
     *
     * @return string
     */
    public function getActionToken()
    {
        return $this->actionToken;
    }

    /**
     * Set registerDate
     *
     * @param \DateTime $registerDate
     *
     * @return User
     */
    public function setRegisterDate($registerDate)
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    /**
     * Get registerDate
     *
     * @return \DateTime
     */
    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function serialize(): string {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password
        ));
    }

    public function unserialize(string $serialized): void {
        list(
                $this->id,
                $this->username,
                $this->password
                ) = unserialize($serialized) ;
    }

}
