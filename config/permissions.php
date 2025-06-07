<?php

$entities = ['users', 'grades', 'wishes', 'chores', 'rewards', 'transactions'];
$actions  = ['view', 'create', 'edit', 'delete', 'manage'];
$roles    = ['parent', 'child', 'guest', 'guardian'];
$permissions = [];

foreach ($roles as $role) {
    foreach ($entities as $entity) {
        foreach ($actions as $action) {
            // Guests have no permissions
            if ($role === 'guest') {
                continue;
            }
            $permission = "$action $entity";
            // Parents have all the privileges
            if ($role === 'parent') {
                $permissions[$role][] = $permission;
            // Guardians can only view and update wishes
            } elseif ($role === 'guardian') {
                if ($entity === 'wishes' && in_array($action, ['view', 'edit'])) {
                    $permissions[$role][] = $permission;
                }
            // Children can view grades, chores and rewards
            // They can also create, edit and delete wishes
            } elseif ($role === 'child') {
                if (in_array($entity, ['grades', 'rewards', 'chores']) && $action === 'view') {
                    $permissions[$role][] = $permission;
                } elseif ($entity === 'wishes' && in_array($action, ['create', 'edit', 'delete'])) {
                    $permissions[$role][] = $permission;
                }
            }
        }
    }
}

return $permissions;

// Example of how the permissions array might look like
//return [
//    'parent' => [
//        'view users',
//        'create users',
//        'edit users',
//        'delete users',
//        'manage users',
//        'view grades',
//        'create grades',
//        'edit grades',
//        'delete grades',
//        'manage grades',
//        'view wishes', 'create wishes', 'edit wishes', 'delete wishes', 'manage wishes', 'fulfill wishes',
//        'view chores', 'create chores', 'edit chores', 'delete chores', 'manage chores', 'approve chores',
//        'view rewards', 'create rewards', 'edit rewards', 'delete rewards', 'manage rewards', 'approve rewards',
//        'view transactions', 'manage transactions',
//    ],
//    'child' => [
//        //'view users',
//        'view grades',
//        'view wishes', 'create wishes',
//        'view chores', 'claim chores',
//        'view rewards', 'claim rewards',
//        'view transactions',
//    ],
//    'guardian' => [
//        'view wishes', 'fulfill wishes',
//    ],
//    'guest' => [
//        // No permissions
//    ],
//];
