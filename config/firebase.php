<?php

declare(strict_types=1);

return [
    /*
     * ------------------------------------------------------------------------
     * Default Firebase project
     * ------------------------------------------------------------------------
     */

    'default' => env('FCM_SERVER_KEY', 'shwepaukkan-73aab'),

    /*
     * ------------------------------------------------------------------------
     * Firebase project configurations
     * ------------------------------------------------------------------------
     */

    'projects' => [
        'shwepaukkan-73aab' => [

            /*
             * ------------------------------------------------------------------------
             * Credentials / Service Account
             * ------------------------------------------------------------------------
             *
             * In order to access a Firebase project and its related services using a
             * server SDK, requests must be authenticated. For server-to-server
             * communication this is done with a Service Account.
             *
             * If you don't already have generated a Service Account, you can do so by
             * following the instructions from the official documentation pages at
             *
             * https://firebase.google.com/docs/admin/setup#initialize_the_sdk
             *
             * Once you have downloaded the Service Account JSON file, you can use it
             * to configure the package.
             *
             * If you don't provide credentials, the Firebase Admin SDK will try to
             * auto-discover them
             *
             * - by checking the environment variable FIREBASE_CREDENTIALS
             * - by checking the environment variable GOOGLE_APPLICATION_CREDENTIALS
             * - by trying to find Google's well known file
             * - by checking if the application is running on GCE/GCP
             *
             * If no credentials file can be found, an exception will be thrown the
             * first time you try to access a component of the Firebase Admin SDK.
             *
             */

            // 'credentials' => env('FIREBASE_CREDENTIALS', env('GOOGLE_APPLICATION_CREDENTIALS')),

            'credentials' => [
                'type' => 'service_account',
                'project_id' => 'shwepaukkan-73aab',
                'private_key_id' => 'c5d658eae4866d2d3cf6ababbf41555a48ebe398',
                'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCJYVTZ6quGxgaM\n7MXsk0WfwtNaSwZ64HNfil33tqGntbibste038FTZzfNNKIiUAyx7nCDbKydcXtU\nMafHQvd+vXuxLGDLKTelFgGrhL+kiOxv6oHyNCsZoGk4Vf0o+6euLlTvohz3ibDC\nDl45Y//YaWTclpKE4a1k/YMR/A4eLqcNoTmX2bFH7F2wNcJiBbZ/9Ya1qWU9gA0r\nreJ9UrTMzZaWDIGnlm29dIv+mvsjx7OFCkTMB17mp+yCnN2b+7rqFQN/q0/WFWIY\n8HLveJ0MwQjrWPnpiOQWV7p75CWV9NGdMDlKLC2V+nHC0Y8bHX8A4u0eG2GC1U+g\n8Jaz+OxvAgMBAAECggEAPmgbjn6e+rM8SIpKguSHzUJIlozcXbdWUcFeXGf3WWMg\ngIImoQDAJq4N2Ecfm+y3R6DkNZ+JbmAdwSppaAhQu59B8EMTmVaY84JisdK05/5X\nQaPK8gamyZZoFfJh9VsUWfisFsuS0xQWWqECRpnZoCqIafhwiLKn/Od4whO5KhYm\n2jF4F/Axt9tsQiZy6oZ44xdP6Acww3+f2xHW/vmVjf/gv8phJ54mhlz10ZPOcPXY\nf9VA09ihUfUmMgdDArvUMOuSptf5B2Evjbwuuez2A3tZewowlVsBmuAkIfrphW7t\np+uU6ogjGK+Eju5vNzJp7D+zT0i8lctaZ03o9aFZwQKBgQC/wQ3r0hCZ4RhyL/E8\nWzq/r+oje3XVVuDqlvBIsKt0ieRuM6CKO5cSTmof24wiXzs0jJ+N/4Jfrf7epUh4\nygyGh7fUeY88VdZ/TcDeIUb9o9sEK0oNJA4NIVB1o2t15tQf899gg1d0WO90vYak\nrFJnUrVEQTKwjlan229a1tZKzwKBgQC3aJImKYf3O4N5vYVKWZJhG7sdwNoVP2/j\nqAfemfUXzFX4p4fT361FKHKUh8FTrMUq+EOieFcaUfr1Qun7MLjk5/WsRd2dRUoM\nRpvzPQmLHMTIqnXkaJR/1Vfmw2C1QNVbjXYxivtNQQt1jqTismbRoKEumCJL/6GF\nwcUp2CUsYQKBgA2ceox+wMbrf3y7gngyUZ1Bs3EJVnfqTtTYGf5O7By9nQVljMPD\nLxoRjt7sCqp18BHu2XSO6oY4J5tOSDKqxPDXuWjPqCc0QKGQt1wNKKjgdK97EyqT\noJu1/awcCYi49d2+xeBn8lFD7ttuiJwvzzmeWVea+SonMGeB4AmmrldpAoGBAJCO\nZRKbDUU5rQiY7aOKMatENhjfVYQFueSPHZS/d8PIE8KmGJJP67tkg9q5nRCcTdLu\nVjCJ9O0TzF7e3JhU8IXKpYGgl2lLoW9Hf8cZRppUlG0snTrnipOuzVdeiqyRaxh7\nyLqHtkZPi/6d7SuYPR3gIuocknugAejwrruqVrJBAoGBALibTTsynWFAzCTrt76h\nEk2eXiG6xb4Wi7wlsAWfh5lyrATh85p6xer+AIVOCikcAmRglD6hbwZASuquy8qh\ntQlVpbphKr2+fX2EURsweyyRGWzVSEkTR3BqE3GQUOtTX+DRN1FLe2DgOz6kuyAJ\n348NSapscySauoBDY0o6VgpK\n-----END PRIVATE KEY-----\n",
                'client_email' => 'firebase-adminsdk-44lvd@shwepaukkan-73aab.iam.gserviceaccount.com',
                'client_id' => '111659591569955978897',
                'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
                'token_uri' => 'https://oauth2.googleapis.com/token',
                'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
                'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-44lvd%40shwepaukkan-73aab.iam.gserviceaccount.com',
                'universe_domain' => 'googleapis.com',
            ],
            
            // 'credentials' => [
            //     'type' => 'service_account',
            //     'project_id' => 'shwesankan-f6f4d',
            //     'private_key_id' => '5194ceae343f462d5722b185ce46ee6bae33443a',
            //     'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCrHh7XdTYmK/iV\nhWRaATs3IFiESP1/wQH46MJ7f3pAt7hiX4DEHIKRYUpJyykfjMbz5pwuPLkaLgq4\npaPsrs83A6xC1DjLAYj+NHfPoq+OoFiChXLWS6qUGXmLeSGGBKtMDv8xGDUHTQRC\n9YB6p/VIgShn9+FRIbwib5URR0phDtH3YhZyteyQR+o6d7mFVX34kTgh/YErSG2O\nXH6090wa7JnI8bbeWnlxtDinooRnGCsycc9rxnMFOWuTEv3Fah3qxHCbLazCAxgZ\n4nA7htfaeMBMs861fxXAipOLpULNQaknUOSIWHtwcPCw73namL4e+hPtFJjAx+Zr\n2lfyWQ+hAgMBAAECggEAA+3iwaoLeqQpFr7bw2zSkCUeHziBWKsFCXMHzzfpxd1q\nHpkojuhEL8QrBWeEu9ia02ws0yt6CSG8RYnpKhTIBZCAJr8yiCfSflrUUvhefWEN\ncz7O+KB/a9vrZHJdPJN0HwCbp8QRaKfiNIroXrinW1k65StGGVuz0xsakk1fpfuc\nTxOPzEK8ETLrcVdwTUqwbp4Byh+DncdgBDRxjFrVdJ7VcC4F44n0U/KPSpJ01SyI\nnM/cbZdFC6yQOXdPrAY13H8s+0yAFIwsfTY8mY24rcOQD1PV1Y+hQlZACQyabdvp\nbhW0ZUBLXDwmzmVb5XomIl4tF/2XBFoBLdm+Rv/jaQKBgQDwCVg4KYgsiUqWBPHN\n6uGDuE1/uKBHkh6s7IzF+M6zwgI3pkKtTapM6QmoipjeqZWx1Lwrl8NiWWoi/MB4\n0XxtTG/M2Lo4mV4Nqlf0JfUPdgKTRvj0GLAwXeR8eRZVAOX5df3khDYrnpe1LIM+\nbjdkWai5L7DmRYtSEHn5CjRdmQKBgQC2f2w8mgUO8zzB3eRk5dYS6G6woMUEeROs\nKYw6eycTOESuuhd0TRLHDm/17OVYJW3tN/Lh8vtHzC00IEHeA57GzenlnoR8Vlyx\nkhl0cYvf0/5yG3VgoyaprlkM4OdvLR28qhe9cgQ5qEvW819nEG0Rz008WJu6JX7g\nS3voS9K3SQKBgQCBycu1sl87FZEKxOmqGdKOUl01LjMb/9ouTklf0kSR1dk1FeT/\np/rpUygxxZ8a5j9WxFxqhcjTqN1GxbucmEjbIHVjIdyvNd4xLWYZUVzMW1bRI5MB\nCUhbHqmo1CBLHg07cZ0yrnpL45jMEaF1ZEr3K7ObTjosiHXojZgmHGpsIQKBgDel\nTMyBrg8r7ZezX+PADPFA/BdRPiGqBWyWUpK2YGjE3HRme6ZTpekaJttWu2uQJh+R\n0rZAj4wJ3rKpL0xR0EUQHkSMfBspfiQKx0YxJRQ/oLMMWlL4DF7qsW5y2T6WBB41\nwv1Z2Z33CgDlvm4/nPI0QnmnDvzIWBJuEb739605AoGBANIhcW9+LY9aM671x+Nf\nNVtuFjGDssd9BhVTMYPEtLdLoDrcHveRg+S1r1IDyYRflL3dZHEocTJ+xOdwCVHz\n/iNyjRMIAI2IHuno5BYFmAD0tOTCycPm4PM1Jl+vaw2SSKYXlbuqXkju3fdtdqht\nL3ZyLTOLQ/8RV5XAQfV8pmSb\n-----END PRIVATE KEY-----\n",
            //     'client_email' => 'firebase-adminsdk-xcsxd@shwesankan-f6f4d.iam.gserviceaccount.com',
            //     'client_id' => '111272075060100956110',
            //     'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
            //     'token_uri' => 'https://oauth2.googleapis.com/token',
            //     'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
            //     'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-xcsxd%40shwesankan-f6f4d.iam.gserviceaccount.com',
            //     'universe_domain' => 'googleapis.com',
            // ],
            /*
             * ------------------------------------------------------------------------
             * Firebase Auth Component
             * ------------------------------------------------------------------------
             */

            'auth' => [
                'tenant_id' => env('FIREBASE_AUTH_TENANT_ID'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firestore Component
             * ------------------------------------------------------------------------
             */

            'firestore' => [

                /*
                 * If you want to access a Firestore database other than the default database,
                 * enter its name here.
                 *
                 * By default, the Firestore client will connect to the `(default)` database.
                 *
                 * https://firebase.google.com/docs/firestore/manage-databases
                 */

                // 'database' => env('FIREBASE_FIRESTORE_DATABASE'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firebase Realtime Database
             * ------------------------------------------------------------------------
             */

            'database' => [

                /*
                 * In most of the cases the project ID defined in the credentials file
                 * determines the URL of your project's Realtime Database. If the
                 * connection to the Realtime Database fails, you can override
                 * its URL with the value you see at
                 *
                 * https://console.firebase.google.com/u/1/project/_/database
                 *
                 * Please make sure that you use a full URL like, for example,
                 * https://my-project-id.firebaseio.com
                 */

                'url' => env('FIREBASE_DATABASE_URL'),

                /*
                 * As a best practice, a service should have access to only the resources it needs.
                 * To get more fine-grained control over the resources a Firebase app instance can access,
                 * use a unique identifier in your Security Rules to represent your service.
                 *
                 * https://firebase.google.com/docs/database/admin/start#authenticate-with-limited-privileges
                 */

                // 'auth_variable_override' => [
                //     'uid' => 'my-service-worker'
                // ],

            ],

            'dynamic_links' => [

                /*
                 * Dynamic links can be built with any URL prefix registered on
                 *
                 * https://console.firebase.google.com/u/1/project/_/durablelinks/links/
                 *
                 * You can define one of those domains as the default for new Dynamic
                 * Links created within your project.
                 *
                 * The value must be a valid domain, for example,
                 * https://example.page.link
                 */

                'default_domain' => env('FIREBASE_DYNAMIC_LINKS_DEFAULT_DOMAIN'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firebase Cloud Storage
             * ------------------------------------------------------------------------
             */

            'storage' => [

                /*
                 * Your project's default storage bucket usually uses the project ID
                 * as its name. If you have multiple storage buckets and want to
                 * use another one as the default for your application, you can
                 * override it here.
                 */

                'default_bucket' => env('FIREBASE_STORAGE_DEFAULT_BUCKET'),

            ],

            /*
             * ------------------------------------------------------------------------
             * Caching
             * ------------------------------------------------------------------------
             *
             * The Firebase Admin SDK can cache some data returned from the Firebase
             * API, for example Google's public keys used to verify ID tokens.
             *
             */

            'cache_store' => env('FIREBASE_CACHE_STORE', 'file'),

            /*
             * ------------------------------------------------------------------------
             * Logging
             * ------------------------------------------------------------------------
             *
             * Enable logging of HTTP interaction for insights and/or debugging.
             *
             * Log channels are defined in config/logging.php
             *
             * Successful HTTP messages are logged with the log level 'info'.
             * Failed HTTP messages are logged with the log level 'notice'.
             *
             * Note: Using the same channel for simple and debug logs will result in
             * two entries per request and response.
             */

            'logging' => [
                'http_log_channel' => env('FIREBASE_HTTP_LOG_CHANNEL'),
                'http_debug_log_channel' => env('FIREBASE_HTTP_DEBUG_LOG_CHANNEL'),
            ],

            /*
             * ------------------------------------------------------------------------
             * HTTP Client Options
             * ------------------------------------------------------------------------
             *
             * Behavior of the HTTP Client performing the API requests
             */

            'http_client_options' => [

                /*
                 * Use a proxy that all API requests should be passed through.
                 * (default: none)
                 */

                'proxy' => env('FIREBASE_HTTP_CLIENT_PROXY'),

                /*
                 * Set the maximum amount of seconds (float) that can pass before
                 * a request is considered timed out
                 *
                 * The default time out can be reviewed at
                 * https://github.com/kreait/firebase-php/blob/6.x/src/Firebase/Http/HttpClientOptions.php
                 */

                'timeout' => env('FIREBASE_HTTP_CLIENT_TIMEOUT'),

                'guzzle_middlewares' => [],
            ],
        ],
    ],
];
