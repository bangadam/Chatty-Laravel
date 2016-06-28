<?php

namespace Chatty\Models;

use Chatty\Models\Status;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{

    use Authenticatable;

    protected $table = 'users';

    protected $fillable = [
      'email',
      'username',
      'password',
      'first_name',
      'last_name',
      'location',
    ];

    protected $hidden = [
      'password',
      'remember_token',
    ];

    public function getName()
    {
      if ($this->first_name && $this->last_name) {
        return "{$this->first_name} {$this->last_name}";
      }

      if ($this->first_name) {
        return $this->first_name;
      }

      return null;
    }

    public function getNameOrUsername()
    {
      return $this->getName() ?: $this->username;
    }

    public function getFirstNameOrUsername()
    {
      return $this->first_name ?: $this->username;
    }

    public function getGravatarUrl()
    {
      return "https://www.gravatar.com/avatar/{{ md5($this->email) }}?d=mm&s=40";
    }

    public function statuses(){
      return $this->hasMany('Chatty\Models\Status', 'user_id');
    }

    public function FriendOfMine()
    {
      return $this->belongsToMany('Chatty\Models\User', 'friends', 'user_id', 'friend_id');
    }

    public function FriendOf()
    {
      return $this->belongsToMany('Chatty\Models\User', 'friends', 'friend_id', 'user_id');
    }

    public function friends()
    {
      return $this->FriendOfMine()->wherePivot('accepted', true)->get()
      ->merge($this->FriendOf()->wherePivot('accepted', true)->get());
    }

    public function FriendsRequest()
    {
      return $this->FriendOfMine()->wherePivot('accepted', false)->get();
    }

    public function FriendsRequestPending()
    {
      return $this->FriendOf()->wherePivot('accepted', false)->get();
    }

    public function hasFriendsRequestPending(User $user)
    {
      return (bool) $this->FriendsRequestPending()->where('id', $user->id)->count();
    }

    public function hasFriendsRequestRecevied(User $user)
    {
      return (bool) $this->FriendsRequest()->where('id', $user->id)->count();
    }

    public function AddFriends(User $user)
    {
      $this->FriendOf()->attach($user->id);
    }

    public function deleteFriend(User $user){
      $this->FriendOf()->detach($user->id);
      $this->FriendOfMine()->detach($user->id);
    }

    public function AcceptFriendsRequest(User $user)
    {
      $this->FriendsRequest()->where('id', $user->id)->first()->pivot
            ->update([
            'accepted' => true,
      ]);
    }

    public function isFriendsWith(User $user)
    {
      return (bool) $this->friends()->where('id', $user->id)->count();
    }

    public function likes(){
      return $this->hasMany('Chatty\Models\Like', 'user_id');
    }

    public function hasLikedStatus(Status $status){
      return (bool) $status->likes->where('user_id', $this->id)->count();
    }
}
