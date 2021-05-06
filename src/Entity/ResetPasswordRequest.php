<?php

namespace App\Entity;

use App\Repository\ResetPasswordRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;

/**
 * @ORM\Entity(repositoryClass=ResetPasswordRequestRepository::class)
 */
class ResetPasswordRequest implements ResetPasswordRequestInterface
{
    use ResetPasswordRequestTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=AdhesionBibliotheque::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=SuperAdmin::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $adminUser;

    public function __construct(
        object $user,
        \DateTimeInterface $expiresAt,
        string $selector,
        string $hashedToken
    ) {
        switch (get_class($user)) {
            case AdhesionBibliotheque::class:
                $this->user = $user;
                break;
            case SuperAdmin::class:
                $this->adminUser = $user;
                break;
        }
        $this->initialize($expiresAt, $selector, $hashedToken);
    }

    public function getUser(): object
    {
        if ($this->user != null) {
            return $this->user;
        }
        if ($this->adminUser != null) {
            return $this->adminUser;
        }
    }
}