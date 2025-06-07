<?php

namespace App\Models;

enum Role: string {
    case Parent = 'parent';
    case Child = 'child';
    case Guest = 'guest';
    case Guardian = 'guardian';
}
