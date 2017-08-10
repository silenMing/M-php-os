<?php

/**
* 
*/
class base_events_service {


    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [];

    public function setListens($eventName)
    {
        if( $eventName )
        {
            $listen = config::get('events.listen');
            $this->listen[$eventName] = $listen[$eventName];
        }

        return $this;
    }

	
}