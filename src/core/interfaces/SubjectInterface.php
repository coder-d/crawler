<?php

namespace App\Core\Interfaces;

/**
 * Subject Interface
 *
 * An interface defining the contract for subject classes that support observer management.
 */
interface SubjectInterface
{
    /**
     * Add an observer.
     *
     * @param ObserverInterface $observer The observer instance.
     * @return void
     */
    public function addObserver(ObserverInterface $observer): void;

    /**
     * Remove an observer.
     *
     * @param ObserverInterface $observer The observer instance.
     * @return void
     */
    public function removeObserver(ObserverInterface $observer): void;

    /**
     * Notify all registered observers.
     *
     * @param mixed $eventData Data related to the event.
     * @return void
     */
    public function notifyObservers($eventData): void;
}