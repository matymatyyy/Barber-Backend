<?php 

namespace Src\Entity\Client;

use DateTime;

final class Client {

    public function __construct(
        private readonly ?int $id,
        private string $name,
        private string $email,
        private string $password,
        private int $dni,
        private string $cellphone,
        private ?string $token,
        private ?DateTime $tokenAuthDate
    ) {
    }

    public static function create(
        string $name, 
        string $email, 
        string $password, 
        int $dni, 
        string $cellphone): self
    {
        return new self(
            null, 
            $name, 
            $email, 
            password_hash($password, PASSWORD_BCRYPT), 
            $dni, 
            $cellphone, 
            null, 
            null);
    } 
    public function modify(
        string $name, 
        string $email, 
        string $password, 
        int $dni, 
        string $cellphone): void
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->dni = $dni;
        $this->cellphone = $cellphone;
    } 

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
    public function dni(): int
    {
        return $this->dni;
    }
    public function cellphone(): string
    {
        return $this->cellphone;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function tokenAuthDate(): ?DateTime
    {
        return $this->tokenAuthDate;
    }

    public function generateToken(): void
    {
        $this->token = md5($this->id."-".$this->email.rand(1000, 9999).date("YmdHis"));
        $this->tokenAuthDate = new DateTime("+1 hours");
    }
}