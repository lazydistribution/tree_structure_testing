<?php


class UserModel extends Model
{

    public function all() {
        $users = [
            1 => [
                'id' => 1,
                'email' => 'mikko.mallikas@gmail.com',
                'password' => '123',
                'displayname' => 'Mikko Mallikas',
            ],
            2 => [
                'id' => 2,
                'email' => 'essi.esimerkki@hotmail.com',
                'password' => '123',
                'displayname' => 'Essi Esimerkki',
            ],
        ];
        return $users;
    }
}