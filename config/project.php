<?php

return [
    'api' => [
        'url' => env('API_URL', 'https://www.ehsan.org.sa/api/v1/orders/fetchOrdersQuerys'),
        'project_url' => env('API_PROJECTURL', 'https://www.ehsan.org.sa/api/v1/orders/fetchProjectsItems'),
        'secret_key' => env('SECRET_KEY', 'ED4SFhUVFUcWGBgdGxocGh5QHh0gHyIhJCMmJSgnKiksKy4t')
    ],
    'VIEW' => '262395553',
    'SERVICE_ACCOUNT' => 'amazing-office-236814-1a8e26d18384.json',
    'DOMAIN' => 'https://give.qb.org.sa',
    'whatsapp' => [
        'base_url' => env('WHATSAPP_URL', 'https://api.ultramsg.com/instance17697/messages/chat'),
        'instance_id' =>  env('WHATSAPP_INSTATNCE_ID', 'instance17697'),
        'api_send_text' => 'messages/chat',
        'token' => env('WHATSAPP_TOKEN', 'klzmj5y2hftzk2m0'),
        'templateToken' => env('TEMPLATE_WHATSAPP_TOKEN', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MTcxNiwic3BhY2VJZCI6MTM4Mzg5LCJvcmdJZCI6NjIxMTAsInR5cGUiOiJhcGkiLCJpYXQiOjE2ODE2Mjk4OTN9.HD18UVrz9seWYC-SBPb2RcJ23j6YHnKkAjTvEw9YHPg'),
    ],
];
