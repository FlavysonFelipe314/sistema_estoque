<?php

namespace App\interfaces;

use App\Models\User;

interface UserInterface {
    public function create(User $user);
    public function update(User $user);
    public function findBy($query, $value);
    public function delete($id);
}
