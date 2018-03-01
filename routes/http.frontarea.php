<?php

declare(strict_types=1);

Route::domain(domain())->group(function () {
    Route::name('frontarea.')
        ->middleware(['web', 'nohttpcache'])
        ->namespace('Cortex\Auth\B2B2C2\Http\Controllers\Frontarea')
        ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.frontarea') : config('cortex.foundation.route.prefix.frontarea'))->group(function () {

        // Login Routes
            Route::get('login')->name('login')->uses('AuthenticationController@form');
            Route::post('login')->name('login.process')->uses('AuthenticationController@login');
            Route::post('logout')->name('logout')->uses('AuthenticationController@logout');

            // Registration Routes
            Route::get('register')->name('register')->uses('MemberRegistrationController@form');
            Route::post('register')->name('register.process')->uses('MemberRegistrationController@register');
            Route::get('register-tenant')->name('register.tenant')->uses('TenantRegistrationController@form');
            Route::post('register-tenant')->name('register.tenant.process')->uses('TenantRegistrationController@register');

            // Reauthentication Routes
            Route::name('reauthentication.')->prefix('reauthentication')->group(function () {
                // Reauthentication Password Routes
                Route::post('password')->name('password.process')->uses('ReauthenticationController@processPassword');

                // Reauthentication Twofactor Routes
                Route::post('twofactor')->name('twofactor.process')->uses('ReauthenticationController@processTwofactor');
            });

            // Password Reset Routes
            Route::name('passwordreset.')->prefix('passwordreset')->group(function () {
                Route::get('request')->name('request')->uses('PasswordResetController@request');
                Route::post('send')->name('send')->uses('PasswordResetController@send');
                Route::get('reset')->name('reset')->uses('PasswordResetController@reset');
                Route::post('process')->name('process')->uses('PasswordResetController@process');
            });

            // Verification Routes
            Route::name('verification.')->prefix('verification')->group(function () {
                // Phone Verification Routes
                Route::name('phone.')->prefix('phone')->group(function () {
                    Route::get('request')->name('request')->uses('PhoneVerificationController@request');
                    Route::post('send')->name('send')->uses('PhoneVerificationController@send');
                    Route::get('verify')->name('verify')->uses('PhoneVerificationController@verify');
                    Route::post('process')->name('process')->uses('PhoneVerificationController@process');
                });

                // Email Verification Routes
                Route::name('email.')->prefix('email')->group(function () {
                    Route::get('request')->name('request')->uses('EmailVerificationController@request');
                    Route::post('send')->name('send')->uses('EmailVerificationController@send');
                    Route::get('verify')->name('verify')->uses('EmailVerificationController@verify');
                });
            });

            // Account Settings Route Alias
            Route::get('account')->name('account')->uses('AccountSettingsController@index');

            // User Account Routes
            Route::name('account.')->prefix('account')->group(function () {
                // Account Settings Routes
                Route::get('settings')->name('settings')->uses('AccountSettingsController@edit');
                Route::post('settings')->name('settings.update')->uses('AccountSettingsController@update');

                // Account Password Routes
                Route::get('password')->name('password')->uses('AccountPasswordController@edit');
                Route::post('password')->name('password.update')->uses('AccountPasswordController@update');

                // Account Attributes Routes
                Route::get('attributes')->name('attributes')->uses('AccountAttributesController@edit');
                Route::post('attributes')->name('attributes.update')->uses('AccountAttributesController@update');

                // Account Sessions Routes
                Route::get('sessions')->name('sessions')->uses('AccountSessionsController@index');
                Route::delete('sessions')->name('sessions.flush')->uses('AccountSessionsController@flush');
                Route::delete('sessions/{session?}')->name('sessions.destroy')->uses('AccountSessionsController@destroy');

                // Account TwoFactor Routes
                Route::name('twofactor.')->prefix('twofactor')->group(function () {
                    Route::get('/')->name('index')->uses('AccountTwoFactorController@index');

                    // Account TwoFactor TOTP Routes
                    Route::name('totp.')->prefix('totp')->group(function () {
                        Route::get('enable')->name('enable')->uses('AccountTwoFactorController@enableTotp');
                        Route::post('update')->name('update')->uses('AccountTwoFactorController@updateTotp');
                        Route::post('disable')->name('disable')->uses('AccountTwoFactorController@disableTotp');
                        Route::post('backup')->name('backup')->uses('AccountTwoFactorController@backupTotp');
                    });

                    // Account TwoFactor Phone Routes
                    Route::name('phone.')->prefix('phone')->group(function () {
                        Route::post('enable')->name('enable')->uses('AccountTwoFactorController@enablePhone');
                        Route::post('disable')->name('disable')->uses('AccountTwoFactorController@disablePhone');
                    });
                });
            });

            // Social Authentication Routes
            Route::redirect('auth', 'login');
            Route::get('auth/{provider}')->name('auth.social')->uses('SocialAuthenticationController@redirectToProvider');
            Route::get('auth/{provider}/callback')->name('auth.social.callback')->uses('SocialAuthenticationController@handleProviderCallback');
        });
});
