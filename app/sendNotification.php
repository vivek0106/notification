<?php
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
$webPush = new WebPush();
$endpoint = 'https://fcm.googleapis.com/fcm/send/fd5Zapv8SmQ:APA91bE_hdd8dTFvTjwm4M8hp1uYcVvwQ9P4K-C5Xlyb8p5n_IpuAc31uuiZwR3aD824rj93cD7uh9BVsKJEoekO0SGcYuzYSKUACg7VaGtdkNZ84Bhj8ZGj3BCb--gd6PXejbkCSSbX'; // Chrome
$notification = [
    [
        'subscription' => Subscription::create([
            'endpoint' => $endpoint            
        ]),
        'payload' => 'hello !',
        ]
    ];

    // $notifications = [
    //     [
    //         'subscription' => Subscription::create([
    //             'endpoint' => 'https://updates.push.services.mozilla.com/push/abc...', // Firefox 43+,
    //             'publicKey' => 'BPcMbnWQL5GOYX/5LKZXT6sLmHiMsJSiEvIFvfcDvX7IZ9qqtq68onpTPEYmyxSQNiH7UD/98AUcQ12kBoxz/0s=', // base 64 encoded, should be 88 chars
    //             'authToken' => 'CxVX6QsVToEGEcjfYPqXQw==', // base 64 encoded, should be 24 chars
    //         ]),
    //         'payload' => 'hello !',
    //     ], [
    //         'subscription' => Subscription::create([
    //             'endpoint' => 'https://fcm.googleapis.com/fcm/send/abcdef...', // Chrome
    //         ]),
    //         'payload' => null,
    //     ], [
    //         'subscription' => Subscription::create([
    //             'endpoint' => 'https://example.com/other/endpoint/of/another/vendor/abcdef...',
    //             'publicKey' => '(stringOf88Chars)',
    //             'authToken' => '(stringOf24Chars)',
    //             'contentEncoding' => 'aesgcm', // one of PushManager.supportedContentEncodings
    //         ]),
    //         'payload' => '{msg:"test"}',
    //     ], [
    //           'subscription' => Subscription::create([ // this is the structure for the working draft from october 2018 (https://www.w3.org/TR/2018/WD-push-api-20181026/) 
    //               "endpoint" => "https://example.com/other/endpoint/of/another/vendor/abcdef...",
    //               "keys" => [
    //                   'p256dh' => '(stringOf88Chars)',
    //                   'auth' => '(stringOf24Chars)'
    //               ],
    //           ]),
    //           'payload' => '{"msg":"Hello World!"}',
    //       ],
    // ];
$auth = [
    'VAPID' => [
        'subject' => 'mailto:kingvivek0106@gmail.com', // can be a mailto: or your website address
        'publicKey' => 'BNCiEjsunQR9Iv2a6BuiOrZDCe-13OfWD9z4pJyaslATyQKff3DD5QrieVc6G3xyf-Xw0MVP8ev47SBRgzllsAs', // (recommended) uncompressed public key P-256 encoded in Base64-URL
        'privateKey' => '4ITOoEOOZbqUrDnhW7PURNuH1lsFRh8GjZsAicHSy1Y', // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
    ],
];
$webPush = new WebPush();
foreach ($notifications as $notification) {
    $webPush->queueNotification(
        $notification['subscription'],
        $notification['payload'] // optional (defaults null)
    );
}

/**
 * Check sent results
 * @var MessageSentReport $report
 */
foreach ($webPush->flush() as $report) {
    $endpoint = $report->getRequest()->getUri()->__toString();

    if ($report->isSuccess()) {
        echo "[v] Message sent successfully for subscription {$endpoint}.";
    } else {
        echo "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
    }
}

// /**
//  * send one notification and flush directly
//  * @var MessageSentReport $report
//  */
// $report = $webPush->sendOneNotification(
//     $notifications[0]['subscription'],
//     $notifications[0]['payload'] // optional (defaults null)
// );
// $webPush = new WebPush($auth);
// $webPush->queueNotification($notification['subscription'],$notification['payload']);
?>