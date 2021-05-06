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
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=SuperAdmin::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $adminUser;

    private $users;

    public function __construct(
        $users,
        \DateTimeInterface $expiresAt,
        string $selector,
        string $hashedToken
    ) {
        $this->users = $users;
        $this->initialize($expiresAt, $selector, $hashedToken);
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): object
    {
        return $this->user;
    }
    public function getAdminUser(): object
    {
        return $this->adminUser;
    }

    public function getUsers(): array
    {
        return [$this->adminUser, $this->user];
    }
}