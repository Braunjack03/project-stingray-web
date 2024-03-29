<?php

use App\Models\User;
use Spark\Features;

return [

    /*
    |--------------------------------------------------------------------------
    | Spark Path
    |--------------------------------------------------------------------------
    |
    | This configuration option determines the URI at which the Spark billing
    | portal is available. You are free to change this URI to a value that
    | you prefer. You shall link to this location from your application.
    |
    */

    'path' => 'billing',

    /*
    |--------------------------------------------------------------------------
    | Spark Middleware
    |--------------------------------------------------------------------------
    |
    | These are the middleware that requests to the Spark billing portal must
    | pass through before being accepted. Typically, the default list that
    | is defined below should be suitable for most Laravel applications.
    |
    */

    'middleware' => ['web', 'auth'],

    /*
    |--------------------------------------------------------------------------
    | Branding
    |--------------------------------------------------------------------------
    |
    | These configuration values allow you to customize the branding of the
    | billing portal, including the primary color and the logo that will
    | be displayed within the billing portal. This logo value must be
    | the absolute path to an SVG logo within the local filesystem.
    |
    */

    //'brand' =>  [
    //     'logo' => realpath(__DIR__.'/../public/images/made_in_tampa_logo.svg'),
    //     'color' => 'bg-gray-800',
    //],

    /*
    |--------------------------------------------------------------------------
    | Proration Behavior
    |--------------------------------------------------------------------------
    |
    | This value determines if charges are prorated when making adjustments
    | to a plan such as incrementing or decrementing the quantity of the
    | plan. This also determines proration behavior if changing plans.
    |
    */

    'prorates' => true,

    /*
    Link to the terms and conditions page
    */
    'terms_url' => '/terms',


    'features' => [
        // Features::billingAddressCollection(),
        // Features::mustAcceptTerms(),
        // Features::euVatCollection(['home-country' => 'BE']),
        Features::receiptEmails(['custom-addresses' => true]),
        Features::paymentNotificationEmails(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Spark Billables
    |--------------------------------------------------------------------------
    |
    | Below you may define billable entities supported by your Spark driven
    | application. You are free to have multiple billable entities which
    | can each define multiple subscription plans available for users.
    |
    | In addition to defining your billable entity, you may also define its
    | plans and the plan's features, including a short description of it
    | as well as a "bullet point" listing of its distinctive features.
    |
    */

    'billables' => [

        'user' => [
            'model' => User::class,

            'trial_days' => 0,

            'default_interval' => 'monthly',

            'plans' => [


                [
                    'name' => 'Seed Plan',
                    'short_description' => 'Ideal for starting small',
                    'monthly_id' => env('SEED_MTH'),
                    'yearly_id' => env('SEED_YR'),
                    'features' => [
                        '2 Job Slots',
                        'Create a free company profile',
                    ],
                    'archived' => false,
                ],



                [
                    'name' => 'Start-up Plan',
                    'short_description' => 'Accelerated hiring for companies of any size',
                    'monthly_id' => env('STARTUP_MTH'),
                    'yearly_id' => env('STARTUP_YR'),
                    'features' => [
                        '5 Job Slots',
                        'Create a free company profile',
                        'Company Spotlight Article (annual plan)'
                    ],
                    'archived' => false,
                ],

                [
                    'name' => 'Growth Plan',
                    'short_description' => 'Perfect for fast growing companies',
                    'monthly_id' => env('GROWTH_MTH'),
                    'yearly_id' => env('GROWTH_YR'),
                    'features' => [
                        '10 Job Slots',
                        'Create a free company profile',
                        'Company Spotlight Article (annual plan)',
                        'Custom Editoral Content (annual plan)'
                    ],
                    'archived' => false,
                ],


            ],

        ],

    ]
];
