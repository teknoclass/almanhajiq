<?php

namespace App\Strategies;

interface ItemStrategy
{
    public function isCompleted(): bool;
    public function renderModal(array $data): string;
    public function getModelClass(): string;
    public function applyCompletedScope($query);
}
