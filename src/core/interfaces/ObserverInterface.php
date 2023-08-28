<?php

namespace App\Core\Interfaces;

/**
 * Observer Interface
 *
 * An interface defining the contract for observer classes.
 */
interface ObserverInterface
{
    /**
     * Update method to handle the event data.
     *
     * @param mixed $eventData Data related to the observed event.
     * @return void
     */
    public function update($eventData): void;
}