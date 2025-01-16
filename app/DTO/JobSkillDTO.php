<?php

namespace App\DTO;

class JobSkillDTO
{
    public function __construct(private string $skill, private bool $isRequired = false)
    {
    }

    public function getSkill(): string
    {
        return $this->skill;
    }

    public function isRequired(): bool
    {
        return $this->isRequired;
    }
}
