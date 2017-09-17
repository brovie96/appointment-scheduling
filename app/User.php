<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function events()
    {
      return $this->hasMany('App\Event');
    }

    public function eventsAsArray()
    {
      $ret = [];
      $this->events->chunk(200, function($events)
      {
        foreach($events as $event)
        {
          $add = [
            'title' => $event->title,
            'start' => $event->start_date,
            'end' => $event->end_date,
            'description' => $event->description
          ];
          $ret[] = $add;
        }
      });

      return $ret;
    }
}
