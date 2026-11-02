<?php

return [
    [
        'name' => 'Instagram Feed',
        'flag' => 'instagram-feed.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'instagram-feed.create',
        'parent_flag' => 'instagram-feed.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'instagram-feed.edit',
        'parent_flag' => 'instagram-feed.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'instagram-feed.destroy',
        'parent_flag' => 'instagram-feed.index',
    ],
    [
        'name' => 'Settings',
        'flag' => 'instagram-feed.settings',
        'parent_flag' => 'instagram-feed.index',
    ],
];
