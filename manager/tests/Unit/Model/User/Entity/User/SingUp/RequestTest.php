<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\User\Entity\User\SingUp;

use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Phone;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testSuccess(): void
    {
        // $user = new User(
        //     $id = Id::next(),
        //     $date = new \DateTimeImmutable(),
        //     $phone = new Phone('+375291234567'),
        //     $hash = 'hash'
        // );
        $user = User::signUpByPhone(
            $id = Id::next(),
            $date = new \DateTimeImmutable(),
            // $name = new Name('First', 'Last'),
            $phone = new Phone('test@app.test'),
            $hash = 'hash',
            $token = 'token'
        );

        $user->confirmSignUp();

        // $this->flusher->flush();
        
        self::assertEquals($phone, $user->getPhone());
        self::assertEquals($hash, $user->getPasswordHash());

        self::assertEquals($id, $user->getId());
        self::assertEquals($date, $user->getDate());
        self::assertEquals($phone, $user->getPhone());
        self::assertEquals($hash, $user->getPasswordHash());
    }
}