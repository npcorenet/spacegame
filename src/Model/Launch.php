<?php declare(strict_types=1);

namespace App\Model;

use DateTime;

class Launch
{

    protected int $id;
    protected int $user;
    protected int $vehicle;
    protected int $satellite;
    protected int $contract;
    protected DateTime $targetTime;
    protected DateTime $liftoff;
    protected bool $complete;
    protected bool $success;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUser(): int
    {
        return $this->user;
    }

    public function setUser(int $user): void
    {
        $this->user = $user;
    }

    public function getVehicle(): int
    {
        return $this->vehicle;
    }

    public function setVehicle(int $vehicle): void
    {
        $this->vehicle = $vehicle;
    }

    public function getSatellite(): int
    {
        return $this->satellite;
    }

    public function setSatellite(int $satellite): void
    {
        $this->satellite = $satellite;
    }

    public function getContract(): int
    {
        return $this->contract;
    }

    public function setContract(int $contract): void
    {
        $this->contract = $contract;
    }

    public function getTargetTime(): DateTime
    {
        return $this->targetTime;
    }

    public function setTargetTime(DateTime $targetTime): void
    {
        $this->targetTime = $targetTime;
    }

    public function getLiftoff(): DateTime
    {
        return $this->liftoff;
    }

    public function setLiftoff(DateTime $liftoff): void
    {
        $this->liftoff = $liftoff;
    }

    public function isComplete(): bool
    {
        return $this->complete;
    }

    public function setComplete(bool $complete): void
    {
        $this->complete = $complete;
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

}