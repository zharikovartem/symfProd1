<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\SingUp\Request;

use App\Model\Flusher;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Phone;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\Service\PasswordHasher;

class Hendler
{
    
    private $userRepository;
    private $hasher;
    private $flusher;

    public function __construct(UserRepository $userRepository, PasswordHasher $hasher, Flusher $flusher)
    {
        $this->UserRepository = $userRepository;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $phone = new Phone($command->phone);

        if ($this->UserRepository->hasByPhone($phone)) {
            throw new \DomainException('User alredy exist.');
        }

        $user = new User(
            Id::next(),
            new \DateTimeImmutable(),
            // new Name(
            //     $command->firstName,
            //     $command->lastName
            // ),
            $phone,
            $this->hashar->hash($command->password),
            // $token = $this->tokenizer->generate()
        );

        $this->UserRepository->add($user);

        //  $this->em->persist($user);
        //  $this->em->flush();
    }
}
