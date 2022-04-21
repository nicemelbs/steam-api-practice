<?php

namespace app\models;

class SteamFriend extends SteamUser
{
    public string $steamid;
    public string $relationship;
    public int $friend_since;

    public function getSteamid()
    {
        return $this->steamid;
    }

    public function getRelationship()
    {
        return $this->relationship;
    }

    public function getFriendSince()
    {
        return $this->friend_since;
    }

    public function getSteamUser(): ?SteamUser
    {
        return SteamUser::findBySteamId( $this->steamid);
    }
}